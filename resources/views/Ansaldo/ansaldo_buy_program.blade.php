@extends('layouts.ansaldo_layouts.app_buy_program')
@section('content')
    <script>
        $(document).ready(function() {
            function toFarsiNumber(n) {
                const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

                return n
                    .toString()
                    .split('')
                    .map(x => farsiDigits[x])
                    .join('');
            }
            bootstrap.Toast.Default.delay = 2000
            $("#DATE_BEGIN1").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_BEGINR").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_ENDR").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_SHAMSI").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_BEGIN1_EDIT").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_SHAMSI_EDIT").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#add_send").on('click',function (event) {
                $('#myModal1').modal('show');
            })
            $("#add_recieve").on('click',function (event) {
                $('#myModal2').modal('show');
            })
            $("#DATE_BEGIN1").prop('readonly', true)
            $("#DATE_BEGINR").prop('readonly', true)
            $("#DATE_ENDR").prop('readonly', true)
            $("#DATE_SHAMSI").prop('readonly', true)
            $("#DATE_BEGIN1_EDIT").prop('readonly', true)
            $("#DATE_SHAMSI_EDIT").prop('readonly', true)
            $("#DATE_BEGIN1").prop('readonly', true)
            $("#buy_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/buy-store",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        $('#ID_T').val('')
                        $('#ID_TG').val('')
                        $('#ID_SE').val('')
                        $('#GROUP_COUNT').val('')
                        $('#SHOMAREH_GHARAR').val('')
                        $('#DISCRIPTION').val('')
                        $("#BUY_CONDITION").val('');
                        $("#RESV").val('');
                        $('#myModal1').modal('hide');
                        toastr.success("برنامه خرید جدید با موفقیت ذخیره گردید", "", {
                            "timeOut": "5000",
                            "extendedTImeout": "0"
                        });
                        $.ajax({
                            url: '/buy-onlyone',
                            method:'GET',
                            success: function (response) {
                                if(response.results.length>0){

                                    $("#add_recieve").hide();
                                    $("#description2").text('');
                                    $("#ID_T_SUB2").text('');
                                    $("#table2").empty();
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var select = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var ID_TG = ''
                                    var ID_TG2 = ''
                                    var ID_SE = ''
                                    var ID_SE2 = ''
                                    var GROUP_COUNT=''
                                    var DATE_SHAMSI = ''
                                    var DISCRIPTION = ''
                                    var SHOMAREH_GHARAR = ''
                                    var BUY_CONDITION = ''
                                    var BUY_CONDITION2 = ''
                                    var RESV = ''
                                    var RESV2 = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">فروشنده</td><td style="text-align: center">تاریخ خرید</td><td style="text-align: center">تعداد قطعات</td><td style="text-align: center">شماره قرارداد</td><td style="text-align: center">وضعیت خرید</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table1").empty();
                                    $("#table1").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_TGS.length; j++) {
                                            if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                                ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                                ID_TG2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var j = 0; j < response.ID_SES.length; j++) {
                                            if (response.ID_SES[j]['ID_SE'] == response.results[i]['ID_SE']) {
                                                ID_SE = $('<td style="width: 25%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_SES[j]['SELLER'] + '</td>');
                                                ID_SE2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_SES[j]['ID_SE'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var z = 0; z < response.ID_USERS.length; z++) {
                                            if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                                ID_USER = $('<td hidden>' + response.ID_USERS[z]['l_name'] + '</td>')
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click',function () {
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                            $('#ID_SE_EDIT').val($(this).closest('tr').find('td:eq(10)').text())
                                            $('#SHOMAREH_GHARAR_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#BUY_CONDITION_EDIT').val($(this).closest('tr').find('td:eq(13)').text())
                                            $('#RESV_EDIT').val($(this).closest('tr').find('td:eq(12)').text())
                                            $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#DATE_SHAMSI_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click',function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");

                                            Swal.fire({
                                                title: 'مایل به حذف این برنامه خرید هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {

                                                    Swal.fire('برنامه خرید حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/buy-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {

                                                            if(response.perm==1){
                                                                $('#' + (Number(id_t) + 2000).toString()).closest('tr').remove();
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
                                                                toastr.error('برنامه خرید حذف گردید');
                                                                $('#' + (Number(id_t) + 2000).toString()).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }else{
                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                            }
                                                        }
                                                    });

                                                }
                                            })

                                        })
                                        detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">سابقه</button></td>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-buy-prog/' + id_t,
                                                method: 'GET',
                                                success: function (response) {
                                                    var ID_S = ''
                                                    var ID_T = ''
                                                    var TIME_WORK = ''
                                                    var DAMAGE_PERCENT = ''
                                                    var DESCRIPTION = ''
                                                    var SERIYAL_NUMBER = ''
                                                    var TYPE_INSTAL = ''
                                                    var row = ''
                                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>کدسابقه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                                    $("#table_history").empty();
                                                    $("#table_history").append(th)
                                                    for (var i = 0; i < response.results.length; i++) {
                                                        ID_S = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                                        ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                                        TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                                        DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                                        TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                                        if(response.results[i]['DISCRIPTION']!= null){
                                                            DESCRIPTION = $('<td style="width:35%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                                        }else{
                                                            DESCRIPTION = $('<td style="width:35%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                                        }

                                                        SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                        row = $('<tr class="table3"></tr>')
                                                        row.append(SERIYAL_NUMBER,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                                        $("#table_history").append(row)
                                                    }
                                                }
                                            })
                                        })
                                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $('#description2').text($(this).closest('tr').find('td:eq(7)').text())
                                            var id_t=$(this).closest('tr').find('td:eq(1)').text()
                                            $("tr.table1").css("background-color", "white");
                                            $("tr.table1").css("color", "black");
                                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                            $(this).closest('tr.table1').css("color", "white");
                                        })

                                        ID_T = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                        SHOMAREH_GHARAR = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['SHOMAREH_GHARAR'] + '</td>')
                                        BUY_CONDITION2 = $('<td hidden style="text-align: center;font-size: x-small">' + response.results[i]['BUY_CONDITION'] + '</td>')
                                        if (response.results[i]['BUY_CONDITION'] == 1) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">یک</td>')
                                        }
                                        if (response.results[i]['BUY_CONDITION'] == 2) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">دو</td>')
                                        }
                                        if (response.results[i]['BUY_CONDITION'] == 3) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">سه</td>')
                                        }
                                        if (response.results[i]['BUY_CONDITION'] == 4) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">چهار</td>')
                                        }
                                        // BUY_CONDITION = $('<td style="width: 23%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['BUY_CONDITION'] + '</td>')
                                        GROUP_COUNT = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                        RESV2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['RESV'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        if (response.results[i]['RESV'] == 1) {
                                            RESV = $('<td style="width: 10%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if (response.results[i]['RESV'] == 2) {
                                            RESV = $('<td style="width: 10%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                        DATE_SHAMSI = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')

                                        t1 = $('<td style="width: 5%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 5%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 5%"></td>')
                                        t3.append(select)
                                        t4 = $('<td style="width: 30%"></td>')
                                        t4.append(detail1)
                                        row = $('<tr class="table1"></tr>')
                                        row.append(t3,ID_T,ID_TG,ID_SE, DATE_SHAMSI,GROUP_COUNT,SHOMAREH_GHARAR,DISCRIPTION,BUY_CONDITION,ID_TG2,ID_SE2,RESV,RESV2,BUY_CONDITION2,t1, t2,t4)
                                        $("#table1").append(row)
                                    }
                                }

                            }
                        })
                    }

                });
            })
            $("#tpsrep_form").on('submit', function (event) {
                 event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/buy-rep",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                    if(response.results.length>0){
                        toastr.info('اطلاعات درخواستی دریافت شد');
                        $("#add_recieve").hide();
                        $("#description2").text('');
                        $("#ID_T_SUB2").text('');
                        $("#table2").empty();
                        var day = ''
                        var month = ''
                        var year = ''
                        var edit1 = ''
                        var del2 = ''
                        var detail1 = ''
                        var select = ''
                        var ID_T = ''
                        var ID_USER = ''
                        var ID_TG = ''
                        var ID_TG2 = ''
                        var ID_SE = ''
                        var ID_SE2 = ''
                        var GROUP_COUNT=''
                        var DATE_SHAMSI = ''
                        var DISCRIPTION = ''
                        var SHOMAREH_GHARAR = ''
                        var BUY_CONDITION = ''
                        var BUY_CONDITION2 = ''
                        var RESV = ''
                        var RESV2 = ''
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">فروشنده</td><td style="text-align: center">تاریخ خرید</td><td style="text-align: center">تعداد قطعات</td><td style="text-align: center">شماره قرارداد</td><td style="text-align: center">وضعیت خرید</td><td>#</td><td>#</td><td>#</td></tr>')
                        $("#table1").empty();
                        $("#table1").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            for (var j = 0; j < response.ID_TGS.length; j++) {
                                if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                    ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                    ID_TG2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                    break;
                                }
                            }
                            for (var j = 0; j < response.ID_SES.length; j++) {
                                if (response.ID_SES[j]['ID_SE'] == response.results[i]['ID_SE']) {
                                    ID_SE = $('<td style="width: 25%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_SES[j]['SELLER'] + '</td>');
                                    ID_SE2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_SES[j]['ID_SE'] + '</td>');
                                    break;
                                }
                            }
                            for (var z = 0; z < response.ID_USERS.length; z++) {
                                if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                    ID_USER = $('<td hidden>' + response.ID_USERS[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click',function () {
                                $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                $('#ID_SE_EDIT').val($(this).closest('tr').find('td:eq(10)').text())
                                $('#SHOMAREH_GHARAR_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#BUY_CONDITION_EDIT').val($(this).closest('tr').find('td:eq(13)').text())
                                $('#RESV_EDIT').val($(this).closest('tr').find('td:eq(12)').text())
                                $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                $('#DATE_SHAMSI_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                            })
                            del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click',function () {
                                var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");

                                Swal.fire({
                                    title: 'مایل به حذف این برنامه خرید هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('برنامه خرید حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/buy-delete/" + id_t,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_t,
                                                "_token": token,
                                            },
                                            success: function (response) {

                                                if(response.perm==1){
                                                    $('#' + (Number(id_t) + 2000).toString()).closest('tr').remove();
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
                                                    toastr.error('برنامه خرید حذف گردید');
                                                    $('#' + (Number(id_t) + 2000).toString()).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })

                            })
                            detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">سابقه</button></td>').on('click', function (event) {
                                id_t = $(this).closest('tr').find('td:eq(1)').text();
                                event.preventDefault();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/get-history-buy-prog/' + id_t,
                                    method: 'GET',
                                    success: function (response) {
                                        var ID_S = ''
                                        var ID_T = ''
                                        var TIME_WORK = ''
                                        var DAMAGE_PERCENT = ''
                                        var DESCRIPTION = ''
                                        var SERIYAL_NUMBER = ''
                                        var TYPE_INSTAL = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>کدسابقه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                        $("#table_history").empty();
                                        $("#table_history").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            ID_S = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                            ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                            TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                            DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                            TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                            if(response.results[i]['DISCRIPTION']!= null){
                                                DESCRIPTION = $('<td style="width:35%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                            }else{
                                                DESCRIPTION = $('<td style="width:35%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                            }

                                            SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            row = $('<tr class="table3"></tr>')
                                            row.append(SERIYAL_NUMBER,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                            $("#table_history").append(row)
                                        }
                                    }
                                })
                            })
                            select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                $('#description2').text($(this).closest('tr').find('td:eq(7)').text())
                                var id_t=$(this).closest('tr').find('td:eq(1)').text()
                                $("tr.table1").css("background-color", "white");
                                $("tr.table1").css("color", "black");
                                $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                $(this).closest('tr.table1').css("color", "white");
                            })

                            ID_T = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                            SHOMAREH_GHARAR = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['SHOMAREH_GHARAR'] + '</td>')
                            BUY_CONDITION2 = $('<td hidden style="text-align: center;font-size: x-small">' + response.results[i]['BUY_CONDITION'] + '</td>')
                            if (response.results[i]['BUY_CONDITION'] == 1) {
                                BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">یک</td>')
                            }
                            if (response.results[i]['BUY_CONDITION'] == 2) {
                                BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">دو</td>')
                            }
                            if (response.results[i]['BUY_CONDITION'] == 3) {
                                BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">سه</td>')
                            }
                            if (response.results[i]['BUY_CONDITION'] == 4) {
                                BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">چهار</td>')
                            }
                            // BUY_CONDITION = $('<td style="width: 23%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['BUY_CONDITION'] + '</td>')
                            GROUP_COUNT = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_COUNT'] + '</td>')
                            RESV2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['RESV'] + '</td>')
                            DISCRIPTION = $('<td hidden style="text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                            if (response.results[i]['RESV'] == 1) {
                                RESV = $('<td style="width: 10%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if (response.results[i]['RESV'] == 2) {
                                RESV = $('<td style="width: 10%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                            month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                            day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                            DATE_SHAMSI = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')

                            t1 = $('<td style="width: 5%"></td>')
                            t1.append(edit1)
                            t2 = $('<td style="width: 5%"></td>')
                            t2.append(del2)
                            t3 = $('<td style="width: 5%"></td>')
                            t3.append(select)
                            t4 = $('<td style="width: 30%"></td>')
                            t4.append(detail1)
                            row = $('<tr class="table1"></tr>')
                            row.append(t3,ID_T,ID_TG,ID_SE, DATE_SHAMSI,GROUP_COUNT,SHOMAREH_GHARAR,DISCRIPTION,BUY_CONDITION,ID_TG2,ID_SE2,RESV,RESV2,BUY_CONDITION2,t1, t2,t4)
                            $("#table1").append(row)
                        }
                    }else{
                        Swal.fire('موردی یافت نشد', '', 'info')
                        $("#table1").empty();
                        $("#description2").text('');
                    }

                    }
                });
            })
            $("#buy_edit").on('submit', function (event) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/buy-edit",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var id_t=response.ID_T
                        toastr.success("تغییرات در برنامه خرید اعمال گردید", "", {
                            "timeOut": "5000",
                            "extendedTImeout": "0"
                        });
                        $.ajax({
                            url: '/buy-onlyone2/'+id_t,
                            method:'GET',
                            success: function (response) {
                                if(response.results.length>0){

                                    $("#add_recieve").hide();
                                    $("#description2").text('');
                                    $("#ID_T_SUB2").text('');
                                    $("#table2").empty();
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var select = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var ID_TG = ''
                                    var ID_TG2 = ''
                                    var ID_SE = ''
                                    var ID_SE2 = ''
                                    var GROUP_COUNT=''
                                    var DATE_SHAMSI = ''
                                    var DISCRIPTION = ''
                                    var SHOMAREH_GHARAR = ''
                                    var BUY_CONDITION = ''
                                    var BUY_CONDITION2 = ''
                                    var RESV = ''
                                    var RESV2 = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">فروشنده</td><td style="text-align: center">تاریخ خرید</td><td style="text-align: center">تعداد قطعات</td><td style="text-align: center">شماره قرارداد</td><td style="text-align: center">وضعیت خرید</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table1").empty();
                                    $("#table1").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_TGS.length; j++) {
                                            if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                                ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                                ID_TG2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var j = 0; j < response.ID_SES.length; j++) {
                                            if (response.ID_SES[j]['ID_SE'] == response.results[i]['ID_SE']) {
                                                ID_SE = $('<td style="width: 25%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_SES[j]['SELLER'] + '</td>');
                                                ID_SE2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_SES[j]['ID_SE'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var z = 0; z < response.ID_USERS.length; z++) {
                                            if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                                ID_USER = $('<td hidden>' + response.ID_USERS[z]['l_name'] + '</td>')
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click',function () {
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                            $('#ID_SE_EDIT').val($(this).closest('tr').find('td:eq(10)').text())
                                            $('#SHOMAREH_GHARAR_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#BUY_CONDITION_EDIT').val($(this).closest('tr').find('td:eq(13)').text())
                                            $('#RESV_EDIT').val($(this).closest('tr').find('td:eq(12)').text())
                                            $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#DATE_SHAMSI_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click',function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");

                                            Swal.fire({
                                                title: 'مایل به حذف این برنامه خرید هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {

                                                    Swal.fire('برنامه خرید حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/buy-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {

                                                            if(response.perm==1){
                                                                $('#' + (Number(id_t) + 2000).toString()).closest('tr').remove();
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
                                                                toastr.error('برنامه خرید حذف گردید');
                                                                $('#' + (Number(id_t) + 2000).toString()).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }else{
                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                            }
                                                        }
                                                    });

                                                }
                                            })

                                        })
                                        detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">سابقه</button></td>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-buy-prog/' + id_t,
                                                method: 'GET',
                                                success: function (response) {
                                                    var ID_S = ''
                                                    var ID_T = ''
                                                    var TIME_WORK = ''
                                                    var DAMAGE_PERCENT = ''
                                                    var DESCRIPTION = ''
                                                    var SERIYAL_NUMBER = ''
                                                    var TYPE_INSTAL = ''
                                                    var row = ''
                                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>کدسابقه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                                    $("#table_history").empty();
                                                    $("#table_history").append(th)
                                                    for (var i = 0; i < response.results.length; i++) {
                                                        ID_S = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                                        ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                                        TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                                        DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                                        TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                                        if(response.results[i]['DISCRIPTION']!= null){
                                                            DESCRIPTION = $('<td style="width:35%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                                        }else{
                                                            DESCRIPTION = $('<td style="width:35%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                                        }

                                                        SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                        row = $('<tr class="table3"></tr>')
                                                        row.append(SERIYAL_NUMBER,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                                        $("#table_history").append(row)
                                                    }
                                                }
                                            })
                                        })
                                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $('#description2').text($(this).closest('tr').find('td:eq(7)').text())
                                            var id_t=$(this).closest('tr').find('td:eq(1)').text()
                                            $("tr.table1").css("background-color", "white");
                                            $("tr.table1").css("color", "black");
                                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                            $(this).closest('tr.table1').css("color", "white");
                                        })

                                        ID_T = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                        SHOMAREH_GHARAR = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['SHOMAREH_GHARAR'] + '</td>')
                                        BUY_CONDITION2 = $('<td hidden style="text-align: center;font-size: x-small">' + response.results[i]['BUY_CONDITION'] + '</td>')
                                        if (response.results[i]['BUY_CONDITION'] == 1) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">یک</td>')
                                        }
                                        if (response.results[i]['BUY_CONDITION'] == 2) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">دو</td>')
                                        }
                                        if (response.results[i]['BUY_CONDITION'] == 3) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">سه</td>')
                                        }
                                        if (response.results[i]['BUY_CONDITION'] == 4) {
                                            BUY_CONDITION = $('<td hidden style="width: 23%;text-align: center;font-size: x-small">چهار</td>')
                                        }
                                        // BUY_CONDITION = $('<td style="width: 23%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['BUY_CONDITION'] + '</td>')
                                        GROUP_COUNT = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                        RESV2 = $('<td hidden style="font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['RESV'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        if (response.results[i]['RESV'] == 1) {
                                            RESV = $('<td style="width: 10%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if (response.results[i]['RESV'] == 2) {
                                            RESV = $('<td style="width: 10%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                        DATE_SHAMSI = $('<td style="width: 5%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')

                                        t1 = $('<td style="width: 5%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 5%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 5%"></td>')
                                        t3.append(select)
                                        t4 = $('<td style="width: 30%"></td>')
                                        t4.append(detail1)
                                        row = $('<tr class="table1"></tr>')
                                        row.append(t3,ID_T,ID_TG,ID_SE, DATE_SHAMSI,GROUP_COUNT,SHOMAREH_GHARAR,DISCRIPTION,BUY_CONDITION,ID_TG2,ID_SE2,RESV,RESV2,BUY_CONDITION2,t1, t2,t4)
                                        $("#table1").append(row)
                                    }
                                }else{
                                    Swal.fire('موردی یافت نشد', '', 'info')
                                    $("#table1").empty();
                                    $("#description2").text('');
                                }

                            }
                        })
                    }
                });
                $('#myModal3').modal('hide');
            })


        })
    </script>
@include('Ansaldo.AnsaldoBuyProgComponents.component01')
@include('Ansaldo.AnsaldoBuyProgComponents.component02')
@include('Ansaldo.AnsaldoBuyProgComponents.component03')
@include('Ansaldo.AnsaldoBuyProgComponents.component04')
@include('Ansaldo.AnsaldoBuyProgComponents.component05')
@include('Ansaldo.AnsaldoBuyProgComponents.component06')
@endsection

