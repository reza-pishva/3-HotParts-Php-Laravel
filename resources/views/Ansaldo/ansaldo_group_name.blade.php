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
    @include('Ansaldo.AnsaldoGroupNameComponents.component01') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component02') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component03') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component04') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component05') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component06') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component07') 
    @include('Ansaldo.AnsaldoGroupNameComponents.component08') 
@endsection

