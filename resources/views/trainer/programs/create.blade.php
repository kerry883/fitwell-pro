@extends('layouts.trainer')

@section('title', 'Create New Program')
@section('page-title', 'Create New Program')
@section('page-subtitle', 'Design a custom fitness or nutrition program for your clients')

@section('content')
<div class="row g-4" x-data="programCreator()">
    <div class="col-12">
        <a href="{{ route('trainer.programs.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Programs
        </a>
    </div>

    <div class="col-12">
        <form method="POST" action="{{ route('trainer.programs.store') }}">
            @csrf
            
            <!-- Program Category Selection -->
            <div class="card trainer-card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-1-circle me-2"></i>Choose Program Type</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="radio" class="btn-check" name="program_category" id="category_fitness" value="fitness" x-model="category" required>
                            <label class="btn btn-outline-primary w-100 p-4 h-100" for="category_fitness">
                                <i class="bi bi-lightning-charge fs-1 d-block mb-2"></i>
                                <strong class="d-block fs-5">Fitness Program</strong>
                                <small class="text-muted">Workout plans, exercises, training schedules</small>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" class="btn-check" name="program_category" id="category_nutrition" value="nutrition" x-model="category" required>
                            <label class="btn btn-outline-success w-100 p-4 h-100" for="category_nutrition">
                                <i class="bi bi-egg-fried fs-1 d-block mb-2"></i>
                                <strong class="d-block fs-5">Nutrition Program</strong>
                                <small class="text-muted">Meal plans, recipes, dietary guidance</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div x-show="category" x-cloak>
                <div class="row g-4">
                    <div class="col-md-8">
                        <!-- Basic Information -->
                        <div class="card trainer-card mb-4">
                            <div class="card-header"><h5 class="mb-0"><i class="bi bi-2-circle me-2"></i>Basic Information</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Program Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name" x-model="formData.name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="program_subtype" class="form-label">Program Subtype <span class="text-danger">*</span></label>
                                        <select class="form-select" id="program_subtype" name="program_subtype" required>
                                            <option value="">Select subtype...</option>
                                            <template x-if="category === 'fitness'">
                                                <optgroup label="Fitness Programs">
                                                    @foreach($fitnessSubtypes as $subtype)
                                                    <option value="{{ $subtype->value }}">{{ $subtype->label() }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </template>
                                            <template x-if="category === 'nutrition'">
                                                <optgroup label="Nutrition Programs">
                                                    @foreach($nutritionSubtypes as $subtype)
                                                    <option value="{{ $subtype->value }}">{{ $subtype->label() }}</option>
                                                    @endforeach
                                                </optgroup>
                                            </template>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="duration_weeks" class="form-label">Duration (Weeks) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="duration_weeks" name="duration_weeks" min="1" max="52" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="difficulty_level" class="form-label">Difficulty <span class="text-danger">*</span></label>
                                        <select class="form-select" id="difficulty_level" name="difficulty_level" required>
                                            <option value="">Select...</option>
                                            <option value="beginner">Beginner</option>
                                            <option value="intermediate">Intermediate</option>
                                            <option value="advanced">Advanced</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="max_clients" class="form-label">Max Clients</label>
                                        <input type="number" class="form-control" id="max_clients_preview" name="max_clients_preview" min="1" disabled>
                                        <small class="text-muted">Set in settings below</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FITNESS FIELDS -->
                        <div x-show="category === 'fitness'" x-cloak>
                            <div class="card trainer-card mb-4">
                                <div class="card-header bg-primary text-white"><h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Fitness Details</h5></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="sessions_per_week" class="form-label">Sessions per Week <span class="text-danger">*</span></label>
                                            <select class="form-select" id="sessions_per_week" name="sessions_per_week" :required="category === 'fitness'">
                                                <option value="">Select...</option>
                                                @for($i = 1; $i <= 7; $i++)
                                                <option value="{{ $i }}">{{ $i }} session{{ $i > 1 ? 's' : '' }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Equipment Required</label>
                                            <div class="row g-2">
                                                @foreach(['Dumbbells', 'Barbell', 'Resistance Bands', 'No Equipment'] as $item)
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="equipment_required[]" value="{{ $item }}" id="eq_{{ $loop->index }}">
                                                        <label class="form-check-label" for="eq_{{ $loop->index }}">{{ $item }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- NUTRITION FIELDS -->
                        <div x-show="category === 'nutrition'" x-cloak>
                            <div class="card trainer-card mb-4">
                                <div class="card-header bg-success text-white"><h5 class="mb-0"><i class="bi bi-egg me-2"></i>Nutrition Details</h5></div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label for="meals_per_day" class="form-label">Meals per Day <span class="text-danger">*</span></label>
                                            <select class="form-select" id="meals_per_day" name="meals_per_day" :required="category === 'nutrition'">
                                                <option value="">Select...</option>
                                                @for($i = 1; $i <= 8; $i++)
                                                <option value="{{ $i }}">{{ $i }} meal{{ $i > 1 ? 's' : '' }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="calorie_target" class="form-label">Daily Calorie Target</label>
                                            <input type="number" class="form-control" id="calorie_target" name="calorie_target" min="500">
                                        </div>
                                        <div class="col-12"><h6>Macros (g/day)</h6></div>
                                        <div class="col-md-3">
                                            <label>Protein</label>
                                            <input type="number" class="form-control" name="macros_target[protein]" min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Carbs</label>
                                            <input type="number" class="form-control" name="macros_target[carbs]" min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Fats</label>
                                            <input type="number" class="form-control" name="macros_target[fats]" min="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Fiber</label>
                                            <input type="number" class="form-control" name="macros_target[fiber]" min="0">
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Dietary Preferences</label>
                                            <div class="row g-2">
                                                @foreach(['Vegetarian', 'Vegan', 'Gluten-Free', 'Dairy-Free'] as $diet)
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="dietary_preferences[]" value="{{ $diet }}" id="diet_{{ $loop->index }}">
                                                        <label class="form-check-label" for="diet_{{ $loop->index }}">{{ $diet }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="includes_meal_prep" value="1" id="includes_meal_prep">
                                                <label class="form-check-label" for="includes_meal_prep">Includes Meal Prep Guide</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" name="includes_shopping_list" value="1" id="includes_shopping_list">
                                                <label class="form-check-label" for="includes_shopping_list">Includes Shopping List</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment & Enrollment Settings -->
                        <div class="card trainer-card mb-4">
                            <div class="card-header bg-info text-white"><h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Payment & Enrollment</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_free" value="1" id="is_free" x-model="formData.is_free">
                                            <label class="form-check-label" for="is_free">
                                                <strong>Free Program</strong>
                                                <small class="text-muted d-block">No payment required, clients activate immediately upon approval</small>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6" x-show="!formData.is_free">
                                        <label for="price" class="form-label">Price ($) <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="price" name="price" min="0" step="0.01" :required="!formData.is_free" value="0">
                                        <small class="text-muted">Leave as 0 for free programs</small>
                                    </div>
                                    <div class="col-md-6" x-show="!formData.is_free">
                                        <label for="payment_deadline_hours" class="form-label">Payment Deadline (Hours)</label>
                                        <input type="number" class="form-control" id="payment_deadline_hours" name="payment_deadline_hours" min="1" max="168" value="48">
                                        <small class="text-muted">Time clients have to complete payment (default: 48h)</small>
                                    </div>
                                    <div class="col-md-6" x-show="!formData.is_free">
                                        <label for="refund_policy_days" class="form-label">Refund Policy (Days)</label>
                                        <input type="number" class="form-control" id="refund_policy_days" name="refund_policy_days" min="0" max="30" value="7">
                                        <small class="text-muted">Money-back guarantee period (default: 7 days)</small>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="requires_approval" value="1" id="requires_approval" checked>
                                            <label class="form-check-label" for="requires_approval">
                                                <strong>Requires Trainer Approval</strong>
                                                <small class="text-muted d-block">Review client suitability before activation/payment</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- General Settings -->
                        <div class="card trainer-card mb-4">
                            <div class="card-header"><h5 class="mb-0"><i class="bi bi-gear me-2"></i>General Settings</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="draft">Draft (Hidden from clients)</option>
                                            <option value="published" selected>Published (Visible to clients)</option>
                                            <option value="archived">Archived (Inactive)</option>
                                        </select>
                                        <small class="text-muted">Only published programs are visible to clients</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="max_clients" class="form-label">Max Clients</label>
                                        <input type="number" class="form-control" id="max_clients" name="max_clients" min="1">
                                        <small class="text-muted">Maximum concurrent enrollments</small>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check form-switch mt-4">
                                            <input class="form-check-input" type="checkbox" name="is_public" value="1" id="is_public" checked>
                                            <label class="form-check-label" for="is_public">
                                                <strong>Make Public</strong>
                                                <small class="text-muted d-block">Allow clients to discover and enroll</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="card trainer-card">
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn trainer-btn-primary btn-lg"><i class="bi bi-check-circle me-2"></i>Create Program</button>
                                    <a href="{{ route('trainer.programs.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-circle me-2"></i>Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Sidebar -->
                    <div class="col-md-4">
                        <div class="card trainer-card sticky-top" style="top: 20px;">
                            <div class="card-header"><h6 class="mb-0"><i class="bi bi-eye me-2"></i>Preview</h6></div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-center rounded-circle mb-2" :class="category === 'fitness' ? 'bg-primary' : 'bg-success'" style="width: 64px; height: 64px;">
                                        <i class="bi fs-2 text-white" :class="category === 'fitness' ? 'bi-lightning-charge' : 'bi-egg-fried'"></i>
                                    </div>
                                    <h5 class="mb-0" x-text="formData.name || 'Program Name'"></h5>
                                    <small class="text-muted" x-text="category === 'fitness' ? 'Fitness Program' : 'Nutrition Program'"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function programCreator() {
    return {
        category: null,
        formData: { 
            name: '',
            is_free: false
        },
        init() {}
    }
}
</script>
@endpush
