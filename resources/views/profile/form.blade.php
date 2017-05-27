@extends('layouts.app')

@section('title', 'Анкетирование пользователя '.$user->firstname.' '.$user->surname)
@section('content')
    <link href="/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <script src="/js/moment-with-locales.min.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Расскажите о себе</div>
                <div class="page-content">
                    {!! Form::open(array('url'=>'/profile/form','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="form-group{{ $errors->has('spec') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Ваши специализации</label>
                        <div class="col-md-16">
                            <select multiple id="spec" name="spec[]" data-search="true" data-placeholder="Выберите специализацию...">
                                @foreach($cats->where('parent_id', 0) as $cat)
                                    <optgroup label="{{ $cat->name }}">
                                        @foreach($cats->where('parent_id', $cat->id) as $subcat)
                                            <?php $stars = "&#x2605;";
                                            $specs = $user->specs_level($subcat->id);
                                            for ($i = 1; $i < $specs['level']; $i++)
                                                $stars .= "&#x2605;";?>
                                            <option value="{{ $subcat->id }}" {{$specs['select']}}>{{ $subcat->name }} ({{$stars}})</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>

                            @if ($errors->has('spec'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('spec') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Ваш район</label>

                        <div class="col-md-16">
                            <select class="styler" name="district" data-search="true" data-placeholder="Выберите район...">
                                <option></option>
                                @foreach($districts->where('parent_id', 0) as $district)
                                    <optgroup label="{{ $district->name }}">
                                        @foreach($districts->where('parent_id', $district->id) as $subdistrict)
                                            <option value="{{ $subdistrict->id }}" {{($subdistrict->id == $user->district)? "selected":''}}>{{ $subdistrict->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>

                            @if ($errors->has('district'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('district') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                        <label for="birthday" class="col-md-8 control-label">День рождения</label>

                        <div class="col-md-16">
                            <input class="styler datepick" type="text" name="birthday" value="{{ ($user->birthday->year < 0) ? '' : $user->birthday->format('d / m / Y')}}" placeholder="День рождения">

                            @if ($errors->has('birthday'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('birthday') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="birthday" class="col-md-8 control-label">E-mail</label>

                        <div class="col-md-16">
                            <input class="styler" type="text" name="email" value="{{$user->email}}" placeholder="E-mail" required>

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <label for="birthday" class="col-md-8 control-label">Телефон</label>

                        <div class="col-md-16">
                            <input class="styler" type="text" name="phone" value="{{$user->phone}}" placeholder="Телефон" required>

                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                        <label for="phone" class="col-md-8 control-label">О себе</label>

                        <div class="col-md-16">
                            <textarea class="styler" rows="5" name="about" placeholder="Расскажите о себе">{{ $user->about }}</textarea>

                            @if ($errors->has('about'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('about') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
                        <label for="foto" class="col-md-8 control-label">Фотография</label>

                        <div class="col-md-12">
                            <input id="foto" type="file" name="foto">

                            @if ($errors->has('foto'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('foto') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-16 col-md-offset-8">
                            <button type="submit" class="btn btn-primary">
                                Сохранить
                            </button>
                            <a href="/profile">
                                <button type="button" class="btn btn-default">
                                    Назад
                                </button>
                            </a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function() {
            DateTimeEnable($('input.datepick'), false);
        });
    </script>
@endsection
