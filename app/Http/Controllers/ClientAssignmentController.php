<?php

namespace App\Http\Controllers;

use App\Models\ProgramAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            ->where('week', '>=', $currentWeek)
            ->orderBy('week')
            ->orderBy('day')
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

            // Create notification for trainer
            \App\Models\Notification::create([
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

        $assignment->updateProgress(
            $request->current_week,
            $request->current_session,
            $request->progress_percentage
        );

        // Update notes if provided
        if ($request->notes) {
            $assignment->update(['notes' => $request->notes]);
        }

        // Check if program is completed
        if ($request->progress_percentage >= 100) {
            $assignment->markAsCompleted();

            // Create notification for trainer
            \App\Models\Notification::create([
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
        }

        return redirect()->back()
            ->with('success', 'Progress updated successfully!');
    }
}
