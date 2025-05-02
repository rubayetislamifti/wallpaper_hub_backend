<?php

namespace App\Http\Controllers;

use App\Services\FCMmsg;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $messaging;

    public function __construct(FCMmsg $messaging)
    {
        $this->messaging = $messaging;
    }

    public function sendNotification(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'title' => 'required|string',
            'body' => 'required|string',
        ]);

        $token = $request->input('token');
        $title = $request->input('title');
        $body = $request->input('body');

        if ($this->messaging->sendNotification($token, $title, $body)) {
            return response()->json(['message' => 'Notification sent successfully'], 200);
        } else {
            return response()->json(['message' => 'Failed to send notification'], 500);
        }
    }
}
