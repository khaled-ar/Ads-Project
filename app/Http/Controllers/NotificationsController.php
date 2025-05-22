<?php

namespace App\Http\Controllers;

use Illuminate\Notifications\DatabaseNotification;

class NotificationsController extends Controller
{

    public function index() {
        return $this->generalResponse(request()->user()->notifications);
    }

    public function unreaded() {
        return $this->generalResponse(request()->user()->unreadNotifications);
    }

    public function readed() {
        return $this->generalResponse(request()->user()->readNotifications);
    }

    public function show(DatabaseNotification $notification) {
        return $this->generalResponse($notification);
    }

    public function delete(DatabaseNotification $notification) {
        return $this->generalResponse($notification->delete(), 'The notification has been moved to the recycle bin successfully.');
    }

    public function destroy(DatabaseNotification $notification) {
        return $this->generalResponse($notification->forceDelete(), 'The notification has been successfully removed from the recycle bin.');
    }

    public function mark_as_readed(DatabaseNotification $notification) {
        return $this->generalResponse($notification->markAsRead(), 'The notification has been successfully marked as read.');
    }

    public function mark_as_unreaded(DatabaseNotification $notification) {
        return $this->generalResponse($notification->markAsUnread(), 'The notification has been successfully marked as unread.');
    }
}
