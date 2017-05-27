@extends('layouts.app')

@section('title', 'Перевод средств')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Перевод средств</div>
                <div class="page-content">
                    {!! Form::open(array('url'=>'/profile/transfer','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="form-group{{ $errors->has('destination') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Выбор адресата</label>
                        <div class="col-md-16">
                            <select class="styler" name="destination" data-search="true" data-placeholder="Выберите адресата...">
                                <option></option>
                                @foreach(\App\Helpers\MyTeam::getMyTeam($user) as $member)
                                        <option value="{{$member->id}}">{{$member->firstname}} {{$member->surname}}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('destination'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('destination') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('sum') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Сумма</label>

                        <div class="col-md-16">
                            <input type="number" name="sum" class="styler" min="1" max="{{intval($user->activeBalance())}}" placeholder="Сумма">

                            @if ($errors->has('sum'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sum') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-16 col-md-offset-8">
                            <button type="submit" class="btn btn-primary">
                                Отправить
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
@endsection
