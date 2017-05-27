@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                @if(config('project.enableCatalog'))
                    <div class="page-title">
                        <span>Активные сделки</span>
                        <a href=".catalog-deals" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapseExample" class="btn btn-primary pull-right std">История сделок</a>
                    </div>
                    <div class="catalog-deals collapse">
                        @if(count($user->finishedDeals()->where('item_type', 'App\Models\Catalog')->get()))
                            <table width="100%" class="table">
                                <thead>
                                <th width="40%" class="text-center">Предмет сделки</th>
                                <th width="15%" class="text-center">Стоимость</th>
                                <th width="15%" class="text-center">Стадия</th>
                                <th width="15%" class="text-center"></th>
                                </thead>
                                @foreach($user->finishedDeals()->where('item_type', 'App\Models\Catalog')->get() as $key => $deal)
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
                                    У Вас нет завершенных сделок
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(count($user->activeDeals()->where('item_type', 'App\Models\Catalog')->get()))
                        <table width="100%" class="table">
                            <thead>
                            <th width="40%" class="text-center">Предмет сделки</th>
                            <th width="15%" class="text-center">Стоимость</th>
                            <th width="15%" class="text-center">Стадия</th>
                            <th width="15%" class="text-center"></th>
                            </thead>
                            @foreach($user->activeDeals()->where('item_type', 'App\Models\Catalog')->get() as $key => $deal)
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
                                У Вас нет активных сделок
                            </div>
                        </div>
                    @endif
                    <div class="page-title">
                        <span>Каталог вещей</span>
                        <a href="/catalog/add" class="btn btn-primary pull-right std" style="margin-left: 10px;">Добавить</a>
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
                                Вы еще не добавили ни одной вещи.
                            </div>
                        </div>
                    @endif

                    <div class="clearfix offset-40"></div>
                    @endif
            </div>
        </div>
    </div>
@endsection