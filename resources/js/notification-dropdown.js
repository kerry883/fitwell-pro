import Alpine from 'alpinejs';

document.addEventListener('alpine:init', () => {
    // Register the notificationDropdown component with Alpine.
    Alpine.data('notificationDropdown', () => ({
        open: false,
        notifications: [],
        unreadCount: 0,
        loading: false,

        loadNotifications() {
            console.log('Loading notifications...');
            this.loading = true;
            axios.get('/notifications/all')
                .then(response => {
                    console.log('Notifications loaded:', response.data);
                    this.notifications = response.data.data || response.data;
                    this.unreadCount = this.notifications.filter(n => !n.is_read).length;
                    console.log('Unread count:', this.unreadCount);
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
            console.log('Setting up notification listener for user:', window.userId);
            if (window.Echo && window.userId) {
                console.log('Echo available, setting up private channel');
                window.Echo.private(`notifications.${window.userId}`)
                    .listen('NotificationCreated', (e) => {
                        console.log('Received notification via Echo:', e.notification);

                        // Add new notification to the list
                        this.notifications.unshift(e.notification);

                        // Update unread count
                        if (!e.notification.is_read) {
                            this.unreadCount++;
                        }

                        // Show toast notification
                        this.showToast(e.notification.title, e.notification.message);
                    });
            } else {
                console.error('Echo or userId not available', { Echo: !!window.Echo, userId: window.userId });
            }
        },

        showToast(title, message) {
            // Simple toast implementation
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            toast.innerHTML = `<div class="font-semibold">${title}</div><div class="text-sm">${message}</div>`;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 5000);
        },

        formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }
    }));
});