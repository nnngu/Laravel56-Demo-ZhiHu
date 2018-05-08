@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $title }}
                        <span class="topic_span">
                        @foreach($topics as $topic)
                            <a class="topic" href="/topic/{{ $topic['id'] }}">{{ $topic['name'] }}</a>
                        @endforeach
                        </span>
                    </div>

                    <div class="card-body">
                        {!! $body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->ownByQuestion($user_id))
                            <span class="edit"><a href="/questions/{{ $id }}/edit">编辑</a></span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

