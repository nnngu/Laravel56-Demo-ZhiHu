<?php
/**
 * Created by PhpStorm.
 * Author: nnngu
 * Date: 10/05/2018
 * Time: 17:27
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendCloudChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendCloud($notifiable);
    }
}