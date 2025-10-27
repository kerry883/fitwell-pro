import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
    // Register the notificationDropdown component with Alpine.
    Alpine.data('notificationDropdown', (config = {}) => ({
        open: false,
        notifications: [],
        unreadCount: 0,
        loading: false,
        perPage: config.perPage || 10,
        theme: config.theme || 'client',

        init() {
            // Load only unread count on initialization (lightweight)
            this.loadUnreadCount();
        },

        loadUnreadCount() {
            // Fetch only the unread count without loading full notification data
            axios.get('/notifications/unread-count')
                .then(response => {
                    this.unreadCount = response.data.count || 0;
                    console.log(`[${this.theme}] Unread count loaded:`, this.unreadCount);
                })
                .catch(error => {
                    console.error(`[${this.theme}] Error loading unread count:`, error);
                    // Fallback: If endpoint doesn't exist, load full notifications
                    // This ensures backward compatibility
                });
        },

        loadNotifications() {
            console.log(`[${this.theme}] Loading notifications...`);
            this.loading = true;
            const url = this.perPage ? `/notifications/all?per_page=${this.perPage}` : '/notifications/all';

            axios.get(url)
                .then(response => {
                    console.log(`[${this.theme}] Notifications loaded:`, response.data);
                    this.notifications = response.data.data || response.data;
                    this.unreadCount = this.notifications.filter(n => !n.is_read).length;
                    console.log(`[${this.theme}] Unread count:`, this.unreadCount);
                    this.loading = false;
                })
                .catch(error => {
                    console.error(`[${this.theme}] Error loading notifications:`, error);
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
            console.log(`[${this.theme}] Setting up notification listener for user:`, window.userId);
            if (window.Echo && window.userId) {
                console.log(`[${this.theme}] Echo available, setting up private channel`);
                window.Echo.private(`notifications.${window.userId}`)
                    .listen('NotificationCreated', (e) => {
                        console.log(`[${this.theme}] Received notification via Echo:`, e.notification);

                        // Add new notification to the list
                        this.notifications.unshift(e.notification);

                        // Update unread count
                        if (!e.notification.is_read) {
                            this.unreadCount++;
                        }

                        // Show toast notification (theme-aware)
                        this.showToast(e.notification.title, e.notification.message);
                    });
            } else {
                console.error(`[${this.theme}] Echo or userId not available`, {
                    Echo: !!window.Echo,
                    userId: window.userId
                });
            }
        },

        showToast(title, message) {
            if (this.theme === 'trainer') {
                // Bootstrap toast for trainer
                this.showBootstrapToast(title, message);
            } else {
                // Tailwind toast for client
                this.showTailwindToast(title, message);
            }
        },

        showTailwindToast(title, message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-emerald-500 text-white px-6 py-4 rounded-lg shadow-xl z-50 max-w-sm transform transition-all duration-300 ease-in-out';
            toast.style.animation = 'slideInRight 0.3s ease-out';
            toast.innerHTML = `
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold">${title}</p>
                        <p class="mt-1 text-sm opacity-90">${message}</p>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 flex-shrink-0 text-white hover:text-gray-200">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            `;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease-in';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        },

        showBootstrapToast(title, message) {
            const toastContainer = document.getElementById('toast-container') || this.createToastContainer();
            const toast = document.createElement('div');
            toast.className = 'toast show align-items-center text-bg-success border-0 mb-2';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-bell-fill me-2"></i>
                            <div>
                                <div class="fw-semibold">${title}</div>
                                <div class="small">${message}</div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.toast').remove()"></button>
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
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }));
});