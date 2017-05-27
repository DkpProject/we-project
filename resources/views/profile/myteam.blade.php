@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                @if(count($confirming))
                    <div class="page-title"><span>Ожидают подтверждения</span></div>
                    <div class="row">
                        @foreach($confirming as $key => $confirm)
                            <div class="col-md-8 text-center">
                                <h4>{{$confirm->surname.' '.$confirm->firstname}}</h4>
                                <img style="border-radius: 50%; width: 100px; height: 100px; margin: 5px;" src="/images/uploads/{{$confirm->images->first()->module()}}/{{$confirm->images->first()->file}}"><br>
                                Приглашен:<br>
                                <a href="/profile/{{$confirm->invited_by->user->id}}">@name($confirm->invited_by->user->surname.' '.$confirm->invited_by->user->firstname, 'ablativus')</a>
                                <br>
                                Истекает через:<br>
                                @if ($confirm->created_at->now()->diffInDays($confirm->created_at->addDays(7), false) > 0)
                                    @plural($confirm->created_at->now()->diffInDays($confirm->created_at->addDays(7)), 'день')
                                @elseif ($confirm->created_at->now()->diffInHours($confirm->created_at->addDays(7), false) > 0)
                                    <span style="color: red">@plural($confirm->created_at->now()->diffInHours($confirm->created_at->addDays(7)), 'час')</span>
                                @else
                                    <span style="color: red">@plural($confirm->created_at->now()->diffInMinutes($confirm->created_at->addDays(7)), 'минута')</span>
                                @endif
                                <br>
                                <a href="/profile/{{$confirm->id}}/confirm"><button class="btn btn-primary" style="margin-top: 10px;">Подтвердить</button></a>
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    <div class="clearfix offset-40"></div>
                @endif
                <div class="page-title">
                    <span>Приглашения @if($user->invited_by)(вы были приглашены <a href="/profile/{{$user->invited_by->user->id}}">{{$user->invited_by->user->surname . ' ' . $user->invited_by->user->firstname}}</a>)@endif</span>
                    <a href="/profile/invite/add" class="btn btn-primary pull-right std">Создать</a>
                </div>
                <br>
                @if(count($user->invites))
                    <div style="max-width: 100%; overflow: auto;">
                        <table width="100%" class="invites-table table table-striped">
                            <thead>
                            <th class="text-center" width="50%">Ключ</th>
                            <th class="text-center" width="50%">Статус</th>
                            </thead>
                            @foreach($user->invites as $invite)
                                <tr>
                                    <td data-label="Ключ" class="text-center" style="font-family: 'Courier New'">{!!($invite->used_by != 0) ? '<s>' : '<a href="'.url("/register/".$invite->key).'">'!!}{{$invite->key}}{!!($invite->used_by != 0) ? '</s>' : '</a>'!!}</td>
                                    <td data-label="Статус" class="text-center">
                                        {!!($invite->used_by != 0) ? 'Использовано: <a data-toggle="tooltip" data-placement="top" title="Дата использования: '.$invite->created_at->format('d.m.Y H:i').'" href="/profile/'.$invite->used['id'].'">'.morphos\Russian\nameCase($invite->used['surname'].' '.$invite->used['firstname'], 'ablativus').'</a>' : 'Не использовано'!!}
                                        @if($invite->used_by != 0 && count($invite->used->invites()->where('used_by', '<>', 0)->get()))
                                            <a href=".sub-invites" role="button" class="pull-right subinvites" data-toggle="collapse"><i class="fa fa-chevron-down"></i></a>
                                            <div class="sub-invites collapse">
                                            @foreach($invite->used->invites as $i)
                                                @if($i->used_by != 0)
                                                <div data-label="Статус" class="text-center">{!!($i->used_by != 0) ? '>>> <a data-toggle="tooltip" data-placement="top" title="Дата использования: '.$i->created_at->format('d.m.Y H:i').'" href="/profile/'.$i->used['id'].'">'.morphos\Russian\nameCase($i->used['surname'].' '.$i->used['firstname'], 'ablativus').'</a>' : 'Не использовано'!!}</div>
                                                @endif
                                            @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @else
                    <div class="row">
                        <div class="col-md-24 text-center">
                            Вы еще не создали ни одного приглашения.
                        </div>
                    </div>
                @endif
                    <script>
                        $("a.subinvites").click(function () {
                            var icon = $(this).find('i.fa');
                            if(icon.hasClass('fa-chevron-down')) {
                                icon.removeClass('fa-chevron-down');
                                icon.addClass('fa-chevron-up');
                            } else {
                                icon.removeClass('fa-chevron-up');
                                icon.addClass('fa-chevron-down');
                            }
                        });
                    </script>

            </div>
        </div>
    </div>
@endsection