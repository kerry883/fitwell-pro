@props([
    'theme' => 'client', // 'client' or 'trainer'
    'containerClass' => '',
])

@php
    // Theme-specific configurations
    $themes = [
        'client' => [
            'buttonClass' => 'relative rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2',
            'dropdownClass' => 'absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none',
            'accentColor' => 'emerald',
            'framework' => 'tailwind',
            'badgeClass' => 'absolute -top-1 -right-1 h-5 w-5 rounded-full bg-red-500 text-xs text-white flex items-center justify-center',
            'headerClass' => 'px-4 py-2 border-b border-gray-200',
            'itemClass' => 'px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer',
            'unreadItemClass' => 'bg-blue-50',
        ],
        'trainer' => [
            'buttonClass' => 'btn btn-light btn-sm position-relative',
            'dropdownClass' => 'dropdown-menu dropdown-menu-end notification-dropdown p-0 shadow-lg border-0',
            'accentColor' => 'success',
            'framework' => 'bootstrap',
            'badgeClass' => 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger',
            'headerClass' => 'px-4 py-3 border-bottom bg-light',
            'itemClass' => 'notification-item px-4 py-3 border-bottom',
            'unreadItemClass' => 'bg-light-subtle',
        ]
    ];

    $config = $themes[$theme];
@endphp

@if($config['framework'] === 'tailwind')
    <!-- Tailwind Version (Client) -->
    <div class="relative {{ $containerClass }}" 
         x-data="notificationDropdown({ theme: '{{ $theme }}' })" 
         x-init="listenForNotifications()">
        <!-- Notification Button -->
        <button type="button"
                @click="open = !open; if(open && notifications.length === 0) loadNotifications()"
                class="{{ $config['buttonClass'] }}">
            <span class="sr-only">View notifications</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>

            <!-- Unread Badge -->
            <span x-show="unreadCount > 0"
                  x-cloak
                  x-text="unreadCount"
                  class="{{ $config['badgeClass'] }}">
            </span>
        </button>

        <!-- Dropdown Panel -->
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             @click.away="open = false"
             class="{{ $config['dropdownClass'] }}"
             role="menu">

            <!-- Header -->
            <div class="{{ $config['headerClass'] }}">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                    <button @click="markAllAsRead()"
                            class="text-xs text-{{ $config['accentColor'] }}-600 hover:text-{{ $config['accentColor'] }}-500"
                            x-show="unreadCount > 0">
                        Mark all read
                    </button>
                </div>
            </div>

            <!-- Loading State -->
            <div x-show="loading" class="px-4 py-8 text-center">
                <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-{{ $config['accentColor'] }}-500"></div>
                <p class="mt-2 text-sm text-gray-500">Loading...</p>
            </div>

            <!-- Notifications List -->
            <div class="max-h-96 overflow-y-auto" x-show="!loading">
                <template x-for="notification in notifications" :key="notification.id">
                    <div :class="{ '{{ $config['unreadItemClass'] }}': !notification.is_read }"
                         class="{{ $config['itemClass'] }}"
                         @click="markAsRead(notification.id)">
                        <div class="flex items-start space-x-3">
                            <!-- Icon (inline rendering for Alpine.js compatibility) -->
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full flex items-center justify-center"
                                     :class="{
                                        'bg-blue-100 text-blue-600': ['message', 'comment', 'session_scheduled'].includes(notification.type),
                                        'bg-green-100 text-green-600': ['workout_assigned', 'workout_completed', 'new_client', 'payment_received'].includes(notification.type),
                                        'bg-yellow-100 text-yellow-600': ['goal_achieved'].includes(notification.type),
                                        'bg-orange-100 text-orange-600': ['assignment_updated', 'session_reminder'].includes(notification.type),
                                        'bg-red-100 text-red-600': ['subscription_expiring'].includes(notification.type),
                                        'bg-gray-100 text-gray-600': notification.type === 'system' || !notification.type
                                     }">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                                <p class="text-sm text-gray-600 truncate" x-text="notification.message"></p>
                                <p class="text-xs text-gray-400 mt-1" x-text="formatDate(notification.created_at)"></p>
                            </div>

                            <!-- Unread Dot -->
                            <div x-show="!notification.is_read" class="flex-shrink-0">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Empty State -->
                <div x-show="notifications.length === 0" class="px-4 py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No notifications yet</p>
                </div>
            </div>

            <!-- Footer -->
            <div x-show="notifications.length > 0" class="px-4 py-2 border-t border-gray-200">
                <a href="{{ route('notifications.index') }}" class="text-sm text-{{ $config['accentColor'] }}-600 hover:text-{{ $config['accentColor'] }}-500">
                    View all notifications
                </a>
            </div>
        </div>
    </div>

@else
    <!-- Bootstrap Version (Trainer) -->
    <div class="dropdown position-relative {{ $containerClass }}" 
         x-data="notificationDropdown({ theme: '{{ $theme }}' })" 
         x-init="listenForNotifications()">
        
        <!-- Notification Button -->
        <button class="{{ $config['buttonClass'] }}" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false"
                @click="if(notifications.length === 0) loadNotifications()">
            <i class="bi bi-bell"></i>
            <span x-show="unreadCount > 0"
                  x-cloak
                  x-text="unreadCount" 
                  class="{{ $config['badgeClass'] }}"
                  style="font-size: 0.6rem;">
            </span>
        </button>

        <!-- Dropdown Menu -->
        <ul class="{{ $config['dropdownClass'] }}" 
            style="width: 350px; max-height: 500px; overflow-y: auto;">
            
            <!-- Header -->
            <li class="{{ $config['headerClass'] }}">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 fw-semibold">Notifications</h6>
                    <button @click="markAllAsRead()" 
                            class="btn btn-sm btn-link text-{{ $config['accentColor'] }} p-0 text-decoration-none"
                            x-show="unreadCount > 0">
                        Mark all read
                    </button>
                </div>
            </li>

            <!-- Loading State -->
            <li x-show="loading" class="text-center py-4">
                <div class="spinner-border spinner-border-sm text-{{ $config['accentColor'] }}" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="small text-muted mt-2 mb-0">Loading notifications...</p>
            </li>

            <!-- Notifications List -->
            <template x-for="notification in notifications" :key="notification.id" x-show="!loading">
                <li :class="{ '{{ $config['unreadItemClass'] }}': !notification.is_read }"
                    class="{{ $config['itemClass'] }} cursor-pointer"
                    @click="markAsRead(notification.id)">
                    <div class="d-flex align-items-start">
                        <!-- Icon (inline rendering for Alpine.js compatibility) -->
                        <div class="flex-shrink-0">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;"
                                 :class="{
                                    'bg-blue-subtle text-blue': ['message', 'comment', 'session_scheduled'].includes(notification.type),
                                    'bg-success-subtle text-success': ['workout_assigned', 'workout_completed', 'new_client', 'payment_received'].includes(notification.type),
                                    'bg-warning-subtle text-warning': ['goal_achieved'].includes(notification.type),
                                    'bg-orange-subtle text-orange': ['assignment_updated', 'session_reminder'].includes(notification.type),
                                    'bg-danger-subtle text-danger': ['subscription_expiring'].includes(notification.type),
                                    'bg-secondary-subtle text-secondary': notification.type === 'system' || !notification.type
                                 }">
                                <i class="bi bi-bell fs-5"></i>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-grow-1 ms-3">
                            <p class="mb-1 fw-semibold" x-text="notification.title"></p>
                            <p class="mb-1 small text-muted" x-text="notification.message"></p>
                            <p class="mb-0 text-muted" style="font-size: 0.75rem;" x-text="formatDate(notification.created_at)"></p>
                        </div>

                        <!-- Unread Indicator -->
                        <div x-show="!notification.is_read" class="ms-2">
                            <span class="badge bg-primary rounded-circle" style="width: 8px; height: 8px; padding: 0;"></span>
                        </div>
                    </div>
                </li>
            </template>

            <!-- Empty State -->
            <li x-show="notifications.length === 0 && !loading" class="text-center py-4">
                <div class="text-muted">
                    <i class="bi bi-bell-slash fs-1 mb-3"></i>
                    <p class="small mb-0">No notifications yet</p>
                </div>
            </li>

            <!-- Footer -->
            <li x-show="notifications.length > 0" class="border-top p-2">
                <a href="{{ route('notifications.index') }}" 
                   class="btn btn-sm btn-link text-{{ $config['accentColor'] }} text-decoration-none w-100">
                    View all notifications
                </a>
            </li>
        </ul>
    </div>
@endif

<script>
// Ensure userId is available globally
window.userId = {{ auth()->id() ?? 'null' }};
</script>
