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
<!-- List of content -->
        <div class="container bg-dark" style="width: 100%;height:6%;">
            <div class="row">
                <div class="col">
                    <ul class="navbar-nav" >
                        <li class="nav-item">
                            <a class="nav-link" href="/savabegh"><p style="font-family: Tahoma;font-size: x-small">بازگشت</p></a>
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
                        <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe">برنامه ورود و خروج قطعات از نیروگاه</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="width: 100%;height:48%;margin-top: 60px">
           <div class="row">
               <div class="col-3" style="height:300px">
                   <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                       <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">جستجو در برنامه های قطعات ارسالی</p>
                   </div>
                   <div style="width: 95%;height: 265px;margin: auto;margin-top:3px;border-radius: 3px;background-color:rgba(105,105,105,0.5)">
                       <form method="post" encType="multipart/form-data" id="tpsrep_form" action={{route('out3.store')}}>
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
                           <br>
                           <br>
                           <br>
                           <div class="row mt-5">
                               <div class="col-3" style="text-align: right"></div>
                               <div class="col-6" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >جستجو</button></div>
                               <div class="col-3" style="text-align: right"></div>
                           </div>
                       </form>

                   </div>
               </div>
               <div class="col-9">
                   <div class="row">
                       <div class="col-10">
                           <div style="width: 100%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                               <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست برنامه های ارسال ثبت شده</p>
                           </div>
                           <div style="width:100%;height: 265px;background-color:rgba(105,105,105,0.5);margin-right: 2px;margin-top:3px;border-radius: 3px">
                               <div style="width: 95%;height: 250px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                                   <table id="table1" align="center" style="width: 100%;font-family: Tahoma;font-size: small;direction: rtl;background-color: white;">
                                   </table>
                               </div>

                           </div>
                       </div>
                       <div class="col-2" style="background-color:rgba(105,105,105,0.5);border-radius: 3px;margin-top: 32px">
                           <div class="row mt-1" style="height: 25%">
                               <div class="col" >
                                   <img src="start01.png" id="add_send" class="reza2" data-toggle="tooltip" data-placement="bottom" title="ایجاد برنامه ارسال قطعه">
                               </div>
                           </div>
                           <div class="row" style="height: 25%;margin-top: -5px">
                               <div class="col" >
                                   <a href="/bazsaz-form" > <img src="base.png" id="add_send2" class="reza2" data-toggle="tooltip" data-placement="bottom" title="افزودن اطلاعات پایه" style="border-radius: 15px ;margin-top: 4px"></a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
        </div>
        <div class="container" style="width: 100%;height:45%;">
            <div class="row">
                <div class="col-3" style="height:260px" hidden>
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
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ایجاد برنامه ورود یا خروج قطعات</p></div>
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
                <form method="post" encType="multipart/form-data" id="out_form" action="{{route('out.store')}}">
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
                        <div class="col-6" style="margin-right: 100px">
                            <input type="text" maxlength="80" class="form-control" id="LOCATION_NAME"  data-toggle="tooltip" data-placement="right"  name="LOCATION_NAME"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="دریافت کننده\ارسال کننده" placeholder="دریافت کننده\ارسال کننده">
                        </div>
                    </div>
                    <br>
                    <div class="row mt-0">
                        <div class="field row" >
                            <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ ارسال یا دریافت</p></div>
                            <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ ارسال یا دریافت"></div>
                        </div>
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                        <div class="col-4" style="text-align: center"> <input type="number" max="100000" min="0"  class="form-control" id="GROUP_COUNT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="تعداد قطعات"></div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-3 ">
                            <select class="form-control isclicked1" required name="OUT_IN" id="OUT_IN" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">ورود یا خروج</option>
                                <option value="1">ورود</option>
                                <option value="2">خروج</option>
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

    <!-- Edit Send form -->
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
        <div class="modal fade" id="myModal3" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Send Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح درخواست ارسال قطعات</p></div>
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
                    <form method="post" encType="multipart/form-data" id="tps_edit" action="{{route('out.edit')}}">
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

                            <div class="col-6" style="margin-right: 100px">
                                <input type="text" maxlength="80" class="form-control" id="LOCATION_NAME_EDIT"  data-toggle="tooltip" data-placement="right"  name="LOCATION_NAME_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="دریافت کننده\ارسال کننده" placeholder="دریافت کننده\ارسال کننده">
                            </div>

                        </div>
                        <br>
                        <div class="row mt-0">
                            <div class="field row" >
                                <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ ارسال</p></div>
                                <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>
                            </div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                            <div class="col-4" style="text-align: center"> <input type="number" max="100000" min="0" class="form-control" id="GROUP_COUNT_EDIT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT_EDIT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="تعداد قطعات"></div>
                            <div class="col-2 ">
                                <select class="form-control isclicked1" name="OUT_IN_EDIT" id="OUT_IN_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">ورود یا خروج</option>
                                    <option value="1">ورود</option>
                                    <option value="2">خروج</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row mt-0">
                            <div class="col-9" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION_EDIT"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION_EDIT" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%" title="توضیحات"></div>
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

@endsection

