<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ProgramAssignment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainerAssignmentController extends Controller
{
    /**
     * Display pending assignments for trainer's programs
     */
    public function index()
    {
        $trainer = Auth::user()->trainerProfile;

        $pendingAssignments = ProgramAssignment::with(['program', 'client.user'])
            ->whereHas('program', function ($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })
            ->pending()
            ->orderBy('assigned_date', 'desc')
            ->get();

        return view('trainer.assignments.index', compact('pendingAssignments'));
    }

    /**
     * Approve a program assignment
     */
    public function approve($id)
    {
        $trainer = Auth::user()->trainerProfile;

        $assignment = ProgramAssignment::with(['program', 'client.user'])
            ->whereHas('program', function ($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })
            ->findOrFail($id);

        if (!$assignment->isPending()) {
            return redirect()->back()
                ->with('error', 'This assignment is not pending approval.');
        }

        DB::transaction(function () use ($assignment) {
            // Update assignment status
            $assignment->update([
                'status' => ProgramAssignment::STATUS_ACTIVE,
                'start_date' => now(),
            ]);

            // Update program current clients count
            $assignment->program->increment('current_clients');

            // Create notification for client
            $notification = Notification::create([
                'user_id' => $assignment->client->user->id,
                'type' => 'program_assignment_approved',
                'title' => 'Program Enrollment Approved',
                'message' => "Your enrollment request for '{$assignment->program->name}' has been approved. You can now start your program!",
                'data' => [
                    'program_id' => $assignment->program->id,
                    'assignment_id' => $assignment->id,
                    'client_id' => $assignment->client->id,
                    'trainer_id' => $assignment->program->trainer_id,
                ],
            ]);
            
            // Broadcast the notification
            broadcast(new \App\Events\NotificationCreated($notification));
        });

        return redirect()->back()
            ->with('success', 'Assignment approved successfully!');
    }

    /**
     * Reject a program assignment
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $trainer = Auth::user()->trainerProfile;

        $assignment = ProgramAssignment::with(['program', 'client.user'])
            ->whereHas('program', function ($query) use ($trainer) {
                $query->where('trainer_id', $trainer->id);
            })
            ->findOrFail($id);

        if (!$assignment->isPending()) {
            return redirect()->back()
                ->with('error', 'This assignment is not pending approval.');
        }

        DB::transaction(function () use ($assignment, $request) {
            // Update assignment status
            $assignment->update([
                'status' => ProgramAssignment::STATUS_REJECTED,
                'notes' => $request->reason,
            ]);

            // Create notification for client
            $notification = Notification::create([
                'user_id' => $assignment->client->user->id,
                'type' => 'assignment_rejected',
                'title' => 'Program Enrollment Rejected',
                'message' => "Your enrollment request for '{$assignment->program->name}' has been rejected." .
                           ($request->reason ? " Reason: {$request->reason}" : ""),
                'data' => [
                    'program_id' => $assignment->program->id,
                    'assignment_id' => $assignment->id,
                    'client_id' => $assignment->client->id,
                    'trainer_id' => $assignment->program->trainer_id,
                ],
            ]);
            
            // Broadcast the notification
            broadcast(new \App\Events\NotificationCreated($notification));
        });

        return redirect()->back()
            ->with('success', 'Assignment rejected.');
    }
}
