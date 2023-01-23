@extends('layouts.ansaldo_layouts.app_base_tables')
@section('content')
<script>
    $(document).ready(function() {
        bootstrap.Toast.Default.delay = 2000
        $("#add_bazsaz").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtypgha").hide()
            $(".addtamirkar").hide()
            $(".addseller").hide()
            $(".addnir").hide()
            $(".addunit").hide()
            $(".addsaz").hide()
            $(".addbazsaz").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/bazsaz-total',
                method:'GET',
                success: function (response) {
                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var ID_BA = ''
                    var BAZSAZ = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                    $("#bazsaz_table").empty();
                    $("#bazsaz_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['ID_BA']+2000)
                        del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_BA']+3000)
                        ID_BA = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_BA'] + '</td>')
                        BAZSAZ = $('<td style="width: 40%;text-align: right">' + response.results[i]['BAZSAZ'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_BA, BAZSAZ,t1,t2)
                        $("#bazsaz_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_BA_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#BAZSAZ_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_ba = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");


                        Swal.fire({
                            title: 'مایل به حذف این شرکت هستید؟',
                            showDenyButton: true,
                            cancelButtonText: `بازگشت`,
                            confirmButtonText: `انصراف از حذف`,
                            denyButtonText: 'حذف شود',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                            } else if (result.isDenied) {

                                $.ajax({
                                    url: "/bazsaz-delete/" + id_ba,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_ba,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.n==0){
                                            $('#' + (Number(id_ba) + 3000)).closest('tr').remove();
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
                                            toastr.error('شرکت بازسازی کننده حذف گردید');
                                            $('#' + (Number(id_ba) + 3000)).closest('tr').remove();
                                            Swal.fire('حذف شد', '', 'success');
                                        }else{
                                            Swal.fire('به علت استفاده از نام این شرکت در برنامه های ارسال به بازسازی امکان حذف وجود ندارد', '', 'info')
                                        }
                                    }
                                });

                            }
                        })
                    })
                }
            })
        })
        $("#bazsaz_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/bazsaz-store",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#BAZSAZ').val('')
                    // $('#role_farsi').val('')
                    toastr.success("شرکت بازسازی کننده جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/bazsaz-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_BA = ''
                            var BAZSAZ = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#bazsaz_table").empty();
                            $("#bazsaz_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['ID_BA']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_BA']+3000)
                                ID_BA = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_BA'] + '</td>')
                                BAZSAZ = $('<td style="width: 40%;text-align: right">' + response.results[i]['BAZSAZ'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_BA, BAZSAZ,t1,t2)
                                $("#bazsaz_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_BA_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#BAZSAZ_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_ba = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");


                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/bazsaz-delete/" + id_ba,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_ba,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_ba) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت بازسازی کننده حذف گردید');
                                                    $('#' + (Number(id_ba) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در برنامه های ارسال به بازسازی امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })


                }
            });
        })
        $("#bazsaz_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/bazsaz-edit",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
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
                    toastr.info('شرکت بازسازی کننده تغییر نام داده شد')
                    $('#myModal6').modal('hide');


                    $.ajax({
                        url: '/bazsaz-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_BA = ''
                            var BAZSAZ = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#bazsaz_table").empty();
                            $("#bazsaz_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['ID_BA']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_BA']+3000)
                                ID_BA = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_BA'] + '</td>')
                                BAZSAZ = $('<td style="width: 40%;text-align: right">' + response.results[i]['BAZSAZ'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_BA, BAZSAZ,t1,t2)
                                $("#bazsaz_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_BA_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#BAZSAZ_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_ba = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");


                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/bazsaz-delete/" + id_ba,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_ba,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_ba) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت بازسازی کننده حذف گردید');
                                                    $('#' + (Number(id_ba) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در برنامه های ارسال به بازسازی امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })
                }
            });
            $('#myModal2').modal('hide');
        });

        $("#add_seller").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtypgha").hide()
            $(".addtamirkar").hide()
            $(".addbazsaz").hide()
            $(".addnir").hide()
            $(".addunit").hide()
            $(".addsaz").hide()
            $(".addseller").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/seller-total',
                method:'GET',
                success: function (response) {
                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var ID_SE = ''
                    var SELLER = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                    $("#seller_table").empty();
                    $("#seller_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal7">ویرایش</button>').attr('id',response.results[i]['ID_SE']+2000)
                        del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_SE']+3000)
                        ID_SE = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_SE'] + '</td>')
                        SELLER = $('<td style="width: 40%;text-align: right">' + response.results[i]['SELLER'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_SE, SELLER,t1,t2)
                        $("#seller_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_SE_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#SELLER_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_se = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");


                        Swal.fire({
                            title: 'مایل به حذف این شرکت هستید؟',
                            showDenyButton: true,
                            cancelButtonText: `بازگشت`,
                            confirmButtonText: `انصراف از حذف`,
                            denyButtonText: 'حذف شود',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                            } else if (result.isDenied) {

                                $.ajax({
                                    url: "/seller-delete/" + id_se,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_se,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.n==0){
                                            $('#' + (Number(id_se) + 3000)).closest('tr').remove();
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
                                            toastr.error('شرکت فروشنده قطعات حذف گردید');
                                            $('#' + (Number(id_se) + 3000)).closest('tr').remove();
                                            Swal.fire('حذف شد', '', 'success');
                                        }else{
                                            Swal.fire('به علت استفاده از نام این شرکت در برنامه های خرید امکان حذف وجود ندارد', '', 'info')
                                        }
                                    }
                                });

                            }
                        })
                    })
                }
            })
        })
        $("#seller_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/seller-store",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#SELLER').val('')
                    // $('#role_farsi').val('')
                    toastr.success("شرکت فروشنده جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/seller-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_SE = ''
                            var SELLER = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#seller_table").empty();
                            $("#seller_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal7">ویرایش</button>').attr('id',response.results[i]['ID_SE']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_SE']+3000)
                                ID_SE = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_SE'] + '</td>')
                                SELLER = $('<td style="width: 40%;text-align: right">' + response.results[i]['SELLER'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_SE, SELLER,t1,t2)
                                $("#seller_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_SE_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#SELLER_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_se = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");


                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/seller-delete/" + id_se,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_se,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_se) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت فروشنده قطعات حذف گردید');
                                                    $('#' + (Number(id_se) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در برنامه های خرید امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })


                }
            });
        })
        $("#seller_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/seller-edit",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
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
                    toastr.info('شرکت فروشنده تغییر نام داده شد')
                    $('#myModal7').modal('hide');


                    $.ajax({
                        url: '/seller-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_SE = ''
                            var SELLER = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#seller_table").empty();
                            $("#seller_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal7">ویرایش</button>').attr('id',response.results[i]['ID_SE']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_SE']+3000)
                                ID_SE = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_SE'] + '</td>')
                                SELLER = $('<td style="width: 40%;text-align: right">' + response.results[i]['SELLER'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_SE, SELLER,t1,t2)
                                $("#seller_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_SE_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#SELLER_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_se = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");


                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/seller-delete/" + id_se,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_se,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_se) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت فروشنده قطعات حذف گردید');
                                                    $('#' + (Number(id_se) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در برنامه های خرید امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })
                }
            });
            $('#myModal7').modal('hide');
        });

        $("#add_tamirkar").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtypgha").hide()
            $(".addseller").hide()
            $(".addbazsaz").hide()
            $(".addnir").hide()
            $(".addunit").hide()
            $(".addsaz").hide()
            $(".addtamirkar").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/tamirkar-total',
                method:'GET',
                success: function (response) {
                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var ID_TA = ''
                    var TAMIRKAR = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                    $("#tamirkar_table").empty();
                    $("#tamirkar_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal8">ویرایش</button>').attr('id',response.results[i]['ID_TA']+2000)
                        del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TA']+3000)
                        ID_TA = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_TA'] + '</td>')
                        TAMIRKAR = $('<td style="width: 40%;text-align: right">' + response.results[i]['TAMIRKAR'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_TA, TAMIRKAR,t1,t2)
                        $("#tamirkar_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#TAMIRKAR_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_ta = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        Swal.fire({
                            title: 'مایل به حذف این شرکت هستید؟',
                            showDenyButton: true,
                            cancelButtonText: `بازگشت`,
                            confirmButtonText: `انصراف از حذف`,
                            denyButtonText: 'حذف شود',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                            } else if (result.isDenied) {

                                $.ajax({
                                    url: "/tamirkar-delete/" + id_ta,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_ta,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.n==0){
                                            $('#' + (Number(id_ta) + 3000)).closest('tr').remove();
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
                                            toastr.error('شرکت فروشنده قطعات حذف گردید');
                                            $('#' + (Number(id_ta) + 3000)).closest('tr').remove();
                                            Swal.fire('حذف شد', '', 'success');
                                        }else{
                                            Swal.fire('به علت استفاده از نام این شرکت در برنامه های تعمیرات دوره ای امکان حذف وجود ندارد', '', 'info')
                                        }
                                    }
                                });

                            }
                        })
                    })
                }
            })
        })
        $("#tamirkar_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tamirkar-store",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {

                    $('#TAMIRKAR').val('')
                    // $('#role_farsi').val('')
                    toastr.success("شرکت تعمیرکاری جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/tamirkar-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_TA = ''
                            var TAMIRKAR = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#tamirkar_table").empty();
                            $("#tamirkar_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal8">ویرایش</button>').attr('id',response.results[i]['ID_TA']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TA']+3000)
                                ID_TA = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_TA'] + '</td>')
                                TAMIRKAR = $('<td style="width: 40%;text-align: right">' + response.results[i]['TAMIRKAR'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_TA, TAMIRKAR,t1,t2)
                                $("#tamirkar_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#TAMIRKAR_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_ta = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/tamirkar-delete/" + id_ta,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_ta,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_ta) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت فروشنده قطعات حذف گردید');
                                                    $('#' + (Number(id_ta) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در برنامه های تعمیرات دوره ای امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })


                }
            });
        })
        $("#tamirkar_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tamirkar-edit",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
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
                    toastr.info('شرکت تعمیرکاری تغییر نام داده شد')
                    $('#myModal8').modal('hide');


                    $.ajax({
                        url: '/tamirkar-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_TA = ''
                            var TAMIRKAR = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#tamirkar_table").empty();
                            $("#tamirkar_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal8">ویرایش</button>').attr('id',response.results[i]['ID_TA']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TA']+3000)
                                ID_TA = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_TA'] + '</td>')
                                TAMIRKAR = $('<td style="width: 40%;text-align: right">' + response.results[i]['TAMIRKAR'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_TA, TAMIRKAR,t1,t2)
                                $("#tamirkar_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_TA_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#TAMIRKAR_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_ta = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/tamirkar-delete/" + id_ta,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_ta,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_ta) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت فروشنده قطعات حذف گردید');
                                                    $('#' + (Number(id_ta) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در برنامه های تعمیرات دوره ای امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })
                }
            });
            $('#myModal7').modal('hide');
        });

        $("#add_tamiratty").on('click',function (event) {
            event.preventDefault();
            $(".addtypgha").hide()
            $(".addtamirkar").hide()
            $(".addseller").hide()
            $(".addbazsaz").hide()
            $(".addnir").hide()
            $(".addunit").hide()
            $(".addsaz").hide()
            $(".addtamiratty").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/tamiratty-total',
                method:'GET',
                success: function (response) {
                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var ID_TT = ''
                    var TAMIRAT_TYPE = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نوع تعمیرات</td><td>#</td><td>#</td></tr>')
                    $("#tamiratty_table").empty();
                    $("#tamiratty_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal9">ویرایش</button>').attr('id',response.results[i]['ID_TT']+2000)
                        del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TT']+3000)
                        ID_TT = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_TT'] + '</td>')
                        TAMIRAT_TYPE = $('<td style="width: 40%;text-align: right">' + response.results[i]['TAMIRAT_TYPE'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_TT, TAMIRAT_TYPE,t1,t2)
                        $("#tamiratty_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#TAMIRAT_TYPE_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_tt = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        Swal.fire({
                            title: 'مایل به حذف این نوع تعمیرات هستید؟',
                            showDenyButton: true,
                            cancelButtonText: `بازگشت`,
                            confirmButtonText: `انصراف از حذف`,
                            denyButtonText: 'حذف شود',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire('این نوع از تعمیرات حذف نشد', '', 'info')
                            } else if (result.isDenied) {

                                $.ajax({
                                    url: "/tamiratty-delete/" + id_tt,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_tt,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.n==0){
                                            $('#' + (Number(id_tt) + 3000)).closest('tr').remove();
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
                                            toastr.error('این نوع از تعمیرات حذف گردید');
                                            $('#' + (Number(id_tt) + 3000)).closest('tr').remove();
                                            Swal.fire('حذف شد', '', 'success');
                                        }else{
                                            Swal.fire('به علت استفاده از این نوع تعمیرات در تعریف تعمیرات دوره ای امکان حذف وجود ندارد', '', 'info')
                                        }
                                    }
                                });

                            }
                        })
                    })

                }
            })
        })
        $("#tamiratty_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tamiratty-store",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#TAMIRAT_TYPE').val('')
                    // $('#role_farsi').val('')
                    toastr.success("شرکت تعمیرکاری جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/tamiratty-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_TT = ''
                            var TAMIRAT_TYPE = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام شرکت</td><td>#</td><td>#</td></tr>')
                            $("#tamiratty_table").empty();
                            $("#tamiratty_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal9">ویرایش</button>').attr('id',response.results[i]['ID_TT']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TT']+3000)
                                ID_TT = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_TT'] + '</td>')
                                TAMIRAT_TYPE = $('<td style="width: 40%;text-align: right">' + response.results[i]['TAMIRAT_TYPE'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_TT, TAMIRAT_TYPE,t1,t2)
                                $("#tamiratty_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#TAMIRAT_TYPE_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_tt = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این نوع تعمیرات هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('این نوع از تعمیرات حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/tamiratty-delete/" + id_tt,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_tt,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_tt) + 3000)).closest('tr').remove();
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
                                                    toastr.error('این نوع از تعمیرات حذف گردید');
                                                    $('#' + (Number(id_tt) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از این نوع تعمیرات در تعریف تعمیرات دوره ای امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })


                }
            });
        })
        $("#tamiratty_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/tamiratty-edit",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
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
                    toastr.info('شرکت تعمیرکاری تغییر نام داده شد')
                    $('#myModal9').modal('hide');


                    $.ajax({
                        url: '/tamiratty-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_TT = ''
                            var TAMIRAT_TYPE = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نوع تعمیرات</td><td>#</td><td>#</td></tr>')
                            $("#tamiratty_table").empty();
                            $("#tamiratty_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal9">ویرایش</button>').attr('id',response.results[i]['ID_TT']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TT']+3000)
                                ID_TT = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_TT'] + '</td>')
                                TAMIRAT_TYPE = $('<td style="width: 40%;text-align: right">' + response.results[i]['TAMIRAT_TYPE'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_TT, TAMIRAT_TYPE,t1,t2)
                                $("#tamiratty_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_TT_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#TAMIRAT_TYPE_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_tt = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این نوع تعمیرات هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('این نوع از تعمیرات حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/tamiratty-delete/" + id_tt,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_tt,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_tt) + 3000)).closest('tr').remove();
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
                                                    toastr.error('این نوع از تعمیرات حذف گردید');
                                                    $('#' + (Number(id_tt) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از این نوع تعمیرات در تعریف تعمیرات دوره ای امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })
                }
            });
            $('#myModal7').modal('hide');
        });

        $("#add_typgha").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtamirkar").hide()
            $(".addseller").hide()
            $(".addbazsaz").hide()
            $(".addnir").hide()
            $(".addunit").hide()
            $(".addsaz").hide()
            $(".addtypgha").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/typgha-total',
                method:'GET',
                success: function (response) {
                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var ID_TG = ''
                    var GHATAAT_NAME = ''
                    var TIME_STANDARD = ''
                    var TYPE_CODE = ''
                    var SET_COUNT = ''
                    var COUNTB_REJECT = ''
                    var TIME_REJECT = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام قطعه</td><td>کد قطعه</td><td>#</td><td>#</td></tr>')
                    $("#typgha_table").empty();
                    $("#typgha_table").append(th)
                    for (var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal10">ویرایش</button>').attr('id', response.results[i]['ID_TG'] + 2000)
                        del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id', response.results[i]['ID_TG'] + 3000)
                        ID_TG = $('<td class="id_gr" style="width: 5%">' + response.results[i]['ID_TG'] + '</td>')
                        GHATAAT_NAME = $('<td style="width: 33%;text-align: right">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                        TYPE_CODE = $('<td style="width: 32%;text-align: right">' + response.results[i]['TYPE_CODE'] + '</td>')
                        TIME_STANDARD = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['TIME_STANDARD'] + '</td>')
                        SET_COUNT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['SET_COUNT'] + '</td>')
                        COUNTB_REJECT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['COUNTB_REJECT'] + '</td>')
                        TIME_REJECT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['TIME_REJECT'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_TG, GHATAAT_NAME, TYPE_CODE, TIME_STANDARD, SET_COUNT, COUNTB_REJECT, TIME_REJECT, t1, t2)
                        $("#typgha_table").append(row)

                    }
                    $(".edit1").on('click', function () {
                        $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#GHATAAT_NAME_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                        $('#TYPE_CODE_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                        $('#TIME_STANDARD_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                        $('#SET_COUNT_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                        $('#COUNTB_REJECT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                        $('#TIME_REJECT_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                    })
                    $(".del1").on('click', function () {
                        var id_tg = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        Swal.fire({
                            title: 'مایل به حذف این نوع قطعات هستید؟',
                            showDenyButton: true,
                            cancelButtonText: `بازگشت`,
                            confirmButtonText: `انصراف از حذف`,
                            denyButtonText: 'حذف شود',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire('این نوع از قطعات حذف نشد', '', 'info')
                            } else if (result.isDenied) {

                                $.ajax({
                                    url: "/typgha-delete/" + id_tg,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_tg,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if (response.n == 0) {
                                            $('#' + (Number(id_tg) + 3000)).closest('tr').remove();
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
                                            toastr.error('این نوع از قطعات حذف گردید');
                                            $('#' + (Number(id_tg) + 3000)).closest('tr').remove();
                                            Swal.fire('حذف شد', '', 'success');
                                        } else {
                                            Swal.fire('به علت استفاده از این نوع قطعه در جداول مختلف امکان حذف وجود ندارد', '', 'info')
                                        }
                                    }
                                });

                            }
                        })
                    })
                }
            })
        })
        $("#typgha_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/typgha-store',
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#ID_TG').val('')
                    $('#GHATAAT_NAME').val('')
                    $('#TYPE_CODE').val('')
                    $('#TIME_STANDARD').val('')
                    $('#SET_COUNT').val('')
                    $('#COUNTB_REJECT').val('')
                    $('#TIME_REJECT').val('')
                    toastr.success("نوع قطعه جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/typgha-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_TG = ''
                            var GHATAAT_NAME = ''
                            var TIME_STANDARD = ''
                            var TYPE_CODE = ''
                            var SET_COUNT = ''
                            var COUNTB_REJECT = ''
                            var TIME_REJECT = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام قطعه</td><td>کد قطعه</td><td>#</td><td>#</td></tr>')
                            $("#typgha_table").empty();
                            $("#typgha_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal10">ویرایش</button>').attr('id',response.results[i]['ID_TG']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TG']+3000)
                                ID_TG = $('<td class="id_gr" style="width: 5%">' + response.results[i]['ID_TG'] + '</td>')
                                GHATAAT_NAME = $('<td style="width: 33%;text-align: right">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                TYPE_CODE = $('<td style="width: 32%;text-align: right">' + response.results[i]['TYPE_CODE'] + '</td>')
                                TIME_STANDARD = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['TIME_STANDARD'] + '</td>')
                                SET_COUNT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['SET_COUNT'] + '</td>')
                                COUNTB_REJECT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['COUNTB_REJECT'] + '</td>')
                                TIME_REJECT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['TIME_REJECT'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_TG, GHATAAT_NAME,TYPE_CODE,TIME_STANDARD,SET_COUNT,COUNTB_REJECT,TIME_REJECT,t1,t2)
                                $("#typgha_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#GHATAAT_NAME_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                $('#TYPE_CODE_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                $('#TIME_STANDARD_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                $('#SET_COUNT_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                $('#COUNTB_REJECT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#TIME_REJECT_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                            })
                            $(".del1").on('click', function () {
                                var id_tg = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این نوع قطعات هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('این نوع از قطعات حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/typgha-delete/" + id_tg,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_tg,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if (response.n == 0) {
                                                    $('#' + (Number(id_tg) + 3000)).closest('tr').remove();
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
                                                    toastr.error('این نوع از قطعات حذف گردید');
                                                    $('#' + (Number(id_tg) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                } else {
                                                    Swal.fire('به علت استفاده از این نوع قطعه در جداول مختلف امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })


                }
            })
        })
        $("#typgha_edit").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/typgha-edit',
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    //$('#NIROGAH_NAME').val('')
                    // $('#role_farsi').val('')
                    toastr.success("نوع قطعه اصلاح گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/typgha-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_TG = ''
                            var GHATAAT_NAME = ''
                            var TIME_STANDARD = ''
                            var TYPE_CODE = ''
                            var SET_COUNT = ''
                            var COUNTB_REJECT = ''
                            var TIME_REJECT = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام قطعه</td><td>کد قطعه</td><td>#</td><td>#</td></tr>')
                            $("#typgha_table").empty();
                            $("#typgha_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal10">ویرایش</button>').attr('id',response.results[i]['ID_TG']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_TG']+3000)
                                ID_TG = $('<td class="id_gr" style="width: 5%">' + response.results[i]['ID_TG'] + '</td>')
                                GHATAAT_NAME = $('<td style="width: 33%;text-align: right">' + response.results[i]['GHATAAT_NAME'] + '</td>')
                                TYPE_CODE = $('<td style="width: 32%;text-align: right">' + response.results[i]['TYPE_CODE'] + '</td>')
                                TIME_STANDARD = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['TIME_STANDARD'] + '</td>')
                                SET_COUNT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['SET_COUNT'] + '</td>')
                                COUNTB_REJECT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['COUNTB_REJECT'] + '</td>')
                                TIME_REJECT = $('<td hidden style="width: 32%;text-align: right">' + response.results[i]['TIME_REJECT'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_TG, GHATAAT_NAME,TYPE_CODE,TIME_STANDARD,SET_COUNT,COUNTB_REJECT,TIME_REJECT,t1,t2)
                                $("#typgha_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_TG_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#GHATAAT_NAME_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                $('#TYPE_CODE_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                                $('#TIME_STANDARD_EDIT').val($(this).closest('tr').find('td:eq(4)').text())
                                $('#SET_COUNT_EDIT').val($(this).closest('tr').find('td:eq(5)').text())
                                $('#COUNTB_REJECT_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#TIME_REJECT_EDIT').val($(this).closest('tr').find('td:eq(7)').text())
                            })
                            $(".del1").on('click', function () {
                                var id_tg = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این نوع قطعات هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('این نوع از قطعات حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/typgha-delete/" + id_tg,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_tg,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if (response.n == 0) {
                                                    $('#' + (Number(id_tg) + 3000)).closest('tr').remove();
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
                                                    toastr.error('این نوع از قطعات حذف گردید');
                                                    $('#' + (Number(id_tg) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                } else {
                                                    Swal.fire('به علت استفاده از این نوع قطعه در جداول مختلف امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }

                    })

                    $('#myModal10').modal('hide');
                }
            })
        })

        $("#add_nir").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtamirkar").hide()
            $(".addseller").hide()
            $(".addbazsaz").hide()
            $(".addtypgha").hide()
            $(".addunit").hide()
            $(".addsaz").hide()
            $(".addnir").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/nir-total',
                method:'GET',
                success: function (response) {
                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var ID_NN = ''
                    var NIROGAH_NAME = ''
                    var t1 = ''
                    var t2 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام نیروگاه</td><td>#</td><td>#</td></tr>')
                    $("#nir_table").empty();
                    $("#nir_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal12">ویرایش</button>').attr('id',response.results[i]['ID_NN']+2000)
                        del2 = $('<button disabled type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_NN']+3000)
                        ID_NN = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_NN'] + '</td>')
                        NIROGAH_NAME = $('<td style="width: 40%;text-align: right">' + response.results[i]['NIROGAH_NAME'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_NN, NIROGAH_NAME,t1,t2)
                        $("#nir_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_NN_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#NIROGAH_NAME_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_nn = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: "/nir-delete/" + id_nn,
                            type: 'DELETE',
                            data: {
                                "id": id_nn,
                                "_token": token,
                            },
                            success: function () {
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
                                toastr.error('نیروگاه انتخابی حذف گردید');
                                $('#' + (Number(id_nn) + 3000)).closest('tr').remove();

                            }
                        });
                    })
                }
            })
        })
        $("#nir_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/nir-store',
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#NIROGAH_NAME').val('')
                    // $('#role_farsi').val('')
                    toastr.success("نیروگاه جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/nir-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_NN = ''
                            var NIROGAH_NAME = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام نیروگاه</td><td>#</td><td>#</td></tr>')
                            $("#nir_table").empty();
                            $("#nir_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal12">ویرایش</button>').attr('id',response.results[i]['ID_NN']+2000)
                                del2 = $('<button disabled type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_NN']+3000)
                                ID_NN = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_NN'] + '</td>')
                                NIROGAH_NAME = $('<td style="width: 40%;text-align: right">' + response.results[i]['NIROGAH_NAME'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_NN, NIROGAH_NAME,t1,t2)
                                $("#nir_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_NN_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#NIROGAH_NAME_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_nn = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/nir-delete/" + id_nn,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_nn,
                                        "_token": token,
                                    },
                                    success: function () {
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
                                        toastr.error('نیروگاه انتخابی حذف گردید');
                                        $('#' + (Number(id_nn) + 3000)).closest('tr').remove();

                                    }
                                });
                            })
                        }
                    })


                }
            })
        })
        $("#nir_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/nir-edit",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
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
                    toastr.info('نام نیروگاه تغییر نام داده شد')
                    $('#myModal12').modal('hide');


                    $.ajax({
                        url: '/nir-total',
                        method:'GET',
                        success: function (response) {
                            var select = ''
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var ID_NN = ''
                            var NIROGAH_NAME = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام نیروگاه</td><td>#</td><td>#</td></tr>')
                            $("#nir_table").empty();
                            $("#nir_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal12">ویرایش</button>').attr('id',response.results[i]['ID_NN']+2000)
                                del2 = $('<button disabled type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_NN']+3000)
                                ID_NN = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_NN'] + '</td>')
                                NIROGAH_NAME = $('<td style="width: 40%;text-align: right">' + response.results[i]['NIROGAH_NAME'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_NN, NIROGAH_NAME,t1,t2)
                                $("#nir_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_NN_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#NIROGAH_NAME_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_nn = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/nir-delete/" + id_nn,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_nn,
                                        "_token": token,
                                    },
                                    success: function () {
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
                                        toastr.error('نیروگاه انتخابی حذف گردید');
                                        $('#' + (Number(id_nn) + 3000)).closest('tr').remove();

                                    }
                                });
                            })
                        }
                    })
                }
            });
            $('#myModal2').modal('hide');
        });

        $("#add_unit").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtamirkar").hide()
            $(".addseller").hide()
            $(".addbazsaz").hide()
            $(".addtypgha").hide()
            $(".addnir").hide()
            $(".addsaz").hide()
            $(".addunit").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/un-total',
                method:'GET',
                success: function (response) {

                    var select = ''
                    var edit1 = ''
                    var del2 = ''
                    var ID_NN = ''
                    var ID_UN = ''
                    var UNIT_NUMBER = ''
                    var unitNumberDigit = ''
                    var t1 = ''
                    var t2 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: right">نام واحد نیروگاه</td><td  style="text-align: right">شماره واحد</td><td>#</td><td>#</td></tr>')
                    $("#un_table").empty();
                    $("#un_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button  type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal13">ویرایش</button>').attr('id',response.results[i]['ID_UN']+2000)
                        del2 = $('<button disabled type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_UN']+3000)
                        ID_UN = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_UN'] + '</td>')
                        ID_NN = $('<td hidden class="id_gr" style="width: 10%">' + response.results[i]['ID_NN'] + '</td>')
                        UNIT_NUMBER = $('<td style="width: 40%;text-align: right">' + response.results[i]['UNIT_NUMBER'] + '</td>')
                        unitNumberDigit = $('<td style="width: 20%;text-align: right">' + response.results[i]['unitNumberDigit'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_UN, UNIT_NUMBER,unitNumberDigit,t1,t2,ID_NN)
                        $("#un_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#ID_NN_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                        $('#UNIT_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                        $('#unitNumberDigit_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                    })
                    $(".del1").on('click',function () {

                        var id_un = $(this).closest('tr').find('td:eq(1)').text();

                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: "/un-delete/" + id_un,
                            type: 'DELETE',
                            data: {
                                "id": id_un,
                                "_token": token,
                            },
                            success: function () {
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
                                toastr.error('واحدانتخابی حذف گردید');
                                $('#' + (Number(id_un) + 3000)).closest('tr').remove();

                            }
                        });
                    })
                }
            })
        })
        $("#un_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/un-store',
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#UNIT_NUMBER').val('')
                    $('#unitNumberDigit').val('')
                    toastr.success("نام واحد جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/un-total',
                        method:'GET',
                        success: function (response) {
                            var select='';
                            var edit1 = ''
                            var del2 = ''
                            var ID_NN = ''
                            var ID_UN = ''
                            var UNIT_NUMBER = ''
                            var unitNumberDigit = ''
                            var t1 = ''
                            var t2 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: right">نام واحد نیروگاه</td><td  style="text-align: right">شماره واحد</td><td>#</td><td>#</td></tr>')
                            $("#un_table").empty();
                            $("#un_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal13">ویرایش</button>').attr('id',response.results[i]['ID_UN']+2000)
                                del2 = $('<button disabled type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_UN']+3000)
                                ID_UN = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_UN'] + '</td>')
                                ID_NN = $('<td hidden class="id_gr" style="width: 10%">' + response.results[i]['ID_NN'] + '</td>')
                                UNIT_NUMBER = $('<td style="width: 40%;text-align: right">' + response.results[i]['UNIT_NUMBER'] + '</td>')
                                unitNumberDigit = $('<td style="width: 20%;text-align: right">' + response.results[i]['unitNumberDigit'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_UN, UNIT_NUMBER,unitNumberDigit,t1,t2,ID_NN)
                                $("#un_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_NN_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#UNIT_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                $('#unitNumberDigit_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                            })
                            $(".del1").on('click',function () {

                                var id_un = $(this).closest('tr').find('td:eq(1)').text();

                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/un-delete/" + id_un,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_un,
                                        "_token": token,
                                    },
                                    success: function () {
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
                                        toastr.error('واحدانتخابی حذف گردید');
                                        $('#' + (Number(id_un) + 3000)).closest('tr').remove();

                                    }
                                });
                            })
                        }
                    })


                }
            })
        })
        $("#un_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/un-edit',
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#UNIT_NUMBER').val('')
                    $('#unitNumberDigit').val('')
                    toastr.success("نام واحد انتخابی با موفقیت اصلاح گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/un-total',
                        method:'GET',
                        success: function (response) {
                            var select='';
                            var edit1 = ''
                            var del2 = ''
                            var ID_NN = ''
                            var ID_UN = ''
                            var UNIT_NUMBER = ''
                            var unitNumberDigit = ''
                            var t1 = ''
                            var t2 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td style="text-align: right">نام واحد نیروگاه</td><td  style="text-align: right">شماره واحد</td><td>#</td><td>#</td></tr>')
                            $("#un_table").empty();
                            $("#un_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal13">ویرایش</button>').attr('id',response.results[i]['ID_UN']+2000)
                                del2 = $('<button disabled type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_UN']+3000)
                                ID_UN = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_UN'] + '</td>')
                                ID_NN = $('<td hidden class="id_gr" style="width: 10%">' + response.results[i]['ID_NN'] + '</td>')
                                UNIT_NUMBER = $('<td style="width: 40%;text-align: right">' + response.results[i]['UNIT_NUMBER'] + '</td>')
                                unitNumberDigit = $('<td style="width: 20%;text-align: right">' + response.results[i]['unitNumberDigit'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_UN, UNIT_NUMBER,unitNumberDigit,t1,t2,ID_NN)
                                $("#un_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_UN_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#ID_NN_EDIT').val($(this).closest('tr').find('td:eq(6)').text())
                                $('#UNIT_NUMBER_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                                $('#unitNumberDigit_EDIT').val($(this).closest('tr').find('td:eq(3)').text())
                            })
                            $(".del1").on('click',function () {

                                var id_un = $(this).closest('tr').find('td:eq(1)').text();

                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/un-delete/" + id_un,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_un,
                                        "_token": token,
                                    },
                                    success: function () {
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
                                        toastr.error('واحدانتخابی حذف گردید');
                                        $('#' + (Number(id_un) + 3000)).closest('tr').remove();

                                    }
                                });
                            })
                        }
                    })


                }
            })
            $('#myModal13').modal('hide');
        });

        $("#add_sazandeh").on('click',function (event) {
            event.preventDefault();
            $(".addtamiratty").hide()
            $(".addtamirkar").hide()
            $(".addseller").hide()
            $(".addbazsaz").hide()
            $(".addtypgha").hide()
            $(".addunit").hide()
            $(".addsaz").fadeToggle(2000);
            $("#SAZANDEH").val('')
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/saz-total',
                method:'GET',
                success: function (response) {
                    var select='';
                    var edit1 = ''
                    var del2 = ''
                    var ID_S  = ''
                    var SAZANDEH = ''
                    var t1 = ''
                    var t2 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام سازنده</td><td>#</td><td>#</td></tr>')
                    $("#saz_table").empty();
                    $("#saz_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                            $("tr.table1").css("background-color", "white");
                            $("tr.table1").css("color", "black");
                            $(this).closest('tr.table1').css("background-color", "#66CDAA");
                            $(this).closest('tr.table1').css("color", "white");
                        })
                        edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal14">ویرایش</button>').attr('id',response.results[i]['ID_NN']+2000)
                        del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_S']+3000)
                        ID_S  = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_S'] + '</td>')
                        SAZANDEH = $('<td style="width: 40%;text-align: right">' + response.results[i]['SAZANDEH'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t4 = $('<td style="width: 5%"></td>')
                        t2.append(del2)
                        t4.append(select)
                        row = $('<tr class="table1"></tr>')
                        row.append(t4,ID_S, SAZANDEH,t1,t2)
                        $("#saz_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#ID_S_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#SAZANDEH_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_s = $(this).closest('tr').find('td:eq(1)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        Swal.fire({
                            title: 'مایل به حذف این شرکت هستید؟',
                            showDenyButton: true,
                            cancelButtonText: `بازگشت`,
                            confirmButtonText: `انصراف از حذف`,
                            denyButtonText: 'حذف شود',
                        }).then((result) => {
                            if (result.isConfirmed) {

                                Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                            } else if (result.isDenied) {

                                $.ajax({
                                    url: "/saz-delete/" + id_s,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_s,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.n==0){
                                            $('#' + (Number(id_s) + 3000)).closest('tr').remove();
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
                                            toastr.error('شرکت سازنده قطعات حذف گردید');
                                            $('#' + (Number(id_s) + 3000)).closest('tr').remove();
                                            Swal.fire('حذف شد', '', 'success');
                                        }else{
                                            Swal.fire('به علت استفاده از نام این شرکت در بخش انتساب قطعات به گروهها امکان حذف وجود ندارد', '', 'info')
                                        }
                                    }
                                });

                            }
                        })
                    })
                }
            })
        })
        $("#sazandeh_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/saz-store',
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#SAZANDEH').val('')
                    // $('#role_farsi').val('')
                    toastr.success("شرکت سازنده جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/saz-total',
                        method:'GET',
                        success: function (response) {
                            var select='';
                            var edit1 = ''
                            var del2 = ''
                            var ID_S  = ''
                            var SAZANDEH = ''
                            var t1 = ''
                            var t2 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام سازنده</td><td>#</td><td>#</td></tr>')
                            $("#saz_table").empty();
                            $("#saz_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal14">ویرایش</button>').attr('id',response.results[i]['ID_NN']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_S']+3000)
                                ID_S  = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_S'] + '</td>')
                                SAZANDEH = $('<td style="width: 40%;text-align: right">' + response.results[i]['SAZANDEH'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_S, SAZANDEH,t1,t2)
                                $("#saz_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_S_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#SAZANDEH_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_s = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/saz-delete/" + id_s,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_s,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_s) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت سازنده قطعات حذف گردید');
                                                    $('#' + (Number(id_s) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در بخش انتساب قطعات به گروهها امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })


                }
            })
        })
        $("#sazandeh_edit").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/saz-edit",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
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
                    toastr.info('نام شرکت سازنده تغییر داده شد')
                    $('#myModal14').modal('hide');


                    $.ajax({
                        url: '/saz-total',
                        method:'GET',
                        success: function (response) {
                            var select='';
                            var edit1 = ''
                            var del2 = ''
                            var ID_S  = ''
                            var SAZANDEH = ''
                            var t1 = ''
                            var t2 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام سازنده</td><td>#</td><td>#</td></tr>')
                            $("#saz_table").empty();
                            $("#saz_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                select = $('<button type="button" class="btn-sm border-info select_send" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">>></button>').on('click',function (event) {
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#66CDAA");
                                    $(this).closest('tr.table1').css("color", "white");
                                })
                                edit1 = $('<button type="button" class="btn-sm border-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal14">ویرایش</button>').attr('id',response.results[i]['ID_NN']+2000)
                                del2 = $('<button type="button" class="btn-sm border-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.results[i]['ID_S']+3000)
                                ID_S  = $('<td class="id_gr" style="width: 10%">' + response.results[i]['ID_S'] + '</td>')
                                SAZANDEH = $('<td style="width: 40%;text-align: right">' + response.results[i]['SAZANDEH'] + '</td>')
                                t1 = $('<td style="width: 5%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 5%"></td>')
                                t4 = $('<td style="width: 5%"></td>')
                                t2.append(del2)
                                t4.append(select)
                                row = $('<tr class="table1"></tr>')
                                row.append(t4,ID_S, SAZANDEH,t1,t2)
                                $("#saz_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#ID_S_EDIT').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#SAZANDEH_EDIT').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_s = $(this).closest('tr').find('td:eq(1)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                Swal.fire({
                                    title: 'مایل به حذف این شرکت هستید؟',
                                    showDenyButton: true,
                                    cancelButtonText: `بازگشت`,
                                    confirmButtonText: `انصراف از حذف`,
                                    denyButtonText: 'حذف شود',
                                }).then((result) => {
                                    if (result.isConfirmed) {

                                        Swal.fire('شرکت انتخابی حذف نشد', '', 'info')
                                    } else if (result.isDenied) {

                                        $.ajax({
                                            url: "/saz-delete/" + id_s,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_s,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                if(response.n==0){
                                                    $('#' + (Number(id_s) + 3000)).closest('tr').remove();
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
                                                    toastr.error('شرکت سازنده قطعات حذف گردید');
                                                    $('#' + (Number(id_s) + 3000)).closest('tr').remove();
                                                    Swal.fire('حذف شد', '', 'success');
                                                }else{
                                                    Swal.fire('به علت استفاده از نام این شرکت در بخش انتساب قطعات به گروهها امکان حذف وجود ندارد', '', 'info')
                                                }
                                            }
                                        });

                                    }
                                })
                            })
                        }
                    })
                }
            });

        });

    })
</script>

    <div class="container" style="direction: rtl;margin-left: 20px;width: 1100px">
        @include('Ansaldo.AnsaldoBaseTableComponents.component01')
        @include('Ansaldo.AnsaldoBaseTableComponents.component02')
        @include('Ansaldo.AnsaldoBaseTableComponents.component03')
        @include('Ansaldo.AnsaldoBaseTableComponents.component04')
        @include('Ansaldo.AnsaldoBaseTableComponents.component05')
        @include('Ansaldo.AnsaldoBaseTableComponents.component06')
        @include('Ansaldo.AnsaldoBaseTableComponents.component07')
        @include('Ansaldo.AnsaldoBaseTableComponents.component08')
        @include('Ansaldo.AnsaldoBaseTableComponents.component09')
        @include('Ansaldo.AnsaldoBaseTableComponents.component10')
        @include('Ansaldo.AnsaldoBaseTableComponents.component11')
        @include('Ansaldo.AnsaldoBaseTableComponents.component12')
        @include('Ansaldo.AnsaldoBaseTableComponents.component13')
        @include('Ansaldo.AnsaldoBaseTableComponents.component14')
        @include('Ansaldo.AnsaldoBaseTableComponents.component15')
        @include('Ansaldo.AnsaldoBaseTableComponents.component16')
        @include('Ansaldo.AnsaldoBaseTableComponents.component17')
        @include('Ansaldo.AnsaldoBaseTableComponents.component18')
        @include('Ansaldo.AnsaldoBaseTableComponents.component19')
        @include('Ansaldo.AnsaldoBaseTableComponents.component20')
        @include('Ansaldo.AnsaldoBaseTableComponents.component21')
        @include('Ansaldo.AnsaldoBaseTableComponents.component22')
        @include('Ansaldo.AnsaldoBaseTableComponents.component23')
        @include('Ansaldo.AnsaldoBaseTableComponents.component24')
    </div>



@endsection

