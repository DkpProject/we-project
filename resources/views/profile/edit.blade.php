@extends('layouts.app')

@section('title', 'Редактирование аккаунта '.$user->firstname.' '.$user->surname)
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Редактирование аккаунта {{$user->firstname}} {{$user->surname}}</div>
                <div class="page-content">
					{!! Form::open(array('url'=>'/profile/'.$user->id.'/edit','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-8 control-label">E-Mail адрес</label>

                            <div class="col-md-16">
                                <input id="email" type="email" class="styler" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-8 control-label">Телефон</label>

                            <div class="col-md-16">
                                <input id="phone" type="text" class="styler" name="phone" placeholder="+79876543211" value="{{ $user->phone }}" required>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-16 col-md-offset-8">
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
