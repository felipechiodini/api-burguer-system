<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index(Request $request)
    {
        $page = UserNotification::query()
            ->select('id', 'title', 'content', 'read', 'created_at')
            ->where('user_id', $request->user()->id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return response()
            ->json(compact('page'));
    }

}
