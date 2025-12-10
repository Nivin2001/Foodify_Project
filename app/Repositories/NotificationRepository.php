<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\UserNotification;

class NotificationRepository
{
    public function getUserNotifications($userId)
    {
        return Notification::where('notifiable_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
        }
        return $notification;
    }
}
