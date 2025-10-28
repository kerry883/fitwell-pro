
@extends('layouts.trainer')

@section('title', 'Notifications')
@section('page-title', 'Notifications')
@section('page-subtitle', 'Stay updated with all your activities')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold mb-0">My Notifications</h4>
                <div class="d-flex gap-2">
                    <button id="delete-all-btn" class="btn btn-danger px-3 py-2" onclick="return confirm('Are you sure you want to delete all notifications? This action cannot be undone.')">
                        <i class="bi bi-trash me-2"></i>Delete All
                    </button>
                    <button id="mark-all-read-btn" class="btn trainer-btn-primary text-white px-3 py-2">
                        <i class="bi bi-check-all me-2"></i>Mark All Read
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary active" data-filter="all">
                    All Notifications
                </button>
                <button type="button" class="btn btn-outline-primary" data-filter="unread">
                    Unread
                </button>
                <button type="button" class="btn btn-outline-primary" data-filter="enrollment_request">
                    Enrollment Requests
                </button>
                <button type="button" class="btn btn-outline-primary" data-filter="assignment_approved">
                    Approved Assignments
                </button>
                <button type="button" class="btn btn-outline-primary" data-filter="assignment_rejected">
                    Rejected Assignments
                </button>
            </div>
        </div>
    </div>

    <!-- Notifications Container -->
    <div class="row">
        <div class="col-12">
            <div id="notifications-container" class="trainer-card p-0">
                <!-- Loading State -->
                <div id="loading-notifications" class="p-5 text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading notifications...</p>
                </div>

                <!-- Notifications List -->
                <div id="notifications-list" class="d-none">
                    <!-- Notifications will be loaded here via JavaScript -->
                </div>

                <!-- Empty State -->
                <div id="no-notifications" class="p-5 text-center d-none">
                    <i class="bi bi-bell-slash text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mb-2">No notifications</h5>
                    <p class="text-muted">You're all caught up! No notifications to show.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <div class="row mt-4">
        <div class="col-12">
            <nav id="pagination-container" class="d-flex justify-content-center">
                <!-- Pagination will be added dynamically -->
            </nav>
        </div>
    </div>
</div>

<!-- Notification Detail Modal -->
<div class="modal fade" id="notificationDetailModal" tabindex="-1" aria-labelledby="notificationDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="notificationDetailModalLabel">Notification Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="notification-detail-content">
                    <!-- Notification details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-danger" id="delete-notification-modal-btn">
                    <i class="bi bi-trash me-2"></i>Delete Notification
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="mark-as-read-btn" type="button" class="btn trainer-btn-primary text-white">
                    <i class="bi bi-check-circle me-2"></i>Mark as Read
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    let perPage = 20;
    let currentFilter = 'all';
    let totalPages = 1;
    let notificationDetailModal;

    // Initialize modal
    notificationDetailModal = new bootstrap.Modal(document.getElementById('notificationDetailModal'));

    // Load notifications
    function loadNotifications(page = 1, filter = 'all') {
        document.getElementById('loading-notifications').classList.remove('d-none');
        document.getElementById('notifications-list').classList.add('d-none');
        document.getElementById('no-notifications').classList.add('d-none');

        let url = `/notifications/all?page=${page}&per_page=${perPage}`;
        if (filter !== 'all') {
            url += `&filter=${filter}`;
        }

        axios.get(url)
            .then(response => {
                const notifications = response.data.data;
                currentPage = response.data.current_page;
                totalPages = response.data.last_page;

                renderNotifications(notifications);
                renderPagination();

                document.getElementById('loading-notifications').classList.add('d-none');

                if (notifications.length > 0) {
                    document.getElementById('notifications-list').classList.remove('d-none');
                } else {
                    document.getElementById('no-notifications').classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error loading notifications:', error);
                document.getElementById('loading-notifications').classList.add('d-none');
                document.getElementById('no-notifications').classList.remove('d-none');
            });
    }

    // Render notifications
    function renderNotifications(notifications) {
        const container = document.getElementById('notifications-list');
        container.innerHTML = '';

        notifications.forEach(notification => {
            const notificationEl = document.createElement('div');
            notificationEl.className = `notification-item p-3 border-bottom ${!notification.is_read ? 'bg-light' : ''}`;
            notificationEl.setAttribute('data-notification-id', notification.id);

            const iconClass = getNotificationIconClass(notification.type);
            const iconBackgroundClass = getNotificationIconBackgroundClass(notification.type);

            notificationEl.innerHTML = `
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center ${iconBackgroundClass}" style="width: 40px; height: 40px;">
                            <i class="${iconClass}"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 ${!notification.is_read ? 'fw-bold' : 'fw-normal'}">${notification.title}</h6>
                                <p class="text-muted mb-2">${notification.message}</p>
                                <small class="text-muted">${formatDate(notification.created_at)}</small>
                            </div>
                            <div>
                                ${!notification.is_read ? '<span class="badge bg-primary">New</span>' : ''}
                            </div>
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-sm btn-outline-primary me-2 view-detail-btn" data-notification-id="${notification.id}">
                                View Details
                            </button>
                            ${notification.type === 'enrollment_request' ?
                                `<a href="/trainer/clients/${notification.data.user_id}/activate?assignment=${notification.data.assignment_id}" class="btn btn-sm trainer-btn-primary text-white me-2">
                                    <i class="bi bi-person-check me-1"></i>Review & Activate
                                </a>` : ''}
                            ${!notification.is_read ?
                                `<button class="btn btn-sm btn-outline-success mark-read-btn me-2" data-notification-id="${notification.id}">
                                    Mark as Read
                                </button>` : ''}
                            <button class="btn btn-sm btn-outline-danger delete-notification-btn" data-notification-id="${notification.id}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(notificationEl);
        });

        // Add event listeners for buttons
        document.querySelectorAll('.view-detail-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                showNotificationDetail(this.getAttribute('data-notification-id'));
            });
        });

        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                markAsRead(this.getAttribute('data-notification-id'));
            });
        });

        document.querySelectorAll('.delete-notification-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                deleteNotification(this.getAttribute('data-notification-id'));
            });
        });
    }

    // Render pagination
    function renderPagination() {
        const container = document.getElementById('pagination-container');
        container.innerHTML = '';

        if (totalPages <= 1) return;

        const pagination = document.createElement('ul');
        pagination.className = 'pagination';

        // Previous button
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" tabindex="-1">Previous</a>`;
        prevLi.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage > 1) {
                loadNotifications(currentPage - 1, currentFilter);
            }
        });
        pagination.appendChild(prevLi);

        // Page numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
            pageLi.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageLi.addEventListener('click', function(e) {
                e.preventDefault();
                loadNotifications(i, currentFilter);
            });
            pagination.appendChild(pageLi);
        }

        // Next button
        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#">Next</a>`;
        nextLi.addEventListener('click', function(e) {
            e.preventDefault();
            if (currentPage < totalPages) {
                loadNotifications(currentPage + 1, currentFilter);
            }
        });
        pagination.appendChild(nextLi);

        container.appendChild(pagination);
    }

    // Show notification detail
    function showNotificationDetail(notificationId) {
        axios.get(`/notifications/${notificationId}`)
            .then(response => {
                const notification = response.data;
                const content = document.getElementById('notification-detail-content');

                const iconClass = getNotificationIconClass(notification.type);
                const iconBackgroundClass = getNotificationIconBackgroundClass(notification.type);

                content.innerHTML = `
                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center ${iconBackgroundClass}" style="width: 50px; height: 50px;">
                                <i class="${iconClass}" style="font-size: 1.5rem;"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="mb-1">${notification.title}</h5>
                            <p class="text-muted mb-0">${formatDate(notification.created_at)}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <p>${notification.message}</p>
                    </div>
                    <div class="mb-3">
                        <span class="badge ${notification.is_read ? 'bg-secondary' : 'bg-primary'}">
                            ${notification.is_read ? 'Read' : 'Unread'}
                        </span>
                    </div>
                `;

                document.getElementById('mark-as-read-btn').setAttribute('data-notification-id', notificationId);

                if (notification.is_read) {
                    document.getElementById('mark-as-read-btn').style.display = 'none';
                } else {
                    document.getElementById('mark-as-read-btn').style.display = 'inline-block';
                }

                notificationDetailModal.show();
            })
            .catch(error => {
                console.error('Error loading notification details:', error);
            });
    }

    // Mark notification as read
    function markAsRead(notificationId) {
        axios.post(`/notifications/${notificationId}/read`)
            .then(response => {
                // Update UI
                const notificationEl = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationEl) {
                    notificationEl.classList.remove('bg-light');
                    const titleEl = notificationEl.querySelector('h6');
                    if (titleEl) titleEl.classList.remove('fw-bold');
                    titleEl.classList.add('fw-normal');

                    const badgeEl = notificationEl.querySelector('.badge');
                    if (badgeEl) badgeEl.remove();

                    const markReadBtn = notificationEl.querySelector('.mark-read-btn');
                    if (markReadBtn) markReadBtn.remove();
                }

                // Close modal if open
                notificationDetailModal.hide();
            })
            .catch(error => {
                console.error('Error marking notification as read:', error);
            });
    }

    // Delete notification
    function deleteNotification(notificationId) {
        if (!confirm('Are you sure you want to delete this notification?')) {
            return;
        }

        axios.delete(`/notifications/${notificationId}`)
            .then(response => {
                // Remove from UI
                const notificationEl = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (notificationEl) {
                    notificationEl.remove();
                }

                // Close modal if open
                notificationDetailModal.hide();

                // Check if no notifications left and show empty state
                const remainingNotifications = document.querySelectorAll('[data-notification-id]');
                if (remainingNotifications.length === 0) {
                    document.getElementById('notifications-list').classList.add('d-none');
                    document.getElementById('no-notifications').classList.remove('d-none');
                    document.getElementById('pagination-container').innerHTML = '';
                }
            })
            .catch(error => {
                console.error('Error deleting notification:', error);
            });
    }

    // Mark all notifications as read
    document.getElementById('mark-all-read-btn').addEventListener('click', function() {
        axios.post('/notifications/mark-all-read')
            .then(response => {
                // Reload notifications
                loadNotifications(currentPage, currentFilter);
            })
            .catch(error => {
                console.error('Error marking all notifications as read:', error);
            });
    });

    // Delete all notifications
    document.getElementById('delete-all-btn').addEventListener('click', function() {
        axios.delete('/notifications/delete-all')
            .then(response => {
                // Show empty state immediately
                document.getElementById('notifications-list').classList.add('d-none');
                document.getElementById('no-notifications').classList.remove('d-none');
                document.getElementById('pagination-container').innerHTML = '';
                document.getElementById('loading-notifications').classList.add('d-none');
            })
            .catch(error => {
                console.error('Error deleting all notifications:', error);
            });
    });

    // Handle modal mark as read button
    document.getElementById('mark-as-read-btn').addEventListener('click', function() {
        const notificationId = this.getAttribute('data-notification-id');
        markAsRead(notificationId);
    });

    // Handle modal delete button
    document.getElementById('delete-notification-modal-btn').addEventListener('click', function() {
        const notificationId = document.getElementById('mark-as-read-btn').getAttribute('data-notification-id');
        deleteNotification(notificationId);
        notificationDetailModal.hide();
    });

    // Filter buttons
    document.querySelectorAll('[data-filter]').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');

            // Load filtered notifications
            currentFilter = this.getAttribute('data-filter');
            loadNotifications(1, currentFilter);
        });
    });

    // Helper functions
    function getNotificationIconClass(type) {
        switch(type) {
            case 'enrollment_request': return 'bi bi-person-plus';
            case 'assignment_approved': return 'bi bi-check-circle';
            case 'assignment_rejected': return 'bi bi-x-circle';
            case 'client_withdrawal': return 'bi bi-person-dash';
            case 'program_completed': return 'bi bi-trophy';
            default: return 'bi bi-info-circle';
        }
    }

    function getNotificationIconBackgroundClass(type) {
        switch(type) {
            case 'enrollment_request': return 'bg-primary text-white';
            case 'assignment_approved': return 'bg-success text-white';
            case 'assignment_rejected': return 'bg-danger text-white';
            case 'client_withdrawal': return 'bg-warning text-white';
            case 'program_completed': return 'bg-info text-white';
            default: return 'bg-secondary text-white';
        }
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    // Initial load
    loadNotifications();
});
</script>
@endpush
