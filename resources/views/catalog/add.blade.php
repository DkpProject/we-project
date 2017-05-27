@extends('layouts.app')

@section('title', 'Добавление новой вещи')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                {!! Form::open(array('url'=>'/catalog/add','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="page-title">Добавление вещи в каталог
                        <span class="good-show pull-right h5" style="margin-top: 5px;">Показывать объявление: <input type="checkbox" data-size="mini" class="switch" name="visible" value="1" {{ (old('visible')) ? 'checked' : '' }} style="margin-top: -5px;"></span>
                    </div>
                    <div class="page-content">
                        <div class="modal fade service-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Правила сервисного центра</h4>
                                    </div>
                                    <div class="modal-body">
                                        Текст правил сервисного центра
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade store-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Правила использования склада</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p><b>1.</b> Участник лично несет полную ответственность за законность вносимых предметов на складское хранение ДКП.</p>
                                        <p><b>2.</b> Запрещено внесение денежной и иных валют на складское хранение.</p>
                                        <p><b>3.</b> Складское хранение вносимых Участником предметов является бесплатным первые 7 суток. По истечении данного срока для предмета, определенного на складское хранение, настоящим пунктом установлен тариф из расчета “габариты/вес”. Минимальная цена 1 руб./сутки.</p>
                                        <p><b>4.</b> Доступ Участника к своему предмету, сданному на складское хранение, осуществляется только через Курьерскую Службу.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade selling-rules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Правила реализации вещи через ДКП</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Данная процедура предполагает продажу предмета участника, исключая необходимость участника заниматься постановкой на общий баланс вещей. Происходит существенная экономия времени Участника и максимально упрощается процедура продажа предмета. Данная процедура предполагает взимание 50% от реализованной стоимости в пользу ДКП, остальные 50% Участник получает на свой счет (актив) по факту продажи предмета.</p>
                                        <p><b>1.</b> Участник обращается с просьбой в ДКП забрать на реализацию определенные им вещи.</p>
                                        <p><b>2.</b> В удобное Участнику время приезжает курьер и забирает запрашиваемые Участником вещи.</p>
                                        <p><b>3.</b> Вещи Участника доставляются на склад (разборная площадка) и осматриваются кладовщиком.</p>
                                        <p><b>4.</b> То, что очевидно является вторсырьем, сразу отправляется (после ТТХ измерений) на вторичную реализацию.</p>
                                        <p><b>5.</b> Остальные вещи, имеющие разумное применение, благодаря сервису и реставрации, фотографируются и отправляются в профиль Участника.</p>
                                        <p><b>6.</b> Вещи после прохождения сервиса и реставрации выставляются на обозрение Участников ДКП для возможности покупки.</p>
                                        <p><b>7.</b> Если в течение 7 суток вещь не была куплена другими Участниками ДКП, администрация оставляет за собой право реализовать вещи любыми способами, по цене на своё усмотрение.</p>
                                        <p><b>8.</b> Выгода от сделки продажи вещей возвращается Участнику (владельцу выставленных на реализацию ДКП) в виде 50% её стоимости на активный счет.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade evaluation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Оценка товара специалистами</h4>
                                    </div>
                                    <div class="modal-body">
                                        <h4 class="text-center">Выберите уровень оценки</h4>
                                        <table width="100%" class="table-hover evaluation-table">
                                            <tr>
                                                <td class="text-center" colspan="3" style="background-color: #DFF0D8;">
                                                    Нет оценки
                                                    <input type="radio" name="evaluation" value="0" checked autocomplete="off">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <i class="icon-rate-1"></i>
                                                    <input type="radio" name="evaluation" value="1" autocomplete="off">
                                                </td>
                                                <td class="text-center">50 ₽</td>
                                                <td>Описание услуг входящих в оценку</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <i class="icon-rate-2"></i>
                                                    <input type="radio" name="evaluation" value="2" autocomplete="off">
                                                </td>
                                                <td class="text-center">100 ₽</td>
                                                <td>Описание услуг входящих в оценку</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <i class="icon-rate-3"></i>
                                                    <input type="radio" name="evaluation" value="3" autocomplete="off">
                                                </td>
                                                <td class="text-center">150 ₽</td>
                                                <td>Описание услуг входящих в оценку</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <i class="icon-rate-4"></i>
                                                    <input type="radio" name="evaluation" value="4" autocomplete="off">
                                                </td>
                                                <td class="text-center">200 ₽</td>
                                                <td>Описание услуг входящих в оценку</td>
                                            </tr>
                                            <tr>
                                                <td class="text-center">
                                                    <i class="icon-rate-5"></i>
                                                    <input type="radio" name="evaluation" value="5">
                                                </td>
                                                <td class="text-center">250 ₽</td>
                                                <td>Описание услуг входящих в оценку</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                            <label for="cat_id" class="col-md-8 control-label">Категория</label>

                            <div class="col-md-16">
                                <select id="cat_id" type="text" name="cat_id" data-search="true" data-placeholder="Выберите категорию..." required autofocus>
                                    <option></option>
                                    @foreach($cats->where('parent_id', 0) as $cat)
                                        <optgroup label="{{ $cat->name }}">
                                            @foreach($cats->where('parent_id', $cat->id) as $subcat)
                                                <option value="{{ $subcat->id }}" {{($subcat->id == old('cat_id'))?'selected':''}}>{{ $subcat->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>

                                @if ($errors->has('cat_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cat_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-8 control-label">Название</label>

                            <div class="col-md-16">
                                <input id="name" type="text" class="styler" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('descr') ? ' has-error' : '' }}">
                            <label for="descr" class="col-md-8 control-label">Описание</label>

                            <div class="col-md-16">
                                <textarea id="descr" class="styler" name="descr" rows="6" required>{{ old('descr') }}</textarea>

                                @if ($errors->has('descr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('deal_type') ? ' has-error' : '' }}">
                            <label class="col-md-8 control-label">Тип сделки</label>

                            <div class="col-md-16">
                                <div class="btn-group" data-toggle="buttons">
                                    <label class="btn btn-sm btn-default radio {{(!old('deal_type'))?'active':''}}{{(old('deal_type')=="buy")?'active':''}}" for="buy">
                                        <input id="buy" data-deal-type="buy" type="radio" name="deal_type" value="buy" {{(!old('deal_type'))?'checked':''}}{{ (old('deal_type') == 'buy') ? 'checked' : '' }}> Продажа
                                    </label>
                                    <label class="btn btn-sm btn-default radio {{ (old('deal_type') == 'rent') ? 'active' : '' }}" for="rent">
                                        <input id="rent" data-deal-type="rent" type="radio" name="deal_type" value="rent" {{ (old('deal_type') == 'rent') ? 'checked' : '' }}> Прокат
                                    </label>
                                    <label class="btn btn-sm btn-default radio {{ (old('deal_type') == 'service') ? 'active' : '' }}" for="service">
                                        <input id="service" data-deal-type="service" type="radio" name="deal_type" value="service" {{ (old('deal_type') == 'service') ? 'checked' : '' }}> Сервис
                                    </label>
                                    <label class="btn btn-sm btn-default radio {{ (old('deal_type') == 'store') ? 'active' : '' }}" for="store">
                                        <input id="store" data-deal-type="store" type="radio" name="deal_type" value="store" {{ (old('deal_type') == 'store') ? 'checked' : '' }}> Хранение
                                    </label>
                                    <label class="btn btn-sm btn-default radio {{ (old('deal_type') == 'selling') ? 'active' : '' }}" for="selling">
                                        <input id="selling" data-deal-type="selling" type="radio" name="deal_type" value="selling" {{ (old('deal_type') == 'selling') ? 'checked' : '' }}> Реализация
                                    </label>
                                </div>
                                @if ($errors->has('deal_type'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('deal_type') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }} hideable buy rent {{(old('deal_type')=="buy" || old('deal_type')=="rent" || !old('deal_type'))?'':'hide'}}">
                            <label for="cost" class="col-md-8 control-label">Стоимость<span class="hideable rent {{(old('deal_type')=="rent")?'':'hide'}}"> в сутки</span></label>

                            <div class="col-md-16">
                                <input id="cost" type="number" class="styler required" name="cost" required min="1" value="{{ (old('cost')) ? old('cost') : '1' }}">
                                <a href="javascript://" class="select-eva" data-toggle="modal" data-target=".evaluation" style="margin-left: 10px;">Оценка экспертом</a>
                                @if ($errors->has('cost'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }} hideable service {{(old('deal_type')=="service")?'':'hide'}}">
                            <label class="col-md-8 control-label">Правила сервисного центра</label>

                            <div class="col-md-16">
                                <a href="javascript://" data-toggle="modal" data-target=".service-rules" style="margin-left: 10px;">Прочитать правила</a>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }} hideable store {{(old('deal_type')=="store")?'':'hide'}}">
                            <label class="col-md-8 control-label">Правила хранения товара</label>

                            <div class="col-md-16">
                                <a href="javascript://" data-toggle="modal" data-target=".store-rules" style="margin-left: 10px;">Прочитать правила</a>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }} hideable selling {{(old('deal_type')=="selling")?'':'hide'}}">
                            <label class="col-md-8 control-label">Правила реализации товара</label>

                            <div class="col-md-16">
                                <a href="javascript://" data-toggle="modal" data-target=".selling-rules" style="margin-left: 10px;">Прочитать правила</a>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('used') ? ' has-error' : '' }} hideable buy rent {{(old('deal_type')=="buy" || old('deal_type')=="rent" || !old('deal_type'))?'':'hide'}}">
                            <label for="used" class="col-md-8 control-label">Бывший в употреблении</label>

                            <div class="col-md-16">
                                <input id="used" type="checkbox" data-size="small" name="used" value="1" class="switch" {{ (old('used')) ? 'checked' : '' }}>

                                @if ($errors->has('used'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('used') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('limitations') ? ' has-error' : '' }} hideable buy rent service {{(old('deal_type')=="buy" || old('deal_type')=="rent" || old('deal_type')=="service" || !old('deal_type'))?'':'hide'}}">
                            <label class="col-md-8 control-label">Найденые дефекты</label>

                            <div class="col-md-16">
                                <div class="btn-group" data-toggle="buttons">

                                    <label class="btn btn-sm btn-default radio {{(!old('limitations'))?'active':''}}" for="notfound">
                                        <input id="notfound" type="radio" name="limitations" value="0" {{(!old('limitations')) ? 'checked':''}}{{ (old('limitations') == '0') ? 'checked' : '' }}> Не обнаружено
                                    </label>
                                    <label class="btn btn-sm btn-default radio {{ (old('limitations') == '1') ? 'active' : '' }}" for="found">
                                        <input id="found" type="radio" name="limitations" value="1" {{ (old('limitations') == '1') ? 'checked' : '' }}> Обнаружено
                                    </label>
                                </div>

                                <textarea id="flaw" class="styler {{(old('limitations') == '1')?'':'hide'}}" name="flaw" rows="6" style="margin-top: 10px;" placeholder="Опишите, найденые вами недостатки...">{{old('flaw')}}</textarea>

                                @if ($errors->has('limitations'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('limitations') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('photo.0') ? ' has-error' : '' }}">
                            <label for="photo" class="col-md-8 control-label">Фотографии</label>

                            <div class="col-md-16">
                                <script>
                                    var photos = 1;
                                </script>
                                    <input id="photo" type="file" class="styler required" name="photo[]" required>
                                    <i class="good-newphoto fa fa-plus photo-add"></i>
                                    @for($i=0;$i<5;$i++)
                                        @if ($errors->has('photo.'.$i))
                                            <span class="help-block">
                                                <strong>{{$i+1}} файл: {{ $errors->first('photo.'.$i) }}</strong>
                                            </span>
                                        @endif
                                    @endfor
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }} hideable rent service store selling  {{(old('deal_type')=="rent" || old('deal_type')=="service" || old('deal_type')=="store" || old('deal_type')=="selling")?'':'hide'}}">
                            <label for="address" class="col-md-8 control-label">Ваш адрес</label>

                            <div class="col-md-16">
                                <input id="address" type="text" class="styler required" name="address" value="{{old('address')}}" placeholder="Улица, дом, квартира">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('datetime') ? ' has-error' : '' }} hideable rent service store selling  {{(old('deal_type')=="rent" || old('deal_type')=="service" || old('deal_type')=="store" || old('deal_type')=="selling")?'':'hide'}}">
                            <label for="datetime" class="col-md-8 control-label">Удобные для вас дата и время</label>

                            <div class="col-md-16">
                                <input id="datetime" type="text" class="styler required datetimepick" name="datetime" value="{{old('datetime')}}" placeholder="Дата и время">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-16 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Добавить
                                </button>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <link href="/css/bootstrap-switch.css" rel="stylesheet">
    <script src="/js/bootstrap-switch.js"></script>
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="/js/moment-with-locales.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(function () {
            $('input[name="deal_type"]').on('change', function () {
                $('.hideable.rent,' +
                    '.hideable.buy,' +
                    '.hideable.service,' +
                    '.hideable.store,' +
                    '.hideable.selling').addClass('hide').find('input').removeAttr('required');
                $('.hideable.'+$(this).data('dealType')).removeClass('hide').find('input.required').attr('required', true);
            });
            $('input[name="limitations"]').on('change', function () {
                if ($(this).val() == 1)
                    $('textarea#flaw').removeClass('hide');
                else
                    $('textarea#flaw').addClass('hide');
            });
            SwitchEnable($('input.switch'));
            DateTimeEnable($('input.datetimepick'), true);
            $('.evaluation-table td').click(function () {
                var parent = $(this).parent();
                $('.evaluation-table').find('td').css('background-color', '');
                parent.find('input').attr('checked', true);
                parent.find('td').css('background-color', '#DFF0D8');
                var text = "";
                if ($('input[name="evaluation"][checked="checked"]').val() != 0) {
                    text = 'Уровень заказанной оценки: <i class="icon-rate-'+$('input[name="evaluation"][checked="checked"]').val()+'"></i>'
                } else {
                    text = 'Оценка экспертом'
                }
                $('.select-eva').html(text)
            });
        });
    </script>
@endsection
