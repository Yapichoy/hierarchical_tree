function incl(_layer) {
    var text ='<div class="wrapper">' +
        '<div class="header bg-dark">'+_layer['surname']+' '+_layer['name']+' '+_layer['secondname']+'</div>' +
        '<div class="row p-3"> <div class="col-3 photo">фото </div> <div class="col-9 info">  ';
            text += '<div class="position">Должность: ';
            text += _layer['denomination'];
            text += '</div></div> </div></div>';
            return text;
}
function template(_layer) {
    var text ='<div class="wrapper">' +
        '<div class="header bg-dark">'+_layer['surname']+' '+_layer['name']+' '+_layer['secondname']+'</div>' +
        '<div class="row p-3"> <div class="col-3 photo">фото </div> <div class="col-9 info">  ';
    text += '<div class="position">Должность: ';
    text += _layer['denomination'];
    text += '</div><div class="date">Дата приема на работу: ';
    text += _layer['date_start_work'];
    text+= '</div><div class="salary">Зарплата: ';
    text+= _layer['salary'];
    text+= '</div></div></div></div>';
    return text;
}
$(document).ready(function () {
    $('.cli').click(function () {

        formData = new FormData();
        var id = $(this).attr('id');
        formData.append('chef_id', id);

        $.ajax(
            {
                url: '/tree/load',
                type: "POST",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    var arr = JSON.parse(result);
                    var third_layer = arr.third_layer;
                    var  third_length =third_layer.length;
                    var forth_layer = arr.forth_layer;
                    var forth_length = forth_layer.length;
                    var fifth_layer = arr.fifth_layer;
                    var fifth_length = fifth_layer.length;
                    var htmlText = '<div id="load">';
                    //alert(forth_layer[third_layer[0]['id']][0]['name']);
                    if (third_length!=0){
                        for(var i = 0; i< third_length; i++){
                            htmlText += '<div class="employee">';
                            htmlText += incl(third_layer[i]);
                            var third_num = third_layer[i]['id'];
                            if( typeof forth_layer[third_num] != 'undefined' ){
                                var layer = forth_layer[third_num];
                                forth_length = layer.length;
                                for(var j = 0; j<forth_length; j++){
                                    htmlText += '<div class="employee">';
                                    htmlText += incl(layer[j]);
                                    var forth_num = layer[j]['id'];
                                    if( typeof fifth_layer[forth_num] != 'undefined' ) {
                                        var _layer = fifth_layer[forth_num];
                                        fifth_length = _layer.length;
                                        for (var l= 0; l < fifth_length; l++) {
                                            htmlText += '<div class="employee">';
                                            htmlText += incl(_layer[l]);
                                            htmlText += '</div>';
                                        }
                                    }
                                    htmlText += '</div>';
                                }
                            }
                                htmlText += '</div>';
                        }
                    }
                    console.log(fifth_layer);
                    $('#'+id).append(htmlText);

                },
                error: function (result) {
                  console.log(result);
                }
            }
        );

    });
    $('#btn-sort').click(function () {
        formData = new FormData();
        formData.append('r-bat', $('input[name=r-bat]:checked').val());
        formData.append('check', $('input[name=check]:checked').val())
        $.ajax(
            {
                url: 'list/sort',
                type: "POST",
                cache: false,
                processData: false,
                contentType: false,
                data: formData,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {
                    var arr = JSON.parse(result);
                    var employees = arr.employees;
                    console.log(employees);
                    var textHtml = '';
                    $(".wrap").empty();
                    if(typeof employees != 'undefined')
                        for(var i = 0; i < employees.length; i++) {
                            textHtml='';
                            textHtml += '<div class = "row mt-1" ><div class = "employee" >';
                            textHtml += template(employees[i]);
                            textHtml += '</div ></div ><hr>';
                            $(".wrap").append(textHtml);
                        }

                },
                error: function (result) {
                    console.log(result);
                }
            }
        );
    });
    $('#btn-find').click(function () {
        var s_bat = $('input[name=s-bat]:checked').val();
        var search_input = $('#search-input').val();
        var pattern = null;
        var message = '';
        formData = new FormData();
        formData.append('s-bat', s_bat);
        formData.append('search-input', search_input);
        $('.error').empty();
        switch (s_bat){
            case 'fio': pattern = /^([А-Я]{1}[а-я]{1,69})(\040[А-Я]{1}[а-я]{1,69})(\040[А-Я]{1}[а-я]{1,69})$/;
                message = "Введите корректно ФИО в формате \"Иванов Иван Иванович\""; break;
            case 'pos': pattern = /^([А-Я]{1}[а-я]+)(((\040)|(\-))?[а-я]+)*$/;
                message =  "Введите корректно должность. Например \"Инспектор по охране труда\"";break;
            case 'date': pattern = /^((19|20){1}([0-9]){2}){1}(\-)(((0)([1-9]))|((1)([0-2])))(\-)(((0|1|2)([0-9]))|(3)(0|1)){1}$/;
                message =  "Введите корректно дату в формате \"2018-10-23\"";break;
            case 'salary': pattern = /^([1-9])([0-9])*$/;
                message =  "Введите корректно зарплату, одна и более цифр";break;
        }
        if(search_input != '') {
            if(search_input.match(pattern)){
            $.ajax(
             {
             url: 'list/search',
             type: "POST",
             cache: false,
             processData: false,
             contentType: false,
             data: formData,
             headers: {
             'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
             },
             success: function (result) {
                 console.log(result);
             var arr = JSON.parse(result);
             var employees = arr.employees;
             $(".wrap").empty();
             if(employees != 'no') {
                 var textHtml = '';

                     for (var i = 0; i < employees.length; i++) {
                         textHtml = '';
                         textHtml += '<div class = "row mt-1" ><div class = "employee" >';
                         textHtml += template(employees[i]);
                         textHtml += '</div ></div ><hr>';
                         $(".wrap").append(textHtml);
                     }
             }
             else {
                 textHtml = '<div class = "row mt-1" ><div class = "employee" >Никого не найдено</div></div>';
                 $(".wrap").append(textHtml);
             }
             },
             error: function (result) {
             console.log(result);
             }
             }
             );}
             else{
                $('.error').append(message);
            }
        }else
        {
            $('.error').append('Заполните поле');
        }
    });
});


