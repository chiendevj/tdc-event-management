<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $now = Carbon::now();

        $notifications = Notification::where('status', 1)
            ->where(function($query) use ($now) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', $now);
            })
            ->get();

        return response()->json(["data" => $notifications, "status" => "success", "message" => "Get notifications successfully"]);
    }
}
