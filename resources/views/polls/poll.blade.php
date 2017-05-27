@extends('layouts.app')

@section('content')
@if (count($errors->all()))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        Все вопросы являются обязательными!
    </div>
@endif
<div class="poll-page">
    <div class="page-title">Опрос "{{$poll->name}}"</div>
    <div class="poll-wizard">
        <form action="/polls/{{$poll->id}}" method="post">
            {{csrf_field()}}
            <div class="navbar">
                <div class="navbar-inner">
                        <ul>
                            @foreach($poll->questions as $value)
                                <li><a href="#question-{{$value->id}}" data-toggle="tab">Вопрос #{{$value->id}}</a></li>
                            @endforeach
                        </ul>
                </div>
            </div>
            <div id="bar" class="progress progress-small">
                <div class="progress-bar progress-bar-inverse"></div>
            </div>
            <div class="tab-content">
                @foreach($poll->questions as $value)
                <div class="tab-pane" id="question-{{$value->id}}">
                    <div class="text-center question"><b>{{$value->question}}</b></div>
                    <div class="answers">
                        <?
                        $answers = explode("\r\n", $value->answers);
                        $i=1;
                        ?>
                        @foreach($answers as $answer)
                            <label for="question-{{$value->id}}-{{$i}}">
                                <input id="question-{{$value->id}}-{{$i}}" type="radio" name="question-{{$value->id}}" {{(old('question-'.$value->id) == $answer)?'checked':''}} value="{{$answer}}" style="display: block;">{{$answer}}
                            </label>
                            <?$i++;?>
                        @endforeach
                    </div>
                </div>
                @endforeach
                <ul class="wizard control">
                    <li class="previous"><a href="javascript://"><i class="fa fa-caret-left"></i> &nbsp;Предыдущий</a></li>
                    <li class="next"><a href="javascript://">Следующий&nbsp; <i class="fa fa-caret-right"></i></a></li>
                    <li class="finish" style="display: none;"><button class="btn btn-success" type="submit" href="javascript://"><i class="fa fa-check"></i>&nbsp; Завершить</button></li>
                </ul>
            </div>
        </form>
    </div>
</div>
    <script type="text/javascript" src="/js/jquery.bootstrap.wizard.js"></script>
    <script>
        $(function () {
            $('.answers input').styler();
            $(".poll-wizard").bootstrapWizard({onTabShow: function(tab, navigation, index) {
                console.log(tab, navigation, index);
                var $total = navigation.find('li').length;
                var $current = index+1;
                var $percent = ($current/$total) * 100;
                var $wizard = $(".poll-wizard");
                $wizard.find('.progress-bar').css({width:$percent+'%'});

                if ($current >= $total) {
                    $('.wizard.control .next').hide();
                    $('.wizard.control .finish').show();
                } else {
                    $('.wizard.control .next').show();
                    $('.wizard.control .finish').hide();
                }
            }});
        });
    </script>
@endsection