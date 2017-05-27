@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                @if(config('project.enableService'))
                    <div class="page-title">
                        <span>Каталог услуг</span>
                        <a href="/service/add" class="btn btn-primary pull-right">Добавить</a>
                    </div>
                    @if(count($user->service))
                        <?php $services = $user->service()->paginate(config('project.pagination.profile.services'));?>
                        @foreach($user->service as $key => $service)
                            <div class="good-card">
                                <div>
                                    <span class="good-title"><a href="/service/{{$service->id}}">{{$service->name}}</a></span><span class="good-separate"> / </span><span class="good-cat">{{$service->cat->name}}</span>
                                    <span class="good-date pull-right">{{$service->created_at->format('j.m.Y H:i')}}</span>
                                </div>
                                <a class="good-link pull-right" role="button" data-toggle="collapse" href=".collapse-service-{{$service->id}}" aria-expanded="false" aria-controls="collapseExample">Показать подробности</a>
                                <div><span class="good-price">{{$service->cost}} ₽</span></div>
                                <div class="collapse collapse-service-{{$service->id}}">
                                    <div style="margin-top: 10px;">{{$service->descr}}</div>
                                    <div class="gallery infinite-slide" style="margin-top: 10px;">
                                        @foreach($service->images as $image)
                                            <a data-sub-html="" href="/images/uploads/{{strtolower($image->module)}}/{{$image->file}}">
                                                <img src="/images/uploads/{{strtolower($image->module)}}/{{$image->file}}" class="pull-left" style="height: 100px; margin: 0 3px;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        @endforeach
                            {{$services->render()}}
                    @else
                        <br>
                        <div class="row">
                            <div class="col-md-24 text-center">
                                Вы еще не добавили ни одной услуги.
                            </div>
                        </div>
                    @endif

                    <div class="clearfix offset-40"></div>
                @endif
            </div>
        </div>
    </div>
@endsection