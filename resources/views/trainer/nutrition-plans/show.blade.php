@extends('layouts.trainer')

@section('title', $program->name . ' - Nutrition Plan')
@section('page-title', $program->name)
@section('page-subtitle', 'Manage Meal Plans and Nutrition Details')

@section('content')
<div class="row g-4" x-data="nutritionPlanManager()">
    <!-- Back Button -->
    <div class="col-12">
        <a href="{{ route('trainer.programs.show', $program->id) }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Program
        </a>
    </div>

    <!-- Nutrition Plan Summary -->
    <div class="col-12">
        <div class="card trainer-card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-egg-fried me-2"></i>Nutrition Plan Details</h5>
            </div>
            <div class="card-body">
                @if($program->nutritionPlan)
                <div class="row g-3">
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 mb-0 text-success">{{ $program->calorie_target ?? 'Not set' }}</div>
                            <small class="text-muted">Daily Calories</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 mb-0 text-success">{{ $program->meals_per_day }}</div>
                            <small class="text-muted">Meals per Day</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 mb-0 text-success">{{ $program->nutritionPlan->meals->count() }}</div>
                            <small class="text-muted">Total Meals</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center p-3 bg-light rounded">
                            <div class="h4 mb-0 text-success">{{ $program->duration_weeks * 7 }}</div>
                            <small class="text-muted">Program Days</small>
                        </div>
                    </div>
                </div>

                @if($program->macros_target)
                <div class="mt-3">
                    <h6>Daily Macro Targets:</h6>
                    <div class="row g-2">
                        <div class="col-auto">
                            <span class="badge bg-primary">Protein: {{ $program->macros_target['protein'] ?? 0 }}g</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-warning">Carbs: {{ $program->macros_target['carbs'] ?? 0 }}g</span>
                        </div>
                        <div class="col-auto">
                            <span class="badge bg-info">Fats: {{ $program->macros_target['fats'] ?? 0 }}g</span>
                        </div>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Add Meal Button -->
    <div class="col-12">
        <button type="button" class="btn btn-success btn-lg w-100" @click="showAddMealModal = true">
            <i class="bi bi-plus-circle me-2"></i>Add New Meal
        </button>
    </div>

    <!-- Meals by Day -->
    @for($day = 1; $day <= min(7, $program->duration_weeks * 7); $day++)
    <div class="col-12">
        <div class="card trainer-card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-day me-2"></i>Day {{ $day }}</h5>
            </div>
            <div class="card-body">
                @php
                    $dayMeals = $program->nutritionPlan ? $program->nutritionPlan->getMealsByDay($day) : collect();
                @endphp
                
                @if($dayMeals->count() > 0)
                    <div class="row g-3">
                        @foreach($dayMeals as $meal)
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-1">{{ $meal->name }}</h6>
                                            <span class="badge bg-secondary">{{ $meal->getMealTypeLabel() }}</span>
                                            @if($meal->prep_time_minutes)
                                            <span class="badge bg-info ms-1"><i class="bi bi-clock"></i> {{ $meal->prep_time_minutes }} min</span>
                                            @endif
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success">{{ $meal->calories }} kcal</div>
                                            <small class="text-muted">{{ $meal->meal_time }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="text-muted">{{ $meal->getMacrosSummary() }}</small>
                                    </div>
                                    
                                    @if($meal->ingredients && count($meal->ingredients) > 0)
                                    <div class="mb-2">
                                        <small><strong><i class="bi bi-basket"></i> Ingredients:</strong> {{ count($meal->ingredients) }} items</small>
                                        <div class="small text-muted mt-1">
                                            @foreach(array_slice($meal->ingredients, 0, 3) as $ingredient)
                                            <div>• {{ $ingredient['name'] ?? 'Unknown' }} 
                                                @if(isset($ingredient['quantity']) && isset($ingredient['unit']))
                                                ({{ $ingredient['quantity'] }}{{ $ingredient['unit'] }})
                                                @endif
                                            </div>
                                            @endforeach
                                            @if(count($meal->ingredients) > 3)
                                            <div class="text-primary">+ {{ count($meal->ingredients) - 3 }} more...</div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if($meal->preparation_instructions)
                                    <div class="mb-2">
                                        <small class="text-muted"><i class="bi bi-card-text"></i> {{ Str::limit($meal->preparation_instructions, 60) }}</small>
                                    </div>
                                    @endif
                                    
                                    @if($meal->notes)
                                    <div class="mb-2">
                                        <small class="text-warning"><i class="bi bi-info-circle"></i> {{ Str::limit($meal->notes, 50) }}</small>
                                    </div>
                                    @endif
                                    
                                    <div class="btn-group btn-group-sm w-100">
                                        <button class="btn btn-outline-primary" @click="editMeal({{ $meal->id }})">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>
                                        <button class="btn btn-outline-info" @click="duplicateMeal({{ $meal->id }})">
                                            <i class="bi bi-files"></i> Duplicate
                                        </button>
                                        <form method="POST" action="{{ route('trainer.programs.meals.destroy', [$program->id, $meal->id]) }}" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this meal?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">
                        <i class="bi bi-info-circle me-2"></i>No meals added for this day yet
                    </p>
                @endif
            </div>
        </div>
    </div>
    @endfor

    <!-- Add Meal Modal -->
    <div class="modal" :class="{'show d-block': showAddMealModal}" x-show="showAddMealModal" x-cloak>
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form method="POST" action="{{ route('trainer.programs.meals.store', $program->id) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Meal</h5>
                        <button type="button" class="btn-close" @click="showAddMealModal = false"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Basic Information -->
                            <div class="col-12"><h6 class="text-primary mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h6><hr></div>
                            
                            <div class="col-md-6">
                                <label for="meal_name" class="form-label">Meal Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="meal_name" name="name" placeholder="e.g., Protein-Packed Breakfast Bowl" required>
                            </div>
                            <div class="col-md-3">
                                <label for="day_number" class="form-label">Day <span class="text-danger">*</span></label>
                                <select class="form-select" id="day_number" name="day_number" required>
                                    @for($d = 1; $d <= $program->duration_weeks * 7; $d++)
                                    <option value="{{ $d }}">Day {{ $d }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="meal_time" class="form-label">Time</label>
                                <input type="time" class="form-control" id="meal_time" name="meal_time" value="07:00">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="meal_type" class="form-label">Meal Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="meal_type" name="meal_type" required>
                                    <option value="breakfast">Breakfast</option>
                                    <option value="morning_snack">Morning Snack</option>
                                    <option value="lunch">Lunch</option>
                                    <option value="afternoon_snack">Afternoon Snack</option>
                                    <option value="dinner">Dinner</option>
                                    <option value="evening_snack">Evening Snack</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="calories" class="form-label">Calories <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="calories" name="calories" min="0" placeholder="e.g., 450" required>
                            </div>
                            <div class="col-md-3">
                                <label for="prep_time_minutes" class="form-label">Prep Time (min)</label>
                                <input type="number" class="form-control" id="prep_time_minutes" name="prep_time_minutes" min="0" placeholder="e.g., 15">
                            </div>
                            
                            <!-- Macronutrients -->
                            <div class="col-12 mt-3"><h6 class="text-primary mb-0"><i class="bi bi-pie-chart me-2"></i>Macronutrients (grams)</h6><hr></div>
                            
                            <div class="col-md-3">
                                <label for="protein" class="form-label">Protein <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="protein" name="macros[protein]" min="0" step="0.1" placeholder="e.g., 30" required>
                            </div>
                            <div class="col-md-3">
                                <label for="carbs" class="form-label">Carbs <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="carbs" name="macros[carbs]" min="0" step="0.1" placeholder="e.g., 45" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fats" class="form-label">Fats <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="fats" name="macros[fats]" min="0" step="0.1" placeholder="e.g., 15" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fiber" class="form-label">Fiber</label>
                                <input type="number" class="form-control" id="fiber" name="macros[fiber]" min="0" step="0.1" placeholder="e.g., 8">
                            </div>
                            
                            <!-- Ingredients -->
                            <div class="col-12 mt-3">
                                <h6 class="text-primary mb-2"><i class="bi bi-basket me-2"></i>Ingredients (Optional)</h6>
                                <hr>
                            </div>
                            
                            <div class="col-12" x-data="{ ingredients: [{ name: '', quantity: '', unit: 'g' }] }">
                                <template x-for="(ingredient, index) in ingredients" :key="index">
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-5">
                                            <input type="text" 
                                                   class="form-control form-control-sm" 
                                                   :name="'ingredients[' + index + '][name]'" 
                                                   x-model="ingredient.name"
                                                   placeholder="Ingredient name (e.g., Chicken breast)">
                                        </div>
                                        <div class="col-md-3">
                                            <input type="number" 
                                                   class="form-control form-control-sm" 
                                                   :name="'ingredients[' + index + '][quantity]'" 
                                                   x-model="ingredient.quantity"
                                                   step="0.1"
                                                   placeholder="Quantity">
                                        </div>
                                        <div class="col-md-2">
                                            <select class="form-select form-select-sm" 
                                                    :name="'ingredients[' + index + '][unit]'"
                                                    x-model="ingredient.unit">
                                                <option value="g">g</option>
                                                <option value="kg">kg</option>
                                                <option value="ml">ml</option>
                                                <option value="l">L</option>
                                                <option value="cup">cup</option>
                                                <option value="tbsp">tbsp</option>
                                                <option value="tsp">tsp</option>
                                                <option value="oz">oz</option>
                                                <option value="lb">lb</option>
                                                <option value="piece">piece</option>
                                                <option value="whole">whole</option>
                                                <option value="slice">slice</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger w-100" 
                                                    @click="ingredients.splice(index, 1)"
                                                    x-show="ingredients.length > 1">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </template>
                                <button type="button" 
                                        class="btn btn-sm btn-outline-success" 
                                        @click="ingredients.push({ name: '', quantity: '', unit: 'g' })">
                                    <i class="bi bi-plus-circle me-1"></i>Add Ingredient
                                </button>
                            </div>
                            
                            <!-- Preparation Instructions -->
                            <div class="col-12 mt-3"><h6 class="text-primary mb-0"><i class="bi bi-card-text me-2"></i>Instructions & Notes</h6><hr></div>
                            
                            <div class="col-12">
                                <label for="preparation_instructions" class="form-label">Preparation Instructions</label>
                                <textarea class="form-control" 
                                          id="preparation_instructions" 
                                          name="preparation_instructions" 
                                          rows="4"
                                          placeholder="Step-by-step cooking instructions...&#10;1. Heat pan on medium heat&#10;2. Add ingredients&#10;3. Cook for 10 minutes"></textarea>
                            </div>
                            
                            <div class="col-12">
                                <label for="notes" class="form-label">Additional Notes</label>
                                <textarea class="form-control" 
                                          id="notes" 
                                          name="notes" 
                                          rows="2"
                                          placeholder="Any special notes, dietary warnings, or tips..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="showAddMealModal = false">Cancel</button>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Add Meal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-backdrop" :class="{'show': showAddMealModal}" x-show="showAddMealModal" x-cloak></div>
</div>
@endsection

@push('scripts')
<script>
function nutritionPlanManager() {
    return {
        showAddMealModal: false,
        editMeal(id) {
            alert('Edit meal functionality - ID: ' + id);
        },
        duplicateMeal(id) {
            if(confirm('Duplicate this meal to another day?')) {
                const day = prompt('Enter day number to duplicate to:');
                if(day) {
                    // Submit duplicate form
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/trainer/programs/{{ $program->id }}/meals/${id}/duplicate`;
                    form.innerHTML = '@csrf<input type="hidden" name="day_number" value="' + day + '">';
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        }
    }
}
</script>
@endpush
