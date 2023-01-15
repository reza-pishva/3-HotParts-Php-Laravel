@extends('layouts.app_second_reciever')
@section('content')
    <script>
        $(document).ready(function(){
            bootstrap.Toast.Default.delay = 3000
            $('#for_second_confirmation').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/2level2',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                        var id_exit = ''
                        var l_name = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var history =''
                        var t1 = ''
                        var enter_exit=''
                        var edit1 = ''
                        var t3 = ''
                        var edit2 = ''
                        var del2 = ''
                        var t4 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td  style="border-left:1px white solid;font-size: x-small">شماره درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تاریخ درخواست</td><td  style="border-left:1px white solid;font-size: x-small">شرح درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تعداد موارد</td><td  style="border-left:1px white solid;font-size: x-small">نوع قطعه</td><td  style="border-left:1px white solid;font-size: x-small">نوع درخواست</td><td  style="border-left:1px white solid;font-size: x-small">همراه با بازگشت</td><td  style="border-left:1px white solid;font-size: x-small">درخواست کننده</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        $('tr').find('td:eq(2)').removeClass('description');//true
                        $('tr').find('td:eq(3)').removeClass('exit_no');//true
                        $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                        $('tr').find('td:eq(5)').removeClass('goods_type');
                        $('tr').find('td:eq(6)').removeClass('with_return');
                        $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                        $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                        $('tr').find('td:eq(11)').removeClass('with_return_text');

                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 5%;font-size: x-small" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%;font-size: x-small">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 26%;font-size: 11px" class="description">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_requester']){
                                    l_name = $('<td style="width: 9%;font-size: 11px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            if(response.results[i]['enter_exit']==1){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'خروج'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            if(response.results[i]['enter_exit']==2){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'ورود'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width:8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width: 9%"></td>')
                            history = $('<button type="button" class="btn-sm btn-outline-warning history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">گردش</button>').attr('id',  response.results[i]['id_exit'] + 5000)
                            edit1 = $('<button type="button" class="btn-sm btn-outline-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">تایید</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 7%"></td>')
                            t3 = $('<td style="width: 7%"></td>')
                            t4 = $('<td style="width: 7%"></td>')
                            edit2 = $('<button type="button" class="btn-sm btn-outline-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModaledit">اصلاح</button>').attr('id',  response.results[i]['id_exit'] + 2000)
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            t4.append(history)
                            t3.append(edit2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name,t2, t1,origin_destination,id_goods_type,with_return_value,t3,t4)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");


                            $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){

                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();

                                $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                                $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                                $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true

                                $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                                $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                                $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                                $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                                $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                                $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                                $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                                $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');

                            })
                            $('#' + response.results[i]['id_exit']).click(function () {

                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/confirm2/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی برای مدیر نیروگاه ارسال گردید")
                                        }
                                    });

                                $(this).closest('tr').remove()

                            })
                            $('#' + (response.results[i]['id_exit']+2000)).on('click',function(){
                                // $('#ajax-alert1').hide();
                                // $('#ajax-alert2').hide();
                                // $('#ajax-alert3').hide();
                                $('#id_exit22').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#description22').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#exit_no22').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#jamdari_no22').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#id_goods_type22').val($(this).closest('tr').find('td:eq(12)').text());
                                $('#with_return22').val($(this).closest('tr').find('td:eq(13)').text());
                                $('#origin_destination22').val($(this).closest('tr').find('td:eq(11)').text());//true
                            })
                            $(".history").on('click',function () {

                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/workflow/'+id_exit,
                                    method:'GET',
                                    success: function (response) {
                                        $('#myModal4').modal('show');
                                        var description = ''
                                        var date_shamsi = ''
                                        var time = ''
                                        var l_name = ''
                                        var row = ''
                                        $(".workflowrows").remove();
                                        for(var i = 0; i < response.results.length; i++) {
                                            description = $('<td style="width: 70%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                            date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                            time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                            for(var z = 0; z < response.users.length; z++) {
                                                if(response.users[z]['id']==response.results[i]['id_user']){
                                                    l_name = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.users[z]['l_name'] + '</td>')
                                                    break;
                                                }

                                            }
                                            row = $('<tr class="workflowrows"></tr>')
                                            row.append(date_shamsi,time,description,l_name)
                                            $("#workflow").append(row)
                                        }
                                    }
                                })
                            })



                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#for_modir').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level3',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد ارسالی برای مدیر نیروگاه</p>')
                        var id_exit = ''
                        var l_name = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td  style="border-left:1px white solid;">شماره درخواست</td><td  style="border-left:1px white solid;">تاریخ درخواست</td><td  style="border-left:1px white solid;">شرح درخواست</td><td  style="border-left:1px white solid;">تعداد موارد</td><td  style="border-left:1px white solid;">نوع قطعه</td><td  style="border-left:1px white solid;">نوع درخواست</td><td  style="border-left:1px white solid;">همراه با بازگشت</td><td  style="border-left:1px white solid;">درخواست کننده</td><td  style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        $('tr').find('td:eq(2)').removeClass('description');//true
                        $('tr').find('td:eq(3)').removeClass('exit_no');//true
                        $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                        $('tr').find('td:eq(5)').removeClass('goods_type');
                        $('tr').find('td:eq(6)').removeClass('with_return');
                        $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                        $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                        $('tr').find('td:eq(11)').removeClass('with_return_text');

                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 5%;font-size: x-small" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%;font-size: x-small">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 30%;font-size: 11px" class="description">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_requester']){
                                    l_name = $('<td style="width: 9%;font-size: 11px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            if(response.results[i]['enter_exit']==1){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'خروج'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            if(response.results[i]['enter_exit']==2){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'ورود'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width:8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width: 8%"></td>')
                            edit1 = $('<button hidden type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 15%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name, t2, t1,origin_destination,id_goods_type,with_return_value)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");


                            // $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                            //
                            //     $('#ajax-alert1').hide();
                            //     $('#ajax-alert2').hide();
                            //     $('#ajax-alert3').hide();
                            //
                            //     $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                            //     $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                            //     $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                            //     $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                            //     $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                            //     $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                            //     $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true
                            //
                            //     $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                            //     $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                            //     $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                            //     $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                            //     $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                            //     $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                            //     $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                            //     $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');
                            //
                            // })
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartabl2/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            bootstrap.Toast.Default.delay = 3000
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل موارد دریافتی بازگشت")
                                        }
                                    });
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#for_herasat').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/2not-confirmed-boss2',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که توسط شما تایید نشده و بازگشت داده شده</p>')
                        var id_exit = ''
                        var l_name = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td  style="border-left:1px white solid;font-size: x-small">شماره درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تاریخ درخواست</td><td  style="border-left:1px white solid;font-size: x-small">شرح درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تعداد موارد</td><td  style="border-left:1px white solid;font-size: x-small">نوع قطعه</td><td style="border-left:1px white solid;font-size: x-small">نوع درخواست</td><td style="border-left:1px white solid;font-size: x-small">همراه با بازگشت</td><td style="border-left:1px white solid;font-size: x-small">درخواست کننده</td><td style="border-left:1px white solid;font-size: x-small">#</td></tr>'
                        $("#report_table").append(row_th)

                        $('tr').find('td:eq(2)').removeClass('description');//true
                        $('tr').find('td:eq(3)').removeClass('exit_no');//true
                        $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                        $('tr').find('td:eq(5)').removeClass('goods_type');
                        $('tr').find('td:eq(6)').removeClass('with_return');
                        $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                        $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                        $('tr').find('td:eq(11)').removeClass('with_return_text');

                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 5%;font-size: x-small" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%;font-size: x-small">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 30%;font-size: 11px" class="description">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_requester']){
                                    l_name = $('<td style="width: 9%;font-size: 11px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            if(response.results[i]['enter_exit']==1){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'خروج'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            if(response.results[i]['enter_exit']==2){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'ورود'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width:8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width: 8%"></td>')
                            edit1 = $('<button hidden type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 15%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name, t2, t1,origin_destination,id_goods_type,with_return_value)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");


                            // $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                            //
                            //     $('#ajax-alert1').hide();
                            //     $('#ajax-alert2').hide();
                            //     $('#ajax-alert3').hide();
                            //
                            //     $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                            //     $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                            //     $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                            //     $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                            //     $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                            //     $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                            //     $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true
                            //
                            //     $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                            //     $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                            //     $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                            //     $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                            //     $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                            //     $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                            //     $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                            //     $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');
                            //
                            // })
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartabl2/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            bootstrap.Toast.Default.delay = 3000
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل موارد دریافتی بازگشت")
                                        }
                                    });
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#from_modir').click(function(event) {
                event.preventDefault();
                $("#report_table").removeClass("table table-dark table-hover")
                $.ajax({
                    url: '/level-3',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که مدیر نیروگاه تایید نکرده</p>')
                        var id_exit = ''
                        var l_name = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var reason1 = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">شرح درخواست</td><td style="border-left:1px white solid;">تعداد موارد</td><td style="border-left:1px white solid;">نوع قطعه</td><td style="border-left:1px white solid;">نوع درخواست</td><td style="border-left:1px white solid;">همراه با بازگشت</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        $('tr').find('td:eq(2)').removeClass('description');//true
                        $('tr').find('td:eq(3)').removeClass('exit_no');//true
                        $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                        $('tr').find('td:eq(5)').removeClass('goods_type');
                        $('tr').find('td:eq(6)').removeClass('with_return');
                        $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                        $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                        $('tr').find('td:eq(11)').removeClass('with_return_text');

                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 5%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 30%;font-size: 11px" class="description">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_requester']){
                                    l_name = $('<td style="width: 9%;font-size: 11px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            if(response.results[i]['enter_exit']==1){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'خروج'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            if(response.results[i]['enter_exit']==2){
                                enter_exit = $('<td style="width: 6%;font-size: 10px">' +'ورود'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                }
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width:8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width: 8%"></td>')
                            edit1 = $('<button hidden type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 15%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name, t2, t1,origin_destination,id_goods_type,with_return_value)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");


                            // $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                            //
                            //     $('#ajax-alert1').hide();
                            //     $('#ajax-alert2').hide();
                            //     $('#ajax-alert3').hide();
                            //
                            //     $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                            //     $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                            //     $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                            //     $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                            //     $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                            //     $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                            //     $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true
                            //
                            //     $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                            //     $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                            //     $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                            //     $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                            //     $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                            //     $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                            //     $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                            //     $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');
                            //
                            // })
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartabl2/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            bootstrap.Toast.Default.delay = 3000
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل موارد دریافتی بازگشت")
                                        }
                                    });
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#exit_part').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level4-1',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد در انتظار خروج</p>')
                        var l_name=''
                        var id_exit = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td>شماره درخواست</td><td>تاریخ درخواست</td><td>شرح درخواست</td><td>تعداد موارد</td><td>شماره جمعداری</td><td>نوع قطعه</td><td>همراه بازگشت</td><td>درخواست کننده</td><td>#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width:4%;font-size:10px" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width:6%;font-size:10px">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width:30%;font-size:10px">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width:7%;font-size:10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width:7%;font-size:10px">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if (response.users[z]['id'] == response.results[i]['id_requester']) {
                                    l_name = $('<td style="width: 7%;font-size:10px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            if(response.results[i]['with_return']==1){
                                with_return = $('<td style="width:4%;font-size:10px">' +'بله'+'</td>')
                            }
                            else
                            {
                                with_return = $('<td style="width:4%;font-size:10px">' + 'خیر' + '</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="font-size:10px">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width:15%"></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal2">انتقال به بایگانی</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: small;text-align: right">انتقال به بایگانی</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,l_name,origin_destination,id_goods_type,with_return_value,t2)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            // $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                            //
                            //     $('#ajax-alert1').hide();
                            //     $('#ajax-alert2').hide();
                            //     $('#ajax-alert3').hide();
                            //
                            //     $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                            //     $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                            //     $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                            //     $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                            //     $('#id_goods_type2').val($(this).closest('tr').find('td:eq(10)').text());
                            //     $('#with_return2').val($(this).closest('tr').find('td:eq(11)').text());
                            //     $('#origin_destination2').val($(this).closest('tr').find('td:eq(9)').text());//true
                            //
                            // })

                            $('#' + response.results[i]['id_exit']).click(function () {

                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/archive/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function (response) {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی به بایگانی منتقل شد")
                                        }
                                    });

                                $(this).closest('tr').remove()

                            })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }
                })
            })
            $('#enter_part').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level6',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد در انتظار ورود</p>')
                        var l_name=''
                        var id_exit = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var edit2 = ''
                        var t3 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ درخواست</td><td>شرح درخواست</td><td>تعداد موارد</td><td>شماره جمعداری</td><td>نوع قطعه</td><td>همراه بازگشت</td><td>درخواست کننده</td><td>#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width:4%;font-size:10px" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width:6%;font-size:10px">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width:30%;font-size:10px">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width:7%;font-size:10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width:7%;font-size:10px">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if (response.users[z]['id'] == response.results[i]['id_requester']) {
                                    l_name = $('<td style="width: 7%;font-size:10px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            if(response.results[i]['with_return']==1){
                                with_return = $('<td style="width:4%;font-size:10px">' +'بله'+'</td>')
                            }
                            else
                            {
                                with_return = $('<td style="width:4%;font-size:10px">' + 'خیر' + '</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="font-size:10px" >' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width:15%"></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal2">انتقال به بایگانی</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: small;text-align: right">انتقال به بایگانی</button>').attr('id',  response.results[i]['id_exit'])

                            t1.append(edit1)
                            t2 = $('<td></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)

                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,l_name,origin_destination,id_goods_type,with_return_value,t2)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            // $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                            //
                            //     $('#ajax-alert1').hide();
                            //     $('#ajax-alert2').hide();
                            //     $('#ajax-alert3').hide();
                            //
                            //     $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                            //     $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                            //     $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                            //     $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                            //     $('#id_goods_type2').val($(this).closest('tr').find('td:eq(10)').text());
                            //     $('#with_return2').val($(this).closest('tr').find('td:eq(11)').text());
                            //     $('#origin_destination2').val($(this).closest('tr').find('td:eq(9)').text());//true
                            //
                            // })

                            $('#' + response.results[i]['id_exit']).click(function () {

                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/archive/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function (response) {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی به بایگانی منتقل شد")
                                        }
                                    });

                                $(this).closest('tr').remove()

                            })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }
                })
            })
            $("#edit_form_request").on('submit',function(event) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/returnform2",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        // refresh page--
                        $.ajax({
                            url: '/2level2',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                                var id_exit = ''
                                var l_name = ''
                                var date_request_shamsi = ''
                                var origin_destination = ''
                                var description = ''
                                var exit_no = ''
                                var jamdari_no = ''
                                var goods_type_value = ''
                                var id_goods_type = ''
                                var with_return_value = ''
                                var with_return = ''
                                var history =''
                                var t1 = ''
                                var enter_exit=''
                                var edit1 = ''
                                var t3 = ''
                                var edit2 = ''
                                var del2 = ''
                                var t4 = ''
                                var t2 = ''
                                var row = ''
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td  style="border-left:1px white solid;font-size: x-small">شماره درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تاریخ درخواست</td><td  style="border-left:1px white solid;font-size: x-small">شرح درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تعداد موارد</td><td  style="border-left:1px white solid;font-size: x-small">نوع قطعه</td><td  style="border-left:1px white solid;font-size: x-small">نوع درخواست</td><td  style="border-left:1px white solid;font-size: x-small">همراه با بازگشت</td><td  style="border-left:1px white solid;font-size: x-small">درخواست کننده</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td></tr>'
                                $("#report_table").append(row_th)

                                $('tr').find('td:eq(2)').removeClass('description');//true
                                $('tr').find('td:eq(3)').removeClass('exit_no');//true
                                $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                                $('tr').find('td:eq(5)').removeClass('goods_type');
                                $('tr').find('td:eq(6)').removeClass('with_return');
                                $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                                $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                                $('tr').find('td:eq(11)').removeClass('with_return_text');

                                for(var i = 0; i < response.results.length; i++) {
                                    id_exit = $('<td style="width: 5%;font-size: x-small" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                                    date_request_shamsi = $('<td style="width: 10%;font-size: x-small">' + response.results[i]['date_request_shamsi'] + '</td>')
                                    origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                                    description = $('<td style="width: 26%;font-size: 11px" class="description">' + response.results[i]['description'] + '</td>')
                                    exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                                    jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                                    id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                                    for(var z = 0; z < response.users.length; z++) {
                                        if(response.users[z]['id']==response.results[i]['id_requester']){
                                            l_name = $('<td style="width: 9%;font-size: 11px">' + response.users[z]['l_name'] + '</td>')
                                            break;
                                        }

                                    }
                                    if(response.results[i]['enter_exit']==1){
                                        enter_exit = $('<td style="width: 6%;font-size: 10px">' +'خروج'+'</td>')
                                        if(response.results[i]['with_return']==1){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                        }
                                        if(response.results[i]['with_return']==2){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                        }
                                    }
                                    if(response.results[i]['enter_exit']==2){
                                        enter_exit = $('<td style="width: 6%;font-size: 10px">' +'ورود'+'</td>')
                                        if(response.results[i]['with_return']==1){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                        }
                                        if(response.results[i]['with_return']==2){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                        }
                                    }
                                    for(var j = 0; j < response.goodstypes.length; j++) {
                                        if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                            goods_type_value=$('<td style="width:8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                            break;
                                        }
                                    }
                                    with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                                    t1 = $('<td style="width: 9%"></td>')
                                    history = $('<button type="button" class="btn-sm btn-outline-warning history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">گردش</button>').attr('id',  response.results[i]['id_exit'] + 5000)
                                    edit1 = $('<button type="button" class="btn-sm btn-outline-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                                    del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">تایید</button>').attr('id',  response.results[i]['id_exit'])
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 7%"></td>')
                                    t3 = $('<td style="width: 7%"></td>')
                                    t4 = $('<td style="width: 7%"></td>')
                                    edit2 = $('<button type="button" class="btn-sm btn-outline-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModaledit">اصلاح</button>').attr('id',  response.results[i]['id_exit'] + 2000)
                                    row = $('<tr class="report_row"></tr>')
                                    t2.append(del2)
                                    t4.append(history)
                                    t3.append(edit2)
                                    row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name,t2, t1,origin_destination,id_goods_type,with_return_value,t3,t4)
                                    $("#report_table").append(row)
                                    $("#editlist").css("margin-top","100px");


                                    $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){

                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                        $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                                        $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                                        $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true

                                        $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                                        $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                                        $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                                        $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                                        $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                                        $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                                        $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                                        $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');

                                    })
                                    $('#' + response.results[i]['id_exit']).click(function () {

                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        //$('.toast').toast('show');
                                        $.ajax(
                                            {
                                                url: "/confirm2/" + id_exit,
                                                type: 'GET',
                                                data: {
                                                    "id": id_exit,
                                                    "_token": token,
                                                },
                                                success: function () {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی برای مدیر نیروگاه ارسال گردید")
                                                }
                                            });

                                        $(this).closest('tr').remove()

                                    })
                                    $('#' + (response.results[i]['id_exit']+2000)).on('click',function(){
                                        // $('#ajax-alert1').hide();
                                        // $('#ajax-alert2').hide();
                                        // $('#ajax-alert3').hide();
                                        $('#id_exit22').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description22').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#exit_no22').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#jamdari_no22').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#id_goods_type22').val($(this).closest('tr').find('td:eq(12)').text());
                                        $('#with_return22').val($(this).closest('tr').find('td:eq(13)').text());
                                        $('#origin_destination22').val($(this).closest('tr').find('td:eq(11)').text());//true
                                    })
                                    $(".history").on('click',function () {

                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        $.ajaxSetup({
                                            headers: {
                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            }
                                        });
                                        var _token = $("input[name='_token']").val();
                                        $.ajax({
                                            url: '/workflow/'+id_exit,
                                            method:'GET',
                                            success: function (response) {
                                                $('#myModal4').modal('show');
                                                var description = ''
                                                var date_shamsi = ''
                                                var time = ''
                                                var l_name = ''
                                                var row = ''
                                                $(".workflowrows").remove();
                                                for(var i = 0; i < response.results.length; i++) {
                                                    description = $('<td style="width: 70%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                                    date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                                    time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                                    for(var z = 0; z < response.users.length; z++) {
                                                        if(response.users[z]['id']==response.results[i]['id_user']){
                                                            l_name = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.users[z]['l_name'] + '</td>')
                                                            break;
                                                        }

                                                    }
                                                    row = $('<tr class="workflowrows"></tr>')
                                                    row.append(date_shamsi,time,description,l_name)
                                                    $("#workflow").append(row)
                                                }
                                            }
                                        })
                                    })



                                }
                                $(".mylist").hide();
                                $(".mylist2").hide();
                                $(".register").hide();
                                $(".mylist2").fadeToggle(2000);
                            }})
                        //---------------
                        $('#ajax-alert1').hide();
                        $('#ajax-alert2').hide();
                        $('#ajax-alert3').addClass('alert-primary').show(function(){
                            $(this).html("درخواست انتخاب شده بازگشت داده شد و دلیل عدم تایید مشخص گردید");
                        });
                        // $("#id_exit2").val('')
                        // $("#description2").val('')
                        // $("#origin_destination2").val('')
                        // $("#id_goods_type").text('')
                        $("#reason1").val('')


                    }
                });
            });
            $(".isclicked1").on('focus',function (event) {
                $('#ajax-alert1').hide();
                $('#ajax-alert2').hide();
                $('#ajax-alert3').hide();
            })
            $('#archive').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/show-archive',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد انتقالی به بایگانی</p>')
                        var id_exit = ''
                        var l_name = ''
                        var date_request_shamsi = ''
                        var origin_destination = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return_value = ''
                        var with_return = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td  style="border-left:1px white solid;">شماره درخواست</td><td  style="border-left:1px white solid;">تاریخ درخواست</td><td  style="border-left:1px white solid;">شرح درخواست</td><td  style="border-left:1px white solid;">تعداد موارد</td><td  style="border-left:1px white solid;">نوع قطعه</td><td  style="border-left:1px white solid;">نوع درخواست</td><td  style="border-left:1px white solid;">همراه با بازگشت</td><td  style="border-left:1px white solid;">درخواست کننده</td><td  style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        $('tr').find('td:eq(2)').removeClass('description');//true
                        $('tr').find('td:eq(3)').removeClass('exit_no');//true
                        $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                        $('tr').find('td:eq(5)').removeClass('goods_type');
                        $('tr').find('td:eq(6)').removeClass('with_return');
                        $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                        $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                        $('tr').find('td:eq(11)').removeClass('with_return_text');

                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 5%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 30%;font-size: 10px" class="description">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_requester']){
                                    l_name = $('<td style="width: 7%;font-size: 10px">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            if(response.results[i]['enter_exit']==1){
                                enter_exit = $('<td style="width: 6%">' +'خروج'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 4%">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 4%">' +'خیر'+'</td>')
                                }
                            }
                            if(response.results[i]['enter_exit']==2){
                                enter_exit = $('<td style="width: 6%">' +'ورود'+'</td>')
                                if(response.results[i]['with_return']==1){
                                    with_return = $('<td style="width: 4%">' +'بله'+'</td>')
                                }
                                if(response.results[i]['with_return']==2){
                                    with_return = $('<td style="width: 4%">' +'خیر'+'</td>')
                                }
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width: 8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td hidden style="width: 10%"></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 13%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name, t2, t1,origin_destination,id_goods_type,with_return_value)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");


                            // $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                            //
                            //     $('#ajax-alert1').hide();
                            //     $('#ajax-alert2').hide();
                            //     $('#ajax-alert3').hide();
                            //
                            //     $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                            //     $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                            //     $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                            //     $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                            //     $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                            //     $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                            //     $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true
                            //
                            //     $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                            //     $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                            //     $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                            //     $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                            //     $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                            //     $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                            //     $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                            //     $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');
                            //
                            // })
                            $('#' + response.results[i]['id_exit']).click(function () {

                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/return-archive/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی به کارتابل بازگشت داده شد")
                                        }
                                    });

                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $("#edit_form_request2").on('submit',function(event) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editformm",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $("#myModaledit").modal("hide");
                        event.preventDefault();
                        $.ajax({
                            url: '/2level2',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                                var id_exit = ''
                                var l_name = ''
                                var date_request_shamsi = ''
                                var origin_destination = ''
                                var description = ''
                                var exit_no = ''
                                var jamdari_no = ''
                                var goods_type_value = ''
                                var id_goods_type = ''
                                var with_return_value = ''
                                var with_return = ''
                                var history =''
                                var t1 = ''
                                var enter_exit=''
                                var edit1 = ''
                                var t3 = ''
                                var edit2 = ''
                                var del2 = ''
                                var t4 = ''
                                var t2 = ''
                                var row = ''
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;font-size: x-small"><td  style="border-left:1px white solid;font-size: x-small">شماره درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تاریخ درخواست</td><td  style="border-left:1px white solid;font-size: x-small">شرح درخواست</td><td  style="border-left:1px white solid;font-size: x-small">تعداد موارد</td><td  style="border-left:1px white solid;font-size: x-small">نوع قطعه</td><td  style="border-left:1px white solid;font-size: x-small">نوع درخواست</td><td  style="border-left:1px white solid;font-size: x-small">همراه با بازگشت</td><td  style="border-left:1px white solid;font-size: x-small">درخواست کننده</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td><td  style="border-left:1px white solid;">#</td></tr>'
                                $("#report_table").append(row_th)

                                $('tr').find('td:eq(2)').removeClass('description');//true
                                $('tr').find('td:eq(3)').removeClass('exit_no');//true
                                $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                                $('tr').find('td:eq(5)').removeClass('goods_type');
                                $('tr').find('td:eq(6)').removeClass('with_return');
                                $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                                $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                                $('tr').find('td:eq(11)').removeClass('with_return_text');

                                for(var i = 0; i < response.results.length; i++) {
                                    id_exit = $('<td style="width: 5%;font-size: x-small" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                                    date_request_shamsi = $('<td style="width: 10%;font-size: x-small">' + response.results[i]['date_request_shamsi'] + '</td>')
                                    origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                                    description = $('<td style="width: 26%;font-size: 11px" class="description">' + response.results[i]['description'] + '</td>')
                                    exit_no = $('<td style="width: 8%;font-size: 10px">' + response.results[i]['exit_no'] + '</td>')
                                    jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                                    id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                                    for(var z = 0; z < response.users.length; z++) {
                                        if(response.users[z]['id']==response.results[i]['id_requester']){
                                            l_name = $('<td style="width: 9%;font-size: 11px">' + response.users[z]['l_name'] + '</td>')
                                            break;
                                        }

                                    }
                                    if(response.results[i]['enter_exit']==1){
                                        enter_exit = $('<td style="width: 6%;font-size: 10px">' +'خروج'+'</td>')
                                        if(response.results[i]['with_return']==1){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                        }
                                        if(response.results[i]['with_return']==2){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                        }
                                    }
                                    if(response.results[i]['enter_exit']==2){
                                        enter_exit = $('<td style="width: 6%;font-size: 10px">' +'ورود'+'</td>')
                                        if(response.results[i]['with_return']==1){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'بله'+'</td>')
                                        }
                                        if(response.results[i]['with_return']==2){
                                            with_return = $('<td style="width: 6%;font-size: 10px">' +'خیر'+'</td>')
                                        }
                                    }
                                    for(var j = 0; j < response.goodstypes.length; j++) {
                                        if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                            goods_type_value=$('<td style="width:8%;font-size: 10px">' + response.goodstypes[j]['description'] + '</td>');
                                            break;
                                        }
                                    }
                                    with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                                    t1 = $('<td style="width: 9%"></td>')
                                    history = $('<button type="button" class="btn-sm btn-outline-warning history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">گردش</button>').attr('id',  response.results[i]['id_exit'] + 5000)
                                    edit1 = $('<button type="button" class="btn-sm btn-outline-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                                    del2 = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">تایید</button>').attr('id',  response.results[i]['id_exit'])
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 7%"></td>')
                                    t3 = $('<td style="width: 7%"></td>')
                                    t4 = $('<td style="width: 7%"></td>')
                                    edit2 = $('<button type="button" class="btn-sm btn-outline-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModaledit">اصلاح</button>').attr('id',  response.results[i]['id_exit'] + 2000)
                                    row = $('<tr class="report_row"></tr>')
                                    t2.append(del2)
                                    t4.append(history)
                                    t3.append(edit2)
                                    row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value,enter_exit, with_return,l_name,t2, t1,origin_destination,id_goods_type,with_return_value,t3,t4)
                                    $("#report_table").append(row)
                                    $("#editlist").css("margin-top","100px");


                                    $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){

                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                        $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#id_goods_type2').val($(this).closest('tr').find('td:eq(13)').text());
                                        $('#with_return2').val($(this).closest('tr').find('td:eq(12)').text());
                                        $('#origin_destination2').val($(this).closest('tr').find('td:eq(11)').text());//true

                                        $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                                        $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                                        $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                                        $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                                        $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                                        $(this).closest('tr').find('td:eq(11)').addClass('origin_destination');//true
                                        $(this).closest('tr').find('td:eq(13)').addClass('goods_type_value');//true
                                        $(this).closest('tr').find('td:eq(12)').addClass('with_return_text');

                                    })
                                    $('#' + response.results[i]['id_exit']).click(function () {

                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        //$('.toast').toast('show');
                                        $.ajax(
                                            {
                                                url: "/confirm2/" + id_exit,
                                                type: 'GET',
                                                data: {
                                                    "id": id_exit,
                                                    "_token": token,
                                                },
                                                success: function () {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی برای مدیر نیروگاه ارسال گردید")
                                                }
                                            });

                                        $(this).closest('tr').remove()

                                    })
                                    $('#' + (response.results[i]['id_exit']+2000)).on('click',function(){
                                        // $('#ajax-alert1').hide();
                                        // $('#ajax-alert2').hide();
                                        // $('#ajax-alert3').hide();
                                        $('#id_exit22').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description22').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#exit_no22').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#jamdari_no22').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#id_goods_type22').val($(this).closest('tr').find('td:eq(12)').text());
                                        $('#with_return22').val($(this).closest('tr').find('td:eq(13)').text());
                                        $('#origin_destination22').val($(this).closest('tr').find('td:eq(11)').text());//true
                                    })
                                    $(".history").on('click',function () {

                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        $.ajaxSetup({
                                            headers: {
                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            }
                                        });
                                        var _token = $("input[name='_token']").val();
                                        $.ajax({
                                            url: '/workflow/'+id_exit,
                                            method:'GET',
                                            success: function (response) {
                                                $('#myModal4').modal('show');
                                                var description = ''
                                                var date_shamsi = ''
                                                var time = ''
                                                var l_name = ''
                                                var row = ''
                                                $(".workflowrows").remove();
                                                for(var i = 0; i < response.results.length; i++) {
                                                    description = $('<td style="width: 70%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                                    date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                                    time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                                    for(var z = 0; z < response.users.length; z++) {
                                                        if(response.users[z]['id']==response.results[i]['id_user']){
                                                            l_name = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.users[z]['l_name'] + '</td>')
                                                            break;
                                                        }

                                                    }
                                                    row = $('<tr class="workflowrows"></tr>')
                                                    row.append(date_shamsi,time,description,l_name)
                                                    $("#workflow").append(row)
                                                }
                                            }
                                        })
                                    })



                                }
                                $(".mylist").hide();
                                $(".mylist2").hide();
                                $(".register").hide();
                                $(".mylist2").fadeToggle(2000);
                            }})

                    }})
            });


        });
    </script>

    <div class="row mylist" style="margin: auto;width:80%;display: none">
        <div class="col-12 bg-info" style="height: 35px;margin-top: 30px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right"><p id="title" style="margin-top: 7px;"></p></div>

    </div>
    <!-- List of content -->
    <div class="row mylist" style="margin: auto;width:80%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
        <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
            <table id="request_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                <tr class="bg-primary" style="color: white">
                    <td>شماره درخواست</td>
                    <td>تاریخ درخواست</td>
                    <td>شرح درخواست</td>
                    <td>تعداد موارد</td>
                    <td>شماره جمعداری</td>
                    <td>نوع قطعه</td>
                    <td>همراه بازگشت</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
            </table>
        </div>
    </div>
    <!-- Edit form -->
    <div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین علت عدم تایید</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10">.</div>
                                <div class="col-2">
                                    <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <!-- Edit form -->
                <div class="container" id="reason_win" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="edit_form_request" action="{{route('returnform.edit')}}">
                        {{csrf_field()}}
                        {{--                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>--}}
                        <input type="hidden" class="form-control" id="id_exit2"  name="id_exit2">
                        {{--                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>--}}
                        <input type="hidden" class="form-control" id="date_request_shamsi2"  name="date_request_shamsi" value={{$date_shamsi}}>
                        <input type="hidden" class="form-control" id="date_request_miladi2"  name="date_request_miladi" value={{$mytime}}>
                        <input type="hidden" class="form-control" id="time_request2"  name="time_request" value={{$mytime->toTimeString()}}>
                        <input type="hidden" class="form-control" id="request_timestamp2"  name="request_timestamp" value={{$mytime->timestamp}}>
                        <input type="hidden" class="form-control" id="id_requester2" placeholder="Enter the id of requester" name="id_requester" value={{$user}}>
                        <input type="hidden" class="form-control" id="id_request_part2" name="id_request_part" value={{$part}}>
                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">مقصد:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نوع قطعه:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" class="form-control" id="origin_destination2" name="origin_destination2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <select class="form-control" name="id_goods_type2" id="id_goods_type2" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                        @foreach($goodstypes as $goodstype)
                                            <option value="{{$goodstype->id_goods_type}}">{{$goodstype->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">شرح انتقال:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-12">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" class="form-control" id="description2"  name="description2" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">علت عدم تایید:</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" maxlength="80" data-toggle="tooltip" data-placement="right" required title="در اینجا علت عدم تایید وارد شود" class="form-control" id="reason1"  name="reason2" style="direction:rtl;font-family:Tahoma;font-size:small;">
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="jamdari_no2"  name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" value={{old('jamdari_no')}}>
                                </div>
                            </div>
                            <div class="col" style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                            </div>
                        </div>

                    </form>
                    <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px">

                </div>

            </div>
        </div>
    </div>
    <!-- Title of report -->
    <div class="row mylist2" style="margin: auto;width:100%;display: none;margin-top: 10px">
        <div class="col-12" id="title_report" style="height: 35px;margin-top: 10px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color:rgb(14,53,126)"></div>
    </div>
    <!-- content of report -->
    <div class="row mylist2" style="margin: auto;width:100%;height:302px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
        <div class="col-12" style="direction: rtl;height: 300px;overflow-y: scroll;">
            <table id="report_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
        </div>

        <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
            <div class="toast-body"><p id="mytoast" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
        </div>
    </div>

    <div class="modal fade mt-3" id="myModaledit" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 100px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10">.</div>
                                <div class="col-2">
                                    <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>


                <!-- Edit form -->
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="edit_form_request2" action="{{route('editformm.edit44')}}">
                        {{csrf_field()}}
                        {{--                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>--}}
                        <input type="hidden" class="form-control" id="id_exit22"  name="id_exit2">
                        {{--                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>--}}
                        {{--                        <input type="hidden" class="form-control" id="date_request_shamsi22"  name="date_request_shamsi" value={{$date_shamsi}}>--}}
                        {{--                        <input type="hidden" class="form-control" id="date_request_miladi22"  name="date_request_miladi" value={{$mytime}}>--}}
                        {{--                        <input type="hidden" class="form-control" id="time_request22"  name="time_request" value={{$mytime->toTimeString()}}>--}}
                        {{--                        <input type="hidden" class="form-control" id="request_timestamp22"  name="request_timestamp" value={{$mytime->timestamp}}>--}}
                        {{--                        <input type="hidden" class="form-control" id="id_requester22" placeholder="Enter the id of requester" name="id_requester" value={{$user}}>--}}
                        {{--                        <input type="hidden" class="form-control" id="id_request_part22" name="id_request_part" value={{$part}}>--}}
                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">مقصد:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نوع قطعه:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="30" class="form-control" id="origin_destination22"  data-toggle="tooltip" data-placement="right" placeholder="مقصد قطعه:" name="origin_destination2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا مبدا یا مقصد این قطعه را وارد کنید">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <select class="form-control" name="id_goods_type2" id="id_goods_type22" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                        @foreach($goodstypes as $goodstype)
                                            <option value="{{$goodstype->id_goods_type}}">{{$goodstype->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">شرح انتقال:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-12">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="50" class="form-control" id="description22" data-toggle="tooltip" data-placement="right" placeholder="شرح کالا یا قطعه:" name="description2" style="direction:rtl;font-family:Tahoma;font-size:small" required title="شرح کالا و یا قطعه مورد نظر برای ورود یا خروج از نیروگاه">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">تعداد قطعه:</p>
                            </div>
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">همراه با بازگشت:</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input type="text" class="form-control isclicked1" id="exit_no22" data-toggle="tooltip" data-placement="right" placeholder="تعداد موارد:" name="exit_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width:110px;display: inline" required title="تعداد مواردی که باید وارد یا خارج از نیروگاه شوند">
                                    {{--                                    <select class="form-control isclicked1" name="unit2" id="unit22" style="width:95px;font-family: Tahoma;font-size: small;display: inline">--}}
                                    {{--                                        <option value='عدد'>عدد</option>--}}
                                    {{--                                        <option value='کیلو'>کیلو</option>--}}
                                    {{--                                        <option value='تن'>تن</option>--}}
                                    {{--                                        <option value='لیتر'>لیتر</option>--}}
                                    {{--                                        <option value='مترمکعب'>مترمکعب</option>--}}
                                    {{--                                        <option value='متر'>متر</option>--}}
                                    {{--                                    </select>--}}
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right" id="with_return_edit22">
                                    <select class="form-control" name="with_return2" id="with_return22" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                        <option value=1>بله</option>
                                        <option value=2>خیر</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 20px;margin-top:18px">
                            <div class="col-12">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">شماره سریال یا جمعداری:</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no22" data-toggle="tooltip" data-placement="right" placeholder="شماره سریال یا جمعداری:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">اعمال تغییرات</button>
                            </div>
                        </div>
                        <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="myModal4" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">گردش درخواست</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <!-- List -->
                <div class="container"  style="margin: auto;background-color:#c4e6f5;width: 850px ;height: 400px;;overflow-y: scroll">
                    <table class="table table-striped" id="workflow" style="width: 800px">
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>
@endsection
