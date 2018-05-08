@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($questions as $question)
                    <div class="media">
                        <div class="media-left">
                            <a href="">
                                <img class="avatar_img" src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h6 class="media-heading">
                                <a href="/questions/{{ $question->id }}">
                                    {{ $question->title }}
                                </a>
                            </h6>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
@endsection

