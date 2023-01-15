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
<!-- List of content -->

    <div class="container" style="direction: rtl;margin-left: 20px;width: 1100px">
        <div class="row addbazsaz" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام شرکت بازسازی کننده</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addbazsaz" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="bazsaz_form" action={{route('bazsaz.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_BA" name="ID_BA" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="40" class="form-control" id="BAZSAZ" data-toggle="tooltip" data-placement="right" title="نام شرکت بازسازی کننده" placeholder="نام شرکت بازسازی کننده" name="BAZSAZ" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="bazsaz_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام شرکت بازسازی کننده</td>
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
        <div class="row usergroup" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نام شرکت سازنده</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal6" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام شرکت بازسازی کننده</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="bazsaz_edit" action="{{route('bazsaz.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="ID_BA_EDIT"  name="ID_BA_EDIT">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام شرکت بازسازی کننده:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" maxlength="40" class="form-control" id="BAZSAZ_EDIT" required name="BAZSAZ_EDIT" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                                </div>
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

        <div class="row addseller" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام شرکت فروشنده</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addseller" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="seller_form" action={{route('seller.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_SE" name="ID_SE" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="40" class="form-control" id="SELLER" data-toggle="tooltip" data-placement="right" title="نام شرکت فروشنده" placeholder="نام شرکت فروشنده" name="SELLER" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="seller_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام شرکت فروشنده</td>
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
        <div class="row usergroup2" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نام شرکت سازنده</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal7" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام شرکت فروشنده</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="seller_edit" action="{{route('seller.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="ID_SE_EDIT"  name="ID_SE_EDIT">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام شرکت فروشنده:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" maxlength="40" class="form-control" id="SELLER_EDIT" required name="SELLER_EDIT" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                                </div>
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

        <div class="row addtamirkar" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام شرکت تعمیرکاری</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addtamirkar" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="tamirkar_form" action={{route('tamirkar.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_TA" name="ID_TA" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="40" class="form-control" id="TAMIRKAR"  data-toggle="tooltip" data-placement="right" title="نام شرکت تعمیرکاری" placeholder="نام شرکت تعمیرکاری" name="TAMIRKAR" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="tamirkar_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام شرکت تعمیرکار</td>
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
        <div class="row usergroup3" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نام شرکت تعمیرکاری</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal8" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام شرکت تعمیرکاری</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="tamirkar_edit" action="{{route('tamirkar.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="ID_TA_EDIT"  name="ID_TA_EDIT">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام شرکت تعمیرکاری:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" maxlength="40" class="form-control" id="TAMIRKAR_EDIT" required name="TAMIRKAR_EDIT" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                                </div>
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

        <div class="row addtamiratty" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نوع تعمیرات</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addtamiratty" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="tamiratty_form" action={{route('tamiratty.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_TT" name="ID_TT" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="40" class="form-control" id="TAMIRAT_TYPE"  data-toggle="tooltip" data-placement="right" title="نوع تعمیرات" placeholder="نوع تعمیرات" name="TAMIRAT_TYPE" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="tamiratty_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نوع تعمیرات</td>
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
        <div class="row usergroup4" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نوع تعمیرات</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal9" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نوع تعمیرات</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="tamiratty_edit" action="{{route('tamiratty.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="ID_TT_EDIT"  name="ID_TT_EDIT">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نوع تعمیرات:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" maxlength="40" class="form-control" id="TAMIRAT_TYPE_EDIT" required name="TAMIRAT_TYPE_EDIT" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="margin-top: 20px">
                                    <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                                </div>
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

        <div class="row addtypgha" id="typgha" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نوع قطعات</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addtypgha" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="typgha_form" action={{route('typgha.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_TG" name="ID_TG" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="40" class="form-control" id="GHATAAT_NAME"  data-toggle="tooltip" data-placement="right" placeholder="نام قطعه" name="GHATAAT_NAME" title="نام قطعه" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4">
                            <input type="number" max="999999" class="form-control" id="TIME_STANDARD"  data-toggle="tooltip" data-placement="left" placeholder="ساعت استاندارد" name="TIME_STANDARD" title="ساعت استاندارد" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">
                            <input type="text" maxlength="2" class="form-control" id="TYPE_CODE"  data-toggle="tooltip" data-placement="right" placeholder="کد نوع قطعه" title="کد نوع قطعه" name="TYPE_CODE" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4">
                            <input type="number" max="999999" class="form-control" id="SET_COUNT"  data-toggle="tooltip" data-placement="bottom" placeholder="تعداد مجاز بازسازی" title="تعداد مجاز بازسازی" name="SET_COUNT" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4">
                            <input type="number" max="999999" class="form-control" id="COUNTB_REJECT" data-toggle="tooltip" data-placement="left" placeholder="تعداد منجر به ریجکت" title="تعداد منجر به ریجکت" name="COUNTB_REJECT" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-4">
                            <input type="number" max="999999" class="form-control" id="TIME_REJECT"  data-toggle="tooltip" data-placement="right" placeholder="ساعت ریجکت" title="ساعت ریجکت" name="TIME_REJECT" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate44" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="typgha_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام قطعه</td>
                                            <td>کد قطعه</td>
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
        <div class="row usergroup5" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش اصلاح نوع قطعه</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal10" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نوع قطعه</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="typgha_edit" action="{{route('typgha.edit')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div>
                                    <input type="hidden" class="form-control" id="ID_TG_EDIT" name="ID_TG_EDIT" >
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-8">
                                    <input type="text" maxlength="40" class="form-control" id="GHATAAT_NAME_EDIT" data-toggle="tooltip" data-placement="right" placeholder="نام قطعه" title="نام قطعه" name="GHATAAT_NAME_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                                <div class="col-4">
                                    <input type="number" max="999999" class="form-control" id="TIME_STANDARD_EDIT" data-toggle="tooltip" data-placement="right" placeholder="ساعت استاندارد" title="ساعت استاندارد" name="TIME_STANDARD_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4">
                                    <input type="text" maxlength="2" class="form-control" id="TYPE_CODE_EDIT" data-toggle="tooltip" data-placement="right" placeholder="کد نوع قطعه" title="کد نوع قطعه" name="TYPE_CODE_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                                <div class="col-4">
                                    <input type="number" max="999999" class="form-control" id="SET_COUNT_EDIT" data-toggle="tooltip" data-placement="bottom" placeholder="تعداد مجاز بازسازی" title="تعداد مجاز بازسازی" name="SET_COUNT_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                                <div class="col-4">
                                    <input type="number" max="999999" class="form-control" id="COUNTB_REJECT_EDIT" data-toggle="tooltip" data-placement="bottom" placeholder="تعداد منجر به ریجکت" title="تعداد منجر به ریجکت" name="COUNTB_REJECT_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                            </div>

                            <div class="row mt-1">
                                <div class="col-4">
                                    <input type="number" max="999999" class="form-control" id="TIME_REJECT_EDIT" data-toggle="tooltip" data-placement="right" placeholder="ساعت ریجکت" title="ساعت ریجکت" name="TIME_REJECT_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                                <div class="col-4" style="text-align: right">
                                    <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                                </div>
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

        <div class="row addnir" id="typgha" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام نیروگاه</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addnir" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="nir_form" action={{route('nir.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_NN" name="ID_NN" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="30" class="form-control" id="NIROGAH_NAME"  data-toggle="tooltip" data-placement="right" title="نام نیروگاه" placeholder="نام نیروگاه" name="NIROGAH_NAME" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate66" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="nir_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام نیروگاه</td>
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
        <div class="row usergroup5" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نام نیروگاه</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal12" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام نیروگاه</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="nir_edit" action="{{route('nir.edit')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div>
                                    <input type="hidden" class="form-control" id="ID_NN_EDIT" name="ID_NN_EDIT" >
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-8">
                                    <input type="text" maxlength="30" class="form-control" id="NIROGAH_NAME_EDIT"  placeholder="نام نیروگاه" name="NIROGAH_NAME_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4" style="text-align: right">
                                    <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                                </div>
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

        <div class="row addunit" id="unit" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام واحدهای نیروگاه</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addunit" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="un_form" action={{route('un.store')}}>
                    {{csrf_field()}}

                    <div class="row mt-1">
                        <div class="col-4">
                            <select class="form-control isclicked1" name="ID_NN" id="ID_NN" style="width: 200px;font-family: Tahoma;font-size:x-small;display: inline">
                                @foreach($pps as $pp)
                                    <option value="{{$pp->ID_NN}}">{{$pp->NIROGAH_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <input type="text" maxlength="30" class="form-control" id="UNIT_NUMBER"  data-toggle="tooltip" data-placement="right" title="نام واحد" placeholder="نام واحد" name="UNIT_NUMBER" required style="font-family: Tahoma;font-size: x-small;width:100%">
                        </div>
                        <div class="col-2">
                            <input type="number" max="100" class="form-control" id="unitNumberDigit"  data-toggle="tooltip" data-placement="right" title="شماره واحد" placeholder="شماره واحد" name="unitNumberDigit" required style="font-family: Tahoma;font-size: x-small;width:100%">
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <input type="hidden" class="form-control" id="ID_UN" name="ID_UN" >
                            </div>
                        </div>
                        <br>
                        <br>


                    </div>
                    <div class="row mt-1">
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate66" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="un_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام واحد نیروگاه</td>
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
        <div class="row usergroup5" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش اصلاح نام واحد نیروگاه</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal13" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام واحد نیروگاه</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="un_edit" action="{{route('un.edit')}}">
                            {{csrf_field()}}
                            <div class="row mt-1">
                                <div class="col-4">
                                    <select class="form-control isclicked1" name="ID_NN_EDIT" id="ID_NN_EDIT" style="width: 200px;font-family: Tahoma;font-size:x-small;display: inline">
                                        @foreach($pps as $pp)
                                            <option value="{{$pp->ID_NN}}">{{$pp->NIROGAH_NAME}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-2">
                                        <input type="hidden" class="form-control" id="ID_UN_EDIT" name="ID_UN_EDIT" >
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4">
                                    <input type="text" maxlength="30" class="form-control" id="UNIT_NUMBER_EDIT"  data-toggle="tooltip" data-placement="right" title="نام واحد" placeholder="نام واحد" name="UNIT_NUMBER_EDIT" required style="font-family: Tahoma;font-size: x-small;width:100%">
                                </div>
                                <div class="col-4">
                                    <input type="number" max="100" class="form-control" id="unitNumberDigit_EDIT"  data-toggle="tooltip" data-placement="right" title="شماره واحد" placeholder="شماره واحد" name="unitNumberDigit_EDIT" required style="font-family: Tahoma;font-size: x-small;width:100%">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4" style="text-align: right">
                                    <button type="submit" class="btn btn-primary" id="btnupdate66" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                                </div>
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

        <div class="row addsaz" id="saz" style="display: none">
            <div class="col-1"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام شرکتهای سازنده</p></div>
            <div class="col-3"></div>
        </div>
        <div class="row addsaz" style="display: none">
            <div class="col-1  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="sazandeh_form" action={{route('saz.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_S" name="ID_S" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="30" class="form-control" id="SAZANDEH"  data-toggle="tooltip" data-placement="right" title="نام شرکت سازنده" placeholder="نام شرکت سازنده" name="SAZANDEH" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate66" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="saz_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>کد</td>
                                            <td>نام سازنده</td>
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
        <div class="row usergroup5" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نام شرکتهای سازنده</p></div>
            <div class="col-2"></div>
        </div>
        <div class="modal fade mt-3" id="myModal14" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 200px">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام شرکتهای سازنده</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="sazandeh_edit" action="{{route('saz.edit')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div>
                                    <input type="hidden" class="form-control" id="ID_S_EDIT" name="ID_S_EDIT" >
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-8">
                                    <input type="text" maxlength="30" class="form-control" id="SAZANDEH_EDIT"  placeholder="نام شرکت سازنده" name="SAZANDEH_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-4" style="text-align: right">
                                    <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                                </div>
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


    </div>



@endsection

