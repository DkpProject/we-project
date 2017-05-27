@extends('layouts.app')

@section('content')
    <div class="polls">
        <div class="page-title">Опросы</div>
        @if (!count(Auth::user()->specs))
            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i> Информация!</strong>
                Мы обнаружили, что у Вы не указали свои специализации и поэтому голосования могут быть недоступны. Исправить эту ситуацию можно на <a href="/profile/form">этой странице</a>, указав свои специализации.
            </div>
        @endif

        @if (count(Auth::user()->specs_list) || \App\Models\Poll::findPolls(0)->count())
            <div class="polls-cat">
                <div class="polls-cat-title" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapse-0" aria-expanded="false" aria-controls="collapseOne">
                    <h4 class="panel-title">
                        Общие опросы <span class="pull-right">Доступен @plural(\App\Models\Poll::findPolls(0)->count(), 'опрос')</span>
                    </h4>
                </div>
                <div id="collapse-0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="polls-list">
                        <ul>
                            @if(\App\Models\Poll::findPolls(0)->count())
                                @foreach(\App\Models\Poll::findPolls(0)->get() as $poll)
                                    <li class="poll-row">
                                        <a href="/polls/{{$poll->id}}">
                                            <div class="pull-right questions">@plural($poll->questions->count(), 'вопрос')</div>
                                            <i class="fa fa-question"></i>
                                            <div class="poll-title">
                                                {{ $poll->name }}
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-center margin-top">Опросы не найдены</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            @foreach(Auth::user()->specs as $cat)
                <div class="polls-cat">
                    <div class="polls-cat-title" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$cat->id}}" aria-expanded="false" aria-controls="collapseOne">
                        <h4 class="panel-title">
                            {{$cat->name}} <span class="pull-right">Доступно @plural(\App\Models\Poll::findPolls($cat->id)->count(), 'опрос')</span>
                        </h4>
                    </div>
                    <div id="collapse-{{$cat->id}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="polls-list">
                            <ul>
                                @if(\App\Models\Poll::findPolls($cat->id)->count())
                                    @foreach(\App\Models\Poll::findPolls($cat->id)->get() as $poll)
                                    <li class="poll-row">
                                        <a href="/polls/{{$poll->id}}">
                                            <div class="pull-right questions">@plural($poll->questions->count(), 'вопрос')</div>
                                            <i class="fa fa-question"></i>
                                            <div class="poll-title">
                                                {{ $poll->name }}
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                @else
                                    <li class="text-center margin-top">Опросы не найдены</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="text-center margin-top">Опросы не найдены</div>
        @endif
    </div>


@endsection