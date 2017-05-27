@extends('layouts.app')

@section('content')
    @if(Auth::user()->id == 1 || Auth::user()->isAdmin())
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Редактирование баланса пользователя</div>
                <div class="page-content">
                    {!! Form::open(array('url'=>'/admin/balance','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                    <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Пользователь</label>
                        <div class="col-md-16">
                            <select name="user" data-placeholder="Выберите пользователя">
                                <option></option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" data-balance="{{$user->balance}}">{{$user->firstname}} {{$user->surname}} (ID: {{$user->id}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('newbalance') ? ' has-error' : '' }}">
                        <label for="email" class="col-md-8 control-label">Баланс</label>
                        <div class="col-md-16">
                            <input name="newbalance" class="styler" type="text" placeholder="Выберите пользователя">
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
    <script>
        $('select').on('select2:select', function (evt) {
            $('input[name="newbalance"]').attr('placeholder', 'Текущий баланс пользователя: ' + $("select option:selected").data('balance'));
        });
    </script>
    @endif
@endsection