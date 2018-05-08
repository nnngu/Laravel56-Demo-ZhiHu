<?php
/**
 * Created by PhpStorm.
 * Author: nnngu
 * Date: 08/05/2018
 * Time: 15:49
 */

namespace App\Repositories;


use App\Question;
use App\Topic;

class QuestionRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function byIdWithTopicsAndAnswers($id)
    {
        return Question::where('id', $id)->with(['topics', 'answers'])->first();
    }

    public function create(array $attributes)
    {
        return Question::create($attributes);
    }

    public function normailzeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic) {
            if(is_numeric($topic)) {
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic = Topic::create(['name' => $topic, 'questions_count' => 1]);
            return $newTopic->id;
        })->toArray();
    }

    public function byId($id)
    {
        return Question::find($id);
    }

    public function getQuestionsFeed()
    {
        return Question::published()->latest('updated_at')->with('user')->get();
    }
}