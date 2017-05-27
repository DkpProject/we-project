<?\Carbon\Carbon::setLocale('ru')?>
@if(count($messages))
    @foreach($messages as $message)
        <div class="message">
            <div class="avatar-block">
                <img class="avatar" src="/images/uploads/user/{{ $message->author->images->first()->file }}">
            </div>
            <div class="chat_body">
                <span class="time pull-right">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($message->created_at))->diffForHumans() }}</span>
                <a href="/profile/{{$message->author->id}}">
                    <span class="title">{{$message->author->surname}} {{$message->author->firstname}}</span>
                </a>
                @if(!$message->type)
                    <p>{{$message->text}}</p>
                @else
                    @if($message->author->id != Auth::user()->id)
                        <p>{{$message->text}}
                            <a href="/profile/transfer/request?destination={{$message->author->id}}&sum={{$message->variable}}">
                                <button type="button" class="btn btn-success pull-right">Откликнуться</button>
                            </a>
                        </p>
                    @else
                        <p>Вы попросили этого пользователя переслать Вам @money($message->variable, 'рубль').</p>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@else
    <div class="text-center" style="margin: 20px 0;">Этот диалог пока пуст</div>
@endif