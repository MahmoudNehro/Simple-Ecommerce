<?php

namespace App\Http\Controllers\Admin\General;

use App\Helpers\MessageResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Cache;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(10);
        return view('admin.general.notifications.index', compact('notifications'));
    }
    public function read(DatabaseNotification $notification): Responsable
    {
        $notification->markAsRead();
        Cache::forget('unread_notifications_' . auth()->id());
        return new MessageResponse(
            message: 'Notification read successfully',
            body: [
                'notification' => $notification
            ],
        );
    }
    public function markAllAsRead() : RedirectResponse
    {
        auth()->user()->unreadNotifications->markAsRead();
        Cache::forget('unread_notifications_' . auth()->id());
        return redirect()->back();
    }
}
