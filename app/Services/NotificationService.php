<?php

namespace App\Services;

use App\Repositories\NotificationRepository;

class NotificationService
{
    public function __construct(private NotificationRepository $repo){}

    public function getUserNotifications($userId)
    {
        return $this->repo->getUserNotifications($userId);
    }

    public function markAsRead($notificationId)
    {
        return $this->repo->markAsRead($notificationId);
    }
}
?>
