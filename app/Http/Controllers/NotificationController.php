<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        // Find the notification by its ID
        $notification = DatabaseNotification::find($id);
        // dd($notification->read_at);
        // Mark it as read
        if ($notification->read_at === null) {
            $notification->read_at = now();
            $notification->save();
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Notification marked as read.');
    }
}
