@extends('layouts.app')

@section('title', 'Notifications')
@section('page-title', 'Notifications')
@section('page-subtitle', 'Stay updated with your fitness journey')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
                <p class="mt-1 text-sm text-gray-600">Stay updated with your fitness journey</p>
            </div>
            <button id="mark-all-read-btn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Mark All Read
            </button>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="mb-6">
        <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg w-fit">
            <button type="button" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200 active-filter" data-filter="all">
                All Notifications
            </button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200" data-filter="unread">
                Unread
            </button>
            <button type="button" class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200" data-filter="program_assignment_approved">
                Program Approvals
            </button>
        </div>
    </div>

    <!-- Notifications Container -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <!-- Loading State -->
        <div id="loading-notifications" class="hidden flex flex-col items-center justify-center py-12">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-600"></div>
            <p class="mt-4 text-sm text-gray-600">Loading notifications...</p>
        </div>

        <!-- Notifications List -->
        <div id="notifications-list" class="divide-y divide-gray-200">
            <!-- Server-side rendered notifications for immediate display -->
            @php
                $notifications = \App\Models\Notification::where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->limit(20)
                    ->get();
            @endphp

            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                <div class="notification-item p-6 hover:bg-gray-50 transition-colors duration-200 {{ !$notification->is_read ? 'bg-blue-50' : 'bg-white' }}" data-notification-id="{{ $notification->id }}">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center
                                @if($notification->type === 'program_assignment_approved') bg-green-100 text-green-600
                                @elseif($notification->type === 'enrollment_request') bg-blue-100 text-blue-600
                                @elseif($notification->type === 'assignment_approved') bg-green-100 text-green-600
                                @elseif($notification->type === 'assignment_rejected') bg-red-100 text-red-600
                                @elseif($notification->type === 'client_withdrawal') bg-orange-100 text-orange-600
                                @elseif($notification->type === 'program_completed') bg-purple-100 text-purple-600
                                @else bg-gray-100 text-gray-600 @endif">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    @if($notification->type === 'program_assignment_approved')
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    @elseif($notification->type === 'enrollment_request')
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                    @else
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    @endif
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-gray-900 {{ !$notification->is_read ? 'font-bold' : '' }}">{{ $notification->title }}</h3>
                                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">{{ $notification->message }}</p>
                                    <p class="mt-2 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->is_read)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">New</span>
                                    @endif
                                    <div class="flex space-x-2">
                                        <button class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 view-detail-btn" data-notification-id="{{ $notification->id }}">
                                            View Details
                                        </button>
                                        @if(!$notification->is_read)
                                            <button class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 mark-read-btn" data-notification-id="{{ $notification->id }}">
                                                Mark as Read
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-5 5v-5zM4.868 12.683A17.925 17.925 0 0112 21c7.962 0 12-1.21 12-2.683m-12 2.683a17.925 17.925 0 01-7.132-8.317M12 21c4.411 0 8-4.03 8-9s-3.589-9-8-9-8 4.03-8 9a9.06 9.06 0 001.832 5.683L4 21l4.868-8.317z" />
                    </svg>
                    <h3 class="mt-4 text-sm font-medium text-gray-900">No notifications</h3>
                    <p class="mt-1 text-sm text-gray-500">You're all caught up! No notifications to show.</p>
                </div>
            @endif
        </div>

    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        <nav id="pagination-container" class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
            <!-- Pagination will be added dynamically -->
        </nav>
    </div>
</div>

<!-- Notification Detail Modal -->
<div id="notificationDetailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="notificationDetailModalLabel" aria-hidden="true">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-gray-500 bg-opacity-5 backdrop-blur-sm transition-opacity" id="modalBackdrop"></div>
    
    <!-- Modal container -->
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center relative z-10">
        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <!-- Modal content -->
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 relative">
            <div class="flex items-start justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900" id="notificationDetailModalLabel">
                    Notification Details
                </h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 focus:outline-none focus:text-gray-600" id="closeModalBtn">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div id="notification-detail-content">
                <!-- Notification details will be loaded here -->
            </div>
            
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button id="mark-as-read-btn" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Mark as Read
                </button>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:w-auto sm:text-sm" id="closeModal2Btn">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Client notifications page loaded');

    let currentPage = 1;
    let perPage = 20;
    let currentFilter = 'all';
    let totalPages = 1;
    let notificationDetailModal;

    // Check if axios is available
    if (typeof window.axios === 'undefined') {
        console.error('Axios is not loaded!');
        document.getElementById('loading-notifications').innerHTML = '<p class="text-red-600">Error: JavaScript dependencies not loaded properly.</p>';
        return;
    }

    console.log('Axios is available, initializing modal...');

    // Initialize modal (Tailwind version)
    const modalElement = document.getElementById('notificationDetailModal');
    if (modalElement) {
        console.log('Modal element found, setting up Tailwind modal');
        
        notificationDetailModal = {
            show: function() {
                modalElement.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            },
            hide: function() {
                modalElement.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        };

        // Add close event listeners
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            notificationDetailModal.hide();
        });
        
        document.getElementById('closeModal2Btn').addEventListener('click', function() {
            notificationDetailModal.hide();
        });
        
        document.getElementById('modalBackdrop').addEventListener('click', function() {
            notificationDetailModal.hide();
        });

        console.log('Tailwind modal initialized successfully');
    } else {
        console.error('Modal element not found');
    }

    // Attach event listeners to server-side rendered buttons
    function attachInitialButtonListeners() {
        console.log('Attaching listeners to server-side rendered buttons');
        
        document.querySelectorAll('.view-detail-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const notificationId = this.getAttribute('data-notification-id');
                console.log('View details clicked for notification:', notificationId);
                showNotificationDetail(notificationId);
            });
        });

        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const notificationId = this.getAttribute('data-notification-id');
                console.log('Mark as read clicked for notification:', notificationId);
                markAsRead(notificationId);
            });
        });
    }

    // Call this immediately for server-side rendered content
    attachInitialButtonListeners();

    // Load notifications
    function loadNotifications(page = 1, filter = 'all') {
        console.log('Loading notifications with page:', page, 'filter:', filter);

        const loadingEl = document.getElementById('loading-notifications');
        const listEl = document.getElementById('notifications-list');
        const noNotificationsEl = document.getElementById('no-notifications');

        if (!loadingEl || !listEl || !noNotificationsEl) {
            console.error('Required DOM elements not found');
            return;
        }

        // Show loading state
        loadingEl.classList.remove('hidden');
        loadingEl.classList.add('flex');

        let url = `/notifications/all?page=${page}&per_page=${perPage}`;
        if (filter !== 'all') {
            url += `&filter=${filter}`;
        }

        console.log('Full URL being requested:', url);
        console.log('Request headers:', window.axios.defaults.headers);

        console.log('Making request to:', url);

        window.axios.get(url)
            .then(response => {
                console.log('Response received:', response);
                console.log('Response data:', response.data);
                const notifications = response.data.data || [];
                currentPage = response.data.current_page || 1;
                totalPages = response.data.last_page || 1;

                console.log('Notifications count:', notifications.length);
                console.log('Notifications data:', notifications);

                renderNotifications(notifications);
                renderPagination();

                // Hide loading and show results
                loadingEl.classList.add('hidden');
                loadingEl.classList.remove('flex');
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                if (error.response) {
                    console.error('Error response:', error.response.data);
                    console.error('Error status:', error.response.status);
                }

                // Hide loading on error
                loadingEl.classList.add('hidden');
                loadingEl.classList.remove('flex');
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        const container = document.getElementById('notifications-list');
        container.innerHTML = '';

        notifications.forEach(notification => {
            const notificationEl = document.createElement('div');
            notificationEl.className = `notification-item p-6 hover:bg-gray-50 transition-colors duration-200 ${!notification.is_read ? 'bg-blue-50' : 'bg-white'}`;
            notificationEl.setAttribute('data-notification-id', notification.id);

            const iconClass = getNotificationIconClass(notification.type);
            const iconBackgroundClass = getNotificationIconBackgroundClass(notification.type);

            notificationEl.innerHTML = `
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center ${iconBackgroundClass}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                ${getNotificationIconSVG(notification.type)}
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-sm font-semibold text-gray-900 ${!notification.is_read ? 'font-bold' : ''}">${notification.title}</h3>
                                <p class="mt-1 text-sm text-gray-600 line-clamp-2">${notification.message}</p>
                                <p class="mt-2 text-xs text-gray-500">${formatDate(notification.created_at)}</p>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                ${!notification.is_read ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">New</span>' : ''}
                                <div class="flex space-x-2">
                                    <button class="inline-flex items-center px-3 py-1 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 view-detail-btn" data-notification-id="${notification.id}">
                                        View Details
                                    </button>
                                    ${!notification.is_read ?
                                        `<button class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 mark-read-btn" data-notification-id="${notification.id}">
                                            Mark as Read
                                        </button>` : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(notificationEl);
        });

        // Add event listeners for buttons - using direct event listeners
        function attachButtonListeners() {
            document.querySelectorAll('.view-detail-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const notificationId = this.getAttribute('data-notification-id');
                    console.log('View details clicked for notification:', notificationId);
                    showNotificationDetail(notificationId);
                });
            });
    
            document.querySelectorAll('.mark-read-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const notificationId = this.getAttribute('data-notification-id');
                    console.log('Mark as read clicked for notification:', notificationId);
                    markAsRead(notificationId);
                });
            });
        }
    
        // Attach listeners immediately and after any dynamic content loads
        attachButtonListeners();
    }

    // Render pagination
    function renderPagination() {
        const container = document.getElementById('pagination-container');
        container.innerHTML = '';

        if (totalPages <= 1) return;

        // Previous button
        if (currentPage > 1) {
            const prevBtn = document.createElement('a');
            prevBtn.href = '#';
            prevBtn.className = 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50';
            prevBtn.innerHTML = `
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Previous
            `;
            prevBtn.addEventListener('click', function(e) {
                e.preventDefault();
                loadNotifications(currentPage - 1, currentFilter);
            });
            container.appendChild(prevBtn);
        }

        // Page numbers
        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, currentPage + 2);

        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = document.createElement('a');
            pageBtn.href = '#';
            pageBtn.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium ${
                i === currentPage
                    ? 'border-emerald-500 bg-emerald-50 text-emerald-600'
                    : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50'
            }`;
            pageBtn.textContent = i;
            pageBtn.addEventListener('click', function(e) {
                e.preventDefault();
                loadNotifications(i, currentFilter);
            });
            container.appendChild(pageBtn);
        }

        // Next button
        if (currentPage < totalPages) {
            const nextBtn = document.createElement('a');
            nextBtn.href = '#';
            nextBtn.className = 'relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50';
            nextBtn.innerHTML = `
                Next
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            `;
            nextBtn.addEventListener('click', function(e) {
                e.preventDefault();
                loadNotifications(currentPage + 1, currentFilter);
            });
            container.appendChild(nextBtn);
        }
    }

    // Show notification detail
    function showNotificationDetail(notificationId) {
        console.log('Showing notification detail for ID:', notificationId);

        window.axios.get(`/notifications/${notificationId}`)
            .then(response => {
                console.log('Notification detail response:', response.data);
                const notification = response.data;
                const content = document.getElementById('notification-detail-content');

                if (!content) {
                    console.error('notification-detail-content element not found');
                    return;
                }

                content.innerHTML = `
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center ${getNotificationIconBackgroundClass(notification.type)}">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    ${getNotificationIconSVG(notification.type)}
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">${notification.title}</h3>
                            <p class="text-sm text-gray-500">${formatDate(notification.created_at)}</p>
                        </div>
                    </div>
                    <div class="mb-4">
                        <p class="text-gray-700">${notification.message}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                            notification.is_read ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800'
                        }">
                            ${notification.is_read ? 'Read' : 'Unread'}
                        </span>
                    </div>
                `;

                const markAsReadBtn = document.getElementById('mark-as-read-btn');
                if (markAsReadBtn) {
                    markAsReadBtn.setAttribute('data-notification-id', notificationId);

                    if (notification.is_read) {
                        markAsReadBtn.classList.add('hidden');
                    } else {
                        markAsReadBtn.classList.remove('hidden');
                    }
                }

                if (notificationDetailModal) {
                    notificationDetailModal.show();
                    console.log('Modal shown successfully');
                } else {
                    console.error('Modal not initialized');
                }
            })
            .catch(error => {
                console.error('Error loading notification details:', error);
                if (error.response) {
                    console.error('Error response:', error.response.data);
                    console.error('Error status:', error.response.status);
                }
            });
    }

    // Mark notification as read
    function markAsRead(notificationId) {
        window.axios.post(`/notifications/${notificationId}/read`)
            .then(response => {
                // Update UI
                const notificationEl = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationEl) {
                    notificationEl.classList.remove('bg-blue-50');
                    notificationEl.classList.add('bg-white');
                    const titleEl = notificationEl.querySelector('h3');
                    if (titleEl) titleEl.classList.remove('font-bold');

                    const badgeEl = notificationEl.querySelector('.bg-blue-100');
                    if (badgeEl) badgeEl.remove();

                    const markReadBtn = notificationEl.querySelector('.mark-read-btn');
                    if (markReadBtn) markReadBtn.remove();
                }

                // Close modal if open
                if (notificationDetailModal) {
                    notificationDetailModal.hide();
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
    }

    // Mark all notifications as read
    document.getElementById('mark-all-read-btn').addEventListener('click', function() {
        window.axios.post('/notifications/mark-all-read')
            .then(response => {
                // Reload notifications
                loadNotifications(currentPage, currentFilter);
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
    });

    // Handle modal mark as read button
    document.getElementById('mark-as-read-btn').addEventListener('click', function() {
        const notificationId = this.getAttribute('data-notification-id');
        markAsRead(notificationId);
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                btn.classList.add('text-gray-500', 'hover:text-gray-700');
            });
            this.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
            this.classList.remove('text-gray-500', 'hover:text-gray-700');

            // Load filtered notifications
            currentFilter = this.getAttribute('data-filter');
            loadNotifications(1, currentFilter);
        });
    });

    // Helper functions
    function getNotificationIconClass(type) {
        switch(type) {
            case 'program_assignment_approved': return 'text-green-600';
            case 'enrollment_request': return 'text-blue-600';
            case 'assignment_approved': return 'text-green-600';
            case 'assignment_rejected': return 'text-red-600';
            case 'client_withdrawal': return 'text-orange-600';
            case 'program_completed': return 'text-purple-600';
            default: return 'text-gray-600';
        }
    }

    function getNotificationIconBackgroundClass(type) {
        switch(type) {
            case 'program_assignment_approved': return 'bg-green-100';
            case 'enrollment_request': return 'bg-blue-100';
            case 'assignment_approved': return 'bg-green-100';
            case 'assignment_rejected': return 'bg-red-100';
            case 'client_withdrawal': return 'bg-orange-100';
            case 'program_completed': return 'bg-purple-100';
            default: return 'bg-gray-100';
        }
    }

    function getNotificationIconSVG(type) {
        switch(type) {
            case 'program_assignment_approved':
                return '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>';
            case 'enrollment_request':
                return '<path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>';
            case 'assignment_approved':
                return '<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>';
            case 'assignment_rejected':
                return '<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>';
            case 'client_withdrawal':
                return '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>';
            case 'program_completed':
                return '<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>';
            default:
                return '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>';
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const diffInHours = Math.floor((now - date) / (1000 * 60 * 60));

        if (diffInHours < 1) {
            const diffInMinutes = Math.floor((now - date) / (1000 * 60));
            return diffInMinutes <= 1 ? 'Just now' : `${diffInMinutes} minutes ago`;
        } else if (diffInHours < 24) {
            return `${diffInHours} hours ago`;
        } else {
            return date.toLocaleDateString() + ' at ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        }
    }

    // Initial load - page loads with server-side rendered notifications
    // JavaScript enhancements are optional
    console.log('Client notifications page loaded with server-side rendered content');
    console.log('Current user ID:', {{ auth()->id() ?? 'null' }});
    console.log('Axios available:', typeof window.axios !== 'undefined');

    // Test modal initialization and button functionality
    console.log('Testing modal availability...');
    const testModal = document.getElementById('notificationDetailModal');
    console.log('Modal element found:', !!testModal);

    // Test button functionality
    const buttons = document.querySelectorAll('.view-detail-btn');
    console.log('View detail buttons found:', buttons.length);
});
</script>
@endpush