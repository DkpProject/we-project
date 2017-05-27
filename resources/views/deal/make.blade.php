@extends('layouts.app')

@section('title', 'Новая сделка')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="modal fade buy-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Правила для покупки товара</h4>
                            </div>
                            <div class="modal-body">
                                Правила для покупки товара
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade rent-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Правила для аренды товара</h4>
                            </div>
                            <div class="modal-body">
                                Правила для аренды товара
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade service-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Правила для заказа услуги</h4>
                            </div>
                            <div class="modal-body">
                                Правила для заказа услуги
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-title">Новая сделка</div>
                <div class="page-content">
					{!! Form::open(array('url'=>'/'.$module.'/'.$item->id.'/deal','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="name" class="col-md-8 control-label">Владелец</label>

                            <div class="col-md-12">
								{{ $seller->firstname }} {{ $seller->surname }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="col-md-8 control-label">Стоимость@if($item->deal_type == "rent") в день@endif</label>

                            <div class="col-md-12">
								@plural($item->cost, 'рубль')
                            </div>
                        </div>

                        @if($module == 'catalog' && $item->deal_type == 'rent')
                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label for="address" class="col-md-8 control-label">Ваш адрес</label>

                                <div class="col-md-12">
                                    <input id="address" name="address" value="{{old('address')}}" class="styler" type="text" placeholder="Улица, дом, квартира">

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('address') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('datetime') ? ' has-error' : '' }}">
                                <label for="datetime" class="col-md-8 control-label">Удобные для Вас дата и время</label>

                                <div class="col-md-12">
                                    <input id="datetime" name="datetime" class="datetimepick styler" value="{{(is_null(old('datetime')))?'':old('datetime')}}" checked="" type="text" placeholder="Дата и время">

                                    @if ($errors->has('datetime'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('datetime') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('days') ? ' has-error' : '' }}">
                                <label for="days" class="col-md-8 control-label">Количество дней аренды</label>

                                <div class="col-md-12">
                                    <input id="days" type="number" class="styler" name="days" required min="1" value="{{ (old('days')) ? old('days') : '1' }}">

                                    @if ($errors->has('days'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('days') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="days" class="col-md-8 control-label"></label>

                            <div class="col-md-12">
                                @if($module == 'catalog')
                                    @if($item->deal_type == 'buy')
                                        <a href="javascript://" data-toggle="modal" data-target=".buy-rules">Правила и соглашения для покупки товара</a>
                                    @else
                                        <a href="javascript://" data-toggle="modal" data-target=".rent-rules">Правила и соглашения для аренды товара</a>
                                    @endif
                                @else
                                    <a href="javascript://" data-toggle="modal" data-target=".service-rules">Правила и соглашения для заказа услуги</a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Создать сделку
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="/js/moment-with-locales.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(function () {
            DateTimeEnable($('input.datetimepick'), true);
        });
    </script>
@endsection
