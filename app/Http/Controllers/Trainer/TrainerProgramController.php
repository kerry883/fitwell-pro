<?php

namespace App\Http\Controllers\Trainer;

use App\Enums\FitnessProgramSubtype;
use App\Enums\NutritionProgramSubtype;
use App\Enums\ProgramCategory;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TrainerProgramController extends Controller
{
    /**
     * Display all trainer programs
     */
    public function index()
    {
        $trainer = Auth::user()->trainerProfile;
        $programs = Program::byTrainer($trainer->id)
            ->with('assignments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('trainer.programs.index', compact('programs'));
    }

    /**
     * Show program creation form
     */
    public function create()
    {
        return view('trainer.programs.create', [
            'fitnessSubtypes' => FitnessProgramSubtype::cases(),
            'nutritionSubtypes' => NutritionProgramSubtype::cases(),
            'programCategories' => ProgramCategory::cases(),
        ]);
    }

    /**
     * Store a new program
     */
    public function store(Request $request)
    {
        // Base validation rules
        $rules = [
            'program_category' => 'required|in:fitness,nutrition',
            'program_subtype' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'goals' => 'nullable|array',
            'is_public' => 'nullable|boolean',
            'max_clients' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ];

        // Conditional validation based on program_category
        if ($request->program_category === 'fitness') {
            $rules['sessions_per_week'] = 'required|integer|min:1|max:7';
            $rules['equipment_required'] = 'nullable|array';
        } else {
            $rules['meals_per_day'] = 'required|integer|min:1|max:8';
            $rules['dietary_preferences'] = 'nullable|array';
            $rules['calorie_target'] = 'nullable|integer|min:500';
            $rules['macros_target'] = 'nullable|array';
            $rules['macros_target.protein'] = 'nullable|integer|min:0';
            $rules['macros_target.carbs'] = 'nullable|integer|min:0';
            $rules['macros_target.fats'] = 'nullable|integer|min:0';
            $rules['includes_meal_prep'] = 'nullable|boolean';
            $rules['includes_shopping_list'] = 'nullable|boolean';
        }

        $validated = $request->validate($rules);

        $trainer = Auth::user()->trainerProfile;

        // Create program in a transaction
        $program = DB::transaction(function () use ($validated, $request, $trainer) {
            $program = Program::create([
                'trainer_id' => $trainer->id,
                'program_category' => $validated['program_category'],
                'program_subtype' => $validated['program_subtype'],
                'name' => $validated['name'],
                'description' => $validated['description'],
                'duration_weeks' => $validated['duration_weeks'],
                'difficulty_level' => $validated['difficulty_level'],
                'sessions_per_week' => $validated['sessions_per_week'] ?? null,
                'meals_per_day' => $validated['meals_per_day'] ?? null,
                'goals' => $validated['goals'] ?? null,
                'dietary_preferences' => $validated['dietary_preferences'] ?? null,
                'macros_target' => $validated['macros_target'] ?? null,
                'calorie_target' => $validated['calorie_target'] ?? null,
                'equipment_required' => $validated['equipment_required'] ?? null,
                'includes_meal_prep' => $request->boolean('includes_meal_prep'),
                'includes_shopping_list' => $request->boolean('includes_shopping_list'),
                'is_public' => $request->boolean('is_public'),
                'max_clients' => $validated['max_clients'] ?? null,
                'price' => $validated['price'] ?? null,
                'notes' => $validated['notes'] ?? null,
                'status' => 'draft',
            ]);

            // If nutrition program, create initial nutrition plan
            if ($program->isNutritionProgram()) {
                $program->nutritionPlan()->create([
                    'name' => $program->name . ' - Nutrition Plan',
                    'description' => $program->description,
                    'total_calories' => $validated['calorie_target'] ?? null,
                    'macros' => $validated['macros_target'] ?? [],
                ]);
            }

            return $program;
        });

        $message = $program->isNutritionProgram() 
            ? 'Nutrition program created successfully! Add meals to complete the nutrition plan.'
            : 'Fitness program created successfully! Add workouts to complete the program.';

        return redirect()->route('trainer.programs.show', $program->id)
            ->with('success', $message);
    }

    /**
     * Show individual program
     */
    public function show($id)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)
            ->with(['assignments.user', 'assignments.client', 'workouts', 'nutritionPlan.meals'])
            ->findOrFail($id);

        $assignedClients = $program->assignments->map(function ($assignment) {
            return [
                'name' => $assignment->full_name,
                'startDate' => $assignment->start_date ? $assignment->start_date->format('Y-m-d') : $assignment->assigned_date->format('Y-m-d'),
                'progress' => $assignment->progress_percentage,
                'status' => $assignment->status,
                'current_week' => $assignment->current_week,
            ];
        });

        return view('trainer.programs.show', compact('program', 'assignedClients'));
    }

    /**
     * Show program edit form
     */
    public function edit($id)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($id);

        return view('trainer.programs.edit', [
            'program' => $program,
            'fitnessSubtypes' => FitnessProgramSubtype::cases(),
            'nutritionSubtypes' => NutritionProgramSubtype::cases(),
            'programCategories' => ProgramCategory::cases(),
        ]);
    }

    /**
     * Update program
     */
    public function update(Request $request, $id)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($id);

        // Base validation rules
        $rules = [
            'program_category' => 'required|in:fitness,nutrition',
            'program_subtype' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'goals' => 'nullable|array',
            'is_public' => 'nullable|boolean',
            'max_clients' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
        ];

        // Conditional validation based on program_category
        if ($request->program_category === 'fitness') {
            $rules['sessions_per_week'] = 'required|integer|min:1|max:7';
            $rules['equipment_required'] = 'nullable|array';
        } else {
            $rules['meals_per_day'] = 'required|integer|min:1|max:8';
            $rules['dietary_preferences'] = 'nullable|array';
            $rules['calorie_target'] = 'nullable|integer|min:500';
            $rules['macros_target'] = 'nullable|array';
            $rules['includes_meal_prep'] = 'nullable|boolean';
            $rules['includes_shopping_list'] = 'nullable|boolean';
        }

        $validated = $request->validate($rules);

        $program->update([
            'program_category' => $validated['program_category'],
            'program_subtype' => $validated['program_subtype'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'duration_weeks' => $validated['duration_weeks'],
            'difficulty_level' => $validated['difficulty_level'],
            'sessions_per_week' => $validated['sessions_per_week'] ?? null,
            'meals_per_day' => $validated['meals_per_day'] ?? null,
            'goals' => $validated['goals'] ?? null,
            'dietary_preferences' => $validated['dietary_preferences'] ?? null,
            'macros_target' => $validated['macros_target'] ?? null,
            'calorie_target' => $validated['calorie_target'] ?? null,
            'equipment_required' => $validated['equipment_required'] ?? null,
            'includes_meal_prep' => $request->boolean('includes_meal_prep'),
            'includes_shopping_list' => $request->boolean('includes_shopping_list'),
            'is_public' => $request->boolean('is_public'),
            'max_clients' => $validated['max_clients'] ?? null,
            'price' => $validated['price'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('trainer.programs.show', $id)
            ->with('success', 'Program updated successfully!');
    }

    /**
     * Delete program
     */
    public function destroy($id)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($id);

        // Check if program has active assignments
        if ($program->assignments()->where('status', 'active')->exists()) {
            return redirect()->route('trainer.programs.index')
                ->with('error', 'Cannot delete program with active client assignments.');
        }

        $program->delete();

        return redirect()->route('trainer.programs.index')
            ->with('success', 'Program deleted successfully!');
    }

    /**
     * Show workout creation form for a program
     */
    public function createWorkout($programId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        return view('trainer.programs.workouts.create', compact('program'));
    }

    /**
     * Store a new workout for a program
     */
    public function storeWorkout(Request $request, $programId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:strength,cardio,flexibility,sports,other',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'duration_minutes' => 'nullable|integer|min:1',
            'calories_burned' => 'nullable|integer|min:0',
            'met_value' => 'nullable|numeric|min:0|max:25',
            'workout_date' => 'required|date',
            'week_number' => 'required|integer|min:1',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);

        // Set default MET value if not provided
        $metValue = $request->met_value ?? Workout::getDefaultMetValues()[$request->type] ?? 4.0;

        Workout::create([
            'user_id' => $trainer->user_id, // Trainer's user ID
            'program_id' => $program->id,
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'difficulty' => $request->difficulty,
            'duration_minutes' => $request->duration_minutes,
            'calories_burned' => $request->calories_burned,
            'met_value' => $metValue,
            'workout_date' => $request->workout_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'planned',
            'week_number' => $request->week_number,
            'notes' => $request->notes,
        ]);

        return redirect()->route('trainer.programs.show', $program->id)
            ->with('success', 'Workout added to program successfully!');
    }

    /**
     * Show workout edit form
     */
    public function editWorkout($programId, $workoutId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);
        $workout = Workout::where('program_id', $program->id)
            ->where('user_id', $trainer->user_id)
            ->findOrFail($workoutId);

        return view('trainer.programs.workouts.edit', compact('program', 'workout'));
    }

    /**
     * Update workout
     */
    public function updateWorkout(Request $request, $programId, $workoutId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:strength,cardio,flexibility,sports,other',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'duration_minutes' => 'nullable|integer|min:1',
            'calories_burned' => 'nullable|integer|min:0',
            'met_value' => 'nullable|numeric|min:0|max:25',
            'workout_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i',
            'status' => 'required|in:planned,in_progress,completed,skipped',
            'week_number' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);
        $workout = Workout::where('program_id', $program->id)
            ->where('user_id', $trainer->user_id)
            ->findOrFail($workoutId);

        $workout->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'difficulty' => $request->difficulty,
            'duration_minutes' => $request->duration_minutes,
            'calories_burned' => $request->calories_burned,
            'met_value' => $request->met_value ?? $workout->met_value,
            'workout_date' => $request->workout_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
            'week_number' => $request->week_number,
            'notes' => $request->notes,
        ]);

        return redirect()->route('trainer.programs.show', $program->id)
            ->with('success', 'Workout updated successfully!');
    }

    /**
     * Delete workout from program
     */
    public function destroyWorkout($programId, $workoutId)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($programId);
        $workout = Workout::where('program_id', $program->id)
            ->where('user_id', $trainer->user_id)
            ->findOrFail($workoutId);

        $workout->delete();

        return redirect()->route('trainer.programs.show', $program->id)
            ->with('success', 'Workout deleted successfully!');
    }
}
