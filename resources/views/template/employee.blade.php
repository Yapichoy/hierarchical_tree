<div class="wrapper">
    <div class="row mt-3 p-1">
        <div class="col-3 photo">
            фото
        </div>
        <div class="col-9 info">
            <div class="fio">
               ФИО: {{$_layer['surname'].' '.$_layer['name'].' '.$_layer['secondname']}}
            </div>
            <div class="position">
                Должность: {{$_layer['denomination']}}
            </div>
            <div class="date">
                Дата начала работы: {{$_layer['date_start_work']}}
            </div>
            <div class="salary">
                Зарплата: {{$_layer['salary'].'p'}}
            </div>
        </div>
    </div>
</div>