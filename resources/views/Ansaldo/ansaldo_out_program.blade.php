@extends('layouts.ansaldo_layouts.app_out_program')
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
            $("#out_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/out-store",
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
                        $('#description2').val('')
                        $('#DISCRIPTION').val('')
                        $("#OUT_IN").val('')
                        $('#myModal1').modal('hide');
                        toastr.success("برنامه ارسال جدید با موفقیت ذخیره گردید", "", {
                            "timeOut": "5000",
                            "extendedTImeout": "0"
                        });
                        $.ajax({
                            url: '/out-onlyone',
                            method:'GET',
                            success: function (response) {
                                if (response.results.length > 0) {
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
                                    var ID_BA = ''
                                    var ID_BA2 = ''
                                    var GROUP_COUNT = ''
                                    var DATE_SHAMSI = ''
                                    var DISCRIPTION = ''
                                    var LOCATION_NAME=''
                                    var OUT_IN = ''
                                    var OUT_IN2 = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">مبدا یا مقصد</td><td style="text-align: center">تاریخ ارسال</td><td style="text-align: center">تعداد قطعات</td><td style="text-align: center">نوع ارسال</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table1").empty();
                                    $("#table1").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_TGS.length; j++) {
                                            if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                                ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                                ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click', function () {
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#LOCATION_NAME_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                            $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DATE_BEGIN1_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                            $('#OUT_IN_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click', function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");

                                            Swal.fire({
                                                title: 'مایل به حذف این این برنامه ورود/خروج هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {

                                                    Swal.fire('برنامه ورود/خروج حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/out-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            if (false) {
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
                                                                    text: 'به علت ثبت درخواست دریافت قطعه برای این برنامه امکان حذف وجود ندارد',
                                                                })
                                                            } else {
                                                                $('#' + (Number(id_t) + 2000)).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
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
                                                url: '/get-history-enter_exit-prog/' + id_t,
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
                                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click', function (event) {
                                            $("#add_recieve").show()
                                            event.preventDefault();
                                            $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text()
                                            $("tr.table1").css("background-color", "white");
                                            $("tr.table1").css("color", "black");
                                            $(this).closest('tr.table1').css("background-color", "cornflowerblue");
                                            $(this).closest('tr.table1').css("color", "white");
                                        })

                                        ID_T = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                        LOCATION_NAME = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['LOCATION_NAME'] + '</td>')
                                        GROUP_COUNT = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="width: 40%;text-align: center">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        if(response.results[i]['OUT_IN']==1){
                                            OUT_IN = $('<td style="width: 4%;text-align: center;font-family: Tahoma;font-size: 10px">ورود</td>')
                                        }
                                        if(response.results[i]['OUT_IN']==2){
                                            OUT_IN = $('<td style="width: 4%;text-align: center;font-family: Tahoma;font-size: 10px">خروج</td>')
                                        }
                                        OUT_IN2 = $('<td hidden style="width: 40%;text-align: center">' + response.results[i]['OUT_IN'] + '</td>')
                                        year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                        DATE_SHAMSI = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                                        t1 = $('<td style="width: 4%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 4%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 4%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 4%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="table1"></tr>')
                                        row.append(t4, ID_T, ID_TG, LOCATION_NAME, DATE_SHAMSI, DISCRIPTION, GROUP_COUNT, ID_TG2,OUT_IN,OUT_IN2, t1, t2,t3)
                                        $("#table1").append(row)
                                    }
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
                    url: "/out-rep",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.results.length > 0) {
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
                            var ID_BA = ''
                            var ID_BA2 = ''
                            var GROUP_COUNT = ''
                            var DATE_SHAMSI = ''
                            var DISCRIPTION = ''
                            var LOCATION_NAME=''
                            var OUT_IN = ''
                            var OUT_IN2 = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">مبدا یا مقصد</td><td style="text-align: center">تاریخ ارسال</td><td style="text-align: center">تعداد قطعات</td><td style="text-align: center">نوع ارسال</td><td>#</td><td>#</td><td>#</td></tr>')
                            $("#table1").empty();
                            $("#table1").append(th)
                            for (var i = 0; i < response.results.length; i++) {
                                for (var j = 0; j < response.ID_TGS.length; j++) {
                                    if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                        ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                        ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                        break;
                                    }
                                }
                                edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click', function () {
                                    $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                    $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                    $('#LOCATION_NAME_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                    $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                    $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                    $('#DATE_BEGIN1_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                    $('#OUT_IN_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                })
                                del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click', function () {
                                    var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                    var token = $("meta[name='csrf-token']").attr("content");

                                    Swal.fire({
                                        title: 'مایل به حذف این این برنامه ورود/خروج هستید؟',
                                        showDenyButton: true,
                                        cancelButtonText: `بازگشت`,
                                        confirmButtonText: `انصراف از حذف`,
                                        denyButtonText: 'حذف شود',
                                    }).then((result) => {
                                        if (result.isConfirmed) {

                                            Swal.fire('برنامه ورود/خروج حذف نشد', '', 'info')
                                        } else if (result.isDenied) {

                                            $.ajax({
                                                url: "/out-delete/" + id_t,
                                                type: 'DELETE',
                                                data: {
                                                    "id": id_t,
                                                    "_token": token,
                                                },
                                                success: function (response) {
                                                    if (false) {
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
                                                            text: 'به علت ثبت درخواست دریافت قطعه برای این برنامه امکان حذف وجود ندارد',
                                                        })
                                                    } else {
                                                        $('#' + (Number(id_t) + 2000)).closest('tr').remove();
                                                        Swal.fire('حذف شد', '', 'success');
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
                                        url: '/get-history-enter_exit-prog/' + id_t,
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
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click', function (event) {
                                    $("#add_recieve").show()
                                    event.preventDefault();
                                    $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                    var id_t = $(this).closest('tr').find('td:eq(1)').text()
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "cornflowerblue");
                                    $(this).closest('tr.table1').css("color", "white");
                                })

                                ID_T = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                LOCATION_NAME = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['LOCATION_NAME'] + '</td>')
                                GROUP_COUNT = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                DISCRIPTION = $('<td hidden style="width: 40%;text-align: center">' + response.results[i]['DISCRIPTION'] + '</td>')
                                if(response.results[i]['OUT_IN']==1){
                                    OUT_IN = $('<td style="width: 4%;text-align: center;font-family: Tahoma;font-size: 10px">ورود</td>')
                                }
                                if(response.results[i]['OUT_IN']==2){
                                    OUT_IN = $('<td style="width: 4%;text-align: center;font-family: Tahoma;font-size: 10px">خروج</td>')
                                }
                                OUT_IN2 = $('<td hidden style="width: 40%;text-align: center">' + response.results[i]['OUT_IN'] + '</td>')
                                year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                DATE_SHAMSI = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                                t1 = $('<td style="width: 4%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 4%"></td>')
                                t2.append(del2)
                                t3 = $('<td style="width: 4%"></td>')
                                t3.append(detail1)
                                t4 = $('<td style="width: 4%"></td>')
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4, ID_T, ID_TG, LOCATION_NAME, DATE_SHAMSI, DISCRIPTION, GROUP_COUNT, ID_TG2,OUT_IN,OUT_IN2, t1, t2,t3)
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
            $("#tps_edit").on('submit', function (event) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/out-edit",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var id_t=response.ID_T
                        toastr.success("تغییرات در برنامه ورود و خروج اعمال گردید", "", {
                            "timeOut": "5000",
                            "extendedTImeout": "0"
                        });
                        $.ajax({
                            url: '/out-onlyone2/'+id_t,
                            method:'GET',
                            success: function (response) {
                                if (response.results.length > 0) {
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
                                    var ID_BA = ''
                                    var ID_BA2 = ''
                                    var GROUP_COUNT = ''
                                    var DATE_SHAMSI = ''
                                    var DISCRIPTION = ''
                                    var LOCATION_NAME=''
                                    var OUT_IN = ''
                                    var OUT_IN2 = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">نوع قطعات</td><td style="text-align: center">مبدا یا مقصد</td><td style="text-align: center">تاریخ ارسال</td><td style="text-align: center">تعداد قطعات</td><td style="text-align: center">نوع ارسال</td><td>#</td><td>#</td><td>#</td></tr>')
                                    $("#table1").empty();
                                    $("#table1").append(th)
                                    for (var i = 0; i < response.results.length; i++) {
                                        for (var j = 0; j < response.ID_TGS.length; j++) {
                                            if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                                ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                                ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                                break;
                                            }
                                        }
                                        edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal3">ویرایش</button>').on('click', function () {
                                            $('#ID_T_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                            $('#LOCATION_NAME_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                            $('#GROUP_COUNT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#DISCRIPTION_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                            $('#DATE_BEGIN1_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                            $('#OUT_IN_EDIT').val($(this).closest('tr').find('td:eq(9)').text())
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_T'] + 2000).on('click', function () {
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");

                                            Swal.fire({
                                                title: 'مایل به حذف این این برنامه ورود/خروج هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {

                                                    Swal.fire('برنامه ورود/خروج حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/out-delete/" + id_t,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_t,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            if (false) {
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
                                                                    text: 'به علت ثبت درخواست دریافت قطعه برای این برنامه امکان حذف وجود ندارد',
                                                                })
                                                            } else {
                                                                $('#' + (Number(id_t) + 2000)).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
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
                                                url: '/get-history-enter_exit-prog/' + id_t,
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
                                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click', function (event) {
                                            $("#add_recieve").show()
                                            event.preventDefault();
                                            $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                            var id_t = $(this).closest('tr').find('td:eq(1)').text()
                                            $("tr.table1").css("background-color", "white");
                                            $("tr.table1").css("color", "black");
                                            $(this).closest('tr.table1').css("background-color", "cornflowerblue");
                                            $(this).closest('tr.table1').css("color", "white");
                                        })

                                        ID_T = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_T'] + '</td>')
                                        LOCATION_NAME = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['LOCATION_NAME'] + '</td>')
                                        GROUP_COUNT = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_COUNT'] + '</td>')
                                        DISCRIPTION = $('<td hidden style="width: 40%;text-align: center">' + response.results[i]['DISCRIPTION'] + '</td>')
                                        if(response.results[i]['OUT_IN']==1){
                                            OUT_IN = $('<td style="width: 4%;text-align: center;font-family: Tahoma;font-size: 10px">ورود</td>')
                                        }
                                        if(response.results[i]['OUT_IN']==2){
                                            OUT_IN = $('<td style="width: 4%;text-align: center;font-family: Tahoma;font-size: 10px">خروج</td>')
                                        }
                                        OUT_IN2 = $('<td hidden style="width: 40%;text-align: center">' + response.results[i]['OUT_IN'] + '</td>')
                                        year = response.results[i]['DATE_SHAMSI'].substr(0, 4);
                                        month = response.results[i]['DATE_SHAMSI'].substr(4, 2);
                                        day = response.results[i]['DATE_SHAMSI'].substr(6, 2);
                                        DATE_SHAMSI = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + year + '/' + month + '/' + day + '</td>')
                                        t1 = $('<td style="width: 4%"></td>')
                                        t1.append(edit1)
                                        t2 = $('<td style="width: 4%"></td>')
                                        t2.append(del2)
                                        t3 = $('<td style="width: 4%"></td>')
                                        t3.append(detail1)
                                        t4 = $('<td style="width: 4%"></td>')
                                        t4.append(select)
                                        row = $('<tr class="table1"></tr>')
                                        row.append(t4, ID_T, ID_TG, LOCATION_NAME, DATE_SHAMSI, DISCRIPTION, GROUP_COUNT, ID_TG2,OUT_IN,OUT_IN2, t1, t2,t3)
                                        $("#table1").append(row)
                                    }
                                }
                            }
                        })
                    }
                });
                $('#myModal3').modal('hide');
            })


        })
    </script>
@include('Ansaldo.AnsaldoOutProgComponents.component01')
@include('Ansaldo.AnsaldoOutProgComponents.component02')
@include('Ansaldo.AnsaldoOutProgComponents.component03')
@include('Ansaldo.AnsaldoOutProgComponents.component04')
@include('Ansaldo.AnsaldoOutProgComponents.component05')
@include('Ansaldo.AnsaldoOutProgComponents.component06')
@endsection

