<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $page = UserNotification::query()
            ->select('id', 'title', 'content', 'read', 'created_at')
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $page->transform(function($model) {
            return [
                'id' => $model->id,
                'title' => $model->title,
                'content' => $model->content,
                'read' => $model->read,
                'created_at' => Carbon::parse($model->created_at)->format('d/m/Y H:i')
            ];
        });

        return response()
            ->json(compact('page'));
    }

    public function markAsRead($userNotificationId)
    {
        UserNotification::query()
            ->where('user_id', auth()->user()->id)
            ->where('id', $userNotificationId)
            ->update(['read' => true]);

        return response()
            ->noContent(200);
    }

    public function unreadMessages(Request $request)
    {
        $count = UserNotification::query()
            ->where('user_id', $request->user()->id)
            ->where('read', false)
            ->count();

        return response()
            ->json(compact('count'));
    }

}
