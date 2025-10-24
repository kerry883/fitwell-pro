<div class="dropdown position-relative" x-data="{ 
    notifications: [], 
    unreadCount: 0, 
    loading: false,
    loadNotifications() {
        this.loading = true;
        axios.get('/notifications/all?per_page=10')
            .then(response => {
                // Check if response is paginated
                if (response.data.data) {
                    this.notifications = response.data.data;
                } else {
                    this.notifications = response.data;
                }
                this.unreadCount = this.notifications.filter(n => !n.is_read).length;
                this.loading = false;
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                this.loading = false;
            });
    },
    markAsRead(notificationId) {
        axios.post(`/notifications/${notificationId}/read`)
            .then(response => {
                // Update local state
                const notification = this.notifications.find(n => n.id === notificationId);
                if (notification) {
                    notification.is_read = true;
                    this.unreadCount = Math.max(0, this.unreadCount - 1);
                }
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
    },
    redirectToNotifications(notificationId) {
        // Mark as read first
        this.markAsRead(notificationId);
        // Then redirect to notifications page
        window.location.href = '{{ route('notifications.index') }}';
    },
    markAllAsRead() {
        axios.post('/notifications/mark-all-read')
            .then(response => {
                // Update local state
                this.notifications.forEach(n => n.is_read = true);
                this.unreadCount = 0;
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
    },
    listenForNotifications() {
        if (window.Echo && window.userId) {
            window.Echo.private(`notifications.${window.userId}`)
                .listen('NotificationCreated', (e) => {
                    // Add new notification to the list
                    this.notifications.unshift(e.notification);

                    // Update unread count
                    if (!e.notification.is_read) {
                        this.unreadCount++;
                    }

                    // Show toast notification
                    this.showToast(e.notification.title, e.notification.message);
                });
        }
    },
    showToast(title, message) {
        // Bootstrap-compatible toast implementation
        const toastContainer = document.getElementById('toast-container') || this.createToastContainer();
        const toast = document.createElement('div');
        toast.className = 'toast show align-items-center text-bg-primary border-0 mb-2';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class='d-flex'>
                <div class='toast-body'>
                    <div class='fw-semibold'>${title}</div>
                    <div class='small'>${message}</div>
                </div>
                <button type='button' class='btn-close btn-close-white me-2 m-auto' data-bs-dismiss='toast'></button>
            </div>
        `;
        
        toastContainer.appendChild(toast);

        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 5000);
    },
    createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '1055';
        document.body.appendChild(container);
        return container;
    },
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }
}" x-init="loadNotifications(); listenForNotifications();">
    <!-- Notification Button -->
    <button class="btn btn-light btn-sm position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell"></i>
        <span x-show="unreadCount > 0" 
              x-text="unreadCount" 
              class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-badge" 
              style="font-size: 0.6rem;">
        </span>
    </button>

    <!-- Notification Dropdown -->
    <ul class="dropdown-menu dropdown-menu-end notification-dropdown p-0 shadow-lg border-0" 
         style="width: 320px; max-height: 400px; border-radius: 12px; overflow: hidden;">
        <!-- Header -->
        <li><div class="p-3 border-bottom bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Notifications</h6>
                <button @click="markAllAsRead()" 
                        x-show="unreadCount > 0"
                        class="btn btn-sm btn-link text-primary p-0 text-decoration-none">
                    Mark all read
                </button>
            </div>
        </div></li>

        <!-- Loading Indicator -->
        <li x-show="loading"><div class="p-4 text-center text-muted">
            <div class="spinner-border spinner-border-sm text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 mb-0 small">Loading notifications...</p>
        </div></li>

        <!-- Notifications List -->
        <li x-show="!loading"><div class="notifications-container overflow-auto" style="max-height: 300px;">
            <template x-for="notification in notifications" :key="notification.id">
                <div class="d-flex align-items-start p-3 border-bottom notification-item cursor-pointer" 
                     :class="{ 'bg-light': !notification.is_read, 'bg-white': notification.is_read }"
                     :data-notification-id="notification.id"
                     @click="redirectToNotifications(notification.id)"
                     style="transition: background-color 0.2s ease; cursor: pointer;"
                     @mouseenter="$el.style.backgroundColor = '#f8f9fa'"
                     @mouseleave="$el.style.backgroundColor = notification.is_read ? '#ffffff' : '#f8f9fa'">
                    <!-- Notification Icon -->
                    <div class="me-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center"
                             style="width: 36px; height: 36px; font-size: 14px;"
                             :class="{
                                 'bg-primary text-white': notification.type === 'enrollment_request',
                                 'bg-success text-white': notification.type === 'assignment_approved',
                                 'bg-danger text-white': notification.type === 'assignment_rejected',
                                 'bg-warning text-white': notification.type === 'client_withdrawal',
                                 'bg-info text-white': notification.type === 'program_completed',
                                 'bg-secondary text-white': !notification.type
                             }">
                            <!-- Icon based on notification type -->
                            <i x-show="notification.type === 'enrollment_request'" class="bi bi-person-plus"></i>
                            <i x-show="notification.type === 'assignment_approved'" class="bi bi-check-circle"></i>
                            <i x-show="notification.type === 'assignment_rejected'" class="bi bi-x-circle"></i>
                            <i x-show="!notification.type || notification.type === 'client_withdrawal' || notification.type === 'program_completed'" class="bi bi-info-circle"></i>
                        </div>
                    </div>

                    <!-- Notification Content -->
                    <div class="flex-grow-1 min-w-0">
                        <div class="fw-semibold small text-dark mb-1" x-text="notification.title"></div>
                        <div class="text-muted small mb-1 text-truncate" x-text="notification.message"></div>
                        <div class="text-muted" style="font-size: 11px;" x-text="formatDate(notification.created_at)"></div>

                        <!-- Action buttons for enrollment request -->
                        <div x-show="notification.type === 'enrollment_request'" class="mt-2">
                            <a :href="'/trainer/clients/' + notification.data.user_id + '/activate'"
                               class="btn btn-sm trainer-btn-primary text-white me-2">
                                Accept & Activate
                            </a>
                        </div>
                    </div>

                    <!-- Unread Indicator -->
                    <div x-show="!notification.is_read" class="ms-2">
                        <div class="bg-primary rounded-circle" style="width: 8px; height: 8px;"></div>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <div x-show="notifications.length === 0" class="p-4 text-center text-muted">
                <i class="bi bi-bell-slash mb-2 d-block" style="font-size: 2.5rem; opacity: 0.5;"></i>
                <h6 class="mb-1 fw-normal">No notifications</h6>
                <small class="text-muted">You're all caught up!</small>
            </div>
        </div></li>

        <!-- Footer -->
        <li x-show="notifications.length > 0"><div class="p-2 border-top bg-light">
            <a href="{{ route('notifications.index') }}" 
               class="btn btn-sm btn-outline-primary w-100 text-decoration-none">
                View all notifications
            </a>
        </div></li>
    </ul>
</div>

<script>
// Ensure userId is available globally for Alpine.js
window.userId = {{ auth()->id() ?? 'null' }};
</script>
