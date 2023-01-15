@extends('layouts.mitsubishi_layouts.app_in_program')
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
                    url: "/m-tain-store",
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
                                url: '/m-tain-onlyone',
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
                                                        url: "/m-tain-delete/" + id_t,
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
                                                url: '/m-get-history-anbar-prog2/' + id_t,
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
                                                url: '/m-resvs_for_out/' + id_t,
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
                                                                        url: "/m-taout-delete/" + id_sub+"/"+id_t,
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
                                                                url: '/m-get-history-anbar-prog/' + id_t,
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
                    url: "/m-tain-rep3",
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
                                            url: "/m-tain-delete/" + id_t,
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
                                    url: '/m-get-history-anbar-prog2/' + id_t,
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
                                    url: '/m-resvs_for_out/' + id_t,
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
                                                            url: "/m-taout-delete/" + id_sub+"/"+id_t,
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
                                                    url: '/m-get-history-anbar-prog/' + id_t,
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
                    url: "/m-taout-store",
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
                                url: '/m-resvs_for_out/' + id_t,
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
                                                        url: "/m-taout-delete/" + id_sub+"/"+id_t,
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
                                                url: '/m-get-history-anbar-prog/' + id_t,
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
                    url: "/m-tain-edit",
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
                            url: '/m-tain-onlyone2/'+id_t,
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
                                                    url: "/m-tain-delete/" + id_t,
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
                                            url: '/m-get-history-anbar-prog2/' + id_t,
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
                                            url: '/m-resvs_for_out/' + id_t,
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
                                                                    url: "/m-taout-delete/" + id_sub+"/"+id_t,
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
                                                            url: '/m-get-history-anbar-prog/' + id_t,
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
                    url: "/m-taout-edit",
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
                                url: '/m-resvs_for_out/' + id_t,
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
                                                        url: "/m-taout-delete/" + id_sub+"/"+id_t,
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
                                                url: '/m-get-history-anbar-prog/' + id_t,
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
                <div class="col-2"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col-4">
                    <div style="width: 100%;height: 65%;border-radius: 3px;margin-top: 4px;padding-top: 5px;background-color: #4a5d74">
                        <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe;direction: rtl">برنامه ورود و خروج قطعات در انبار (Mitsubishi)</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="width: 100%;height:48%;margin-top: 6px">
           <div class="row">
               <div class="col-3" style="height:300px">
                   <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                       <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">جستجو در برنامه های ورود و خروج به انبار</p>
                   </div>
                   <div style="width: 95%;height: 265px;margin: auto;margin-top:3px;border-radius: 3px;background-color:rgba(105,105,105,0.5)">
                       <form method="post" encType="multipart/form-data" id="tpsrep_form" action={{route('tpi2.store')}}>
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
                           {{--<div class="row mt-2" style="margin-left: 20px">--}}
                               {{--<div class="col-6" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_BEGINR"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGINR"  style="font-family: Tahoma;font-size: x-small;width: 100%;" required title="تاریخ شروع"></div>--}}
                               {{--<div class="col-6" style="text-align: center"><p style="text-align: left;font-size:small;font-family: Tahoma;color: #fdfdfe">تاریخ شروع</p></div>--}}
                           {{--</div>--}}
                           {{--<div class="row mt-2" style="margin-left: 20px">--}}
                               {{--<div class="col-6" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_ENDR"  data-toggle="tooltip" data-placement="right"  name="DATE_ENDR"  style="font-family: Tahoma;font-size: x-small;width: 100%;" required title="تاریخ پایان"></div>--}}
                               {{--<div class="col-6" style="text-align: center"><p style="text-align: left;font-size:small;font-family: Tahoma;color: #fdfdfe">تاریخ پایان</p></div>--}}
                           {{--</div>--}}
                           <div class="row mt-2"  style="text-align: center;margin-left: 5px">
                               <div class="col-2">
                                   <select class="form-control isclicked1" name="GHATAAT_DAMAGE_R" id="GHATAAT_DAMAGE_R"  style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                       <option value="0">وضعیت قطعات</option>
                                       <option value="1">نو</option>
                                       <option value="2">قابل بازسازی</option>
                                       <option value="3">بازسازی شده</option>
                                       <option value="4">ریجکت</option>
                                   </select>
                               </div>
                           </div>
                           <div class="row mt-2"  style="text-align: center">
                               <div class="col">
                                   <select class="form-control isclicked1" name="RESV_R" id="RESV_R" style="width: 200px;font-family: Tahoma;font-size: x-small;display: inline">
                                       <option value="0">وضعیت خروج از انبار</option>
                                       <option value="1">همه موارد</option>
                                       <option value="2">قطعات وارد شده و خارج نشده</option>
                                       <option value="3">قطعات وارد شده و خارج شده</option>
                                   </select>
                               </div>
                           </div>


                           <div class="row mt-3">
                               <div class="col-3" style="text-align: right"></div>
                               <div class="col-6" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >جستجو </button></div>
                               <div class="col-3" style="text-align: right"></div>
                           </div>
                       </form>

                   </div>
               </div>
               <div class="col-9">
                   <div class="row">
                       <div class="col-10">
                           <div style="width: 100%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                               <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست برنامه های ورود به انبار ثبت شده</p>
                           </div>
                           <div style="width:100%;height: 265px;background-color:rgba(105,105,105,0.5);margin-right: 2px;margin-top:3px;border-radius: 3px">
                               <div style="width: 95%;height: 250px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                                   <table id="table1" align="center" style="width: 100%;font-family: Tahoma;font-size: small;direction: rtl;background-color: white;">
                                   </table>
                               </div>

                           </div>
                       </div>
                       <div class="col-2" style="background-color:rgba(105,105,105,0.5);border-radius: 3px;margin-top: 32px">
                           <div class="row" style="height: 25%;margin-top: -5px">
                               <div class="col" >
                                   <img src="start01.png" id="add_send" class="reza2" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه ارسال قطعه">
                               </div>
                           </div>
                           <div class="row mt-2" style="height: 25%">
                               <div class="col" >
                                   <a href="/bazsaz-form" ><img src="base.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="افزودن اطلاعات پایه" style="border-radius: 15px ;margin-top: 4px"></a>
                               </div>
                           </div>
                           {{--<div class="row " style="height: 25%;margin-top: -5px">--}}
                               {{--<div class="col" >--}}
                                   {{--<a href="/bazsaz-form" ><img src="equip.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="تعیین لیست قطعات" style="border-radius: 15px ;margin-top: 4px"></a>--}}
                               {{--</div>--}}
                           {{--</div>--}}
                           {{--<div class="row " style="height: 25%;margin-top: -5px">--}}
                               {{--<div class="col" >--}}
                                   {{--<a href="/tapr-form" ><img src="repair2.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="ایجاد برنامه تعمیراتی" style="border-radius: 15px ;margin-top: 4px"></a>--}}
                               {{--</div>--}}
                           {{--</div>--}}
                        </div>

                   </div>
               </div>
           </div>
        </div>
        <div class="container" style="width: 100%;height:45%;">
            <div class="row">
                <div class="col-3" style="height:260px">
                    <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                        <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">توضیحات</p>
                    </div>
                    <div style="width: 95%;height: 150px;background-color:rgba(105,105,105,0.5);margin: auto;margin-top:3px;border-radius: 3px;text-align: right;padding-right: 10px">
                        <p class="modal-title" id="description2" style="color: white;font-family: Tahoma;font-size: small;display: inline;"></p>
                    </div>
                </div>
                <div class="col-9" style="height:260px">
                    <div class="row">
                        <div class="col-10">
                            <div style="width: 100%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                                <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست برنامه های خروج از انبار ثبت شده</p>
                            </div>
                            <div style="width:100%;height: 200px;margin-right: 2px;margin-top:3px;border-radius: 3px;text-align: center;background-color:rgba(105,105,105,0.5)">
                                <div style="word-wrap: break-word;width: 85%;height: 185px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                                   <table id="table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 3px;direction: rtl;background-color: white"></table>
                                </div>
                            </div>
                        </div>
                        <div class="col-2" style="background-color:rgba(105,105,105,0.5)">
                            <div class="row" style="height:33%">
                                <div class="col">
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
    </div>
    <!-- Send Anbar -->
        <div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
          <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
            <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ایجاد برنامه ورود به انبار</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10">.</div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white;">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="container"  style="margin: auto;background-color:lightgray;height: 260px ">
                <form method="post" encType="multipart/form-data" id="tpi_form" action="{{route('tpi.store')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_T" name="ID_T" >
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-4 ">
                            <select class="form-control isclicked1" name="ID_TG" id="ID_TG" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">انتخاب نوع قطعات</option>
                                @foreach($ghataats as $ghataat)
                                    <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2" style="margin-right: 100px">
                            <select class="form-control isclicked1" name="GHATAAT_DAMAGE" id="GHATAAT_DAMAGE" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">وضعیت قطعات</option>
                                <option value="نو">نو</option>
                                <option value="قابل بازسازی">قابل بازسازی</option>
                                <option value="بازسازی شده">بازسازی شده</option>
                                <option value="ریجکت">ریجکت</option>

                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row mt-0">
                        <div class="field row" >
                            <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ ورود</p></div>
                            <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>
                        </div>
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                        <div class="col-4" style="text-align: center"> <input type="number" max="10000" min="0" class="form-control" id="GROUP_COUNT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="تعداد قطعات"></div>
                    </div>
                    <br>
                    <div class="field row mt-0">
                        <div class="col-9" style="text-align: right"><input type="text" maxlength="100" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%"  title="توضیحات"></div>
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
    <!-- Exit Anbar -->
        <div class="modal fade" id="myModal2" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Recieve Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ایجاد برنامه خروج از انبار</p></div>
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

                <!-- Recieve Header -->
                <div class="container"  style="margin: auto;background-color:lightgray;height: 170px ">
                    <form method="post" encType="multipart/form-data" id="tpo_form" action="{{route('tpo.store')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input type="hidden" class="form-control" id="ID_SUB " name="ID_SUB " >
                                <input type="hidden" id="ID_T_SUB2" name="ID_T" >
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="container row" >
                                <div class="col-3" style="text-align: center"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تاریخ خروج</p></div>
                                <div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI2"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI2"  style="font-family: Tahoma;font-size: small;width: 100%;"  title="تاریخ خروج"></div>
                                <div class="col-3" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: black">خارج شد</p></div>
                                <div class="col-2" style="text-align: left">
                                    <input style="font-size: 4px" class="form-control" type="checkbox" id="RESV" name="RESV" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="container row mt-2">
                            <div class="col-3" style="text-align: right"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تعداد قطعات</p></div>
                            <div class="col-4" style="text-align: center"> <input type="number" max="10000" min="0" class="form-control" id="COUNT_GH"  data-toggle="tooltip" data-placement="right"  name="COUNT_GH" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 100%;" required title="تعداد قطعات"></div>
                        </div>
                        <br>
                         <div class="field row mt-0">
                            <div class="col-4"></div>
                            <div class="col-5"></div>
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
    <!-- Edit Send Anbar -->
        <div class="modal fade" id="myModal3" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Send Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح درخواست ورود قطعات به انبار</p></div>
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
                <div class="container"  style="margin: auto;background-color:lightgray;height: 260px ">
                    <form method="post" encType="multipart/form-data" id="tpi_edit" action="{{route('tpi.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input type="hidden" class="form-control" id="ID_T_EDIT" name="ID_T_EDIT" >
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-4 ">
                                <select class="form-control isclicked1" name="ID_TG_EDIT" id="ID_TG_EDIT" required style="width: 240px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع قطعات</option>
                                    @foreach($ghataats as $ghataat)
                                        <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2" style="margin-right: 100px">
                                <select class="form-control isclicked1" name="GHATAAT_DAMAGE_EDIT" id="GHATAAT_DAMAGE_EDIT" required style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">وضعیت قطعات</option>
                                    <option value="نو">نو</option>
                                    <option value="قابل بازسازی">قابل بازسازی</option>
                                    <option value="بازسازی شده">بازسازی شده</option>
                                    <option value="ریجکت">ریجکت</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0">
                            <div class="field row" >
                                <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ ورود</p></div>
                                <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ ورود به انبار"></div>
                            </div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                            <div class="col-4" style="text-align: center"> <input type="number" max="10000" min="0" class="form-control" id="GROUP_COUNT_EDIT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT_EDIT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 70%;" required title="تعداد قطعات"></div>
                        </div>
                        <br>
                        <div class="field row mt-0">
                            <div class="col-9" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION_EDIT"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION_EDIT" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%"  title="توضیحات"></div>
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
    <!-- Edit Exit Anbar -->
        <div class="modal fade" id="myModal4" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Recieve Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح فرم درخواست خروج از انبار</p></div>
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

                <!-- Recieve Header -->
                <div class="container"  style="margin: auto;background-color:lightgray;height: 175px ">
                    <form method="post" encType="multipart/form-data" id="tpo_edit" action="{{route('tpoa.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input type="hidden" class="form-control" id="ID_SUB_EDIT" name="ID_SUB_EDIT" >
                                <input type="hidden" id="ID_T_SUB2_EDIT" name="ID_T_EDIT" >
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="container row" >
                                <div class="col-3" style="text-align: center"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تاریخ خروج</p></div>
                                <div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI2_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI2_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;"  title="تاریخ دریافت"></div>
                                <div class="col-3" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: black">خارج شد</p></div>
                                <div class="col-2" style="text-align: left">
                                    <input style="font-size: 4px" class="form-control" type="checkbox" id="RESV_EDIT" name="RESV_EDIT" value="1">
                                </div>
                            </div>
                        </div>
                        <div class="container row mt-2">
                            <div class="col-3" style="text-align: right"><p style="text-align: left;font-size:smaller;font-family: Tahoma">تعداد قطعات</p></div>
                            <div class="col-4" style="text-align: center"> <input type="number" max="10000" min="0" class="form-control" id="COUNT_GH_EDIT"  data-toggle="tooltip" data-placement="right"  name="COUNT_GH_EDIT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 100%;" required title="تعداد قطعات"></div>
                        </div>
                        <br>
                        <div class="field row mt-0">
                            <div class="col-4"></div>
                            <div class="col-5"></div>
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
                </div>
            </div>
        </div>
    </div>





@endsection

