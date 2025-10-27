@props([
    'framework' => 'tailwind'
])

@if($framework === 'tailwind')
    <!-- Tailwind Empty State -->
    <div class="px-4 py-8 text-center text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                  d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications</h3>
        <p class="mt-1 text-sm text-gray-500">You're all caught up!</p>
    </div>
@else
    <!-- Bootstrap Empty State -->
    <div class="text-center py-4 px-3">
        <i class="bi bi-bell-slash fs-1 text-muted"></i>
        <h6 class="mt-3 mb-1">No notifications</h6>
        <p class="small text-muted mb-0">You're all caught up!</p>
    </div>
@endif
