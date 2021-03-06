@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Каталог услуг</div>
                <div class="page-content">
					@if(count($service))
					@foreach($service as $good)
					<div class="good-card">
						<div class="col-md-6 col-xs-24 no-padding">
						<img src="/images/uploads/{{$good->images->first()->module()}}/{{$good->images->first()->file}}" class="pull-left" style="width:150px; margin-right: 30px;">
						</div>
						<div class="col-md-18 col-xs-24 no-padding">
						<div class="margin-xs"><span class="good-title"><a href="/service/{{$good->id}}">{{$good->name}}</a></span><span class="good-separate"> / </span><span class="good-date">{{$good->cat->name}}</span> <span class="good-date pull-right">{{$good->created_at->format('j.m.Y H:i')}}</span></div>
						<div><span class="good-price">{{$good->cost}} ₽</span></div>
						<div style="margin-top: 20px;">{{$good->descr}}</div>
						<a href="/service/{{$good->id}}" class="pull-right" style="margin-top: 20px;"><button class="btn btn-primary std">Подробнее</button></a>
						</div>
						<div class="clearfix"></div>
					</div>
					@endforeach
                        {{$service->render()}}
					@else
					<div class="row">
						<div class="col-md-24 text-center">
							Каталог услуг пуст.
						</div>
					</div>
					@endif
                </div>
            </div>
        </div>
    </div>
@endsection
