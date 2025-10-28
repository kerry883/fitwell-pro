<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Program;
use App\Models\Notification;
use App\Models\ProgramAssignment;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class TrainerClientController extends Controller
{
    /**
     * Display all clients for the trainer
     */
    public function index(Request $request)
    {
        $trainer = Auth::user();

        $clientQuery = ClientProfile::with(['user'])
            ->where('trainer_id', $trainer->id);

        // Apply search filter
        if($request->has('search') && $request->search){
            $clientQuery->whereHas('user', function($query) use ($request){
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $clients = $clientQuery->get()->map(function($clientProfile) {
            return [
                'id' => $clientProfile->id,
                'name' => $clientProfile->user->name,
                'email' => $clientProfile->user->email,
                'joinedDate' => $clientProfile->joined_date,
                'lastSession' => $clientProfile->last_session,
                'nextSession' => $clientProfile->next_session,
                'status' => $clientProfile->status,
                'progress' => $clientProfile->progress,
                'sessionsCompleted' => $clientProfile->sessions_completed,
                'currentGoals' => $clientProfile->goals ?? [],
            ];
        });

        return view('trainer.clients.index', compact('clients'));
    }
    
    /**
     * Show individual client details
     */
    public function show($id)
    {
        $trainer = Auth::user();

        // Get the actual client profile
        $clientProfile = ClientProfile::with(['user', 'assignments.program'])
            ->where('trainer_id', $trainer->id)
            ->findOrFail($id);

        // Get client data from profile
        $client = [
            'id' => $clientProfile->id,
            'name' => $clientProfile->user->full_name,
            'email' => $clientProfile->user->email,
            'joinedDate' => $clientProfile->joined_date,
            'lastSession' => $clientProfile->last_session,
            'nextSession' => $clientProfile->next_session,
            'status' => $clientProfile->status,
            'progress' => $clientProfile->progress,
            'sessionsCompleted' => $clientProfile->sessions_completed,
            'currentGoals' => $clientProfile->goals ?? [],
        ];

        $clientStats = $this->getClientStats($clientProfile);
        $workoutHistory = $this->getClientWorkoutHistory($clientProfile);
        $progressData = $this->getClientProgress($clientProfile);
        $clientSchedule = $this->getClientSchedule($clientProfile);
        $clientNotes = $this->getClientNotes($clientProfile);
        $clientGoals = $this->getClientGoals($clientProfile);
        $currentProgram = $this->getCurrentProgram($clientProfile);

        return view('trainer.clients.show', compact(
            'client',
            'clientStats',
            'workoutHistory',
            'progressData',
            'clientSchedule',
            'clientNotes',
            'clientGoals',
            'currentProgram',
            'clientProfile'
        ));
    }
    
    /**
     * Get all clients for the trainer
     */
    private function getTrainerClients($id)
    {
        
        // This would fetch actual client relationships
        return [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'joinedDate' => '2024-01-15',
                'lastSession' => '2024-01-20',
                'nextSession' => '2024-01-22',
                'status' => 'active',
                'progress' => 'improving',
                'sessionsCompleted' => 12,
                'currentGoals' => ['Weight Loss', 'Strength Building']
            ],
            [
                'id' => 2,
                'name' => 'Mike Chen',
                'email' => 'mike@example.com',
                'joinedDate' => '2024-01-10',
                'lastSession' => '2024-01-19',
                'nextSession' => '2024-01-24',
                'status' => 'active',
                'progress' => 'on-track',
                'sessionsCompleted' => 15,
                'currentGoals' => ['Muscle Gain', 'Endurance']
            ],
            [
                'id' => 3,
                'name' => 'Emma Wilson',
                'email' => 'emma@example.com',
                'joinedDate' => '2023-12-01',
                'lastSession' => '2024-01-18',
                'nextSession' => '2024-01-25',
                'status' => 'active',
                'progress' => 'excellent',
                'sessionsCompleted' => 28,
                'currentGoals' => ['Flexibility', 'Core Strength']
            ]
        ];
    }
    
    /**
     * Get client by ID
     */
    private function getClientById($id)
    {
        $clients = $this->getTrainerClients(Auth::user());
        return collect($clients)->firstWhere('id', $id);
    }
    
    /**
     * Get client statistics
     */
    private function getClientStats($clientProfile)
    {
        // Calculate actual statistics from client profile and assignments
        $totalSessions = $clientProfile->sessions_completed ?? 0;

        // Calculate weekly average from actual workout data
        $weeklyAverage = $this->calculateWeeklyAverage($clientProfile->user_id);

        // Calculate current streak from workout data
        $currentStreak = $this->calculateCurrentStreak($clientProfile->user_id);

        // Calculate missed sessions from schedule data
        $missedSessions = $this->calculateMissedSessions($clientProfile->id);

        // Calculate enhanced progress score
        $progressScore = $this->calculateProgressScore($clientProfile);

        return [
            'totalSessions' => $totalSessions,
            'weeklyAverage' => $weeklyAverage,
            'currentStreak' => $currentStreak,
            'missedSessions' => $missedSessions,
            'progressScore' => $progressScore,
        ];
    }
    
    /**
     * Get client workout history
     */
    private function getClientWorkoutHistory($clientProfile)
    {
        // Get actual workouts from database
        $workouts = \App\Models\Workout::where('user_id', $clientProfile->user_id)
            ->with(['exercises', 'program'])
            ->orderBy('workout_date', 'desc')
            ->limit(10)
            ->get();

        return $workouts->map(function($workout) {
            return [
                'date' => $workout->workout_date->format('Y-m-d'),
                'workout' => $workout->name,
                'duration' => $workout->duration_minutes,
                'sets' => $workout->exercises->sum('pivot.sets'),
                'reps' => $workout->exercises->sum('pivot.reps'),
                'caloriesBurned' => $workout->total_calories_burned,
                'rating' => 4, // Placeholder - would need rating system
            ];
        })->toArray();
    }

    /**
     * Get client schedule
     */
    private function getClientSchedule($clientProfile)
    {
        // Get upcoming scheduled sessions
        $upcoming = \App\Models\ClientSchedule::where('client_id', $clientProfile->id)
            ->where('status', 'scheduled')
            ->where('scheduled_date', '>=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return $upcoming->map(function($schedule) {
            return [
                'id' => $schedule->id,
                'date' => $schedule->scheduled_date->format('M j, Y'),
                'time' => $schedule->start_time ? $schedule->start_time->format('g:i A') : 'TBD',
                'session_type' => $schedule->session_type_label,
                'location' => $schedule->location,
                'duration' => $schedule->duration ?? 60,
                'status' => $schedule->status,
            ];
        })->toArray();
    }

    /**
     * Get client notes
     */
    private function getClientNotes($clientProfile)
    {
        // Get recent notes for this client
        $notes = \App\Models\ClientNote::where('client_id', $clientProfile->id)
            ->with('trainer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return $notes->map(function($note) {
            return [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'type' => $note->type_label,
                'created_at' => $note->created_at->format('M j, Y g:i A'),
                'trainer' => $note->trainer->name ?? 'Unknown',
            ];
        })->toArray();
    }

    /**
     * Get client goals
     */
    private function getClientGoals($clientProfile)
    {
        // Get active goals for this client
        $goals = \App\Models\Goal::where('client_id', $clientProfile->id)
            ->with(['trackings' => function($query) {
                $query->orderBy('tracking_date', 'desc')->limit(3);
            }])
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return $goals->map(function($goal) {
            return [
                'id' => $goal->id,
                'title' => $goal->title,
                'category' => $goal->category_label,
                'type' => $goal->type_label,
                'target_value' => $goal->target_value,
                'current_value' => $goal->current_value,
                'target_unit' => $goal->target_unit,
                'progress_percentage' => $goal->progress_percentage,
                'status' => $goal->status_label,
                'priority' => $goal->priority,
                'target_date' => $goal->target_date?->format('M j, Y'),
                'is_overdue' => $goal->is_overdue,
                'days_remaining' => $goal->days_remaining,
                'latest_tracking' => $goal->latest_tracking ? [
                    'value' => $goal->latest_tracking->value,
                    'date' => $goal->latest_tracking->tracking_date->format('M j, Y'),
                ] : null,
            ];
        })->toArray();
    }
    
    /**
     * Get client progress data
     */
    private function getClientProgress($clientProfile)
    {
        // Get body measurements from client profile
        $measurements = [
            'waist' => ['current' => $clientProfile->waist_cm, 'starting' => null],
            'chest' => ['current' => $clientProfile->chest_cm, 'starting' => null],
            'arms' => ['current' => $clientProfile->arms_cm, 'starting' => null],
        ];

        // Filter out null measurements
        $measurements = array_filter($measurements, function($measurement) {
            return $measurement['current'] !== null;
        });

        // Calculate weight progress
        $weightProgress = [
            'current' => $clientProfile->weight_kg,
            'starting' => null, // Would need historical data
            'goal' => null, // Would need goal data
            'trend' => 'stable'
        ];

        // Calculate BMI if height and weight are available
        $bmi = null;
        if ($clientProfile->height_cm && $clientProfile->weight_kg) {
            $heightInMeters = $clientProfile->height_cm / 100;
            $bmi = round($clientProfile->weight_kg / ($heightInMeters * $heightInMeters), 1);
        }

        return [
            'weightProgress' => $weightProgress,
            'strengthProgress' => [
                'benchPress' => ['current' => null, 'starting' => null], // Would need workout data
                'squat' => ['current' => null, 'starting' => null],
                'deadlift' => ['current' => null, 'starting' => null]
            ],
            'measurements' => $measurements,
            'bmi' => $bmi,
            'bodyFat' => null // Removed body fat percentage as it's not in the three measurements
        ];
    }

    /**
     * Show client activation page with match percentage
     */
    public function activate(Request $request, $id)
    {
        // Get the client details
        $client = User::findOrFail($id);
        $clientProfile = $client->clientProfile;

        if (!$clientProfile) {
            return redirect()->route('trainer.clients.index')
                ->with('error', 'Client profile not found.');
        }

        // Get the specific assignment if provided, otherwise get any pending
        $assignmentQuery = ProgramAssignment::where('client_id', $clientProfile->id)
            ->with('program');

        if ($request->has('assignment')) {
            $assignmentQuery->where('id', $request->assignment);
        } else {
            // If no specific assignment, get any pending one
            $assignmentQuery->where('status', 'pending');
        }

        $assignment = $assignmentQuery->first();

        if (!$assignment) {
            return redirect()->route('trainer.assignments.index')
                ->with('error', 'No enrollment found for this client.');
        }

        $program = $assignment->program;

        // Verify the program belongs to this trainer
        if ($program->trainer_id !== Auth::user()->trainerProfile->id) {
            return redirect()->route('trainer.assignments.index')
                ->with('error', 'Unauthorized access to this enrollment.');
        }

        // Use the same ProgramMatchingService as clients see
        $matchingService = app(\App\Services\ProgramMatchingService::class);
        $matchData = $matchingService->calculateMatch($clientProfile, $program);

        // For backward compatibility, keep matchPercentage as the total score
        $matchPercentage = $matchData['total_score'];

        // Add match data to program for template access
        $program->match_data = $matchData;

        return view('trainer.clients.activate', compact(
            'client',
            'clientProfile',
            'program',
            'assignment',
            'matchPercentage'
        ));
    }

    /**
     * Process client activation (Updated for payment integration)
     */
    public function processActivation($id, Request $request)
    {
        $request->validate([
            'approval_notes' => 'nullable|string|max:1000',
            'assignment_id' => 'required|exists:program_assignments,id',
        ]);

        // Get the client and specific assignment
        $client = User::findOrFail($id);
        $clientProfile = $client->clientProfile;
        $assignment = ProgramAssignment::with('program')->findOrFail($request->assignment_id);
        $program = $assignment->program;

        if (!$assignment->isPending()) {
            return redirect()->route('trainer.assignments.index')
                ->with('error', 'This assignment is not pending approval.');
        }

        DB::transaction(function () use ($assignment, $program, $request, $clientProfile) {
            // Check if program is free
            if ($program->isFree()) {
                // Free program - activate immediately
                $assignment->update([
                    'status' => \App\Enums\ProgramAssignmentStatus::ACTIVE,
                    'start_date' => now(),
                    'end_date' => now()->addWeeks($program->duration_weeks),
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                    'approval_notes' => $request->approval_notes,
                ]);

                // Update program current clients count
                $program->increment('current_clients');

                // Update client profile status
                $clientProfile->status = 'active';
                if (!$clientProfile->trainer_id) {
                    $clientProfile->trainer_id = Auth::id();
                }
                if (!$clientProfile->joined_date) {
                    $clientProfile->joined_date = now();
                }
                $clientProfile->save();

                // Create notification for client - immediate activation
                $notification = \App\Models\Notification::create([
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
                    'status' => \App\Enums\ProgramAssignmentStatus::PENDING_PAYMENT,
                    'approved_at' => now(),
                    'approved_by' => Auth::id(),
                    'approval_notes' => $request->approval_notes,
                    'payment_deadline' => $paymentDeadline,
                ]);

                // Create notification for client - payment required
                $notification = \App\Models\Notification::create([
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

        return redirect()->route('trainer.assignments.index')
            ->with('success', $program->isFree() 
                ? 'Assignment approved and activated!' 
                : 'Assignment approved! Client will be notified to complete payment.');
    }

    /**
     * Deactivate a client
     */
    public function deactivate($id, Request $request)
    {
        // Get the client and profile
        $client = User::findOrFail($id);
        $clientProfile = $client->clientProfile;

        // Check if client belongs to this trainer
        if ($clientProfile->trainer_id !== Auth::id()) {
            abort(403, 'Unauthorized access to client.');
        }

        // Update client profile status
        $clientProfile->status = 'inactive';
        $clientProfile->save();

        // Update all active assignments to cancelled
        ProgramAssignment::where('client_id', $clientProfile->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create notification for the client
        Notification::create([
            'user_id' => $client->id,
            'title' => 'Account Deactivated',
            'message' => 'Your trainer account has been deactivated. Please contact your trainer for more information.',
            'type' => 'account_deactivated',
            'data' => [
                'trainer_id' => Auth::id(),
                'client_id' => $clientProfile->id,
            ],
        ]);

        // Update trainer's client count
        $trainerProfile = Auth::user()->trainerProfile;
        if ($trainerProfile && $trainerProfile->current_clients > 0) {
            $trainerProfile->current_clients = $trainerProfile->current_clients - 1;
            $trainerProfile->save();
        }

        // Redirect with success message
        return redirect()->route('trainer.clients.index')
            ->with('success', 'Client has been successfully deactivated.');
    }

    /**
     * Calculate weekly average workouts for a client
     */
    private function calculateWeeklyAverage($userId)
    {
        // Get workouts from the last 4 weeks
        $fourWeeksAgo = now()->subWeeks(4);

        $totalWorkouts = \App\Models\Workout::where('user_id', $userId)
            ->where('workout_date', '>=', $fourWeeksAgo)
            ->count();

        // Calculate average per week
        return round($totalWorkouts / 4, 1);
    }

    /**
     * Calculate current workout streak for a client
     */
    private function calculateCurrentStreak($userId)
    {
        $streak = 0;
        $currentDate = now()->toDateString();

        // Check backwards from today
        for ($i = 0; $i < 365; $i++) { // Max 365 days to prevent infinite loop
            $checkDate = now()->subDays($i)->toDateString();

            $hasWorkout = \App\Models\Workout::where('user_id', $userId)
                ->where('workout_date', $checkDate)
                ->exists();

            if ($hasWorkout) {
                $streak++;
            } else {
                // Only break if we're checking past dates (not future)
                if ($checkDate < $currentDate) {
                    break;
                }
            }
        }

        return $streak;
    }

    /**
     * Calculate missed sessions for a client
     */
    private function calculateMissedSessions($clientId)
    {
        // Count scheduled sessions that are marked as missed
        return \App\Models\ClientSchedule::where('client_id', $clientId)
            ->where('status', 'missed')
            ->count();
    }

    /**
     * Calculate enhanced progress score for a client
     */
    private function calculateProgressScore($clientProfile)
    {
        $score = 0;
        $weights = [
            'assignment_progress' => 40,
            'goal_achievement' => 30,
            'workout_consistency' => 20,
            'measurement_improvement' => 10,
        ];

        // Assignment progress (40%)
        $activeAssignments = $clientProfile->assignments()->active()->get();
        if ($activeAssignments->count() > 0) {
            $assignmentProgress = $activeAssignments->avg('progress_percentage') ?? 0;
            $score += ($assignmentProgress * $weights['assignment_progress'] / 100);
        }

        // Goal achievement (30%) - calculate from actual goals
        $goalAchievement = $this->calculateGoalAchievement($clientProfile->id);
        $score += ($goalAchievement * $weights['goal_achievement'] / 100);

        // Workout consistency (20%)
        $weeklyAverage = $this->calculateWeeklyAverage($clientProfile->user_id);
        $consistencyScore = min(100, $weeklyAverage * 25); // 4 workouts/week = 100%
        $score += ($consistencyScore * $weights['workout_consistency'] / 100);

        // Measurement improvement (10%) - simplified
        $measurementScore = 60; // Placeholder - would compare current vs starting measurements
        $score += ($measurementScore * $weights['measurement_improvement'] / 100);

        return round(min(100, $score));
    }

    /**
     * Calculate match percentage between client and program (DEPRECATED)
     * This method is kept for backward compatibility but should not be used.
     * Use ProgramMatchingService instead.
     */
    private function calculateMatchPercentage($client, $program)
    {
        // This is a simplified example - in a real implementation,
        // you would compare client preferences, goals, fitness level, etc.
        // with the program characteristics to calculate a match score

        // For now, return a random percentage between 70-95
        return rand(70, 95);
    }

    /**
     * Calculate goal achievement percentage for a client
     */
    private function calculateGoalAchievement($clientId)
    {
        $goals = \App\Models\Goal::where('client_id', $clientId)->get();

        if ($goals->isEmpty()) {
            return 0;
        }

        $totalAchievement = 0;
        $goalCount = 0;

        foreach ($goals as $goal) {
            $goalCount++;
            $totalAchievement += $goal->progress_percentage;

            // Bonus for completed goals
            if ($goal->status === 'completed') {
                $totalAchievement += 20; // Bonus points for completion
            }

            // Penalty for overdue goals
            if ($goal->is_overdue) {
                $totalAchievement -= 10; // Penalty for overdue
            }
        }

        $averageAchievement = $goalCount > 0 ? $totalAchievement / $goalCount : 0;

        // Cap at 100%
        return min(100, max(0, $averageAchievement));
    }

    /**
     * Get current program for a client
     */
    private function getCurrentProgram($clientProfile)
    {
        // Get the active program assignment
        $activeAssignment = $clientProfile->assignments()
            ->with('program')
            ->active()
            ->first();

        return $activeAssignment;
    }
}