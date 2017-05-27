@extends('layouts.app')

@section('content')
    @if(Auth::user()->id == 2 || Auth::user()->id == 5)
        <div class="row">
            <div class="col-md-24">
                <div class="page-wrap">
                    <div class="page-title">Редактирование баланса пользователя</div>
                    <div class="page-content">
                        {!! Form::open(array('url'=>'/specialties','method'=>'POST', 'files'=>false, 'class' => 'form-horizontal', 'role' => 'form')) !!}
                        <div class="form-group{{ $errors->has('user') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-8 control-label">Родительская категория</label>
                            <div class="col-md-16">
                                <select name="parent" data-placeholder="Выберите родительскую категорию">
                                    <option value="0">Нет родительской категории</option>
                                    @foreach($cats->where('parent_id' , '0')->get() as $cat)
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('newbalance') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-8 control-label">Название категории</label>
                            <div class="col-md-16">
                                <input name="name" class="styler" type="text" placeholder="Название категории">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-16 col-md-offset-8">
                                <button type="submit" class="btn btn-primary">
                                    Добавить
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}

                        <table class="table table-striped">
                            <thead>
                                <th>Название категории</th>
                                <th>Действие</th>
                            </thead>
                            <tbody>
                            @foreach($cats->get() as $value)
                                <tr>
                                    <td>{{$value->name}}</td>
                                    <td><a href="/specialties/{{$value->id}}/delete"><i class="fa fa-close"></i> Удалить</a></td>
                                </tr>
                                @foreach($value->childs()->get() as $child)
                                    <tr>
                                        <td>>>> {{$child->name}}</td>
                                        <td><a href="/specialties/{{$child->id}}/delete"><i class="fa fa-close"></i> Удалить</a></td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection