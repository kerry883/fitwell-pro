<?php

namespace App\Http\Controllers\Trainer;

use App\Enums\ProgramAssignmentStatus;
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
     * Approve a program assignment (Updated for payment integration)
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'approval_notes' => 'nullable|string|max:1000',
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

        $program = $assignment->program;

        DB::transaction(function () use ($assignment, $program, $request) {
            // Check if program is free
            if ($program->isFree()) {
                // Free program - activate immediately
                $assignment->update([
                    'status' => ProgramAssignmentStatus::ACTIVE,
                    'start_date' => now(),
                    'end_date' => now()->addWeeks($program->duration_weeks),
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                    'approval_notes' => $request->approval_notes,
                ]);

                // Update program current clients count
                $program->increment('current_clients');

                // Create notification for client - immediate activation
                $notification = Notification::create([
                    'user_id' => $assignment->client->user->id,
                    'type' => 'program_assignment_approved',
                    'title' => 'Program Enrollment Approved',
                    'message' => "Your enrollment for '{$program->name}' has been approved! You can start immediately.",
                    'data' => [
                        'program_id' => $program->id,
                        'assignment_id' => $assignment->id,
                        'client_id' => $assignment->client->id,
                        'trainer_id' => $program->trainer_id,
                    ],
                ]);
                
                broadcast(new \App\Events\NotificationCreated($notification));
            } else {
                // Paid program - set to pending payment
                $paymentDeadline = now()->addHours($program->payment_deadline_hours ?? 48);

                $assignment->update([
                    'status' => ProgramAssignmentStatus::PENDING_PAYMENT,
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                    'approval_notes' => $request->approval_notes,
                    'payment_deadline' => $paymentDeadline,
                ]);

                // Create notification for client - payment required
                $notification = Notification::create([
                    'user_id' => $assignment->client->user->id,
                    'type' => 'enrollment_approved_pending_payment',
                    'title' => 'Payment Required',
                    'message' => "Your enrollment for '{$program->name}' has been approved! Please complete payment within " . 
                               ($program->payment_deadline_hours ?? 48) . " hours to activate your program.",
                    'data' => [
                        'program_id' => $program->id,
                        'assignment_id' => $assignment->id,
                        'client_id' => $assignment->client->id,
                        'trainer_id' => $program->trainer_id,
                        'amount' => $program->price,
                        'deadline' => $paymentDeadline->toISOString(),
                        'payment_url' => route('client.payment.checkout', $assignment->id),
                    ],
                ]);
                
                broadcast(new \App\Events\NotificationCreated($notification));
            }
        });

        return redirect()->back()
            ->with('success', $program->isFree() 
                ? 'Assignment approved and activated!' 
                : 'Assignment approved! Client will be notified to complete payment.');
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
                'status' => ProgramAssignmentStatus::REJECTED,
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
