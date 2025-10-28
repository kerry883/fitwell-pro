<?php

namespace App\Http\Controllers;

use App\Models\ProgramAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ClientAssignmentController extends Controller
{
    /**
     * Display client's enrolled programs
     */
    public function index()
    {
        $client = Auth::user()->clientProfile;

        $assignments = ProgramAssignment::with(['program.trainer.user'])
            ->where('client_id', $client->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($assignment) {
                $assignment->can_withdraw = $assignment->isPending() || $assignment->isActive();
                return $assignment;
            });

        return view('client.assignments.index', compact('assignments'));
    }

    /**
     * Show program assignment details
     */
    public function show($id)
    {
        $client = Auth::user()->clientProfile;

        $assignment = ProgramAssignment::with(['program.trainer.user', 'program.workouts'])
            ->where('client_id', $client->id)
            ->findOrFail($id);

        // Calculate progress metrics
        $totalWeeks = $assignment->program->duration_weeks;
        $currentWeek = $assignment->current_week;
        $progressPercentage = $assignment->progress_percentage;

        // Get upcoming workouts
        $upcomingWorkouts = $assignment->program->workouts()
            ->where('week_number', '>=', $currentWeek)
            ->orderBy('week_number')
            ->orderBy('day', 'asc')
            ->take(5)
            ->get();

        return view('client.assignments.show', compact('assignment', 'totalWeeks', 'currentWeek', 'progressPercentage', 'upcomingWorkouts'));
    }

    /**
     * Withdraw from a program assignment
     */
    public function withdraw(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $client = Auth::user()->clientProfile;

        $assignment = ProgramAssignment::with(['program', 'program.trainer.user'])
            ->where('client_id', $client->id)
            ->findOrFail($id);

        // Check if withdrawal is allowed
        if (!$assignment->isPending() && !$assignment->isActive()) {
            return redirect()->back()
                ->with('error', 'Cannot withdraw from this program at this time.');
        }

        DB::transaction(function () use ($assignment, $request, $client) {
            // Update assignment status
            $assignment->update([
                'status' => ProgramAssignment::STATUS_REJECTED,
                'notes' => $request->reason ? 'Client withdrawal: ' . $request->reason : 'Client withdrew from program',
            ]);

            // Decrease program current clients count if it was active
            if ($assignment->isActive()) {
                $assignment->program->decrement('current_clients');
            }

            // Check if client has any remaining active assignments with this trainer
            $remainingAssignmentsWithTrainer = ProgramAssignment::where('client_id', $client->id)
                ->where('id', '!=', $assignment->id) // Exclude the current assignment being withdrawn
                ->whereHas('program', function ($query) use ($assignment) {
                    $query->where('trainer_id', $assignment->program->trainer_id);
                })
                ->whereIn('status', ['active', 'pending'])
                ->count();

            // If no remaining assignments with this trainer, update trainer relationship
            if ($remainingAssignmentsWithTrainer === 0) {
                $newTrainerCount = max(0, $client->trainer_count - 1);
                if ($newTrainerCount === 0) {
                    // No trainers left, clear trainer_id
                    Log::info('Clearing client trainer_id on withdrawal', [
                        'client_id' => $client->id,
                        'trainer_id_before' => $client->trainer_id,
                        'trainer_count_before' => $client->trainer_count,
                        'trainer_count_after' => 0,
                    ]);
                    $client->update([
                        'trainer_id' => null,
                        'trainer_count' => 0,
                    ]);
                } else {
                    // Still have other trainers, decrement count but keep current trainer_id
                    // (could potentially switch to another trainer, but keeping current is simpler)
                    Log::info('Decrementing client trainer_count on withdrawal', [
                        'client_id' => $client->id,
                        'trainer_id' => $client->trainer_id,
                        'trainer_count_before' => $client->trainer_count,
                        'trainer_count_after' => $newTrainerCount,
                    ]);
                    $client->update([
                        'trainer_count' => $newTrainerCount,
                    ]);
                }

                if ($newTrainerCount === 0) {
                    // No trainers left, clear trainer_id
                    Log::info('Clearing client trainer_id on withdrawal', [
                        'client_id' => $client->id,
                        'trainer_id_before' => $client->trainer_id,
                        'trainer_count_before' => $client->trainer_count,
                        'trainer_count_after' => 0,
                    ]);
                    $client->update([
                        'trainer_id' => null,
                        'trainer_count' => 0,
                    ]);
                } else {
                    // Still have other trainers, decrement count but keep current trainer_id
                    // (could potentially switch to another trainer, but keeping current is simpler)
                    Log::info('Decrementing client trainer_count on withdrawal', [
                        'client_id' => $client->id,
                        'trainer_id' => $client->trainer_id,
                        'trainer_count_before' => $client->trainer_count,
                        'trainer_count_after' => $newTrainerCount,
                    ]);
                    $client->update([
                        'trainer_count' => $newTrainerCount,
                    ]);
                }
            }

            // Create notification for trainer
            $notification = \App\Models\Notification::create([
                'user_id' => $assignment->program->trainer->user->id,
                'type' => 'client_withdrawal',
                'title' => 'Client Withdrew from Program',
                'message' => "Client {$client->user->full_name} has withdrawn from your program '{$assignment->program->name}'." .
                           ($request->reason ? " Reason: {$request->reason}" : ""),
                'data' => [
                    'program_id' => $assignment->program->id,
                    'client_id' => $client->id,
                    'assignment_id' => $assignment->id,
                ],
            ]);

            // Broadcast the notification
            broadcast(new \App\Events\NotificationCreated($notification))->toOthers();
        });

        return redirect()->route('client.assignments.index')
            ->with('success', 'You have successfully withdrawn from the program.');
    }

    /**
     * Update progress (for active assignments)
     */
    public function updateProgress(Request $request, $id)
    {
        $request->validate([
            'current_week' => 'required|integer|min:1',
            'current_session' => 'required|integer|min:1',
            'progress_percentage' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $client = Auth::user()->clientProfile;

        $assignment = ProgramAssignment::where('client_id', $client->id)
            ->where('status', ProgramAssignment::STATUS_ACTIVE)
            ->findOrFail($id);

        $oldProgress = $assignment->progress_percentage;

        $assignment->updateProgress(
            $request->current_week,
            $request->current_session,
            $request->progress_percentage
        );

        // Update notes if provided
        if ($request->notes) {
            $assignment->update(['notes' => $request->notes]);
        }

        // Create progress update notification for trainer if significant progress made
        if ($request->progress_percentage > $oldProgress && ($request->progress_percentage - $oldProgress) >= 10) {
            $notification = \App\Models\Notification::create([
                'user_id' => $assignment->program->trainer->user->id,
                'type' => 'program_progress_update',
                'title' => 'Program Progress Update',
                'message' => "Client {$client->user->full_name} has made progress in '{$assignment->program->name}' - now at {$request->progress_percentage}% complete!",
                'data' => [
                    'program_id' => $assignment->program->id,
                    'client_id' => $client->id,
                    'assignment_id' => $assignment->id,
                    'progress_percentage' => $request->progress_percentage,
                    'old_progress' => $oldProgress,
                ],
            ]);

            // Broadcast the notification
            broadcast(new \App\Events\NotificationCreated($notification))->toOthers();
        }

        // Check if program is completed
        if ($request->progress_percentage >= 100) {
            $assignment->markAsCompleted();

            // Create notification for trainer
            $notification = \App\Models\Notification::create([
                'user_id' => $assignment->program->trainer->user->id,
                'type' => 'program_completed',
                'title' => 'Program Completed',
                'message' => "Client {$client->user->full_name} has completed your program '{$assignment->program->name}'!",
                'data' => [
                    'program_id' => $assignment->program->id,
                    'client_id' => $client->id,
                    'assignment_id' => $assignment->id,
                ],
            ]);

            // Broadcast the notification
            broadcast(new \App\Events\NotificationCreated($notification))->toOthers();
        }

        return redirect()->back()
            ->with('success', 'Progress updated successfully!');
    }
}
