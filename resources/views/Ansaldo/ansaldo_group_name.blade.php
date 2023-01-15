@extends('layouts.ansaldo_layouts.app_group_name')
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
                $("#GROUP_CODE").val('');
                $("#GROUP_TYPE").val('');
                $("#ID_TG").val('0');
            })
            $("#add_recieve").on('click',function (event) {
                $('#myModal3').modal('show');
                $("#MAKER").val('0');
                $("#SERIYAL_NUMBER").val('');
                $("#SERIAL_NUMBER2").val('');
                $("#REAL_SOURE").val('');
            })
            $("#edit_recieve").on('click',function (event) {
                $('#myModal5').modal('show');
                $("#MAKER_EDIT2").val('0');
                $("#REAL_SOURE_EDIT2").val('0');
            })
            $("#DATE_BEGIN1").prop('readonly', true)
            $("#DATE_BEGINR").prop('readonly', true)
            $("#DATE_ENDR").prop('readonly', true)
            $("#DATE_SHAMSI").prop('readonly', true)
            $("#DATE_BEGIN1_EDIT").prop('readonly', true)
            $("#DATE_SHAMSI_EDIT").prop('readonly', true)
            $("#DATE_BEGIN1").prop('readonly', true)



            $("#group_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/group-store",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.repeat==1){
                            Swal.fire('کد گروه انتخابی تکراری است', '', 'info')
                        }else {
                            $('#myModal1').modal('hide');
                            toastr.success("گروه جدید با موفقیت گردید", "", {
                                "timeOut": "5000",
                                "extendedTImeout": "0"
                            });
                            $.ajax({
                                url: '/group-onlyone',
                                method: 'GET',
                                success: function (response) {
                                    $("#add_recieve").hide();
                                    $("#edit_recieve").hide();
                                    $("#description2").text('');
                                    $("#ID_T_SUB2").text('');
                                    $("#table2").empty();
                                    var edit1 = ''
                                    var del2 = ''
                                    var detail1 = ''
                                    var select = ''
                                    var ID_G = ''
                                    var ID_USER = ''
                                    var ID_TG = ''
                                    var ID_TG2 = ''
                                    var GROUP_CODE = ''
                                    var GROUP_TYPE = ''
                                    var GROUP_TYPE2 = ''
                                    var t1 = ''
                                    var t2 = ''
                                    var t3 = ''
                                    var t4 = ''
                                    var row = ''
                                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">کد گروه</td><td style="text-align: center">نوع گروه</td><td style="text-align: center">نوع قطعه</td><td>#</td><td>#</td></tr>')
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
                                        edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal2">ویرایش</button>').on('click', function () {
                                            $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                            $('#GROUP_CODE_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                            $('#GROUP_TYPE_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                        })
                                        del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_G'] + 2000).on('click', function () {
                                            var id_g = $(this).closest('tr').find('td:eq(1)').text();
                                            var token = $("meta[name='csrf-token']").attr("content");

                                            Swal.fire({
                                                title: 'مایل به حذف گروه انتخابی هستید؟',
                                                showDenyButton: true,
                                                cancelButtonText: `بازگشت`,
                                                confirmButtonText: `انصراف از حذف`,
                                                denyButtonText: 'حذف شود',
                                            }).then((result) => {
                                                if (result.isConfirmed) {

                                                    Swal.fire('گروه انتخابی حذف نشد', '', 'info')
                                                } else if (result.isDenied) {

                                                    $.ajax({
                                                        url: "/group-delete/" + id_g,
                                                        type: 'DELETE',
                                                        data: {
                                                            "id": id_g,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            // $('#' + (Number(id_g) + 2000)).closest('tr').remove();
                                                            if (response.rec_no > 0) {
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
                                                                    text: 'به علت ثبت قطعه در این گروه امکان حذف وجود ندارد',
                                                                })
                                                            } else {
                                                                $('#' + (Number(id_g) + 2000)).closest('tr').remove();
                                                                Swal.fire('حذف شد', '', 'success');
                                                            }


                                                        }
                                                    });

                                                }
                                            })

                                        })
                                        detail1 = $('<button type="button" class="btn-sm border-info detail_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal2">جزئیات</button>')
                                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click', function (event) {
                                            $("#add_recieve").show()
                                            $("#edit_recieve").show()
                                            event.preventDefault();
                                            $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                            var id_g = $(this).closest('tr').find('td:eq(1)').text()
                                            $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(1)').text())
                                            $('#ID_G_EDIT3').val(id_g)
                                            $("tr.table1").css("background-color", "white");
                                            $("tr.table1").css("color", "black");
                                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                            $(this).closest('tr.table1').css("color", "white");
                                            $('#ID_G_GH').val($(this).closest('tr').find('td:eq(1)').text())
                                            $.ajaxSetup({
                                                headers: {
                                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                }
                                            });
                                            var _token = $("input[name='_token']").val();
                                            $.ajax({
                                    url: '/gh-gr1/' + id_g,
                                    method: 'GET',
                                    success: function (response) {
                                        radif=0
                                        RADIF1=''
                                        var edit1 = ''
                                        var del2 = ''
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var SERIAL_NUMBER2 = ''
                                        var REAL_SOURE = ''
                                        var MAKER = ''
                                        var MAKER2 = ''
                                        var ID_G = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var select = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>ردیف</td><td>کد</td><td style="text-align: center">شماره سریال</td><td style="text-align: center">سریال قبلی</td><td style="text-align: center">اصالت قطعه</td><td style="text-align: center">شرکت سازنده</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            radif=radif+1
                                            RADIF1 = $('<td style="text-align: center;font-family: Tahoma;font-size: 10px;border:1px dotted black">' + radif + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(5)').text() == '--') {
                                                    $('#REAL_SOURE_EDIT').val('0')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'اصلی') {
                                                    $('#REAL_SOURE_EDIT').val('1')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید ارزی') {
                                                    $('#REAL_SOURE_EDIT').val('2')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید داخل') {
                                                    $('#REAL_SOURE_EDIT').val('3')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'ساخت داخل') {
                                                    $('#REAL_SOURE_EDIT').val('4')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'امانی') {
                                                    $('#REAL_SOURE_EDIT').val('5')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'نامشخص') {
                                                    $('#REAL_SOURE_EDIT').val('6')
                                                }
                                                $('#ID_E_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#SERIYAL_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                                $('#SERIAL_NUMBER2_EDIT').val($(this).closest('tr').find('td:eq(4)').text())

                                                $('#MAKER_EDIT').val($(this).closest('tr').find('td:eq(8)').text())

                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_E'] + 3000).on('click', function () {
                                                var id_e = $(this).closest('tr').find('td:eq(2)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این قطعه هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {

                                                        Swal.fire('قطعه انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {

                                                        $.ajax({
                                                            url: "/equ-delete/" + id_e,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_e,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {

                                                                if(response.n==1){
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
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
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });

                                                    }
                                                })

                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            ID_E = $('<td style="width:5%;text-align: center;font-size: 10px">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td  hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            SERIAL_NUMBER2 = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIAL_NUMBER2'] + '</td>')
                                            if (response.results[i]['REAL_SOURE']==0) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">--</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==1) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">اصلی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==2) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید ارزی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==3) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==4) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">ساخت داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==5) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">امانی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==6) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">نامشخص</td>')
                                            }


                                            for (var j = 0; j < response.SAZS.length; j++) {
                                                if (response.SAZS[j]['ID_S'] == response.results[i]['MAKER']) {
                                                    MAKER = $('<td style="width: 44%;font-family: Tahoma;font-size: 10px;text-align: center;border:1px dotted black">' + response.SAZS[j]['SAZANDEH'] + '</td>');
                                                    MAKER2 = $('<td hidden>' + response.SAZS[j]['ID_S'] + '</td>')
                                                    break;
                                                }
                                            }
                                            t1 = $('<td style="width: 10%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 10%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 10%"></td>')
                                            t3.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t3,RADIF1,ID_E, SERIYAL_NUMBER,SERIAL_NUMBER2, REAL_SOURE, MAKER,ID_G,MAKER2,t1, t2)
                                            $("#table2").append(row)
                                        }
                                    }
                                })
                                        })
                                        ID_G = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                        GROUP_CODE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_CODE'] + '</td>')
                                        GROUP_TYPE = $('<td hidden style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_TYPE'] + '</td>')
                                        if (response.results[i]['GROUP_TYPE'] == 1) {
                                            GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">حقیقی</td>')
                                        }
                                        if (response.results[i]['GROUP_TYPE'] == 2) {
                                            GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">مجازی</td>')
                                        }
                                        if (response.results[i]['GROUP_TYPE'] == 3) {
                                            GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">ریجکت</td>')
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
                                        row.append(t4, ID_G, GROUP_CODE, GROUP_TYPE2, GROUP_TYPE, ID_TG, ID_TG2, t1, t2)
                                        $("#table1").append(row)
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
            })
            $("#group_report_form").on('submit', function (event) {
                 event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/group-rep",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#add_recieve").hide();
                        $("#edit_recieve").hide();
                        $("#description2").text('');
                        $("#ID_T_SUB2").text('');
                        $("#table2").empty();
                        var edit1 = ''
                        var del2 = ''
                        var detail1 = ''
                        var select = ''
                        var ID_G = ''
                        var ID_USER = ''
                        var ID_TG = ''
                        var ID_TG2 = ''
                        var GROUP_CODE = ''
                        var GROUP_TYPE = ''
                        var GROUP_TYPE2 = ''
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">کد گروه</td><td style="text-align: center">نوع گروه</td><td style="text-align: center">نوع قطعه</td><td>#</td><td>#</td></tr>')
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
                            edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal2">ویرایش</button>').on('click', function () {
                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#GROUP_CODE_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                $('#GROUP_TYPE_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                            })
                            del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_G'] + 2000).on('click', function () {
                                var id_g = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");

                                Swal.fire({
                                    title: 'مایل به حذف گروه انتخابی هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('گروه انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/group-delete/" + id_g,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_g,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                // $('#' + (Number(id_g) + 2000)).closest('tr').remove();
                                                if (response.rec_no > 0) {
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
                                                        text: 'به علت ثبت قطعه در این گروه امکان حذف وجود ندارد',
                                                    })
                                                } else {
                                                    $('#' + (Number(id_g) + 2000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }


                                            }
                                        });

                                    }
                                })

                            })
                            detail1 = $('<button type="button" class="btn-sm border-info detail_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal2">جزئیات</button>')
                            select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click', function (event) {
                                $("#add_recieve").show()
                                $("#edit_recieve").show()
                                event.preventDefault();
                                $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                var id_g = $(this).closest('tr').find('td:eq(1)').text()
                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_G_EDIT3').val(id_g)
                                $("tr.table1").css("background-color", "white");
                                $("tr.table1").css("color", "black");
                                $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                $(this).closest('tr.table1').css("color", "white");
                                $('#ID_G_GH').val($(this).closest('tr').find('td:eq(1)').text())
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/gh-gr1/' + id_g,
                                    method: 'GET',
                                    success: function (response) {
                                        radif=0
                                        RADIF1=''
                                        var edit1 = ''
                                        var del2 = ''
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var SERIAL_NUMBER2 = ''
                                        var REAL_SOURE = ''
                                        var MAKER = ''
                                        var MAKER2 = ''
                                        var ID_G = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var select = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>ردیف</td><td>کد</td><td style="text-align: center">شماره سریال</td><td style="text-align: center">سریال قبلی</td><td style="text-align: center">اصالت قطعه</td><td style="text-align: center">شرکت سازنده</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            radif=radif+1
                                            RADIF1 = $('<td style="text-align: center;font-family: Tahoma;font-size: 10px;border:1px dotted black">' + radif + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(5)').text() == '--') {
                                                    $('#REAL_SOURE_EDIT').val('0')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'اصلی') {
                                                    $('#REAL_SOURE_EDIT').val('1')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید ارزی') {
                                                    $('#REAL_SOURE_EDIT').val('2')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید داخل') {
                                                    $('#REAL_SOURE_EDIT').val('3')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'ساخت داخل') {
                                                    $('#REAL_SOURE_EDIT').val('4')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'امانی') {
                                                    $('#REAL_SOURE_EDIT').val('5')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'نامشخص') {
                                                    $('#REAL_SOURE_EDIT').val('6')
                                                }
                                                $('#ID_E_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#SERIYAL_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                                $('#SERIAL_NUMBER2_EDIT').val($(this).closest('tr').find('td:eq(4)').text())

                                                $('#MAKER_EDIT').val($(this).closest('tr').find('td:eq(8)').text())

                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_E'] + 3000).on('click', function () {
                                                var id_e = $(this).closest('tr').find('td:eq(2)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این قطعه هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {

                                                        Swal.fire('قطعه انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {

                                                        $.ajax({
                                                            url: "/equ-delete/" + id_e,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_e,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {

                                                                if(response.n==1){
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
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
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });

                                                    }
                                                })

                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            ID_E = $('<td style="width:5%;text-align: center;font-size: 10px">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td  hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            SERIAL_NUMBER2 = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIAL_NUMBER2'] + '</td>')
                                            if (response.results[i]['REAL_SOURE']==0) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">--</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==1) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">اصلی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==2) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید ارزی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==3) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==4) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">ساخت داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==5) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">امانی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==6) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">نامشخص</td>')
                                            }


                                            for (var j = 0; j < response.SAZS.length; j++) {
                                                if (response.SAZS[j]['ID_S'] == response.results[i]['MAKER']) {
                                                    MAKER = $('<td style="width: 44%;font-family: Tahoma;font-size: 10px;text-align: center;border:1px dotted black">' + response.SAZS[j]['SAZANDEH'] + '</td>');
                                                    MAKER2 = $('<td hidden>' + response.SAZS[j]['ID_S'] + '</td>')
                                                    break;
                                                }
                                            }
                                            t1 = $('<td style="width: 10%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 10%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 10%"></td>')
                                            t3.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t3,RADIF1,ID_E, SERIYAL_NUMBER,SERIAL_NUMBER2, REAL_SOURE, MAKER,ID_G,MAKER2,t1, t2)
                                            $("#table2").append(row)
                                        }
                                    }
                                })
                            })
                            ID_G = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_G'] + '</td>')
                            GROUP_CODE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_CODE'] + '</td>')
                            GROUP_TYPE = $('<td hidden style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_TYPE'] + '</td>')
                            if(response.results[i]['GROUP_TYPE']==1){
                                GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">حقیقی</td>')
                            }
                            if(response.results[i]['GROUP_TYPE']==2){
                                GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">مجازی</td>')
                            }
                            if(response.results[i]['GROUP_TYPE']==3){
                                GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">ریجکت</td>')
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
                            row.append(t4, ID_G,GROUP_CODE,GROUP_TYPE2,GROUP_TYPE,ID_TG,ID_TG2, t1, t2)
                            $("#table1").append(row)
                        }
                    }
                });
            })
            $("#group_edit_form").on('submit', function (event) {
                event.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/group-edit",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        var id_g=response.ID_G
                        $('#myModal1').modal('hide');
                        toastr.success("اطلاعات اصلاح گردید", "", {
                            "timeOut": "5000",
                            "extendedTImeout": "0"
                        });
                        $.ajax({
                            url: '/group-onlyone2/'+id_g,
                            method:'GET',
                            success: function (response) {
                                $("#add_recieve").hide();
                                $("#edit_recieve").hide();
                                $("#description2").text('');
                                $("#ID_T_SUB2").text('');
                                $("#table2").empty();
                                var edit1 = ''
                                var del2 = ''
                                var detail1 = ''
                                var select = ''
                                var ID_G = ''
                                var ID_USER = ''
                                var ID_TG = ''
                                var ID_TG2 = ''
                                var GROUP_CODE = ''
                                var GROUP_TYPE = ''
                                var GROUP_TYPE2 = ''
                                var t1 = ''
                                var t2 = ''
                                var t3 = ''
                                var t4 = ''
                                var row = ''
                                var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: center">کد گروه</td><td style="text-align: center">نوع گروه</td><td style="text-align: center">نوع قطعه</td><td>#</td><td>#</td></tr>')
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
                                    edit1 = $('<button type="button" class="btn-sm border-success edit_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal2">ویرایش</button>').on('click', function () {
                                        $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                        $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                        $('#GROUP_CODE_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                        $('#GROUP_TYPE_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                    })
                                    del2 = $('<button type="button" class="btn-sm border-danger del_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_G'] + 2000).on('click', function () {
                                        var id_g = $(this).closest('tr').find('td:eq(1)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");

                                        Swal.fire({
                                            title: 'مایل به حذف گروه انتخابی هستید؟',
                                            showDenyButton: true,
                                            cancelButtonText: `بازگشت`,
                                            confirmButtonText: `انصراف از حذف`,
                                            denyButtonText: 'حذف شود',
                                        }).then((result) => {
                                            if (result.isConfirmed) {

                                                Swal.fire('گروه انتخابی حذف نشد', '', 'info')
                                            } else if (result.isDenied) {

                                                $.ajax({
                                                    url: "/group-delete/" + id_g,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_g,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        // $('#' + (Number(id_g) + 2000)).closest('tr').remove();
                                                        if (response.rec_no > 0) {
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
                                                                text: 'به علت ثبت قطعه در این گروه امکان حذف وجود ندارد',
                                                            })
                                                        } else {
                                                            $('#' + (Number(id_g) + 2000)).closest('tr').remove();
                                                            Swal.fire('حذف شد', '', 'success');
                                                        }


                                                    }
                                                });

                                            }
                                        })

                                    })
                                    detail1 = $('<button type="button" class="btn-sm border-info detail_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal2">جزئیات</button>')
                                    select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click', function (event) {
                                        $("#add_recieve").show()
                                        $("#edit_recieve").show()
                                        event.preventDefault();
                                        $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                        var id_g = $(this).closest('tr').find('td:eq(1)').text()
                                        $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(1)').text())
                                        $('#ID_G_EDIT3').val(id_g)
                                        $("tr.table1").css("background-color", "white");
                                        $("tr.table1").css("color", "black");
                                        $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                        $(this).closest('tr.table1').css("color", "white");
                                        $('#ID_G_GH').val($(this).closest('tr').find('td:eq(1)').text())
                                        $.ajaxSetup({
                                            headers: {
                                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                            }
                                        });
                                        var _token = $("input[name='_token']").val();
                                        $.ajax({
                                    url: '/gh-gr1/' + id_g,
                                    method: 'GET',
                                    success: function (response) {
                                        radif=0
                                        RADIF1=''
                                        var edit1 = ''
                                        var del2 = ''
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var SERIAL_NUMBER2 = ''
                                        var REAL_SOURE = ''
                                        var MAKER = ''
                                        var MAKER2 = ''
                                        var ID_G = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var select = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>ردیف</td><td>کد</td><td style="text-align: center">شماره سریال</td><td style="text-align: center">سریال قبلی</td><td style="text-align: center">اصالت قطعه</td><td style="text-align: center">شرکت سازنده</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            radif=radif+1
                                            RADIF1 = $('<td style="text-align: center;font-family: Tahoma;font-size: 10px;border:1px dotted black">' + radif + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(5)').text() == '--') {
                                                    $('#REAL_SOURE_EDIT').val('0')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'اصلی') {
                                                    $('#REAL_SOURE_EDIT').val('1')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید ارزی') {
                                                    $('#REAL_SOURE_EDIT').val('2')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید داخل') {
                                                    $('#REAL_SOURE_EDIT').val('3')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'ساخت داخل') {
                                                    $('#REAL_SOURE_EDIT').val('4')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'امانی') {
                                                    $('#REAL_SOURE_EDIT').val('5')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'نامشخص') {
                                                    $('#REAL_SOURE_EDIT').val('6')
                                                }
                                                $('#ID_E_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#SERIYAL_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                                $('#SERIAL_NUMBER2_EDIT').val($(this).closest('tr').find('td:eq(4)').text())

                                                $('#MAKER_EDIT').val($(this).closest('tr').find('td:eq(8)').text())

                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_E'] + 3000).on('click', function () {
                                                var id_e = $(this).closest('tr').find('td:eq(2)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این قطعه هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {

                                                        Swal.fire('قطعه انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {

                                                        $.ajax({
                                                            url: "/equ-delete/" + id_e,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_e,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {

                                                                if(response.n==1){
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
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
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });

                                                    }
                                                })

                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            ID_E = $('<td style="width:5%;text-align: center;font-size: 10px">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td  hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            SERIAL_NUMBER2 = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIAL_NUMBER2'] + '</td>')
                                            if (response.results[i]['REAL_SOURE']==0) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">--</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==1) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">اصلی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==2) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید ارزی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==3) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==4) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">ساخت داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==5) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">امانی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==6) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">نامشخص</td>')
                                            }


                                            for (var j = 0; j < response.SAZS.length; j++) {
                                                if (response.SAZS[j]['ID_S'] == response.results[i]['MAKER']) {
                                                    MAKER = $('<td style="width: 44%;font-family: Tahoma;font-size: 10px;text-align: center;border:1px dotted black">' + response.SAZS[j]['SAZANDEH'] + '</td>');
                                                    MAKER2 = $('<td hidden>' + response.SAZS[j]['ID_S'] + '</td>')
                                                    break;
                                                }
                                            }
                                            t1 = $('<td style="width: 10%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 10%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 10%"></td>')
                                            t3.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t3,RADIF1,ID_E, SERIYAL_NUMBER,SERIAL_NUMBER2, REAL_SOURE, MAKER,ID_G,MAKER2,t1, t2)
                                            $("#table2").append(row)
                                        }
                                    }
                                })
                                    })
                                    ID_G = $('<td style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                    GROUP_CODE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_CODE'] + '</td>')
                                    GROUP_TYPE = $('<td hidden style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">' + response.results[i]['GROUP_TYPE'] + '</td>')
                                    if(response.results[i]['GROUP_TYPE']==1){
                                        GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">حقیقی</td>')
                                    }
                                    if(response.results[i]['GROUP_TYPE']==2){
                                        GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">مجازی</td>')
                                    }
                                    if(response.results[i]['GROUP_TYPE']==3){
                                        GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center;border-right:1px dotted black">ریجکت</td>')
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
                                    row.append(t4, ID_G,GROUP_CODE,GROUP_TYPE2,GROUP_TYPE,ID_TG,ID_TG2, t1, t2)
                                    $("#table1").append(row)
                                }
                            }
                        })
                    }
                });
                $('#myModal2').modal('hide');
            })
            $("#equ_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/equ-store",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.repeat==1){
                            Swal.fire('این شماره سریال تکراری است', '', 'info')
                        }else{
                            id_g=response.ID_G
                            $('#myModal3').modal('hide');
                            toastr.info('این قطعه به گروه انتخابی افزوده شد');
                            event.preventDefault();
                            $.ajaxSetup({
                                headers: {
                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            });
                            var _token = $("input[name='_token']").val();
                            $.ajax({
                                    url: '/gh-gr1/' + id_g,
                                    method: 'GET',
                                    success: function (response) {
                                        radif=0
                                        RADIF1=''
                                        var edit1 = ''
                                        var del2 = ''
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var SERIAL_NUMBER2 = ''
                                        var REAL_SOURE = ''
                                        var MAKER = ''
                                        var MAKER2 = ''
                                        var ID_G = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var select = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>ردیف</td><td>کد</td><td style="text-align: center">شماره سریال</td><td style="text-align: center">سریال قبلی</td><td style="text-align: center">اصالت قطعه</td><td style="text-align: center">شرکت سازنده</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            radif=radif+1
                                            RADIF1 = $('<td style="text-align: center;font-family: Tahoma;font-size: 10px;border:1px dotted black">' + radif + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(5)').text() == '--') {
                                                    $('#REAL_SOURE_EDIT').val('0')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'اصلی') {
                                                    $('#REAL_SOURE_EDIT').val('1')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید ارزی') {
                                                    $('#REAL_SOURE_EDIT').val('2')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید داخل') {
                                                    $('#REAL_SOURE_EDIT').val('3')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'ساخت داخل') {
                                                    $('#REAL_SOURE_EDIT').val('4')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'امانی') {
                                                    $('#REAL_SOURE_EDIT').val('5')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'نامشخص') {
                                                    $('#REAL_SOURE_EDIT').val('6')
                                                }
                                                $('#ID_E_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#SERIYAL_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                                $('#SERIAL_NUMBER2_EDIT').val($(this).closest('tr').find('td:eq(4)').text())

                                                $('#MAKER_EDIT').val($(this).closest('tr').find('td:eq(8)').text())

                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_E'] + 3000).on('click', function () {
                                                var id_e = $(this).closest('tr').find('td:eq(2)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این قطعه هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {

                                                        Swal.fire('قطعه انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {

                                                        $.ajax({
                                                            url: "/equ-delete/" + id_e,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_e,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {

                                                                if(response.n==1){
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
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
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });

                                                    }
                                                })

                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            ID_E = $('<td style="width:5%;text-align: center;font-size: 10px">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td  hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            SERIAL_NUMBER2 = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIAL_NUMBER2'] + '</td>')
                                            if (response.results[i]['REAL_SOURE']==0) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">--</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==1) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">اصلی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==2) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید ارزی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==3) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==4) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">ساخت داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==5) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">امانی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==6) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">نامشخص</td>')
                                            }


                                            for (var j = 0; j < response.SAZS.length; j++) {
                                                if (response.SAZS[j]['ID_S'] == response.results[i]['MAKER']) {
                                                    MAKER = $('<td style="width: 44%;font-family: Tahoma;font-size: 10px;text-align: center;border:1px dotted black">' + response.SAZS[j]['SAZANDEH'] + '</td>');
                                                    MAKER2 = $('<td hidden>' + response.SAZS[j]['ID_S'] + '</td>')
                                                    break;
                                                }
                                            }
                                            t1 = $('<td style="width: 10%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 10%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 10%"></td>')
                                            t3.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t3,RADIF1,ID_E, SERIYAL_NUMBER,SERIAL_NUMBER2, REAL_SOURE, MAKER,ID_G,MAKER2,t1, t2)
                                            $("#table2").append(row)
                                        }
                                    }
                                })
                        }


                    }
                });
            })
            $("#equ_edit").on('submit', function (event) {

                id_t=$('#ID_T_SUB2').val();
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/equ-edit",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.repeat==1){
                            Swal.fire('این شماره سریال تکراری است', '', 'info')
                        }else{
                            if(true){
                                toastr.success("تغییرات قطعه انتخابی اعمال گردید", "", {
                                    "timeOut": "5000",
                                    "extendedTImeout": "0"
                                });
                                $.ajax({
                                    url: '/gh-gr1/' + response.ID_G,
                                    method: 'GET',
                                    success: function (response) {
                                        radif=0
                                        RADIF1=''
                                        var edit1 = ''
                                        var del2 = ''
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var SERIAL_NUMBER2 = ''
                                        var REAL_SOURE = ''
                                        var MAKER = ''
                                        var MAKER2 = ''
                                        var ID_G = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var select = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>ردیف</td><td>کد</td><td style="text-align: center">شماره سریال</td><td style="text-align: center">سریال قبلی</td><td style="text-align: center">اصالت قطعه</td><td style="text-align: center">شرکت سازنده</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            radif=radif+1
                                            RADIF1 = $('<td style="text-align: center;font-family: Tahoma;font-size: 10px;border:1px dotted black">' + radif + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(5)').text() == '--') {
                                                    $('#REAL_SOURE_EDIT').val('0')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'اصلی') {
                                                    $('#REAL_SOURE_EDIT').val('1')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید ارزی') {
                                                    $('#REAL_SOURE_EDIT').val('2')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید داخل') {
                                                    $('#REAL_SOURE_EDIT').val('3')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'ساخت داخل') {
                                                    $('#REAL_SOURE_EDIT').val('4')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'امانی') {
                                                    $('#REAL_SOURE_EDIT').val('5')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'نامشخص') {
                                                    $('#REAL_SOURE_EDIT').val('6')
                                                }
                                                $('#ID_E_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#SERIYAL_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                                $('#SERIAL_NUMBER2_EDIT').val($(this).closest('tr').find('td:eq(4)').text())

                                                $('#MAKER_EDIT').val($(this).closest('tr').find('td:eq(8)').text())

                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_E'] + 3000).on('click', function () {
                                                var id_e = $(this).closest('tr').find('td:eq(2)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این قطعه هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {

                                                        Swal.fire('قطعه انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {

                                                        $.ajax({
                                                            url: "/equ-delete/" + id_e,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_e,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {

                                                                if(response.n==1){
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
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
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });

                                                    }
                                                })

                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            ID_E = $('<td style="width:5%;text-align: center;font-size: 10px">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td  hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            SERIAL_NUMBER2 = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIAL_NUMBER2'] + '</td>')
                                            if (response.results[i]['REAL_SOURE']==0) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">--</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==1) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">اصلی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==2) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید ارزی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==3) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==4) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">ساخت داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==5) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">امانی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==6) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">نامشخص</td>')
                                            }


                                            for (var j = 0; j < response.SAZS.length; j++) {
                                                if (response.SAZS[j]['ID_S'] == response.results[i]['MAKER']) {
                                                    MAKER = $('<td style="width: 44%;font-family: Tahoma;font-size: 10px;text-align: center;border:1px dotted black">' + response.SAZS[j]['SAZANDEH'] + '</td>');
                                                    MAKER2 = $('<td hidden>' + response.SAZS[j]['ID_S'] + '</td>')
                                                    break;
                                                }
                                            }
                                            t1 = $('<td style="width: 10%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 10%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 10%"></td>')
                                            t3.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t3,RADIF1,ID_E, SERIYAL_NUMBER,SERIAL_NUMBER2, REAL_SOURE, MAKER,ID_G,MAKER2,t1, t2)
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
                    }
                });
                $('#myModal4').modal('hide');
            })
            $("#equ_edit2").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/equ-edit2",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(true){
                            toastr.success("تغییرات در اطلاعات قطعات اعمال گردید", "", {
                                "timeOut": "5000",
                                "extendedTImeout": "0"
                            });
                            Swal.fire({
                                icon: 'info',
                                text: 'تغییرات در کلیه قطعات این گروه اعمال گردید',
                            })
                            $.ajax({
                                    url: '/gh-gr1/' + response.ID_G,
                                    method: 'GET',
                                    success: function (response) {
                                        radif=0
                                        RADIF1=''
                                        var edit1 = ''
                                        var del2 = ''
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var SERIAL_NUMBER2 = ''
                                        var REAL_SOURE = ''
                                        var MAKER = ''
                                        var MAKER2 = ''
                                        var ID_G = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var t3 = ''
                                        var select = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td>#</td><td>ردیف</td><td>کد</td><td style="text-align: center">شماره سریال</td><td style="text-align: center">سریال قبلی</td><td style="text-align: center">اصالت قطعه</td><td style="text-align: center">شرکت سازنده</td><td>#</td><td>#</td></tr>')
                                        $("#table2").empty();
                                        $("#table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            radif=radif+1
                                            RADIF1 = $('<td style="text-align: center;font-family: Tahoma;font-size: 10px;border:1px dotted black">' + radif + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px" data-toggle="modal" data-target="#myModal4">ویرایش</button>').on('click', function () {
                                                if ($(this).closest('tr').find('td:eq(5)').text() == '--') {
                                                    $('#REAL_SOURE_EDIT').val('0')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'اصلی') {
                                                    $('#REAL_SOURE_EDIT').val('1')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید ارزی') {
                                                    $('#REAL_SOURE_EDIT').val('2')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'خرید داخل') {
                                                    $('#REAL_SOURE_EDIT').val('3')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'ساخت داخل') {
                                                    $('#REAL_SOURE_EDIT').val('4')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'امانی') {
                                                    $('#REAL_SOURE_EDIT').val('5')
                                                }
                                                if ($(this).closest('tr').find('td:eq(5)').text() == 'نامشخص') {
                                                    $('#REAL_SOURE_EDIT').val('6')
                                                }
                                                $('#ID_E_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                                $('#ID_G_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#ID_G_EDIT2').val($(this).closest('tr').find('td:eq(7)').text())
                                                $('#SERIYAL_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                                $('#SERIAL_NUMBER2_EDIT').val($(this).closest('tr').find('td:eq(4)').text())

                                                $('#MAKER_EDIT').val($(this).closest('tr').find('td:eq(8)').text())

                                            })
                                            del2 = $('<button type="button" class="btn-sm del_send border-danger" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;border-radius: 6px">حذف</button>').attr('id', response.results[i]['ID_E'] + 3000).on('click', function () {
                                                var id_e = $(this).closest('tr').find('td:eq(2)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                Swal.fire({
                                                    title: 'مایل به حذف این قطعه هستید؟',
                                                    showDenyButton: true,
                                                    cancelButtonText: `بازگشت`,
                                                    confirmButtonText: `انصراف از حذف`,
                                                    denyButtonText: 'حذف شود',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {

                                                        Swal.fire('قطعه انتخابی حذف نشد', '', 'info')
                                                    } else if (result.isDenied) {

                                                        $.ajax({
                                                            url: "/equ-delete/" + id_e,
                                                            type: 'DELETE',
                                                            data: {
                                                                "id": id_e,
                                                                "_token": token,
                                                            },
                                                            success: function (response) {

                                                                if(response.n==1){
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
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
                                                                    $('#' + (Number(id_e) + 3000).toString()).closest('tr').remove();
                                                                    Swal.fire('حذف شد', '', 'success');
                                                                }else{
                                                                    Swal.fire('به علت استفاده از این برنامه در سوابق موجود امکان حذف وجود ندارد', '', 'info')
                                                                }
                                                            }
                                                        });

                                                    }
                                                })

                                            })
                                            select = $('<button type="button" class="btn-sm btn-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                                $("tr.table2").css("background-color", "white");
                                                $("tr.table2").css("color", "black");
                                                $(this).closest('tr.table2').css( "background-color","RosyBrown");
                                                $(this).closest('tr.table2').css( "color", "white" );
                                            })
                                            ID_E = $('<td style="width:5%;text-align: center;font-size: 10px">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td  hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            SERIAL_NUMBER2 = $('<td style="width: 13%;text-align: center;font-size: 10px;border:1px dotted black">' + response.results[i]['SERIAL_NUMBER2'] + '</td>')
                                            if (response.results[i]['REAL_SOURE']==0) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">--</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==1) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">اصلی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==2) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید ارزی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==3) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">خرید داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==4) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">ساخت داخل</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==5) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">امانی</td>')
                                            }
                                            if (response.results[i]['REAL_SOURE']==6) {
                                                REAL_SOURE = $('<td style="width: 15%;text-align: center;font-size: 10px;border:1px dotted black">نامشخص</td>')
                                            }


                                            for (var j = 0; j < response.SAZS.length; j++) {
                                                if (response.SAZS[j]['ID_S'] == response.results[i]['MAKER']) {
                                                    MAKER = $('<td style="width: 44%;font-family: Tahoma;font-size: 10px;text-align: center;border:1px dotted black">' + response.SAZS[j]['SAZANDEH'] + '</td>');
                                                    MAKER2 = $('<td hidden>' + response.SAZS[j]['ID_S'] + '</td>')
                                                    break;
                                                }
                                            }
                                            t1 = $('<td style="width: 10%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 10%"></td>')
                                            t2.append(del2)
                                            t3 = $('<td style="width: 10%"></td>')
                                            t3.append(select)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t3,RADIF1,ID_E, SERIYAL_NUMBER,SERIAL_NUMBER2, REAL_SOURE, MAKER,ID_G,MAKER2,t1, t2)
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
                $('#myModal5').modal('hide');
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
                            <a class="nav-link" href="/savabegh"><p style="font-family: Tahoma;font-size: x-small">بازگشت</p></a>
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
                    <div style="width: 100%;height: 65%;border-radius: 3px;margin-top: 4px;padding-top: 5px;background-color: #005299">
                        <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe"> (Ansaldo) تعریف گروه و تخصیص قطعات</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" style="width: 100%;height:48%;margin-top: 6px">
           <div class="row">
               <div class="col-3" style="height:300px">
                   <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                       <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">جستجو در گروههای تعریف شده</p>
                   </div>
                   <div style="width: 95%;height: 165px;margin: auto;margin-top:3px;border-radius: 3px;background-color:rgba(105,105,105,0.5)">
                       <form method="post" encType="multipart/form-data" id="group_report_form" action={{route('group2.store')}}>
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
                           <div class="row mt-2"  style="text-align: center">
                               <div class="col">
                                   <select class="form-control isclicked1" name="GROUP_TYPE_R" id="GROUP_TYPE_R" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                       <option value="0">انتخاب نوع گروه</option>
                                       <option value="1">حقیقی</option>
                                       <option value="2">مجازی</option>
                                       <option value="3">ریجکت</option>
                                   </select>
                               </div>
                           </div>
                           <div class="row mt-4">
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
                               <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست گروههای ایجاد شده</p>
                           </div>
                           <div style="width:100%;height: 265px;background-color:rgba(105,105,105,0.5);margin-right: 2px;margin-top:3px;border-radius: 3px">
                               <div style="width: 95%;height: 250px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                                   <table id="table1" align="center" style="width: 100%;font-family: Tahoma;font-size: small;direction: rtl;background-color: white;"></table>
                               </div>
                           </div>
                       </div>
                       <div class="col-2" style="background-color:rgba(105,105,105,0.5);border-radius: 3px;margin-top: 32px">
                           <div class="row" style="height: 25%;margin-top: -5px">
                               <div class="col" >
                                   <img src="start01.png" id="add_send" class="reza2" data-toggle="tooltip" data-placement="bottom" title=" ایجاد گروه جدید">
                               </div>
                           </div>
                           <div class="row mt-2" style="height: 25%">
                               <div class="col" >
                                   <a href="/bazsaz-form" ><img src="base.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="افزودن اطلاعات پایه" style="border-radius: 15px ;margin-top: 4px"></a>
                               </div>
                           </div>
                           <div class="row " style="height: 25%;margin-top: -5px">
                               <div class="col" >
                                   <a hidden href="/bazsaz-form" ><img src="equip.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="تعیین لیست قطعات" style="border-radius: 15px ;margin-top: 4px"></a>
                               </div>
                           </div>
                           <div class="row " style="height: 25%;margin-top: -5px">
                               <div class="col" >
                                   <a hidden href="/tapr-form" ><img src="repair2.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="ایجاد برنامه تعمیراتی" style="border-radius: 15px ;margin-top: 4px"></a>
                               </div>
                           </div>
                        </div>

                   </div>
               </div>
           </div>
        </div>
        <div class="container" style="width: 100%;height:45%;">
            <div class="row">
                <div class="col-3" style="height:260px">
                    {{--<div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">--}}
                        {{--<p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">توضیحات</p>--}}
                    {{--</div>--}}
                    {{--<div style="width: 95%;height: 150px;background-color:rgba(105,105,105,0.5);margin: auto;margin-top:3px;border-radius: 3px;text-align: right;padding-right: 10px">--}}
                        {{--<p class="modal-title" id="description2" style="color: white;font-family: Tahoma;font-size: small;display: inline;"></p>--}}
                    {{--</div>--}}
                </div>
                <div class="col-9" style="height:260px">
                    <div class="row">
                        <div class="col-10">
                            <div style="width: 100%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                                <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست قطعات تخصیص داده شده به گروه انتخابی</p>
                            </div>
                            <div style="width:100%;height: 200px;margin-right: 2px;margin-top:3px;border-radius: 3px;text-align: center;background-color:rgba(105,105,105,0.5)">
                                <div style="width: 85%;height: 185px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                                   <table id="table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 3px;direction: rtl;background-color: white"></table>
                                </div>
                            </div>
                        </div>
                        <div class="col-2" style="background-color:rgba(105,105,105,0.5)">
                            {{--<div class="row" style="height:33%">--}}
                                {{--<div class="col">--}}

                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row" style="height: 33%">--}}
                                {{--<div class="col" >--}}

                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="row" style="height: 33%">--}}
                                {{--<div class="col" ></div>--}}
                            {{--</div>--}}


                            <div class="row" style="height: 25%;margin-top: -5px">
                                <div class="col" >
                                    <img style="display: none" src="addlist.jpg" id="add_recieve" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تخصیص قطعات">
                                </div>
                            </div>
                            <div class="row mt-2" style="height: 25%">
                                <div class="col" >
                                    <img style="display: none" src="amar1.png" id="edit_recieve" class="reza2" data-toggle="tooltip" data-placement="bottom" title="ویرایش قطعات بصورت گروهی">
                                </div>
                            </div>
                            <div class="row " style="height: 25%;margin-top: -5px">
                                <div class="col" >
                                    <a hidden href="/bazsaz-form" ><img src="equip.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="تعیین لیست قطعات" style="border-radius: 15px ;margin-top: 4px"></a>
                                </div>
                            </div>
                            <div class="row " style="height: 25%;margin-top: -5px">
                                <div class="col" >
                                    <a hidden href="/tapr-form" ><img src="repair2.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="ایجاد برنامه تعمیراتی" style="border-radius: 15px ;margin-top: 4px"></a>
                                </div>
                            </div>

                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Define group code -->
        <div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
          <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
            <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین نام گروه جدید</p></div>
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
            <div class="container"  style="margin: auto;background-color:lightgray;height: 220px ">
                <form method="post" encType="multipart/form-data" id="group_form" action="{{route('group1.store')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_G " name="ID_G " >
                        </div>
                    </div>
                    <br>
                    <div class="row mt-0">
                        <div class="field row" >
                            <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کد گروه</p></div>
                            <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="GROUP_CODE"  data-toggle="tooltip" data-placement="right"  name="GROUP_CODE"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="کد گروه" placeholder="کد گروه"></div>
                        </div>
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: right;margin-right: 67px">
                            <select class="form-control isclicked1" name="GROUP_TYPE" required id="GROUP_TYPE" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">انتخاب نوع گروه</option>
                                <option value="1">حقیقی</option>
                                <option value="2">مجازی</option>
                                <option value="3">ریجکت</option>
                            </select>
                        </div>

                    </div>
                    <div class="field row">
                        <div class="col-2" style="text-align: right;margin-right: 67px">
                            <select class="form-control isclicked1 mt-2" required name="ID_TG" id="ID_TG" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                <option value="0">انتخاب نوع قطعات</option>
                                @foreach($ghataats as $ghataat)
                                    <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="field row mt-0">
                        {{--<div class="col-9" style="text-align: right"><input type="text" maxlength="100" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%" required title="توضیحات"></div>--}}
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
    <!-- Edit group code -->
        <div class="modal fade" id="myModal2" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Recieve Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح گروههای تعریف شده</p></div>
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
                <div class="container"  style="margin: auto;background-color:lightgray;height: 220px ">
                    <form method="post" encType="multipart/form-data" id="group_edit_form" action="{{route('group.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input hidden class="form-control" id="ID_G_EDIT" name="ID_G_EDIT" >
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0">
                            <div class="field row" >
                                <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کد گروه</p></div>
                                <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="GROUP_CODE_EDIT"  data-toggle="tooltip" data-placement="right"  name="GROUP_CODE_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="کد گروه" placeholder="کد گروه"></div>
                            </div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1" name="GROUP_TYPE_EDIT" required id="GROUP_TYPE_EDIT" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع گروه</option>
                                    <option value="1">حقیقی</option>
                                    <option value="2">مجازی</option>
                                    <option value="3">ریجکت</option>
                                </select>
                            </div>

                        </div>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1 mt-2" name="ID_TG_EDIT" required id="ID_TG_EDIT" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="0">انتخاب نوع قطعات</option>
                                    @foreach($ghataats as $ghataat)
                                        <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row mt-0">
                            {{--<div class="col-9" style="text-align: right"><input type="text" maxlength="100" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%" required title="توضیحات"></div>--}}
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
    <!-- Define ghataat -->
        <div class="modal fade" id="myModal3" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین نام قطعات جدید</p></div>
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
                <div class="container"  style="margin: auto;background-color:lightgray;height: 300px ">
                    <form method="post" encType="multipart/form-data" id="equ_form" action="{{route('equ1.store')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input hidden type="text" class="form-control" id="ID_G_GH" name="ID_G" >
                            </div>
                        </div>
                        <div class="field row mt-2">
                            <div class="col-3" style="text-align: right"><p style="text-align: right;font-size:small;font-family: Tahoma;margin-top: 15px">شرکت سازنده:</p></div>
                            <div class="col-9" style="text-align: right;">
                                <select class="form-control isclicked1 mt-2" name="MAKER" required id="MAKER" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="">انتخاب شرکت سازنده</option>
                                    <option value="--">---</option>
                                    @foreach($sazs as $saz)
                                        <option value="{{$saz->ID_S}}">{{$saz->SAZANDEH}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0">
                                <div class="col-2" style="text-align: right"><p style="text-align: right;font-size: xx-small;font-family: Tahoma">شماره سریال</p></div>
                                <div class="col-10" style="text-align: right"> <input type="text" maxlength="20" class="form-control" id="SERIYAL_NUMBER"  data-toggle="tooltip" data-placement="right"  name="SERIYAL_NUMBER"  style="font-family: Tahoma;font-size: small;width: 40%;" required title="شماره سریال" placeholder="شماره سریال"></div>
                        </div>
                        <div class="row mt-0">
                                <div class="col-2" style="text-align: right"><p style="text-align: right;font-size: xx-small;font-family: Tahoma">شماره سریال قبلی</p></div>
                                <div class="col-10" style="text-align: right"> <input type="text" maxlength="20" class="form-control" id="SERIAL_NUMBER2"  data-toggle="tooltip" data-placement="right"  name="SERIAL_NUMBER2"  style="font-family: Tahoma;font-size: small;width: 40%;"  title="شماره سریال قبلی" placeholder="شماره سریال قبلی"></div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1" name="REAL_SOURE" id="REAL_SOURE" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع اصالت قطعه</option>
                                    <option value="0">--</option>
                                    <option value="1">اصلی</option>
                                    <option value="2">خرید ارزی</option>
                                    <option value="3">خرید داخلی</option>
                                    <option value="4">ساخت داخل</option>
                                    <option value="5">امانی</option>
                                    <option value="6">نامشخص</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row mt-0">
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
    <!-- Edit gataat -->
        <div class="modal fade" id="myModal4" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح نام قطعات جدید</p></div>
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
                <div class="container"  style="margin: auto;background-color:lightgray;height: 270px ">
                    <form method="post" encType="multipart/form-data" id="equ_edit" action="{{route('equ.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input hidden type="text" class="form-control" id="ID_E_EDIT" name="ID_E_EDIT2" >
                                <input hidden type="text" class="form-control" id="ID_G_EDIT3" name="ID_G_EDIT" >
                            </div>
                        </div>
                        <div class="field row mt-2">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1 mt-2" name="MAKER_EDIT" id="MAKER_EDIT" required style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="">انتخاب شرکت سازنده</option>
                                    @foreach($sazs as $saz)
                                        <option value="{{$saz->ID_S}}">{{$saz->SAZANDEH}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0">
                            <div class="col-2" style="text-align: right"><p style="text-align: right;font-size: xx-small;font-family: Tahoma">شماره سریال</p></div>
                            <div class="col-10" style="text-align: right"> <input type="text" maxlength="20" class="form-control" id="SERIYAL_NUMBER_EDIT"  data-toggle="tooltip" data-placement="right"  name="SERIYAL_NUMBER_EDIT"  style="font-family: Tahoma;font-size: small;width: 40%;" required title="شماره سریال" placeholder="شماره سریال"></div>
                        </div>
                        <div class="row mt-0">
                            <div class="col-2" style="text-align: right"><p style="text-align: right;font-size: xx-small;font-family: Tahoma">شماره سریال قبلی</p></div>
                            <div class="col-10" style="text-align: right"> <input type="text" maxlength="20" class="form-control" id="SERIAL_NUMBER2_EDIT"  data-toggle="tooltip" data-placement="right"  name="SERIAL_NUMBER2_EDIT"  style="font-family: Tahoma;font-size: small;width: 40%;"  title="شماره سریال قبلی" placeholder="شماره سریال قبلی"></div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1" name="REAL_SOURE_EDIT" id="REAL_SOURE_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع اصالت قطعه</option>
                                    <option value="0">--</option>
                                    <option value="1">اصلی</option>
                                    <option value="2">خرید ارزی</option>
                                    <option value="3">خرید داخلی</option>
                                    <option value="4">ساخت داخل</option>
                                    <option value="5">امانی</option>
                                    <option value="6">نامشخص</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row mt-0">
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
    <!-- Edit gataat total -->
        <div class="modal fade" id="myModal5" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح اطلاعات قطعات بصورت گروهی</p></div>
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
                <div class="container"  style="margin: auto;background-color:lightgray;height: 180px ">
                    <form method="post" encType="multipart/form-data" id="equ_edit2" action="{{route('equ2.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input hidden type="text" class="form-control" id="ID_E_EDIT" name="ID_E_EDIT2" >
                                <input hidden type="text" class="form-control" id="ID_G_EDIT2" name="ID_G_EDIT" >
                            </div>
                        </div>
                        <div class="field row mt-2">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1 mt-2" name="MAKER_EDIT" id="MAKER_EDIT2" required style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="">انتخاب شرکت سازنده</option>
                                    @foreach($sazs as $saz)
                                        <option value="{{$saz->ID_S}}">{{$saz->SAZANDEH}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1" name="REAL_SOURE_EDIT" id="REAL_SOURE_EDIT2" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع اصالت قطعه</option>
                                    <option value="0">--</option>
                                    <option value="1">اصلی</option>
                                    <option value="2">خرید ارزی</option>
                                    <option value="3">خرید داخلی</option>
                                    <option value="4">ساخت داخل</option>
                                    <option value="5">امانی</option>
                                    <option value="6">نامشخص</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row mt-0" style="text-align: center">
                            <div class="col-2"></div>
                            <div class="col-8" style="text-align: center"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت برای کلیه قطعات گروه انتخابی </button></div>
                            <div class="col-2"></div>
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

