@extends('layouts.app_fourth_reciever')
@section('content')
    <script>

        $(document).ready(function(){
            bootstrap.Toast.Default.delay = 2000
            $('#time_enter2').timepicker();
            $('#time_exit2').timepicker();
            $('#setTimeButton').on('click', function() {
                $('#time_enter2').timepicker('setTime', new Date());
            });
            $('#setTimeButton2').on('click', function() {
                $('#time_exit2').timepicker('setTime', new Date());
            });
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
                        var history = ''
                        var t2 = ''
                        var t3 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ درخواست</td><td>شرح درخواست</td><td>تعداد موارد</td><td>شماره جمعداری</td><td>نوع قطعه</td><td>همراه بازگشت</td><td>درخواست کننده</td><td>#</td><td>#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width:4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width:6%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width:30%">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width:7%">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width:7%">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if (response.users[z]['id'] == response.results[i]['id_requester']) {
                                    l_name = $('<td style="width: 7%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            if(response.results[i]['with_return']==1){
                                with_return = $('<td style="width:4%">' +'بله'+'</td>')
                            }
                            else
                            {
                                with_return = $('<td style="width:4%">' + 'خیر' + '</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td >' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width:15%"></td>')
                            history = $('<button type="button" class="btn-sm btn-primary history" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal10" disabled>سابقه</button>').attr('id',  response.results[i]['id_exit'] + 10000)
                            edit1 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal2">تکمیل اطلاعات خروج</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: right">حذف</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td></td>')
                            t3 = $('<td></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            t3.append(history)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,l_name,t1,origin_destination,id_goods_type,with_return_value,t3)
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
                                $('#id_goods_type2').val($(this).closest('tr').find('td:eq(10)').text());
                                $('#with_return2').val($(this).closest('tr').find('td:eq(11)').text());
                                $('#origin_destination2').val($(this).closest('tr').find('td:eq(9)').text());//true

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
                                        $('#myModal10').modal('show');
                                        var description = ''
                                        var date_shamsi = ''
                                        var time = ''
                                        var row = ''
                                        $(".workflowrows").remove();
                                        for(var i = 0; i < response.results.length; i++) {
                                            description = $('<td style="width: 80%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                            date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                            time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                            row = $('<tr class="workflowrows"></tr>')
                                            row.append(date_shamsi,time,description)
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
                    }
                })
            })
            $('#enter_part').click(function(event) {
                event.preventDefault();
                $("#report_table").removeClass("table table-dark table-hover")
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
                        var history = ''
                        var del2 = ''
                        var t2 = ''
                        var t3 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ درخواست</td><td>شرح درخواست</td><td>تعداد موارد</td><td>شماره جمعداری</td><td>نوع قطعه</td><td>همراه بازگشت</td><td>درخواست کننده</td><td>#</td><td>#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td class="id_exit" style="width:5%">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width:7%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width:35%">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width:5%">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width:7%">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if (response.users[z]['id'] == response.results[i]['id_requester']) {
                                    l_name = $('<td style="width: 7%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            if(response.results[i]['with_return']==1){
                                with_return = $('<td style="width:5%">' +'بله'+'</td>')
                            }
                            else
                            {
                                with_return = $('<td style="width:5%">' + 'خیر' + '</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width:4%">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width:15%"></td>')
                            history = $('<button type="button" class="btn-sm btn-primary history" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal10" disabled>سابقه</button>').attr('id',  response.results[i]['id_exit'] + 10000)
                            edit1 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal3">تکمیل اطلاعات ورود</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: right">حذف</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td></td>')
                            t3 = $('<td></td>')
                            if( response.results[i]['iscomplete']==2){
                                row = $('<tr style="color: #c82333" class="report_row"></tr>')
                            } else{
                                row = $('<tr style="color: black" class="report_row"></tr>')
                            }
                            t2.append(del2)
                            t3.append(history)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,l_name,t1,origin_destination,id_goods_type,with_return_value,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){
                                $('#time_enter2').val('')
                                $('#date_enter_shamsi2').val('')
                                $('#enter_driver2').val('')
                                $('#car_name_enter2').val('')
                                $('#car_no_enter2').val('')
                                $('#iscomplete').val(1)
                                $('#description_detail4').val('')
                                $("#no4").val('')
                                $("#no5").val('')
                                $("#no6").val('')
                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();
                                $('#id_exit3').val($(this).closest('tr').find('td:eq(0)').text());
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
                                        $('#myModal10').modal('show');
                                        var description = ''
                                        var date_shamsi = ''
                                        var time = ''
                                        var row = ''
                                        $(".workflowrows").remove();
                                        for(var i = 0; i < response.results.length; i++) {
                                            description = $('<td style="width: 80%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                            date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                            time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                            row = $('<tr class="workflowrows"></tr>')
                                            row.append(date_shamsi,time,description)
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
                    }
                })
            })
            $('#third_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level5',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد قابل ویرایش و یا بازگشت به کارتابل</p>')
                        var l_name = ''
                        var part100=''
                        var part200=''
                        var part300=''
                        var id_exit = ''
                        var date_exit_shamsi = ''
                        var exit_driver = ''
                        var description = ''
                        var car_name_exit = ''
                        var car_no_exit = ''
                        var time_exit='';
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ خروج</td><td>درخواست</td><td>خارج کننده</td><td>خودرو</td><td>.</td><td>.</td><td>.</td><td>ساعت خروج</td><td>#</td><td>#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_exit_shamsi = $('<td style="width: 11%">' + response.results[i]['date_exit_shamsi'] + '</td>')
                            description = $('<td style="width: 35%">' + response.results[i]['description'] + '</td>')
                            exit_driver = $('<td style="width: 13%">' + response.results[i]['exit_driver'] + '</td>')
                            car_name_exit = $('<td style="width: 8%">' + response.results[i]['car_name_exit'] + '</td>')
                            car_no_exit = $('<td hidden>' + response.results[i]['car_no_exit'] + '</td>')
                            part100=$('<td style="width: 1%">'+response.results[i]['car_no_exit'].toString().substr(1,2)+'</td>')
                            part200=$('<td style="width: 1%">'+response.results[i]['car_no_exit'].toString().substr(0,1)+'</td>')
                            part300=$('<td style="width: 2%">'+response.results[i]['car_no_exit'].toString().substr(3,3)+'</td>')
                            time_exit = $('<td style="width: 10%">' + response.results[i]['time_exit'] + '</td>')
                            t1 = $('<td style="width: 15%"></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal4">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 15%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_exit_shamsi, description, exit_driver, car_name_exit,part300,part200,part100,car_no_exit,time_exit, t2, t1)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){

                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();

                                $('#id_exit4').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#description3').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#date_exit_shamsi3').val($(this).closest('tr').find('td:eq(1)').text());
                                $('#time_exit3').val($(this).closest('tr').find('td:eq(9)').text());
                                $('#exit_driver3').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#car_name_exit3').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#car_no_exit3').val($(this).closest('tr').find('td:eq(8)').text());
                                var part1=$("#car_no_exit3").val().toString().substr(1,2)
                                var part2=$("#car_no_exit3").val().toString().substr(0,1)
                                var part3=$("#car_no_exit3").val().toString().substr(3,3)
                                $("#no7").val($(this).closest('tr').find('td:eq(5)').text());
                                $("#no8").val($(this).closest('tr').find('td:eq(6)').text());
                                $("#no9").val($(this).closest('tr').find('td:eq(7)').text());

                            })
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/return4/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی به کارتابل شخصی شما بازگشت داده شد")
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
            $('#fourth_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level7',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد قابل ویرایش و یا بازگشت به کارتابل</p>')
                        var iscomplete=''
                        var part100=''
                        var part200=''
                        var part300=''
                        var id_exit = ''
                        var date_enter_shamsi = ''
                        var enter_driver = ''
                        var description = ''
                        var car_name_enter = ''
                        var car_no_enter = ''
                        var time_enter='';
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ ورود</td><td>درخواست</td><td>وارد کننده</td><td>خودرو</td><td>.</td><td>.</td><td>.</td><td>ساعت ورود</td><td>#</td><td>#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            iscomplete = $('<td hidden style="width: 4%">' + response.results[i]['iscomplete'] + '</td>')
                            date_enter_shamsi = $('<td style="width: 11%">' + response.results[i]['date_enter_shamsi'] + '</td>')
                            description = $('<td style="width: 35%">' + response.results[i]['description'] + '</td>')
                            enter_driver = $('<td style="width: 13%">' + response.results[i]['enter_driver'] + '</td>')
                            car_name_enter = $('<td style="width: 8%">' + response.results[i]['car_name_enter'] + '</td>')
                            car_no_enter = $('<td hidden>' + response.results[i]['car_no_enter'] + '</td>')
                            time_enter = $('<td style="width: 10%">' + response.results[i]['time_enter'] + '</td>')
                            part100=$('<td style="width: 1%">'+response.results[i]['car_no_enter'].toString().substr(1,2)+'</td>')
                            part200=$('<td style="width: 1%">'+response.results[i]['car_no_enter'].toString().substr(0,1)+'</td>')
                            part300=$('<td style="width: 2%">'+response.results[i]['car_no_enter'].toString().substr(3,3)+'</td>')
                            t1 = $('<td style="width: 15%"></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-primary edit1" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal5">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 15%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_enter_shamsi, description, enter_driver, car_name_enter,part300,part200,part100,car_no_enter,time_enter, t2, t1,iscomplete)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('.edit1').on('click',function(){

                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();

                                $('#id_exit5').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#description4').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#date_enter_shamsi4').val($(this).closest('tr').find('td:eq(1)').text());
                                $('#time_enter4').val($(this).closest('tr').find('td:eq(9)').text());
                                $('#enter_driver4').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#car_name_enter4').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#car_no_enter4').val($(this).closest('tr').find('td:eq(8)').text());
                                var part1=$("#car_no_enter4").val().toString().substr(1,2)
                                var part2=$("#car_no_enter4").val().toString().substr(0,1)
                                var part3=$("#car_no_enter4").val().toString().substr(3,3)
                                $("#no10").val($(this).closest('tr').find('td:eq(5)').text());
                                $("#no11").val($(this).closest('tr').find('td:eq(6)').text());
                                $("#no12").val($(this).closest('tr').find('td:eq(7)').text());
                                $("#iscomplete4").val($(this).closest('tr').find('td:eq(12)').text());



                            })
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/return4/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی به کارتابل شخصی شما بازگشت داده شد")
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
            $("#edit_form_request1").on('submit',function(event) {
                var date_shamsi_exit_r=$("#date_exit_shamsi2").val();
                var date_shamsi_exit_split=date_shamsi_exit_r.split('/',3);

                var with_return=''
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editform2",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        $("#no1").val('')
                        $("#no2").val('')
                        $("#no3").val('')
                        var id_exit = $("#id_exit2").val();
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                                url: "/confirm4/" + id_exit,
                                type: 'GET',
                                data: {
                                    "id": id_exit,
                                    "_token": token,
                                },
                                success: function () {
                                    
                                     $("#"+(Number(id_exit)+1000)).closest('tr').remove();
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "3000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.success('اطلاعات مربوط به خروج قطعه یا کالا ثبت شد');
                                    $("#date_exit_shamsi_r2").val('');
                                    $("#date_exit_shamsi2").val('');
                                    $("#time_exit2").val('');
                                    $("#exit_driver2").val('');
                                    $("#car_name_exit2").val('');
                                    $("#car_no_exit2").val('');
                                    $('#myModal2').modal('toggle');
                                }
                            });


                    }
                });
            });
            $("#edit_form_request3").on('submit',function(event) {
                var date_shamsi_exit_r=$("#date_exit_shamsi3").val();
                var date_shamsi_exit_split=date_shamsi_exit_r.split('/',3);
                $("#date_exit_shamsi_r3").val(date_shamsi_exit_split[0]+date_shamsi_exit_split[1]+date_shamsi_exit_split[2]);
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editform22",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        event.preventDefault();
                        $.ajax({
                            url: '/level5',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد قابل ویرایش و یا بازگشت به کارتابل</p>')
                                var part100=''
                                var part200=''
                                var part300=''
                                var id_exit = ''
                                var date_exit_shamsi = ''
                                var exit_driver = ''
                                var description = ''
                                var car_name_exit = ''
                                var car_no_exit = ''
                                var time_exit='';
                                var t1 = ''
                                var edit1 = ''
                                var del2 = ''
                                var t2 = ''
                                var row = ''
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ خروج</td><td>درخواست</td><td>خارج کننده</td><td>خودرو</td><td>.</td><td>.</td><td>.</td><td>ساعت خروج</td><td>#</td><td>#</td></tr>'
                                $("#report_table").append(row_th)
                                for(var i = 0; i < response.results.length; i++) {
                                    id_exit = $('<td style="width: 4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                                    date_exit_shamsi = $('<td style="width: 11%">' + response.results[i]['date_exit_shamsi'] + '</td>')
                                    description = $('<td style="width: 35%">' + response.results[i]['description'] + '</td>')
                                    exit_driver = $('<td style="width: 13%">' + response.results[i]['exit_driver'] + '</td>')
                                    car_name_exit = $('<td style="width: 8%">' + response.results[i]['car_name_exit'] + '</td>')
                                    car_no_exit = $('<td hidden>' + response.results[i]['car_no_exit'] + '</td>')
                                    part100=$('<td style="width: 1%">'+response.results[i]['car_no_exit'].toString().substr(1,2)+'</td>')
                                    part200=$('<td style="width: 1%">'+response.results[i]['car_no_exit'].toString().substr(0,1)+'</td>')
                                    part300=$('<td style="width: 2%">'+response.results[i]['car_no_exit'].toString().substr(3,3)+'</td>')
                                    time_exit = $('<td style="width: 10%">' + response.results[i]['time_exit'] + '</td>')

                                    t1 = $('<td style="width: 15%"></td>')
                                    edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal4">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                                    del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 15%"></td>')
                                    row = $('<tr class="report_row"></tr>')
                                    t2.append(del2)
                                    row.append(id_exit, date_exit_shamsi, description, exit_driver, car_name_exit,part300,part200,part100,car_no_exit,time_exit, t2, t1)
                                    $("#report_table").append(row)
                                    $("#editlist").css("margin-top","100px");
                                    $('#' + (response.results[i]['id_exit']+1000)).on('click',function(){

                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                        $('#id_exit4').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description3').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#date_exit_shamsi3').val($(this).closest('tr').find('td:eq(1)').text());
                                        $('#time_exit3').val($(this).closest('tr').find('td:eq(9)').text());
                                        $('#exit_driver3').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#car_name_exit3').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#car_no_exit3').val($(this).closest('tr').find('td:eq(8)').text());
                                        var part1=$("#car_no_exit3").val().toString().substr(1,2)
                                        var part2=$("#car_no_exit3").val().toString().substr(0,1)
                                        var part3=$("#car_no_exit3").val().toString().substr(3,3)
                                        $("#no7").val($(this).closest('tr').find('td:eq(5)').text());
                                        $("#no8").val($(this).closest('tr').find('td:eq(6)').text());
                                        $("#no9").val($(this).closest('tr').find('td:eq(7)').text());

                                    })
                                    $('#' + response.results[i]['id_exit']).click(function () {
                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        $.ajax(
                                            {
                                                url: "/return4/" + id_exit,
                                                type: 'GET',
                                                data: {
                                                    "id": id_exit,
                                                    "_token": token,
                                                },
                                                success: function () {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی به کارتابل شخصی شما بازگشت داده شد")
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
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.info('اطلاعات مربوط به خروج قطعه یا کالا اصلاح شد');
                        $("#date_exit_shamsi_r3").val('');
                        $("#date_exit_shamsi3").val('');
                        $("#time_exit3").val('');
                        $("#exit_driver3").val('');
                        $("#car_name_exit3").val('');
                        $("#car_no_exit3").val('');
                        $('#myModal4').modal('toggle');


                    }
                });
            });
            $("#edit_form_request2").on('submit',function(event) {

                var date_shamsi_enter_r=$("#date_enter_shamsi2").val();
                var date_shamsi_enter_split=date_shamsi_enter_r.split('/',3);
                $("#date_enter_shamsi_r2").val(date_shamsi_enter_split[0]+date_shamsi_enter_split[1]+date_shamsi_enter_split[2]);
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editform3",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        var id_exit = $("#id_exit3").val();
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: "/confirm4-2/" + id_exit,
                            type: 'GET',
                            data: {
                                "id": id_exit,
                                "_token": token,
                            },
                            success: function () {
                               
                                $("#"+(Number(id_exit)+1000)).closest('tr').remove();
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "positionClass": "toast-top-right",
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "3000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                };
                                toastr.success('اطلاعات مربوط به ورود قطعه یا کالا ثبت شد');
                                $("#date_exit_shamsi_r2").val('');
                                $("#date_exit_shamsi2").val('');
                                $("#time_exit2").val('');
                                $("#exit_driver2").val('');
                                $("#car_name_exit2").val('');
                                $("#car_no_exit2").val('');
                                $('#myModal3').modal('toggle');
                            }
                        });


                    }
                });
            });
            $("#edit_form_request4").on('submit',function(event) {

                var date_shamsi_enter_r=$("#date_enter_shamsi4").val();
                var date_shamsi_enter_split=date_shamsi_enter_r.split('/',3);
                $("#date_enter_shamsi_r4").val(date_shamsi_enter_split[0]+date_shamsi_enter_split[1]+date_shamsi_enter_split[2]);
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editform33",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        event.preventDefault();
                        $.ajax({
                            url: '/level7',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد قابل ویرایش و یا بازگشت به کارتابل</p>')
                                var part100=''
                                var part200=''
                                var part300=''
                                var id_exit = ''
                                var date_enter_shamsi = ''
                                var enter_driver = ''
                                var description = ''
                                var car_name_enter = ''
                                var car_no_enter = ''
                                var time_enter='';
                                var t1 = ''
                                var edit1 = ''
                                var del2 = ''
                                var t2 = ''
                                var row = ''
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td>شماره درخواست</td><td>تاریخ ورود</td><td>درخواست</td><td>وارد کننده</td><td>خودرو</td><td>.</td><td>.</td><td>.</td><td>ساعت ورود</td><td>#</td><td>#</td></tr>'
                                $("#report_table").append(row_th)
                                for(var i = 0; i < response.results.length; i++) {
                                    id_exit = $('<td style="width: 4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                                    date_enter_shamsi = $('<td style="width: 11%">' + response.results[i]['date_enter_shamsi'] + '</td>')
                                    description = $('<td style="width: 35%">' + response.results[i]['description'] + '</td>')
                                    enter_driver = $('<td style="width: 13%">' + response.results[i]['enter_driver'] + '</td>')
                                    car_name_enter = $('<td style="width: 8%">' + response.results[i]['car_name_enter'] + '</td>')
                                    car_no_enter = $('<td hidden>' + response.results[i]['car_no_enter'] + '</td>')
                                    time_enter = $('<td style="width: 10%">' + response.results[i]['time_enter'] + '</td>')
                                    part100=$('<td style="width: 1%">'+response.results[i]['car_no_enter'].toString().substr(1,2)+'</td>')
                                    part200=$('<td style="width: 1%">'+response.results[i]['car_no_enter'].toString().substr(0,1)+'</td>')
                                    part300=$('<td style="width: 2%">'+response.results[i]['car_no_enter'].toString().substr(3,3)+'</td>')
                                    t1 = $('<td style="width: 15%"></td>')
                                    edit1 = $('<button type="button" class="btn-sm btn-primary edit1" style="font-family: Tahoma;font-size: smaller;text-align: right" data-toggle="modal" data-target="#myModal5">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                                    del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: right">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_exit'])
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 15%"></td>')
                                    row = $('<tr class="report_row"></tr>')
                                    t2.append(del2)
                                    row.append(id_exit, date_enter_shamsi, description, enter_driver, car_name_enter,part300,part200,part100,car_no_enter,time_enter, t2, t1)
                                    $("#report_table").append(row)
                                    $("#editlist").css("margin-top","100px");
                                    $('.edit1').on('click',function(){

                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                        $('#id_exit5').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description4').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#date_enter_shamsi4').val($(this).closest('tr').find('td:eq(1)').text());
                                        $('#time_enter4').val($(this).closest('tr').find('td:eq(9)').text());
                                        $('#enter_driver4').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#car_name_enter4').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#car_no_enter4').val($(this).closest('tr').find('td:eq(8)').text());
                                        var part1=$("#car_no_enter4").val().toString().substr(1,2)
                                        var part2=$("#car_no_enter4").val().toString().substr(0,1)
                                        var part3=$("#car_no_enter4").val().toString().substr(3,3)
                                        $("#no10").val($(this).closest('tr').find('td:eq(5)').text());
                                        $("#no11").val($(this).closest('tr').find('td:eq(6)').text());
                                        $("#no12").val($(this).closest('tr').find('td:eq(7)').text());



                                    })
                                    $('#' + response.results[i]['id_exit']).click(function () {
                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        $.ajax(
                                            {
                                                url: "/return4/" + id_exit,
                                                type: 'GET',
                                                data: {
                                                    "id": id_exit,
                                                    "_token": token,
                                                },
                                                success: function () {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی به کارتابل شخصی شما بازگشت داده شد")
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
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.info('اطلاعات مربوط به ورود قطعه یا کالا اصلاح شد');
                        $("#date_enter_shamsi_r4").val('');
                        $("#date_enter_shamsi4").val('');
                        $("#time_enter4").val('');
                        $("#enter_driver4").val('');
                        $("#car_name_enter4").val('');
                        $("#car_no_enter4").val('');
                        $('#myModal5').modal('toggle');
                    }
                });
            });
            $(".isclicked1").on('focus',function (event) {
                $('#ajax-alert1').hide();
                $('#ajax-alert2').hide();
                $('#ajax-alert3').hide();
            })
            $("#date_exit_shamsi2").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_enter_shamsi2").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_exit_shamsi3").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_enter_shamsi4").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#btnupdate").on('click',function(event){
                $("#car_no_exit2").val($("#no2").val()+$("#no3").val()+$("#no1").val());
            });
            $("#btnupdate3").on('click',function(event){
                $("#car_no_enter2").val($("#no5").val()+$("#no6").val()+$("#no4").val());
            });
            $("#btnupdate4").on('click',function(event){
                $("#car_no_exit3").val($("#no8").val()+$("#no9").val()+$("#no7").val());
            });
            $("#btnupdate5").on('click',function(event){
                $("#car_no_enter4").val($("#no11").val()+$("#no12").val()+$("#no10").val());
            });
            // $("#exit_driver2").on('change',function(event){
            //     if($("#exit_driver2").val()=='سعید سیفی'){
            //         $("#no1").val('883');
            //         $("#no2").val('ن');
            //         $("#no3").val('15');
            //         $("#car_name_exit2").val('پژو 405');
            //     }
            //     if($("#exit_driver2").val()=='فريدون مرادي نژاد'){
            //         $("#no1").val('817');
            //         $("#no2").val('ص');
            //         $("#no3").val('66');
            //         $("#car_name_exit2").val('سمند');
            //     }
            //     if($("#exit_driver2").val()=='عباس يدالهي'){
            //         $("#no1").val('535');
            //         $("#no2").val('ص');
            //         $("#no3").val('68');
            //         $("#car_name_exit2").val('وانت پیکان');
            //     }
            //     if($("#exit_driver2").val()=='مسلم انصاری'){
            //         $("#no1").val('747');
            //         $("#no2").val('ن');
            //         $("#no3").val('48');
            //         $("#car_name_exit2").val('سمند');
            //     }
            //     if($("#exit_driver2").val()=='علی برز جمشیدی'){
            //         $("#no1").val('911');
            //         $("#no2").val('ن');
            //         $("#no3").val('99');
            //         $("#car_name_exit2").val('وانت پیکان');
            //     }
            // });
            // $("#enter_driver2").on('change',function(event){
            //     if($("#enter_driver2").val()=='سعید سیفی'){
            //         $("#no4").val('883');
            //         $("#no5").val('ن');
            //         $("#no6").val('15');
            //         $("#car_name_enter2").val('پژو 405');
            //     }
            //     if($("#enter_driver2").val()=='فريدون مرادي نژاد'){
            //         $("#no4").val('817');
            //         $("#no5").val('ص');
            //         $("#no6").val('66');
            //         $("#car_name_enter2").val('سمند');
            //     }
            //     if($("#enter_driver2").val()=='عباس يدالهي'){
            //         $("#no4").val('535');
            //         $("#no5").val('ص');
            //         $("#no6").val('68');
            //         $("#car_name_enter2").val('وانت پیکان');
            //     }
            //     if($("#enter_driver2").val()=='مسلم انصاری'){
            //         $("#no4").val('747');
            //         $("#no5").val('ن');
            //         $("#no6").val('48');
            //         $("#car_name_enter2").val('سمند');
            //     }
            //     if($("#enter_driver2").val()=='علی برز جمشیدی'){
            //         $("#no4").val('911');
            //         $("#no5").val('ن');
            //         $("#no6").val('99');
            //         $("#car_name_enter2").val('وانت پیکان');
            //     }
            // });
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
    <!-- Edit form1 -->
        <div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم مربوط به قطعات خروجی</p></div>
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request1" action="{{route('editform.edit')}}">
                        {{csrf_field()}}
{{--                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>--}}
                        <input type="hidden" class="form-control" id="id_exit2"  name="id_exit">
{{--                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>--}}
                        <input type="hidden" class="form-control" id="id_herasat_exit2"  name="id_herasat_exit" value={{$user}}>
                        <input type="hidden" class="form-control" id="date_exit_shamsi_r2"  name="date_exit_shamsi_r">

                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ خروج:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت خروج:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="20" class="form-control" id="date_exit_shamsi2"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ خروج" name="date_exit_shamsi" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا تاریخ خروج را وارد کنید">
                                </div>
                            </div>
{{--                            <div class="col">--}}
{{--                                <div class="form-group" style="text-align: right">--}}
{{--                                    <input type="time" maxlength="10" class="form-control" id="time_exit2"  data-toggle="tooltip" data-placement="right" placeholder="ساعت خروج" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا ساعت خروج را وارد کنید">--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input maxlength="12" id="time_exit2" class="form-control" type="text" style="width: 50%;font-size: 12px;display: inline;text-align: center" class="time" name="time_exit" required placeholder="ساعت خروج"/>
                                    <button class="btn btn-success" id="setTimeButton2" style="font-family: Tahoma;font-size: 10px;text-align: right">ساعت فعلی</button>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 50%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">فرد خارج کننده قطعه:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px;text-align: right">
{{--                                    <input style="font-family: Tahoma;font-size: small;width: 90%;text-align: right;height: 35px" type="text" list="browsers" id="exit_driver2" placeholder="فرد خارج کننده قطعه:" name="exit_driver" required title="نام فرد خارج کننده قطعه وارد گردد" value=""/>--}}
{{--                                    <datalist id="browsers">--}}
{{--                                        <option value="سعید سیفی">سعید سیفی</option>--}}
{{--                                        <option value="عباس يدالهي">عباس يدالهي</option>--}}
{{--                                        <option value="فريدون مرادي نژاد">فريدون مرادي نژاد</option>--}}
{{--                                        <option value="مسلم انصاری">مسلم انصاری</option>--}}
{{--                                        <option value="علی برز جمشیدی">علی برز جمشیدی</option>--}}
{{--                                    </datalist>--}}
                                    <input type="text" maxlength="50" class="form-control" id="exit_driver2" data-toggle="tooltip" data-placement="right" placeholder="فرد خارج کننده قطعه:" name="exit_driver" style="direction:rtl;font-family:Tahoma;font-size:small" required title="نام فرد خارج کننده قطعه وارد گردد" value="" title="لطفا ساعت خروج را وارد کنید">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">نام خودرو:</p>
                            </div>
                            <div class="col" style="text-align: right">
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">شماره پلاک:</p>
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">مثال 532ب98</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="50" class="form-control" id="car_name_exit2" placeholder="نام خودرو:" name="car_name_exit" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no_exit2" placeholder="شماره پلاک خودرو:" name="car_no_exit" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="شماره پلاک خودرو وارد گردد">
                                    <input type="text" maxlength="3" class="form-control" id="no1" style="font-family:Tahoma;font-size:small;width: 70px;display: inline" required placeholder="532" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                    <input type="text" maxlength="1" class="form-control" id="no2" style="font-family:Tahoma;font-size:small;width: 55px;display: inline" required placeholder="ب" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                    <input type="text" maxlength="2" class="form-control" id="no3" style="font-family:Tahoma;font-size:small;width: 60px;display: inline" required placeholder="98" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                </div>
                            </div>
                        </div>

                        <div class="row"  style="height: 20px;margin-top:18px;visibility:hidden">
                            <div class="col-12">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">شماره جمعداری:</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col" style=";visibility:hidden">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no2" data-toggle="tooltip" data-placement="right" placeholder="شماره جمعداری:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ثبت اطلاعات</button>
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
    <!-- Edit form2 -->
        <div class="modal fade" id="myModal3" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top:150px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم مربوط به قطعات ورودی</p></div>
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request2" action="{{route('editform3.edit3')}}">
                        {{csrf_field()}}
                        {{--                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>--}}
                        <input type="hidden" class="form-control" id="id_exit3"  name="id_exit">
                        {{--                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>--}}
                        <input type="hidden" class="form-control" id="id_herasat_enter2"  name="id_herasat_enter" value={{$user}}>
                        <input type="hidden" class="form-control" id="date_enter_shamsi_r2"  name="date_enter_shamsi_r">

                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ ورود:</p></div>
{{--                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت ورود:</p></div>--}}
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="20" class="form-control" id="date_enter_shamsi2"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ ورود" name="date_enter_shamsi" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا تاریخ ورود را وارد کنید">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input maxlength="12" id="time_enter2" class="form-control" type="text" style="width: 50%;font-size: 12px;display: inline;text-align: center" class="time" name="time_enter" required placeholder="ساعت ورود" title="لطفا ساعت ورود را وارد کنید"/>
                                    <button class="btn btn-success" id="setTimeButton" style="font-family: Tahoma;font-size: 10px;text-align: right">ساعت فعلی</button>
                                </div>
                            </div>
{{--                            <div class="col">--}}
{{--                                <div class="form-group" style="text-align: right;width:100%">--}}
{{--                                    <button class="btn btn-primary" id="setTimeButton" style="font-family: Tahoma;font-size: 10px;text-align: right">ساعت فعلی</button>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 50%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">فرد وارد کننده قطعه:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px;text-align: right">
{{--                                    <input style="font-family: Tahoma;font-size: small;width: 90%;text-align: right;height: 35px" type="text" list="browsers" id="enter_driver2" placeholder="فرد وارد کننده قطعه:" name="enter_driver" required title="نام فرد وارد کننده قطعه وارد گردد" value=""/>--}}
{{--                                    <datalist id="browsers">--}}
{{--                                        <option value="سعید سیفی">سعید سیفی</option>--}}
{{--                                        <option value="عباس يدالهي">عباس يدالهي</option>--}}
{{--                                        <option value="فريدون مرادي نژاد">فريدون مرادي نژاد</option>--}}
{{--                                        <option value="مسلم انصاری">مسلم انصاری</option>--}}
{{--                                        <option value="علی برز جمشیدی">علی برز جمشیدی</option>--}}
{{--                                    </datalist>--}}
                                    <input type="text" maxlength="50" class="form-control" id="enter_driver2" data-toggle="tooltip" data-placement="right" placeholder="فرد وارد کننده قطعه:" name="enter_driver" style="direction:rtl;font-family:Tahoma;font-size:small" required title="نام فرد وارد کننده قطعه وارد گردد" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">نام خودرو:</p>
                            </div>
                            <div class="col" style="text-align: right">
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">شماره پلاک:</p>
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">مثال 532ب98</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="50" class="form-control" id="car_name_enter2" placeholder="نام خودرو:" name="car_name_enter" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no_enter2" placeholder="شماره پلاک خودرو:" name="car_no_enter" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px">
                                    <input type="text" maxlength="3" class="form-control" id="no4" style="font-family:Tahoma;font-size:small;width: 70px;display: inline" required placeholder="532" title="شماره پلاک خودرو بطور کامل وارد گردد">
                                    <input type="text" maxlength="1" class="form-control" id="no5" style="font-family:Tahoma;font-size:small;width: 55px;display: inline" required placeholder="ب" title="شماره پلاک خودرو بطور کامل وارد گردد">
                                    <input type="text" maxlength="2" class="form-control" id="no6" style="font-family:Tahoma;font-size:small;width: 60px;display: inline" required placeholder="98" title="شماره پلاک خودرو بطور کامل وارد گردد">
                                </div>
                            </div>
                        </div>

                        <div  class="row" style="margin-top: 10px;margin-right: 3px">
                            <div  class="form-group" style="text-align: right">
                                <label for="with_return" style="font-family: Tahoma;font-size: small;"> وضعیت ورود تجهیزات:</label>
                                <select class="form-control" name="iscomplete" id="iscomplete" style="width:100%;font-family: Tahoma;font-size: small;">
                                    <option value=1>کلیه موارد وارد شده</option>
                                    <option value=2>بخشی از قطعات وارد شده</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 0px">
                            <div class="col-10">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="150" class="form-control" id="description_detail4" data-toggle="tooltip" data-placement="right" placeholder="توضیحات:" name="description_detail" style="direction:rtl;font-family:Tahoma;font-size:small;width:100%;background-color: #7ecff4;color: white"  title="دراین بخش می توانید توضیحات لازم را وارد کنید" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col" style=";visibility:hidden">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no3" data-toggle="tooltip" data-placement="right" placeholder="شماره جمعداری:" name="jamdari_no" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btnupdate3" style="font-family: Tahoma;font-size: small;text-align: right">ثبت اطلاعات</button>
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
    <!-- Edit form3 -->
    <div class="modal fade mt-3" id="myModal4" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم مربوط به قطعات خروجی</p></div>
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request3" action="{{route('editform22.edit22')}}">
                        {{csrf_field()}}
                        {{--                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>--}}
                        <input type="hidden" class="form-control" id="id_exit4"  name="id_exit">
                        {{--                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>--}}
{{--                        <input type="hidden" class="form-control" id="id_herasat_exit3"  name="id_herasat_exit" value={{$user}}>--}}
                        <input type="hidden" class="form-control" id="date_exit_shamsi_r3"  name="date_exit_shamsi_r">

                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ خروج:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت خروج:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="20" class="form-control" id="date_exit_shamsi3"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ خروج" name="date_exit_shamsi" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا تاریخ خروج را وارد کنید">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input type="time" maxlength="10" class="form-control" id="time_exit3"  data-toggle="tooltip" data-placement="right" placeholder="ساعت خروج" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا ساعت خروج را وارد کنید">
                                </div>
                            </div>

                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 50%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">فرد خارج کننده قطعه:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="50" class="form-control" id="exit_driver3" data-toggle="tooltip" data-placement="right" placeholder="فرد خارج کننده قطعه:" name="exit_driver" style="direction:rtl;font-family:Tahoma;font-size:small" required title="نام فرد خارج کننده قطعه وارد گردد" value="">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">نام خودرو:</p>
                            </div>
                            <div class="col" style="text-align: right">
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">شماره پلاک:</p>
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">مثال 532ب98</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="50" class="form-control" id="car_name_exit3" placeholder="نام خودرو:" name="car_name_exit" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no_exit3" placeholder="شماره پلاک خودرو:" name="car_no_exit" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="شماره پلاک خودرو وارد گردد">
                                    <input type="text" maxlength="3" class="form-control" id="no7" style="font-family:Tahoma;font-size:small;width: 50px;display: inline" required placeholder="532" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                    <input type="text" maxlength="1" class="form-control" id="no8" style="font-family:Tahoma;font-size:small;width: 35px;display: inline" required placeholder="ب" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                    <input type="text" maxlength="2" class="form-control" id="no9" style="font-family:Tahoma;font-size:small;width: 40px;display: inline" required placeholder="98" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                </div>
                            </div>
                        </div>

                        <div class="row"  style="height: 20px;margin-top:18px;visibility:hidden">
                            <div class="col-12">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">شماره جمعداری:</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col" style=";visibility:hidden">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no2" data-toggle="tooltip" data-placement="right" placeholder="شماره جمعداری:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: right">ثبت اطلاعات</button>
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
    <!-- Edit form4 -->
    <div class="modal fade mt-3" id="myModal5" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 100px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم مربوط به قطعات ورودی</p></div>
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request4" action="{{route('editform33.edit33')}}">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" id="id_exit5"  name="id_exit4">
                        <input type="hidden" class="form-control" id="date_enter_shamsi_r4"  name="date_enter_shamsi_r4">
                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ ورود:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت ورود:</p></div>
                        </div>
                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="20" class="form-control" id="date_enter_shamsi4"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ ورود" name="date_enter_shamsi4" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا تاریخ ورود را وارد کنید">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input type="time" maxlength="10" class="form-control" id="time_enter4"  data-toggle="tooltip" data-placement="right" placeholder="ساعت ورود" name="time_enter4" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا ساعت ورود را وارد کنید">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 10px;margin-top: 25px;width: 50%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">فرد وارد کننده قطعه:</p></div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="50" class="form-control" id="enter_driver4" data-toggle="tooltip" data-placement="right" placeholder="فرد وارد کننده قطعه:" name="enter_driver4" style="direction:rtl;font-family:Tahoma;font-size:small" required title="نام فرد وارد کننده قطعه وارد گردد" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">نام خودرو:</p>
                            </div>
                            <div class="col" style="text-align: right">
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">شماره پلاک:</p>
                                <p style="text-align: right;font-family: Tahoma;font-size: small;display: inline">مثال 532ب98</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="50" class="form-control" id="car_name_enter4" placeholder="نام خودرو:" name="car_name_enter4" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no_enter4" placeholder="شماره پلاک خودرو:" name="car_no_enter4" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="شماره پلاک خودرو وارد گردد">
                                    <input type="text" maxlength="3" class="form-control" id="no10" style="font-family:Tahoma;font-size:small;width: 50px;display: inline" required placeholder="532" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                    <input type="text" maxlength="1" class="form-control" id="no11" style="font-family:Tahoma;font-size:small;width: 35px;display: inline" required placeholder="ب" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                    <input type="text" maxlength="2" class="form-control" id="no12" style="font-family:Tahoma;font-size:small;width: 40px;display: inline" required placeholder="98" title="لطفا شماره پلاک خودرو بطور کامل وارد شود">
                                </div>
                            </div>
                        </div>
                        <div  class="row" style="margin-top: 10px;margin-right: 3px">
                            <div  class="form-group" style="text-align: right">
                                <label for="with_return" style="font-family: Tahoma;font-size: small;"> وضعیت ورود تجهیزات:</label>
                                <select class="form-control" name="iscomplete4" id="iscomplete4" style="width:100%;font-family: Tahoma;font-size: small;">
                                    <option value=1>کلیه موارد وارد شده</option>
                                    <option value=2>بخشی از قطعات وارد شده</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 0px">
                            <div class="col-10">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="150" class="form-control" id="description_detail" data-toggle="tooltip" data-placement="right" placeholder="توضیحات:" name="description_detail4" style="direction:rtl;font-family:Tahoma;font-size:small;width:100%;background-color: #7ecff4;color: white"  title="دراین بخش می توانید توضیحات لازم را وارد کنید" value="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style=";visibility:hidden">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no2" data-toggle="tooltip" data-placement="right" placeholder="شماره جمعداری:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col mt-2">
                                <button type="submit" class="btn btn-primary" id="btnupdate5" style="font-family: Tahoma;font-size: small;text-align: right">ثبت اطلاعات</button>
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
    <!-- Title of report -->
    <div class="row mylist2" style="margin: auto;width:100%;display: none;margin-top: 10px">
        <div class="col-12" id="title_report" style="height: 35px;margin-top: 10px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color:rgb(14,53,126)"></div>
    </div>
    <!-- content of report -->
    <div class="row mylist2" style="margin: auto;width:100%;height:302px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
        <div class="col-12" style="direction: rtl;height: 300px;overflow-y: scroll;">
            <table id="report_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
        </div>
        <div class="toast bg-info" style="margin-top:20px;margin: auto;border-radius: 10px">
            <div class="toast-body"><p id="mytoast" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
        </div>
    </div>
    <div class="modal fade mt-3" id="myModal10" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">گردش درخواست</p></div>
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

                <!-- List -->
                <div class="container"  style="margin: auto;background-color:#c4e6f5;width: 850px ;height: 400px;;overflow-y: scroll">
                    <table class="table table-striped" id="workflow" style="width: 800px">
                        {{--                        <thead>--}}
                        {{--                        <tr style="background-color: darkslateblue;color: #f9f9f9;font-family: Tahoma;font-size: small">--}}
                        {{--                            <th>لیست گردش درخواست</th>--}}
                        {{--                        </tr>--}}
                        {{--                        </thead>--}}
                        {{--                        <tbody></tbody>--}}
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>


@endsection
