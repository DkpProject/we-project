@extends('layouts.app')

@section('title', $good->name)
@section('content')
    <div class="row">
        <div class="col-md-24">
			<div class="page-wrap"><div class="modal fade report-form" tabindex="-1" role="dialog" aria-labelledby="report-form">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/catalog/{{$good->id}}/report" method="post">
                                {{csrf_field()}}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Жалоба на товар "{{$good->name}}"</h4>
                                </div>
                                <div class="modal-body">
                                    <textarea class="styler" name="message" style="width: 100%;" rows="5" placeholder="Опишите, пожалуйста, что именно нарушает это пользователь" minlength="5"></textarea>
                                    @if ($errors->has('message'))
                                        <span class="help-block text-red">
                                            <strong>{{ $errors->first('message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-danger">Отправить жалобу</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
				<div class="page-title">
				{{$good->name}}
                    @cannot('mine', $good->user)
                        <a href="javascript://" data-toggle="modal" data-target=".report-form" class="btn btn-danger std pull-right" style="margin-left: 10px;">Пожаловаться</a>
                    @endcannot
                    @can('update', $good)
                        <span class="good-link pull-right" style="margin-left: 10px;">
                            <a href="/catalog/{{$good->id}}/delete" class="btn btn-primary std">Удалить</a>
                        </span>
                        <span class="good-link pull-right">
                            <a href="/catalog/{{$good->id}}/edit" class="btn btn-primary std">Редактировать</a>
                        </span>
                    @endcan
				</div>
				<div class="page-content">
                    <div class="good-card">
                        <div>
                            <span class="f-good-price"><strong style="color: #65c178;">Стоимость: @money($good->cost, 'рубль')</strong></span>
                            <span class="good-date pull-right">{{$good->created_at->format('j.m.Y H:i')}}</span>
                        </div>
                        <div class="h5">
                            Категория: <a href="/catalog/cat/{{$good->cat->id}}">{{$good->cat->name}}</a>
                            <span class="pull-right">Просмотров: {{$good->views}}</span>
                        </div>
                        <div class="h5">
                            Состояние: {{$good->used ? 'Подержанный' : 'Новый'}}
                            @if($good->evaluation == 1)
                                <span class="pull-right">Ожидает оценки экспертом</span>
                            @elseif(!is_numeric($good->evaluation))
                                <span class="pull-right" style="color: orange;">Оценено экспертом: {{$good->evaluation}} руб.</span>
                            @endif
                        </div>
                        <div class="h5">Обнаруженные дефекты: @if ($good->limitations == '0')
                                не обнаружено
                            @elseif ($good->limitations == '1')
                                {{$good->flaw}}
                            @else
                                требуется ремонт
                            @endif</div>
                        <div class="h5">Тип сделки:  @if ($good->deal_type == 'buy')
                                продажа
                                @elseif ($good->deal_type == 'rent')
                                аренда
                                @elseif ($good->deal_type == 'service')
                                сервис
                                @elseif ($good->deal_type == 'store')
                                хранение
                                @elseif ($good->deal_type == 'selling')
                                реализация
                                @endif</div>
                        @if ($good->onlycash)
                        <div class="h5" style="color: blue; font-weight: bold; font-size: 16px;">Только наличные</div>
                        @endif
                        <div class="h5">Владелец: <a href="/profile/{{$good->user->id}}">{{$good->user->firstname .' '. $good->user->surname}}</a></div>
                        <div class="h5">Местоположение товара: @if($good->stock)
                            <span class="text-green">на складе</span>
                        @else
                            у пользователя ({{$good->user->userDistrict->name}})
                        @endif</div>
                        <div class="h5">{{$good->descr}}</div>
                        @can('deal', $good)
                        <a href="/catalog/{{$good->id}}/deal">
                            <button class="btn btn-primary std">
                                @if ($good->deal_type == 'rent')
                                    Арендовать
                                @else
                                    Купить
                                @endif
                            </button>
                        </a>
                        @endcan
                        <div class="page-title">Галерея</div>
                        <div class="nav row gallery" style="padding-top: 20px;">
                            @foreach($good->images as $image)
                                <a data-sub-html="" href="/images/uploads/{{$image->module()}}/{{$image->file}}" class="col-md-6 text-center">
                                    <img src="/images/uploads/{{$image->module()}}/{{$image->file}}" style="max-width: 150px; margin: 0 auto; max-height: 100px;">
                                </a>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>
                    </div>
				</div>
			</div>
        </div>
    </div>
    <link href="/css/lightgallery.min.css" rel="stylesheet">
    <script src="/js/lightgallery.js"></script>
    <link href="/css/slick.css" rel="stylesheet">
    <link href="/css/slick-theme.css" rel="stylesheet">
    <script src="/js/slick.min.js"></script>
    <script>
        $( document ).ready(function() {
            GalleryEnable($('.gallery'));
            $('.nav').slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                dots: true,
                infinite: false,
                arrows: false
            });
        });
    </script>
@endsection
