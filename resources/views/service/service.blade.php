@extends('layouts.app')

@section('title', $service->name)
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">{{$service->name}}
                    @can('update', $service)
                        <span class="good-link pull-right" style="margin-left: 10px;">
                            <a href="/service/{{$service->id}}/delete" class="btn btn-primary std">Удалить</a>
                        </span>
                        <span class="good-link pull-right">
                            <a href="/service/{{$service->id}}/edit" class="btn btn-primary std">Редактировать услугу</a>
                        </span>
                    @endcan
                </div>
                <div class="page-content">
					<div class="good-card">
                        <div>
                            <span class="good-title" style="font-size: 24px;">{{$service->name}}</span>
                            <span class="good-date pull-right">{{$service->created_at->format('j.m.Y H:i')}}</span>
                        </div>
                        <div class="h5">
                            <span class="f-good-price"><strong style="color: #65c178;">{{$service->cost}} ₽</strong></span>
                            <span class="pull-right">Просмотров: {{$service->views}}</span>
                        </div>
                        <div class="h5">Категория: <a href="/catalog/cat/{{$service->cat->id}}">{{$service->cat->name}}</a></div>
                        <div class="h5">Исполнитель: <a href="/profile/{{$service->user->id}}">{{$service->user->firstname .' '. $service->user->surname}}</a> ({{$service->user->phone}})</div>
                        <div class="h5">{{$service->descr}}</div>
                        @can('deal', $service)
                        <a href="/service/{{$service->id}}/deal">
                            <button class="btn btn-primary std">
                                Заказать услугу
                            </button>
                        </a>
                        @endcan
                        <div class="page-title">Галерея</div>
                        <div class="nav row gallery" style="padding-top: 20px;">
                            @foreach($service->images as $image)
                                <a data-sub-html="" href="/images/uploads/{{$image->module()}}/{{$image->file}}">
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
