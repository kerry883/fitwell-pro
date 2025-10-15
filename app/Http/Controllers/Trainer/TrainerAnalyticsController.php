<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TrainerAnalyticsController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        // Mock analytics data - in a real app, this would come from the database
        $analytics = [
            'revenue' => $this->getRevenueData(),
            'sessions' => $this->getSessionData(),
            'clients' => $this->getClientData(),
            'performance' => $this->getPerformanceData(),
            'goals' => $this->getGoalsData(),
            'trends' => $this->getTrendsData()
        ];
        
        return view('trainer.analytics.index', compact('analytics', 'currentMonth', 'lastMonth'));
    }
    
    private function getRevenueData()
    {
        return [
            'current_month' => 3250,
            'last_month' => 2900,
            'year_to_date' => 28750,
            'growth_rate' => 12.1,
            'monthly_data' => [
                'January' => 2800,
                'February' => 2900,
                'March' => 3250,
                'April' => 3100,
                'May' => 3450,
                'June' => 3300,
                'July' => 3600,
                'August' => 3400,
                'September' => 3200,
                'October' => 3500,
                'November' => 3300,
                'December' => 3100
            ],
            'breakdown' => [
                'personal_training' => 2200,
                'group_sessions' => 650,
                'program_sales' => 250,
                'consultations' => 150
            ]
        ];
    }
    
    private function getSessionData()
    {
        return [
            'total_this_month' => 52,
            'total_last_month' => 48,
            'completed_rate' => 94.2,
            'average_per_week' => 13,
            'by_type' => [
                'Personal Training' => 28,
                'Strength Training' => 12,
                'Cardio Sessions' => 8,
                'Functional Training' => 4
            ],
            'by_location' => [
                'Home Studio' => 24,
                'Client Home' => 16,
                'Local Gym' => 8,
                'Outdoor' => 4
            ],
            'weekly_data' => [
                'Week 1' => 14,
                'Week 2' => 13,
                'Week 3' => 12,
                'Week 4' => 13
            ]
        ];
    }
    
    private function getClientData()
    {
        return [
            'active_clients' => 12,
            'new_this_month' => 3,
            'retained_rate' => 91.7,
            'average_sessions_per_client' => 4.3,
            'client_satisfaction' => 4.8,
            'progress_distribution' => [
                'Excellent' => 5,
                'Improving' => 4,
                'On Track' => 2,
                'Needs Focus' => 1
            ],
            'enrollment_trend' => [
                'January' => 8,
                'February' => 9,
                'March' => 12,
                'April' => 11,
                'May' => 13,
                'June' => 12
            ]
        ];
    }
    
    private function getPerformanceData()
    {
        return [
            'average_rating' => 4.8,
            'total_reviews' => 47,
            'punctuality_score' => 98.5,
            'session_quality' => 4.7,
            'communication' => 4.9,
            'professionalism' => 4.8,
            'recent_feedback' => [
                [
                    'client' => 'Sarah Johnson',
                    'rating' => 5,
                    'comment' => 'Excellent trainer! Very knowledgeable and motivating.',
                    'date' => '2024-01-20'
                ],
                [
                    'client' => 'Mike Chen',
                    'rating' => 5,
                    'comment' => 'Great workout plans and always on time.',
                    'date' => '2024-01-18'
                ],
                [
                    'client' => 'Emma Wilson',
                    'rating' => 5,
                    'comment' => 'Helped me achieve my fitness goals faster than expected.',
                    'date' => '2024-01-15'
                ]
            ]
        ];
    }
    
    private function getGoalsData()
    {
        return [
            'monthly_revenue_target' => 3500,
            'monthly_sessions_target' => 60,
            'client_acquisition_target' => 15,
            'current_progress' => [
                'revenue' => 92.9, // 3250/3500 * 100
                'sessions' => 86.7, // 52/60 * 100
                'clients' => 80.0   // 12/15 * 100
            ]
        ];
    }
    
    private function getTrendsData()
    {
        return [
            'busiest_day' => 'Wednesday',
            'peak_hours' => '9:00 AM - 11:00 AM',
            'most_popular_session' => 'Personal Training',
            'average_session_length' => 52, // minutes
            'client_retention_months' => 8.3,
            'seasonal_trends' => [
                'Q1' => 'High demand for weight loss programs',
                'Q2' => 'Increased outdoor training requests',
                'Q3' => 'Focus on strength building',
                'Q4' => 'Holiday fitness maintenance'
            ]
        ];
    }
}