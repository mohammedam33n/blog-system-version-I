<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function getNotifications()
    {
        // dd('getNotifications');
        return [
            'read'      => auth()->user()->readNotifications,
            'unread'    => auth()->user()->unreadNotifications,
            'usertype'  => auth()->user()->roles->first()->name, //permissions
        ];
    }

    public function markAsRead(Request $request)
    {
        // dd('markAsRead');
        return auth()->user()->notifications->where('id', $request->id)->markAsRead();
    }

    public function markAsReadAndRedirect($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();
        $notification->markAsRead();

        // dd($notification);
        if (auth()->user()->roles->first()->name == 'user') {

            if ($notification->type == 'App\Notifications\NewCommentForPostOwnerNotify') {
                // dd('user');
                return redirect()->route('comment.edit', $notification->data['id']);
            } else {
                return redirect()->back();
            }
        }
    }
}
