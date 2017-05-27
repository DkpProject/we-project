@extends('layouts.app')

@section('title', 'Профиль пользователя ' . morphos\Russian\nameCase($user->surname . ' ' . $user->firstname, 'genetivus'))


@section('content')
    <div class="row">
        <div class="col-md-24">
			<div class="page-wrap">
                <div class="modal fade report-form" tabindex="-1" role="dialog" aria-labelledby="report-form">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="/profile/{{$user->id}}/report" method="post">
                                {{csrf_field()}}
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Жалоба на @name($user->surname .' '. $user->firstname, 'genetivus')</h4>
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
				<div class="page-title">{{$user->surname . ' ' . $user->firstname, 'genetivus'}}
                    @if($auth->id == 1)
                        <a href="/admin/balance" class="btn btn-primary std pull-right" style="margin-left: 10px;">Баланс ДКП</a>
                    @endif
                    @cannot('mine', $user)
                        <a href="javascript://" data-toggle="modal" data-target=".report-form" class="btn btn-danger std pull-right" style="margin-left: 10px;">Пожаловаться</a>
                    @endcannot
                    @can('mine', $user)
                        <a href="/profile/password" class="btn btn-primary std pull-right" style="margin-left: 10px;">Изменить пароль</a>
                    @endcan
                    @can('mine', $user)
                        <a href="/profile/form" class="btn btn-primary std pull-right">Редактировать анкету</a>
                    @endcan
                    @cannot('mine', $user)
                        <a href="/chat/{{$user->id}}" class="btn btn-primary std pull-right">Открыть диалог</a>
                    @endcannot
                </div>

				<div class="page-content">
					<img class="avatar pull-left" style="margin-right: 30px; max-width:150px; max-height:180px;" src="/images/uploads/{{$images->module()}}/{{$images->file}}">
                    @can('meAndMyTeam', $user)
					<div class="h5">
                        <i class="fa fa-phone i-profile fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Номер телефона"></i>
                        {!! \App\Helpers\TextToImage::convert($user->phone) !!}
                    </div>
                    @endcan
                    @can('meAndMyTeam', $user)
					<div class="h5">
                        <i class="fa fa-envelope-o i-profile fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Адрес электронной почты"></i>
                        <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                    </div>
                    @endcan
					<div class="h5">
                        <i class="fa fa-calendar-plus-o i-profile fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Дата регистрации в системе"></i>
                        {{ $user->created_at->format('j.m.Y') }}
                    </div>
                    @if(count($user->specs_list))
					<div class="h5">
                        <i class="fa fa-address-book i-profile fa-fw pull-left" style="margin-right: 15px;" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Специальности"></i>
                        <ul style="list-style: none; margin: 0px; padding-left: 34px;">
                        @foreach($user->specs_list as $spec)
                            <li>{{$spec->spec->name}}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif
					<div class="h5">
                        <i class="fa fa-user i-profile fa-fw" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Группа польователя"></i>
                        {{(is_string($user->group()))? $user->group() : $user->group()->getRole()->name }}
                    </div>
                    @can('mine', $user)
                        @if(!is_string($user->group()))
                        <br>
                        <div class="h5">До статуса "{{$user->group()->getNextRole()->name}}" осталось:</div>
                        @foreach($user->group()->getProgress() as $rule)
                            @if($rule->value && round($rule->count/$rule->value*100) < 100)
                                @if($rule->type == 'invites')
                                    Приглашенных пользователей:
                                @elseif($rule->type == 'goods')
                                    Стоимость добавленных товаров:
                                @elseif($rule->type == 'reg')
                                    Дней регистрации:
                                @elseif($rule->type == 'polls')
                                    Пройдено общих опросов:
                                @elseif($rule->type == 'deals')
                                    Завершено сделок:
                                @endif{{$rule->count}} / {{$rule->value}}
                                <div class="progress" style="margin-bottom: 5px;">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="{{$rule->count}}" aria-valuemin="0" aria-valuemax="{{$rule->value}}" style="min-width: 2em; width: {{min(round($rule->count/$rule->value*100), 100)}}%;">
                                        {{min(round($rule->count/$rule->value*100), 100)}}%
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @endif
                    @endcan

					<div class="clearfix offset-40"></div>

					@can('meAndMyTeam', $user)
                    @can('mine', $user)
                        <div class="page-subtitle">
                            <span>Баланс</span>
                            <a class="btn btn-primary pull-right" style="margin-left: 10px;">Пополнить</a>
                            <a class="btn btn-primary pull-right" href="/profile/transfer" style="margin-left: 10px;">Перевести</a>
                            <a class="btn btn-primary pull-right" href="/profile/request" style="margin-left: 10px;">Запросить</a>
                            <a class="btn btn-primary pull-right" role="button" data-toggle="collapse" href=".collapse-balance-history" aria-expanded="false" aria-controls="collapseExample">История действий</a>
                        </div>
                        <div class="h5"><span class="t">На активном счету:</span> <strong>@money($user->activeBalance(), 'рубль')</strong></div>
                        <div class="h5"><span class="t">На пассивном счету:</span> <strong>@money($user->passiveBalance(), 'рубль')</strong></div>
                        <div class="collapse collapse-balance-history">
                            <div style="margin-bottom: 5px;">История операций:</div>
                            <div class="action form-control">
                                @foreach($user->balanceLog()->get() as $message)
                                    <div class="message">
                                        <span class="pull-right">{{$message->created_at->format("j.m.Y H:i")}}</span>
                                        <div class="text">{!! \App\Helpers\Balance::getBalanceLog($message) !!}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="clearfix offset-40"></div>
                    @endcan

                    @can('myTeam', $user)
                        @if(config('project.enableCatalog'))
                            <div class="page-title">
                                <span>Каталог вещей</span>
                            </div>
                            @if(count($user->catalog))
                                <?php $catalog = $user->catalog()->paginate(config('project.pagination.profile.goods')); ?>
                                @foreach($catalog as $key => $good)
                                    <div class="good-card">
                                        <div>
                                            <span class="good-title"><a href="/catalog/{{$good->id}}">{{$good->name}}</a></span><span class="good-separate"> / </span><span class="good-cat">{{$good->cat->name}}</span>
                                            <span class="good-date pull-right">{{$good->created_at->format('j.m.Y H:i')}}</span>
                                        </div>
                                        <a class="good-link pull-right" role="button" data-toggle="collapse" href=".collapse-good-{{$good->id}}" aria-expanded="false" aria-controls="collapseExample">Показать подробности</a>
                                        <div>{{$good->used ? 'Подержанный' : 'Новый'}} / <span class="good-price">{{$good->cost}} ₽</span></div>
                                        <div class="collapse collapse-good-{{$good->id}}">
                                            <div style="margin-top: 10px;">{{$good->descr}}</div>
                                            <div class="gallery infinite-slide" style="margin-top: 10px;">
                                                @foreach($good->images as $image)
                                                    <a data-sub-html="" href="/images/uploads/{{$image->module()}}/{{$image->file}}">
                                                        <img src="/images/uploads/{{$image->module()}}/{{$image->file}}" class="pull-left" style="height: 100px; margin: 0 3px;">
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                @endforeach
                                {{$catalog->render()}}
                            @else
                                <br>
                                <div class="row">
                                    <div class="col-md-24 text-center">
                                        Этот пользователь не продает ни одной вещи
                                    </div>
                                </div>
                            @endif

                            <div class="clearfix offset-40"></div>
                        @endif
                    @endcan

                    @can('myTeam', $user)
                        @if(config('project.enableService'))
                            <div class="page-title">
                                <span>Каталог услуг</span>
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
                                        Этот пользователь не зарегистрировал ни одной услуги
                                    </div>
                                </div>
                            @endif

                            <div class="clearfix offset-40"></div>
                        @endif
                    @endcan

                    @can('myTeam', $user)
                        <div class="page-subtitle"><span>Cделки</span></div>
                        <br>
                        @if(count($user->activeDeals()->get()))
                        <table width="100%" class="table">
                            <thead>
                                <th width="40%" class="text-center">Предмет сделки</th>
                                <th width="15%" class="text-center">Цена</th>
                                <th width="15%" class="text-center">Стадия</th>
                                <th width="15%" class="text-center"></th>
                            </thead>
                            @foreach($user->activeDeals()->get() as $key => $deal)
                                <tr>
                                    <td data-label="Предмет сделки" style="vertical-align: middle;"><a href="/{{$deal->item->module()}}/{{$deal->item->id}}">{{$deal->item->name}}</a></td>
                                    <td data-label="Цена" class="text-center" style="vertical-align: middle;">{{$deal->cost}} ₽</td>
                                    <td data-label="Стадия" class="text-center" style="vertical-align: middle;"><a data-toggle="tooltip" data-placement="top" title="Дата создания: {{$deal->created_at->format('j.m.Y H:i')}}" class="deal-stage
                                        @if ($deal->state == 'initial')deal-starter
                                        @elseif ($deal->state == 'inprogress')deal-process
                                        @elseif ($deal->state == 'finished')deal-finish
                                        @else deal-cancel
                                        @endif">{!!\App\Helpers\DealHelper::statuses($deal)!!}
                                        </a>
                                    </td>
                                    <td data-label="Подробнее" class="text-right"><a href="/deal/{{$deal->id}}"><i class="fa fa-angle-double-right fa-2x"></i></a></td>
                                </tr>
                            @endforeach
                        </table>
                        @else
                        <div class="row">
                            <div class="col-md-24 text-center">
                                У этого пользователя нет активных сделок
                            </div>
                        </div>
                        @endif
                    @endcan
					
					@endcan
				</div>
			</div>
        </div>
    </div>
    <link href="/css/lightgallery.min.css" rel="stylesheet">
    <link href="/css/slick.css" rel="stylesheet">
    <link href="/css/slick-theme.css" rel="stylesheet">
    <script src="/js/lightgallery.js"></script>
    <script src="/js/slick.min.js"></script>
    <script>
        $( document ).ready(function() {
            GalleryEnable($('.gallery'));
            SlideEnable($('.infinite-slide'));
        });
    </script>
@endsection
