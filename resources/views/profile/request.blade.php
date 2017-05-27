@extends('layouts.app')

@section('title', 'Запрос средств')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Запрос средств</div>
                <div class="alert alert-info" style="margin-top: 10px; margin-bottom: 0px;" role="alert">С помощью этой страницы вы можете запросить средства у участников вашей команды. При этом они получат соответствующее уведомление.</div>
                <div class="page-content">
                    {!! Form::open(array('url'=>'/profile/request','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}

                    <div class="form-group{{ $errors->has('sum') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Сумма</label>

                        <div class="col-md-16">
                            <input type="number" name="sum" class="styler" min="1" placeholder="Сумма">

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
                                Запросить
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
