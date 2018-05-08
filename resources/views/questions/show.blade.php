@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ $title }}
                        @foreach($topics as $topic)
                            <span class="topic">{{ $topic['name'] }}</span>
                        @endforeach
                    </div>

                    <div class="card-body">
                        {!! $body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-body img {
            width: 100%;
        }
    </style>
@endsection

