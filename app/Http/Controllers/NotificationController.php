<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    /**
     * Get user's notifications
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Display the notifications page
     */
    public function showNotificationsPage()
    {
        $user = Auth::user();

        if ($user->user_type === 'trainer') {
            return view('trainer.notifications.index');
        } else {
            return view('client.notifications.index');
        }
    }

    /**
     * Get a specific notification
     */
    public function show($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'id' => $notification->id,
            'title' => $notification->title,
            'message' => $notification->message,
            'type' => $notification->type,
            'is_read' => (bool) $notification->is_read,
            'created_at' => $notification->created_at->toISOString(),
            'data' => $notification->data,
        ]);
    }


    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
                'type' => $notification->type,
                'is_read' => (bool) $notification->is_read,
                'created_at' => $notification->created_at->toISOString(),
                'data' => $notification->data,
            ]
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read'
        ]);
    }
    

    /**
     * API endpoint to get all notifications for the current user
     */
    public function getAll(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        // Apply filter if provided
        if ($request->has('filter') && $request->filter !== 'all') {
            if ($request->filter === 'unread') {
                $query->where('is_read', false);
            } else {
                $query->where('type', $request->filter);
            }
        }

        // Apply pagination
        $perPage = $request->input('per_page', 20);
        $notifications = $query->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json($notifications);
    }


    /**
     * Delete a specific notification
     */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted successfully'
        ]);
    }

    /**
     * Delete all notifications for the current user
     */
    public function deleteAll()
    {
        Notification::where('user_id', Auth::id())->delete();

        return response()->json([
            'success' => true,
            'message' => 'All notifications deleted successfully'
        ]);
    }

    /**
     * Get unread count
     */
    public function unreadCount()
    {
        $count = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }
}
