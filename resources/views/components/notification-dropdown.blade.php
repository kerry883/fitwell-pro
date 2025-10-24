<div class="relative" x-data="notificationDropdown" x-init="console.log('Notification dropdown initialized'); loadNotifications(); listenForNotifications();">
    <!-- Notification Button -->
    <button type="button"
            @click="open = !open; loadNotifications()"
            class="relative rounded-full bg-white p-1 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
        <span class="sr-only">View notifications</span>
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>

        <!-- Unread indicator -->
        <span x-show="unreadCount > 0"
              x-text="unreadCount"
              class="absolute -top-1 -right-1 h-5 w-5 rounded-full bg-red-500 text-xs text-white flex items-center justify-center notification-badge">
        </span>
    </button>

    <!-- Notification Dropdown -->
    <div x-show="open"
         x-cloak
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         @click.away="open = false"
         class="absolute right-0 z-10 mt-2 w-80 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
         role="menu">

        <!-- Header -->
        <div class="px-4 py-2 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                <button @click="markAllAsRead()"
                        class="text-xs text-emerald-600 hover:text-emerald-500"
                        x-show="unreadCount > 0">
                    Mark all read
                </button>
            </div>
        </div>

        <!-- Loading Indicator -->
        <div x-show="loading" class="px-4 py-8 text-center text-gray-500">
            <div class="inline-block animate-spin rounded-full h-6 w-6 border-b-2 border-emerald-500"></div>
            <p class="mt-2 text-sm text-gray-500">Loading notifications...</p>
        </div>

        <!-- Notifications List -->
        <div class="max-h-96 overflow-y-auto notifications-container" x-show="!loading">
            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer notification-item"
                      :class="{ 'bg-blue-50': !notification.is_read }"
                      :data-notification-id="notification.id"
                      @click="markAsRead(notification.id)">
                    <div class="flex items-start space-x-3">
                        <!-- Notification Icon -->
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center"
                                  :class="{
                                      'bg-blue-100 text-blue-600': notification.type === 'enrollment_request',
                                      'bg-green-100 text-green-600': notification.type === 'assignment_approved' || notification.type === 'program_assignment_approved',
                                      'bg-red-100 text-red-600': notification.type === 'assignment_rejected',
                                      'bg-orange-100 text-orange-600': notification.type === 'client_withdrawal',
                                      'bg-purple-100 text-purple-600': notification.type === 'program_completed',
                                      'bg-gray-100 text-gray-600': !notification.type
                                  }">
                                <!-- Icon based on notification type -->
                                <svg x-show="notification.type === 'enrollment_request'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                                <svg x-show="notification.type === 'assignment_approved' || notification.type === 'program_assignment_approved'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <svg x-show="notification.type === 'program_progress_update'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                                </svg>
                                <svg x-show="!notification.type || notification.type === 'client_withdrawal' || notification.type === 'program_completed'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Notification Content -->
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900" x-text="notification.title"></p>
                            <p class="text-sm text-gray-600 truncate" x-text="notification.message"></p>
                            <p class="text-xs text-gray-400 mt-1" x-text="formatDate(notification.created_at)"></p>
                        </div>

                        <!-- Unread indicator -->
                        <div x-show="!notification.is_read" class="flex-shrink-0">
                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        </div>
                    </div>
                </div>
            </template>

            
            <!-- Empty State -->
            <div x-show="notifications.length === 0" class="px-4 py-8 text-center text-gray-500">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683a17.925 17.925 0 01-7.132-8.317M12 21c4.411 0 8-4.03 8-9s-3.589-9-8-9-8 4.03-8 9a9.06 9.06 0 001.832 5.683L4 21l4.868-8.317z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
                <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
            </div>
        </div>

        <!-- Footer -->
        <div x-show="notifications.length > 0" class="px-4 py-2 border-t border-gray-200">
            @if(auth()->user()->isTrainer())
                <a href="{{ route('notifications.index') }}" class="text-sm text-emerald-600 hover:text-emerald-500">View all notifications</a>
            @else
                <a href="{{ route('notifications.index') }}" class="text-sm text-emerald-600 hover:text-emerald-500">View all notifications</a>
            @endif
        </div>
    </div>
</div>

<script>
// Ensure userId is available globally for Alpine.js
window.userId = {{ auth()->id() ?? 'null' }};
</script>
