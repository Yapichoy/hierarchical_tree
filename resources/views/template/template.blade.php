<div class="wrapper">
    <div class="header bg-dark">{{$_layer['surname'].' '.$_layer['name'].' '.$_layer['secondname']}}</div>
    <div class="row p-3">
        <div class="col-3">
        </div>
        <div class="col-9 info">
            <div class="position">
                Должность: {{$_layer['denomination']}}
            </div>
            <div class="date">
                Дата приема на работу: {{$_layer['date_start_work']}}
            </div>
            <div class="salary">
                Зарплата: {{$_layer['salary']}}
            </div>
        </div>
    </div>
    <div class="row p-2">
        <div class="col-3">
            <a class="btn btn-primary" href="{{url('employee/change/'.$_layer['id'])}}">Изменить</a>
        </div>
        <div class="col-3">
            <a class="btn btn-primary" href="{{url('employee/delete/'.$_layer['id'])}}">Удалить</a>
        </div>
    </div>
</div>