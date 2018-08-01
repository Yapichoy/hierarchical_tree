function incl(_layer) {
    var text ='<div class="wrapper"><div class="row mt-3 p-1"> <div class="col-3 photo">фото </div> <div class="col-9 info"> <div class="fio">ФИО: ';
         text += _layer['surname']+' '+_layer['name']+' '+_layer['secondname'];
            text += '</div> <div class="position">Должность: ';
            text += _layer['denomination'];
            text += '</div> <div class="date">Дата начала работы: ';
            text += _layer['date_start_work'];
            text += '</div> <div class="salary">Зарплата: ';
            text += _layer['salary']+'p';
            text += '</div> </div> </div></div>';
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

});
