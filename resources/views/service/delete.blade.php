@extends('layouts.app')

@section('title', 'Удаление услуги')
@section('content')
    <div class="row">
        <div class="col-md-24">
            <div class="page-wrap">
                <div class="page-title">Удаление услуги</div>
                <div class="page-content">
					{!! Form::open(array('url'=>'/service/'.$id.'/delete','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
						<br>
                        <div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
                            <label class="col-md-24 text-center">Подтвердите удаление услуги из каталога</label>
                        </div>

                        <div class="form-group">
                            <div class="col-md-24 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Удалить
                                </button>
                                <a href="{{url('/service/'.$id)}}">
                                    <button type="button" class="btn btn-default">Отменить удаление</button>
                                </a>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
