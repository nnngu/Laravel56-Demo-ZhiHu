<?php
/**
 * Created by PhpStorm.
 * Author: nnngu
 * Date: 10/05/2018
 * Time: 21:39
 */

namespace App\Mailer;


use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    protected function sendTo($template, $email, array $data)
    {
        $content = new SendCloudTemplate($template, $data);

        Mail::raw($content, function ($message) use ($email) {
            $message->from(' 123456@qq.com', ' 知乎官方邮件');

            $message->to($email);
        });
    }
}