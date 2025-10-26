<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                        <button @click="markAllAsRead" class="text-sm font-medium text-emerald-600 hover:text-emerald-500">Mark all as read</button>
                    </div>
                </div>

                <div class="bg-gray-50">
                    <div x-data="notificationsPage()" x-init="init()">
                        <template x-if="loading">
                            <div class="text-center py-12">
                                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-emerald-500"></div>
                                <p class="mt-4 text-gray-500">Loading notifications...</p>
                            </div>
                        </template>

                        <template x-if="!loading && notifications.length === 0">
                            <div class="text-center py-12">
                                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                </svg>
                                <h3 class="mt-2 text-lg font-medium text-gray-900">No notifications yet</h3>
                                <p class="mt-1 text-sm text-gray-500">When you have new notifications, they'll show up here.</p>
                            </div>
                        </template>

                        <ul x-show="!loading && notifications.length > 0" class="divide-y divide-gray-200">
                            <template x-for="notification in notifications" :key="notification.id">
                                <li class="p-4 sm:p-6 hover:bg-gray-100" :class="{ 'bg-emerald-50': !notification.read_at }">
                                    <a :href="notification.data.link || '#'" class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-md font-semibold text-gray-900 truncate" x-text="notification.data.title"></p>
                                                <p class="text-sm text-gray-500" x-text="timeAgo(notification.created_at)"></p>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-600" x-text="notification.data.message"></p>
                                        </div>
                                        <div x-show="!notification.read_at" class="ml-2 flex-shrink-0 self-center">
                                            <span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                                        </div>
                                    </a>
                                </li>
                            </template>
                        </ul>

                        <!-- Pagination -->
                        <div x-show="!loading && pagination.last_page > 1" class="p-4 bg-white border-t border-gray-200 flex items-center justify-between">
                            <p class="text-sm text-gray-700">
                                Showing <span x-text="pagination.from"></span> to <span x-text="pagination.to"></span> of <span x-text="pagination.total"></span> results
                            </p>
                            <div class="flex-1 flex justify-between sm:justify-end">
                                <button @click="changePage(pagination.current_page - 1)" :disabled="!pagination.prev_page_url" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                                    Previous
                                </button>
                                <button @click="changePage(pagination.current_page + 1)" :disabled="!pagination.next_page_url" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function notificationsPage() {
    return {
        loading: true,
        notifications: [],
        pagination: {},
        init() {
            this.fetchNotifications();
        },
        fetchNotifications(page = 1) {
            this.loading = true;
            fetch(`{{ route("notifications.all") }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    this.notifications = data.data;
                    this.pagination = {
                        current_page: data.current_page,
                        from: data.from,
                        to: data.to,
                        total: data.total,
                        last_page: data.last_page,
                        next_page_url: data.next_page_url,
                        prev_page_url: data.prev_page_url,
                    };
                    this.loading = false;
                });
        },
        changePage(page) {
            if (page > 0 && page <= this.pagination.last_page) {
                this.fetchNotifications(page);
            }
        },
        markAllAsRead() {
            fetch('{{ route("notifications.mark-all-read.post") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            }).then(() => {
                this.notifications.forEach(n => n.read_at = new Date().toISOString());
            });
        },
        timeAgo(dateString) {
            const date = new Date(dateString);
            const seconds = Math.floor((new Date() - date) / 1000);
            let interval = seconds / 31536000;
            if (interval > 1) return Math.floor(interval) + " years ago";
            interval = seconds / 2592000;
            if (interval > 1) return Math.floor(interval) + " months ago";
            interval = seconds / 86400;
            if (interval > 1) return Math.floor(interval) + " days ago";
            interval = seconds / 3600;
            if (interval > 1) return Math.floor(interval) + " hours ago";
            interval = seconds / 60;
            if (interval > 1) return Math.floor(interval) + " minutes ago";
            return Math.floor(seconds) + " seconds ago";
        }
    }
}
</script>
