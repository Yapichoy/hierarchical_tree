@extends('template.app')
@section('title', 'Редактировать')
@section('content')

    <h1 class="mb-2 mt-2">Редактировать</h1>
    <div class="row p-3 m-2">

        <div class="col-6">
            {!! Form::open(['url'=>'employee/change/save']) !!}
            <div class="form-group">
                {!!Form::label('fio','ФИО')!!}
                {!!Form::text('fio',$employee['surname'].' '.$employee['name'].' '.$employee['secondname'],['class'=>['form-control']])!!}
            </div>
            <div class="form-group">
                {!!Form::label('position','Должность')!!}
                <select name="positions" id="positions" class="form-control">
                    @foreach($positions as $position)
                        <option @if($position['_id']==$employee['position_id'])
                                {{'selected'}}
                                @endif
                                value="{{$position['_id']}}">{{$position['denomination']}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {!! Form::label('date','Дата') !!}
                {!! Form::date('date', $employee['date_start_work'], ['class'=>['form-control']])!!}
            </div>
            <div class="form-group">
                {!!Form::label('chef','Начальник')!!}
                @if($chef != null )
                    <select name="chef" id="chef" class="form-control">
                        @foreach($chef as $ch)
                            <option @if($ch['id']==$employee['chef_id'])
                                    {{'selected'}}
                                    @endif
                                    value="{{$ch['id']}}">{{$ch['surname'].' '.$ch['name'].' '.$ch['secondname']}}</option>
                        @endforeach
                    </select>
                @else
                    {!!Form::text('chef',"Нет начальника",['class'=>['form-control']])!!}
                @endif
            </div>

            <div class="form-group">
                {!!Form::label('salary','Зарплата, руб')!!}
                {!!Form::text('salary',$employee['salary'],['class'=>['form-control']])!!}
            </div>
            <input type="hidden" name="id" value="{{$employee['id']}}">
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