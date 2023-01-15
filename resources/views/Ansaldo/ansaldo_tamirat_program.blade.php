@extends('layouts.ansaldo_layouts.app_tamirat_program')
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
        $("#DATE_BEGIN_SH").prop('readonly', true)
        $("#DATE_END_SH").prop('readonly', true)
        $("#DATE_BEGIN_SH_EDIT").prop('readonly', true)
        $("#DATE_END_SH_EDIT").prop('readonly', true)
        $("#DATE_BEGIN_SH_REP").prop('readonly', true)
        $("#DATE_END_SH_REP").prop('readonly', true)

        $("#DATE_BEGIN_SH").persianDatepicker({
            format: 'YYYY/MM/DD'
        });
        $("#DATE_END_SH").persianDatepicker({
            format: 'YYYY/MM/DD'
        });
        $("#DATE_BEGIN_SH_EDIT").persianDatepicker({
            format: 'YYYY/MM/DD'
        });
        $("#DATE_END_SH_EDIT").persianDatepicker({
            format: 'YYYY/MM/DD'
        });
        $("#DATE_BEGIN_SH_REP").persianDatepicker({
            format: 'YYYY/MM/DD'
        });
        $("#DATE_END_SH_REP").persianDatepicker({
            format: 'YYYY/MM/DD'
        });
        $("#tainfoform").on('click',function (event) {
            $('#flag').val('1')
            event.preventDefault();
            $(".tarep").hide()
            $(".tainfo").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/tapr-total',
                method:'GET',
                success: function (response) {
                    if(response.results.length>0){
                        var day = ''
                        var month = ''
                        var year = ''
                        var edit1 = ''
                        var del2 = ''
                        var detail1 = ''
                        var detail2 = ''
                        var ID_T = ''
                        var ID_USER = ''
                        var ID_UN = ''
                        var ID_UN2 = ''
                        var ID_TT = ''
                        var ID_TT2 = ''
                        var ID_TA = ''
                        var ID_TA2 = ''
                        var TIME_WORK_REAL = ''
                        var TIME_WORK_EQUAL = ''
                        var DISCRIPTION = ''
                        var ANGAM = ''
                        var CONFIR = ''
                        var ANGAM2 = ''
                        var CONFIR2 = ''
                        var DATE_BEGIN_SH = ''
                        var DATE_END_SH = ''
                        var FILE_NAME = ''
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td style="text-align: right">واحد</td><td style="text-align: right">نوع تعمیرات</td><td style="text-align: right">شرکت تعمیرکار</td><td style="text-align: right">شروع تعمیرات</td><td style="text-align: right">پایان تعمیرات</td><td>کارکرد واقعی</td><td>کارکرد معادل</td><td>تایید شد</td><td>انجام شد</td></tr>')
                        $("#tamirat_table").empty();
                        $("#tamirat_table").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            for (var j = 0; j < response.ID_UNS.length; j++) {
                                if (response.ID_UNS[j]['ID_UN'] == response.results[i]['ID_UN']) {
                                    ID_UN = $('<td style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['UNIT_NUMBER'] + '</td>');
                                    ID_UN2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['ID_UN'] + '</td>');
                                    break;
                                }
                            }
                            for (var j = 0; j < response.ID_TAS.length; j++) {
                                if (response.ID_TAS[j]['ID_TA'] == response.results[i]['ID_TA']) {
                                    ID_TA = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['TAMIRKAR'] + '</td>');
                                    ID_TA2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['ID_TA'] + '</td>');
                                    break;
                                }
                            }
                            for (var j = 0; j < response.ID_TTS.length; j++) {
                                if (response.ID_TTS[j]['ID_TT'] == response.results[i]['ID_TT']) {
                                    ID_TT = $('<td style="width: 14%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['TAMIRAT_TYPE'] + '</td>');
                                    ID_TT2 = $('<td hidden style="width: 17%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['ID_TT'] + '</td>');
                                    break;
                                }
                            }
                            for (var z = 0; z < response.ID_USERS.length; z++) {
                                if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                    ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal1">ویرایش</button>').on('click',function () {
                                $('#ANGAM_EDIT').prop('checked', false);
                                $('#CONFIR_EDIT').prop('checked', false);
                                $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(0)').text())
                                $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(13)').text())
                                $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(15)').text())
                                $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(14)').text())
                                $('#DATE_BEGIN_SH_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                $('#DATE_END_SH_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                $('#TIME_WORK_REAL_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#TIME_WORK_EQUAL_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(8)').text())
                                if ($(this).closest('tr').find('td:eq(9)').text() == 1) {
                                    $('#ANGAM_EDIT').prop('checked', true);
                                }
                                if ($(this).closest('tr').find('td:eq(10)').text() == 1) {
                                    $('#CONFIR_EDIT').prop('checked', true);
                                }
                                if ($(this).closest('tr').find('td:eq(11)').text() != 'null') {
                                    $('#FILE_NAME_EDIT').text($(this).closest('tr').find('td:eq(11)').text()).attr("href", "images/" + $(this).closest('tr').find('td:eq(11)').text())
                                } else {
                                    $('#FILE_NAME_EDIT').text('فایل پیوست ندارد')
                                }
                            })
                            del2 = $('<button type="button" class="btn-sm border-danger del2" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 3000).on('click',function () {
                                var id_t = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این برنامه تعمیراتی هستید؟',
                                    showDenyButton: true,
                                    //showCancelButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        Swal.fire('رکورد انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {
                                        $.ajax({
                                            url: "/tapr-delete/" + id_t,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_t,
                                                "_token": token,
                                            },
                                            success: function (response) {

                                                if(response.perm==1){
                                                    $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
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
                                                    toastr.error('برنامه تعمیراتی حذف گردید');
                                                    $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });
                                        // Swal.fire('حذف شد', '', 'success');
                                    }
                                })
                            })
                            detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button></td>').on('click', function (event) {
                                id_t = $(this).closest('tr').find('td:eq(0)').text();
                                event.preventDefault();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/get-history-tamirat-prog/' + id_t,
                                    method: 'GET',
                                    success: function (response) {
                                        var ID_S = ''
                                        var ID_T = ''
                                        var TIME_WORK = ''
                                        var GHATAAT_NAME=''
                                        var DAMAGE_PERCENT = ''
                                        var DESCRIPTION = ''
                                        var SERIYAL_NUMBER = ''
                                        var TYPE_INSTAL = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>نوع قطعه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                        $("#table_history").empty();
                                        $("#table_history").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            ID_S = $('<td hidden style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                            ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                            TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                            GHATAAT_NAME = $('<td style="width:25%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                            DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                            TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                            if(response.results[i]['DISCRIPTION']!= null){
                                                DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                            }else{
                                                DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                            }

                                            SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            row = $('<tr class="table3"></tr>')
                                            row.append(SERIYAL_NUMBER,GHATAAT_NAME,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                            $("#table_history").append(row)
                                        }
                                    }
                                })
                            })
                            if(response.results[i]['FILE_NAME']=="فایل پیوست ندارد"){
                                ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a style="visibility: hidden" href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                            }else{
                                ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                            }
                            TIME_WORK_REAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['TIME_WORK_REAL'] + '</td>')
                            TIME_WORK_EQUAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['TIME_WORK_EQUAL'] + '</td>')
                            DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                            ANGAM = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ANGAM'] + '</td>')
                            CONFIR = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['CONFIR'] + '</td>')
                            if(response.results[i]['ANGAM']==1){
                                ANGAM2 = $('<td  style="width: 5%;text-align: center"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if(response.results[i]['ANGAM']==2){
                                ANGAM2 = $('<td  style="width: 5%;text-align: center"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if(response.results[i]['CONFIR']==1){
                                CONFIR2 = $('<td  style="width: 5%;text-align: center"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if(response.results[i]['CONFIR']==2){
                                CONFIR2 = $('<td  style="width: 5%;text-align: center"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            year = response.results[i]['DATE_BEGIN_SH'].substr(0, 4);
                            month = response.results[i]['DATE_BEGIN_SH'].substr(4, 2);
                            day = response.results[i]['DATE_BEGIN_SH'].substr(6, 2);
                            DATE_BEGIN_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                            year = response.results[i]['DATE_END_SH'].substr(0, 4);
                            month = response.results[i]['DATE_END_SH'].substr(4, 2);
                            day = response.results[i]['DATE_END_SH'].substr(6, 2);
                            DATE_END_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                            FILE_NAME = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['FILE_NAME'] + '</td>')
                            t1 = $('<td style="width: 4%"></td>')
                            t1.append(edit1)
                            t2 = $('<td style="width: 4%"></td>')
                            t2.append(del2)
                            t3 = $('<td style="width: 4%"></td>')
                            t3.append(detail1)
                            row = $('<tr></tr>')
                            row.append(ID_T, ID_UN, ID_TT, ID_TA, DATE_BEGIN_SH, DATE_END_SH, TIME_WORK_REAL, TIME_WORK_EQUAL, DISCRIPTION, ANGAM, CONFIR, FILE_NAME, ID_USER, ID_UN2, ID_TA2, ID_TT2,CONFIR2, ANGAM2)
                            $("#tamirat_table").append(row)
                        }
                    }else{
                        Swal.fire('موردی یافت نشد', '', 'info')
                    }


                }


        })

        })
        $("#tp_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tapr-store",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#ID_T').val('')
                    $('#ID_UN').val('')
                    $('#ID_TT').val('')
                    $('#ID_TA').val('')
                    $('#TIME_WORK_REAL').val('')
                    $('#TIME_WORK_EQUAL').val('')
                    $('#DISCRIPTION').val('')
                    $('#FILE_NAME').val('')
                    $('#CONFIR').prop('checked', false)
                    $('#ANGAM').prop('checked', false)
                    $('#select_file').val('')
                    toastr.success("اطلاعات مربوط به این تعمیرات با موفقیت ذخیره گردید", "", {
                        "timeOut": "5000",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/tapr-total',
                        method:'GET',
                        success: function (response) {
                            if(response.results.length>0){
                                var day = ''
                                var month = ''
                                var year = ''
                                var edit1 = ''
                                var del2 = ''
                                var detail1 = ''
                                var detail2 = ''
                                var ID_T = ''
                                var ID_USER = ''
                                var ID_UN = ''
                                var ID_UN2 = ''
                                var ID_TT = ''
                                var ID_TT2 = ''
                                var ID_TA = ''
                                var ID_TA2 = ''
                                var TIME_WORK_REAL = ''
                                var TIME_WORK_EQUAL = ''
                                var DISCRIPTION = ''
                                var ANGAM = ''
                                var CONFIR = ''
                                var ANGAM2 = ''
                                var CONFIR2 = ''
                                var DATE_BEGIN_SH = ''
                                var DATE_END_SH = ''
                                var FILE_NAME = ''
                                var t1 = ''
                                var t2 = ''
                                var t3 = ''
                                var t4 = ''
                                var row = ''
                                var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td style="text-align: right">واحد</td><td style="text-align: right">نوع تعمیرات</td><td style="text-align: right">شرکت تعمیرکار</td><td style="text-align: right">شروع تعمیرات</td><td style="text-align: right">پایان تعمیرات</td><td>کارکرد واقعی</td><td>کارکرد معادل</td><td>تایید شد</td><td>انجام شد</td><td>#</td><td>#</td><td>#</td></tr>')
                                $("#tamirat_table").empty();
                                $("#tamirat_table").append(th)
                                for (var i = 0; i < response.results.length; i++) {
                                    for (var j = 0; j < response.ID_UNS.length; j++) {
                                        if (response.ID_UNS[j]['ID_UN'] == response.results[i]['ID_UN']) {
                                            ID_UN = $('<td style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['UNIT_NUMBER'] + '</td>');
                                            ID_UN2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['ID_UN'] + '</td>');
                                            break;
                                        }
                                    }
                                    for (var j = 0; j < response.ID_TAS.length; j++) {
                                        if (response.ID_TAS[j]['ID_TA'] == response.results[i]['ID_TA']) {
                                            ID_TA = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['TAMIRKAR'] + '</td>');
                                            ID_TA2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['ID_TA'] + '</td>');
                                            break;
                                        }
                                    }
                                    for (var j = 0; j < response.ID_TTS.length; j++) {
                                        if (response.ID_TTS[j]['ID_TT'] == response.results[i]['ID_TT']) {
                                            ID_TT = $('<td style="width: 14%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['TAMIRAT_TYPE'] + '</td>');
                                            ID_TT2 = $('<td hidden style="width: 17%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['ID_TT'] + '</td>');
                                            break;
                                        }
                                    }
                                    for (var z = 0; z < response.ID_USERS.length; z++) {
                                        if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                            ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                            break;
                                        }
                                    }
                                    edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal1">ویرایش</button>').on('click',function () {
                                        $('#ANGAM_EDIT').prop('checked', false);
                                        $('#CONFIR_EDIT').prop('checked', false);
                                        $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(0)').text())
                                        $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(13)').text())
                                        $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(15)').text())
                                        $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(14)').text())
                                        $('#DATE_BEGIN_SH_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                        $('#DATE_END_SH_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                        $('#TIME_WORK_REAL_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                        $('#TIME_WORK_EQUAL_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                        $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(8)').text())
                                        if ($(this).closest('tr').find('td:eq(9)').text() == 1) {
                                            $('#ANGAM_EDIT').prop('checked', true);
                                        }
                                        if ($(this).closest('tr').find('td:eq(10)').text() == 1) {
                                            $('#CONFIR_EDIT').prop('checked', true);
                                        }
                                        if ($(this).closest('tr').find('td:eq(11)').text() != 'null') {
                                            $('#FILE_NAME_EDIT').text($(this).closest('tr').find('td:eq(11)').text()).attr("href", "images/" + $(this).closest('tr').find('td:eq(11)').text())
                                        } else {
                                            $('#FILE_NAME_EDIT').text('فایل پیوست ندارد')
                                        }
                                    })
                                    del2 = $('<button type="button" class="btn-sm border-danger del2" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 3000).on('click',function () {
                                        var id_t = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        Swal.fire({
                                            title: 'مایل به حذف این برنامه تعمیراتی هستید؟',
                                            showDenyButton: true,
                                            //showCancelButton: true,
                                            cancelButtonText: `بازگشت`,
                                            confirmButtonText: `انصراف از حذف`,
                                            denyButtonText: 'حذف شود',
                                        }).then((result) => {
                                            /* Read more about isConfirmed, isDenied below */
                                            if (result.isConfirmed) {
                                                Swal.fire('رکورد انتخابی حذف نشد', '', 'info')
                                            } else if (result.isDenied) {
                                                $.ajax({
                                                    url: "/tapr-delete/" + id_t,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_t,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {

                                                        if(response.perm==1){
                                                            $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
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
                                                            toastr.error('برنامه تعمیراتی حذف گردید');
                                                            $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
                                                            Swal.fire('حذف شد', '', 'success');
                                                        }else{
                                                            Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                        }
                                                    }
                                                });
                                                Swal.fire('حذف شد', '', 'success');
                                            }
                                        })
                                    })
                                    detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button></td>').on('click', function (event) {
                                        id_t = $(this).closest('tr').find('td:eq(0)').text();
                                        event.preventDefault();
                                        $.ajaxSetup({
                                            headers: {
                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            }
                                        });
                                        var _token = $("input[name='_token']").val();
                                        $.ajax({
                                            url: '/get-history-tamirat-prog/' + id_t,
                                            method: 'GET',
                                            success: function (response) {
                                                var ID_S = ''
                                                var ID_T = ''
                                                var TIME_WORK = ''
                                                var GHATAAT_NAME=''
                                                var DAMAGE_PERCENT = ''
                                                var DESCRIPTION = ''
                                                var SERIYAL_NUMBER = ''
                                                var TYPE_INSTAL = ''
                                                var row = ''
                                                var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>نوع قطعه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                                $("#table_history").empty();
                                                $("#table_history").append(th)
                                                for (var i = 0; i < response.results.length; i++) {
                                                    ID_S = $('<td hidden style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                                    ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                                    TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                                    GHATAAT_NAME = $('<td style="width:25%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                                    DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                                    TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                                    if(response.results[i]['DISCRIPTION']!= null){
                                                        DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                                    }else{
                                                        DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                                    }

                                                    SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                    row = $('<tr class="table3"></tr>')
                                                    row.append(SERIYAL_NUMBER,GHATAAT_NAME,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                                    $("#table_history").append(row)
                                                }
                                            }
                                        })
                                    })
                                    if(response.results[i]['FILE_NAME']=="فایل پیوست ندارد"){
                                        ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a style="visibility: hidden" href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                                    }else{
                                        ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                                    }
                                    TIME_WORK_REAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['TIME_WORK_REAL'] + '</td>')
                                    TIME_WORK_EQUAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['TIME_WORK_EQUAL'] + '</td>')
                                    DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                    ANGAM = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ANGAM'] + '</td>')
                                    CONFIR = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['CONFIR'] + '</td>')
                                    if(response.results[i]['ANGAM']==1){
                                        ANGAM2 = $('<td  style="width: 5%;text-align: center"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                    }
                                    if(response.results[i]['ANGAM']==2){
                                        ANGAM2 = $('<td  style="width: 5%;text-align: center"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                    }
                                    if(response.results[i]['CONFIR']==1){
                                        CONFIR2 = $('<td  style="width: 5%;text-align: center"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                    }
                                    if(response.results[i]['CONFIR']==2){
                                        CONFIR2 = $('<td  style="width: 5%;text-align: center"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                    }
                                    year = response.results[i]['DATE_BEGIN_SH'].substr(0, 4);
                                    month = response.results[i]['DATE_BEGIN_SH'].substr(4, 2);
                                    day = response.results[i]['DATE_BEGIN_SH'].substr(6, 2);
                                    DATE_BEGIN_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                                    year = response.results[i]['DATE_END_SH'].substr(0, 4);
                                    month = response.results[i]['DATE_END_SH'].substr(4, 2);
                                    day = response.results[i]['DATE_END_SH'].substr(6, 2);
                                    DATE_END_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                                    FILE_NAME = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['FILE_NAME'] + '</td>')
                                    t1 = $('<td style="width: 4%"></td>')
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 4%"></td>')
                                    t2.append(del2)
                                    t3 = $('<td style="width: 4%"></td>')
                                    t3.append(detail1)
                                    row = $('<tr></tr>')
                                    row.append(ID_T, ID_UN, ID_TT, ID_TA, DATE_BEGIN_SH, DATE_END_SH, TIME_WORK_REAL, TIME_WORK_EQUAL, DISCRIPTION, ANGAM, CONFIR, FILE_NAME, ID_USER, ID_UN2, ID_TA2, ID_TT2,CONFIR2, ANGAM2, t3, t1, t2)
                                    $("#tamirat_table").append(row)
                                }
                            }else{
                                Swal.fire('موردی یافت نشد', '', 'info')
                            }
                        }
                    })
                },
                error:function(response){
                    if(response.message===undefined){
                        alert("اشکال در ارسال اطلاعات. نوع اطلاعات وارد شده مورد بررسی مجدد قرار گیرد")
                    }
                }
            });
        })
        $("#tainfoedit").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tapr-edit",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    toastr.success("تغییرات اعمال گردید", "", {
                        "timeOut": "5000",
                        "extendedTImeout": "0"
                    });
                    if($('#flag').val()==1){
                        $.ajax({
                            url: '/tapr-total',
                            method:'GET',
                            success: function (response) {
                                if(response.results.length>0){
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var select = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var ID_UN = ''
                                    var ID_UN2 = ''
                                    var ID_TT = ''
                                    var ID_TT2 = ''
                                    var ID_TA = ''
                                    var ID_TA2 = ''
                                    var TIME_WORK_REAL = ''
                                    var TIME_WORK_EQUAL = ''
                                    var DISCRIPTION = ''
                                    var ANGAM = ''
                                    var CONFIR = ''
                                    var ANGAM2 = ''
                                    var CONFIR2 = ''
                                    var DATE_BEGIN_SH = ''
                                    var DATE_END_SH = ''
                                    var FILE_NAME = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">واحد</td><td style="text-align: center">نوع تعمیرات</td><td style="text-align: center">شرکت تعمیرکار</td><td style="text-align: center">شروع تعمیرات</td><td style="text-align: center">پایان تعمیرات</td><td style="text-align: center">کارکرد واقعی</td><td style="text-align: center">کارکرد معادل</td><td style="text-align: center">تایید شد</td><td style="text-align: center">انجام شد</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#tamirat_table_report").empty();
                                    $("#tamirat_table_report").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_UNS.length; j++) {
                                            if (response.ID_UNS[j]['ID_UN'] == response.results[i]['ID_UN']) {
                                                ID_UN = $('<td style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_UNS[j]['UNIT_NUMBER'] + '</td>');
                                                ID_UN2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['ID_UN'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var j = 0; j < response.ID_TAS.length; j++) {
                                            if (response.ID_TAS[j]['ID_TA'] == response.results[i]['ID_TA']) {
                                                ID_TA = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TAS[j]['TAMIRKAR'] + '</td>');
                                                ID_TA2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['ID_TA'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var j = 0; j < response.ID_TTS.length; j++) {
                                            if (response.ID_TTS[j]['ID_TT'] == response.results[i]['ID_TT']) {
                                                ID_TT = $('<td style="width: 14%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TTS[j]['TAMIRAT_TYPE'] + '</td>');
                                                ID_TT2 = $('<td hidden style="width: 17%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['ID_TT'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var z = 0; z < response.ID_USERS.length; z++) {
                                            if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                                ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal1">ویرایش</button>').on('click',function () {
                                            $('#ANGAM_EDIT').prop('checked', false);
                                            $('#CONFIR_EDIT').prop('checked', false);
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(14)').text())
                                            $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(16)').text())
                                            $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(15)').text())
                                            $('#DATE_BEGIN_SH_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DATE_END_SH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#TIME_WORK_REAL_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#TIME_WORK_EQUAL_EDIT').val($(this).closest('tr').find('td:eq(8)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                            if ($(this).closest('tr').find('td:eq(10)').text() == 1) {
                                                $('#ANGAM_EDIT').prop('checked', true);
                                            }
                                            if ($(this).closest('tr').find('td:eq(11)').text() == 1) {
                                                $('#CONFIR_EDIT').prop('checked', true);
                                            }
                                            if ($(this).closest('tr').find('td:eq(12)').text() != 'null') {
                                                $('#FILE_NAME_EDIT').text($(this).closest('tr').find('td:eq(11)').text()).attr("href", "images/" + $(this).closest('tr').find('td:eq(12)').text())
                                            } else {
                                                $('#FILE_NAME_EDIT').text('فایل پیوست ندارد')
                                            }
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del2" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 3000).on('click',function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");
                                            Swal.fire({
                                                title: 'مایل به حذف این برنامه تعمیراتی هستید؟',
                                                showDenyButton: true,
                                                //showCancelButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                /* Read more about isConfirmed, isDenied below */
                                                if (result.isConfirmed) {
                                                    Swal.fire('رکورد انتخابی حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/tapr-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {

                                                            if(response.perm==1){
                                                                $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
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
                                                                toastr.error('برنامه تعمیراتی حذف گردید');
                                                                $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }else{
                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                            }
                                                        }
                                                    });

                                                }
                                            })
                                        })
                                        detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button></td>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-tamirat-prog/' + id_t,
                                                method: 'GET',
                                                success: function (response) {
                                                    var ID_S = ''
                                                    var ID_T = ''
                                                    var TIME_WORK = ''
                                                    var GHATAAT_NAME=''
                                                    var DAMAGE_PERCENT = ''
                                                    var DESCRIPTION = ''
                                                    var SERIYAL_NUMBER = ''
                                                    var TYPE_INSTAL = ''
                                                    var row = ''
                                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>نوع قطعه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                                    $("#table_history").empty();
                                                    $("#table_history").append(th)
                                                    for (var i = 0; i < response.results.length; i++) {
                                                        ID_S = $('<td hidden style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                                        ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                                        TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                                        GHATAAT_NAME = $('<td style="width:25%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                                        DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                                        TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                                        if(response.results[i]['DISCRIPTION']!= null){
                                                            DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                                        }else{
                                                            DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                                        }

                                                        SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                        row = $('<tr class="table3"></tr>')
                                                        row.append(SERIYAL_NUMBER,GHATAAT_NAME,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                                        $("#table_history").append(row)
                                                    }
                                                }
                                            })
                                        })
                                        select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $("tr.tamirat_table_report").css("background-color", "white");
                                            $("tr.tamirat_table_report").css("color", "black");
                                            $(this).closest('tr.tamirat_table_report').css( "background-color","RosyBrown");
                                            $(this).closest('tr.tamirat_table_report').css( "color", "white" );
                                        })
                                        if(response.results[i]['FILE_NAME']=="فایل پیوست ندارد"){
                                            ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a style="visibility: hidden" href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                                        }else{
                                            ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                                        }
                                        TIME_WORK_REAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_REAL'] + '</td>')
                                        TIME_WORK_EQUAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_EQUAL'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        ANGAM = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ANGAM'] + '</td>')
                                        CONFIR = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['CONFIR'] + '</td>')
                                        if(response.results[i]['ANGAM']==1){
                                            ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if(response.results[i]['ANGAM']==2){
                                            ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if(response.results[i]['CONFIR']==1){
                                            CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if(response.results[i]['CONFIR']==2){
                                            CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        year = response.results[i]['DATE_BEGIN_SH'].substr(0, 4);
                                        month = response.results[i]['DATE_BEGIN_SH'].substr(4, 2);
                                        day = response.results[i]['DATE_BEGIN_SH'].substr(6, 2);
                                        DATE_BEGIN_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        year = response.results[i]['DATE_END_SH'].substr(0, 4);
                                        month = response.results[i]['DATE_END_SH'].substr(4, 2);
                                        day = response.results[i]['DATE_END_SH'].substr(6, 2);
                                        DATE_END_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        FILE_NAME = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['FILE_NAME'] + '</td>')
                                        t1 = $('<td style="width: 4%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 4%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 4%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 4%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="tamirat_table_report"></tr>')
                                        row.append(t4,ID_T, ID_UN, ID_TT, ID_TA, DATE_BEGIN_SH, DATE_END_SH, TIME_WORK_REAL, TIME_WORK_EQUAL, DISCRIPTION, ANGAM, CONFIR, FILE_NAME, ID_USER, ID_UN2, ID_TA2, ID_TT2,CONFIR2, ANGAM2, t3, t1, t2)
                                        $("#tamirat_table_report").append(row)
                                    }
                                }else{
                                    Swal.fire('موردی یافت نشد', '', 'info')
                                }
                            }
                        })
                    }
                    if($('#flag').val()==2){
                        $.ajax({
                            url: '/tapr-rep2',
                            method:'GET',
                            success: function (response) {
                                if(response.results.length>0){
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var select = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var ID_UN = ''
                                    var ID_UN2 = ''
                                    var ID_TT = ''
                                    var ID_TT2 = ''
                                    var ID_TA = ''
                                    var ID_TA2 = ''
                                    var TIME_WORK_REAL = ''
                                    var TIME_WORK_EQUAL = ''
                                    var DISCRIPTION = ''
                                    var ANGAM = ''
                                    var CONFIR = ''
                                    var ANGAM2 = ''
                                    var CONFIR2 = ''
                                    var DATE_BEGIN_SH = ''
                                    var DATE_END_SH = ''
                                    var FILE_NAME = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">واحد</td><td style="text-align: center">نوع تعمیرات</td><td style="text-align: center">شرکت تعمیرکار</td><td style="text-align: center">شروع تعمیرات</td><td style="text-align: center">پایان تعمیرات</td><td style="text-align: center">کارکرد واقعی</td><td style="text-align: center">کارکرد معادل</td><td style="text-align: center">تایید شد</td><td style="text-align: center">انجام شد</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#tamirat_table_report").empty();
                                    $("#tamirat_table_report").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_UNS.length; j++) {
                                            if (response.ID_UNS[j]['ID_UN'] == response.results[i]['ID_UN']) {
                                                ID_UN = $('<td style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_UNS[j]['UNIT_NUMBER'] + '</td>');
                                                ID_UN2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['ID_UN'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var j = 0; j < response.ID_TAS.length; j++) {
                                            if (response.ID_TAS[j]['ID_TA'] == response.results[i]['ID_TA']) {
                                                ID_TA = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TAS[j]['TAMIRKAR'] + '</td>');
                                                ID_TA2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['ID_TA'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var j = 0; j < response.ID_TTS.length; j++) {
                                            if (response.ID_TTS[j]['ID_TT'] == response.results[i]['ID_TT']) {
                                                ID_TT = $('<td style="width: 14%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TTS[j]['TAMIRAT_TYPE'] + '</td>');
                                                ID_TT2 = $('<td hidden style="width: 17%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['ID_TT'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var z = 0; z < response.ID_USERS.length; z++) {
                                            if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                                ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal1">ویرایش</button>').on('click',function () {
                                            $('#ANGAM_EDIT').prop('checked', false);
                                            $('#CONFIR_EDIT').prop('checked', false);
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(14)').text())
                                            $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(16)').text())
                                            $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(15)').text())
                                            $('#DATE_BEGIN_SH_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DATE_END_SH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#TIME_WORK_REAL_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#TIME_WORK_EQUAL_EDIT').val($(this).closest('tr').find('td:eq(8)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                            if ($(this).closest('tr').find('td:eq(10)').text() == 1) {
                                                $('#ANGAM_EDIT').prop('checked', true);
                                            }
                                            if ($(this).closest('tr').find('td:eq(11)').text() == 1) {
                                                $('#CONFIR_EDIT').prop('checked', true);
                                            }
                                            if ($(this).closest('tr').find('td:eq(12)').text() != 'null') {
                                                $('#FILE_NAME_EDIT').text($(this).closest('tr').find('td:eq(11)').text()).attr("href", "images/" + $(this).closest('tr').find('td:eq(12)').text())
                                            } else {
                                                $('#FILE_NAME_EDIT').text('فایل پیوست ندارد')
                                            }
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del2" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 3000).on('click',function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");
                                            Swal.fire({
                                                title: 'مایل به حذف این برنامه تعمیراتی هستید؟',
                                                showDenyButton: true,
                                                //showCancelButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                /* Read more about isConfirmed, isDenied below */
                                                if (result.isConfirmed) {
                                                    Swal.fire('رکورد انتخابی حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/tapr-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {

                                                            if(response.perm==1){
                                                                $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
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
                                                                toastr.error('برنامه تعمیراتی حذف گردید');
                                                                $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }else{
                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                            }
                                                        }
                                                    });

                                                }
                                            })
                                        })
                                        detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button></td>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-tamirat-prog/' + id_t,
                                                method: 'GET',
                                                success: function (response) {
                                                    var ID_S = ''
                                                    var ID_T = ''
                                                    var TIME_WORK = ''
                                                    var GHATAAT_NAME=''
                                                    var DAMAGE_PERCENT = ''
                                                    var DESCRIPTION = ''
                                                    var SERIYAL_NUMBER = ''
                                                    var TYPE_INSTAL = ''
                                                    var row = ''
                                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>نوع قطعه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                                    $("#table_history").empty();
                                                    $("#table_history").append(th)
                                                    for (var i = 0; i < response.results.length; i++) {
                                                        ID_S = $('<td hidden style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                                        ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                                        TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                                        GHATAAT_NAME = $('<td style="width:25%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                                        DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                                        TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                                        if(response.results[i]['DISCRIPTION']!= null){
                                                            DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                                        }else{
                                                            DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                                        }

                                                        SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                        row = $('<tr class="table3"></tr>')
                                                        row.append(SERIYAL_NUMBER,GHATAAT_NAME,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                                        $("#table_history").append(row)
                                                    }
                                                }
                                            })
                                        })
                                        select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $("tr.tamirat_table_report").css("background-color", "white");
                                            $("tr.tamirat_table_report").css("color", "black");
                                            $(this).closest('tr.tamirat_table_report').css( "background-color","RosyBrown");
                                            $(this).closest('tr.tamirat_table_report').css( "color", "white" );
                                        })
                                        if(response.results[i]['FILE_NAME']=="فایل پیوست ندارد"){
                                            ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a style="visibility: hidden" href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                                        }else{
                                            ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                                        }
                                        TIME_WORK_REAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_REAL'] + '</td>')
                                        TIME_WORK_EQUAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_EQUAL'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        ANGAM = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ANGAM'] + '</td>')
                                        CONFIR = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['CONFIR'] + '</td>')
                                        if(response.results[i]['ANGAM']==1){
                                            ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if(response.results[i]['ANGAM']==2){
                                            ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if(response.results[i]['CONFIR']==1){
                                            CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if(response.results[i]['CONFIR']==2){
                                            CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        year = response.results[i]['DATE_BEGIN_SH'].substr(0, 4);
                                        month = response.results[i]['DATE_BEGIN_SH'].substr(4, 2);
                                        day = response.results[i]['DATE_BEGIN_SH'].substr(6, 2);
                                        DATE_BEGIN_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        year = response.results[i]['DATE_END_SH'].substr(0, 4);
                                        month = response.results[i]['DATE_END_SH'].substr(4, 2);
                                        day = response.results[i]['DATE_END_SH'].substr(6, 2);
                                        DATE_END_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        FILE_NAME = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['FILE_NAME'] + '</td>')
                                        t1 = $('<td style="width: 4%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 4%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 4%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 4%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="tamirat_table_report"></tr>')
                                        row.append(t4,ID_T, ID_UN, ID_TT, ID_TA, DATE_BEGIN_SH, DATE_END_SH, TIME_WORK_REAL, TIME_WORK_EQUAL, DISCRIPTION, ANGAM, CONFIR, FILE_NAME, ID_USER, ID_UN2, ID_TA2, ID_TT2,CONFIR2, ANGAM2, t3, t1, t2)
                                        $("#tamirat_table_report").append(row)
                                    }
                                }else{
                                    Swal.fire('موردی یافت نشد', '', 'info')
                                }
                            }


                        })
                    }
                },
                error:function(response){
                    if(response.message===undefined){
                        alert("مدرکی الصاق نشده")
                    }
                }
            });
            $('#myModal1').modal('hide');
        })
        $("#ta_report").on('click',function (event) {
            event.preventDefault();
            $('#flag').val('2')
            $('#ID_UN_REP').val('0')
            $('#ID_TT_REP').val('0')
            $('#ID_TA_REP').val('0')
            // $('#DATE_BEGIN_SH_REP').val('')
            // $('#DATE_END_SH_REP').val('')
            $('#CONFIR_REP').val('0')
            $('#ANGAM_REP').val('0')
            $("#tamirat_table_report").empty();
            $(".tainfo").hide()
            $(".tarep").fadeToggle(2000);
            // $.ajaxSetup({
            //     headers: {
            //         'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //     }
            // });
            // var _token = $("input[name='_token']").val();
            // $.ajax({
            //     url: '/tapr-total',
            //     method:'GET',
            //     success: function (response) {
            //         if(response.results.length>0){
            //             var day = ''
            //             var month = ''
            //             var year = ''
            //             var edit1 = ''
            //             var del2 = ''
            //             var detail1 = ''
            //             var select = ''
            //             var ID_T = ''
            //             var ID_USER = ''
            //             var ID_UN = ''
            //             var ID_UN2 = ''
            //             var ID_TT = ''
            //             var ID_TT2 = ''
            //             var ID_TA = ''
            //             var ID_TA2 = ''
            //             var TIME_WORK_REAL = ''
            //             var TIME_WORK_EQUAL = ''
            //             var DISCRIPTION = ''
            //             var ANGAM = ''
            //             var CONFIR = ''
            //             var ANGAM2 = ''
            //             var CONFIR2 = ''
            //             var DATE_BEGIN_SH = ''
            //             var DATE_END_SH = ''
            //             var FILE_NAME = ''
            //             var t1 = ''
            //             var t2 = ''
            //             var t3 = ''
            //             var t4 = ''
            //             var row = ''
            //             var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">واحد</td><td style="text-align: center">نوع تعمیرات</td><td style="text-align: center">شرکت تعمیرکار</td><td style="text-align: center">شروع تعمیرات</td><td style="text-align: center">پایان تعمیرات</td><td style="text-align: center">کارکرد واقعی</td><td style="text-align: center">کارکرد معادل</td><td style="text-align: center">تایید شد</td><td style="text-align: center">انجام شد</td><td>#</td><td>#</td><td>#</td></tr>')
            //             $("#tamirat_table_report").empty();
            //             $("#tamirat_table_report").append(th)
            //             for (var i = 0; i < response.results.length; i++) {
            //                 for (var j = 0; j < response.ID_UNS.length; j++) {
            //                     if (response.ID_UNS[j]['ID_UN'] == response.results[i]['ID_UN']) {
            //                         ID_UN = $('<td style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_UNS[j]['UNIT_NUMBER'] + '</td>');
            //                         ID_UN2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['ID_UN'] + '</td>');
            //                         break;
            //                     }
            //                 }
            //                 for (var j = 0; j < response.ID_TAS.length; j++) {
            //                     if (response.ID_TAS[j]['ID_TA'] == response.results[i]['ID_TA']) {
            //                         ID_TA = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TAS[j]['TAMIRKAR'] + '</td>');
            //                         ID_TA2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['ID_TA'] + '</td>');
            //                         break;
            //                     }
            //                 }
            //                 for (var j = 0; j < response.ID_TTS.length; j++) {
            //                     if (response.ID_TTS[j]['ID_TT'] == response.results[i]['ID_TT']) {
            //                         ID_TT = $('<td style="width: 14%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TTS[j]['TAMIRAT_TYPE'] + '</td>');
            //                         ID_TT2 = $('<td hidden style="width: 17%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['ID_TT'] + '</td>');
            //                         break;
            //                     }
            //                 }
            //                 for (var z = 0; z < response.ID_USERS.length; z++) {
            //                     if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
            //                         ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
            //                         break;
            //                     }
            //                 }
            //                 edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal1">ویرایش</button>').on('click',function () {
            //                     $('#ANGAM_EDIT').prop('checked', false);
            //                     $('#CONFIR_EDIT').prop('checked', false);
            //                     $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
            //                     $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(14)').text())
            //                     $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(16)').text())
            //                     $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(15)').text())
            //                     $('#DATE_BEGIN_SH_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
            //                     $('#DATE_END_SH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
            //                     $('#TIME_WORK_REAL_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
            //                     $('#TIME_WORK_EQUAL_EDIT').val($(this).closest('tr').find('td:eq(8)').text())
            //                     $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
            //                     if ($(this).closest('tr').find('td:eq(10)').text() == 1) {
            //                         $('#ANGAM_EDIT').prop('checked', true);
            //                     }
            //                     if ($(this).closest('tr').find('td:eq(11)').text() == 1) {
            //                         $('#CONFIR_EDIT').prop('checked', true);
            //                     }
            //                     if ($(this).closest('tr').find('td:eq(12)').text() != 'null') {
            //                         $('#FILE_NAME_EDIT').text($(this).closest('tr').find('td:eq(11)').text()).attr("href", "images/" + $(this).closest('tr').find('td:eq(12)').text())
            //                     } else {
            //                         $('#FILE_NAME_EDIT').text('فایل پیوست ندارد')
            //                     }
            //                 })
            //                 del2 = $('<button type="button" class="btn-sm border-danger del2" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 3000).on('click',function () {
            //                     var id_t = $(this).closest('tr').find('td:eq(1)').text();
            //                     var token = $("meta[name='csrf-token']").attr("content");
            //                     Swal.fire({
            //                         title: 'مایل به حذف این برنامه تعمیراتی هستید؟',
            //                         showDenyButton: true,
            //                         //showCancelButton: true,
            //                         cancelButtonText: `بازگشت`,
            //                         confirmButtonText: `انصراف از حذف`,
            //                         denyButtonText: 'حذف شود',
            //                     }).then((result) => {
            //                         /* Read more about isConfirmed, isDenied below */
            //                         if (result.isConfirmed) {
            //                             Swal.fire('رکورد انتخابی حذف نشد', '', 'info')
            //                         } else if (result.isDenied) {
            //
            //                             $.ajax({
            //                                 url: "/tapr-delete/" + id_t,
            //                                 type: 'DELETE',
            //                                 data: {
            //                                     "id": id_t,
            //                                     "_token": token,
            //                                 },
            //                                 success: function (response) {
            //
            //                                     if(response.perm==1){
            //                                         $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
            //                                         toastr.options = {
            //                                             "closeButton": true,
            //                                             "debug": false,
            //                                             "positionClass": "toast-top-right",
            //                                             "onclick": null,
            //                                             "showDuration": "300",
            //                                             "hideDuration": "1000",
            //                                             "timeOut": "3000",
            //                                             "extendedTimeOut": "1000",
            //                                             "showEasing": "swing",
            //                                             "hideEasing": "linear",
            //                                             "showMethod": "fadeIn",
            //                                             "hideMethod": "fadeOut"
            //                                         };
            //                                         toastr.error('برنامه تعمیراتی حذف گردید');
            //                                         $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
            //                                         Swal.fire('حذف شد', '', 'success');
            //                                     }else{
            //                                         Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
            //                                     }
            //                                 }
            //                             });
            //
            //                         }
            //                     })
            //                 })
            //                 detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button></td>').on('click', function (event) {
            //                     id_t = $(this).closest('tr').find('td:eq(1)').text();
            //                     event.preventDefault();
            //                     $.ajaxSetup({
            //                         headers: {
            //                             'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            //                         }
            //                     });
            //                     var _token = $("input[name='_token']").val();
            //                     $.ajax({
            //                         url: '/get-history-tamirat-prog/' + id_t,
            //                         method: 'GET',
            //                         success: function (response) {
            //                             var ID_S = ''
            //                             var ID_T = ''
            //                             var TIME_WORK = ''
            //                             var GHATAAT_NAME=''
            //                             var DAMAGE_PERCENT = ''
            //                             var DESCRIPTION = ''
            //                             var SERIYAL_NUMBER = ''
            //                             var TYPE_INSTAL = ''
            //                             var row = ''
            //                             var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>نوع قطعه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
            //                             $("#table_history").empty();
            //                             $("#table_history").append(th)
            //                             for (var i = 0; i < response.results.length; i++) {
            //                                 ID_S = $('<td hidden style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
            //                                 ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
            //                                 TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
            //                                 GHATAAT_NAME = $('<td style="width:25%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['GHATAAT_NAME'] + '</td>')
            //                                 DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
            //                                 TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
            //                                 if(response.results[i]['DISCRIPTION']!= null){
            //                                     DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
            //                                 }else{
            //                                     DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
            //                                 }
            //
            //                                 SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
            //                                 row = $('<tr class="table3"></tr>')
            //                                 row.append(SERIYAL_NUMBER,GHATAAT_NAME,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
            //                                 $("#table_history").append(row)
            //                             }
            //                         }
            //                     })
            //                 })
            //                 select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
            //                     $("tr.tamirat_table_report").css("background-color", "white");
            //                     $("tr.tamirat_table_report").css("color", "black");
            //                     $(this).closest('tr.tamirat_table_report').css( "background-color","RosyBrown");
            //                     $(this).closest('tr.tamirat_table_report').css( "color", "white" );
            //                 })
            //                 if(response.results[i]['FILE_NAME']=="فایل پیوست ندارد"){
            //                     ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a style="visibility: hidden" href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
            //                 }else{
            //                     ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
            //                 }
            //                 TIME_WORK_REAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_REAL'] + '</td>')
            //                 TIME_WORK_EQUAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_EQUAL'] + '</td>')
            //                 DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
            //                 ANGAM = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ANGAM'] + '</td>')
            //                 CONFIR = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['CONFIR'] + '</td>')
            //                 if(response.results[i]['ANGAM']==1){
            //                     ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
            //                 }
            //                 if(response.results[i]['ANGAM']==2){
            //                     ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
            //                 }
            //                 if(response.results[i]['CONFIR']==1){
            //                     CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
            //                 }
            //                 if(response.results[i]['CONFIR']==2){
            //                     CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
            //                 }
            //                 year = response.results[i]['DATE_BEGIN_SH'].substr(0, 4);
            //                 month = response.results[i]['DATE_BEGIN_SH'].substr(4, 2);
            //                 day = response.results[i]['DATE_BEGIN_SH'].substr(6, 2);
            //                 DATE_BEGIN_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
            //                 year = response.results[i]['DATE_END_SH'].substr(0, 4);
            //                 month = response.results[i]['DATE_END_SH'].substr(4, 2);
            //                 day = response.results[i]['DATE_END_SH'].substr(6, 2);
            //                 DATE_END_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
            //                 FILE_NAME = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['FILE_NAME'] + '</td>')
            //                 t1 = $('<td style="width: 4%"></td>')
            //                 t1.append(edit1)
            //                 t2 = $('<td style="width: 4%"></td>')
            //                 t2.append(del2)
            //                 t3 = $('<td style="width: 4%"></td>')
            //                 t3.append(detail1)
            //                 t4 = $('<td style="width: 4%"></td>')
            //                 t4.append(select)
            //                 row = $('<tr class="tamirat_table_report"></tr>')
            //                 row.append(t4,ID_T, ID_UN, ID_TT, ID_TA, DATE_BEGIN_SH, DATE_END_SH, TIME_WORK_REAL, TIME_WORK_EQUAL, DISCRIPTION, ANGAM, CONFIR, FILE_NAME, ID_USER, ID_UN2, ID_TA2, ID_TT2,CONFIR2, ANGAM2, t3, t1, t2)
            //                 $("#tamirat_table_report").append(row)
            //             }
            //         }else{
            //             Swal.fire('موردی یافت نشد', '', 'info')
            //         }
            //     }
            // })

        })
        $("#tprep_form").on('submit', function (event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tapr-rep",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.results.length>0){
                        var day = ''
                        var month = ''
                        var year = ''
                        var edit1 = ''
                        var del2 = ''
                        var detail1 = ''
                        var select = ''
                        var ID_T = ''
                        var ID_USER = ''
                        var ID_UN = ''
                        var ID_UN2 = ''
                        var ID_TT = ''
                        var ID_TT2 = ''
                        var ID_TA = ''
                        var ID_TA2 = ''
                        var TIME_WORK_REAL = ''
                        var TIME_WORK_EQUAL = ''
                        var DISCRIPTION = ''
                        var ANGAM = ''
                        var CONFIR = ''
                        var ANGAM2 = ''
                        var CONFIR2 = ''
                        var DATE_BEGIN_SH = ''
                        var DATE_END_SH = ''
                        var FILE_NAME = ''
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">واحد</td><td style="text-align: center">نوع تعمیرات</td><td style="text-align: center">شرکت تعمیرکار</td><td style="text-align: center">شروع تعمیرات</td><td style="text-align: center">پایان تعمیرات</td><td style="text-align: center">کارکرد واقعی</td><td style="text-align: center">کارکرد معادل</td><td style="text-align: center">تایید شد</td><td style="text-align: center">انجام شد</td><td>#</td><td>#</td><td>#</td></tr>')
                        $("#tamirat_table_report").empty();
                        $("#tamirat_table_report").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            for (var j = 0; j < response.ID_UNS.length; j++) {
                                if (response.ID_UNS[j]['ID_UN'] == response.results[i]['ID_UN']) {
                                    ID_UN = $('<td style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_UNS[j]['UNIT_NUMBER'] + '</td>');
                                    ID_UN2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_UNS[j]['ID_UN'] + '</td>');
                                    break;
                                }
                            }
                            for (var j = 0; j < response.ID_TAS.length; j++) {
                                if (response.ID_TAS[j]['ID_TA'] == response.results[i]['ID_TA']) {
                                    ID_TA = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TAS[j]['TAMIRKAR'] + '</td>');
                                    ID_TA2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TAS[j]['ID_TA'] + '</td>');
                                    break;
                                }
                            }
                            for (var j = 0; j < response.ID_TTS.length; j++) {
                                if (response.ID_TTS[j]['ID_TT'] == response.results[i]['ID_TT']) {
                                    ID_TT = $('<td style="width: 14%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TTS[j]['TAMIRAT_TYPE'] + '</td>');
                                    ID_TT2 = $('<td hidden style="width: 17%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TTS[j]['ID_TT'] + '</td>');
                                    break;
                                }
                            }
                            for (var z = 0; z < response.ID_USERS.length; z++) {
                                if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                    ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal1">ویرایش</button>').on('click',function () {
                                $('#ANGAM_EDIT').prop('checked', false);
                                $('#CONFIR_EDIT').prop('checked', false);
                                $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(14)').text())
                                $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(16)').text())
                                $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(15)').text())
                                $('#DATE_BEGIN_SH_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                $('#DATE_END_SH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#TIME_WORK_REAL_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                $('#TIME_WORK_EQUAL_EDIT').val($(this).closest('tr').find('td:eq(8)').text())
                                $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                if ($(this).closest('tr').find('td:eq(10)').text() == 1) {
                                    $('#ANGAM_EDIT').prop('checked', true);
                                }
                                if ($(this).closest('tr').find('td:eq(11)').text() == 1) {
                                    $('#CONFIR_EDIT').prop('checked', true);
                                }
                                if ($(this).closest('tr').find('td:eq(12)').text() != 'null') {
                                    $('#FILE_NAME_EDIT').text($(this).closest('tr').find('td:eq(11)').text()).attr("href", "images/" + $(this).closest('tr').find('td:eq(12)').text())
                                } else {
                                    $('#FILE_NAME_EDIT').text('فایل پیوست ندارد')
                                }
                            })
                            del2 = $('<button type="button" class="btn-sm border-danger del2" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 3000).on('click',function () {
                                var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این برنامه تعمیراتی هستید؟',
                                    showDenyButton: true,
                                    //showCancelButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    /* Read more about isConfirmed, isDenied below */
                                    if (result.isConfirmed) {
                                        Swal.fire('رکورد انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/tapr-delete/" + id_t,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_t,
                                                "_token": token,
                                            },
                                            success: function (response) {

                                                if(response.perm==1){
                                                    $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
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
                                                    toastr.error('برنامه تعمیراتی حذف گردید');
                                                    $('#' + (Number(id_t) + 3000).toString()).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                            detail1 = $('<td><button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;border-right:1px dotted black;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button></td>').on('click', function (event) {
                                id_t = $(this).closest('tr').find('td:eq(1)').text();
                                event.preventDefault();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/get-history-tamirat-prog/' + id_t,
                                    method: 'GET',
                                    success: function (response) {
                                        var ID_S = ''
                                        var ID_T = ''
                                        var TIME_WORK = ''
                                        var GHATAAT_NAME=''
                                        var DAMAGE_PERCENT = ''
                                        var DESCRIPTION = ''
                                        var SERIYAL_NUMBER = ''
                                        var TYPE_INSTAL = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>شماره سریال</td><td>نوع قطعه</td><td style="text-align: center">کارکرد</td><td style="text-align: right">میزان خرابی</td><td style="text-align: right">وضعیت نصب</td><td style="text-align: right">توضیحات</td></tr>')
                                        $("#table_history").empty();
                                        $("#table_history").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            ID_S = $('<td hidden style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_S'] + '</td>')
                                            ID_T = $('<td hidden style="text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['ID_T'] + '</td>')
                                            TIME_WORK = $('<td style="width:10%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['TIME_WORK'] + '</td>')
                                            GHATAAT_NAME = $('<td style="width:25%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                            DAMAGE_PERCENT = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DAMAGE_PERCENT'] + '</td>')
                                            TYPE_INSTAL = $('<td style="width:15%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['TYPE_INSTAL'] + '</td>')
                                            if(response.results[i]['DISCRIPTION']!= null){
                                                DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">' + response.results[i]['DISCRIPTION'] + '</td>')
                                            }else{
                                                DESCRIPTION = $('<td style="width:20%;text-align: right;font-family: Tahoma;font-size: x-small">----</td>')
                                            }

                                            SERIYAL_NUMBER = $('<td style="width:15%;text-align: center;font-family: Tahoma;font-size: x-small">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            row = $('<tr class="table3"></tr>')
                                            row.append(SERIYAL_NUMBER,GHATAAT_NAME,ID_S,TIME_WORK,DAMAGE_PERCENT,TYPE_INSTAL,DESCRIPTION,ID_T)
                                            $("#table_history").append(row)
                                        }
                                    }
                                })
                            })
                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                $("tr.tamirat_table_report").css("background-color", "white");
                                $("tr.tamirat_table_report").css("color", "black");
                                $(this).closest('tr.tamirat_table_report').css( "background-color","RosyBrown");
                                $(this).closest('tr.tamirat_table_report').css( "color", "white" );
                            })
                            if(response.results[i]['FILE_NAME']=="فایل پیوست ندارد"){
                                ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a style="visibility: hidden" href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                            }else{
                                ID_T = $('<td class="id_gr" style="width: 8%;font-family: Tahoma;font-size: 10px;text-align: center"><a href='+'images/'+response.results[i]['FILE_NAME']+'><img src="attachment.jpg" class="rounded-circle" alt="Cinque Terre"></a>' + response.results[i]['ID_T'] + '</td>')
                            }
                            TIME_WORK_REAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_REAL'] + '</td>')
                            TIME_WORK_EQUAL = $('<td style="width: 6%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['TIME_WORK_EQUAL'] + '</td>')
                            DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                            ANGAM = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ANGAM'] + '</td>')
                            CONFIR = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['CONFIR'] + '</td>')
                            if(response.results[i]['ANGAM']==1){
                                ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if(response.results[i]['ANGAM']==2){
                                ANGAM2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if(response.results[i]['CONFIR']==1){
                                CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            if(response.results[i]['CONFIR']==2){
                                CONFIR2 = $('<td  style="width: 5%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                            }
                            year = response.results[i]['DATE_BEGIN_SH'].substr(0, 4);
                            month = response.results[i]['DATE_BEGIN_SH'].substr(4, 2);
                            day = response.results[i]['DATE_BEGIN_SH'].substr(6, 2);
                            DATE_BEGIN_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                            year = response.results[i]['DATE_END_SH'].substr(0, 4);
                            month = response.results[i]['DATE_END_SH'].substr(4, 2);
                            day = response.results[i]['DATE_END_SH'].substr(6, 2);
                            DATE_END_SH = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                            FILE_NAME = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['FILE_NAME'] + '</td>')
                            t1 = $('<td style="width: 4%"></td>')
                            t1.append(edit1)
                            t2 = $('<td style="width: 4%"></td>')
                            t2.append(del2)
                            t3 = $('<td style="width: 4%"></td>')
                            t3.append(detail1)
                            t4 = $('<td style="width: 4%"></td>')
                            t4.append(select)
                            row = $('<tr class="tamirat_table_report"></tr>')
                            row.append(t4,ID_T, ID_UN, ID_TT, ID_TA, DATE_BEGIN_SH, DATE_END_SH, TIME_WORK_REAL, TIME_WORK_EQUAL, DISCRIPTION, ANGAM, CONFIR, FILE_NAME, ID_USER, ID_UN2, ID_TA2, ID_TT2,CONFIR2, ANGAM2, t3, t1, t2)
                            $("#tamirat_table_report").append(row)
                        }
                    }else{
                        Swal.fire('موردی یافت نشد', '', 'info')
                    }
                }


            });
        })
    })
</script>
<!-- List of content -->
{{----}}
    <div class="container mt-1" style="direction: ltr">
        <div class="row tainfo" style="display: none;width: 120%;margin-left: 100px">
            <div class="col-1"></div>
            <div class="col-8 bg-info  pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan"> ورود اطلاعات برنامه تعمیرات</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row tainfo " style="display: none;width: 120%;margin-left: -115px;direction: rtl">
            <div class="col-1  mt-3"></div>
            <div class="col-8  mt-1" style="background-color:rgba(47,47,119,0.5);border-radius: 10px;height: 420px ">
                <form method="post" encType="multipart/form-data" id="tp_form" action={{route('tp.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_T" name="ID_T" >
                            <input type="hidden" class="form-control" id="flag">
                        </div>
                        <div class="col-3 mt-2">
                            <select hidden class="form-control isclicked1" name="ID_NN" id="ID_NN" style="width: 100%;font-family: Tahoma;font-size:small;display: inline">
                                @foreach($anns as $ann)
                                    <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        {{--<div class="col-3">--}}
                            {{--<select class="form-control isclicked1" name="ID_NN" id="ID_NN" style="width: 100%;font-family: Tahoma;font-size:x-small;display: inline">--}}
                                {{--@foreach($anns as $ann)--}}
                                    {{--<option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>--}}
                                {{--@endforeach--}}
                            {{--</select>--}}
                        {{--</div>--}}

                        <div class="col-3">
                            <select class="form-control isclicked1" name="ID_UN" id="ID_UN" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value=""><p style="font-size: xx-small">واحد</p></option>
                                @foreach($auns as $aun)
                                    <option value="{{$aun->ID_UN}}">{{$aun->UNIT_NUMBER}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-control isclicked1" name="ID_TT" id="ID_TT" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">نوع تعمیرات</option>
                                @foreach($atts as $att)
                                    <option value="{{$att->ID_TT}}">{{$att->TAMIRAT_TYPE}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <select class="form-control isclicked1" name="ID_TA" id="ID_TA" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">انتخاب پیمانکار</option>
                                @foreach($ats as $at)
                                    <option value="{{$at->ID_TA }}">{{$at->TAMIRKAR}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br><br>
                        <div class="field row" >
                            <div class="col-3" style="text-align: center"><p style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px">تاریخ شروع تعمیرات</p></div>
                            <div class="col-3" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_BEGIN_SH"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGIN_SH"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>
                            <div class="col-3" style="text-align: center"><label for="date_shamsi2" style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px"> تاریخ پایان تعمیرات:</label></div>
                            <div class="col-3" style="text-align: center"><input type="text" maxlength="10" class="form-control" id="DATE_END_SH"  data-toggle="tooltip" data-placement="right"  name="DATE_END_SH" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" required title="تاریخ پایان تعمیرات"></div>
                        </div>
                    </div>
                    <br>
                    <div class="field row">
                            <div class="col-3" style="text-align: center;"> <input style="font-size: 10px;font-family: Tahoma" type="number" max="9999999" class="form-control" id="TIME_WORK_REAL"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_REAL" placeholder="کارکرد واقعی" style="font-family: Tahoma;font-size: small;width: 60%;" required title="کارکرد واقعی"></div>
                            <div class="col-3" style="text-align: center;"><input style="font-size: 10px;font-family: Tahoma" type="number" max="9999999" class="form-control" id="TIME_WORK_EQUAL"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_EQUAL" placeholder="کارکرد معادل" style="direction: rtl;font-family: Tahoma;font-size: small;width: 60%" required title="کارکرد معادل"></div>

                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">تایید شد</p></div>
                        <div class="col-1" style="text-align: left">
                            <input style="font-size: 4px" class="form-control" type="checkbox" id="CONFIR" name="CONFIR" value="1">
                        </div>
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">انجام شد</p></div>
                        <div class="col-1" style="text-align: left">
                            <input style="font-size: 4px" class="form-control" type="checkbox" id="ANGAM" name="ANGAM" value="1">
                        </div>

                        <div class="col-2"><p style="font-size: 12px;font-family: Tahoma;color: #fdfdfe">الصاق فایل</p></div>
                        <div class="col-2"><input style="color: #fdfdfe;font-size: smaller" type="file" id="select_file"  placeholder="الصاق فایل" name="select_file"></div>
                    </div>

                    <div class="field row mt-0">
                            <div class="col-8" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" title="توضیحات"></div>
                            <div class="col-4" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
                        </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:168px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 163px;overflow-y: scroll">
                                    <table id="tamirat_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام شرکت</td>
                                            <td>#</td>
                                            <td>#</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                                    <div class="toast-body"><p id="mytoast5" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3  mt-3">.</div>
        </div>
        <div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
            <div class="modal-dialog modal-md" style="margin-top: 25px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح اطلاعات تعمیرات</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray;height: 370px ">
                        <form method="post" encType="multipart/form-data" id="tainfoedit" action="{{route('tp.edit')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div>
                                    <input type="hidden" class="form-control" id="ID_T_EDIT" name="ID_T_EDIT" >
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-3">
                                    <select class="form-control isclicked1" name="ID_NN_EDIT" id="ID_NN_EDIT" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                        @foreach($anns as $ann)
                                            <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3 mr-5">
                                    <select class="form-control isclicked1" name="ID_UN_EDIT" id="ID_UN_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                        <option value=""><p style="font-size: xx-small">مربوط به واحد</p></option>
                                        @foreach($auns as $aun)
                                            <option value="{{$aun->ID_UN}}">{{$aun->UNIT_NUMBER}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-3 ">
                                    <select class="form-control isclicked1" name="ID_TT_EDIT" id="ID_TT_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                        <option value="">نوع تعمیرات</option>
                                        @foreach($atts as $att)
                                            <option value="{{$att->ID_TT}}">{{$att->TAMIRAT_TYPE}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3" style="margin-right: 100px">
                                    <select class="form-control isclicked1" name="ID_TA_EDIT" id="ID_TA_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                        <option value="">انتخاب پیمانکار</option>
                                        @foreach($ats as $at)
                                            <option value="{{$at->ID_TA }}">{{$at->TAMIRKAR}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row mt-0">
                                <div class="field row" >
                                    <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ شروع تعمیرات</p></div>
                                    <div class="col-3" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_BEGIN_SH_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGIN_SH_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>
                                    <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ پایان تعمیرات</p></div>
                                    <div class="col-3" style="text-align: center"><input type="text" maxlength="10" class="form-control" id="DATE_END_SH_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_END_SH_EDIT" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" required title="تاریخ پایان تعمیرات"></div>
                                </div>
                            </div>
                            <br>
                            <div class="field row">
                                <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کارکرد واقعی</p></div>
                                <div class="col-4" style="text-align: center"> <input type="number" max="9999999" class="form-control" id="TIME_WORK_REAL_EDIT"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_REAL_EDIT" placeholder="کارکرد واقعی" style="font-family: Tahoma;font-size: small;width: 70%;" required title="کارکرد واقعی"></div>
                                <div class="col-6" style="text-align: center">
                                    <input style="color: #4e555b;font-size: smaller" type="file" id="select_file_edit" placeholder="الصاق فایل" name="select_file_edit">
                                </div>
                            </div>
                            <div class="field row">
                                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کارکرد معادل</p></div>
                                <div class="col-4" style="text-align: center"><input type="number" max="9999999" class="form-control" id="TIME_WORK_EQUAL_EDIT"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_EQUAL_EDIT" placeholder="کارکرد معادل" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="کارکرد معادل"></div>
                                <div class="col-6" style="text-align: center"><p id="FILE_NAME_EDIT" style="text-align: right;font-size: small;font-family: Tahoma"></p></div>
                            </div>
                            <br>
                            <div class="field row">
                                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma"></p></div>
                                <div class="col-1" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma">تایید شد</p></div>
                                <div class="col-2" style="text-align: left">
                                    <input style="font-size: 4px" class="form-control" type="checkbox" id="CONFIR_EDIT" name="CONFIR_EDIT" value="1">
                                </div>
                                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma"></p></div>
                                <div class="col-1" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma">انجام شد</p></div>
                                <div class="col-2" style="text-align: left">
                                    <input style="font-size: 4px" class="form-control" type="checkbox" id="ANGAM_EDIT" name="ANGAM_EDIT" value="1">
                                </div>
                            </div>
                            <div class="field row mt-0">
                                <div class="col-8" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION_EDIT"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION_EDIT" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" title="توضیحات"></div>
                                <div class="col-4" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
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
        <div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
            <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 450px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 600px " >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جزئیات برنامه تعمیراتی</p></div>
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
                    <div class="container"  style="margin: auto;background-color:white;width: 600px ;height: 280px;overflow-y: scroll">
                        <div class="row mt-3">
                            <div class="col">
                                <div class="row">
                                    <div class="col-6">
                                        <p style="font-family: Tahoma;font-size: smaller;color: black;font-weight: bold;">مربوط به واحد:</p>
                                    </div>
                                    <div class="col-6" style="text-align: right">
                                        <p id="ID_UN_D" style="font-family: Tahoma;font-size: smaller;color: black;color: #1c7430;font-weight: bold"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col" style="height:25px">
                                <div class="row">
                                    <div class="col-6">
                                        <p style="font-family: Tahoma;font-size: smaller;color: black;font-weight: bold;font-weight: bold">نوع تعمیرات:</p>
                                    </div>
                                    <div class="col-6" style="height:25px;text-align: right">
                                        <p style="font-family: Tahoma;font-size: small;color: black;text-align: right;color: #1c7430;font-weight: bold" id="ID_TT_D"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col" style="height:25px">
                                <div class="row">
                                    <div class="col-3" style="height:25px">
                                        <p style="font-family: Tahoma;font-size: xx-small;color: black;font-weight: bold;">نام شرکت تعمیر کننده:</p>
                                    </div>
                                    <div class="col-5" style="height:25px;text-align: right">
                                        <p style="font-family: Tahoma;font-size: xx-small;color: black;color:  #1c7430;font-weight: bold" id="ID_TA_D"></p>
                                    </div>
                                    <div class="col-2" style="height:25px">
                                        <p style="font-family: Tahoma;font-size: xx-small;color: black;font-weight: bold;">ثبت کننده:</p>
                                    </div>
                                    <div class="col-2" style="text-align: right">
                                        <p id="ID_USER_D" style="font-family: Tahoma;font-size: xx-small;color: black;color:  #1c7430;font-weight: bold;"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col" style="height:25px;text-align: right">
                                <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;font-weight: bold;">مشخصات تعمیرات:</p>
                            </div>
                        </div>
                        <div class="row" style="width: 100%">
                            <div class="col-7">
                                <div id="person_div" class="col" style="height:50px">
                                    <table id="person_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;border: 1px solid black;margin-right: 10px">
                                        <tr style="color: black">
                                            <td class="person">کد تعمیرات</td>
                                            <td class="person2"><p class="person3" id="ID_T_D"></p></td>
                                        </tr>
                                        <tr style="color: black">
                                            <td class="person">تاریخ شروع تعمیرات</td>
                                            <td class="person2"><p class="person3" id="DATE_BEGIN_SH_D"></p></td>
                                        </tr>
                                        <tr style="color: black">
                                            <td class="person">تاریخ پایان تعمیرات</td>
                                            <td class="person2"><p class="person3" id="DATE_END_SH_D"></p></td>
                                        </tr>
                                        <tr style="color: black">
                                            <td class="person">کارکرد واقعی</td>
                                            <td class="person2"><p class="person3" id="TIME_WORK_REAL_D"></p></td>
                                        </tr>
                                        <tr style="color: black">
                                            <td class="person">کارکرد معادل</td>
                                            <td class="person2"><p class="person3" id="TIME_WORK_EQUAL_D"></p></td>
                                        </tr>
                                        <tr style="color: black">
                                            <td class="person">فایل الصاقی</td>
                                            <td class="person2" style="direction: ltr"><a id="FILE_NAME_D"></a></td>

                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-5">
                                    <div class="row">
                                        <div class="col-3">
                                           <p style="font-family: Tahoma;font-size: small;">توضیحات:</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" style="word-wrap: break-word;height: 80px;font-family: Tahoma;font-size: smaller;direction: rtl;text-align: right">
                                            <p class="person3" id="DISCRIPTION_D"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="person_div" class="col" style="height:50px">
                                                <table id="person_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;border: 1px solid black;margin-right: 10px">
                                                    <tr style="color: black">
                                                        <td class="person">تایید شده</td>
                                                        {{--<p class="person3" id="CONFIR_D"></p>--}}
                                                        <td class="person2"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre" id="CONFIR_D2"></td>
                                                    </tr>
                                                    <tr style="color: black">
                                                        <td class="person">انجام شده</td>
                                                        {{--<p class="person3" id="ANGAM_D"></p>--}}
                                                        <td class="person2"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre" id="ANGAM_D2"></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-info" style="height: 20px;width:600px"></div>

                </div>
            </div>
        </div>
        <div class="row tarep" style="display: none;width: 120%;margin-left: 100px">
            <div class="col-1"></div>
            <div class="col-8 bg-info  pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan"> گزارش گیری از اطلاعات تعمیرات برنامه ریزی شده</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row tarep" style="display: none;;width: 120%;margin-left: -115px;direction: rtl">
            <div class="col-1  mt-3"></div>
            <div class="col-8  mt-1" style="background-color:rgba(134,179,223,0.5);border-radius: 10px;height: 420px ">
                <form method="post" encType="multipart/form-data" id="tprep_form" action={{route('tp.store')}}>
                    {{csrf_field()}}
                    <div hidden class="row">
                        <div class="col-3 mt-2">
                            <select class="form-control isclicked1" name="ID_NN_REP" id="ID_NN_REP" style="width: 100%;font-family: Tahoma;font-size:small;display: inline">
                                @foreach($anns as $ann)
                                    <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3">
                            <select class="form-control isclicked1" name="ID_UN_REP" id="ID_UN_REP" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="0"><p style="font-size: xx-small">واحد</p></option>
                                @foreach($auns as $aun)
                                    <option value="{{$aun->ID_UN}}">{{$aun->UNIT_NUMBER}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-control isclicked1" name="ID_TT_REP" id="ID_TT_REP" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="0">نوع تعمیرات</option>
                                @foreach($atts as $att)
                                    <option value="{{$att->ID_TT}}">{{$att->TAMIRAT_TYPE}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-5">
                            <select class="form-control isclicked1" name="ID_TA_REP" id="ID_TA_REP" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="0">انتخاب پیمانکار</option>
                                @foreach($ats as $at)
                                    <option value="{{$at->ID_TA }}">{{$at->TAMIRKAR}}</option>
                                @endforeach
                            </select>
                        </div>
                        <br><br>
                        {{--<div class="field row" >--}}
                            {{--<div class="col-3" style="text-align: center"><p style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px">تاریخ شروع تعمیرات</p></div>--}}
                            {{--<div class="col-3" style="text-align: center"> <input type="text" maxlength="20" class="form-control" id="DATE_BEGIN_SH_REP"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGIN_SH_REP"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>--}}
                            {{--<div class="col-3" style="text-align: center"><label for="date_shamsi2" style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px"> تاریخ پایان تعمیرات:</label></div>--}}
                            {{--<div class="col-3" style="text-align: center"><input type="text" maxlength="20" class="form-control" id="DATE_END_SH_REP"  data-toggle="tooltip" data-placement="right"  name="DATE_END_SH_REP" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" required title="تاریخ پایان تعمیرات"></div>--}}
                        {{--</div>--}}
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">وضعیت انجام تعمیرات</p></div>
                        <div class="col-3" style="text-align: left">
                            <select class="form-control isclicked1" name="ANGAM_REP" id="ANGAM_REP" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="0">انتخاب</option>
                                <option value="1">تعمیرات انجام شده</option>
                                <option value="2">تعمیرات انجام نشده</option>
                            </select>
                        </div>
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">وضعیت تایید تعمیرات</p></div>
                        <div class="col-3" style="text-align: left">
                            <select class="form-control isclicked1" name="CONFIR_REP" id="CONFIR_REP" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                                <option value="0">انتخاب</option>
                                <option value="1">تعمیرات تایید شده</option>
                                <option value="2">تعمیرات تایید نشده</option>
                            </select>
                        </div>
                            <div class="col-2" style="text-align: right">
                                <button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >جستجو </button>
                            </div>

                    </div>


                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:258px;direction: rtl;margin-top: 12px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 253px;overflow-y: scroll">
                                    <table id="tamirat_table_report" class="table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام شرکت</td>
                                            <td>#</td>
                                            <td>#</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                                    <div class="toast-body"><p id="mytoast5" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-3  mt-3">.</div>
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
    </div>



@endsection

