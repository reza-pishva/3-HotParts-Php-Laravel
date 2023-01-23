@extends('layouts.ansaldo_layouts.app_in_program')
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
            $("#DATE_SHAMSI2").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_BEGIN1_EDIT").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_SHAMSI_EDIT").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#DATE_SHAMSI2_EDIT").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#add_send").on('click',function (event) {
                $('#myModal1').modal('show');
            })
            $("#add_recieve").on('click',function (event) {
                $('#RESV').prop("checked", false);
                $('#DATE_SHAMSI2').val('')
                $('#myModal2').modal('show');
            })
            $("#DATE_SHAMSI2").on('click',function (event) {
                $('#DATE_SHAMSI2').css('color','black');
            
            })
            $("#DATE_BEGIN1").prop('readonly', true)
            $("#DATE_BEGINR").prop('readonly', true)
            $("#DATE_ENDR").prop('readonly', true)
            $("#DATE_SHAMSI").prop('readonly', true)
            //$("#DATE_SHAMSI2").prop('readonly', true)
            $("#DATE_BEGIN1_EDIT").prop('readonly', true)
            $("#DATE_SHAMSI_EDIT").prop('readonly', true)
            //$("#DATE_SHAMSI2_EDIT").prop('readonly', true)

            $("#tpi_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/tain-store",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                            $('#ID_T').val('')
                            $('#ID_TG').val('')
                            $('#ID_BA').val('')
                            $('#GROUP_COUNT').val('')
                            $('#SHOMAREH_GHARAR').val('')
                            $('#DISCRIPTION').val('')
                            $("#ID_T_SUB2").text('');
                            $('#myModal1').modal('hide');
                            toastr.success("ورود به انبار موفقیت ذخیره گردید", "", {
                                "timeOut": "5000",
                                "extendedTImeout": "0"
                            });
                            $.ajax({
                                url: '/tain-onlyone',
                                method: 'GET',
                                success: function (response) {
                                    $("#add_recieve").hide();
                                    $("#description2").text('');
                                    $("#ID_T_SUB2").text('');
                                    $("#table2").empty();
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var detail2 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var select = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var ID_TG = ''
                                    var ID_TG2 = ''
                                    var ID_BA = ''
                                    var ID_BA2 = ''
                                    var GHATAAT_DAMAGE = ''
                                    var GROUP_COUNT=''
                                    var DATE_BEGIN1 = ''
                                    var DISCRIPTION = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">وضعیت قطعات</td><td style="text-align: center">تاریخ ارسال</td><td style="text-align: center">تعداد قطعات</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table1").empty();
                                    $("#table1").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_TGS.length; j++) {
                                            if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                                ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                                ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                                break;
                                            }
                                        }
                                        for (var z = 0; z < response.ID_USERS.length; z++) {
                                            if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                                ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click',function () {
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#GHATAAT_DAMAGE_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                            $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DATE_SHAMSI_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click',function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");
                                            Swal.fire({
                                                title: 'مایل به حذف این این برنامه ورود به انبار هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {

                                                    Swal.fire('برنامه ورود به انبار حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/tain-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            if(response.rec_no>0){
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
                                                                toastr.error('امکان حذف نیست');
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'هشدار',
                                                                    text: 'به علت ثبت درخواست خروج قطعه برای این برنامه امکان حذف وجود ندارد',
                                                                })
                                                            }
                                                            else{
                                                                $('#' + (Number(id_t) + 2000)).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }


                                                        }
                                                    });

                                                }
                                            })

                                        })
                                        detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-anbar-prog2/' + id_t,
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
                                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $("#add_recieve").show()
                                            event.preventDefault();
                                            $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                            var id_t=$(this).closest('tr').find('td:eq(1)').text()
                                            $("tr.table1").css("background-color", "white");
                                            $("tr.table1").css("color", "black");
                                            $(this).closest('tr.table1').css( "background-color","#66CDAA");
                                            $(this).closest('tr.table1').css( "color", "white" );
                                            $('#ID_T_SUB2').val($(this).closest('tr').find('td:eq(1)').text())
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/resvs_for_out/' + id_t,
                                                method:'GET',
                                                success: function (response) {
                                                    var select=''
                                                    var day = ''
                                                    var month = ''
                                                    var year = ''
                                                    var edit1 = ''
                                                    var del2 = ''
                                                    var detail1 = ''
                                                    var ID_SUB = ''
                                                    var ID_SUB2 = ''
                                                    var ID_T = ''
                                                    var ID_USER = ''
                                                    var RESV = ''
                                                    var RESV2 = ''
                                                    var COUNT_GH = ''
                                                    var DATE_SHAMSI = ''
                                                    var t1 = ''
                                                    var t2 = ''
                                                    var t3 = ''
                                                    var t4 = ''
                                                    var row = ''
                                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>کد خروج</td><td style="text-align: center">وضعیت خروج</td><td style="text-align: center">تعداد خارج شده</td><td style="text-align: center">تاریخ خروج</td><td>#</td><td>#</td><td>#</td></tr>')
                                                    $("#table2").empty();
                                                    $("#table2").append(th)
                                                    for (var i = 0; i < response.results.length; i++) {
                                                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                            if ($(this).closest('tr').find('td:eq(4)').text() == 1) {
                                                                $('#RESV_EDIT').prop('checked', true);
                                                            }
                                                            if ($(this).closest('tr').find('td:eq(4)').text() == 2) {
                                                                $('#RESV_EDIT').prop('checked', false);
                                                            }
                                                            $('#ID_SUB_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                                            $('#ID_T_SUB2_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                            $('#COUNT_GH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                                            if ($(this).closest('tr').find('td:eq(7)').text() == 'بدون تاریخ') {
                                                                $('#DATE_SHAMSI2_EDIT').val('')
                                                            }else{
                                                                $('#DATE_SHAMSI2_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                            }
                                                        })
                                                        select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                            $("tr.table2").css("background-color", "white");
                                                            $("tr.table2").css("color", "black");
                                                            $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                            $(this).closest('tr.table2').css( "color", "white" );
                                                        })
                                                        del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_SUB'] + 3000).on('click', function () {
                                                            var id_sub = $(this).closest('tr').find('td:eq(1)').text();
                                                            var token = $("meta[name='csrf-token']").attr("content");
                                                            Swal.fire({
                                                                title: 'مایل به حذف این این برنامه خروج از انبار هستید؟',
                                                                showDenyButton: true,
                                                                cancelButtonText: `بازگشت`,
                                                                confirmButtonText: `انصراف از حذف`,
                                                                denyButtonText: 'حذف شود',
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    Swal.fire('برنامه خروج از انبار انتخابی حذف نشد', '', 'info')
                                                                } else if (result.isDenied) {
                                                                    $.ajax({
                                                                        url: "/taout-delete/" + id_sub+"/"+id_t,
                                                                        type: 'DELETE',
                                                                        data: {
                                                                            "id": id_sub,
                                                                            "_token": token,
                                                                        },
                                                                        success: function (response) {
                                                                            if(response.n==0){
                                                                                $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
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
                                                                                toastr.error('برنامه انبار حذف گردید');
                                                                                $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
                                                                                Swal.fire('حذف شد', '', 'success');
                                                                            }else{
                                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                            }
                                                                        }
                                                                    });
                                                                }
                                                            })

                                                        })
                                                        detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                                            event.preventDefault();
                                                            $.ajaxSetup({
                                                                headers: {
                                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                                }
                                                            });
                                                            var _token = $("input[name='_token']").val();
                                                            $.ajax({
                                                                url: '/get-history-anbar-prog/' + id_t,
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
                                                        ID_SUB2 = $('<td style="width:5%;text-align: center">' + response.results[i]['ID_SUB'] + '</td>')
                                                        ID_T = $('<td  hidden style="width: 40%;text-align: right">' + response.results[i]['ID_T'] + '</td>')
                                                        ID_USER = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ID_USER'] + '</td>')
                                                        RESV = $('<td hidden style="width: 3%;text-align: right">' + response.results[i]['RESV'] + '</td>')
                                                        if (response.results[i]['RESV'] == 1) {
                                                            RESV2 = $('<td style="width: 15%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                                        }
                                                        if (response.results[i]['RESV'] == 2) {
                                                            RESV2 = $('<td style="width: 8%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                                        }


                                                        year = response.results[i]['DATE_SHAMSI2'].substr(0, 4);
                                                        month = response.results[i]['DATE_SHAMSI2'].substr(4, 2);
                                                        day = response.results[i]['DATE_SHAMSI2'].substr(6, 2);
                                                        if (response.results[i]['DATE_SHAMSI2'] == '---') {
                                                            DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                                        }else{
                                                            DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                                        }

                                                        COUNT_GH = $('<td style="width: 15%;text-align: center;border-right:1px dotted black">' + response.results[i]['COUNT_GH'] + '</td>')
                                                        t1 = $('<td style="width: 8%"></td>')
                                                        t1.append(edit1)
                                                        t2 = $('<td style="width: 8%"></td>')
                                                        t2.append(del2)
                                                        t3 = $('<td style="width: 8%"></td>')
                                                        t3.append(detail1)
                                                        t4 = $('<td style="width: 5%"></td>')
                                                        t4.append(select)
                                                        row = $('<tr class="table2"></tr>')
                                                        row.append(t4,ID_SUB2, ID_T, ID_USER, RESV, RESV2, COUNT_GH, DATE_SHAMSI, t3, t1, t2)
                                                        $("#table2").append(row)
                                                    }
                                                }
                                            })
                                        })
                                        ID_T = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                        GHATAAT_DAMAGE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GHATAAT_DAMAGE'] + '</td>')
                                        GROUP_COUNT = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        if(response.results[i]['DATE_SHAMSI']=="---"){
                                            DATE_BEGIN1 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                        }else{
                                            year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                            month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                            day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                            DATE_BEGIN1 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        }

                                        t1 = $('<td style="width: 4%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 4%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 4%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 4%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="table1"></tr>')

                                        row.append(t4,ID_T,ID_TG,GHATAAT_DAMAGE,DATE_BEGIN1, DISCRIPTION,GROUP_COUNT,ID_TG2,t1,t3,t2)
                                        $("#table1").append(row)
                                    }
                                }
                            })

                    },
                    error:function(response){
                        if(response.message===undefined){
                            alert("مدرکی الصاق نشده")
                        }
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
                    url: "/tain-rep3",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#add_recieve").hide();
                        $("#description2").text('');
                        $("#ID_T_SUB2").text('');
                        $("#table2").empty();
                        var day = ''
                        var month = ''
                        var year = ''
                        var edit1 = ''
                        var detail2 = ''
                        var del2 = ''
                        var detail1 = ''
                        var select = ''
                        var ID_T = ''
                        var ID_USER = ''
                        var ID_TG = ''
                        var ID_TG2 = ''
                        var ID_BA = ''
                        var ID_BA2 = ''
                        var GHATAAT_DAMAGE = ''
                        var GROUP_COUNT=''
                        var DATE_BEGIN1 = ''
                        var DISCRIPTION = ''
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">وضعیت قطعات</td><td style="text-align: center">تاریخ ارسال</td><td style="text-align: center">تعداد قطعات</td><td>#</td><td>#</td><td>#</td></tr>')
                        $("#table1").empty();
                        $("#table1").append(th)
                        var id_t_repeat=0;
                        for (var i = 0; i < response.results.length; i++) {
                            if(response.results[i]['ID_T']==id_t_repeat){
                                continue
                            }else{
                                id_t_repeat=response.results[i]['ID_T']
                            }
                            for (var j = 0; j < response.ID_TGS.length; j++) {
                                if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                    ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                    ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                    break;
                                }
                            }
                            for (var z = 0; z < response.ID_USERS.length; z++) {
                                if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                    ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click',function () {
                                $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                $('#GHATAAT_DAMAGE_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                $('#DATE_SHAMSI_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                            })
                            del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click',function () {
                                var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این این برنامه ورود به انبار هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('برنامه ورود به انبار حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/tain-delete/" + id_t,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_t,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.rec_no>0){
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
                                                    toastr.error('امکان حذف نیست');
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'هشدار',
                                                        text: 'به علت ثبت درخواست خروج قطعه برای این برنامه امکان حذف وجود ندارد',
                                                    })
                                                }
                                                else{
                                                    $('#' + (Number(id_t) + 2000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }


                                            }
                                        });

                                    }
                                })

                            })
                            detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                id_t = $(this).closest('tr').find('td:eq(1)').text();
                                event.preventDefault();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/get-history-anbar-prog2/' + id_t,
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
                            select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                $("#add_recieve").show()
                                event.preventDefault();
                                $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                var id_t=$(this).closest('tr').find('td:eq(1)').text()
                                $("tr.table1").css("background-color", "white");
                                $("tr.table1").css("color", "black");
                                $(this).closest('tr.table1').css( "background-color","#66CDAA");
                                $(this).closest('tr.table1').css( "color", "white" );
                                $('#ID_T_SUB2').val($(this).closest('tr').find('td:eq(1)').text())
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/resvs_for_out/' + id_t,
                                    method:'GET',
                                    success: function (response) {
                                        var select=''
                                        var day = ''
                                        var month = ''
                                        var year = ''
                                        var edit1 = ''
                                        var del2 = ''
                                        var detail1 = ''
                                        var ID_SUB = ''
                                        var ID_SUB2 = ''
                                        var ID_T = ''
                                        var ID_USER = ''
                                        var RESV = ''
                                        var RESV2 = ''
                                        var COUNT_GH = ''
                                        var DATE_SHAMSI = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var t4 = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>کد خروج</td><td style="text-align: center">وضعیت خروج</td><td style="text-align: center">تعداد خارج شده</td><td style="text-align: center">تاریخ خروج</td><td>#</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(4)').text() == 1) {
                                                    $('#RESV_EDIT').prop('checked', true);
                                                }
                                                if ($(this).closest('tr').find('td:eq(4)').text() == 2) {
                                                    $('#RESV_EDIT').prop('checked', false);
                                                }
                                                $('#ID_SUB_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                                $('#ID_T_SUB2_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#COUNT_GH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                                if ($(this).closest('tr').find('td:eq(7)').text() == 'بدون تاریخ') {
                                                    $('#DATE_SHAMSI2_EDIT').val('')
                                                }else{
                                                    $('#DATE_SHAMSI2_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                }
                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_SUB'] + 3000).on('click', function () {
                                                var id_sub = $(this).closest('tr').find('td:eq(1)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این این برنامه خروج از انبار هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        Swal.fire('برنامه خروج از انبار انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {
                                                        $.ajax({
                                                            url: "/taout-delete/" + id_sub+"/"+id_t,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_sub,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {
                                                                if(response.n==0){
                                                                    $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
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
                                                                    toastr.error('برنامه انبار حذف گردید');
                                                                    $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });
                                                    }
                                                })

                                            })
                                            detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                                id_t = $(this).closest('tr').find('td:eq(1)').text();
                                                event.preventDefault();
                                                $.ajaxSetup({
                                                    headers: {
                                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                    }
                                                });
                                                var _token = $("input[name='_token']").val();
                                                $.ajax({
                                                    url: '/get-history-anbar-prog/' + id_t,
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
                                            ID_SUB2 = $('<td style="width:5%;text-align: center">' + response.results[i]['ID_SUB'] + '</td>')
                                            ID_T = $('<td  hidden style="width: 40%;text-align: right">' + response.results[i]['ID_T'] + '</td>')
                                            ID_USER = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ID_USER'] + '</td>')
                                            RESV = $('<td hidden style="width: 3%;text-align: right">' + response.results[i]['RESV'] + '</td>')
                                            if (response.results[i]['RESV'] == 1) {
                                                RESV2 = $('<td style="width: 15%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                            }
                                            if (response.results[i]['RESV'] == 2) {
                                                RESV2 = $('<td style="width: 8%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                            }


                                            year = response.results[i]['DATE_SHAMSI2'].substr(0, 4);
                                            month = response.results[i]['DATE_SHAMSI2'].substr(4, 2);
                                            day = response.results[i]['DATE_SHAMSI2'].substr(6, 2);
                                            if (response.results[i]['DATE_SHAMSI2'] == '---') {
                                                DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                            }else{
                                                DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                            }

                                            COUNT_GH = $('<td style="width: 15%;text-align: center;border-right:1px dotted black">' + response.results[i]['COUNT_GH'] + '</td>')
                                            t1 = $('<td style="width: 8%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 8%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 8%"></td>')
                                            t3.append(detail1)
                                            t4 = $('<td style="width: 5%"></td>')
                                            t4.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t4,ID_SUB2, ID_T, ID_USER, RESV, RESV2, COUNT_GH, DATE_SHAMSI, t3, t1, t2)
                                            $("#table2").append(row)
                                        }
                                    }
                                })
                            })
                            ID_T = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                            GHATAAT_DAMAGE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GHATAAT_DAMAGE'] + '</td>')
                            GROUP_COUNT = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_COUNT'] + '</td>')
                            DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                            if(response.results[i]['DATE_SHAMSI']=="---"){
                                DATE_BEGIN1 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                            }else{
                                year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                DATE_BEGIN1 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                            }

                            t1 = $('<td style="width: 4%"></td>')
                            t1.append(edit1)
                            t2 = $('<td style="width: 4%"></td>')
                            t2.append(del2)
                            t3 = $('<td style="width: 4%"></td>')
                            t3.append(detail1)
                            t4 = $('<td style="width: 4%"></td>')
                            t4.append(select)
                            row = $('<tr class="table1"></tr>')

                            row.append(t4,ID_T,ID_TG,GHATAAT_DAMAGE,DATE_BEGIN1, DISCRIPTION,GROUP_COUNT,ID_TG2,t1,t3,t2)
                            $("#table1").append(row)
                        }
                    }
                });
            })
            $("#tpo_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/taout-store",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(true) {
                            if(response.sum == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'هشدار',
                                    text: 'مجموع قطعات خارج شده از انبار بیش از موارد وارد شده در این درخواست ورود به انبار می باشد.لطفا نسبت به اصلاح تعداد قطعات خارج شده اقدام گردد.',
                                })
                            }


                            if(response.sum == 0) {
                                toastr.success("برنامه دریافت جدید با موفقیت ذخیره گردید", "", {
                                    "timeOut": "5000",
                                    "extendedTImeout": "0"
                                });
                            }
                            if(response.sum == 1) {
                                $('#myModal2').modal('hide');
                                Swal.fire({
                                    icon: 'error',
                                    title: 'هشدار',
                                    text: 'مجموع قطعات خارج شده از انبار بیش از موارد وارد شده در این درخواست ورود به انبار می باشد.لطفا نسبت به اصلاح تعداد قطعات خارج شده اقدام گردد.',
                                })
                            }


                            $('#ID_SUB').val('')
                            $('#RESV').prop("checked", false);
                            $('#COUNT_GH').val('')
                            id_t = $('#ID_T_SUB2').val()
                            $('#myModal2').modal('hide');
                            // toastr.success("برنامه دریافت جدید با موفقیت ذخیره گردید", "", {
                            //     "timeOut": "5000",
                            //     "extendedTImeout": "0"
                            // });
                            $.ajax({
                                url: '/resvs_for_out/' + id_t,
                                method: 'GET',
                                success: function (response) {
                                    var select=''
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var ID_SUB = ''
                                    var ID_SUB2 = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var RESV = ''
                                    var RESV2 = ''
                                    var COUNT_GH = ''
                                    var DATE_SHAMSI = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>کد خروج</td><td style="text-align: center">وضعیت خروج</td><td style="text-align: center">تعداد خارج شده</td><td style="text-align: center">تاریخ خروج</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table2").empty();
                                    $("#table2").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                            if ($(this).closest('tr').find('td:eq(4)').text() == 1) {
                                                $('#RESV_EDIT').prop('checked', true);
                                            }
                                            if ($(this).closest('tr').find('td:eq(4)').text() == 2) {
                                                $('#RESV_EDIT').prop('checked', false);
                                            }
                                            $('#ID_SUB_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_T_SUB2_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                            $('#COUNT_GH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            if ($(this).closest('tr').find('td:eq(7)').text() == 'بدون تاریخ') {
                                                $('#DATE_SHAMSI2_EDIT').val('')
                                            }else{
                                                $('#DATE_SHAMSI2_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            }
                                        })
                                        select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $("tr.table2").css("background-color", "white");
                                            $("tr.table2").css("color", "black");
                                            $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                            $(this).closest('tr.table2').css( "color", "white" );
                                        })
                                        del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_SUB'] + 3000).on('click', function () {
                                            var id_sub = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");
                                            Swal.fire({
                                                title: 'مایل به حذف این این برنامه خروج از انبار هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire('برنامه خروج از انبار انتخابی حذف نشد', '', 'info')
                                                } else if (result.isDenied) {
                                                    $.ajax({
                                                        url: "/taout-delete/" + id_sub+"/"+id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_sub,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            if(response.n==0){
                                                                $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
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
                                                                toastr.error('برنامه انبار حذف گردید');
                                                                $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }else{
                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                            }
                                                        }
                                                    });
                                                }
                                            })

                                        })
                                        detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-anbar-prog/' + id_t,
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
                                        ID_SUB2 = $('<td style="width:5%;text-align: center">' + response.results[i]['ID_SUB'] + '</td>')
                                        ID_T = $('<td  hidden style="width: 40%;text-align: right">' + response.results[i]['ID_T'] + '</td>')
                                        ID_USER = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ID_USER'] + '</td>')
                                        RESV = $('<td hidden style="width: 3%;text-align: right">' + response.results[i]['RESV'] + '</td>')
                                        if (response.results[i]['RESV'] == 1) {
                                            RESV2 = $('<td style="width: 15%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if (response.results[i]['RESV'] == 2) {
                                            RESV2 = $('<td style="width: 8%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }


                                        year = response.results[i]['DATE_SHAMSI2'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI2'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI2'].substr(6, 2);
                                        if (response.results[i]['DATE_SHAMSI2'] == '---') {
                                            DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                        }else{
                                            DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        }

                                        COUNT_GH = $('<td style="width: 15%;text-align: center;border-right:1px dotted black">' + response.results[i]['COUNT_GH'] + '</td>')
                                        t1 = $('<td style="width: 8%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 8%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 8%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 5%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="table2"></tr>')
                                        row.append(t4,ID_SUB2, ID_T, ID_USER, RESV, RESV2, COUNT_GH, DATE_SHAMSI, t3, t1, t2)
                                        $("#table2").append(row)
                                    }
                                }
                            })
                        }else{
                            $('#myModal2').modal('hide');
                            Swal.fire({
                                icon: 'error',
                                title: 'هشدار',
                                text: 'مجموع قطعات خارج شده از انبار بیش از موارد وارد شده در این درخواست ورود به انبار می باشد.لطفا نسبت به اصلاح تعداد قطعات خارج شده اقدام گردد.',
                            })
                        }
                    },
                    error:function(response){
                        if(response.message===undefined){
                            alert("مدرکی الصاق نشده")
                        }
                    }
                });
            })
            $("#tpi_edit").on('submit', function (event) {
                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/tain-edit",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var id_t=response.ID_T
                        $('#ID_T').val('')
                        $('#ID_TG').val('')
                        $('#ID_BA').val('')
                        $('#GROUP_COUNT').val('')
                        $('#SHOMAREH_GHARAR').val('')
                        $('#DISCRIPTION').val('')
                        $("#ID_T_SUB2").text('');
                        $('#myModal1').modal('hide');
                        toastr.success("اطلاعات ورود به انبار اصلاح گردید", "", {
                            "timeOut": "5000",
                            "extendedTImeout": "0"
                        });
                        $.ajax({
                            url: '/tain-onlyone2/'+id_t,
                            method:'GET',
                            success: function (response) {
                                $("#add_recieve").hide();
                                $("#description2").text('');
                                $("#ID_T_SUB2").text('');
                                $("#table2").empty();
                                var day = ''
                                var month = ''
                                var year = ''
                                var edit1 = ''
                                var detail2 = ''
                                var del2 = ''
                                var detail1 = ''
                                var select = ''
                                var ID_T = ''
                                var ID_USER = ''
                                var ID_TG = ''
                                var ID_TG2 = ''
                                var ID_BA = ''
                                var ID_BA2 = ''
                                var GHATAAT_DAMAGE = ''
                                var GROUP_COUNT=''
                                var DATE_BEGIN1 = ''
                                var DISCRIPTION = ''
                                var t1 = ''
                                var t2 = ''
                                var t3 = ''
                                var t4 = ''
                                var row = ''
                                var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">وضعیت قطعات</td><td style="text-align: center">تاریخ ارسال</td><td style="text-align: center">تعداد قطعات</td><td>#</td><td>#</td><td>#</td></tr>')
                                $("#table1").empty();
                                $("#table1").append(th)
                                for (var i = 0; i < response.results.length; i++) {
                                    for (var j = 0; j < response.ID_TGS.length; j++) {
                                        if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                            ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                            ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                            break;
                                        }
                                    }
                                    for (var z = 0; z < response.ID_USERS.length; z++) {
                                        if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                            ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                            break;
                                        }
                                    }
                                    edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click',function () {
                                        $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                        $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                        $('#GHATAAT_DAMAGE_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                        $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                        $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                        $('#DATE_SHAMSI_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                    })
                                    del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click',function () {
                                        var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        Swal.fire({
                                            title: 'مایل به حذف این این برنامه ورود به انبار هستید؟',
                                            showDenyButton: true,
                                            cancelButtonText: `بازگشت`,
                                            confirmButtonText: `انصراف از حذف`,
                                            denyButtonText: 'حذف شود',
                                        }).then((result) => {
                                            if (result.isConfirmed) {

                                                Swal.fire('برنامه ورود به انبار حذف نشد', '', 'info')
                                            } else if (result.isDenied) {

                                                $.ajax({
                                                    url: "/tain-delete/" + id_t,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_t,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(response.rec_no>0){
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
                                                            toastr.error('امکان حذف نیست');
                                                            Swal.fire({
                                                                icon: 'error',
                                                                title: 'هشدار',
                                                                text: 'به علت ثبت درخواست خروج قطعه برای این برنامه امکان حذف وجود ندارد',
                                                            })
                                                        }
                                                        else{
                                                            $('#' + (Number(id_t) + 2000)).closest('tr').remove();
                                                            Swal.fire('حذف شد', '', 'success');
                                                        }


                                                    }
                                                });

                                            }
                                        })

                                    })
                                    detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                        id_t = $(this).closest('tr').find('td:eq(1)').text();
                                        event.preventDefault();
                                        $.ajaxSetup({
                                            headers: {
                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            }
                                        });
                                        var _token = $("input[name='_token']").val();
                                        $.ajax({
                                            url: '/get-history-anbar-prog2/' + id_t,
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
                                    select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                        $("#add_recieve").show()
                                        event.preventDefault();
                                        $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                        var id_t=$(this).closest('tr').find('td:eq(1)').text()
                                        $("tr.table1").css("background-color", "white");
                                        $("tr.table1").css("color", "black");
                                        $(this).closest('tr.table1').css( "background-color","#66CDAA");
                                        $(this).closest('tr.table1').css( "color", "white" );
                                        $('#ID_T_SUB2').val($(this).closest('tr').find('td:eq(1)').text())
                                        $.ajaxSetup({
                                            headers: {
                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            }
                                        });
                                        var _token = $("input[name='_token']").val();
                                        $.ajax({
                                            url: '/resvs_for_out/' + id_t,
                                            method:'GET',
                                            success: function (response) {
                                                var select=''
                                                var day = ''
                                                var month = ''
                                                var year = ''
                                                var edit1 = ''
                                                var del2 = ''
                                                var detail1 = ''
                                                var ID_SUB = ''
                                                var ID_SUB2 = ''
                                                var ID_T = ''
                                                var ID_USER = ''
                                                var RESV = ''
                                                var RESV2 = ''
                                                var COUNT_GH = ''
                                                var DATE_SHAMSI = ''
                                                var t1 = ''
                                                var t2 = ''
                                                var t3 = ''
                                                var t4 = ''
                                                var row = ''
                                                var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>کد خروج</td><td style="text-align: center">وضعیت خروج</td><td style="text-align: center">تعداد خارج شده</td><td style="text-align: center">تاریخ خروج</td><td>#</td><td>#</td><td>#</td></tr>')
                                                $("#table2").empty();
                                                $("#table2").append(th)
                                                for (var i = 0; i < response.results.length; i++) {
                                                    edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                        if ($(this).closest('tr').find('td:eq(4)').text() == 1) {
                                                            $('#RESV_EDIT').prop('checked', true);
                                                        }
                                                        if ($(this).closest('tr').find('td:eq(4)').text() == 2) {
                                                            $('#RESV_EDIT').prop('checked', false);
                                                        }
                                                        $('#ID_SUB_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                                        $('#ID_T_SUB2_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                        $('#COUNT_GH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                                        if ($(this).closest('tr').find('td:eq(7)').text() == 'بدون تاریخ') {
                                                            $('#DATE_SHAMSI2_EDIT').val('')
                                                        }else{
                                                            $('#DATE_SHAMSI2_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                        }
                                                    })
                                                    select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                        $("tr.table2").css("background-color", "white");
                                                        $("tr.table2").css("color", "black");
                                                        $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                        $(this).closest('tr.table2').css( "color", "white" );
                                                    })
                                                    del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_SUB'] + 3000).on('click', function () {
                                                        var id_sub = $(this).closest('tr').find('td:eq(1)').text();
                                                        var token = $("meta[name='csrf-token']").attr("content");
                                                        Swal.fire({
                                                            title: 'مایل به حذف این این برنامه خروج از انبار هستید؟',
                                                            showDenyButton: true,
                                                            cancelButtonText: `بازگشت`,
                                                            confirmButtonText: `انصراف از حذف`,
                                                            denyButtonText: 'حذف شود',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                Swal.fire('برنامه خروج از انبار انتخابی حذف نشد', '', 'info')
                                                            } else if (result.isDenied) {
                                                                $.ajax({
                                                                    url: "/taout-delete/" + id_sub+"/"+id_t,
                                                                    type: 'DELETE',
                                                                    data: {
                                                                        "id": id_sub,
                                                                        "_token": token,
                                                                    },
                                                                    success: function (response) {
                                                                        if(response.n==0){
                                                                            $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
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
                                                                            toastr.error('برنامه انبار حذف گردید');
                                                                            $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
                                                                            Swal.fire('حذف شد', '', 'success');
                                                                        }else{
                                                                            Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                        }
                                                                    }
                                                                });
                                                            }
                                                        })

                                                    })
                                                    detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                                        id_t = $(this).closest('tr').find('td:eq(1)').text();
                                                        event.preventDefault();
                                                        $.ajaxSetup({
                                                            headers: {
                                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                            }
                                                        });
                                                        var _token = $("input[name='_token']").val();
                                                        $.ajax({
                                                            url: '/get-history-anbar-prog/' + id_t,
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
                                                    ID_SUB2 = $('<td style="width:5%;text-align: center">' + response.results[i]['ID_SUB'] + '</td>')
                                                    ID_T = $('<td  hidden style="width: 40%;text-align: right">' + response.results[i]['ID_T'] + '</td>')
                                                    ID_USER = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ID_USER'] + '</td>')
                                                    RESV = $('<td hidden style="width: 3%;text-align: right">' + response.results[i]['RESV'] + '</td>')
                                                    if (response.results[i]['RESV'] == 1) {
                                                        RESV2 = $('<td style="width: 15%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                                    }
                                                    if (response.results[i]['RESV'] == 2) {
                                                        RESV2 = $('<td style="width: 8%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                                    }


                                                    year = response.results[i]['DATE_SHAMSI2'].substr(0, 4);
                                                    month = response.results[i]['DATE_SHAMSI2'].substr(4, 2);
                                                    day = response.results[i]['DATE_SHAMSI2'].substr(6, 2);
                                                    if (response.results[i]['DATE_SHAMSI2'] == '---') {
                                                        DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                                    }else{
                                                        DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                                    }

                                                    COUNT_GH = $('<td style="width: 15%;text-align: center;border-right:1px dotted black">' + response.results[i]['COUNT_GH'] + '</td>')
                                                    t1 = $('<td style="width: 8%"></td>')
                                                    t1.append(edit1)
                                                    t2 = $('<td style="width: 8%"></td>')
                                                    t2.append(del2)
                                                    t3 = $('<td style="width: 8%"></td>')
                                                    t3.append(detail1)
                                                    t4 = $('<td style="width: 5%"></td>')
                                                    t4.append(select)
                                                    row = $('<tr class="table2"></tr>')
                                                    row.append(t4,ID_SUB2, ID_T, ID_USER, RESV, RESV2, COUNT_GH, DATE_SHAMSI, t3, t1, t2)
                                                    $("#table2").append(row)
                                                }
                                            }
                                        })
                                    })
                                    ID_T = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                    GHATAAT_DAMAGE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GHATAAT_DAMAGE'] + '</td>')
                                    GROUP_COUNT = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                    DISCRIPTION = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['DISCRIPTION'] + '</td>')
                                    if(response.results[i]['DATE_SHAMSI']=="---"){
                                        DATE_BEGIN1 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                    }else{
                                        year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                        DATE_BEGIN1 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                    }

                                    t1 = $('<td style="width: 4%"></td>')
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 4%"></td>')
                                    t2.append(del2)
                                    t3 = $('<td style="width: 4%"></td>')
                                    t3.append(detail1)
                                    t4 = $('<td style="width: 4%"></td>')
                                    t4.append(select)
                                    row = $('<tr class="table1"></tr>')

                                    row.append(t4,ID_T,ID_TG,GHATAAT_DAMAGE,DATE_BEGIN1, DISCRIPTION,GROUP_COUNT,ID_TG2,t1,t3,t2)
                                    $("#table1").append(row)
                                }
                            }
                        })
                    }
                });
                $('#myModal3').modal('hide');
            })
            $("#tpo_edit").on('submit', function (event) {
                id_t=$('#ID_T_SUB2').val();
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/taout-edit",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.sum == 0){
                            toastr.success("تغییرات در برنامه خروج انتخابی اعمال گردید", "", {
                                "timeOut": "5000",
                                "extendedTImeout": "0"
                            });
                            $.ajax({
                                url: '/resvs_for_out/' + id_t,
                                method:'GET',
                                success: function (response) {
                                    var select=''
                                    var day = ''
                                    var month = ''
                                    var year = ''
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var ID_SUB = ''
                                    var ID_SUB2 = ''
                                    var ID_T = ''
                                    var ID_USER = ''
                                    var RESV = ''
                                    var RESV2 = ''
                                    var COUNT_GH = ''
                                    var DATE_SHAMSI = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>کد خروج</td><td style="text-align: center">وضعیت خروج</td><td style="text-align: center">تعداد خارج شده</td><td style="text-align: center">تاریخ خروج</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table2").empty();
                                    $("#table2").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                            if ($(this).closest('tr').find('td:eq(4)').text() == 1) {
                                                $('#RESV_EDIT').prop('checked', true);
                                            }
                                            if ($(this).closest('tr').find('td:eq(4)').text() == 2) {
                                                $('#RESV_EDIT').prop('checked', false);
                                            }
                                            $('#ID_SUB_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_T_SUB2_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                            $('#COUNT_GH_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            if ($(this).closest('tr').find('td:eq(7)').text() == 'بدون تاریخ') {
                                                $('#DATE_SHAMSI2_EDIT').val('')
                                            }else{
                                                $('#DATE_SHAMSI2_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            }
                                        })
                                        select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                            $("tr.table2").css("background-color", "white");
                                            $("tr.table2").css("color", "black");
                                            $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                            $(this).closest('tr.table2').css( "color", "white" );
                                        })
                                        del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_SUB'] + 3000).on('click', function () {
                                            var id_sub = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");
                                            Swal.fire({
                                                title: 'مایل به حذف این این برنامه خروج از انبار هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    Swal.fire('برنامه خروج از انبار انتخابی حذف نشد', '', 'info')
                                                } else if (result.isDenied) {
                                                    $.ajax({
                                                        url: "/taout-delete/" + id_sub+"/"+id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_sub,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            if(response.n==0){
                                                                $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
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
                                                                toastr.error('برنامه انبار حذف گردید');
                                                                $('#' + (Number(id_sub) + 3000).toString()).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }else{
                                                                Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                            }
                                                        }
                                                    });
                                                }
                                            })

                                        })
                                        detail1 = $('<button type="button" class="btn-sm border-info detail" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#savabegh">قطعات</button>').on('click', function (event) {
                                            id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            event.preventDefault();
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                                url: '/get-history-anbar-prog/' + id_t,
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
                                        ID_SUB2 = $('<td style="width:5%;text-align: center">' + response.results[i]['ID_SUB'] + '</td>')
                                        ID_T = $('<td  hidden style="width: 40%;text-align: right">' + response.results[i]['ID_T'] + '</td>')
                                        ID_USER = $('<td hidden style="width: 40%;text-align: right">' + response.results[i]['ID_USER'] + '</td>')
                                        RESV = $('<td hidden style="width: 3%;text-align: right">' + response.results[i]['RESV'] + '</td>')
                                        if (response.results[i]['RESV'] == 1) {
                                            RESV2 = $('<td style="width: 15%;text-align: center;border-right:1px dotted black"><img src="checked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }
                                        if (response.results[i]['RESV'] == 2) {
                                            RESV2 = $('<td style="width: 8%;text-align: center;border-right:1px dotted black"><img src="unchecked.jpg" class="rounded-circle" alt="Cinque Terre"></td>')
                                        }


                                        year = response.results[i]['DATE_SHAMSI2'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI2'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI2'].substr(6, 2);
                                        if (response.results[i]['DATE_SHAMSI2'] == '---') {
                                            DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">بدون تاریخ</td>')
                                        }else{
                                            DATE_SHAMSI = $('<td style="width: 16%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + year + '/' + month + '/' + day + '</td>')
                                        }

                                        COUNT_GH = $('<td style="width: 15%;text-align: center;border-right:1px dotted black">' + response.results[i]['COUNT_GH'] + '</td>')
                                        t1 = $('<td style="width: 8%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 8%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 8%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 5%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="table2"></tr>')
                                        row.append(t4,ID_SUB2, ID_T, ID_USER, RESV, RESV2, COUNT_GH, DATE_SHAMSI, t3, t1, t2)
                                        $("#table2").append(row)
                                    }
                                }
                            })
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'هشدار',
                                text: 'مجموع قطعات خارج شده از انبار بیش از موارد وارد شده در این درخواست ورود به انبار می باشد.لطفا نسبت به اصلاح تعداد قطعات خارج شده اقدام گردد.',
                            })
                        }

                    }
                });
                $('#myModal4').modal('hide');
            })

        })
    </script>
    @include('Ansaldo.AnsaldoStoreProgComponents.component01')
    @include('Ansaldo.AnsaldoStoreProgComponents.component02')
    @include('Ansaldo.AnsaldoStoreProgComponents.component03')
    @include('Ansaldo.AnsaldoStoreProgComponents.component04')
    @include('Ansaldo.AnsaldoStoreProgComponents.component05')
    @include('Ansaldo.AnsaldoStoreProgComponents.component06')
    @include('Ansaldo.AnsaldoStoreProgComponents.component07')
    @include('Ansaldo.AnsaldoStoreProgComponents.component08')

@endsection

