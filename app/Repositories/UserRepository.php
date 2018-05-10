<?php
/**
 * Created by PhpStorm.
 * Author: nnngu
 * Date: 10/05/2018
 * Time: 09:52
 */

namespace App\Repositories;


use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
    }
}