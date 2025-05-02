<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCMmsg
{
    protected $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory)->withServiceAccount(storage_path('app/laravelsms-6ead3-firebase-adminsdk-hu91s-df56a82eb8.json'))
            ->createMessaging();
    }

    public function sendNotification($token, $title, $body)
    {
        $notification = Notification::create($title, $body);
        $message = CloudMessage::withTarget('token', $token)
            ->withNotification($notification);

        try {
            $this->messaging->send($message);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
