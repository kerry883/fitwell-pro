<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainerScheduleController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $currentDate = Carbon::now();
        
        // Mock schedule data - in a real app, this would come from the database
        $schedule = [
            'today' => [
                [
                    'id' => 1,
                    'client_name' => 'Sarah Johnson',
                    'start_time' => '08:00',
                    'end_time' => '09:00',
                    'session_type' => 'Personal Training',
                    'status' => 'completed',
                    'location' => 'Home Studio'
                ],
                [
                    'id' => 2,
                    'client_name' => 'Mike Chen',
                    'start_time' => '10:00',
                    'end_time' => '10:45',
                    'session_type' => 'Strength Training',
                    'status' => 'completed',
                    'location' => 'Client Home'
                ],
                [
                    'id' => 3,
                    'client_name' => 'Alex Rodriguez',
                    'start_time' => '14:00',
                    'end_time' => '14:30',
                    'session_type' => 'Cardio Session',
                    'status' => 'upcoming',
                    'location' => 'Local Gym'
                ],
                [
                    'id' => 4,
                    'client_name' => 'Lisa Brown',
                    'start_time' => '16:30',
                    'end_time' => '17:30',
                    'session_type' => 'Functional Training',
                    'status' => 'upcoming',
                    'location' => 'Outdoor Training'
                ]
            ],
            'week' => $this->getWeeklySchedule(),
            'month' => $this->getMonthlyStats()
        ];
        
        $availability = $this->getTrainerAvailability();
        
        return view('trainer.schedule.index', compact('schedule', 'availability', 'currentDate'));
    }
    
    public function create()
    {
        $clients = $this->getTrainerClients();
        $timeSlots = $this->getAvailableTimeSlots();
        
        return view('trainer.schedule.create', compact('clients', 'timeSlots'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'session_type' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500'
        ]);
        
        // In a real app, you would save to database
        // Schedule::create([...]);
        
        return redirect()
            ->route('trainer.schedule.index')
            ->with('success', 'Session scheduled successfully!');
    }
    
    public function show($id)
    {
        // Mock session data
        $session = [
            'id' => $id,
            'client' => [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'phone' => '+1 (555) 123-4567'
            ],
            'date' => Carbon::today()->format('F j, Y'),
            'start_time' => '08:00',
            'end_time' => '09:00',
            'duration' => 60,
            'session_type' => 'Personal Training',
            'location' => 'Home Studio',
            'status' => 'completed',
            'notes' => 'Client showed great improvement in form. Increased weights for squats.',
            'exercises_completed' => [
                'Squats - 3x10 @ 135lbs',
                'Bench Press - 3x8 @ 85lbs',
                'Deadlifts - 3x5 @ 115lbs',
                'Plank - 3x45s'
            ]
        ];
        
        return view('trainer.schedule.show', compact('session'));
    }
    
    public function edit($id)
    {
        $clients = $this->getTrainerClients();
        $timeSlots = $this->getAvailableTimeSlots();
        
        // Mock session data
        $session = [
            'id' => $id,
            'client_id' => 1,
            'session_date' => Carbon::today()->addDays(2)->format('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '14:30',
            'session_type' => 'Cardio Session',
            'location' => 'Local Gym',
            'notes' => 'Focus on HIIT training'
        ];
        
        return view('trainer.schedule.edit', compact('session', 'clients', 'timeSlots'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'session_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'session_type' => 'required|string|max:100',
            'location' => 'required|string|max:100',
            'notes' => 'nullable|string|max:500'
        ]);
        
        // In a real app, you would update the database record
        
        return redirect()
            ->route('trainer.schedule.index')
            ->with('success', 'Session updated successfully!');
    }
    
    public function destroy($id)
    {
        // In a real app, you would delete from database
        
        return redirect()
            ->route('trainer.schedule.index')
            ->with('success', 'Session cancelled successfully!');
    }
    
    private function getWeeklySchedule()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $schedule = [];
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $schedule[$date->format('Y-m-d')] = [
                'date' => $date,
                'sessions' => $this->getMockSessionsForDate($date)
            ];
        }
        
        return $schedule;
    }
    
    private function getMockSessionsForDate($date)
    {
        $sessions = [];
        $dayOfWeek = $date->dayOfWeek;
        
        // Mock different sessions based on day of week
        if (in_array($dayOfWeek, [1, 3, 5])) { // Mon, Wed, Fri
            $sessions[] = [
                'client_name' => 'Sarah Johnson',
                'time' => '09:00-10:00',
                'type' => 'Strength Training'
            ];
            $sessions[] = [
                'client_name' => 'Mike Chen',
                'time' => '17:30-18:15',
                'type' => 'Powerlifting'
            ];
        }
        
        if (in_array($dayOfWeek, [2, 4])) { // Tue, Thu
            $sessions[] = [
                'client_name' => 'Emma Wilson',
                'time' => '11:00-12:00',
                'type' => 'Yoga & Flexibility'
            ];
            $sessions[] = [
                'client_name' => 'Alex Rodriguez',
                'time' => '14:00-14:30',
                'type' => 'Cardio Session'
            ];
        }
        
        return $sessions;
    }
    
    private function getMonthlyStats()
    {
        return [
            'total_sessions' => 124,
            'completed_sessions' => 118,
            'cancelled_sessions' => 6,
            'revenue' => 9300,
            'avg_sessions_per_day' => 4.1
        ];
    }
    
    private function getTrainerAvailability()
    {
        return [
            'monday' => ['09:00-12:00', '14:00-18:00'],
            'tuesday' => ['08:00-12:00', '13:00-17:00'],
            'wednesday' => ['09:00-12:00', '14:00-18:00'],
            'thursday' => ['08:00-12:00', '13:00-17:00'],
            'friday' => ['09:00-12:00', '14:00-16:00'],
            'saturday' => ['10:00-14:00'],
            'sunday' => ['Unavailable']
        ];
    }
    
    private function getTrainerClients()
    {
        return [
            ['id' => 1, 'name' => 'Sarah Johnson'],
            ['id' => 2, 'name' => 'Mike Chen'],
            ['id' => 3, 'name' => 'Emma Wilson'],
            ['id' => 4, 'name' => 'Alex Rodriguez'],
            ['id' => 5, 'name' => 'Lisa Brown']
        ];
    }
    
    private function getAvailableTimeSlots()
    {
        $slots = [];
        for ($hour = 8; $hour <= 18; $hour++) {
            $slots[] = sprintf('%02d:00', $hour);
            if ($hour < 18) {
                $slots[] = sprintf('%02d:30', $hour);
            }
        }
        return $slots;
    }
}