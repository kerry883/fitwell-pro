<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return view('trainer.programs.create');
    }
    
    /**
     * Store a new program
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'program_type' => 'required|string',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'goals' => 'nullable|array',
            'equipment_required' => 'nullable|array',
            'is_public' => 'nullable|boolean',
            'max_clients' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $trainer = Auth::user()->trainerProfile;

        $program = Program::create([
            'trainer_id' => $trainer->id,
            'name' => $request->name,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'difficulty_level' => $request->difficulty_level,
            'program_type' => $request->program_type,
            'sessions_per_week' => $request->sessions_per_week,
            'goals' => $request->goals,
            'equipment_required' => $request->equipment_required,
            'is_public' => $request->boolean('is_public'),
            'max_clients' => $request->max_clients,
            'price' => $request->price,
            'notes' => $request->notes,
            'status' => 'draft', // Programs start as draft
        ]);

        return redirect()->route('trainer.programs.index')
            ->with('success', 'Program created successfully!');
    }
    
    /**
     * Show individual program
     */
    public function show($id)
    {
        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)
            ->with(['assignments.user', 'assignments.client'])
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

        return view('trainer.programs.edit', compact('program'));
    }
    
    /**
     * Update program
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_weeks' => 'required|integer|min:1|max:52',
            'difficulty_level' => 'required|in:beginner,intermediate,advanced',
            'program_type' => 'required|string',
            'sessions_per_week' => 'required|integer|min:1|max:7',
            'goals' => 'nullable|array',
            'equipment_required' => 'nullable|array',
            'is_public' => 'nullable|boolean',
            'max_clients' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,published,archived',
        ]);

        $trainer = Auth::user()->trainerProfile;
        $program = Program::byTrainer($trainer->id)->findOrFail($id);

        $program->update([
            'name' => $request->name,
            'description' => $request->description,
            'duration_weeks' => $request->duration_weeks,
            'difficulty_level' => $request->difficulty_level,
            'program_type' => $request->program_type,
            'sessions_per_week' => $request->sessions_per_week,
            'goals' => $request->goals,
            'equipment_required' => $request->equipment_required,
            'is_public' => $request->boolean('is_public'),
            'max_clients' => $request->max_clients,
            'price' => $request->price,
            'notes' => $request->notes,
            'status' => $request->status,
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
    

}