<?php

namespace App\View\Components;

use App\Models\Notification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class NotificationDropdown extends Component
{
    public $notifications;
    public $unreadCount;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $this->unreadCount = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        // Debug logging
        Log::info('NotificationDropdown component loaded', [
            'user_id' => Auth::id(),
            'total_notifications' => $this->notifications->count(),
            'unread_count' => $this->unreadCount
        ]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.notification-dropdown');
    }
}
