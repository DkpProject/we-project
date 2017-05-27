@extends('layouts.app')

@section('title', 'Изменение пароля')
@section('content')
    <div class="row">
        <div class="col-md-24">
			<div class="page-wrap">
				<div class="page-title">Изменение пароля</div>
                <div class="page-content">
					{!! Form::open(array('url'=>'/profile/password','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-8 control-label">Пароль</label>

                            <div class="col-md-16">
                                <input id="password" type="password" class="styler" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-8 control-label">Пароль еще раз</label>

                            <div class="col-md-16">
                                <input id="password-confirm" type="password" class="styler" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
				</div>
			</div>
        </div>
    </div>
@endsection
