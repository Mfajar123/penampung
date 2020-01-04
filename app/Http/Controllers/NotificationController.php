<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Notification;

class NotificationController extends Controller
{
    public function send_notification($role, $id, $message, $route)
    {
        $notification = Notification::create([
            'role' => $role,
            'id' => $id,
            'message' => $message,
            'route' => $route
        ]);
    }

    public function read_notification($id_notification)
    {
        $notification = Notification::findOrFail($id_notification);
        
        $notification->update(['is_read', 'Y']);
    }
}
