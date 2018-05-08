<?php
/**
 * Created by PhpStorm.
 * Author: nnngu
 * Date: 08/05/2018
 * Time: 23:49
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }
}