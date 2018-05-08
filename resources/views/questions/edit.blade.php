@extends('layouts.app')

@section('content')
@include('vendor.ueditor.assets')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">编辑问题</div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="/questions/{{ $question->id }}" method="post">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                        <label for="title">标题</label>
                        <input id="title" type="text" name="title" class="form-control" placeholder="请输入标题" value="{{ $question->title }}">
                        @if($errors->has('title'))
                        <div class="alert alert-danger">
                        <strong>{{ $errors->first('title') }}</strong>
                        </div>
                        @endif


                            <div class="form-group">
                                <select class="js-example-placeholder-multiple js-data-example-ajax form-control" name="topics[]" multiple="multiple" >
                                    @foreach($question->topics as $topic)
                                        <option value="{{ $topic->id }}" selected="selected">{{ $topic->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                        <br>

                        <label for="body">描述</label>
                        <script id="container" style="height: 200px;" name="body" type="text/plain">
                        {!! $question->body !!}
                        </script>

                        @if($errors->has('body'))
                        <div class="alert alert-danger">
                        <strong>{{ $errors->first('body') }}</strong>
                        </div>
                        @endif
                        <button class="btn btn-success pull-right" type="submit" style="float: right;">确认修改
                        </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



@section('js')
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

<!-- 加载select2 -->
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<!-- select2的组件 -->
<script>
$(document).ready(function () {
function formatTopic(topic) {
    return "<div class='select2-result-repository clearfix'>" +
    "<div class='select2-result-repository__meta'>" +
    "<div class='select2-result-repository__title'>" +
    topic.name ? topic.name : "Laravel" +
        "</div></div></div>";
}

function formatTopicSelection(topic) {
    return topic.name || topic.text;
}

$(".js-example-placeholder-multiple").select2({
    tags: true,
    placeholder: '请选择相关话题',
    minimumInputLength: 2,
    ajax: {
        url: '/api/topics',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term
            };
        },
        processResults: function (data, params) {
            return {
                results: data
            };
        },
        cache: true
    },
    templateResult: formatTopic,
    templateSelection: formatTopicSelection,
    escapeMarkup: function (markup) {
        return markup;
    }
});
});
</script>
@endsection