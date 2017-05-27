@foreach($deal->messages as $message)
    <div class="message {{($message->finish)?'end':''}} {{($message->user_id)?'':'system'}}">
        @if ($message->user_id)
            <span class=""><a href="/profile/{{$message->user->id}}">{{$message->user->firstname}} {{$message->user->surname}}</a> {{($message->finish)?'выполнил свои обязательства':''}}</span>
        @else
            <span class="">Система</span>
        @endif
        <span class="pull-right">{{$message->created_at->format("j/m/Y, H:i")}}</span>
        <div class="text">{{$message->comment}}</div>
    </div>
@endforeach