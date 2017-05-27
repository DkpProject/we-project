@extends('layouts.app')

@section('title', 'Диолог с ' . morphos\Russian\nameCase($user->surname . ' ' . $user->firstname, 'ablativus'))

@section('content')
    <div class="messages">
        <div class="page-title">Диолог с @name($user->surname . ' ' . $user->firstname, 'ablativus')</div>
        <div class="chat-conteiner">
            @include('messages.chat')
        </div>
        <div class="response">

            <textarea class="styler chat-send" data-id="{{$user->id}}" rows="3" placeholder="Введите сообщение..." name="text"></textarea>
            <i class="send-button fa fa-arrow-circle-right fa-3x"></i>
        </div>
    </div>
    <script>
        $('.send-button').click(function () {
            var text = $('.chat-send');
            if (text.val() != '') {
                $.post("/ajax/chat/"+$('.chat-send').data('id')+"/send", {
                    _token: window.Laravel.csrfToken,
                    text: text.val()
                })
                .success(function (data) {
                    $('.chat-conteiner').html(data);
                    text.val('');
                })
                .fail(function () {
                    //error.html('Ошибка передачи данных').removeClass('hide');
                });
            }
        });

        function reloadChat() {
            $.post("/ajax/chat/"+$('.chat-send').data('id')+"/reload", {
                _token: window.Laravel.csrfToken
            })
            .success(function (data) {
                $('.chat-conteiner').html(data);
            });
        }
        setInterval(reloadChat, 10000);
    </script>
@endsection