<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ClientProfile;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    /**
     * Start or resume onboarding process
     */
    public function start()
    {
        $user = Auth::user();
        $client = $user->clientProfile;
        
        // Redirect if already completed
        if ($client->hasCompletedOnboarding()) {
            return redirect()->route('client.dashboard')
                ->with('info', 'You have already completed onboarding.');
        }
        
        // Start from last saved step or step 1
        $currentStep = $client->getCurrentOnboardingStep() ?: 1;
        
        return redirect()->route('client.onboarding.step', ['step' => $currentStep]);
    }
    
    /**
     * Show specific onboarding step
     */
    public function showStep($step)
    {
        $user = Auth::user();
        $client = $user->clientProfile;
        
        // Validate step number
        if ($step < 1 || $step > 7) {
            return redirect()->route('client.onboarding.start');
        }
        
        // Redirect if already completed
        if ($client->hasCompletedOnboarding()) {
            return redirect()->route('client.dashboard')
                ->with('info', 'You have already completed onboarding.');
        }
        
        // Get step-specific data
        $data = $this->getStepData($step, $client);
        
        return view('client.onboarding.step' . $step, compact('client', 'data', 'step'));
    }
    
    /**
     * Save onboarding step data
     */
    public function saveStep(Request $request, $step)
    {
        // Validate step data
        $validated = $this->validateStep($request, $step);
        
        $user = Auth::user();
        $client = $user->clientProfile;
        
        // Save step data to database
        $this->saveStepData($client, $step, $validated);
        
        // Update onboarding progress
        $client->markOnboardingStep($step);
        
        // If final step, mark onboarding complete
        if ($step == 7) {
            $client->completeOnboarding();
            
            return redirect()->route('client.dashboard')
                ->with('success', 'Welcome to FitWell Pro! Your profile is complete and you can now browse personalized programs.');
        }
        
        // Go to next step
        return redirect()->route('client.onboarding.step', ['step' => $step + 1])
            ->with('success', 'Step ' . $step . ' completed successfully!');
    }
    
    /**
     * Validate step data based on step number
     */
    private function validateStep(Request $request, int $step): array
    {
        $rules = match($step) {
            1 => [ // Personal Info
                'height' => 'required|numeric|min:100|max:250',
                'weight' => 'required|numeric|min:30|max:300',
                'age' => 'required|integer|min:13|max:100',
                'gender' => 'required|in:male,female,other',
            ],
            2 => [ // Fitness Level & Schedule
                'experience_level' => 'required|in:beginner,intermediate,advanced',
                'fitness_history' => 'nullable|string|max:500',
                'available_days_per_week' => 'required|integer|min:1|max:7',
                'workout_duration_preference' => 'required|integer|min:15|max:180',
            ],
            3 => [ // Goals
                'goal_templates' => 'required|array|min:1|max:3',
                'goal_templates.*' => 'in:weight_loss,muscle_building,endurance,strength,flexibility,general_fitness,sports_performance,healthy_eating,meal_planning,weight_gain,body_composition,nutrition_knowledge,dietary_management',
            ],
            4 => [ // Medical Screening
                'medical_conditions' => 'nullable|array',
                'injuries' => 'nullable|array',
                'medications' => 'nullable|string|max:500',
                'medical_notes' => 'nullable|string|max:1000',
                'medical_clearance' => 'required|accepted',
            ],
            5 => [ // Workout Preferences
                'preferred_workout_time' => 'nullable|date_format:H:i',
                'preferred_workout_types' => 'required|array|min:1',
                'preferred_workout_types.*' => 'in:strength,cardio,flexibility,sports,weight_loss,muscle_gain,endurance,general_fitness',
            ],
            6 => [ // Equipment Access
                'equipment_access' => 'required|array|min:1',
                'equipment_access.*' => 'in:dumbbells,barbell,resistance_bands,bodyweight,kettlebell,pull_up_bar,yoga_mat,treadmill,stationary_bike,rowing_machine,none',
            ],
            7 => [ // Emergency Contact
                'emergency_contact_name' => 'required|string|max:255',
                'emergency_contact_phone' => 'required|string|max:20',
                'emergency_contact_relationship' => 'required|string|max:100',
            ],
            default => [],
        };
        
        return $request->validate($rules);
    }
    
    /**
     * Save step data to database
     */
    private function saveStepData(ClientProfile $client, int $step, array $data): void
    {
        switch ($step) {
            case 1: // Personal Info
                $client->update([
                    'height' => $data['height'],
                    'weight' => $data['weight'],
                    'age' => $data['age'],
                    'gender' => $data['gender'],
                ]);
                break;
                
            case 2: // Fitness Level & Schedule
                $client->update([
                    'experience_level' => $data['experience_level'],
                    'fitness_history' => $data['fitness_history'] ?? null,
                    'available_days_per_week' => $data['available_days_per_week'],
                    'workout_duration_preference' => $data['workout_duration_preference'],
                ]);
                break;
                
            case 3: // Goals - Create Goal models
                // Delete existing client-set goals before creating new ones
                $client->goals()
                    ->where('type', 'client_set')
                    ->delete();
                
                // Create new goals from templates
                foreach ($data['goal_templates'] as $index => $templateKey) {
                    Goal::createFromTemplate($templateKey, $client, [
                        'priority' => $index + 1,
                    ]);
                }
                
                // Also save to deprecated field for backward compatibility
                $client->update([
                    'goals_deprecated' => $data['goal_templates'],
                ]);
                break;
                
            case 4: // Medical Screening
                $client->update([
                    'medical_conditions' => $data['medical_conditions'] ?? [],
                    'injuries' => $data['injuries'] ?? [],
                    'medications' => $data['medications'] ?? null,
                    'medical_notes' => $data['medical_notes'] ?? null,
                    'medical_clearance' => true, // User accepted terms
                ]);
                break;
                
            case 5: // Workout Preferences
                $client->update([
                    'preferred_workout_time' => $data['preferred_workout_time'] ?? null,
                    'preferred_workout_types' => $data['preferred_workout_types'],
                ]);
                break;
                
            case 6: // Equipment Access
                $client->update([
                    'equipment_access' => $data['equipment_access'],
                ]);
                break;
                
            case 7: // Emergency Contact
                $client->update([
                    'emergency_contact_name' => $data['emergency_contact_name'],
                    'emergency_contact_phone' => $data['emergency_contact_phone'],
                    'emergency_contact_relationship' => $data['emergency_contact_relationship'],
                ]);
                break;
        }
    }
    
    /**
     * Get step-specific data for rendering view
     */
    private function getStepData(int $step, ClientProfile $client): array
    {
        return match($step) {
            1 => [
                'title' => 'Personal Information',
                'description' => 'Help us understand your current fitness profile',
                'fields' => ['height', 'weight', 'age', 'gender'],
            ],
            2 => [
                'title' => 'Fitness Level & Schedule',
                'description' => 'Tell us about your fitness experience and availability',
                'fields' => ['experience_level', 'fitness_history', 'available_days_per_week', 'workout_duration_preference'],
            ],
            3 => [
                'title' => 'Your Goals',
                'description' => 'Select 1-3 goals you want to achieve (these help us match you with the right programs)',
                'goal_templates' => Goal::GOAL_TEMPLATES,
                'current_goals' => $client->goals()->where('type', 'client_set')->pluck('title')->toArray(),
            ],
            4 => [
                'title' => 'Medical Screening',
                'description' => 'Help us keep you safe with important health information',
                'fields' => ['medical_conditions', 'injuries', 'medications', 'medical_notes', 'medical_clearance'],
            ],
            5 => [
                'title' => 'Workout Preferences',
                'description' => 'What type of workouts do you enjoy?',
                'workout_types' => [
                    'strength' => 'Strength Training',
                    'cardio' => 'Cardiovascular Exercise',
                    'flexibility' => 'Flexibility & Stretching',
                    'sports' => 'Sports Activities',
                    'weight_loss' => 'Weight Loss Programs',
                    'muscle_gain' => 'Muscle Building',
                    'endurance' => 'Endurance Training',
                    'general_fitness' => 'General Fitness',
                ],
            ],
            6 => [
                'title' => 'Equipment Access',
                'description' => 'What equipment do you have access to?',
                'equipment_options' => [
                    'dumbbells' => 'Dumbbells',
                    'barbell' => 'Barbell',
                    'resistance_bands' => 'Resistance Bands',
                    'bodyweight' => 'Bodyweight Only',
                    'kettlebell' => 'Kettlebell',
                    'pull_up_bar' => 'Pull-up Bar',
                    'yoga_mat' => 'Yoga Mat',
                    'treadmill' => 'Treadmill',
                    'stationary_bike' => 'Stationary Bike',
                    'rowing_machine' => 'Rowing Machine',
                    'none' => 'No Equipment',
                ],
            ],
            7 => [
                'title' => 'Emergency Contact',
                'description' => 'Safety first - who should we contact in case of emergency?',
                'fields' => ['emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relationship'],
            ],
            default => [],
        };
    }
}
