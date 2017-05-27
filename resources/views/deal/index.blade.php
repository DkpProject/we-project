@extends('layouts.app')
@section('seller', ($deal->module()=="catalog")?"Продавец":"Исполнитель")
@section('purchaser', ($deal->module()=="catalog")?"Покупатель":"Заказчик")
@section('item1', ($deal->module()=="catalog")?"отправки":"оказания")
@section('item2', ($deal->module()=="catalog")?"товара":"услуги")
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Сделка между @name($deal->seller->surname.' '.$deal->seller->firstname, 'ablativus') и @name($deal->purchaser->surname . ' ' . $deal->purchaser->firstname, 'ablativus')</div>
                <div class="page-content">
					<div class="row">
						<div class="col-md-24">
                            <div class="">@yield('seller'): <a href="/profile/{{$deal->seller->id}}">{{$deal->seller->firstname}} {{$deal->seller->surname}}</a> ({!! \App\Helpers\TextToImage::convert($deal->seller->phone) !!})</div>
                            <div class="">@yield('purchaser'): <a href="/profile/{{$deal->purchaser->id}}">{{$deal->purchaser->firstname}} {{$deal->purchaser->surname}}</a> ({!! \App\Helpers\TextToImage::convert($deal->purchaser->phone) !!})</div>
                            <div class="">Создано: {{$deal->created_at->format('j/m/Y, H:i')}}</div>
                            <hr>
                            <div class="">Предмет сделки:
                                @if(!is_null($deal->item))
                                    <a href="/{{$deal->item->module()}}/{{$deal->item->id}}">{{$deal->item->name}}</a>
                                @else
                                    товар удален
                                @endif
                            </div>
                            <div class="">Сумма сделаки: @plural($deal->cost, 'рубль')</div>
                            <hr>
                            <div class="">Тип сделки: {{\App\Helpers\DealHelper::type($deal)}}</div>
                            <div class="">Стадия сделки:
                                {!!\App\Helpers\DealHelper::statuses($deal, true)!!}
                            </div>
                            @if(count($deal->receipts) && \App\Helpers\DealHelper::detectPerson($deal, $auth) == 'purchaser')
                            <hr>
                            <h4>Дополнительные квитанции</h4>
                            <table class="table table-hover">
                                @foreach($deal->receipts as $receipt)
                                <tr>
                                    <td style="vertical-align: middle">{{$receipt->action}}</td>
                                    <td style="vertical-align: middle">@plural($receipt->price, 'рубль')</td>
                                    <td>
                                        @if($receipt->paid)
                                            <span class="pull-right text-green">Оплачено</span>
                                        @else
                                        <a href="/deal/{{$deal->id}}/receipt/{{$receipt->id}}">
                                            <button class="btn btn-success pull-right">Оплатить</button>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            @endif
                            <hr>
                            <h4>Чат сделки</h4>
                            <div class="chat form-control">
                                @include('deal.chat')
                            </div>
                            @if ($deal->status != 4)
                            <form action="/deal/{{$deal->id}}" data-id="{{$deal->id}}" method="post" class="text-right chat-send">
                                {{csrf_field()}}
                                <input type="text" name="comment" class="styler pull-left" style="margin-top: 10px; display: inline-block;">
                                <span class="ajax-error hide" style="color: red; margin-right: 10px; position: relative; top: 6px;"></span>
                                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Отправить</button>
                            </form>
                            @endif
                            <hr>
                            @if (
                            \App\Helpers\DealHelper::detectPerson($deal, $auth) == 'purchaser' &&
                            $deal->state != 'finished' &&
                            $deal->state != 'canceled' &&
                            (
                                $deal->state == 'initial' ||
                                ($deal->type=='buy' && $deal->status == 2) ||
                                (
                                    $deal->type=='rent' &&
                                    ($deal->status == 2 ||$deal->status == 3 || $deal->status == 4 )
                                )
                            )
                            )
                            <h4>Подтверждение получения @yield('item2')</h4>
                            <form action="/deal/{{$deal->id}}/purchaser" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-md-8 control-label">Комментарий</label>

                                    <div class="col-md-12">
                                        <textarea id="name" type="text" class="form-control" name="comment"></textarea>
                                    </div>
                                </div>

                                @if (($deal->type == 'buy' && ($deal->state == 'initial' || $deal->state == 'inprogress')) || ($deal->status > 2 && $deal->status < 6 && $deal->type == 'rent'))
                                <div class="form-group">
                                    <label for="name" class="col-md-8 control-label">Рейтинг сделки</label>

                                    <div class="col-md-12">
                                        <input id="0" style="display: inline; height: 12px; margin-top: 10px; width: 20px;" type="radio" class="form-control" name="percent" value="0" required checked> <label for="0">0%</label>
                                        <input id="25" style="display: inline; height: 12px; margin-top: 10px; width: 20px;" type="radio" class="form-control" name="percent" value="25" required> <label for="25">25%</label>
                                        <input id="50" style="display: inline; height: 12px; margin-top: 10px; width: 20px;" type="radio" class="form-control" name="percent" value="50" required> <label for="50">50%</label>
                                        <input id="75" style="display: inline; height: 12px; margin-top: 10px; width: 20px;" type="radio" class="form-control" name="percent" value="75" required> <label for="75">75%</label>
                                        <input id="100" style="display: inline; height: 12px; margin-top: 10px; width: 20px;" type="radio" class="form-control" name="percent" value="100" required> <label for="100">100%</label>
                                    </div>
                                </div>
                                @endif

                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-8">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                                            Завершить сделку
                                        </button>
                                        @if ($deal->state == 'initial')
                                        <a href="/deal/{{$deal->id}}/cancel">
                                            <button type="button" class="btn btn-default" style="margin-top: 10px;">
                                                Отменить сделку
                                            </button>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            @endif
                            @if (
                            \App\Helpers\DealHelper::detectPerson($deal, $auth) == 'seller' &&
                            $deal->state != 'finished' &&
                            $deal->state != 'canceled' &&
                            (
                                $deal->state == 'initial' ||
                                ($deal->type=='buy' && $deal->status == 1) ||
                                (
                                    $deal->type=='rent' &&
                                    ($deal->status == 1 || $deal->status == 3 || $deal->status == 5 )
                                )
                            )
                            )
                            <h4>Подтверждение @yield('item1') @yield('item2')</h4>
                            <form action="/deal/{{$deal->id}}/seller" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="name" class="col-md-8 control-label">Комментарий</label>

                                    <div class="col-md-12">
                                        <textarea id="name" type="text" class="form-control" name="comment"></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-8">
                                        <button type="submit" class="btn btn-primary" style="margin-top: 10px;">
                                            Завершить сделку
                                        </button>
                                        @if ($deal->status < 2)
                                        <a href="/deal/{{$deal->id}}/cancel">
                                            <button type="button" class="btn btn-default" style="margin-top: 10px;">
                                                Отменить сделку
                                            </button>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                            @endif
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('.chat-send').on('submit', function (e) {
                var comment = $('.chat-send > input[name="comment"]');
                var button = $('.chat-send > button');
                var error = $('.chat-send > span.ajax-error');
                error.addClass('hide');
                button.html('<i class="fa fa-spinner fa-pulse"></i> Отправить');
                if (comment.val() != '') {
                    $.post("/ajax/deal/chat/"+$('.chat-send').data('id')+"/send", {
                                _token: window.Laravel.csrfToken,
                                comment: comment.val()
                    })
                    .success(function (data) {
                        $('.chat').html(data);
                        comment.val('');
                    })
                    .fail(function () {
                        error.html('Ошибка передачи данных').removeClass('hide');
                    });
                }
                button.html('Отправить');
                e.preventDefault();
            });

            function reloadChat() {
                $.post("/ajax/deal/chat/"+$('.chat-send').data('id')+"/reload", {
                    _token: window.Laravel.csrfToken
                })
                .success(function (data) {
                    $('.chat').html(data);
                });
            }
            setInterval(reloadChat, 5000);
        });
    </script>
@endsection
