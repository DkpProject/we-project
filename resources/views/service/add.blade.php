@extends('layouts.app')

@section('title', 'Добавление новой услуги')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                {!! Form::open(array('url'=>'/service/add','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="page-title">Добавление услуги в каталог
                        <span class="good-show pull-right h5" style="margin-top: 5px;">Показывать объявление: <input type="checkbox" data-size="mini" class="switch" name="visible" value="1" style="margin-top: -5px;"></span>
                    </div>
                    <div class="page-content">

                        <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                            <label for="cat_id" class="col-md-8 control-label">Категория</label>

                            <div class="col-md-16">
                                <select id="cat_id" type="text" class="styler" name="cat_id" required autofocus>
									@foreach($cats as $cat)
									{{ old('cat_id') }}
									<option value="{{ $cat->id }}" {{old('cat_id') == $cat->id ? 'selected' : ''}}>{{ $cat->name }}</option>
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

                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
                            <label for="cost" class="col-md-8 control-label">Стоимость</label>

                            <div class="col-md-16">
                                <input id="cost" type="number" class="styler" name="cost" required min="1" value="{{ (old('cost')) ? old('cost') : '1' }}">

                                @if ($errors->has('cost'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('cost') }}</strong>
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
                                <input id="photo" type="file" class="styler" name="photo[]" required>
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
    <script>
        $(function () {
            SwitchEnable($('input.switch'));
        });
    </script>
@endsection
