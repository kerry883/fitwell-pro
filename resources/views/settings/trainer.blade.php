@extends('layouts.trainer')

@section('title', 'Settings - FitWellPro')

@section('content')
<div class="container-fluid py-4" x-data="trainerSettingsManager()">
    <!-- Toast Notifications -->
    @if(session('success'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition
         x-init="setTimeout(() => show = false, 5000)"
         class="position-fixed top-0 end-0 p-3" 
         style="z-index: 11; margin-top: 70px;">
        <div class="toast show align-items-center text-white bg-success border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="show = false"></button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-transition
         x-init="setTimeout(() => show = false, 5000)"
         class="position-fixed top-0 end-0 p-3" 
         style="z-index: 11; margin-top: 70px;">
        <div class="toast show align-items-center text-white bg-danger border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" @click="show = false"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Sidebar Navigation (Desktop) -->
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="card trainer-card border-0 shadow-lg position-sticky" style="top: 85px;">
                <div class="card-body p-0">
                    <div class="d-none d-lg-block">
                        <div class="p-4 border-bottom">
                            <h5 class="mb-0 fw-bold" style="color: var(--trainer-primary);">
                                <i class="bi bi-gear-fill me-2"></i>Settings
                            </h5>
                        </div>
                        <div class="list-group list-group-flush p-3">
                            <button @click="activeTab = 'notifications'" 
                                    :class="activeTab === 'notifications' ? 'active' : ''"
                                    class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center"
                                    style="transition: all 0.2s;">
                                <i class="bi bi-bell-fill me-3" style="font-size: 1.1rem;"></i>
                                <span class="fw-medium">Notifications</span>
                            </button>
                            
                            <button @click="activeTab = 'account'" 
                                    :class="activeTab === 'account' ? 'active' : ''"
                                    class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center"
                                    style="transition: all 0.2s;">
                                <i class="bi bi-person-fill me-3" style="font-size: 1.1rem;"></i>
                                <span class="fw-medium">Account Settings</span>
                            </button>
                            
                            <button @click="activeTab = 'privacy'" 
                                    :class="activeTab === 'privacy' ? 'active' : ''"
                                    class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center"
                                    style="transition: all 0.2s;">
                                <i class="bi bi-shield-fill-check me-3" style="font-size: 1.1rem;"></i>
                                <span class="fw-medium">Privacy & Security</span>
                            </button>
                            
                            <button @click="activeTab = 'preferences'" 
                                    :class="activeTab === 'preferences' ? 'active' : ''"
                                    class="list-group-item list-group-item-action border-0 rounded-3 mb-1 d-flex align-items-center"
                                    style="transition: all 0.2s;">
                                <i class="bi bi-sliders me-3" style="font-size: 1.1rem;"></i>
                                <span class="fw-medium">Preferences</span>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Tab Navigation -->
                    <div class="d-lg-none overflow-auto border-bottom">
                        <div class="d-flex p-3 gap-2" style="min-width: max-content;">
                            <button @click="activeTab = 'notifications'" 
                                    :class="activeTab === 'notifications' ? 'btn-success' : 'btn-outline-secondary'"
                                    class="btn btn-sm text-nowrap">
                                <i class="bi bi-bell-fill me-1"></i>Notifications
                            </button>
                            <button @click="activeTab = 'account'" 
                                    :class="activeTab === 'account' ? 'btn-success' : 'btn-outline-secondary'"
                                    class="btn btn-sm text-nowrap">
                                <i class="bi bi-person-fill me-1"></i>Account
                            </button>
                            <button @click="activeTab = 'privacy'" 
                                    :class="activeTab === 'privacy' ? 'btn-success' : 'btn-outline-secondary'"
                                    class="btn btn-sm text-nowrap">
                                <i class="bi bi-shield-fill-check me-1"></i>Privacy
                            </button>
                            <button @click="activeTab = 'preferences'" 
                                    :class="activeTab === 'preferences' ? 'btn-success' : 'btn-outline-secondary'"
                                    class="btn btn-sm text-nowrap">
                                <i class="bi bi-sliders me-1"></i>Preferences
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="col-lg-9">
            <!-- Notifications Tab -->
            <div x-show="activeTab === 'notifications'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform translate-end"
                 x-transition:enter-end="opacity-100"
                 class="card trainer-card border-0 shadow-lg">
                
                <!-- Enhanced Header with Icon and Gradient -->
                <div class="card-header border-0 position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--trainer-primary), var(--trainer-secondary)); padding: 2rem;">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-center" 
                                 style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                                <i class="bi bi-bell-fill" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-1 fw-bold">Notification Preferences</h4>
                            <p class="mb-0 opacity-90" style="font-size: 0.95rem;">Control your alerts for important client activities</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <form action="{{ route('trainer.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="list-group list-group-flush">
                            @if(isset($notificationTypes) && count($notificationTypes) > 0)
                                @foreach($notificationTypes as $type)
                                    @php
                                        $preference = $preferences[$type] ?? null;
                                        $title = ucwords(str_replace('_', ' ', $type));
                                        $icons = [
                                            'client_milestone_achieved' => 'trophy-fill',
                                            'new_client_assigned' => 'person-plus-fill',
                                            'client_sent_message' => 'chat-left-text-fill',
                                            'weekly_summary_report' => 'graph-up'
                                        ];
                                        $iconColors = [
                                            'client_milestone_achieved' => '#ffc107',
                                            'new_client_assigned' => '#17a2b8',
                                            'client_sent_message' => '#28a745',
                                            'weekly_summary_report' => '#6610f2'
                                        ];
                                        $description = [
                                            'client_milestone_achieved' => 'When a client completes a major goal or milestone.',
                                            'new_client_assigned' => 'When a new client is assigned to you by an admin.',
                                            'client_sent_message' => 'Receive an alert for new messages from any of your clients.',
                                            'weekly_summary_report' => 'A summary of your clients\' activity, delivered weekly.'
                                        ][$type] ?? 'General notification setting.';
                                    @endphp
                                    <div class="list-group-item border-0 py-4 notification-setting-item" 
                                         style="transition: all 0.2s;">
                                        <div class="row align-items-center">
                                            <div class="col-lg-7 mb-3 mb-lg-0">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="rounded-circle d-flex align-items-center justify-center" 
                                                             style="width: 48px; height: 48px; background-color: {{ $iconColors[$type] ?? '#28a745' }}20;">
                                                            <i class="bi bi-{{ $icons[$type] ?? 'bell' }}" 
                                                               style="font-size: 1.25rem; color: {{ $iconColors[$type] ?? '#28a745' }};"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-semibold">{{ $title }}</h6>
                                                        <small class="text-muted">{{ $description }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="d-flex align-items-center justify-content-lg-end gap-4">
                                                    <!-- In-App Toggle -->
                                                    <div class="d-flex flex-column align-items-center">
                                                        <small class="text-muted text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">In-App</small>
                                                        <input type="hidden" name="notifications[{{ $type }}][in_app]" value="0">
                                                        <div class="form-check form-switch m-0">
                                                            <input class="form-check-input custom-switch" 
                                                                   type="checkbox" 
                                                                   role="switch" 
                                                                   :id="'in_app_{{ $type }}'"
                                                                   :checked="settings['{{ $type }}'].in_app"
                                                                   @change="toggleSetting('{{ $type }}', 'in_app')"
                                                                   style="width: 3.5em; height: 1.75em; cursor: pointer;">
                                                            <input type="hidden" 
                                                                   :name="'notifications[{{ $type }}][in_app]'" 
                                                                   :value="settings['{{ $type }}'].in_app ? '1' : '0'">
                                                        </div>
                                                    </div>
                                                    <!-- Email Toggle -->
                                                    <div class="d-flex flex-column align-items-center">
                                                        <small class="text-muted text-uppercase mb-2" style="font-size: 0.7rem; letter-spacing: 0.5px; font-weight: 600;">Email</small>
                                                        <input type="hidden" name="notifications[{{ $type }}][email]" value="0">
                                                        <div class="form-check form-switch m-0">
                                                            <input class="form-check-input custom-switch" 
                                                                   type="checkbox" 
                                                                   role="switch" 
                                                                   :id="'email_{{ $type }}'"
                                                                   :checked="settings['{{ $type }}'].email"
                                                                   @change="toggleSetting('{{ $type }}', 'email')"
                                                                   style="width: 3.5em; height: 1.75em; cursor: pointer;">
                                                            <input type="hidden" 
                                                                   :name="'notifications[{{ $type }}][email]'" 
                                                                   :value="settings['{{ $type }}'].email ? '1' : '0'">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-5">
                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3 mb-0">No notification settings available.</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer bg-white border-0 py-4">
                            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                                <button type="button" 
                                        @click="resetToDefaults"
                                        class="btn btn-outline-secondary order-2 order-sm-1">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                                    Reset to Defaults
                                </button>
                                <button type="submit" 
                                        class="btn trainer-btn-primary order-1 order-sm-2"
                                        style="min-width: 150px;">
                                    <i class="bi bi-check-lg me-2"></i>
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Account Tab -->
            <div x-show="activeTab === 'account'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="card trainer-card border-0 shadow-lg">
                
                <div class="card-header border-0" style="background: linear-gradient(135deg, #007bff, #0056b3); padding: 2rem;">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-center" 
                                 style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-person-fill" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-1 fw-bold">Account Settings</h4>
                            <p class="mb-0 opacity-90">Manage your account information</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="bi bi-tools text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-4 text-muted">Coming Soon</h5>
                        <p class="text-muted">Account settings will be available here.</p>
                    </div>
                </div>
            </div>

            <!-- Privacy Tab -->
            <div x-show="activeTab === 'privacy'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="card trainer-card border-0 shadow-lg">
                
                <div class="card-header border-0" style="background: linear-gradient(135deg, #6f42c1, #563d7c); padding: 2rem;">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-center" 
                                 style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-shield-fill-check" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-1 fw-bold">Privacy & Security</h4>
                            <p class="mb-0 opacity-90">Control your privacy settings</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="bi bi-lock-fill text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-4 text-muted">Coming Soon</h5>
                        <p class="text-muted">Privacy & security settings will be available here.</p>
                    </div>
                </div>
            </div>

            <!-- Preferences Tab -->
            <div x-show="activeTab === 'preferences'" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 class="card trainer-card border-0 shadow-lg">
                
                <div class="card-header border-0" style="background: linear-gradient(135deg, #fd7e14, #dc6502); padding: 2rem;">
                    <div class="d-flex align-items-center text-white">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-center" 
                                 style="width: 60px; height: 60px; background: rgba(255,255,255,0.2);">
                                <i class="bi bi-sliders" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                        <div class="ms-3">
                            <h4 class="mb-1 fw-bold">App Preferences</h4>
                            <p class="mb-0 opacity-90">Customize your experience</p>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="bi bi-gear-fill text-muted" style="font-size: 3rem;"></i>
                        <h5 class="mt-4 text-muted">Coming Soon</h5>
                        <p class="text-muted">App preferences will be available here.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .custom-switch:checked {
        background-color: var(--trainer-primary) !important;
        border-color: var(--trainer-primary) !important;
    }
    
    .custom-switch:focus {
        border-color: var(--trainer-primary) !important;
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25) !important;
    }
    
    .notification-setting-item:hover {
        background-color: #f8f9fa !important;
        transform: translateX(2px);
    }
    
    .toast {
        min-width: 300px;
    }
    
    /* Smooth transitions for switches */
    .form-check-input {
        transition: background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    /* Tab Navigation Active State */
    .list-group-item.active {
        background-color: var(--trainer-primary) !important;
        color: white !important;
        border-left: 4px solid var(--trainer-secondary) !important;
    }
    
    .list-group-item:not(.active):hover {
        background-color: #f8f9fa;
        border-left: 4px solid #dee2e6 !important;
    }
    
    .list-group-item {
        border-left: 4px solid transparent;
        cursor: pointer;
    }
    
    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .notification-setting-item {
            padding: 1.5rem 1rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function trainerSettingsManager() {
        return {
            activeTab: 'notifications',
            settings: {
                @foreach($notificationTypes as $type)
                    '{{ $type }}': {
                        in_app: {{ ($preferences[$type] ?? null) && $preferences[$type]->in_app ? 'true' : 'false' }},
                        email: {{ ($preferences[$type] ?? null) && $preferences[$type]->email ? 'true' : 'false' }}
                    },
                @endforeach
            },
            toggleSetting(type, channel) {
                this.settings[type][channel] = !this.settings[type][channel];
            },
            resetToDefaults() {
                if (confirm('Are you sure you want to reset all settings to defaults? (In-App: ON, Email: OFF)')) {
                    Object.keys(this.settings).forEach(type => {
                        this.settings[type].in_app = true;
                        this.settings[type].email = false;
                    });
                }
            }
        }
    }
</script>
@endpush
