@extends('layouts.app')

@section('title', 'Создание аккаунта')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Создание аккаунта</div>
                <div class="page-content">
					{!! Form::open(array('url'=>'/register','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="license">
                        <div class="form-group">
                            <div class="col-md-24" style="text-align: justify">
                                @include('pages.uaText')
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-3">
                                <input type="checkbox" class="styler" id="license" name="license" value="1">
                                <label for="license">Вы соглашаетесь с правилами сайта</label>
                                <script>
                                    $("input#license").styler();
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="form" style="display: none;">
                        <div class="form-group">
                            <label for="name" class="col-md-8 control-label">Пригласил</label>

                            <div class="col-md-12">
								{{ $invited->firstname }} {{ $invited->surname }}
								<input type="hidden" name="key" value="{{ $key }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-8 control-label">Имя</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
						
                        <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-8 control-label">Фамилия</label>

                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="surname" value="{{ old('surname') }}" required autofocus>

                                @if ($errors->has('surname'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('surname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-8 control-label">E-Mail адрес</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-8 control-label">Пароль</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-8 control-label">Пароль еще раз</label>

                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-8 control-label">Телефон</label>

                            <div class="col-md-12">
                                <input id="phone" type="text" class="form-control" name="phone" placeholder="Телефон" value="{{ old('phone') }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('district') ? ' has-error' : '' }}">
                            <label for="district" class="col-md-8 control-label">Ваш район</label>

                            <div class="col-md-12">
                                <select class="form-control" style="width: 85%;" name="district" data-search="true" data-placeholder="Выберите район...">
                                    <option></option>
                                    @foreach($districts->where('parent_id', 0) as $district)
                                        <optgroup label="{{ $district->name }}">
                                            @foreach($districts->where('parent_id', $district->id) as $subdistrict)
                                                <option value="{{ $subdistrict->id }}">{{ $subdistrict->name }}</option>
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

                        <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }}">
                            <label for="foto" class="col-md-8 control-label">Фотография</label>

                            <div class="col-md-12">
                                <input id="foto" type="file" name="foto" required>

                                @if ($errors->has('foto'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('foto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Продолжить
                                </button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#license').change(function () {
                if ($(this).is(':checked')) {
                    $('.license').hide(500, function () {
                        $('.form').show(500);
                    });
                }
            });
        });
    </script>
@endsection
