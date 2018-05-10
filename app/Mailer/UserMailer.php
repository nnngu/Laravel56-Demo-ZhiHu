<?php
/**
 * Created by PhpStorm.
 * Author: nnngu
 * Date: 10/05/2018
 * Time: 21:45
 */

namespace App\Mailer;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = [
            'url' => 'http://laravel56.com', 'name' => Auth::guard('api')->user()->name,
        ];

        $this->sendTo('zhihu_app_new_user_follow', $email, $data);
    }

    public function passwordReset($email, $token)
    {
        $data = [
            'url' => url('password/reset', $token),
        ];
        $this->sendTo('zhihu_app_password_reset', $email, $data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify', ['token' => $user->confirmation_token]),
            'name' => $user->name
        ];
        $this->sendTo('zhihu_app_register', $user->email, $data);
    }
}