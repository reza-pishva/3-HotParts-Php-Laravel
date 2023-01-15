@extends('layouts.app_requester')
@section('content')
    <script>
        $(document).ready(function(){
            bootstrap.Toast.Default.delay = 2000
            $('#first_report').click(function(event) {
                event.preventDefault();
                $("#report_table").removeClass("table table-dark table-hover")
                $.ajax({
                    url: '/not-confirmed',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد ارسالی برای سرپرست مستقیم که هنوز مورد بررسی قرار نگرفته است</p>')
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
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;font-size: 8px">شماره درخواست</td><td style="border-left:1px white solid;font-size: 8px">تاریخ درخواست</td><td style="border-left:1px white solid;font-size: 8px">شرح درخواست</td><td style="border-left:1px white solid;font-size: 8px">تعداد موارد</td><td style="border-left:1px white solid;font-size: 8px">شماره جمعداری</td><td style="border-left:1px white solid;font-size: 8px">نوع قطعه</td><td style="border-left:1px white solid;font-size: 8px">نوع درخواست</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 6%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width:9%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="text-align: right;width: 35%;padding-right: 10px">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 8%;font-size: 8px">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width: 12%">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            if(response.results[i]['enter_exit']==1){
                                with_return = $('<td style="width: 5%" >' +'خروج'+'</td>')
                            }
                            if(response.results[i]['enter_exit']==2){
                                with_return = $('<td style="width: 5%">' +'ورود'+'</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width: 10%">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return, t2, t1,origin_destination,id_goods_type,with_return_value)
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
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                        url: "/exit-delete/" + id_exit,
                                        type: 'DELETE',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('#ajax-alert1').hide();
                                            $('#ajax-alert2').hide();
                                            $('#ajax-alert3').hide();
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
                                            toastr.error('این درخواست از این فرم حذف گردید');
                                        }
                                    });
                                $('#' + id_exit).closest('tr').remove();
                            })

                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }
                })
            })
            $('#second_report').click(function(event) {
                $("#report_table").removeClass("table table-dark table-hover")
                event.preventDefault();
                $.ajax({
                    url: '/total-sent',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد در جریان</p>')
                        var id_exit = ''
                        var date_request_shamsi = ''
                        var description = ''
                        var exit_no = ''
                        var jamdari_no = ''
                        var goods_type_value = ''
                        var id_goods_type = ''
                        var with_return = ''
                        var t1 = ''
                        var history = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">شرح درخواست</td><td style="border-left:1px white solid;">تعداد موارد</td><td style="border-left:1px white solid;">شماره جمعداری</td><td style="border-left:1px white solid;">نوع قطعه</td><td style="border-left:1px white solid;">نوع درخواست</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 5%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 7%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            description = $('<td style="width: 50%;text-align: right">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 5%">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width: 5%">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            if(response.results[i]['enter_exit']==1){
                                with_return = $('<td >' +'خروج'+'</td>')
                            }
                            if(response.results[i]['enter_exit']==2){
                                with_return = $('<td >' +'ورود'+'</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width: 5%">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            t1 = $('<td style="width:20%"></td>')
                            history = $('<button type="button" class="btn-sm btn-primary history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">گردش درخواست</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            t1.append(history)
                            row = $('<tr class="report_row"></tr>')
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,t1)
                            $("#report_table").append(row)
                            $("#report_table").addClass("table table-hover")
                            $("#editlist").css("margin-top","100px");
                        }
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
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#third_report').click(function(event) {
                $("#report_table").removeClass("table table-dark table-hover")
                event.preventDefault();
                $.ajax({
                    url: '/not-confirmed-boss',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که مسئول قسمت تایید نکرده</p>')
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
                        var reasons=''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var reason1 = ''
                        var t2 = ''
                        var t3 = $('<td></td>')
                        var send_again = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">شرح درخواست</td><td style="border-left:1px white solid;">علت عدم تایید</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 31%;text-align: right;">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td hidden>' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            if(response.results[i]['enter_exit']==1){
                                with_return = $('<td hidden>' +'خروج'+'</td>')
                            }
                            if(response.results[i]['enter_exit']==2){
                                with_return = $('<td hidden>' +'ورود'+'</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td hidden>' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            reason1=$('<td style="width: 18%">' + response.results[i]['reason1'] + '</td>')
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td style="width: 5%"></td>')
                            edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center" data-toggle="modal" data-target="#myModal3">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 2000)
                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center">حذف</button>').attr('id',  response.results[i]['id_exit']+3000)
                            send_again = $('<button type="button" class="btn-sm btn-success send_again" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">ارسال مجدد</button>').attr('id',  response.results[i]['id_exit']+4000)
                            reasons = $('<button type="button" class="btn-sm btn-success history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">دلایل عدم تایید</button>').attr('id',  response.results[i]['id_exit']+5000)
                            t1.append(edit1)
                            t2 = $('<td style="width: 5%"></td>')
                            t2.append(del2)
                            t3 = $('<td style="width: 10%"></td>')
                            t3.append(send_again)
                            t4 = $('<td style="width: 14%"></td>')
                            t4.append(reasons)
                            row = $('<tr class="report_row"></tr>')

                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,origin_destination,id_goods_type,with_return_value,reason1,t4, t2, t1,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + (response.results[i]['id_exit']+2000)).on('click',function(){
                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert4').hide();

                                $('#id_exit3').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#description3').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#exit_no3').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#jamdari_no3').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#id_goods_type3').val($(this).closest('tr').find('td:eq(8)').text());
                                $('#with_return3').val($(this).closest('tr').find('td:eq(9)').text());
                                $('#origin_destination3').val($(this).closest('tr').find('td:eq(7)').text());//true
                            })
                            $('#' + (response.results[i]['id_exit']+3000)).click(function () {
                                var id=$(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/exit-delete/" + id,
                                    type: 'DELETE',
                                    data: {
                                        "id": id,
                                        "_token": token,
                                    },
                                    success: function (data) {
                                        var id2=0;
                                        $('#' + (Number(data.data)+3000)).closest('tr').remove();
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
                                        toastr.error('این درخواست از این فرم حذف گردید');
                                        // $('#ajax-alert1').addClass('alert-danger').show(function () {
                                        //     $(this).html("این آیتم با موفقیت از فرم درخواست جاری حذف گردید");
                                        // });
                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                    }
                                });
                            })
                            $('.send_again').click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/sendagain/" + id_exit,
                                        type: 'GET',
                                        data: {
                                            "id": id_exit,
                                            "_token": token,
                                        },
                                        success: function (response) {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا برای مسئول قسمت فرستاده شد")
                                        }
                                    });
                                $(this).closest('tr').remove()
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
                                    url: '/workflow2/'+id_exit,
                                    method:'GET',
                                    success: function (response) {
                                        $('#myModal4').modal('show');
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
                    }})
            })
            $('#fourth_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/returned',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که مجوز ورود یا خروج گرفته اند</p>')
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
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">شرح درخواست</td><td style="border-left:1px white solid;">تعداد موارد</td><td style="border-left:1px white solid;">شماره جمعداری</td><td style="border-left:1px white solid;">نوع قطعه</td></tr>'
                        var row_div=$('<div></div>')
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="width: 10%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="width: 10%">' + response.results[i]['date_request_shamsi'] + '</td>')
                            origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                            description = $('<td style="width: 50%;text-align: right">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="width: 5%">' + response.results[i]['exit_no'] + '</td>')
                            jamdari_no = $('<td style="width: 15%">' + response.results[i]['jamdari_no'] + '</td>')
                            id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                            if(response.results[i]['enter_exit']==1){
                                with_return = $('<td >' +'خروج'+'</td>')
                            }
                            if(response.results[i]['enter_exit']==2){
                                with_return = $('<td >' +'ورود'+'</td>')
                            }
                            for(var j = 0; j < response.goodstypes.length; j++) {
                                if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                    goods_type_value=$('<td style="width: 10%">' + response.goodstypes[j]['description'] + '</td>');
                                    break;
                                }
                            }
                            with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                            t1 = $('<td></td>')
                            edit1 = $('<button hidden type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: small;text-align: right" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            del2 = $('<button  hidden type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: right">حذف</button>').attr('id',  response.results[i]['id_exit'])
                            t1.append(edit1)
                            t2 = $('<td></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value)
                            row_div.append(row);
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


                                $('tr').find('td:eq(2)').removeClass('description');//true
                                $('tr').find('td:eq(3)').removeClass('exit_no');//true
                                $('tr').find('td:eq(4)').removeClass('jamdari_no');//true
                                $('tr').find('td:eq(5)').removeClass('goods_type');
                                $('tr').find('td:eq(6)').removeClass('with_return');
                                $('tr').find('td:eq(9)').removeClass('origin_destination');//true
                                $('tr').find('td:eq(10)').removeClass('goods_type_value');//true
                                $('tr').find('td:eq(11)').removeClass('with_return_text');

                                $(this).closest('tr').find('td:eq(2)').addClass('description');//true
                                $(this).closest('tr').find('td:eq(3)').addClass('exit_no');//true
                                $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');//true
                                $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                                $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                                $(this).closest('tr').find('td:eq(9)').addClass('origin_destination');//true
                                $(this).closest('tr').find('td:eq(10)').addClass('goods_type_value');//true
                                $(this).closest('tr').find('td:eq(11)').addClass('with_return_text');
                            })
                            $('#' + response.results[i]['id_exit']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                if (confirm("آیا شما از حذف این درخواست مطمئن هستید؟")) {

                                    $.ajax(
                                        {
                                            url: "/exit-delete/" + id_exit,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_exit,
                                                "_token": token,
                                            },
                                            success: function () {
                                                $('#ajax-alert1').addClass('alert-danger').show(function () {
                                                    $(this).html("این آیتم با موفقیت از فرم درخواست جاری حذف گردید");
                                                });
                                                $('#ajax-alert2').hide();
                                                $('#ajax-alert3').hide();
                                            }
                                        });
                                }
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $("#edit_form_request").on('submit',function(event) {
                var with_return=''
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editform",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $("#report_table").removeClass("table table-dark table-hover")
                        $.ajax({
                            url: '/not-confirmed',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد ارسالی برای سرپرست مستقیم که هنوز مورد بررسی قرار نگرفته است</p>')
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
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;font-size: 8px">شماره درخواست</td><td style="border-left:1px white solid;font-size: 8px">تاریخ درخواست</td><td style="border-left:1px white solid;font-size: 8px">شرح درخواست</td><td style="border-left:1px white solid;font-size: 8px">تعداد موارد</td><td style="border-left:1px white solid;font-size: 8px">شماره جمعداری</td><td style="border-left:1px white solid;font-size: 8px">نوع قطعه</td><td style="border-left:1px white solid;font-size: 8px">نوع درخواست</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                                $("#report_table").append(row_th)
                                for(var i = 0; i < response.results.length; i++) {
                                    id_exit = $('<td style="width: 6%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                                    date_request_shamsi = $('<td style="width:9%">' + response.results[i]['date_request_shamsi'] + '</td>')
                                    origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                                    description = $('<td style="text-align: right;width: 35%;padding-right: 10px">' + response.results[i]['description'] + '</td>')
                                    exit_no = $('<td style="width: 8%;font-size: 8px">' + response.results[i]['exit_no'] + '</td>')
                                    jamdari_no = $('<td style="width: 12%">' + response.results[i]['jamdari_no'] + '</td>')
                                    id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                                    if(response.results[i]['enter_exit']==1){
                                        with_return = $('<td style="width: 5%" >' +'خروج'+'</td>')
                                    }
                                    if(response.results[i]['enter_exit']==2){
                                        with_return = $('<td style="width: 5%">' +'ورود'+'</td>')
                                    }
                                    for(var j = 0; j < response.goodstypes.length; j++) {
                                        if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                            goods_type_value=$('<td style="width: 10%">' + response.goodstypes[j]['description'] + '</td>');
                                            break;
                                        }
                                    }
                                    with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                                    t1 = $('<td></td>')
                                    edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                                    del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',  response.results[i]['id_exit'])
                                    t1.append(edit1)
                                    t2 = $('<td></td>')
                                    row = $('<tr class="report_row"></tr>')
                                    t2.append(del2)
                                    row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return, t2, t1,origin_destination,id_goods_type,with_return_value)
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
                                    $('#' + response.results[i]['id_exit']).click(function () {
                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        $.ajax({
                                            url: "/exit-delete/" + id_exit,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_exit,
                                                "_token": token,
                                            },
                                            success: function () {
                                                $('#ajax-alert1').hide();
                                                $('#ajax-alert2').hide();
                                                $('#ajax-alert3').hide();
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
                                                toastr.error('این درخواست از این فرم حذف گردید');
                                            }
                                        });
                                        $('#' + id_exit).closest('tr').remove();
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
                                toastr.info('اطلاعات مربوط به این درخواست تغییر داده شد');
                    }
                });
            });
            $("#edit_form_request3").on('submit',function(event) {
                var with_return=''
                event.preventDefault();
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editformm",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $("#report_table").removeClass("table table-dark table-hover")
                        event.preventDefault();
                        $.ajax({
                            url: '/not-confirmed-boss',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که مسئول قسمت تایید نکرده</p>')
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
                                var reasons=''
                                var t1 = ''
                                var edit1 = ''
                                var del2 = ''
                                var reason1 = ''
                                var t2 = ''
                                var t3 = $('<td></td>')
                                var send_again = ''
                                var row = ''
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">شرح درخواست</td><td style="border-left:1px white solid;">علت عدم تایید</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                                $("#report_table").append(row_th)
                                for(var i = 0; i < response.results.length; i++) {
                                    id_exit = $('<td style="width: 4%" class="id_exit">' + response.results[i]['id_exit'] + '</td>')
                                    date_request_shamsi = $('<td style="width: 10%">' + response.results[i]['date_request_shamsi'] + '</td>')
                                    origin_destination = $('<td hidden>' +response.results[i]['origin_destination'] + '</td>')
                                    description = $('<td style="width: 31%;text-align: right;">' + response.results[i]['description'] + '</td>')
                                    exit_no = $('<td hidden>' + response.results[i]['exit_no'] + '</td>')
                                    jamdari_no = $('<td hidden>' + response.results[i]['jamdari_no'] + '</td>')
                                    id_goods_type = $('<td hidden>' + response.results[i]['id_goods_type'] + '</td>')
                                    if(response.results[i]['enter_exit']==1){
                                        with_return = $('<td hidden>' +'خروج'+'</td>')
                                    }
                                    if(response.results[i]['enter_exit']==2){
                                        with_return = $('<td hidden>' +'ورود'+'</td>')
                                    }
                                    for(var j = 0; j < response.goodstypes.length; j++) {
                                        if(response.goodstypes[j]['id_goods_type']==response.results[i]['id_goods_type']){
                                            goods_type_value=$('<td hidden>' + response.goodstypes[j]['description'] + '</td>');
                                            break;
                                        }
                                    }
                                    reason1=$('<td style="width: 18%">' + response.results[i]['reason1'] + '</td>')
                                    with_return_value = $('<td hidden>' + response.results[i]['with_return'] + '</td>')
                                    t1 = $('<td style="width: 5%"></td>')
                                    edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center" data-toggle="modal" data-target="#myModal3">ویرایش</button>').attr('id',  response.results[i]['id_exit'] + 2000)
                                    del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center">حذف</button>').attr('id',  response.results[i]['id_exit']+3000)
                                    send_again = $('<button type="button" class="btn-sm btn-success send_again" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">ارسال مجدد</button>').attr('id',  response.results[i]['id_exit']+4000)
                                    reasons = $('<button type="button" class="btn-sm btn-success history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">دلایل عدم تایید</button>').attr('id',  response.results[i]['id_exit']+5000)
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 5%"></td>')
                                    t2.append(del2)
                                    t3 = $('<td style="width: 10%"></td>')
                                    t3.append(send_again)
                                    t4 = $('<td style="width: 14%"></td>')
                                    t4.append(reasons)
                                    row = $('<tr class="report_row"></tr>')

                                    row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, goods_type_value, with_return,origin_destination,id_goods_type,with_return_value,reason1,t4, t2, t1,t3)
                                    $("#report_table").append(row)
                                    $("#editlist").css("margin-top","100px");
                                    $('#' + (response.results[i]['id_exit']+2000)).on('click',function(){
                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert4').hide();

                                        $('#id_exit3').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#description3').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#exit_no3').val($(this).closest('tr').find('td:eq(3)').text());
                                        $('#jamdari_no3').val($(this).closest('tr').find('td:eq(4)').text());
                                        $('#id_goods_type3').val($(this).closest('tr').find('td:eq(8)').text());
                                        $('#with_return3').val($(this).closest('tr').find('td:eq(9)').text());
                                        $('#origin_destination3').val($(this).closest('tr').find('td:eq(7)').text());//true
                                    })
                                    $('#' + (response.results[i]['id_exit']+3000)).click(function () {
                                        var id=$(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        $.ajax({
                                            url: "/exit-delete/" + id,
                                            type: 'DELETE',
                                            data: {
                                                "id": id,
                                                "_token": token,
                                            },
                                            success: function (data) {
                                                var id2=0;
                                                $('#' + (Number(data.data)+3000)).closest('tr').remove();
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
                                                toastr.error('این درخواست از این فرم حذف گردید');
                                                // $('#ajax-alert1').addClass('alert-danger').show(function () {
                                                //     $(this).html("این آیتم با موفقیت از فرم درخواست جاری حذف گردید");
                                                // });
                                                $('#ajax-alert1').hide();
                                                $('#ajax-alert2').hide();
                                                $('#ajax-alert3').hide();

                                            }
                                        });
                                    })
                                    $('.send_again').click(function () {
                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        $.ajax(
                                            {
                                                url: "/sendagain/" + id_exit,
                                                type: 'GET',
                                                data: {
                                                    "id": id_exit,
                                                    "_token": token,
                                                },
                                                success: function (response) {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی مجددا برای مسئول قسمت فرستاده شد")
                                                }
                                            });
                                        $(this).closest('tr').remove()
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
                                            url: '/workflow2/'+id_exit,
                                            method:'GET',
                                            success: function (response) {
                                                $('#myModal4').modal('show');
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
                            }})
                    }
                });
            });
            $(".isclicked1").on('focus',function (event) {
                $('#ajax-alert1').hide();
                $('#ajax-alert2').hide();
                $('#ajax-alert3').hide();
            })
        });
    </script>
        <div class="row mylist" style="margin: auto;width:100%;display: none">
            <div class="col-12 bg-info" style="height: 35px;margin-top: 30px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right"><p id="title" style="margin-top: 7px;"></p></div>
        </div>
    <!-- List of content -->
        <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request" action="{{route('editform.edit')}}">
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
                                    <input type="text" maxlength="30" class="form-control" id="origin_destination2"  data-toggle="tooltip" data-placement="right" placeholder="مقصد قطعه:" name="origin_destination2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا مبدا یا مقصد این قطعه را وارد کنید">
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
                                    <input type="text" maxlength="50" class="form-control" id="description2" data-toggle="tooltip" data-placement="right" placeholder="شرح کالا یا قطعه:" name="description2" style="direction:rtl;font-family:Tahoma;font-size:small" required title="شرح کالا و یا قطعه مورد نظر برای ورود یا خروج از نیروگاه">
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
                                    <input type="text" class="form-control isclicked1" id="exit_no2" data-toggle="tooltip" data-placement="right" placeholder="تعداد موارد:" name="exit_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width:110px;display: inline" required title="تعداد مواردی که باید وارد یا خارج از نیروگاه شوند">
{{--                                    <select hidden class="form-control isclicked1" name="unit2" id="unit2" style="width:95px;font-family: Tahoma;font-size: small;display: inline">--}}
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
                                <div class="form-group" style="text-align: right" id="with_return_edit">
                                    <select class="form-control" name="with_return2" id="with_return2" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
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
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no2" data-toggle="tooltip" data-placement="right" placeholder="شماره سریال یا جمعداری:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
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
    <!-- Edit form2 -->
        <div class="modal fade" id="myModal3" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request3" action="{{route('editform.edit')}}">
                        {{csrf_field()}}
                        {{--                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>--}}
                        <input type="hidden" class="form-control" id="id_exit3"  name="id_exit2">
                        {{--                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>--}}
                        <input type="hidden" class="form-control" id="date_request_shamsi3"  name="date_request_shamsi" value={{$date_shamsi}}>
                        <input type="hidden" class="form-control" id="date_request_miladi3"  name="date_request_miladi" value={{$mytime}}>
                        <input type="hidden" class="form-control" id="time_request3"  name="time_request" value={{$mytime->toTimeString()}}>
                        <input type="hidden" class="form-control" id="request_timestamp3"  name="request_timestamp" value={{$mytime->timestamp}}>
                        <input type="hidden" class="form-control" id="id_requester3" placeholder="Enter the id of requester" name="id_requester" value={{$user}}>
                        <input type="hidden" class="form-control" id="id_request_part3" name="id_request_part" value={{$part}}>
                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">مقصد:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نوع قطعه:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="30" class="form-control" id="origin_destination3"  data-toggle="tooltip" data-placement="right" placeholder="مقصد قطعه:" name="origin_destination2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا مبدا یا مقصد این قطعه را وارد کنید">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <select class="form-control" name="id_goods_type2" id="id_goods_type3" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
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
                                    <input type="text" maxlength="50" class="form-control" id="description3" data-toggle="tooltip" data-placement="right" placeholder="شرح کالا یا قطعه:" name="description2" style="direction:rtl;font-family:Tahoma;font-size:small" required title="شرح کالا و یا قطعه مورد نظر برای ورود یا خروج از نیروگاه">
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
                                <div class="form-group">
                                    <input type="text"  class="form-control isclicked1" id="exit_no3" data-toggle="tooltip" data-placement="right" placeholder="تعداد موارد:" name="exit_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width:110px;display: inline" required title="تعداد مواردی که باید وارد یا خارج از نیروگاه شوند">
{{--                                    <select hidden class="form-control isclicked1" name="unit2" id="unit3" style="width:95px;font-family: Tahoma;font-size: small;display: inline">--}}
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
                                <div class="form-group" style="text-align: right">
                                    <select class="form-control" name="with_return2" id="with_return3" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                        <option value=1>بله</option>
                                        <option value=2>خیر</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 20px;margin-top:18px">
                            <div class="col-12">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">شماره جمعداری یا شماره سریال:</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no3" data-toggle="tooltip" data-placement="right" placeholder="شماره جمعداری و شماره سریال:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">اعمال تغییرات</button>
                            </div>
                        </div>
                        <div id="ajax-alert4" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
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
    <div class="modal fade mt-3" id="myModal4" style="direction: rtl;">
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
