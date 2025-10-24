import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Set CSRF Token for all axios requests
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    // Use nullish coalescing to fall back to sensible defaults when env vars are undefined
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST || `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusherapp.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT || 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT || 443,
    forceTLS: (
        import.meta.env.VITE_PUSHER_SCHEME || 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

// Notification handling functionality
document.addEventListener('DOMContentLoaded', function() {
    // Get the user ID from the window object (set in the layout)
    const userId = window.userId;

    if (userId) {
        console.log('Setting up bootstrap notification listener for user:', userId);
        // Listen for notifications on the private channel
        window.Echo.private(`notifications.${userId}`)
            .listen('NotificationCreated', (e) => {
                console.log('Bootstrap notification received:', e.notification);
                updateNotificationsUI(e.notification);
            });
    } else {
        console.error('No userId available for bootstrap notifications');
    }

    // Handle notification clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.notification-item')) {
            const notificationId = e.target.closest('.notification-item').dataset.notificationId;
            if (notificationId) {
                markNotificationAsRead(notificationId);
            }
        }
    });

    // Handle mark all as read button
    const markAllReadBtn = document.getElementById('mark-all-notifications-read');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function() {
            markAllNotificationsAsRead();
        });
    }
});

// Function to update the UI with new notifications
function updateNotificationsUI(notification) {
    // Update notification count
    const badge = document.querySelector('.notification-badge');
    if (badge) {
        const currentCount = parseInt(badge.textContent) || 0;
        badge.textContent = currentCount + 1;
        badge.classList.remove('hidden');
    }

    // Add notification to the dropdown
    const container = document.querySelector('.notifications-container');
    if (container) {
        const notificationElement = createNotificationElement(notification);
        container.prepend(notificationElement);
    }
}

// Function to create a notification element
function createNotificationElement(notification) {
    const div = document.createElement('div');
    div.className = `notification-item p-3 border-b hover:bg-gray-50 ${notification.is_read ? 'bg-gray-50' : 'bg-white'}`;
    div.dataset.notificationId = notification.id;

    // Format the date
    const date = new Date(notification.created_at);
    const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    div.innerHTML = `
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <h4 class="font-semibold text-sm">${notification.title}</h4>
                <p class="text-sm text-gray-600 mt-1">${notification.message}</p>
                <span class="text-xs text-gray-500">${formattedDate}</span>
            </div>
            ${!notification.is_read ? '<div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>' : ''}
        </div>
    `;

    return div;
}

// Mark notification as read
function markNotificationAsRead(notificationId) {
    axios.post(`/notifications/${notificationId}/read`)
        .then(response => {
            // Update UI to show notification as read
            const notificationElement = document.querySelector(`.notification-item[data-notification-id="${notificationId}"]`);
            if (notificationElement) {
                notificationElement.classList.add('bg-gray-50');
                const unreadIndicator = notificationElement.querySelector('.bg-blue-500');
                if (unreadIndicator) {
                    unreadIndicator.remove();
                }
            }

            // Update badge count
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                const currentCount = parseInt(badge.textContent) || 0;
                if (currentCount > 0) {
                    badge.textContent = currentCount - 1;
                    if (currentCount - 1 === 0) {
                        badge.classList.add('hidden');
                    }
                }
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
}

// Mark all notifications as read
function markAllNotificationsAsRead() {
    axios.post('/notifications/mark-all-read')
        .then(response => {
            // Update UI to show all notifications as read
            const notificationElements = document.querySelectorAll('.notification-item');
            notificationElements.forEach(element => {
                element.classList.add('bg-gray-50');
                const unreadIndicator = element.querySelector('.bg-blue-500');
                if (unreadIndicator) {
                    unreadIndicator.remove();
                }
            });

            // Update badge count
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                badge.textContent = '0';
                badge.classList.add('hidden');
            }
        })
        .catch(error => console.error('Error marking all notifications as read:', error));
}