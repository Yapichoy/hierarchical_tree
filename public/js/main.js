function incl(_layer) {
    var text ='<div class="wrapper">' +
        '<div class="header bg-dark">'+_layer['surname']+' '+_layer['name']+' '+_layer['secondname']+'</div>' +
        '<div class="row p-3"> <div class="col-3"></div> <div class="col-9 info">  ';
            text += '<div class="position">Должность: ';
            text += _layer['denomination'];
            text += '</div></div> </div></div>';
            return text;
}
function template(_layer) {
    var text ='<div class="wrapper">' +
        '<div class="header bg-dark">'+_layer['surname']+' '+_layer['name']+' '+_layer['secondname']+'</div>' +
        '<div class="row p-3"> <div class="col-3"></div> <div class="col-9 info">  ';
    text += '<div class="position">Должность: ';
    text += _layer['denomination'];
    text += '</div><div class="date">Дата приема на работу: ';
    text += _layer['date_start_work'];
    text += '</div><div class="salary">Зарплата: ';
    text += _layer['salary'];
    text += '</div></div></div>';
    text += '<div class="row p-2"><div class="col-3">';
    text += '<a class="btn btn-primary" href="http://hierarchy.tree/employee/change/'+_layer['id']+'">Изменить</a>';
    text += '</div>';
    text += '<div class="col-3">';
    text += '<a class="btn btn-primary" href="http://hierarchy.tree/employee/delete/'+_layer['id']+'">Удалить</a>';
    text += '</div></div></div>';
    return text;
}
endPage = 0;
function paginate(cntRecodrs, curPos, cntOnPage){
    endPage = Math.ceil(cntRecodrs/ cntOnPage);
    var text = '<ul class="pagination">';
    if(curPos>1)text+='<li class="page-item" ><span class="page-link pagin"><</span></li>';
    for(var i = 1; i<= 2; i++){
        text+='<li class="page-item';
        if(i == curPos) text+=' active';
        text+='" >';
        text+='<span class="page-link pagin">'+i+'</span>';
        text+='</li>';
    }
    if(curPos < 7){start = 3; finish = 8;}
    else {
        text+='<li class="page-item" >';
        text+='<span class="page-link pagin">...</span>';
        text+='</li>';
        start = curPos-3; finish = curPos+3;
    }
    if(curPos>endPage-5){start = endPage-8; finish = endPage-2;}
    for(var i = start; i<= finish; i++){
        text+='<li class="page-item';
        if(i == curPos) text+=' active';
        text+='" >';
            text+='<span class="page-link pagin">'+i+'</span>';
        text+='</li>';
    }
    if(curPos<endPage-5){
        text+='<li class="page-item" >';
        text+='<span class="page-link">...</span>';
        text+='</li>';
    }
    for(var i = endPage-1; i<= endPage; i++){
        text+='<li class="page-item';
        if(i == curPos) text+=' active';
        text+='" >';
        text+='<span class="page-link pagin">'+i+'</span>';
        text+='</li>';
    }
    if(curPos<endPage)text+='<li class="page-item" ><span class="page-link  pagin">></span></li>';
    text += '</ul>';
    return text;
}

$(document).ready(function () {
    var cntPostsOnPage = 50;
    var employees = null;
    $('.cli').click(function () { // раскрытие остальных уровней дерева иерархии сотрудников

        formData = new FormData();

        var id = $(this).attr('id');
        var _html = $('#' + id).children('#load');
        if(_html.length == 0) {

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
                        var third_length = third_layer.length;
                        var forth_layer = arr.forth_layer;
                        var forth_length = forth_layer.length;
                        var fifth_layer = arr.fifth_layer;
                        var fifth_length = fifth_layer.length;
                        var htmlText = '<div id="load">';
                        if (third_length != 0) {
                            for (var i = 0; i < third_length; i++) {
                                htmlText += '<div class="employee">';
                                htmlText += incl(third_layer[i]);
                                var third_num = third_layer[i]['id'];
                                if (typeof forth_layer[third_num] != 'undefined') {
                                    var layer = forth_layer[third_num];
                                    forth_length = layer.length;
                                    for (var j = 0; j < forth_length; j++) {
                                        htmlText += '<div class="employee">';
                                        htmlText += incl(layer[j]);
                                        var forth_num = layer[j]['id'];
                                        if (typeof fifth_layer[forth_num] != 'undefined') {
                                            var _layer = fifth_layer[forth_num];
                                            fifth_length = _layer.length;
                                            for (var l = 0; l < fifth_length; l++) {
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
                        $('#' + id).append(htmlText);

                    },
                    error: function (result) {
                        console.log(result);
                    }
                }
            );
        }
        else{
           _html.toggle();
        }
    });

    $('#btn-sort').click(function () { // обработка сортировки сотрудников
        formData = new FormData();
        formData.append('r-bat', $('input[name=r-bat]:checked').val());
        formData.append('check', $('input[name=check]:checked').val());
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
                beforeSend:function(){
                    $(".wrap").empty();
                    $(".wrap").append("Wait!");

                },
                success: function (result) {
                    var arr = JSON.parse(result);
                    employees = arr.employees;
                    var textHtml = '';
                    $(".wrap").empty();
                    if(typeof employees != 'undefined') {
                        for (var i = 0; i < cntPostsOnPage; i++) {
                            textHtml = '';
                            textHtml += '<div class = "row mt-1" ><div class = "employee" >';
                            textHtml += template(employees[i]);
                            textHtml += '</div ></div ><hr>';
                            $(".wrap").append(textHtml);
                        }
                        $(".wrap").append(paginate(employees.length,1,cntPostsOnPage));
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
    $('#positions').change(function () {
        formData = new FormData();
        formData.append('position_id', $('#positions').val());

        $.ajax(
            {
                url: '/positions/get',
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
                    var chefs = arr.chefs;
                    console.log(chefs);
                    var textHtml = '';
                    $('#chef').empty();

                    if(typeof chefs != 'undefined')
                        for(var i = 0; i < chefs.length; i++) {
                            textHtml='<option value="'+chefs[i]['id']+'">'+chefs[i]['surname']+' '+chefs[i]['name']+' '+chefs[i]['secondname']+'</option>';
                            $("#chef").append(textHtml);
                        }
                },
                error: function (result) {
                    console.log(result);
                }
            }
        );
    });
    var prevPage = 1;
    $('.pagin').live('click',function () {
       var curPage = $(this).html().trim();
        //alert(curPage);
        if(curPage == '&lt;') curPage= prevPage-1;
        else if (curPage=='&gt;')curPage = prevPage+1;
        else curPage = Number(curPage);
        if(curPage == prevPage)return;
        var begin = (curPage-1)*cntPostsOnPage;
        var end = curPage*cntPostsOnPage;
        if(curPage == endPage) end = (employees.length/cntPostsOnPage)*cntPostsOnPage;
        $(".wrap").empty();
        for (var i = begin; i < end; i++) {
            textHtml = '';
            textHtml += '<div class = "row mt-1" ><div class = "employee" >';
            textHtml += template(employees[i]);
            textHtml += '</div ></div ><hr>';
            $(".wrap").append(textHtml);
        }
        $(".wrap").append(paginate(employees.length,curPage,cntPostsOnPage));

        prevPage = curPage;



    });



});


