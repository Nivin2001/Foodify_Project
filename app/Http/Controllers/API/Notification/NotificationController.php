<?php

namespace App\Http\Controllers\API\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
     public function __construct(private NotificationService $service){}

    // استرجاع كل الإشعارات
    // public function index()
    // {
    //     $notifications = $this->service->getUserNotifications(auth()->id());
    //     return NotificationResource::collection($notifications);
    // }

 public function index()
    {
        $user = auth()->user();

        // ترتيب من الأحدث → الأقدم
        $notifications = $user->notifications()->latest()->get();

        return NotificationResource::collection($notifications);
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()
            ->notifications()
            ->find($id);

        if (!$notification) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $notification->markAsRead();

        return new NotificationResource($notification);
    }
}
