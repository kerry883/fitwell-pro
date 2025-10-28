<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\ClientSchedule;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ClientScheduleController extends Controller
{
    /**
     * Store a newly created schedule for a client.
     */
    public function store(Request $request, $clientId): JsonResponse
    {
        $request->validate([
            'scheduled_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'session_type' => 'required|in:training,consultation,assessment,check_in',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user();

        // Verify trainer has access to this client
        $clientProfile = ClientProfile::where('id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $schedule = ClientSchedule::create([
            'client_id' => $clientId,
            'trainer_id' => $trainer->id,
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'session_type' => $request->session_type,
            'location' => $request->location,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Session scheduled successfully',
            'schedule' => [
                'id' => $schedule->id,
                'date' => $schedule->scheduled_date->format('M j, Y'),
                'time' => $schedule->start_time ? $schedule->start_time->format('g:i A') : 'TBD',
                'session_type' => $schedule->session_type_label,
                'location' => $schedule->location,
                'duration' => $schedule->duration ?? 60,
                'status' => $schedule->status,
            ]
        ]);
    }

    /**
     * Update the specified schedule.
     */
    public function update(Request $request, $clientId, $scheduleId): JsonResponse
    {
        $request->validate([
            'scheduled_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'session_type' => 'required|in:training,consultation,assessment,check_in',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled,missed',
            'actual_duration_minutes' => 'nullable|integer|min:1',
            'performance_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $trainer = Auth::user();

        $schedule = ClientSchedule::where('id', $scheduleId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $updateData = [
            'scheduled_date' => $request->scheduled_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'session_type' => $request->session_type,
            'location' => $request->location,
            'notes' => $request->notes,
            'status' => $request->status,
        ];

        // Handle completion data
        if ($request->status === 'completed') {
            $updateData['completed_at'] = now();
            $updateData['actual_duration_minutes'] = $request->actual_duration_minutes;
            $updateData['performance_rating'] = $request->performance_rating;
        }

        $schedule->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Schedule updated successfully',
            'schedule' => [
                'id' => $schedule->id,
                'date' => $schedule->scheduled_date->format('M j, Y'),
                'time' => $schedule->start_time ? $schedule->start_time->format('g:i A') : 'TBD',
                'session_type' => $schedule->session_type_label,
                'location' => $schedule->location,
                'duration' => $schedule->duration ?? 60,
                'status' => $schedule->status,
            ]
        ]);
    }

    /**
     * Remove the specified schedule.
     */
    public function destroy($clientId, $scheduleId): JsonResponse
    {
        $trainer = Auth::user();

        $schedule = ClientSchedule::where('id', $scheduleId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Schedule deleted successfully'
        ]);
    }

    /**
     * Mark a session as completed.
     */
    public function markCompleted(Request $request, $clientId, $scheduleId): JsonResponse
    {
        $request->validate([
            'actual_duration_minutes' => 'nullable|integer|min:1',
            'performance_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $trainer = Auth::user();

        $schedule = ClientSchedule::where('id', $scheduleId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->where('status', 'scheduled')
            ->firstOrFail();

        $schedule->markAsCompleted(
            $request->actual_duration_minutes,
            $request->performance_rating
        );

        return response()->json([
            'success' => true,
            'message' => 'Session marked as completed'
        ]);
    }

    /**
     * Mark a session as missed.
     */
    public function markMissed($clientId, $scheduleId): JsonResponse
    {
        $trainer = Auth::user();

        $schedule = ClientSchedule::where('id', $scheduleId)
            ->where('client_id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->where('status', 'scheduled')
            ->firstOrFail();

        $schedule->markAsMissed();

        return response()->json([
            'success' => true,
            'message' => 'Session marked as missed'
        ]);
    }

    /**
     * Get schedules for a specific client (AJAX endpoint).
     */
    public function getClientSchedules($clientId): JsonResponse
    {
        $trainer = Auth::user();

        // Verify trainer has access to this client
        ClientProfile::where('id', $clientId)
            ->where('trainer_id', $trainer->id)
            ->firstOrFail();

        $schedules = ClientSchedule::where('client_id', $clientId)
            ->orderBy('scheduled_date')
            ->orderBy('start_time')
            ->get()
            ->map(function($schedule) {
                return [
                    'id' => $schedule->id,
                    'date' => $schedule->scheduled_date->format('M j, Y'),
                    'time' => $schedule->start_time ? $schedule->start_time->format('g:i A') : 'TBD',
                    'session_type' => $schedule->session_type_label,
                    'location' => $schedule->location,
                    'duration' => $schedule->duration ?? 60,
                    'status' => $schedule->status,
                    'notes' => $schedule->notes,
                ];
            });

        return response()->json(['schedules' => $schedules]);
    }
}
