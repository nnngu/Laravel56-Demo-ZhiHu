<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionsController extends Controller
{
    protected $questionRepository;

    /**
     * QuestionsController constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->questionRepository = $questionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = $this->questionRepository->getQuestionsFeed();
//        dd(compact('questions'));
        return view('questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('questions.make');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        $topics = $this->questionRepository->normailzeTopic($request->get('topics'));
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => Auth::id(),
        ];
        $question = $this->questionRepository->create($data);
        $question->topics()->attach($topics);
        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = $this->questionRepository->byIdWithTopicsAndAnswers($id);
//        dd($question->toArray());
//        dd(json_decode($question, true));
//        dd($question);

//        print_r($question);
//        die;

        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question)) {
            return view('questions.edit', compact('question'));
        }

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreQuestionRequest $request, $id)
    {
        $question = $this->questionRepository->byId($id);
        $topics = $this->questionRepository->normailzeTopic($request->get('topics'));

        $question->update([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        $question->topics()->sync($topics);
        return redirect()->route('questions.show', [$question->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = $this->questionRepository->byId($id);

        if(Auth::user()->owns($question)) {
            $question->delete();
            return redirect('/');
        }

        abort(403, 'Forbidden'); // return back();
    }


}
