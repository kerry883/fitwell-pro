<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientProgramController extends Controller
{
    /**
     * Display available programs for clients
     */
    public function index()
    {
        $client = Auth::user()->clientProfile;
        $clientGoals = $client->goals ?? [];

        $programs = Program::public()
            ->published()
            ->with('trainer.user')
            ->when(!empty($clientGoals), function ($query) use ($clientGoals) {
                // Filter programs that match client's goals
                $query->where(function ($q) use ($clientGoals) {
                    foreach ($clientGoals as $goal) {
                        $q->orWhereJsonContains('goals', $goal);
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($program) {
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

        $program->can_enroll = $program->canEnrollClient();
        $program->is_enrolled = $this->isClientEnrolled($program->id);

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
            // Create program assignment with pending status
            $assignment = ProgramAssignment::create([
                'client_id' => $client->id,
                'program_id' => $program->id,
                'assigned_date' => now(),
                'status' => ProgramAssignment::STATUS_PENDING,
                'current_week' => 1,
                'current_session' => 1,
                'progress_percentage' => 0,
            ]);

            // Create notification for trainer
            $trainer = $program->trainer->user;
            \App\Models\Notification::create([
                'user_id' => $trainer->id,
                'type' => 'enrollment_request',
                'title' => 'New Program Enrollment Request',
                'message' => "Client {$client->user->full_name} has requested to enroll in your program '{$program->name}'.",
                'data' => [
                    'program_id' => $program->id,
                    'client_id' => $client->id,
                    'assignment_id' => $assignment->id,
                ],
            ]);
        });

        return redirect()->route('dashboard')
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
