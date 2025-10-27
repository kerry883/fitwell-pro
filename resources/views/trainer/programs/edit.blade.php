@extends('layouts.trainer')

@section('title', 'Edit Program: ' . $program->name)

@section('content')
    <div class="container-fluid" x-data="programEditor()">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('trainer.programs.index') }}">Programs</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('trainer.programs.show', $program->id) }}">{{ $program->name }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h1 class="h3 mb-0">Edit Program</h1>
                <p class="text-muted">Modify your program details and structure</p>
            </div>
        </div>

        <form action="{{ route('trainer.programs.update', $program->id) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <!-- Hidden field for program category -->
            <input type="hidden" name="program_category" x-model="category">

            <div class="row">
                <!-- Sidebar - Program Preview (Right Side) -->
                <div class="col-lg-4 order-lg-2">
                    <div class="card shadow-sm mb-4 position-sticky" style="top: 20px;">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Program Preview</h5>
                        </div>
                        <div class="card-body">
                            <div class="program-preview">
                                <h6 x-text="formData.name || '{{ $program->name }}'"></h6>
                                <p x-text="formData.description || '{{ $program->description }}'" class="text-muted small"></p>

                                <div class="row text-center mb-3">
                                    <div class="col-4">
                                        <div class="preview-stat">
                                            <strong x-text="formData.duration_weeks || {{ $program->duration_weeks }}"></strong>
                                            <small class="d-block text-muted">Weeks</small>
                                        </div>
                                    </div>
                                    <div class="col-4" x-show="category === 'fitness'" x-cloak>
                                        <div class="preview-stat">
                                            <strong>{{ $program->sessions_per_week ?? 3 }}</strong>
                                            <small class="d-block text-muted">Sessions/Week</small>
                                        </div>
                                    </div>
                                    <div class="col-4" x-show="category === 'nutrition'" x-cloak>
                                        <div class="preview-stat">
                                            <strong>{{ $program->meals_per_day ?? 3 }}</strong>
                                            <small class="d-block text-muted">Meals/Day</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="preview-stat">
                                            <span class="badge" :class="formData.difficulty_level === 'beginner' ? 'bg-success' : (formData.difficulty_level === 'intermediate' ? 'bg-warning' : 'bg-danger')"
                                                  x-text="formData.difficulty_level ? formData.difficulty_level.charAt(0).toUpperCase() + formData.difficulty_level.slice(1) : '{{ ucfirst($program->difficulty_level) }}'">
                                            </span>
                                            <small class="d-block text-muted">Level</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-muted">Category:</strong>
                                    <span class="ms-2">
                                        <span x-show="category === 'fitness'" class="badge bg-primary">
                                            <i class="fas fa-dumbbell me-1"></i>Fitness
                                        </span>
                                        <span x-show="category === 'nutrition'" class="badge bg-success">
                                            <i class="fas fa-utensils me-1"></i>Nutrition
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="card-footer">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Update Program
                                </button>
                                <a href="{{ route('trainer.programs.show', $program->id) }}"
                                    class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i> Cancel Changes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Form (Left Side) -->
                <div class="col-lg-8 order-lg-1">
                    <!-- Program Category (Non-editable) -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Program Category <span class="badge bg-secondary ms-2">Cannot be changed</span></h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border" :class="category === 'fitness' ? 'border-primary border-3 bg-light' : 'opacity-50'" style="cursor: not-allowed;">
                                        <div class="card-body text-center">
                                            <input type="radio" name="category_display" value="fitness" x-model="category" class="form-check-input" disabled>
                                            <i class="fas fa-dumbbell fa-3x mb-2" :class="category === 'fitness' ? 'text-primary' : 'text-muted'"></i>
                                            <h5 :class="category === 'fitness' ? '' : 'text-muted'">Fitness Program</h5>
                                            <p class="text-muted small mb-0">Workouts, exercises, training plans</p>
                                            <span x-show="category === 'fitness'" class="badge bg-primary mt-2">
                                                <i class="fas fa-check me-1"></i>Current Category
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border" :class="category === 'nutrition' ? 'border-success border-3 bg-light' : 'opacity-50'" style="cursor: not-allowed;">
                                        <div class="card-body text-center">
                                            <input type="radio" name="category_display" value="nutrition" x-model="category" class="form-check-input" disabled>
                                            <i class="fas fa-utensils fa-3x mb-2" :class="category === 'nutrition' ? 'text-success' : 'text-muted'"></i>
                                            <h5 :class="category === 'nutrition' ? '' : 'text-muted'">Nutrition Program</h5>
                                            <p class="text-muted small mb-0">Meal plans, diet guidance, nutrition goals</p>
                                            <span x-show="category === 'nutrition'" class="badge bg-success mt-2">
                                                <i class="fas fa-check me-1"></i>Current Category
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-info mt-3 mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <small>Program category cannot be changed after creation. To switch categories, please create a new program.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Basic Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Program Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="name" class="form-label">Program Name *</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        x-model="formData.name" value="{{ $program->name }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="duration_weeks" class="form-label">Duration (weeks) *</label>
                                    <input type="number" class="form-control" id="duration_weeks" name="duration_weeks"
                                        x-model="formData.duration_weeks" value="{{ $program->duration_weeks }}" min="1" max="52" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" x-model="formData.description" rows="3">{{ $program->description }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="difficulty_level" class="form-label">Difficulty Level *</label>
                                    <select class="form-select" id="difficulty_level" name="difficulty_level" x-model="formData.difficulty_level" required>
                                        <option value="beginner" {{ $program->difficulty_level === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="intermediate" {{ $program->difficulty_level === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="advanced" {{ $program->difficulty_level === 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="program_subtype" class="form-label">Program Type *</label>
                                    <select class="form-select" id="program_subtype" name="program_subtype" required>
                                        <template x-if="category === 'fitness'">
                                            <optgroup label="Fitness Programs">
                                                @foreach($fitnessSubtypes as $subtype)
                                                    <option value="{{ $subtype->value }}" {{ $program->program_subtype === $subtype->value ? 'selected' : '' }}>
                                                        {{ $subtype->label() }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </template>
                                        <template x-if="category === 'nutrition'">
                                            <optgroup label="Nutrition Programs">
                                                @foreach($nutritionSubtypes as $subtype)
                                                    <option value="{{ $subtype->value }}" {{ $program->program_subtype === $subtype->value ? 'selected' : '' }}>
                                                        {{ $subtype->label() }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </template>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="draft" {{ $program->status === 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="published" {{ $program->status === 'published' ? 'selected' : '' }}>Published</option>
                                        <option value="archived" {{ $program->status === 'archived' ? 'selected' : '' }}>Archived</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Fitness-specific fields -->
                            <div x-show="category === 'fitness'" x-cloak>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="sessions_per_week" class="form-label">Sessions per Week *</label>
                                        <select class="form-select" id="sessions_per_week" name="sessions_per_week" :required="category === 'fitness'">
                                            @for($i = 1; $i <= 7; $i++)
                                                <option value="{{ $i }}" {{ $program->sessions_per_week == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Equipment Required</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="equipment_dumbbells" name="equipment_required[]" value="Dumbbells" 
                                                {{ is_array($program->equipment_required) && in_array('Dumbbells', $program->equipment_required) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="equipment_dumbbells">Dumbbells</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="equipment_barbell" name="equipment_required[]" value="Barbell"
                                                {{ is_array($program->equipment_required) && in_array('Barbell', $program->equipment_required) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="equipment_barbell">Barbell</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Nutrition-specific fields -->
                            <div x-show="category === 'nutrition'" x-cloak>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="meals_per_day" class="form-label">Meals per Day *</label>
                                        <select class="form-select" id="meals_per_day" name="meals_per_day" :required="category === 'nutrition'">
                                            @for($i = 1; $i <= 8; $i++)
                                                <option value="{{ $i }}" {{ $program->meals_per_day == $i ? 'selected' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="calorie_target" class="form-label">Daily Calorie Target</label>
                                        <input type="number" class="form-control" id="calorie_target" name="calorie_target" 
                                            value="{{ $program->calorie_target }}" min="500" placeholder="e.g., 2500">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="includes_meal_prep" name="includes_meal_prep" value="1"
                                                {{ $program->includes_meal_prep ? 'checked' : '' }}>
                                            <label class="form-check-label" for="includes_meal_prep">Includes Meal Prep</label>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($program->macros_target)
                                <div class="row">
                                    <div class="col-12 mb-2"><label class="form-label">Daily Macro Targets (grams)</label></div>
                                    <div class="col-md-3 mb-3">
                                        <input type="number" class="form-control" name="macros_target[protein]" 
                                            value="{{ $program->macros_target['protein'] ?? '' }}" placeholder="Protein" min="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="number" class="form-control" name="macros_target[carbs]" 
                                            value="{{ $program->macros_target['carbs'] ?? '' }}" placeholder="Carbs" min="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="number" class="form-control" name="macros_target[fats]" 
                                            value="{{ $program->macros_target['fats'] ?? '' }}" placeholder="Fats" min="0">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <input type="number" class="form-control" name="macros_target[fiber]" 
                                            value="{{ $program->macros_target['fiber'] ?? '' }}" placeholder="Fiber" min="0">
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Price ($)</label>
                                    <input type="number" class="form-control" id="price" name="price" 
                                        value="{{ $program->price }}" min="0" step="0.01" placeholder="0.00">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="max_clients" class="form-label">Max Clients</label>
                                    <input type="number" class="form-control" id="max_clients" name="max_clients" 
                                        value="{{ $program->max_clients }}" min="1" placeholder="Unlimited">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_public" name="is_public"
                                        value="1" {{ $program->is_public ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_public">
                                        Make Program Public
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Goals/Objectives -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Program Goals</h5>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="addGoal()">
                                <i class="fas fa-plus me-1"></i> Add Goal
                            </button>
                        </div>
                        <div class="card-body">
                            <div id="goals-container">
                                @if ($program->goals && count($program->goals))
                                    @foreach ($program->goals as $index => $goal)
                                        <div class="goal-item mb-2">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="goals[]"
                                                    value="{{ $goal }}" placeholder="Program goal">
                                                <button type="button" class="btn btn-outline-danger"
                                                    onclick="removeGoal(this)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="goal-item mb-2">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="goals[]"
                                                placeholder="Program goal">
                                            <button type="button" class="btn btn-outline-danger"
                                                onclick="removeGoal(this)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Section: Workout Schedule OR Nutrition Plan Link -->
                    <div class="card shadow-sm mb-4">
                        <template x-if="category === 'fitness'">
                            <div>
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0"><i class="fas fa-dumbbell me-2"></i>Workout Management</h5>
                                </div>
                                <div class="card-body text-center py-4">
                                    <i class="fas fa-dumbbell fa-3x text-primary mb-3"></i>
                                    <h6>Manage Workouts</h6>
                                    <p class="text-muted">Workouts are managed separately from the program details.</p>
                                    <a href="{{ route('trainer.programs.show', $program->id) }}" class="btn btn-primary">
                                        <i class="fas fa-list me-2"></i>Go to Workout Management
                                    </a>
                                </div>
                            </div>
                        </template>
                        
                        <template x-if="category === 'nutrition'">
                            <div>
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Meal Plan Management</h5>
                                </div>
                                <div class="card-body text-center py-4">
                                    <i class="fas fa-utensils fa-3x text-success mb-3"></i>
                                    <h6>Manage Meals</h6>
                                    <p class="text-muted">Meals are managed separately from the program details.</p>
                                    @if($program->nutritionPlan)
                                        <a href="{{ route('trainer.programs.nutrition-plan.show', $program->id) }}" class="btn btn-success">
                                            <i class="fas fa-edit me-2"></i>Manage Nutrition Plan & Meals
                                        </a>
                                    @else
                                        <p class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Nutrition plan will be created when you save this program.</p>
                                    @endif
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function programEditor() {
            return {
                category: '{{ $program->program_category }}',
                formData: {
                    name: '{{ $program->name }}',
                    description: '{{ $program->description }}',
                    duration_weeks: {{ $program->duration_weeks }},
                    difficulty_level: '{{ $program->difficulty_level }}'
                }
            }
        }

        function addGoal() {
            const container = document.getElementById('goals-container');
            const goalItem = document.createElement('div');
            goalItem.className = 'goal-item mb-2';
            goalItem.innerHTML = `
                <div class="input-group">
                    <input type="text" class="form-control" name="goals[]" placeholder="Program goal">
                    <button type="button" class="btn btn-outline-danger" onclick="removeGoal(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(goalItem);
        }

        function removeGoal(button) {
            const goalItem = button.closest('.goal-item');
            const container = document.getElementById('goals-container');
            if (container.children.length > 1) {
                goalItem.remove();
            } else {
                goalItem.querySelector('input').value = '';
            }
        }
    </script>
    @endpush
@endsection
