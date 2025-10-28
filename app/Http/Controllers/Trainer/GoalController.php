<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use App\Models\GoalTracking;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class GoalController extends Controller
{
    /**
     * Store a newly created goal for a client.
     */
    public function store(Request $request, $clientId): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:weight_loss,weight_gain,muscle_building,strength,endurance,flexibility,general_fitness,sports_performance,health_improvement,other',
            'type' => 'required|in:trainer_set,client_set,program_based,milestone',
            'measurement_type' => 'required|in:weight,body_fat,muscle_mass,measurements,performance,time_based,repetition_based,distance_based,custom',
            'target_value' => 'required|numeric|min:0',
            'target_unit' => 'nullable|string|max:50',
            'current_value' => 'nullable|numeric|min:0',
            'target_date' => 'nullable|date|after:today',
            'priority' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user();

        // Verify trainer has access to this client
        $clientProfile = ClientProfile::where('id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Create goal instance to check medical considerations
        $goalData = [
            'client_id' => $clientId,
            'trainer_id' => $trainer->id,
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'type' => $request->type,
            'measurement_type' => $request->measurement_type,
            'target_value' => $request->target_value,
            'target_unit' => $request->target_unit,
            'current_value' => $request->current_value,
            'target_date' => $request->target_date,
            'start_date' => now(),
            'priority' => $request->priority,
            'notes' => $request->notes,
        ];

        $goal = new Goal($goalData);

        // Check for medical considerations and warnings
        $medicalWarnings = $goal->checkMedicalConsiderations($clientProfile);
        $medicalRecommendations = $goal->getMedicalRecommendations($clientProfile);

        // Store medical considerations in the goal
        $goalData['medical_considerations'] = array_merge($medicalWarnings, $medicalRecommendations);

        $goal = Goal::create($goalData);

        // Create initial tracking entry if current value is provided
        if ($request->current_value) {
            $goal->trackings()->create([
                'client_id' => $clientId,
                'value' => $request->current_value,
                'unit' => $request->target_unit,
                'tracking_date' => now(),
                'entry_type' => 'manual',
                'notes' => 'Initial goal value',
            ]);
        }

        $response = [
            'success' => true,
            'message' => 'Goal created successfully',
            'goal' => [
                'id' => $goal->id,
                'title' => $goal->title,
                'category' => $goal->category_label,
                'type' => $goal->type_label,
                'target_value' => $goal->target_value,
                'current_value' => $goal->current_value,
                'progress_percentage' => $goal->progress_percentage,
                'status' => $goal->status_label,
            ]
        ];

        // Include medical warnings if any
        if (!empty($medicalWarnings)) {
            $response['warnings'] = $medicalWarnings;
        }

        // Include medical recommendations if any
        if (!empty($medicalRecommendations)) {
            $response['recommendations'] = $medicalRecommendations;
        }

        return response()->json($response);
    }

    /**
     * Update the specified goal.
     */
    public function update(Request $request, $clientId, $goalId): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:weight_loss,weight_gain,muscle_building,strength,endurance,flexibility,general_fitness,sports_performance,health_improvement,other',
            'type' => 'required|in:primary,secondary,long_term,short_term',
            'measurement_type' => 'required|in:weight,body_fat,muscle_mass,measurements,performance,time_based,repetition_based,distance_based,custom',
            'target_value' => 'required|numeric|min:0',
            'target_unit' => 'nullable|string|max:50',
            'current_value' => 'nullable|numeric|min:0',
            'target_date' => 'nullable|date',
            'status' => 'required|in:active,completed,paused,cancelled',
            'priority' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user();

        $goal = Goal::where('id', $goalId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $goal->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'type' => $request->type,
            'measurement_type' => $request->measurement_type,
            'target_value' => $request->target_value,
            'target_unit' => $request->target_unit,
            'current_value' => $request->current_value,
            'target_date' => $request->target_date,
            'status' => $request->status,
            'priority' => $request->priority,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Goal updated successfully',
            'goal' => [
                'id' => $goal->id,
                'title' => $goal->title,
                'category' => $goal->category_label,
                'type' => $goal->type_label,
                'target_value' => $goal->target_value,
                'current_value' => $goal->current_value,
                'progress_percentage' => $goal->progress_percentage,
                'status' => $goal->status_label,
            ]
        ]);
    }

    /**
     * Remove the specified goal.
     */
    public function destroy($clientId, $goalId): JsonResponse
    {
        $trainer = Auth::user();

        $goal = Goal::where('id', $goalId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $goal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Goal deleted successfully'
        ]);
    }

    /**
     * Add a progress tracking entry for a goal.
     */
    public function addProgress(Request $request, $clientId, $goalId): JsonResponse
    {
        $request->validate([
            'value' => 'required|numeric|min:0',
            'tracking_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user();

        $goal = Goal::where('id', $goalId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        // Update goal's current value
        $goal->update(['current_value' => $request->value]);

        // Create tracking entry
        $tracking = $goal->trackings()->create([
            'client_id' => $clientId,
            'value' => $request->value,
            'unit' => $goal->target_unit,
            'tracking_date' => $request->tracking_date,
            'notes' => $request->notes,
            'entry_type' => 'manual',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully',
            'goal' => [
                'id' => $goal->id,
                'current_value' => $goal->current_value,
                'progress_percentage' => $goal->progress_percentage,
            ],
            'tracking' => [
                'id' => $tracking->id,
                'value' => $tracking->value,
                'date' => $tracking->tracking_date->format('M j, Y'),
                'notes' => $tracking->notes,
            ]
        ]);
    }

    /**
     * Get goals for a specific client (AJAX endpoint).
     */
    public function getClientGoals($clientId): JsonResponse
    {
        $trainer = Auth::user();

        // Verify trainer has access to this client
        ClientProfile::where('id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $goals = Goal::where('client_id', $clientId)
            ->with(['trackings' => function($query) {
                $query->orderBy('tracking_date', 'desc')->limit(5);
            }])
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($goal) {
                return [
                    'id' => $goal->id,
                    'title' => $goal->title,
                    'description' => $goal->description,
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
                        'notes' => $goal->latest_tracking->notes,
                    ] : null,
                    'recent_trackings' => $goal->trackings->map(function($tracking) {
                        return [
                            'date' => $tracking->tracking_date->format('M j'),
                            'value' => $tracking->value,
                            'change' => $tracking->calculateChange(),
                        ];
                    }),
                ];
            });

        return response()->json(['goals' => $goals]);
    }
}
