<?php

namespace App\Services;

use App\Models\ClientProfile;
use App\Models\Program;
use Illuminate\Support\Collection;

class ProgramMatchingService
{
    /**
     * Scoring weights for different matching criteria
     */
    const WEIGHTS = [
        'goals' => 40,
        'difficulty' => 25,
        'schedule' => 20,
        'workout_types' => 10,
        'equipment' => 5,
    ];

    /**
     * Difficulty level mapping for compatibility scoring
     */
    const DIFFICULTY_LEVELS = [
        'beginner' => 1,
        'intermediate' => 2,
        'advanced' => 3,
    ];

    /**
     * Workout type compatibility mapping
     */
    const WORKOUT_TYPE_MAPPING = [
        'strength' => ['strength', 'powerlifting', 'bodybuilding'],
        'cardio' => ['cardio', 'hiit', 'running', 'cycling'],
        'flexibility' => ['flexibility', 'yoga', 'pilates'],
        'sports' => ['sports', 'athletic', 'functional'],
        'weight_loss' => ['cardio', 'hiit', 'strength'],
        'muscle_gain' => ['strength', 'powerlifting', 'bodybuilding'],
        'endurance' => ['cardio', 'running', 'cycling'],
        'general_fitness' => ['strength', 'cardio', 'flexibility'],
    ];

    /**
     * Calculate match score between a client and program
     *
     * @param ClientProfile $client
     * @param Program $program
     * @return array
     */
    public function calculateMatch(ClientProfile $client, Program $program): array
    {
        $scores = [
            'goals' => $this->calculateGoalsMatch($client, $program),
            'difficulty' => $this->calculateDifficultyMatch($client, $program),
            'schedule' => $this->calculateScheduleMatch($client, $program),
            'workout_types' => $this->calculateWorkoutTypesMatch($client, $program),
            'equipment' => $this->calculateEquipmentMatch($client, $program),
        ];

        $totalScore = $this->calculateWeightedScore($scores);

        return [
            'total_score' => round($totalScore, 1),
            'scores' => $scores,
            'recommendation' => $this->getRecommendation($totalScore),
            'warnings' => $this->getWarnings($client, $program),
            'explanations' => $this->getExplanations($scores),
        ];
    }

    /**
     * Calculate goals matching score (40% weight)
     */
    private function calculateGoalsMatch(ClientProfile $client, Program $program): float
    {
        $clientGoals = $client->goals ?? [];
        $programGoals = $program->goals ?? [];

        if (empty($clientGoals) || empty($programGoals)) {
            return 50.0; // Neutral score when goals are not specified
        }

        $matchingGoals = array_intersect($clientGoals, $programGoals);
        $matchRatio = count($matchingGoals) / count($clientGoals);

        return $matchRatio * 100;
    }

    /**
     * Calculate difficulty compatibility score (25% weight)
     */
    private function calculateDifficultyMatch(ClientProfile $client, Program $program): float
    {
        $clientLevel = self::DIFFICULTY_LEVELS[$client->experience_level] ?? 1;
        $programLevel = self::DIFFICULTY_LEVELS[$program->difficulty_level] ?? 1;

        $levelDifference = abs($clientLevel - $programLevel);

        // Perfect match
        if ($levelDifference === 0) {
            return 100.0;
        }

        // Adjacent levels (good match)
        if ($levelDifference === 1) {
            return 75.0;
        }

        // Two or more levels difference (poor match)
        return 25.0;
    }

    /**
     * Calculate schedule compatibility score (20% weight)
     */
    private function calculateScheduleMatch(ClientProfile $client, Program $program): float
    {
        $clientAvailableDays = $client->available_days_per_week ?? 3;
        $programRequiredSessions = $program->sessions_per_week ?? 3;

        if ($clientAvailableDays >= $programRequiredSessions) {
            // Perfect fit - client has enough availability
            $availabilityRatio = min($clientAvailableDays / $programRequiredSessions, 2.0); // Cap at 200%
            return min($availabilityRatio * 50, 100); // Scale to 0-100
        } else {
            // Insufficient availability - penalty but not zero
            $shortfallRatio = $clientAvailableDays / $programRequiredSessions;
            return max($shortfallRatio * 50, 10); // Minimum 10% for partial availability
        }
    }

    /**
     * Calculate workout types preference match (10% weight)
     */
    private function calculateWorkoutTypesMatch(ClientProfile $client, Program $program): float
    {
        $clientPreferences = $client->preferred_workout_types ?? [];
        $programType = strtolower($program->program_type ?? '');

        if (empty($clientPreferences)) {
            return 50.0; // Neutral when no preferences specified
        }

        // Check for exact matches first
        if (in_array($programType, $clientPreferences)) {
            return 100.0;
        }

        // Check for related workout types using mapping
        foreach ($clientPreferences as $preference) {
            $relatedTypes = self::WORKOUT_TYPE_MAPPING[strtolower($preference)] ?? [];
            if (in_array($programType, $relatedTypes)) {
                return 75.0; // Partial match for related types
            }
        }

        return 0.0; // No match
    }

    /**
     * Calculate equipment availability score (5% weight)
     */
    private function calculateEquipmentMatch(ClientProfile $client, Program $program): float
    {
        $requiredEquipment = $program->equipment_required ?? [];

        if (empty($requiredEquipment)) {
            return 100.0; // No equipment required = perfect match
        }

        // For now, assume clients have basic equipment
        // Future enhancement: Add equipment_access field to client profile
        $basicEquipment = ['dumbbells', 'barbell', 'resistance bands', 'bodyweight'];
        $clientEquipment = $client->equipment_access ?? $basicEquipment;

        $availableEquipment = array_intersect($requiredEquipment, $clientEquipment);
        $availabilityRatio = count($availableEquipment) / count($requiredEquipment);

        return $availabilityRatio * 100;
    }

    /**
     * Calculate weighted total score
     */
    private function calculateWeightedScore(array $scores): float
    {
        $totalScore = 0;

        foreach ($scores as $criterion => $score) {
            $weight = self::WEIGHTS[$criterion] ?? 0;
            $totalScore += ($score * $weight) / 100;
        }

        return $totalScore;
    }

    /**
     * Get recommendation based on total score
     */
    private function getRecommendation(float $score): string
    {
        if ($score >= 85) {
            return 'excellent';
        } elseif ($score >= 70) {
            return 'good';
        } elseif ($score >= 50) {
            return 'fair';
        } else {
            return 'poor';
        }
    }

    /**
     * Get warnings for potential issues
     */
    private function getWarnings(ClientProfile $client, Program $program): array
    {
        $warnings = [];

        // Difficulty mismatch warning
        $clientLevel = self::DIFFICULTY_LEVELS[$client->experience_level] ?? 1;
        $programLevel = self::DIFFICULTY_LEVELS[$program->difficulty_level] ?? 1;
        if (abs($clientLevel - $programLevel) >= 2) {
            $warnings[] = 'Significant difficulty level mismatch - consider your experience level';
        }

        // Schedule conflict warning
        $clientAvailableDays = $client->available_days_per_week ?? 3;
        $programRequiredSessions = $program->sessions_per_week ?? 3;
        if ($clientAvailableDays < $programRequiredSessions) {
            $warnings[] = 'Program requires more sessions than your available days per week';
        }

        // Medical condition warnings
        $medicalConditions = $client->medical_conditions ?? [];
        $injuries = $client->injuries ?? [];
        if (!empty($medicalConditions) || !empty($injuries)) {
            $warnings[] = 'Consult with a healthcare professional before starting this program';
        }

        // Equipment availability warning
        $requiredEquipment = $program->equipment_required ?? [];
        if (!empty($requiredEquipment)) {
            $warnings[] = 'Ensure you have access to all required equipment before enrolling';
        }

        return $warnings;
    }

    /**
     * Get detailed explanations for each score
     */
    private function getExplanations(array $scores): array
    {
        $explanations = [];

        foreach ($scores as $criterion => $score) {
            switch ($criterion) {
                case 'goals':
                    $explanations['goals'] = $score >= 80 ? 'Excellent goal alignment' :
                                           ($score >= 60 ? 'Good goal alignment' :
                                           'Limited goal alignment');
                    break;
                case 'difficulty':
                    $explanations['difficulty'] = $score >= 90 ? 'Perfect difficulty match' :
                                                ($score >= 70 ? 'Suitable difficulty level' :
                                                'Difficulty level may be challenging');
                    break;
                case 'schedule':
                    $explanations['schedule'] = $score >= 80 ? 'Schedule fits well' :
                                              ($score >= 50 ? 'Schedule manageable' :
                                              'Schedule may be tight');
                    break;
                case 'workout_types':
                    $explanations['workout_types'] = $score >= 80 ? 'Matches your preferences' :
                                                   ($score >= 50 ? 'Some preference alignment' :
                                                   'May not match your preferences');
                    break;
                case 'equipment':
                    $explanations['equipment'] = $score >= 80 ? 'Equipment available' :
                                               ($score >= 50 ? 'Most equipment available' :
                                               'May need additional equipment');
                    break;
            }
        }

        return $explanations;
    }

    /**
     * Sort programs by match score for a client
     */
    public function sortProgramsByMatch(ClientProfile $client, Collection $programs): Collection
    {
        return $programs->map(function ($program) use ($client) {
            $match = $this->calculateMatch($client, $program);
            $program->match_score = $match['total_score'];
            $program->match_data = $match;
            return $program;
        })->sortByDesc('match_score');
    }

    /**
     * Filter programs by minimum match score
     */
    public function filterByMinimumScore(Collection $programs, float $minScore): Collection
    {
        return $programs->filter(function ($program) use ($minScore) {
            return ($program->match_score ?? 0) >= $minScore;
        });
    }
}
