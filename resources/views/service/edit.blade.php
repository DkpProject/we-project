@extends('layouts.app')

@section('title', 'Редактирование услуги')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                {!! Form::open(array('url'=>'/service/'.$service->id.'/edit','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="page-title">Редактирование услуги
                        <span class="good-show pull-right h5" style="margin-top: 5px;">Показывать объявление: <input type="checkbox" data-size="mini" class="switch" name="visible" value="1" {{ ($service->visible) ? 'checked' : ''}} style="margin-top: -5px;"></span>
                    </div>
                    <div class="page-content">
						<br>
                        <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                            <label for="cat_id" class="col-md-8 control-label">Категория</label>

                            <div class="col-md-16">
                                <select id="cat_id" type="text" class="styler" name="cat_id" required autofocus>
									@foreach($cats as $cat)
									{{ old('cat_id') }}
									<option value="{{ $cat->id }}" {{$service->cat_id == $cat->id ? 'selected' : ''}}>{{ $cat->name }}</option>
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
                                <input id="name" type="text" class="styler" name="name" value="{{ $service->name }}" required>

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
                                <textarea id="descr" class="styler" name="descr" rows="6" required>{{ $service->descr }}</textarea>

                                @if ($errors->has('descr'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('descr') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                            <label for="cost" class="col-md-8 control-label">Стоимость</label>

                            <div class="col-md-16">
                                <input id="cost" type="number" class="styler" name="cost" required min="1" value="{{ $service->cost }}">

                                @if ($errors->has('cost'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unphoto" class="col-md-8 control-label">Загруженные фотографии</label>

                            <div class="col-md-16">
                                @if(count($service->images))
                                    @foreach($service->images as $image)
                                        <div style="margin-bottom: 5px;">
                                            <img src="/images/uploads/{{$image->module()}}/{{$image->file}}" style="margin-right: 10px; max-width: 150px;">
                                            <input id="unphoto-{{$image->id}}" type="checkbox" class="styler unphoto" style="display: inline; width: 20px; height: 20px; margin: 0px;" name="unphoto[]" value="{{$image->id}}">
                                            <label for="unphoto-{{$image->id}}">Удалить</label>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center">Нет загруженных фотографий</div>
                                @endif
                            </div>
                        </div>

                        @if ($service->images->count() < 5)
                        <div class="form-group{{ $errors->has('photo.0') ? ' has-error' : '' }}">
                            <label for="photo" class="col-md-8 control-label">Фотографии</label>

                            <div class="col-md-16">
                                <script>
                                    var photos = 1 + {{$service->images->count()}};
                                </script>
                                <input id="photo" type="file" class="styler" name="photo[]">
                                @if ($service->images->count() < 4)
                                <i class="good-newphoto fa fa-plus photo-add"></i>
                                @endif
                                @for($i=0;$i<5;$i++)
                                    @if ($errors->has('photo.'.$i))
                                        <span class="help-block">
                                            <strong>{{$i+1}} файл: {{ $errors->first('photo.'.$i) }}</strong>
                                        </span>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-16 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Сохранить
                                </button>
                                <a href="{{url('/service/'.$service->id)}}">
                                    <button type="button" class="btn btn-default">Отменить редактирование</button>
                                </a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <link href="/css/bootstrap-switch.css" rel="stylesheet">
    <script src="/js/bootstrap-switch.js"></script>
    <script>
        $(function () {
            SwitchEnable($('input.switch'));

            var unphoto = $('input[type="checkbox"].unphoto').length;
            if (unphoto == 1) {
                $('input[type="checkbox"].unphoto').attr('disabled', true).trigger('refresh');
            }
            $('input[type="checkbox"].unphoto').change(function () {
                if ($(this).is(':checked')) unphoto--; else unphoto++;
                if (unphoto == 1) {
                    $('input[type="checkbox"].unphoto:not(:checked)').attr('disabled', true).trigger('refresh');
                } else {
                    $('input[type="checkbox"].unphoto:disabled').removeAttr('disabled').trigger('refresh');
                }
            });
        });
    </script>
@endsection
