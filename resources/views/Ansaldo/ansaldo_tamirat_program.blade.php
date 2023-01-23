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
    <div class="container mt-1" style="direction: ltr">
        @include('Ansaldo.AnsaldoMaintenanceProgComponents.component01')
        @include('Ansaldo.AnsaldoMaintenanceProgComponents.component02')
        @include('Ansaldo.AnsaldoMaintenanceProgComponents.component03')
        @include('Ansaldo.AnsaldoMaintenanceProgComponents.component04')
        @include('Ansaldo.AnsaldoMaintenanceProgComponents.component05')
        @include('Ansaldo.AnsaldoMaintenanceProgComponents.component06')
    </div>
@endsection

