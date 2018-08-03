@extends('template.app')
@section('title', 'Добавить')
@section('content')

    <h1 class="mb-2 mt-2">Добавить сотрудника</h1>
    <div class="row p-3 m-2">

        <div class="col-6">
            {!! Form::open(['url'=>'employee/create/save']) !!}
            <div class="form-group">
                {!!Form::label('fio','ФИО')!!}
                {!!Form::text('fio',null,['class'=>['form-control']])!!}
            </div>
            <div class="form-group">
                {!!Form::label('position','Должность')!!}
                <select name="positions" id="positions" class="form-control">
                    @foreach($positions as $position)
                        <option value="{{$position['_id']}}">{{$position['denomination']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('date','Дата') !!}
                {!! Form::date('date', null, ['class'=>['form-control']])!!}
            </div>
            <div class="form-group">
                {!!Form::label('chef','Начальник')!!}
                    <select name="chef" id="chef" class="form-control">

                    </select>
            </div>

            <div class="form-group">
                {!!Form::label('salary','Зарплата, руб')!!}
                {!!Form::text('salary',null,['class'=>['form-control']])!!}
            </div>
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            {!! Form::submit('Сохранить', ['class'=>['btn','btn-primary','mt-1','ml-1']]) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection