@extends('layouts.app')

@section('title', 'Личные сообщения')

@section('content')
    <?\Carbon\Carbon::setLocale('ru')?>
    <div class="dialogs">
        <div class="page-title">Ваши сообщения</div>
        @if(count($dialogs))
            @foreach($dialogs as $dialog)
                @if ($dialog->author->id == Auth::user()->id)
                    <?php $interlocutor = $dialog->recipient; ?>
                @else
                    <?php $interlocutor = $dialog->author; ?>
                @endif
                <a href="/chat/{{$interlocutor->id}}">
                    <div class="dialog">
                        <div class="avatar-block">
                            <img class="avatar" src="/images/uploads/user/{{ $interlocutor->images->first()->file }}">
                        </div>
                        <div class="chat_body">
                            <span class="time pull-right">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($dialog->created_at))->diffForHumans() }}</span>
                            <h3 class="title">{{$interlocutor->surname}} {{$interlocutor->firstname}}</h3>
                            <?php
                                $lastMess = \App\Models\Message::lastMessage(Auth::user()->id, $interlocutor->id);
                            ?>
                            <p class="{{($lastMess->read)?'':'unread'}}">{{$lastMess->text}}</p>
                        </div>

                        <div class="chatter_clear"></div>
                    </div>
                </a>
            @endforeach
        @else
            <div class="text-center" style="margin-top: 10px;">У Вас нет недавних диалогов</div>
        @endif
    </div>
@endsection