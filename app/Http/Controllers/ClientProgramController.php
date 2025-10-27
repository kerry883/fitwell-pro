<?php

namespace App\Http\Controllers;

use App\Enums\ProgramAssignmentStatus;
use App\Models\ClientProfile;
use App\Models\Program;
use App\Models\ProgramAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientProgramController extends Controller
{
    /**
     * Display available programs for clients
     */
    public function index()
    {
        $client = Auth::user()->clientProfile;

        // Get ALL available programs (remove goal filtering to show everything)
        $programs = Program::public()
            ->published()
            ->with('trainer.user')
            ->get();

        // Apply matching algorithm to calculate scores but DON'T sort by match score
        // Keep original order (by creation date) but add match data
        $matchingService = app(\App\Services\ProgramMatchingService::class);
        $programs = $programs->map(function ($program) use ($client, $matchingService) {
            $matchData = $matchingService->calculateMatch($client, $program);
            $program->match_data = $matchData;
            $program->match_score = $matchData['total_score'];
            return $program;
        });

        // Add enrollment status and capabilities
        $programs = $programs->map(function ($program) {
            $program->can_enroll = $program->canEnrollClient();
            $program->is_enrolled = $this->isClientEnrolled($program->id);
            return $program;
        });

        return view('programs.index', compact('programs'));
    }

    /**
     * Show program details
     */
    public function show($id)
    {
        $program = Program::public()
            ->published()
            ->with('trainer.user')
            ->findOrFail($id);

        $client = Auth::user()->clientProfile;

        // Calculate match score for this program
        $matchingService = app(\App\Services\ProgramMatchingService::class);
        $matchData = $matchingService->calculateMatch($client, $program);

        $program->can_enroll = $program->canEnrollClient();
        $program->is_enrolled = $this->isClientEnrolled($program->id);
        $program->match_data = $matchData;

        return view('programs.show', compact('program'));
    }

    /**
     * Enroll client in program
     */
    public function enroll(Request $request, $id)
    {
        $program = Program::public()
            ->published()
            ->findOrFail($id);

        $client = Auth::user()->clientProfile;

        // Check if client is already enrolled
        if ($this->isClientEnrolled($program->id)) {
            return redirect()->back()
                ->with('error', 'You are already enrolled in this program.');
        }

        // Check if program can accept more clients
        if (!$program->canEnrollClient()) {
            return redirect()->back()
                ->with('error', 'This program is currently full or not accepting enrollments.');
        }

        
        DB::transaction(function () use ($program, $client) {
            // Add logging for debugging trainer_id assignment
            Log::info('Enrollment transaction started', [
                'client_id' => $client->id,
                'program_id' => $program->id,
                'program_trainer_id' => $program->trainer_id,
                'program_trainer_user_id' => $program->trainer ? $program->trainer->user_id : null,
                'program_trainer_exists' => $program->trainer ? true : false,
                'program_trainer_user_exists' => $program->trainer && $program->trainer->user ? true : false,
                'current_client_trainer_id' => $client->trainer_id,
                'current_client_trainer_count' => $client->trainer_count,
            ]);

            // Verify trainer exists before proceeding
            if (!$program->trainer || !$program->trainer->user) {
                throw new \Exception('Program trainer not found. Cannot process enrollment.');
            }

            // Find Existing cancelled assignment
            $existingAssignment = ProgramAssignment::where('client_id', $client->id)
                ->where('program_id', $program->id)
                ->where('status', 'cancelled')
                ->first();

            if ($existingAssignment) {
                $existingAssignment->update([
                    'status' => 'pending',
                    'assigned_date' => now(),
                    'current_week' => 1,
                    'current_session' => 0,
                    'notes' => null, //clear withdrawal notes if any is available
                ]);

                // Check if client already has active assignments with this trainer
                $hasExistingTrainerRelationship = ProgramAssignment::where('client_id', $client->id)
                    ->where('program_id', '!=', $program->id)
                    ->whereHas('program', function ($query) use ($program) {
                        $query->where('trainer_id', $program->trainer->id); // Use trainer profile id for comparison
                    })
                    ->whereIn('status', ['active', 'pending'])
                    ->exists();

                // Only update trainer relationship if this is a new trainer for the client
                if (!$hasExistingTrainerRelationship) {
                    Log::info('Updating client trainer_id for re-enrollment', [
                        'client_id' => $client->id,
                        'new_trainer_id' => $program->trainer->user_id, // Use trainer user_id, not trainer profile id
                        'current_trainer_id' => $client->trainer_id,
                        'trainer_count_before' => $client->trainer_count,
                        'trainer_count_after' => $client->trainer_count + 1,
                    ]);
                    $client->update([
                        'trainer_id' => $program->trainer->user_id, // Use trainer user_id, not trainer profile id
                        'trainer_count' => $client->trainer_count + 1,
                    ]);
                }

                return redirect()->back()->with('success', 'Successfully re-enrolled in program!');
            } else {
                // Create program assignment with pending status
                $assignment = ProgramAssignment::create([
                    'client_id' => $client->id,
                    'program_id' => $program->id,
                    'assigned_date' => now(),
                    'status' => ProgramAssignmentStatus::PENDING,
                    'current_week' => 1,
                    'current_session' => 1,
                    'progress_percentage' => 0,
                ]);

                // Check if client already has active assignments with this trainer
                $hasExistingTrainerRelationship = ProgramAssignment::where('client_id', $client->id)
                    ->whereHas('program', function ($query) use ($program) {
                        $query->where('trainer_id', $program->trainer->id); // Use trainer profile id for comparison
                    })
                    ->whereIn('status', ['active', 'pending'])
                    ->exists();

                // Only update trainer relationship if this is a new trainer for the client
                if (!$hasExistingTrainerRelationship) {
                    $client->update([
                        'trainer_id' => $program->trainer->user_id, // Use trainer user_id, not trainer profile id
                        'trainer_count' => $client->trainer_count + 1,
                    ]);
                }

                // Create notification for trainer
                $trainer = $program->trainer->user;
                $notification = \App\Models\Notification::create([
                    'user_id' => $trainer->id,
                    'type' => 'enrollment_request',
                    'title' => 'New Program Enrollment Request',
                    'message' => "Client {$client->user->full_name} has requested to enroll in your program '{$program->name}'.",
                    'data' => [
                        'program_id' => $program->id,
                        'user_id' => $client->user->id,
                        'client_id' => $client->id,
                        'assignment_id' => $assignment->id,
                    ],
                ]);

                // Broadcast the notification
                broadcast(new \App\Events\NotificationCreated($notification))->toOthers();

                return redirect()->back()->with('success', 'Successfully enrolled in program');
            }
        });

        return redirect()->route('client.assignments.index')
            ->with('success', 'Enrollment request sent for ' . $program->name . '. Waiting for trainer approval.');
    }

    /**
     * Check if client is already enrolled in program
     */
    private function isClientEnrolled($programId)
    {
        $client = Auth::user()->clientProfile;
        return ProgramAssignment::where('client_id', $client->id)
            ->where('program_id', $programId)
            ->whereIn('status', ['active', 'pending'])
            ->exists();
    }
}
