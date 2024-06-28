<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Display the notifications page
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('notifications.index', compact('notifications'));
    }

    // Get the count of unread notifications
    public function getUnreadNotificationCount(Request $request)
    {
        $count = Notification::where('user_id', auth()->id())
                             ->where('read', false)
                             ->count();

        return response()->json(['count' => $count]);
    }

    // Mark all notifications as read
    public function markAllAsRead(Request $request)
    {
        Notification::where('user_id', auth()->id())->where('read', false)->update(['read' => true]);
        return redirect()->route('notifications');
    }
}



