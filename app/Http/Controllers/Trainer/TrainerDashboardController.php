<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TrainerDashboardController extends Controller
{
    /**
     * Display the trainer dashboard.
     */
    public function index()
    {
        $trainer = Auth::user();
        $trainerProfile = $trainer->trainerProfile;
        
        // Get trainer statistics
        $stats = $this->getTrainerStats($trainer);
        
        // Get recent client interactions
        $recentClients = $this->getRecentClients($trainer);
        
        // Get today's schedule
        $todaySchedule = $this->getTodaySchedule($trainer);
        
        // Get upcoming sessions
        $upcomingSessions = $this->getUpcomingSessions($trainer);
        
        return view('trainer.dashboard', compact(
            'trainer',
            'trainerProfile', 
            'stats', 
            'recentClients', 
            'todaySchedule',
            'upcomingSessions'
        ));
    }
    
    /**
     * Get trainer statistics
     */
    private function getTrainerStats($trainer)
    {
        $trainerProfile = $trainer->trainerProfile;
        
        return [
            'totalClients' => $trainerProfile->current_clients ?? 0,
            'maxClients' => $trainerProfile->max_clients ?? 20,
            'sessionsToday' => 4, // This would come from sessions model
            'monthlyRevenue' => 3250, // This would come from earnings model
            'clientRetentionRate' => 92, // This would be calculated
            'averageRating' => 4.8, // This would come from reviews model
        ];
    }
    
    /**
     * Get recent client interactions
     */
    private function getRecentClients($trainer)
    {
        // This would fetch actual client data from relationships
        return [
            [
                'name' => 'Sarah Johnson',
                'lastSession' => 'Today 10:00 AM',
                'nextSession' => 'Tomorrow 2:00 PM',
                'status' => 'active',
                'progress' => 'improving'
            ],
            [
                'name' => 'Mike Chen',
                'lastSession' => 'Yesterday 6:00 PM',
                'nextSession' => 'Friday 5:30 PM',
                'status' => 'active',
                'progress' => 'on-track'
            ],
            [
                'name' => 'Emma Wilson',
                'lastSession' => '2 days ago',
                'nextSession' => 'Thursday 11:00 AM',
                'status' => 'active',
                'progress' => 'excellent'
            ]
        ];
    }
    
    /**
     * Get today's schedule
     */
    private function getTodaySchedule($trainer)
    {
        return [
            [
                'time' => '08:00 AM',
                'client' => 'John Smith',
                'type' => 'Personal Training',
                'status' => 'completed',
                'duration' => 60
            ],
            [
                'time' => '10:00 AM',
                'client' => 'Sarah Johnson', 
                'type' => 'Strength Training',
                'status' => 'completed',
                'duration' => 45
            ],
            [
                'time' => '02:00 PM',
                'client' => 'Alex Rodriguez',
                'type' => 'Cardio Session',
                'status' => 'upcoming',
                'duration' => 30
            ],
            [
                'time' => '04:30 PM',
                'client' => 'Lisa Brown',
                'type' => 'Functional Training',
                'status' => 'upcoming',
                'duration' => 60
            ]
        ];
    }
    
    /**
     * Get upcoming sessions for the week
     */
    private function getUpcomingSessions($trainer)
    {
        return [
            [
                'date' => 'Tomorrow',
                'time' => '09:00 AM',
                'client' => 'Michael Davis',
                'type' => 'Weight Training'
            ],
            [
                'date' => 'Tomorrow',
                'time' => '02:00 PM',
                'client' => 'Sarah Johnson',
                'type' => 'HIIT Session'
            ],
            [
                'date' => 'Thursday',
                'time' => '11:00 AM',
                'client' => 'Emma Wilson',
                'type' => 'Yoga & Flexibility'
            ],
            [
                'date' => 'Friday',
                'time' => '05:30 PM',
                'client' => 'Mike Chen',
                'type' => 'Strength Training'
            ]
        ];
    }
}