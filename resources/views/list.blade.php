@extends('template.app')
@section('title', 'Список сотрудников')
@section('content')
    <div class="sort-window bg-light align-">
        <div class="header bg-dark ">Сортировать список сотрудников</div>
        {{--{!! Form::open(['url' => 'list/sort']) !!}--}}
        <div class="form-group mt-2 p-2">
            <div class="form-check">
                {!! Form::radio('r-bat','fio', true,['id'=>'rbat']) !!}
                {!! Form::label('fio','по ФИО',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('r-bat','pos',false,['id'=>'rbat']) !!}
                {!! Form::label('pos','по должности',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('r-bat','date',false,['id'=>'rbat']) !!}
                {!! Form::label('date','по дате приема',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('r-bat','salary',false,['id'=>'rbat'] ) !!}
                {!! Form::label('salary','по зарплате',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            {!! Form::label('m','Сортировать в порядке: ', ['class' =>['form-check-label', ' justify-content-center']]) !!}

            <div class="form-check">
                {!! Form::radio('check', 'on-high',true) !!}
                {!! Form::label('check','возрастания',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('check', 'on-low', false) !!}
                {!! Form::label('check','убывания',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            {!! Form::submit('Сортировать', ['class'=>['btn','btn-primary','mt-1','ml-1'], 'id' => 'btn-sort']) !!}
        </div>
        {{--{!! Form::close() !!}--}}
    </div>
    <div class="find-window bg-light align-">
        <div class="header bg-dark ">Найти сотрудника</div>
        <div class="form-group mt-2 p-2">
            <div class="form-check">
                {!! Form::radio('s-bat','fio', true,['id'=>'rbat']) !!}
                {!! Form::label('fio','по ФИО',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('s-bat','pos',false,['id'=>'rbat']) !!}
                {!! Form::label('pos','по должности',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('s-bat','date',false,['id'=>'rbat']) !!}
                {!! Form::label('date','по дате приема',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            <div class="form-check">
                {!! Form::radio('s-bat','salary',false,['id'=>'rbat'] ) !!}
                {!! Form::label('salary','по зарплате',['class'=> ['form-check-label', 'ml-1'],])!!}
            </div>
            {!! Form::label('m','Сортировать в порядке: ', ['class' =>['form-check-label', ' justify-content-center']]) !!}

            <div class="form-group">
                {!! Form::label('search-input','Поиск',['class'=> ['ml-1']])!!}
                {!! Form::text('search-input', null, ['class'=>'form-control']) !!}
            </div>
            <div class="error mb-2">

            </div>
            {!! Form::submit('Найти', ['class'=>['btn','btn-primary','mt-1','ml-1'], 'id' => 'btn-find']) !!}
        </div>
    </div>
    <div class="wrap">
    @foreach($employees as $employee)
        <div class="row mt-1">
            <div class="employee">
                @include('template.template',['_layer'=>$employee])
            </div>
        </div>
        <hr>
    @endforeach
        {{$employees->links()}}
    </div>

@endsection