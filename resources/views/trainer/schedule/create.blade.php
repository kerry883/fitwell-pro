@extends('layouts.trainer')

@section('title', 'Schedule New Session')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Schedule New Session</h4>
            <p class="text-muted mb-0">Create a new training session for your client</p>
        </div>
        <a href="{{ route('trainer.schedule.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Schedule
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">Session Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('trainer.schedule.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="client_id" class="form-label">Select Client *</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" id="client_id" name="client_id" required>
                                    <option value="">Choose a client...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client['id'] }}" {{ old('client_id') == $client['id'] ? 'selected' : '' }}>
                                            {{ $client['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="session_type" class="form-label">Session Type *</label>
                                <select class="form-select @error('session_type') is-invalid @enderror" id="session_type" name="session_type" required>
                                    <option value="">Select session type...</option>
                                    <option value="Personal Training" {{ old('session_type') == 'Personal Training' ? 'selected' : '' }}>Personal Training</option>
                                    <option value="Strength Training" {{ old('session_type') == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                                    <option value="Cardio Session" {{ old('session_type') == 'Cardio Session' ? 'selected' : '' }}>Cardio Session</option>
                                    <option value="HIIT Training" {{ old('session_type') == 'HIIT Training' ? 'selected' : '' }}>HIIT Training</option>
                                    <option value="Functional Training" {{ old('session_type') == 'Functional Training' ? 'selected' : '' }}>Functional Training</option>
                                    <option value="Powerlifting" {{ old('session_type') == 'Powerlifting' ? 'selected' : '' }}>Powerlifting</option>
                                    <option value="Yoga & Flexibility" {{ old('session_type') == 'Yoga & Flexibility' ? 'selected' : '' }}>Yoga & Flexibility</option>
                                    <option value="Sports Conditioning" {{ old('session_type') == 'Sports Conditioning' ? 'selected' : '' }}>Sports Conditioning</option>
                                </select>
                                @error('session_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="session_date" class="form-label">Session Date *</label>
                                <input type="date" class="form-control @error('session_date') is-invalid @enderror" 
                                       id="session_date" name="session_date" 
                                       value="{{ old('session_date', date('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d') }}" required>
                                @error('session_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="start_time" class="form-label">Start Time *</label>
                                <select class="form-select @error('start_time') is-invalid @enderror" id="start_time" name="start_time" required>
                                    <option value="">Select time...</option>
                                    @foreach($timeSlots as $slot)
                                        <option value="{{ $slot }}" {{ old('start_time') == $slot ? 'selected' : '' }}>
                                            {{ date('g:i A', strtotime($slot)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('start_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="end_time" class="form-label">End Time *</label>
                                <select class="form-select @error('end_time') is-invalid @enderror" id="end_time" name="end_time" required>
                                    <option value="">Select time...</option>
                                    @foreach($timeSlots as $slot)
                                        <option value="{{ $slot }}" {{ old('end_time') == $slot ? 'selected' : '' }}>
                                            {{ date('g:i A', strtotime($slot)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('end_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="location" class="form-label">Training Location *</label>
                                <select class="form-select @error('location') is-invalid @enderror" id="location" name="location" required>
                                    <option value="">Select location...</option>
                                    <option value="Home Studio" {{ old('location') == 'Home Studio' ? 'selected' : '' }}>Home Studio</option>
                                    <option value="Client's Home" {{ old('location') == "Client's Home" ? 'selected' : '' }}>Client's Home</option>
                                    <option value="Local Gym" {{ old('location') == 'Local Gym' ? 'selected' : '' }}>Local Gym</option>
                                    <option value="Outdoor Training" {{ old('location') == 'Outdoor Training' ? 'selected' : '' }}>Outdoor Training</option>
                                    <option value="Virtual Session" {{ old('location') == 'Virtual Session' ? 'selected' : '' }}>Virtual Session</option>
                                </select>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Session Notes (Optional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="4" 
                                      placeholder="Add any special instructions, focus areas, or notes for this session...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Maximum 500 characters</div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-calendar-plus me-2"></i>Schedule Session
                            </button>
                            <button type="button" class="btn btn-success">
                                <i class="fas fa-repeat me-2"></i>Schedule & Repeat
                            </button>
                            <a href="{{ route('trainer.schedule.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Session Preview -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-eye text-info me-2"></i>
                        Session Preview
                    </h5>
                </div>
                <div class="card-body">
                    <div id="session-preview" class="text-muted">
                        <p>Fill out the form to see a preview of your session</p>
                    </div>
                </div>
            </div>

            <!-- Quick Tips -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Scheduling Tips
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Schedule sessions at least 24 hours in advance</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Allow 15 minutes buffer between sessions</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Include travel time for location changes</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Add specific notes for better preparation</small>
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>Confirm with client before scheduling</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const preview = document.getElementById('session-preview');
    
    function updatePreview() {
        const clientSelect = document.getElementById('client_id');
        const sessionType = document.getElementById('session_type').value;
        const sessionDate = document.getElementById('session_date').value;
        const startTime = document.getElementById('start_time').value;
        const endTime = document.getElementById('end_time').value;
        const location = document.getElementById('location').value;
        const notes = document.getElementById('notes').value;
        
        let previewHtml = '';
        
        if (clientSelect.selectedIndex > 0) {
            previewHtml += `<div class="mb-2"><strong>Client:</strong> ${clientSelect.options[clientSelect.selectedIndex].text}</div>`;
        }
        
        if (sessionType) {
            previewHtml += `<div class="mb-2"><strong>Type:</strong> ${sessionType}</div>`;
        }
        
        if (sessionDate) {
            const date = new Date(sessionDate);
            previewHtml += `<div class="mb-2"><strong>Date:</strong> ${date.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</div>`;
        }
        
        if (startTime && endTime) {
            const start = new Date(`2000-01-01 ${startTime}`);
            const end = new Date(`2000-01-01 ${endTime}`);
            const duration = Math.round((end - start) / (1000 * 60));
            previewHtml += `<div class="mb-2"><strong>Time:</strong> ${start.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })} - ${end.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' })} (${duration} min)</div>`;
        }
        
        if (location) {
            previewHtml += `<div class="mb-2"><strong>Location:</strong> ${location}</div>`;
        }
        
        if (notes) {
            previewHtml += `<div class="mb-2"><strong>Notes:</strong> <small class="text-muted">${notes.substring(0, 100)}${notes.length > 100 ? '...' : ''}</small></div>`;
        }
        
        if (previewHtml) {
            preview.innerHTML = previewHtml;
        } else {
            preview.innerHTML = '<p class="text-muted">Fill out the form to see a preview of your session</p>';
        }
    }
    
    // Add event listeners to form fields
    ['client_id', 'session_type', 'session_date', 'start_time', 'end_time', 'location', 'notes'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', updatePreview);
            element.addEventListener('input', updatePreview);
        }
    });
    
    // Update start time options based on selected date and existing sessions
    document.getElementById('session_date').addEventListener('change', function() {
        // In a real application, you would fetch unavailable slots via AJAX
        console.log('Date changed, would update available time slots');
    });
});
</script>
@endsection