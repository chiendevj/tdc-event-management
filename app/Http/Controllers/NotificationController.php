<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $now = Carbon::now();

        $notifications = Notification::where('status', 1)
            ->where(function ($query) use ($now) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>', $now);
            })
            ->get();

        // Check event of each notification
        foreach ($notifications as $notification) {
            $event = Event::find($notification->event_id);
            if ($event) {
                // Check if event is expired
                $expired = $event->event_end < $now;
                if ($expired) {
                    $notification->status = 0;
                    $notification->save();
                }

                // Check if status of event !== "Đã hủy"
                if ($event->status != "Đã hủy") {
                    $notification->status = 0;
                    $notification->save();
                }

                // Remove notification from notifications list if it's expired or event is cancelled
                if ($expired || $event->status != "Đã hủy") {
                    $notifications = $notifications->reject(function ($value, $key) use ($notification) {
                        return $value->id == $notification->id;
                    });
                }
            }
        }

        return response()->json(["data" => $notifications, "status" => "success", "message" => "Get notifications successfully"]);
    }
}
