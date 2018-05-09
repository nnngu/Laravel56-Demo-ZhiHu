@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="card">
                    <div class="card-header">
                        {{ $question->title }}
                        <span class="topic_span">
                        @foreach($question->topics as $topic)
                            <a class="topic" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                        @endforeach
                        </span>
                    </div>

                    <div class="card-body">
                        <div class="question-body">
                            {!! $question->body !!}
                        </div>
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/questions/{{ $question->id }}/edit">编辑</a></span>
                            <form action="/questions/{{ $question->id }}" method="post" class="delete-form">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header question-follow">
                        <h3>{{ $question->followers_count }}</h3>
                        <span>关注者</span>
                    </div>
                    <div class="card-body question-follow">

                        <question-follow-button question="{{$question->id}}">

                        </question-follow-button>

                        <a href="#editor" class="btn btn-primary">回答</a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-1">
                <div class="card">
                    <div class="card-header">
                        {{ $question->answers_count }} 个回答
                    </div>

                    <div class="card-body">


                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <a href="/user/{{ $answer->user->name }}">
                                        <img class="avatar_img" src="{{ $answer->user->avatar }}" alt="{{ $answer->user->name }}">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h6 class="media-heading">
                                        <a href="/user/{{ $answer->user->name }}">
                                            {{ $answer->user->name }}
                                        </a>
                                    </h6>
                                    {!! $answer->body !!}
                                </div>
                            </div>
                            <hr>
                        @endforeach


                        @if(Auth::check())
                            <form action="/questions/{{ $question->id }}/answer" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <script id="container" style="height: 120px;" name="body" type="text/plain">
                                        {!! old('body') !!}
                                    </script>

                                    @if($errors->has('body'))
                                    <div class="alert alert-danger">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </div>
                                    @endif
                                        <button class="btn btn-success pull-right" type="submit" style="float: right;">提交回答
                                        </button>
                                </div>
                            </form>
                        @else
                            <a href="{{ url('login') }}" class='btn btn-success btn-block'>登录后提交回答</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header question-follow">
                        <h5>关于作者</h5>
                    </div>
                    <div class="card-body question-follow">

                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img width=36 src="{{ $question->user->avatar }}" alt="{{ $question->user->name }}">
                                </a>
                            </div>
                            <div class="author_name" >
                                <h5 class="media-heading">
                                    <a href="">
                                        {{ $question->user->name }}
                                    </a>
                                </h5>
                            </div>
                        </div>


                        <div class="user-statics">
                            <div class="statics-item text-center">
                                <div class="statics-text">问题</div>
                                <div class="statics-count">{{ $question->user->questions_count }}</div>
                            </div>

                            <div class="statics-item text-center">
                                <div class="statics-text">回答</div>
                                <div class="statics-count">{{ $question->user->answers_count }}</div>
                            </div>

                            <div class="statics-item text-center">
                                <div class="statics-text">关注者</div>
                                <div class="statics-count">{{ $question->user->followers_count }}</div>
                            </div>
                        </div>


                        <question-follow-button question="{{$question->id}}">

                        </question-follow-button>

                        <a href="#editor" class="btn btn-primary">私信</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection






@section('js')
    @if(Auth::check())
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
    @endif
@endsection

