@extends('layouts.app')

@section('title', 'Удаление вещи')
@section('content')
	<div class="row">
		<div class="col-md-24">
			<div class="page-wrap">
				<div class="page-title">Удаление вещи</div>
				<div class="page-content">
					{!! Form::open(array('url'=>'/catalog/'.$id.'/delete','method'=>'POST', 'files'=>true, 'class' => 'form-horizontal', 'role' => 'form')) !!}
						<br>
						<div class="form-group{{ $errors->has('cat_id') ? ' has-error' : '' }}">
							<label class="col-md-24 text-center">Подтвердите удаление вещи из каталога</label>
						</div>

						<div class="form-group">
							<div class="col-md-24 text-center">
								<button type="submit" class="btn btn-primary">
									Удалить
								</button>
								<a href="{{url('/catalog/'.$id)}}">
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
