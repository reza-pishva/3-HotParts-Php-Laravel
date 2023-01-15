@extends('layouts.mitsubishi_layouts.app_buy_program')
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
                    url: "/m-buy-store",
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
                            url: '/m-buy-onlyone',
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
                                                        url: "/m-buy-delete/" + id_t,
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
                                                url: '/m-get-history-buy-prog/' + id_t,
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
                    url: "/m-buy-rep",
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
                                            url: "/m-buy-delete/" + id_t,
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
                                    url: '/m-get-history-buy-prog/' + id_t,
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
                    url: "/m-buy-edit",
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
                            url: '/m-buy-onlyone2/'+id_t,
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
                                                        url: "/m-buy-delete/" + id_t,
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
                                                url: '/m-get-history-buy-prog/' + id_t,
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
<!-- List of content -->
{{----}}
    {{--<div class="container" style="direction: ltr">--}}
        <div class="container bg-dark" style="width: 100%;height:6%;">
            <div class="row">

                <div class="col">
                    <ul class="navbar-nav" >
                        <li class="nav-item">
                            <a class="nav-link" href="/m-savabegh"><p style="font-family: Tahoma;font-size: x-small">بازگشت</p></a>
                        </li>
                    </ul>
                </div>
                <div class="col-3"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col-3">
                    <div style="width: 100%;height: 65%;border-radius: 3px;margin-top: 4px;padding-top: 5px;background-color: #4a5d74">
                        <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe">برنامه خرید قطعات در نیروگاه</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="width: 100%;height:48%;margin-top: 60px">
           <div class="row">
               <div class="col-3" style="height:300px">
                   <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                       <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">جستجو در برنامه های خرید</p>
                   </div>
                   <div style="width: 95%;height: 280px;margin: auto;margin-top:3px;border-radius: 3px;background-color:rgba(105,105,105,0.5)">
                       <form method="post" encType="multipart/form-data" id="tpsrep_form" action={{route('buy.store')}}>
                           {{csrf_field()}}
                           <div class="row" style="text-align: center">
                               <div class="col">
                                   <select class="form-control isclicked1 mt-2" name="ID_TG_R" id="ID_TG_R" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                       <option value="0">انتخاب نوع قطعات</option>
                                       @foreach($ghataats as $ghataat)
                                           <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           <div class="row mt-1"  style="text-align: center">
                               <div class="col">
                                   <select class="form-control isclicked1" name="ID_SE_R" id="ID_SE_R" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                       <option value="">فروشنده</option>
                                       @foreach($sellers as $seller)
                                           <option value="{{$seller->ID_SE }}">{{$seller->SELLER}}</option>
                                       @endforeach
                                   </select>
                               </div>
                           </div>
                           {{--<div class="row mt-1" style="margin-left: 20px">--}}
                               {{--<div class="col-6" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_BEGINR"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGINR"  style="font-family: Tahoma;font-size: x-small;width: 100%;" required title="تاریخ شروع"></div>--}}
                               {{--<div class="col-6" style="text-align: center"><p style="text-align: left;font-size:small;font-family: Tahoma;color: #fdfdfe">تاریخ شروع</p></div>--}}
                           {{--</div>--}}
                           {{--<div class="row mt-1" style="margin-left: 20px">--}}
                               {{--<div class="col-6" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_ENDR"  data-toggle="tooltip" data-placement="right"  name="DATE_ENDR"  style="font-family: Tahoma;font-size: x-small;width: 100%;" required title="تاریخ پایان"></div>--}}
                               {{--<div class="col-6" style="text-align: center"><p style="text-align: left;font-size:small;font-family: Tahoma;color: #fdfdfe">تاریخ پایان</p></div>--}}
                           {{--</div>--}}
                           {{--<div class="row mt-1">--}}
                               {{--<div class="col">--}}
                                   {{--<select class="form-control isclicked1" name="BUY_CONDITION_R" id="BUY_CONDITION_R" style="width: 180px;font-family: Tahoma;font-size: small;display: inline">--}}
                                       {{--<option value="0">وضعیت خرید</option>--}}
                                       {{--<option value="1">1</option>--}}
                                       {{--<option value="2">2</option>--}}
                                       {{--<option value="3">3</option>--}}
                                       {{--<option value="4">4</option>--}}
                                   {{--</select>--}}
                               {{--</div>--}}
                           {{--</div>--}}
                               <div class="row mt-1">
                               <div class="col">
                                   <select class="form-control isclicked1" name="RESV_R" id="RESV_R" style="width: 180px;font-family: Tahoma;font-size: small;display: inline">
                                       <option value="">وضعیت دریافت</option>
                                       <option value="1">دریافت شده</option>
                                       <option value="2">دریافت نشده</option>
                                   </select>
                               </div>
                           </div>
                           <div class="row mt-4">
                               <div class="col" style="width:60%;text-align: center"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:60%" >جستجو </button></div>
                           </div>
                       </form>

                   </div>
               </div>
               <div class="col-9">
                   <div class="row">
                       <div class="col-11">
                           <div style="width: 100%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                               <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست برنامه های خرید ثبت شده</p>
                           </div>
                           <div style="width:100%;height: 265px;background-color:rgba(105,105,105,0.5);margin-right: 2px;margin-top:3px;border-radius: 3px">
                               <div style="width: 100%;height: 250px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                                   <table id="table1" align="center" style="width: 100%;font-family: Tahoma;font-size: small;direction: rtl;background-color: white;">
                                       {{--<tr style="color: white;font-size:x-small;">--}}
                                           {{--<td>کد</td>--}}
                                           {{--<td>نام قطعات</td>--}}
                                           {{--<td>تاریخ ارسال</td>--}}
                                           {{--<td>نام پیمانکار</td>--}}
                                           {{--<td>#</td>--}}
                                           {{--<td>#</td>--}}
                                       {{--</tr>--}}
                                       {{--@foreach($requests as $request)--}}
                                           {{--<tr class="bg-primary" style="color: white;font-size:x-small">--}}
                                               {{--<td>{{$request->ID_T}}</td>--}}
                                               {{--<td>نام قطعات</td>--}}
                                               {{--<td>تاریخ ارسال</td>--}}
                                               {{--<td>نام پیمانکار</td>--}}
                                               {{--<td>#</td>--}}
                                               {{--<td>#</td>--}}
                                           {{--</tr>--}}
                                       {{--@endforeach--}}

                                   </table>
                               </div>

                           </div>
                       </div>
                       <div class="col-1" style="background-color:rgba(105,105,105,0.5);border-radius: 3px;margin-top: 32px">
                           <div class="row mt-1" style="height: 25%">
                               <div class="col" >
                                   <img src="start01.png" id="add_send" class="reza2" data-toggle="tooltip" data-placement="bottom" title="ایجاد برنامه خرید قطعه">
                               </div>
                           </div>
                           <div class="row" style="height: 25%;margin-top: -5px">
                               <div class="col" >
                                   <a href="/bazsaz-form" > <img src="base.png" id="add_send2" class="reza2" data-toggle="tooltip" data-placement="bottom" title="افزودن اطلاعات پایه" style="border-radius: 15px ;margin-top: 4px"></a>
                               </div>
                           </div>
                           {{--<div class="row" style="height: 25%">--}}
                               {{--<div class="col" >--}}
                                   {{--<a href="/tapr-form" > <img src="equip.png" id="add_send2" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تعیین لیست قطعات" style="border-radius: 15px ;margin-top: 4px"></a>--}}
                               {{--</div>--}}
                           {{--</div>--}}
                           {{--<div class="row" style="height: 25%">--}}
                               {{--<div class="col" >--}}
                                   {{--<a href="/tapr-form" > <img src="repair2.png" id="add_send2" class="reza2" data-toggle="tooltip" data-placement="bottom" title="افزودن برنامه تعمیرات" style="border-radius: 15px ;margin-top: 4px"></a>--}}
                               {{--</div>--}}
                           {{--</div>--}}

                       </div>

                   </div>
               </div>
           </div>
        </div>
        <div class="container" style="width: 100%;height:45%;">
            <div class="row">
                <div class="col-3" style="height:260px" hidden>
                    {{--<div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">--}}
                        {{--<p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">توضیحات</p>--}}
                    {{--</div>--}}
                    {{--<div style="width: 95%;height: 150px;background-color:rgba(72,103,121,0.5);margin: auto;margin-top:3px;border-radius: 3px;text-align: right;padding-right: 10px">--}}
                        {{--<p class="modal-title" id="description2" style="color: white;font-family: Tahoma;font-size: small;display: inline;"></p>--}}
                    {{--</div>--}}
                </div>
                <div class="col-9" style="height:160px">
                    <div class="row">

                        <div class="col-5" style="margin-left: 645px">
                            <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                                <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">توضیحات</p>
                            </div>
                            <div style="width: 95%;height: 100px;background-color:rgba(105,105,105,0.5);margin: auto;margin-top:3px;border-radius: 3px;text-align: right;padding-right: 10px">
                                <p class="modal-title" id="description2" style="color: white;font-family: Tahoma;font-size: small;display: inline;"></p>
                            </div>
                        </div>
                        <div class="col-2" style="background-color:rgba(72,103,121,0.5);border-radius: 3px;margin-top: 32px" hidden>
                            <div class="row" style="height: 33%">
                                <div class="col mt-1" >
                                    <img style="display: none" src="addlist.jpg" id="add_recieve" class="reza2" data-toggle="tooltip" data-placement="left" title="ایجاد برنامه دریافت قطعات">
                                </div>
                            </div>
                            <div class="row" style="height: 33%">
                                <div class="col" ></div>
                            </div>
                            <div class="row" style="height: 33%">
                                <div class="col" ></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Send form -->
        <div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
          <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
            <!-- Send Header -->
            <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ایجاد برنامه خرید قطعات</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10"></div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white;">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Send form -->
            <div class="container"  style="margin: auto;background-color:lightgray;height: 300px ">
                <form method="post" encType="multipart/form-data" id="buy_form" action="{{route('buy.store')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_T" name="ID_T" >
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-3 ">
                            <select class="form-control isclicked1" name="ID_TG" id="ID_TG" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">انتخاب نوع قطعات</option>
                                @foreach($ghataats as $ghataat)
                                    <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3" style="margin-right: 100px">
                            <select class="form-control isclicked1" name="ID_SE" id="ID_SE" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">فروشنده</option>
                                @foreach($sellers as $seller)
                                    <option value="{{$seller->ID_SE }}">{{$seller->SELLER}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row mt-0">
                        <div class="field row" >
                            <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ خرید</p></div>
                            <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ ارسال یا دریافت"></div>
                        </div>
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                        <div class="col-4" style="text-align: center"> <input type="number" max="100000" min="0" class="form-control" id="GROUP_COUNT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="تعداد قطعات"></div>
                        <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">شماره قرارداد</p></div>
                        <div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="SHOMAREH_GHARAR"  data-toggle="tooltip" data-placement="right"  name="SHOMAREH_GHARAR" placeholder="شماره قرارداد" style="font-family: Tahoma;font-size: smaller;width: 80%;"  title="شماره قرارداد"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-4">
                            <select class="form-control isclicked1" name="RESV" id="RESV" required style="width: 180px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">وضعیت دریافت</option>
                                <option value="1">دریافت شده</option>
                                <option value="2">دریافت نشده</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="field row mt-0">
                        <div class="col-9" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%"  title="توضیحات"></div>
                        <div class="col-3" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
                    </div>

                </form>
                <div id="ajax-alert4" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px">

            </div>

        </div>
    </div>
</div>
    <!-- Recieve form -->
        {{--<div class="modal fade" id="myModal2" style="direction: rtl;margin-top: 70px">--}}
        {{--<div class="modal-dialog modal-md" style="margin-top: 25px">--}}
            {{--<div class="modal-content">--}}
                {{--<!-- Recieve Header -->--}}
                {{--<div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >--}}
                    {{--<div class="row" style="width: 100%">--}}
                        {{--<div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ایجاد فرم درخواست دریافت قطعات</p></div>--}}
                        {{--<div class="col-6">--}}
                            {{--<div class="row" style="width: 100%">--}}
                                {{--<div class="col-10"></div>--}}
                                {{--<div class="col-2">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<!-- Recieve Header -->--}}
                {{--<div class="container"  style="margin: auto;background-color:lightgray;height: 210px ">--}}
                    {{--<form method="post" encType="multipart/form-data" id="tpr_form" action="{{route('tpr.store')}}">--}}
                        {{--{{csrf_field()}}--}}
                        {{--<div class="row">--}}
                            {{--<div>--}}
                                {{--<input type="hidden" class="form-control" id="ID_SUB " name="ID_SUB " >--}}
                                {{--<input type="hidden" id="ID_T_SUB2" name="ID_T" >--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row mt-4">--}}
                            {{--<div class="container row" >--}}
                                {{--<div class="col-3" style="text-align: center"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تاریخ دریافت</p></div>--}}
                                {{--<div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ دریافت"></div>--}}
                                {{--<div class="col-3" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: black">دریافت شد</p></div>--}}
                                {{--<div class="col-2" style="text-align: left">--}}
                                    {{--<input style="font-size: 4px" class="form-control" type="checkbox" id="RESV" name="RESV" value="1">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="container row mt-2">--}}
                            {{--<div class="col-3" style="text-align: right"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تعداد قطعات</p></div>--}}
                            {{--<div class="col-4" style="text-align: center"> <input type="text" maxlength="9" class="form-control" id="COUNT_GH"  data-toggle="tooltip" data-placement="right"  name="COUNT_GH" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 100%;" required title="تعداد قطعات"></div>--}}
                            {{--<div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">الصاق فایل</p></div>--}}
                            {{--<div class="col-5" style="text-align: center"> <input style="color: #4e555b;font-size: smaller" type="file" id="select_file_edit" placeholder="الصاق فایل" name="select_file_edit"></div>--}}
                        {{--</div>--}}
                        {{--<br>--}}
                        {{--<div class="field row">--}}


                            {{--<div class="col-3"><p style="font-size: 12px;font-family: Tahoma;color: black">الصاق فایل</p></div>--}}
                            {{--<div class="col-3">--}}
                                {{--<input style="color: black;font-size: smaller" type="file" id="select_file"  placeholder="الصاق فایل" name="select_file">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                         {{--<div class="field row mt-0">--}}
                            {{--<div class="col-4"></div>--}}
                            {{--<div class="col-5"></div>--}}
                            {{--<div class="col-3" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>--}}
                        {{--</div>--}}

                    {{--</form>--}}
                    {{--<div id="ajax-alert4" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>--}}
                {{--</div>--}}

                {{--<!-- Modal footer -->--}}
                {{--<div class="modal-footer bg-info" style="height: 20px">--}}

                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <!-- Edit Send form -->
        <div class="modal fade" id="myModal3" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Send Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح درخواست خرید قطعات</p></div>
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

                <!-- Send form -->
                <div class="container"  style="margin: auto;background-color:lightgray;height: 290px ">
                    <form method="post" encType="multipart/form-data" id="buy_edit" action="{{route('buy.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input type="hidden" class="form-control" id="ID_T_EDIT" name="ID_T_EDIT" >
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-3 ">
                                <select class="form-control isclicked1" name="ID_TG_EDIT" id="ID_TG_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع قطعات</option>
                                    @foreach($ghataats as $ghataat)
                                        <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3" style="margin-right: 100px">
                                <select class="form-control isclicked1" name="ID_SE_EDIT" id="ID_SE_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">فروشنده</option>
                                    @foreach($sellers as $seller)
                                        <option value="{{$seller->ID_SE }}">{{$seller->SELLER}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0">
                            <div class="field row" >
                                <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ خرید</p></div>
                                <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ ارسال یا دریافت"></div>
                            </div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                            <div class="col-4" style="text-align: center"> <input type="number" max="100000" min="0" class="form-control" id="GROUP_COUNT_EDIT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT_EDIT" required placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="تعداد قطعات"></div>
                            <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">شماره قرارداد</p></div>
                            <div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="SHOMAREH_GHARAR_EDIT"  data-toggle="tooltip" data-placement="right"  name="SHOMAREH_GHARAR_EDIT" placeholder="شماره قرارداد" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="شماره قرارداد"></div>
                        </div>
                        <div class="row mt-2">
                            {{--<div class="col-4">--}}
                                {{--<select class="form-control isclicked1" name="BUY_CONDITION_EDIT" id="BUY_CONDITION_EDIT" style="width: 180px;font-family: Tahoma;font-size: small;display: inline">--}}
                                    {{--<option value="0">وضعیت خرید</option>--}}
                                    {{--<option value="1">1</option>--}}
                                    {{--<option value="2">2</option>--}}
                                    {{--<option value="3">3</option>--}}
                                    {{--<option value="4">4</option>--}}
                                {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="col-3"></div>--}}
                            <div class="col-4">
                                <select class="form-control isclicked1" name="RESV_EDIT" id="RESV_EDIT" required style="width: 180px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">وضعیت دریافت</option>
                                    <option value="1">دریافت شده</option>
                                    <option value="2">دریافت نشده</option>
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="field row mt-0">
                            <div class="col-9" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION_EDIT"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION_EDIT" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%" required title="توضیحات"></div>
                            <div class="col-3" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
                        </div>

                    </form>
                    <div id="ajax-alert4" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px">

                </div>

            </div>
        </div>
    </div>
        <div class="modal fade" id="savabegh" style="direction: rtl;margin:auto;margin-top: 80px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width:120%" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">مشاهده سوابق مرتبط با این برنامه</p></div>
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
                <div class="container"  style="margin: auto;background-color:lightgray;height: 375px;width:120%;">
                    <div class="row mylist" style="margin: auto;width:100%;height:368px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige;overflow-y: scroll">
                        <div class="col-12" style="direction: rtl;height: 370px">
                            <table id="table_history" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                <tr class="bg-primary" style="color: white;font-size:x-small;">
                                    <td>کد</td>
                                    <td>کارکرد</td>
                                    <td>میزان خرابی</td>
                                    <td>وضعیت نصب</td>
                                    <td>نوع عملیات</td>
                                    <td>تاریخ شروع</td>
                                    <td>تاریخ پایان</td>
                                    <td>پیمانکار/تعمیرکار</td>
                                    <td>مکان قطعه</td>
                                    <td>توضیحات</td>
                                </tr>
                            </table>
                        </div>
                        <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                            <div class="toast-body"><p id="mytoast5" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                        </div>
                    </div>
                    {{--<table id="table_history" align="center" style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 120%">--}}
                    {{--<tr class="bg-primary" style="color: white;font-size:x-small">--}}
                    {{--<td>کد</td>--}}
                    {{--<td>کارکرد</td>--}}
                    {{--<td>میزان خرابی</td>--}}
                    {{--<td>وضعیت نصب</td>--}}
                    {{--<td>نوع عملیات</td>--}}
                    {{--<td>تاریخ شروع</td>--}}
                    {{--<td>تاریخ پایان</td>--}}
                    {{--<td>پیمانکار/تعمیرکار</td>--}}
                    {{--<td>مکان قطعه</td>--}}
                    {{--<td>توضیحات</td>--}}
                    {{--</tr>--}}
                    {{--</table>--}}





                </div>

                <!-- Modal footer -->
                {{--<div class="modal-footer bg-info" style="height: 20px">--}}

                {{--</div>--}}

            </div>
        </div>
    </div>
    <!-- Edit Recieve form -->
    {{--<div class="modal fade" id="myModal4" style="direction: rtl;margin-top: 70px">--}}
        {{--<div class="modal-dialog modal-md" style="margin-top: 25px">--}}
            {{--<div class="modal-content">--}}
                {{--<!-- Recieve Header -->--}}
                {{--<div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >--}}
                    {{--<div class="row" style="width: 100%">--}}
                        {{--<div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح فرم درخواست دریافت قطعات</p></div>--}}
                        {{--<div class="col-6">--}}
                            {{--<div class="row" style="width: 100%">--}}
                                {{--<div class="col-10"></div>--}}
                                {{--<div class="col-2">--}}
                                    {{--<button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white;">&times;</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

                {{--<!-- Recieve Header -->--}}
                {{--<div class="container"  style="margin: auto;background-color:lightgray;height: 225px ">--}}
                    {{--<form method="post" encType="multipart/form-data" id="tpr_edit" action="{{route('out.edit')}}">--}}
                        {{--{{csrf_field()}}--}}
                        {{--<div class="row">--}}
                            {{--<div>--}}
                                {{--<input hidden id="ID_T_SUB2_EDIT" name="ID_T_EDIT" >--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="row mt-4">--}}
                            {{--<div class="container row" >--}}
                                {{--<div class="col-3" style="text-align: center"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تاریخ دریافت</p></div>--}}
                                {{--<div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ دریافت"></div>--}}
                                {{--<div class="col-3" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: black">دریافت شد</p></div>--}}
                                {{--<div class="col-2" style="text-align: left">--}}
                                    {{--<input style="font-size: 4px" class="form-control" type="checkbox" id="RESV_EDIT" name="RESV_EDIT" value="1">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="container row mt-2">--}}
                            {{--<div class="col-3" style="text-align: right"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تعداد قطعات</p></div>--}}
                            {{--<div class="col-4" style="text-align: center"> <input type="text" maxlength="9" class="form-control" id="$GROUP_COUNT_EDIT"  data-toggle="tooltip" data-placement="right"  name="$GROUP_COUNT_EDIT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 100%;" required title="تعداد قطعات"></div>--}}
                            {{--<div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">الصاق فایل</p></div>--}}
                            {{--<div class="col-5" style="text-align: center"> <input style="color: #4e555b;font-size: smaller" type="file" id="select_file_edit" placeholder="الصاق فایل" name="select_file_edit"></div>--}}
                        {{--</div>--}}
                        {{--<br>--}}
                        {{--<div class="field row">--}}


                            {{--<div class="col-3"><p style="font-size: 12px;font-family: Tahoma;color: black">الصاق فایل</p></div>--}}
                            {{--<div class="col-5">--}}
                                {{--<input style="color: black;font-size: smaller" type="file" id="select_file_edit"  placeholder="الصاق فایل" name="select_file_edit">--}}
                                {{--<div style="text-align: center"><p id="FILE_NAME_EDIT" style="text-align: right;font-size: smaller;font-family: Tahoma"></p></div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="field row mt-0">--}}
                            {{--<div class="col-4"></div>--}}
                            {{--<div class="col-5"></div>--}}
                            {{--<div class="col-3" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>--}}
                        {{--</div>--}}

                    {{--</form>--}}
                    {{--<div id="ajax-alert4" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>--}}
                {{--</div>--}}

                {{--<!-- Modal footer -->--}}
                {{--<div class="modal-footer bg-info" style="height: 20px">--}}

                {{--</div>--}}

            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}





@endsection

