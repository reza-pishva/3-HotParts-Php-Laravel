@extends('layouts.entering.app_entering2')
@section('content')


    <script>
        $(document).ready(function(){
            $("#date_shamsi_exit").prop('readonly', true)
            $("#date_shamsi_enter").prop('readonly', true)
            $("#date_shamsi_exit_edit").prop('readonly', true)
            $("#date_shamsi_enter_edit").prop('readonly', true)
            bootstrap.Toast.Default.delay = 2000
            var s1=0;
            var s2=0;
            var s3=0;
            var s4=0;
            var s5=0;
            $("#create_request").on('submit',function(event) {

                    event.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    });
                    var _token = $("input[name='_token']").val();
                    if(s1==0){
                        $.ajax({
                            url: "/entering-store",
                            method: 'POST',
                            data: new FormData(this),
                            dataType: 'JSON',
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                s1=1;
                                $("#id_ef_permission1").val(response.data);
                                $("#id_ef_permission2").val(response.data);
                                $("#id_ef_permission3").val(response.data);
                                $("#stage001").removeClass( "bg-secondary" )
                                $("#stage001").css('background-color','green')
                                $("#bs1").css("border-color","yellow");
                                $("#bs1").css("border-width","3px");
                                toastr.success("مرحله اول ثبت درخواست با موفقیت انجام شد.", "", {
                                    "timeOut": "2000",
                                    "extendedTImeout": "0"
                                });
                                $("#date_shamsi_exit").val($("#date_shamsi_exit100").val());
                                $("#date_shamsi_enter").val($("#date_shamsi_enter100").val());
                                $("#time_exit").val($("#time_exit100").val());
                                $("#time_enter").val($("#time_enter100").val());
                                $("#s1_footer").show()
                                $("#next_s2").show()
                            }
                        });
                    }
                    if(s1==1){
                        event.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var _token = $("input[name='_token']").val();
                        $.ajax({
                            url: "/baseform-update",
                            method:'POST',
                            data:new FormData(this),
                            dataType:'JSON',
                            contentType:false,
                            processData:false,
                            success: function () {
                                toastr.success("تغییرات اعمال شد", "", {
                                    "timeOut": "5000",
                                    "extendedTImeout": "0"
                                });
                            }
                        });
                    }
            });
            $("#addpersons").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addpersons",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // alert('hi')
                        // alert(response.date_no1)
                        // alert(response.date_no2)
                        // alert(response.date_no1_p)
                        // alert(response.date_no2_p)
                        if(response.reapeted==1){
                            alert('اشکال در انتخاب تاریخ: تاریخ انتخابی را مجددا بررسی نمایید. از برنامه خارج شوید و مجددا نسبت به تکمیل فرم اقدام نمایید')
                            var alarm="بر اساس درخواست شماره "+response.id_ef+" از طرف شرکت  "+response.company+" این فرد در بخشی از بازه زمانی انتخاب شده  مجاز به ورود بوده و قبل از ثبت درخواست جدید توسط شما مجوز قبلی باید توسط مدیر حراست لغو گردد.برای این منظور شماره درخواست ذکر شده به مسئول حراست ارائه گردد"
                            alert(alarm)
                        }else{
                            $("#date_shamsi_exit").val($("#date_shamsi_exit100").val());
                            $("#date_shamsi_enter").val($("#date_shamsi_enter100").val());
                            $("#time_exit").val($("#time_exit100").val());
                            $("#time_enter").val($("#time_enter100").val());
                            s2=1;
                            $("#stage002").removeClass( "bg-secondary" )
                            $("#stage002").css('background-color','green')
                            $("#next_s3").show()
                            $('#s8').hide()
                            $("#s2_1").fadeIn()
                            if(response.people==1){
                                $('#s2_3_1').modal('toggle')
                            }
                            if(response.people>1){
                                toastr.success("مشخصات این فرد به فرم اضافه گردید", "", {
                                    "timeOut": "2000",
                                    "extendedTImeout": "0"
                                });
                            }
                            var id_ep = $('<td>' + response.id_ep + '</td>')
                            var id_et = $('<td hidden>' +$('#id_et').val() + '</td>')
                            var nationality = $('<td hidden>' + $('#nationality').val() + '</td>')
                            var age = $('<td hidden>' + $('#age').val() + '</td>')
                            var full_name = $('<td>' + $('#f_name').val() +' '+ $('#l_name').val()+'</td>')
                            var f_name = $('<td hidden>' + $('#f_name').val() +'</td>')
                            var l_name = $('<td hidden>' + $('#l_name').val() +'</td>')
                            var time_enter = $('<td>' + $('#time_enter').val() + '</td>')
                            var date_shamsi_enter = $('<td>' + $('#date_shamsi_enter').val() + '</td>')
                            var time_exit = $('<td>' + $('#time_exit').val() + '</td>')
                            var date_shamsi_exit = $('<td>' + $('#date_shamsi_exit').val() + '</td>')
                            var code_melli = $('<td hidden>' + $('#code_melli').val() + '</td>')
                            var mobile = $('<td hidden>' + $('#mobile').val() + '</td>')
                            var edit1 = $('<button type="button" class="btn-sm btn-primary edit1" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%" data-toggle="modal" data-target="#s2_2">ویرایش</button>').attr('id',response.id_ep + 1000)
                            var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ep+2000)
                            var t1=$('<td></td>')
                            var t2=$('<td></td>')
                            t1.append(edit1)
                            t2.append(del1)
                            var row=$('<tr></tr>')
                            row.append(id_ep, full_name, date_shamsi_enter, time_enter, date_shamsi_exit, time_exit,t1,t2,code_melli,mobile,f_name,l_name,id_et,nationality,age)
                            $("#persons_table").append(row)
                            $('#f_name').val('');
                            $('#l_name').val('');
                            $('#time_enter').val('');
                            $('#date_shamsi_enter').val('');
                            $('#date_shamsi_exit').val('');
                            $('#time_exit').val('');
                            $('#code_melli').val('');
                            $('#mobile').val('');
                            $('#id_et').val('0');
                            $('#nationality').val('ایرانی');
                            $('#age').val('');

                            $('#' + (Number(response.id_ep) + 1000)).click(function () {
                                $('#id_ep_edit').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#f_name_edit').val($(this).closest('tr').find('td:eq(10)').text());
                                $('#l_name_edit').val($(this).closest('tr').find('td:eq(11)').text());
                                $('#time_enter_edit').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#date_shamsi_enter_edit').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#date_shamsi_exit_edit').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#time_exit_edit').val($(this).closest('tr').find('td:eq(5)').text());
                                $('#code_melli_edit').val($(this).closest('tr').find('td:eq(8)').text());
                                $('#mobile_edit').val($(this).closest('tr').find('td:eq(9)').text());
                                $('#id_et_edit').val($(this).closest('tr').find('td:eq(12)').text());
                                $('#nationality_edit').val($(this).closest('tr').find('td:eq(13)').text());
                                $('#age_edit').val($(this).closest('tr').find('td:eq(14)').text());
                            })
                            $('#' + (Number(response.id_ep)+2000)).click(function () {
                                var id_ep = $('#' + (Number(response.id_ep)+2000)).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/enter-delete/" + id_ep,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_ep,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.people==0){
                                            $('#next_s3').hide();
                                            $("#stage002").css("background-color","red");
                                            $('#s2_3').modal('toggle')
                                        }
                                        if(response.people>0){
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
                                            toastr.error('این فرد از این فرم حذف گردید');
                                        }

                                    }
                                });
                                $('#' + (Number(response.id_ep)+2000)).closest('tr').remove();
                            })
                        }

                    }
                });

            });
            $("#f_name").click(function() {
                $("#date_shamsi_exit").val($("#date_shamsi_exit100").val());
                $("#date_shamsi_enter").val($("#date_shamsi_enter100").val());
                $("#time_exit").val($("#time_exit100").val());
                $("#time_enter").val($("#time_enter100").val());
            });
            $("#updatepersons").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatepersons",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(8)').text($("#code_melli_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(9)').text($("#mobile_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(10)').text($("#f_name_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(11)').text($("#l_name_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(12)').text($("#id_et_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(13)').text($("#nationality_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(14)').text($("#age_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(3)').text($("#time_enter_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(5)').text($("#time_exit_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(2)').text($("#date_shamsi_enter_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(4)').text($("#date_shamsi_exit_edit").val());
                        $('#' + (Number(response.id_ep)+1000)).closest('tr').find('td:eq(1)').text($("#f_name_edit").val()+' '+$("#l_name_edit").val());
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
                            if(response.repeat==0){
                                toastr.info('اطلاعات مربوط به این فرد تغییر داده شد');
                                $('#s2_2').modal('toggle')
                            }else{
                                $('#s2_2').modal('toggle')
                                alert('تاریخ غیر مجاز')
                            }

                        }

                });

            });
            $("#addcars").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addcars",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        s3=1;
                        $("#stage003").removeClass( "bg-secondary" )
                        $("#stage003").css('background-color','green')
                        $('#s9').hide()
                        $("#next_s4").show()
                        $("#s3_1").fadeIn()
                        $("#s3_footer").height('65px');
                        if(response.cars>=2){
                            toastr.success("مشخصات این خودرو به فرم اضافه گردید", "", {
                                "timeOut": "2000",
                                "extendedTImeout": "0"
                            });
                        }
                        $('#s9').hide()
                        if(response.cars==1){
                            //alert(response.cars)
                            $("#s3_3_1").modal('toggle')
                        }
                        var id_ec = $('<td>' + response.id_ec + '</td>')
                        var car_name = $('<td>' + $('#car_name').val() +'</td>')
                        var area = $('<td hidden>' + $('#area').val() +'</td>')
                        var driver_name = $('<td >' + $('#driver_name').val() +'</td>')
                        var car_no44 = $('<td hidden>' + $('#car_no').val() +'</td>')
                        var car_no = $('#car_no').val()
                        var car_no3 = $('<td >' + $('#car_no').val().toString().substr(1,2) +'</td>')
                        var car_no2 = $('<td >' + $('#car_no').val().toString().substr(0,1) +'</td>')
                        var car_no1 = $('<td >' + $('#car_no').val().toString().substr(3,3) +'</td>')
                        var edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%" data-toggle="modal" data-target="#s3_2">ویرایش</button>').attr('id',response.id_ec + 1000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ec+2000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr></tr>')
                        row.append(id_ec, car_name,car_no1,car_no2,car_no3,driver_name,t1,t2,car_no44,area)
                        $("#cars_table").append(row)
                        $('#car_name').val('');
                        $('#car_no').val('');
                        $('#driver_name').val('');
                        $('#no1').val('');
                        $('#no2').val('');
                        $('#no3').val('');
                        $('#area').val('');

                        $('#' + (Number(response.id_ec) + 1000)).click(function () {
                            $('#id_ec_edit').val($(this).closest('tr').find('td:eq(0)').text());
                            $('#car_name_edit').val($(this).closest('tr').find('td:eq(1)').text());
                            $('#no1_edit').val($(this).closest('tr').find('td:eq(2)').text());
                            $('#no2_edit').val($(this).closest('tr').find('td:eq(3)').text());
                            $('#no3_edit').val($(this).closest('tr').find('td:eq(4)').text());
                            $('#car_no_edit').val($(this).closest('tr').find('td:eq(2)').text());
                            $('#driver_name_edit').val($(this).closest('tr').find('td:eq(5)').text());
                            $('#area_edit').val($(this).closest('tr').find('td:eq(9)').text());
                        })
                        $('#' + (Number(response.id_ec)+2000)).click(function () {
                            var id_ec = $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax({
                                url: "/car-delete/" + id_ec,
                                type: 'DELETE',
                                data: {
                                    "id": id_ec,
                                    "_token": token,
                                },
                                success: function (response) {

                                    if(response.car==0){
                                        $('#next_s4').hide();
                                        $("#stage003").css("background-color","red");
                                        $('#s3_3').modal('toggle')
                                    }
                                    if(response.car>0){
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
                                        toastr.error('این خودرو از این فرم حذف گردید');

                                    }
                                }
                            });
                            $('#' + (Number(response.id_ec)+2000)).closest('tr').remove();
                        })
                    }
                });

            });
            $("#updatecars").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatecars",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(0)').text($("#id_ec_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(1)').text($("#car_name_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(5)').text($("#driver_name_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(8)').text($("#car_no_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(2)').text($("#no1_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(3)').text($("#no2_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(4)').text($("#no3_edit").val());
                        $('#' + (Number(response.id_ec)+2000)).closest('tr').find('td:eq(9)').text($("#area_edit").val());
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
                        toastr.info('اطلاعات مربوط به این خودرو تغییر داده شد');
                        $('#s3_2').modal('toggle')
                    }
                });

            });
            $("#addins").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addins",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        s4=1;
                        $("#stage004").removeClass( "bg-secondary" )
                        $("#stage004").css('background-color','green')
                        $('#s10').hide()
                        $("#next_s5").show()
                        $("#s4_1").fadeIn()
                        $("#s4_footer").height('65px');
                        if(response.ins>1){
                            toastr.success("مشخصات این قطعه الکترونیکی به فرم اضافه گردید", "", {
                                "timeOut": "2000",
                                "extendedTImeout": "0"
                            });
                        }
                        if(response.ins==1){
                            $('#s4_3_1').modal('toggle')
                        }
                        var id_ei = $('<td>' + response.id_ei + '</td>')
                        var description = $('<td style="text-align: right;padding-right: 3px">' + $('#description').val() +'</td>')
                        var serial_no = $('<td hidden style="text-align: right;padding-right: 3px">' + $('#serial_no').val() +'</td>')
                        var edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%" data-toggle="modal" data-target="#s4_2">ویرایش</button>').attr('id',response.id_ei + 1000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ei+2000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr></tr>')
                        row.append(id_ei, description,t1,t2,serial_no)
                        $("#ins_table").append(row)
                        $('#description').val('');
                        $('#serial_no').val('');

                        $('#' + (Number(response.id_ei) + 1000)).click(function () {
                            $('#id_ei_edit').val($(this).closest('tr').find('td:eq(0)').text());
                            $('#description_edit').val($(this).closest('tr').find('td:eq(1)').text());
                            $('#serial_no_edit').val($(this).closest('tr').find('td:eq(4)').text());
                        })
                        $('#' + (Number(response.id_ei)+2000)).click(function () {
                            var id_ei = $('#' + (Number(response.id_ei)+2000)).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax({
                                url: "/ins-delete/" + id_ei,
                                type: 'DELETE',
                                data: {
                                    "id": id_ei,
                                    "_token": token,
                                },
                                success: function (response) {
                                   if(response.ins==0){

                                        $('#next_s5').hide();
                                       $("#stage004").css("background-color","red");
                                        $('#s4_3').modal('toggle')
                                    }
                                    if(response.ins>0){
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
                                        toastr.error('این قطعه از این فرم حذف گردید');

                                    }
                                }


                            });
                            $('#' + (Number(response.id_ei)+2000)).closest('tr').remove();
                        })
                    }
                });

            });
            $("#updateins").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updateins",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ei)+2000)).closest('tr').find('td:eq(0)').text($("#id_ei_edit").val());
                        $('#' + (Number(response.id_ei)+2000)).closest('tr').find('td:eq(1)').text($("#description_edit").val());
                        $('#' + (Number(response.id_ei)+2000)).closest('tr').find('td:eq(4)').text($("#serial_no_edit").val());
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
                        toastr.info('اطلاعات مربوط به این قطعه الکترونیکی تغییر داده شد');
                        $('#s4_2').modal('toggle')
                    }
                });

            });
            $("#addeq").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addeq",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        s5=1;
                        $("#stage005").removeClass( "bg-secondary" )
                        $("#stage005").css('background-color','green')
                        toastr.success("مشخصات این وسیله به فرم اضافه گردید", "", {
                            "timeOut": "2000",
                            "extendedTImeout": "0"
                        });
                        $("#finish").show()
                        $("#s5_1").fadeIn()
                        $("#s5_1_2").hide()
                        $("#s5_footer").height('50px');

                        var id_ee = $('<td>' + response.id_ee + '</td>')
                        var description = $('<td style="text-align: right;padding-right: 3px">' + $('#description_eq').val() +'</td>')
                        var edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%" data-toggle="modal" data-target="#s5_2">ویرایش</button>').attr('id',response.id_ee + 1000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ee+2000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr></tr>')
                        row.append(id_ee, description,t1,t2)
                        $("#eq_table").append(row)
                        $('#description_eq').val('');

                        $('#' + (Number(response.id_ee) + 1000)).click(function () {
                            $('#id_ee_edit').val($(this).closest('tr').find('td:eq(0)').text());
                            $('#description_eq_edit').val($(this).closest('tr').find('td:eq(1)').text());
                        })
                        $('#' + (Number(response.id_ee)+2000)).click(function () {
                            var id_ee = $('#' + (Number(response.id_ee)+2000)).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax({
                                url: "/eq-delete/" + id_ee,
                                type: 'DELETE',
                                data: {
                                    "id": id_ee,
                                    "_token": token,
                                },
                                success: function (response) {
                                    if(response.eqs==0){

                                        $('#finish').hide();
                                        $("#stage005").css("background-color","red");
                                        $('#s5_3_2').modal('toggle')
                                    }
                                    if(response.eqs>0){
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
                                        toastr.error('این وسیله از این فرم حذف گردید');

                                    }
                                }
                            });
                            $('#' + (Number(response.id_ee)+2000)).closest('tr').remove();
                        })
                    }
                });

            });
            $("#updateeq").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updateeq",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ee)+2000)).closest('tr').find('td:eq(0)').text($("#id_ee_edit").val());
                        $('#' + (Number(response.id_ee)+2000)).closest('tr').find('td:eq(1)').text($("#description_eq_edit").val());
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
                        toastr.info('اطلاعات مربوط به این وسیله تغییر داده شد');
                        $('#s5_2').modal('toggle')
                    }
                });

            });
            $("#permission1form").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatepermission1",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        $("#stage003").removeClass( "bg-secondary" )
                        $("#stage003").css('background-color','green')
                    }
                });

            });
            $("#permission2form").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatepermission2",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        $("#stage004").removeClass( "bg-secondary" )
                        $("#stage004").css('background-color','green')
                    }
                });

            });
            $("#permission3form").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatepermission3",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $("#stage005").removeClass( "bg-secondary" )
                        $("#stage005").css('background-color','green')
                        if(response.level==1){
                            $('#s5_3_1').modal('toggle')
                        }
                        if(response.level==0){
                            $('#s5_3_2').modal('toggle')
                        }
                    }
                });

            });
            $("#prev_s1").on('click',function(event) {
                $('#s7').fadeIn(500)
                $('#s8').hide()
                $('#s2_1').hide()
                $('#s3_1').hide()
                $('#s4_1').hide()
                $('#s5_1').hide()
                $('#s1').hide()
                $('#s2').hide()
                $('#s3').hide()
                $('#s4').hide()
                $('#s5').hide()
                $('#s1').fadeIn(1000);
                $('#s1_footer').hide()
                $('#s2_footer').hide()
                $('#s3_footer').hide()
                $('#s1_footer').fadeIn(1000);
                $("#bs2").css("border-color","gray");
                $("#bs2").css("border-width","1px");
                $("#bs1").css("border-color","yellow");
                $("#bs1").css("border-width","3px");
            });
            $("#next_s2").on('click',function(event) {
                if($('#persons_table tr').length>1 && s2==1){
                    $('#s2_1').fadeIn(1000);
                    $('#s8').hide()
                    $('#next_s3').show()
                }
                else{
                    $('#s8').fadeIn(500)
                    $('#s2_1').hide()
                }
                $('#s7').hide()

                $('#s4_1').hide()
                $('#s5_1').hide()
                $('#s1').hide()
                $('#s3').hide()
                $('#s4').hide()
                $('#s5').hide()
                $('#s2').fadeIn(1000);
                $('#s1_footer').hide()
                $('#s3_footer').hide()
                $('#s2_footer').fadeIn(1000);
                $("#bs1").css("border-color","gray");
                $("#bs1").css("border-width","1px");
                $("#bs2").css("border-color","yellow");
                $("#bs2").css("border-width","3px");
                toastr.info("مرحله دوم<br>دراین مرحله شما می توانید مشخصات نفراتی را که جهت حضور در نیروگاه مورد درخواست شما هستند وارد نمایید", "", {
                    "timeOut": "3000",
                    "extendedTImeout": "0"
                });
            });
            $("#prev_s2").on('click',function(event) {
                if($('#persons_table tr').length>1 && s2==1){
                    $('#s2_1').fadeIn(1000);
                    $('#s8').hide()
                    $('#next_s3').show()
                }
                else{
                    $('#s8').fadeIn(500)
                    $('#s2_1').hide()
                }
                $('#s9').hide()
                $('#s3_1').hide()
                $('#s4_1').hide()
                $('#s5_1').hide()
                $('#s1').hide()
                $('#s3').hide()
                $('#s4').hide()
                $('#s5').hide()
                $('#s2').fadeIn(1000);
                $('#s1_footer').hide()
                $('#s3_footer').hide()
                $('#s2_footer').fadeIn(1000);
                $("#bs3").css("border-color","gray");
                $("#bs3").css("border-width","1px");
                $("#bs2").css("border-color","yellow");
                $("#bs2").css("border-width","3px");
            });
            $("#next_s3").on('click',function(event) {
                if($('#cars_table tr').length>1 && s3==1){
                    $('#s3_1').fadeIn(1000);
                    $('#s9').hide()
                    $('#next_s4').show()
                }
                else{
                    $('#s9').fadeIn(500)
                    $('#s3_1').hide()
                }
                $('#s8').hide()
                $('#s2_footer').hide()
                $('#s4_1').hide()
                $('#s5_1').hide()
                $('#s2').hide()
                $('#s2_1').hide()
                $('#s1').hide()
                $('#s4').hide()
                $('#s5').hide()
                $('#s3_footer').fadeIn(1000);
                $('#s3').fadeIn(1000);
                if($("#with_car").val()==2){
                    $('#s3_1').hide()
                    $('#s9').show()
                }
                $("#bs2").css("border-color","gray");
                $("#bs2").css("border-width","1px");
                $("#bs3").css("border-color","yellow");
                $("#bs3").css("border-width","3px");
                toastr.info("مرحله سوم<br> دراین مرحله شما می توانید مشخصات خودروهایی که نفرات دعوت شده به نیروگاه وارد نیروگاه می کنند وارد کنید", "", {
                    "timeOut": "3000",
                    "extendedTImeout": "0"
                });
            });
            $("#prev_s3").on('click',function(event) {
                if($('#cars_table tr').length>1 && s3==1){
                    $('#s3_1').fadeIn(1000);
                    $('#s9').hide()
                    $('#next_s4').show()
                }
                else{
                    $('#s9').fadeIn(500)
                    $('#s3_1').hide()
                }
                $('#s10').hide()
                $('#s8').hide()
                $('#s2_footer').hide()
                $('#s4_1').hide()
                $('#s5_1').hide()
                $('#s2').hide()
                $('#s2_1').hide()
                $('#s1').hide()
                $('#s4').hide()
                $('#s5').hide()
                $('#s4_footer').hide()
                $('#s3_footer').fadeIn(1000);
                $('#s3').fadeIn(1000);
                if(s3==1){
                    $('#s3_1').fadeIn(1000);
                }
                if($("#with_car").val()==1){
                    if(s3==1){
                        $('#s3_1').fadeIn(1000);
                    }
                }else{
                    $('#s3_1').hide();
                }
                if($("#with_car").val()==2){
                    $('#s3_1').hide()
                }
                $("#bs4").css("border-color","gray");
                $("#bs4").css("border-width","1px");
                $("#bs3").css("border-color","yellow");
                $("#bs3").css("border-width","3px");
            });
            $("#next_s4").on('click',function(event) {
                if($('#ins_table tr').length>1 && s4==1){
                    $('#s4_1').fadeIn(1000);
                    $('#s10').hide()
                    $('#next_s5').show()
                }
                else{
                    $("#s4_1").hide()
                    $('#s10').fadeIn(500)
                }
                if($('#ins_table tr').length==1){
                    $("#s4_1").hide()
                }
                $('#s9').hide()
                $('#s1_footer').hide()
                $('#s2_footer').hide()
                $('#s3_footer').hide()
                $('#s5_footer').hide()
                $('#s2_1').hide()
                $('#s3_1').hide()
                $('#s5_1').hide()
                $('#s1').hide()
                $('#s2').hide()
                $('#s3').hide()
                $('#s5').hide()
                $('#s4_footer').fadeIn(1000);
                $('#s4').fadeIn(1000);
                // if(s4==1){
                //     $('#s4_1').fadeIn(1000);
                // }
                if($("#with_el").val()==2){
                    $('#s4_1').hide()
                }
                $("#bs3").css("border-color","gray");
                $("#bs3").css("border-width","1px");
                $("#bs4").css("border-color","yellow");
                $("#bs4").css("border-width","3px");
                toastr.info("در مرحله چهارم شما می توانید لیست وسایل الکترونیکی که این افراد وارد نیروگاه می کنند وارد نمایید", "", {
                    "timeOut": "3000",
                    "extendedTImeout": "0"
                });
            });
            $("#prev_s4").on('click',function(event) {
                if($('#ins_table tr').length>1 && s4==1){
                    $('#s4_1').fadeIn(1000);
                    $('#s10').hide()
                    $('#next_s5').show()
                }
                else{
                    $("#s4_1").hide()
                    $('#s10').fadeIn(500)
                }
                $('#s11').hide()
                $('#s1_footer').hide()
                $('#s2_footer').hide()
                $('#s3_footer').hide()
                $('#s5_footer').hide()
                $('#s2_1').hide()
                $('#s3_1').hide()
                $('#s4_1').hide()
                $('#s5_1').hide()
                $('#s5_1_2').hide()
                $('#s1').hide()
                $('#s2').hide()
                $('#s3').hide()
                $('#s5').hide()
                $('#s4_footer').fadeIn(1000);
                $('#s4').fadeIn(1000);
                if(s4==1){
                    $('#s4_1').fadeIn(1000);
                }
                if($("#with_el").val()==2){
                    $('#s4_1').hide()
                }
                $("#bs5").css("border-color","gray");
                $("#bs5").css("border-width","1px");
                $("#bs4").css("border-color","yellow");
                $("#bs4").css("border-width","3px");
            });
            $("#next_s5").on('click',function(event) {
                if($('#ins_table tr').length>1 && s5==1){
                    $('#s5_1').fadeIn(1000);
                    $('#s11').hide()
                }
                else{
                    $("#s5_1").hide()
                    $("#s10").hide()
                    $('#s11').fadeIn(500)
                }
                if($('#equp_table tr').length==1){
                    $("#s5_1").hide()
                }
                if($('#with_eq').val()==2){
                    $("#s5_1_2").hide()
                    $("#s5_1").hide()
                    $('#s11').fadeIn(500)
                }
                if($('#equp_table tr').length>1){
                    $("#s5_1_2").fadeIn(500)
                    $('#s11').hide()
                }
                $('#s1_footer').hide()
                $('#s2_footer').hide()
                $('#s3_footer').hide()
                $('#s4_footer').hide()
                $('#s2_1').hide()
                $('#s3_1').hide()
                $('#s4_1').hide()
                $('#s1').hide()
                $('#s2').hide()
                $('#s3').hide()
                $('#s4').hide()
                $('#s5_footer').fadeIn(1000);
                $('#s5').fadeIn(1000);
                if($("#with_eq").val()==2){
                    $('#s5_1').hide()
                }
                $("#bs4").css("border-color","gray");
                $("#bs4").css("border-width","1px");
                $("#bs5").css("border-color","yellow");
                $("#bs5").css("border-width","3px");
                if($("#send_type").val()==0){
                    $("#s5_1").hide()
                    $("#s5_1_2").hide()
                    $("#s5").height('140px');
                    $("#s5_footer").height('50px');
                    $("#eq_title").hide()
                    $("#equpload").hide()
                    $("#addeq").hide()
                }
                if($("#send_type").val()==1){
                    $("#s5_1").fadeIn()
                    $("#s5_1_2").hide()
                    $("#permission3").val(1);
                    $("#addeq").show()
                    $("#equpload").hide()
                    $("#eq_title").show()
                    $("#s5").height('290px');
                    $("#s5_footer").height('50px');
                    // $("#eq_table").find("tr:gt(0)").remove();
                }
                if($("#send_type").val()==2){
                    $("#s5_1_2").fadeIn()
                    $("#s5_1").hide()
                    $("#permission3").val(1);
                    $("#equpload").show()
                    $("#eq_title").hide()
                    $("#addeq").hide()
                    $("#s5").height('310px');
                    $("#s5_footer").height('50px');
                }
                toastr.info("در مرحله پنجم شما می توانید لیست تجهیزاتی که این نفرات برای کار به آنها نیاز دارند وارد نمایید", "", {
                    "timeOut": "3000",
                    "extendedTImeout": "0"
                });
            });
            $("#with_car").on('change',function(event) {
                if($("#with_car").val()==0){
                    $("#permission1").val(0);
                    $('#s3_1').hide()
                    $('.car_title').hide()
                    $("#s3").height('65px');
                    $('#btncar').hide()
                    $("#s3_footer").height('50px');
                    $('#next_s4').hide()

                }
                if($("#with_car").val()==1){
                    $("#permission1").val(1);
                    $('.car_title').fadeIn();
                    $("#s3").height('250px');
                    $("#s3_footer").height('50px');
                    $('#btncar').fadeIn();
                    $('#next_s4').hide();
                    $("#cars_table").find("tr:gt(0)").remove();
                }
                if($("#with_car").val()==2){
                    $("#permission1").val(2);
                    $('#s3_1').hide()
                    $('.car_title').hide()
                    $("#s3").height('65px');
                    $('#btncar').hide()
                    $("#s3_footer").height('65px');
                    $('#next_s4').fadeIn()
                    $('#s9').show()
                }
            });
            $("#with_el").on('change',function(event) {
                if($("#with_el").val()==0){
                    $("#permission2").val(0);
                    $('#s4_1').hide()
                    $('#next_s5').hide()
                    $("#btnic").hide()
                    $('.el_title').hide()
                    $("#s4").height('100px');
                    $("#s4_footer").height('50px');

                }
                if($("#with_el").val()==1){
                    $("#permission2").val(1);
                    $('#next_s5').hide()
                    $('.el_title').fadeIn()
                    $("#btnic").show();
                    $("#s4").height('270px');
                    $("#s4_footer").height('50px');
                    $("#ins_table").find("tr:gt(0)").remove();

                }
                if($("#with_el").val()==2){
                    $("#permission2").val(2);
                    $('#s4_1').hide()
                    $('#next_s5').show()
                    $("#btnic").hide()
                    $('.el_title').hide()
                    $("#s4").height('100px');
                    $("#s4_footer").height('65px');
                    $('#s10').show()
                }
            });
            $("#with_eq").on('change',function(event) {
                if($("#with_eq").val()==0){
                    $("#permission3").val(0);
                    $("#send_type").val(0);
                    $('#finish').hide()
                    $('.eq_title').hide()
                    $("#btneq").hide()
                    $("#s5").height('80px');
                    $("#s5_footer").height('50px');

                }
                if($("#with_eq").val()==1){
                    $("#send_type").val(0);
                    $("#s5").height('130px');
                    $("#s5_footer").height('50px');
                    $("#send_type").attr('display','inline')
                    $("#send_type_lable").attr('display','inline')
                    $("#send_type_lable").show()
                    $("#send_type").show()
                }
                if($("#with_eq").val()==2){
                    $("#send_type").val(0);
                    $("#permission3").val(2);
                    $('#s5_1').hide()
                    $('#s5_1_2').hide()
                    $('#s11').fadeIn(500)
                    $('#finish').show()
                    $('#addeq').hide()
                    $('#equpload').hide()
                    $('#send_type').hide()
                    $('#send_type_lable').hide()
                    $("#s5").height('80px');
                    $("#s5_footer").height('50px');
                }
            });
            $("#date_shamsi_exit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_enter").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_exit100").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_enter100").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_exit_edit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_enter_edit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#btncar").on('click',function(event){
                $("#car_no").val($("#no2").val()+$("#no3").val()+$("#no1").val());
            });
            $("#btncar2").on('click',function(event){
                $("#car_no_edit").val($("#no2_edit").val()+$("#no3_edit").val()+$("#no1_edit").val());
            });
            $("#send_type").on('change',function(event) {
                $("#s11").hide()
                if($('#equp_table tr').length>1 || $('#eq_table tr').length>1){
                    $('#finish').show()
                }else{
                    $('#finish').hide()
                }
            if($("#send_type").val()==0){
                    $("#s5_1").hide()
                    $("#s5_1_2").hide()
                    $("#s5").height('140px');
                    $("#s5_footer").height('50px');
                    $("#eq_title").hide()
                    $("#equpload").hide()
                    $("#addeq").hide()
                }
            if($("#send_type").val()==1){
                    $("#s5_1").fadeIn()
                    $("#s5_1_2").hide()
                    $("#permission3").val(1);
                    $("#addeq").show()
                    $("#equpload").hide()
                    $("#eq_title").show()
                    $("#s5").height('290px');
                    $("#s5_footer").height('50px');
                    // $("#eq_table").find("tr:gt(0)").remove();
                }
            if($("#send_type").val()==2){
                    $("#s5_1_2").fadeIn()
                    $("#s5_1").hide()
                    $("#permission3").val(1);
                    $("#equpload").show()
                    $("#eq_title").hide()
                    $("#addeq").hide()
                    $("#s5").height('310px');
                    $("#s5_footer").height('50px');
                }
            });
            $('#equpload').on('submit',function(event){

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/store-file",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.ext && response.size){
                            s5=1;
                            $("#stage005").removeClass( "bg-secondary" )
                            $("#stage005").css('background-color','green')
                            $("#finish").show()
                            $("#s5_footer").height('50px');

                            $(".progress-bar").show()
                            var delay = 1500;
                            $(".progress-bar").each(function(i) {
                                $(this).delay(delay * i).animate({
                                    width: $(this).attr('aria-valuenow') + '%'
                                }, delay);

                                $(this).prop('Counter', 0).animate({
                                    //Counter: $(this).text()
                                }, {
                                    duration: delay,
                                    easing: 'swing',
                                    step: function(now) {
                                        $(this).text(Math.ceil(now) + '%');
                                    }
                                });
                            });
                            setTimeout(function(){$(".progress-bar").hide();}, 3000);



                            $("#s5_1").hide();
                            $("#s5_1_2").fadeIn();
                            var id_eup = $('<td style="width: 5%">' + response.id_eup + '</td>')
                            var icon = $('<td style="width: 5%;text-align: center"><img src="./pdf001.png"  style="width:75%;height:35px;border-radius: 10px"></td>')
                            var description = $('<td style="text-align: right;padding-right: 10px;width: 65%"><a href="./documents/'+response.id_eup+'.pdf">'+ $('#description_upload').val() +'</a></td>')
                            var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.id_eup+2000)
                            var t2=$('<td style="width: 25%"></td>')
                            t2.append(del1)
                            var row=$('<tr></tr>')
                            row.append(id_eup, icon,description,t2)
                            $("#equp_table").append(row)
                            $('#description_eq').val('');
                            $("#file").val('')
                            $("#description_upload").val('')
                            $('#' + (Number(response.id_eup)+2000)).click(function () {
                                var id_eup = $('#' + (Number(response.id_eup)+2000)).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/eup-delete/" + id_eup,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_eup,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.eup==0){

                                            $('#finish').hide();
                                            $("#stage005").css("background-color","red");
                                            $('#s5_3_2').modal('toggle')
                                        }
                                        if(response.eup>0){
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
                                            toastr.error('این فایل الصاقی از این فرم حذف گردید');

                                        }
                                    }
                                });
                                $('#' + (Number(response.id_eup)+2000)).closest('tr').remove();
                            })
                        }else{
                            if(response.ext==0){
                                $("#s12").modal('show');
                                $("#s13").hide()

                            }
                            if(response.size==0){
                                $("#s13").modal('show');
                                $("#s12").hide()
                            }
                        }


                    },
                });

            });
        });
    </script>
    <div id="s1_footer" class="container bg-dark" style="margin: auto;background-color:rgba(0, 0,255, 0.4);width: 80%;border-radius: 5px;height:50px;direction: rtl;color: white;padding-top: 4px;display: none">
        <div class="row" style="margin-top:5px">
            <div  class="col-5"></button>
            </div>
            <div  class="col-7" style="text-align:right">
                <button id="next_s2" type="button" class="btn btn-success" id="btnupdate" style="text-align:right;font-family: Tahoma;font-size: small;text-align: center;width: 100%;display: none">مرحله بعدی: افزودن نفرات</button>
            </div>
        </div>
    </div>
    <div id="s1" class="container" style="margin: auto;background-color:rgba(0, 105,155, 0.6);width: 80%;border-radius: 5px;height:360px;direction: rtl;color: white;margin-top: 5px;padding-top: 5px;">


        <form method="post" encType="multipart/form-data" id="create_request" action="{{route('create_request.store')}}">
            {{csrf_field()}}
            <div class="row" style="height: 20px;margin-top: 20px">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ شروع فعالیت:</p></div>
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت شروع فعالیت:</p></div>
            </div>
            <div class="row" style="height: 15px">
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter100"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_shamsi_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 90%" required title="تاریخ شروع به کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <input type="time" maxlength="10" class="form-control" id="time_enter100"  data-toggle="tooltip" data-placement="right" placeholder="ساعت شروع فعالیت:" name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 90%" value="07:30" required title="ساعت شروع به کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
            </div>
            <div class="row" style="height: 20px;margin-top: 20px">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ پایان فعالیت:</p></div>
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت پایان فعالیت:</p></div>
            </div>
            <div class="row" style="height: 15px">
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="10" class="form-control" id="date_shamsi_exit100"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ پایان فعالیت:" name="date_shamsi_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 90%" required title="تاریخ پایان کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <input type="time" maxlength="10" class="form-control" id="time_exit100"  data-toggle="tooltip" data-placement="right" placeholder="ساعت پایان فعالیت:" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 90%" value="19:30" required title="ساعت پایان کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
            </div>
            <br>
            <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">عنوان فعالیت:</p></div>
            </div>

            <div class="row" style="margin-top: 10px">
                <div class="col-12">
                    <div class="form-group" style="height: 15px">
                        <input type="text" maxlength="50" class="form-control" id="title" data-toggle="tooltip" data-placement="right" placeholder="عنوان فعالیت:" name="title" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا عنوان فعالیتی که قرار است انجام شود وارد کنید">
                    </div>
                </div>
            </div>
            <div class="row" style="height: 20px;margin-top: 20px">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نام شرکت یا مرکز:</p></div>
            </div>

            <div class="row" style="height: 15px">
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="30" class="form-control" id="company"  data-toggle="tooltip" data-placement="right" placeholder="نام شرکت یا مرکز:" name="company" style="direction: rtl;font-family: Tahoma;font-size: small;width: 80%" required title="نام شرکت یا مرکزی که این فرد یا افراد از آنجا به نیروگاه معرفی شده اند وارد گردد">
                    </div>
                </div>
            </div>



            <div class="row" style="margin-top: 45px">
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="firststage" style="font-family: Tahoma;font-size: small;text-align: center;width: 70%">ثبت</button>
                </div>
            </div>
            <div id="alert1" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
        </form>

    </div>
    <div id="s2_footer" class="container bg-dark" style="text-align: right;background-color:rgba(0, 0,255, 0.4);width: 90%;border-radius: 5px;height:50px;direction: rtl;color: white;margin-top:5px;padding-top: 4px;display: none">
        <div class="row" style="margin-top:5px">
            <div  class="col" style="direction: ltr">
                <button id="prev_s1" type="button" class="btn btn-info"  style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">مرحله قبل</button>
            </div>
            <div  class="col" style="text-align:right">
                <button id="next_s3" type="button" class="btn btn-success"  style="text-align:right;font-family: Tahoma;font-size: small;text-align: center;width: 100%;display: none">مرحله بعدی: افزودن خودرو</button>
            </div>
        </div>
    </div>
    <div id="s2" class="container" style="text-align: left;background-color:rgba(0, 105,155, 0.6);width: 90%;border-radius: 5px;height:250px;direction: rtl;color: white;margin-top:2px;padding-top: 2px;display: none">
        <form method="post" encType="multipart/form-data" id="addpersons" action="{{route('addpersons.store')}}">
            {{csrf_field()}}
            <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام:</p></div>
                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام خانوادگی:</p></div>
            </div>

            <div class="row" style="margin-top: 10px">
                <div class="col-6">
                    <div class="form-group" style="height: 15px">
                        <input type="text" maxlength="15" class="form-control" id="f_name" data-toggle="tooltip" data-placement="right" placeholder="نام مهمان:" name="f_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام فرد دعوت شده وارد شود">
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group" style="height: 15px">
                        <input type="text" maxlength="20" class="form-control" id="l_name" data-toggle="tooltip" data-placement="right" placeholder="نام خانوادگی مهمان:" name="l_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام خانوادگی فرد دعوت شده وارد شود">
                    </div>
                </div>
            </div>
            <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">عنوان فرد:</p></div>

            </div>
            <div class="row" style="margin-top: 10px">
                <div class="col-6">
                    <div class="form-group" style="height: 15px">
                        <select class="form-control" name="id_et" id="id_et" style="width: 150px;font-family: Tahoma;font-size: small;" required title="عنوان این فرد وارد شود">
                            <option value=''>----</option>
                            @foreach($persons as $person)
                                <option value="{{$person->id_et}}">{{$person->description}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group" style="height: 15px">
                        <select  class="form-control"  required name="nationality" id="nationality" style="width: 100%;font-family: Tahoma;font-size: x-small;">
                            <option value='ایرانی'>ایرانی</option>
                            <option value='افغان'>افغان</option>
                            <option value='ایتالیایی'>ایتالیایی</option>
                            <option value='هلندی'>هلندی</option>
                            <option value='فرانسوی'>فرانسوی</option>
                            <option value='آلمانی'>آلمانی</option>
                            <option value='انگلیسی'>انگلیسی</option>
                            <option value='هندی'>هندی</option>
                            <option value='ترک'>ترک</option>
                            <option value='عراقی'>عراقی</option>
                            <option value='پاکستانی'>پاکستانی</option>
                            <option value='روس'>روس</option>
                            <option value='سوری'>سوری</option>
                            <option value='آمریکایی'>آمریکایی</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group" style="height: 15px">
                        <input hidden type="number" max=100 min=1 class="form-control" id="age"  data-toggle="tooltip" data-placement="right" placeholder="سن:" name="age" style="direction: rtl;font-family: Tahoma;font-size: x-small;width: 100%"  title="سن این فرد وارد شود">
                    </div>
                </div>
            </div>
            <div hidden class="row" style="height: 20px;margin-top: 20px">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ شروع فعالیت:</p></div>
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت شروع فعالیت:</p></div>
            </div>

            <div hidden class="row" style="height: 15px">
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_shamsi_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="تاریخ شروع به کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <input type="time" maxlength="10" class="form-control" id="time_enter"  data-toggle="tooltip" data-placement="right" placeholder="ساعت شروع فعالیت:" name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  required title="ساعت شروع به کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
            </div>
            <div hidden class="row" style="height: 20px;margin-top: 20px">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ پایان فعالیت:</p></div>
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت پایان فعالیت:</p></div>
            </div>

            <div hidden class="row" style="height: 15px">
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="10" class="form-control" id="date_shamsi_exit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ پایان فعالیت:" name="date_shamsi_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="تاریخ پایان کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <input type="time" maxlength="10" class="form-control" id="time_exit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت پایان فعالیت:" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  required title="ساعت پایان کار فرد در نیروگاه وارد شود">
                    </div>
                </div>
            </div>
            <div class="row" style="height: 20px;margin-top: 20px">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">کد ملی:</p></div>
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">شماره تلفن:</p></div>
            </div>

            <div class="row" style="height: 15px">
                <div class="col">
                    <div class="form-group" >
                        <input type="text"  pattern="[0-9]{10}" class="form-control" id="code_melli"  data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="کد ملی فرد وارد گردد">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="11" class="form-control" id="mobile"  data-toggle="tooltip" data-placement="right" placeholder="شماره تلفن:" name="mobile" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="شماره موبایل فرد وارد گردد">
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top:30px">
                <div class="col" style="text-align:center">
                    <button type="submit" class="btn btn-primary" id="btnupdate" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:80%">ثبت</button>
                </div>
            </div>

        </form>
        <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
    </div>
    <div id="s3_footer" class="container bg-dark" style="margin: auto;background-color:rgba(0, 0,255, 0.4);width: 80%;border-radius: 5px;height:50px;direction: rtl;color: white;margin-top:5px;padding-top: 4px;display: none">
        <div class="row" style="margin-top:5px">
            <div  class="col" style="direction: ltr">
                <button id="prev_s2" type="button" class="btn btn-info"  style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">مرحله قبل</button>
            </div>
            <div  class="col" style="text-align:right">
                <form method="post" encType="multipart/form-data" id="permission1form" action="{{route('permission1.edit')}}">
                    {{csrf_field()}}
                    <input hidden type="text" id="id_ef_permission1" name="id_ef">
                    <input hidden type="text" id="permission1" name="permission1">
                    <button id="next_s4" type="submit" class="btn btn-success"  style="text-align:right;font-family: Tahoma;font-size: small;text-align: center;width: 100%;display: none">مرحله بعدی: افزودن قطعات الکترونیکی</button>
                </form>
            </div>
        </div>
    </div>
    <div id="s3" class="container" style="margin: auto;background-color:rgba(0, 105,155, 0.4);width: 80%;border-radius: 5px;height:60px;direction: rtl;color: white;margin-top: 5px;padding-top: 20px;display: none">
        <form method="post" encType="multipart/form-data" id="addcars" action="{{route('addcars.store')}}">
            {{csrf_field()}}
            <div  class="form-group" style="text-align: right">
                <label for="with_car" style="font-family: Tahoma;font-size: small;display: inline">نیاز به صدور مجوز تردد خودرو مهمان:</label>
                <select class="form-control" name="with_car" id="with_car" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                    <option value=0>---</option>
                    <option value=1>بله</option>
                    <option value=2>خیر</option>
                </select>
            </div>
            <hr style="border-top: 1px solid white">
            <div class="row car_title" style="height: 10px;margin-top: 10px;display: none">
                <div class="col" >
                    <p style="text-align: right;font-family: Tahoma;font-size: small;">نام خودرو:</p>
                </div>
                <div class="col" style="text-align: right;">
                    <p style="text-align: right;font-family: Tahoma;font-size: small;">شماره پلاک:</p>
                </div>
            </div>

            <div class="row car_title" style="margin-top: 12px;height: 20px;display: none" id="car_title2">
                <div class="col">
                    <div class="form-group car_title">
                        <input type="text" maxlength="15" class="form-control" id="car_name" placeholder="نام خودرو:" name="car_name" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" style="text-align: right">
                        <input hidden type="text" maxlength="50" class="form-control" id="car_no" placeholder="شماره پلاک خودرو:" name="car_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px">
                        <input type="text" maxlength="3" class="form-control" id="no1" style="font-family:Tahoma;font-size:small;width: 50px;display: inline" required placeholder="532">
                        <input type="text" maxlength="1" class="form-control" id="no2" style="font-family:Tahoma;font-size:small;width: 35px;display: inline" required placeholder="ب">
                        <input type="text" maxlength="2" class="form-control" id="no3" style="font-family:Tahoma;font-size:small;width: 40px;display: inline" required placeholder="98">
                    </div>
                </div>
            </div>
            <div class="row car_title" style="height: 20px;margin-top: 20px;display: none" id="car_title3">
                <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نام راننده:</p></div>
            </div>

            <div class="row car_title" style="height: 15px;display: none" id="car_title4">
                <div class="col">
                    <div class="form-group" >
                        <input type="text" maxlength="20" class="form-control" id="driver_name"  data-toggle="tooltip" data-placement="right" placeholder="نام راننده:" name="driver_name" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="نام راننده وارد گردد">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group" >
                        <select class="form-control" name="area" id="area" style="width:100%;font-family: Tahoma;font-size: small;" required>
                            <option value=''>محدوده تردد</option>
                            <option value='ساختمان اداری'>ساختمان اداری</option>
                            <option value='محدوده انبار'>محدوده انبار</option>
                            <option value='محدوده پست انتقال'>محدوده پست انتقال</option>
                            <option value='محدوده واحدهای گازی'>محدوده واحدهای گازی</option>
                            <option value='محدوده واحدهای بخار'>محدوده واحدهای بخار</option>
                            <option value='محدوده واحدهای گازی و بخار'>محدوده واحدهای گازی و بخار</option>
                            <option value='ساختمان اتاق فرمان'>ساختمان اتاق فرمان</option>
                            <option value='اطراف کارگاهها'>اطراف کارگاهها</option>
                            <option value='محدوده باغ زیتون'>محدوده باغ زیتون</option>
                            <option value='محدوده ایستگاه گاز'>محدوده ایستگاه گاز</option>
                            <option value='محدوده مخازن سوخت'>محدوده مخازن سوخت</option>
                            <option value='محدوده پارکینگ شمالی'>محدوده پارکینگ شمالی</option>
                            <option value='محدوده پارکینگ جنوبی'>محدوده پارکینگ جنوبی</option>
                            <option value='محدوده مهمانسرا'>محدوده مهمانسرا</option>
                            <option value='تردد در کل سایت'>تردد در کل سایت</option>
                        </select>
                    </div>
                </div>

            </div>



            <div class="row" style="margin-top: 45px">
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="btncar" style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;display: none">ثبت اطلاعات</button>
                </div>
            </div>
        </form>
    </div>
    <div id="s4_footer" class="container bg-dark" style="margin: auto;background-color:rgba(0, 0,255, 0.4);width: 80%;border-radius: 5px;height:50px;direction: rtl;color: white;margin-top:5px;padding-top: 4px;display: none">
        <div class="row" style="margin-top:5px">
            <div  class="col" style="direction: ltr">
                <button id="prev_s3" type="button" class="btn btn-info" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">مرحله قبل</button>
            </div>

            <div  class="col" style="text-align:right">
                <form method="post" encType="multipart/form-data" id="permission2form" action="{{route('permission2.edit')}}">
                    {{csrf_field()}}
                    <input hidden type="text" id="id_ef_permission2" name="id_ef">
                    <input hidden type="text" id="permission2" name="permission2">
                    <button id="next_s5" type="submit" class="btn btn-success"  style="text-align:right;font-family: Tahoma;font-size: small;text-align: center;width: 100%;display: none">مرحله بعدی: افزودن وسایل کار</button>
                </form>
            </div>
        </div>
    </div>
    <div id="s4" class="container" style="margin: auto;background-color:rgba(0, 105,155, 0.4);width: 80%;border-radius: 5px;height:100px;direction: rtl;color: white;margin-top: 5px;padding-top: 20px;display: none">
        <form method="post" encType="multipart/form-data" id="addins" action="{{route('addins.store')}}">
            {{csrf_field()}}
            <div  class="form-group" style="text-align: right">
                <label for="with_el" style="font-family: Tahoma;font-size: small;display: inline">نیاز به صدور مجوز ورود لوازم الكترونيكي مهمان:</label>
                <select class="form-control isclicked1" name="with_el" id="with_el" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                    <option value=0>----</option>
                    <option value=1>بله</option>
                    <option value=2>خیر</option>
                </select>
            </div>
            <hr style="border-top: 1px solid white">
            <div class="row el_title" style="height: 10px;margin-top: 10px;display: none">
                <div class="col">
                    <p style="text-align: right;font-family: Tahoma;font-size: small">نام وسیله الکترونیکی:</p>
                </div>
            </div>
            <div class="row el_title" style="margin-top: 12px;height: 20px;display: none">
                <div class="col">
                    <div class="form-group">
                        <input type="text" maxlength="40" class="form-control" id="description" placeholder="نام وسیله الکترونیکی:" name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 90%" required title="نام وسیله الکترونیکی وارد گردد">
                    </div>
                </div>
            </div>
            <div class="row el_title" style="height: 10px;margin-top: 15px;display: none">
                <div class="col">
                    <p style="text-align: right;font-family: Tahoma;font-size: small">شماره سریال:</p>
                </div>
            </div>
            <div class="row el_title" style="margin-top: 12px;height: 20px;display: none">
                <div class="col">
                    <div class="form-group">
                        <input type="text" maxlength="20" class="form-control" id="serial_no" placeholder="شماره سریال:" name="serial_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 50%" title="شماره سریال در صورت وجود وارد شود">
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 45px">
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="btnic" style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;display: none">ثبت اطلاعات</button>
                </div>
            </div>
        </form>
    </div>
    <div id="s5_footer" class="container bg-dark" style="margin: auto;background-color:rgba(0, 0,255, 0.4);width: 75%;border-radius: 5px;height:50px;direction: rtl;color: white;margin-top:5px;padding-top: 4px;display: none">
        <div class="row" style="margin-top:5px">
            <div  class="col" style="direction: ltr">
                <button id="prev_s4" type="button" class="btn btn-info" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">مرحله قبل</button>
            </div>
            <div  class="col" style="direction: ltr">
                <form method="post" encType="multipart/form-data" id="permission3form" action="{{route('permission3.edit')}}">
                    {{csrf_field()}}
                    <input hidden type="text" id="id_ef_permission3" name="id_ef">
                    <input hidden type="text" id="permission3" name="permission3">
                    <button id="finish" type="submit" class="btn btn-success"  style="text-align:right;font-family: Tahoma;font-size: small;text-align: center;width: 100%;display: none">تکمیل فرایند</button>
                </form>
            </div>

        </div>
    </div>
    <div id="s5" class="container" style="margin: auto;background-color:rgba(0, 105,155, 0.4);width: 75%;border-radius: 5px;height:100px;direction: rtl;color: white;margin-top: 5px;padding-top: 20px;display: none">
        <div  class="form-group" style="text-align: right">
            <label for="with_eq" style="font-family: Tahoma;font-size: small;display: inline">نیاز به صدور مجوز برای وسایل کارمهمان:</label>
            <select class="form-control isclicked1" name="with_eq" id="with_eq" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                <option value=0>----</option>
                <option value=1>بله</option>
                <option value=2>خیر</option>
            </select>
        </div>
        <div  class="form-group" style="text-align: right">
            <label for="send_type" id="send_type_lable" style="font-family: Tahoma;font-size: small;display: none">انتخاب روش مشخص کردن وسایل کار:</label>
            <select  class="form-control isclicked1" name="send_type" id="send_type" style="width: 83%;font-family: Tahoma;font-size: small;display: none">
                <option value=0>----</option>
                <option value=1>ورود اطلاعات بصورت دستی </option>
                <option value=2>ارسال فایل حاوی اطلاعات مربوط به این وسایل</option>
            </select>
        </div>
        <hr style="border-top: 1px solid white">
        <form method="post" encType="multipart/form-data" id="addeq" action="{{route('addeq.store')}}" style="display: none">
            {{csrf_field()}}

            <div class="row eq_title" style="height: 10px;margin-top: 10px">
                <div class="col">
                    <p style="text-align: right;font-family: Tahoma;font-size: small">نام وسیله :</p>
                </div>
            </div>

            <div class="row eq_title" style="margin-top: 12px;height: 20px">
                <div class="col">
                    <div class="form-group">
                        <input type="text" maxlength="35" class="form-control" id="description_eq" placeholder="نام وسیله:" name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 90%" required title="نام وسیله وارد گردد">
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 45px">
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="btneq" style="font-family: Tahoma;font-size: small;text-align: center;width: 80%">ثبت اطلاعات</button>
                </div>
            </div>
        </form>
        <form method="post" encType="multipart/form-data" id="equpload" action="{{route('equpload.store')}}" style="display: none">
            {{csrf_field()}}
            <div class="row upload" style="margin-top: 12px;height: 20px">
                <div class="col">
                    <div class="form-group">
                        <input hidden type="text" maxlength="100" class="form-control" id="description_upload" placeholder="انتخاب نام فایل جهت ارسال:" name="description_upload" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 85%" required title="نام انتخابی برای فایل" value="لیست وسایل">
                    </div>
                </div>
            </div>
            <div class="row upload" style="margin-top: 22px;height: 20px">
                <div class="col">
                    <div class="form-group">
                        <input type="file" name="file" placeholder="انتخاب فایل :" id="file">
                    </div>
                </div>
            </div>
            <br>
            <div class="container">
                <div class="progress border">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"  style="direction: rtl"></div>
                </div>
            </div>
{{--            <div class="toast" id="uploadsuccess">--}}
{{--                <div class="toast-body bg-success">--}}
{{--                    <p style="text-align: right;font-family: Tahoma;font-size: small;color: white">فایل انتخاب شده با موفقیت ارسال گردید</p>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="row" style="margin-top: 5px">
                <div class="col">
                    <button type="submit" class="btn btn-primary" id="btnupload" style="font-family: Tahoma;font-size: small;text-align: center;width: 80%">ارسال فایل</button>
                </div>
            </div>
        </form>
    </div>

@endsection
@section("content2")
    <div id="s2_1" class="container" style="margin: auto;background-color:rgba(0, 0,55, 0.4);width: 100%;border-radius: 5px;height:250px;direction: rtl;color: white;margin-top: 60px;padding-top: 2px;display: none;overflow-y: scroll">
        <table id="persons_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
            <tr class="bg-primary" style="color: white">
                <td style="border-left: 1px white solid;width: 8%;font-family: Tahoma;font-size: smaller;height: 10px">شماره سریال</td>
                <td style="border-left: 1px white solid;width: 18%;font-family: Tahoma;font-size: smaller;">نام و نام خانوادگی</td>
                <td style="border-left: 1px white solid;width: 13%;font-family: Tahoma;font-size: smaller;">تاریخ شروع</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">ساعت شروع</td>
                <td style="border-left: 1px white solid;width: 13%;font-family: Tahoma;font-size: smaller;">تاریخ پایان</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">ساعت پایان</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
            </tr>
        </table>
    </div>
    <div class="modal fade mt-3" id="s2_2" style="direction: rtl;margin-top: 20px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="updatepersons" action="{{route('updatepersons.update')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ep_edit" name="id_ep">
                        <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام:</p></div>
                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام خانوادگی:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="20" class="form-control" id="f_name_edit" data-toggle="tooltip" data-placement="right" placeholder="نام مهمان:" name="f_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام فرد دعوت شده وارد شود">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="25" class="form-control" id="l_name_edit" data-toggle="tooltip" data-placement="right" placeholder="نام خانوادگی مهمان:" name="l_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام خانوادگی فرد دعوت شده وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">عنوان فرد:</p></div>

                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <select class="form-control" name="id_et" id="id_et_edit" style="width: 150px;font-family: Tahoma;font-size: small;" required>
                                        <option value="">----</option>
                                        @foreach($persons as $person)
                                            <option value="{{$person->id_et}}">{{$person->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group" style="height: 15px">
                                    <select  class="form-control" name="nationality" id="nationality_edit" style="width: 100%;font-family: Tahoma;font-size: x-small;">
                                        <option value='ایرانی'>ایرانی</option>
                                        <option value='افغان'>افغان</option>
                                        <option value='ایتالیایی'>ایتالیایی</option>
                                        <option value='هلندی'>هلندی</option>
                                        <option value='فرانسوی'>فرانسوی</option>
                                        <option value='آلمانی'>آلمانی</option>
                                        <option value='انگلیسی'>انگلیسی</option>
                                        <option value='هندی'>هندی</option>
                                        <option value='ترک'>ترک</option>
                                        <option value='عراقی'>عراقی</option>
                                        <option value='پاکستانی'>پاکستانی</option>
                                        <option value='روس'>روس</option>
                                        <option value='سوری'>سوری</option>
                                        <option value='آمریکایی'>آمریکایی</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group" style="height: 15px">
                                    <input hidden type="number" max=100 min=1 class="form-control" id="age_edit"  data-toggle="tooltip" data-placement="right" placeholder="سن:" name="age" style="direction: rtl;font-family: Tahoma;font-size: x-small;width: 100%"  title="سن این فرد وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row"  style="height: 20px;margin-top: 20px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ شروع فعالیت:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت شروع فعالیت:</p></div>
                        </div>

                        <div class="row"  style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_shamsi_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ شروع به کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                            <div class="col" >
                                <div class="form-group" >
                                    <input type="time" maxlength="10" class="form-control" id="time_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت شروع فعالیت:" name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="ساعت شروع به کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row"  style="height: 20px;margin-top: 20px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ پایان فعالیت:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت پایان فعالیت:</p></div>
                        </div>

                        <div class="row"  style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="10" class="form-control" id="date_shamsi_exit_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ پایان فعالیت:" name="date_shamsi_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ پایان کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <input type="time" maxlength="10" class="form-control" id="time_exit_edit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت پایان فعالیت:" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="ساعت پایان کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 20px;margin-top: 20px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">کد ملی:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">شماره تلفن:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text"  pattern="[0-9]{10}" class="form-control" id="code_melli_edit"  data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="کد ملی فرد وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="11" class="form-control" id="mobile_edit"  data-toggle="tooltip" data-placement="right" placeholder="شماره تلفن:" name="mobile" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="شماره موبایل فرد وارد گردد">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 45px">
                            <div class="col" style="text-align:center">
                                <button type="submit" class="btn btn-primary" id="updatepeople" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:80%">ثبت تغییرات</button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div id="s3_1" class="container" style="margin: auto;background-color:rgba(0, 0,55, 0.4);width: 80%;border-radius: 5px;height:250px;direction: rtl;color: white;margin-top: 80px;padding-top: 2px;display: none;overflow-y: scroll">
        <table id="cars_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small;">
            <tr class="bg-primary" style="color: white">
                <th style="border-left: 1px white solid;width: 17%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</th>
                <th style="border-left: 1px white solid;width: 20%;font-family: Tahoma;font-size: smaller;">نام خودرو</th>
                <th style="width: 3%;font-family: Tahoma;font-size: smaller;">--</th>
                <th style="width: 2%;font-family: Tahoma;font-size: smaller;">پلاک</th>
                <th style="border-left: 1px white solid;width: 3%;font-family: Tahoma;font-size: smaller;">--</th>
                <th style="border-left: 1px white solid;width: 25%;font-family: Tahoma;font-size: smaller;">نام راننده</th>
                <th style="border-left: 1px white solid;width: 15%;font-family: Tahoma;font-size: smaller;">#</th>
                <th style="border-left: 1px white solid;width: 15%;font-family: Tahoma;font-size: smaller;">#</th>
            </tr>
        </table>
    </div>
    <div class="modal fade mt-3" id="s3_2" style="direction: rtl;margin-top: 20px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="updatecars" action="{{route('updatecars.edit')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ec_edit"  name="id_ec">
                        <div class="row car_title" style="height: 10px;margin-top: 10px;display: none">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام خودرو:</p>
                            </div>
                            <div class="col" style="text-align: right;">
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">شماره پلاک:</p>
                            </div>
                        </div>

                        <div class="row car_title" style="margin-top: 12px;height: 20px;display: none" id="car_title2">
                            <div class="col">
                                <div class="form-group car_title">
                                    <input type="text" maxlength="15" class="form-control" id="car_name_edit" placeholder="نام خودرو:" name="car_name" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no_edit" placeholder="شماره پلاک خودرو:" name="car_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px">
                                    <input type="text" maxlength="3" class="form-control" id="no1_edit" style="font-family:Tahoma;font-size:small;width: 50px;display: inline" required placeholder="532">
                                    <input type="text" maxlength="1" class="form-control" id="no2_edit" style="font-family:Tahoma;font-size:small;width: 35px;display: inline" required placeholder="ب">
                                    <input type="text" maxlength="2" class="form-control" id="no3_edit" style="font-family:Tahoma;font-size:small;width: 40px;display: inline" required placeholder="98">
                                </div>
                            </div>
                        </div>
                        <div class="row car_title" style="height: 20px;margin-top: 20px;display: none" id="car_title3">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نام راننده:</p></div>
                        </div>

                        <div class="row car_title" style="height: 15px;display: none" id="car_title4">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="15" class="form-control" id="driver_name_edit"  data-toggle="tooltip" data-placement="right" placeholder="نام راننده:" name="driver_name" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="نام راننده وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <select class="form-control" name="area" id="area_edit" style="width:100%;font-family: Tahoma;font-size: small;" required>
                                        <option value=''>محدوده تردد</option>
                                        <option value='ساختمان اداری'>ساختمان اداری</option>
                                        <option value='محدوده انبار'>محدوده انبار</option>
                                        <option value='محدوده پست انتقال'>محدوده پست انتقال</option>
                                        <option value='محدوده واحدهای گازی'>محدوده واحدهای گازی</option>
                                        <option value='محدوده واحدهای بخار'>محدوده واحدهای بخار</option>
                                        <option value='محدوده واحدهای گازی و بخار'>محدوده واحدهای گازی و بخار</option>
                                        <option value='ساختمان اتاق فرمان'>ساختمان اتاق فرمان</option>
                                        <option value='اطراف کارگاهها'>اطراف کارگاهها</option>
                                        <option value='محدوده باغ زیتون'>محدوده باغ زیتون</option>
                                        <option value='محدوده ایستگاه گاز'>محدوده ایستگاه گاز</option>
                                        <option value='محدوده مخازن سوخت'>محدوده مخازن سوخت</option>
                                        <option value='محدوده پارکینگ شمالی'>محدوده پارکینگ شمالی</option>
                                        <option value='محدوده پارکینگ جنوبی'>محدوده پارکینگ جنوبی</option>
                                        <option value='محدوده مهمانسرا'>محدوده مهمانسرا</option>
                                        <option value='تردد در کل سایت'>تردد در کل سایت</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="row" style="margin-top: 45px">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btncar2" style="font-family: Tahoma;font-size: small;text-align: right;">ثبت اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div id="s4_1" class="container" style="margin: auto;background-color:rgba(0, 0,55, 0.4);width: 80%;border-radius: 5px;height:210px;direction: rtl;color: white;margin-top: 80px;padding-top: 2px;display: none;overflow-y: scroll">
        <table id="ins_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
            <tr class="bg-primary" style="color: white">
                <td style="border-left: 1px white solid;width: 16%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</td>
                <td style="border-left: 1px white solid;width: 60%;font-family: Tahoma;font-size: smaller;">نام وسیله الکترونیکی</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
            </tr>
        </table>
    </div>
    <div class="modal fade" id="s4_2" style="direction: rtl;margin-top: 30px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content" style="height: 220px">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray;height: 220px">
                    <form method="post" encType="multipart/form-data" id="updateins" action="{{route('updateins.edit')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ei_edit"  name="id_ei">
                        <div class="row el_title" style="height: 10px;margin-top: 10px">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام قطعه الکترونیکی:</p>
                            </div>
                        </div>

                        <div class="row el_title" style="margin-top: 12px;height: 20px;" id="el_title2">
                            <div class="col">
                                <div class="form-group el_title">
                                    <input type="text" maxlength="50" class="form-control" id="description_edit"  name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 80%" required title="نام قطعه وارد گردد">
                                </div>
                            </div>
                        </div>
                        <div class="row el_title" style="height: 10px;margin-top: 15px;">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">شماره سریال:</p>
                            </div>
                        </div>
                        <div class="row el_title" style="margin-top: 12px;height: 20px;">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="50" class="form-control" id="serial_no_edit" placeholder="شماره سریال:" name="serial_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 50%"  title="شماره سریال در صورت وجود وارد شود">
                                </div>
                            </div>
                        </div>



                        <div class="row" style="margin-top: 45px">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="updateins" style="font-family: Tahoma;font-size: small;text-align: right;">ثبت اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div id="s5_1" class="container" style="margin: auto;background-color:rgba(0, 0,55, 0.4);width: 80%;border-radius: 5px;height:210px;direction: rtl;color: white;margin-top: 72px;padding-top: 2px;display: none;overflow-y: scroll">
        <table id="eq_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
            <tr class="bg-primary" style="color: white">
                <td style="border-left: 1px white solid;width: 16%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</td>
                <td style="border-left: 1px white solid;width: 60%;font-family: Tahoma;font-size: smaller;">نام وسیله </td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
            </tr>
        </table>
    </div>
    <div id="s5_1_2" class="container" style="margin: auto;background-color:rgba(0, 0,55, 0.4);width: 70%;border-radius: 5px;height:210px;direction: rtl;color: white;margin-top: 72px;padding-top: 2px;display: none;overflow-y: scroll">
        <table id="equp_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
            <tr class="bg-primary" style="color: white">
                <td style="border-left: 1px white solid;width: 16%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                <td style="border-left: 1px white solid;width: 60%;font-family: Tahoma;font-size: smaller;">عنوان فایل </td>
                <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
            </tr>
        </table>
    </div>
    <div class="modal fade" id="s5_2" style="direction: rtl;margin-top: 30px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="updateeq" action="{{route('updateeq.edit')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ee_edit"  name="id_ee">
                        <div class="row eq_title" style="height: 10px;margin-top: 10px;">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام وسیله:</p>
                            </div>
                        </div>

                        <div class="row eq_title" style="margin-top: 12px;height: 20px;" id="eq_title2">
                            <div class="col">
                                <div class="form-group eq_title">
                                    <input type="text" maxlength="100" class="form-control" id="description_eq_edit"  name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 80%" required title="نام وسیله وارد گردد">
                                </div>
                            </div>
                        </div>




                        <div class="row" style="margin-top: 45px">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" style="font-family: Tahoma;font-size: small;text-align: right;">ثبت اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s2_3" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">به علت حذف کلیه افراد از این لیست امکان به جریان افتادن این درخواست وجود ندارد.در این مرحله حتما مشخصات یک فرد جهت ورود به نیروگاه وارد گردد</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s2_3_1" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-info" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">توجه</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px"><span style="color: #007be6">مشخصات نفر اول</span> با موفقیت ثبت گردید.شما می توانید مشخصات افراد بیشتری را در <span style="color: #007be6">همین</span> فرم وارد کنید.لیست این افراد در پنجره سمت چپ قابل مشاهده خواهد بود و امکان حذف و یا ویرایش آن در این قسمت وجود خواهد داشت.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s3_3" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px"> به علت حذف کلیه موارد امکان به جریان افتادن این درخواست وجود ندارد.لطفا یا درخواست مجوز ورود خودرو را خیر انتخاب کنید و یا در صورت انتخاب بله حداقل مشخصات یک خودرو وارد شود.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s3_3_1" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-info" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">توجه</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px"> مشخصات  <span style="color: #007be6">خودرو اول </span>با موفقیت ثبت گردید.شما می توانید مشخصات خودروهای بیشتری را در <span style="color: #007be6">همین</span> فرم وارد کنید.لیست این خودروها در پنجره سمت چپ قابل مشاهده خواهد بود و امکان حذف و یا ویرایش آن در این قسمت وجود خواهد داشت.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s4_3" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px"> به علت حذف کلیه موارد امکان به جریان افتادن این درخواست وجود ندارد.لطفا یا درخواست مجوز ورود قطعه الکترونیکی را خیر انتخاب کنید و یا در صورت انتخاب بله حداقل مشخصات یک قطعه وارد شود.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s4_3_1" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-info" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">توجه</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px"> مشخصات  <span style="color: #007be6">وسیله الکترونیکی اول </span>با موفقیت ثبت گردید.شما می توانید مشخصات وسایل بیشتری را در <span style="color: #007be6">همین</span> فرم وارد کنید.لیست این وسایل در پنجره سمت چپ قابل مشاهده خواهد بود و امکان حذف و یا ویرایش آن در این قسمت وجود خواهد داشت.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s5_3_1" style="direction: rtl;top: -100px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-success" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">پایان فرایند درخواست</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">درخواست مجوز ورود این افراد با موفقیت ایجاد گردید و برای مسؤول مستقیم ارسال شد.برای پیگیری وضعیت درخواست به کارتابل خود مراجعه کنید و در بخش گردش موقعیت فعلی درخواست را مشاهده نمایید.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s5_3_2" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">به علت حذف کلیه وسایل از این لیست امکان به جریان افتادن این درخواست وجود ندارد.در این مرحله حتما مشخصات وسایل جهت ورود به نیروگاه وارد گردد</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s6" style="direction: rtl;top: -400px;border-radius: 10px;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم درخواست</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;width: 100%">
                    <div class="row">
                        <div class="col bg-success">.</div>
                        <div class="col bg-danger">.</div>
                        <div class="col bg-primary">.</div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div id="s7" class="container" style="background-color:rgba(0, 0,55, 0.7);width: 60%;border-radius: 5px;height:180px;direction: rtl;color: white;margin-top: 35px;margin-right: 50px;padding-top: 2px;">
         <p id="hint" style="font-family: Tahoma;font-size: small;color: white;margin-top: 40px;text-align: right;text-indent: 5px">فرایند درخواست حضور افراد در نیروگاه شامل پنج مرحله است . در این مرحله دلیل درخواست مجوز برای این افراد و نیز شرکت، سازمان و یا موسسه ای که این افراد در آن عضویت دارند ذکر می شود.در مورد کارگران روزمزد و مواردی از این دست ذکر نام شهر کافیست. پس از ثبت این دو مورد دکمه مربوط به مرحله بعدی ظاهر می شود و با کلیک بر روی آن وارد مرحله دوم خواهیم شد.</p>
    </div>
    <div id="s8" class="container" style="background-color:rgba(0, 0,55, 0.7);width: 60%;border-radius: 5px;height:180px;direction: rtl;color: white;margin-top: 35px;margin-right: 50px;padding-top: 2px;display: none">
        <p id="hint" style="font-family: Tahoma;font-size: small;color: white;margin-top: 20px;text-align: right;text-indent: 5px;">در مرحله دوم مشخصات هر فرد در فرم سمت راست وارد می شود. بعد از ثبت هر یک از این مشخصات ، فرم خالی شده و امکان ورود مشخصات نفر بعدی وجود خواهد داشت. در این مرحله امکان ورود اطلاعات تعداد نامحدودی از افرادی که مایلیم در نیروگاه حضور داشته باشند وجود دارد. بعد از تکمیل اطلاعات این مرحله وارد مرحله سوم می شویم که در آن مشخصات خودرو یا خودروهایی که این افراد با خود وارد نیروگاه می کنند ثبت می شود.</p>
    </div>
    <div id="s9" class="container" style="background-color:rgba(0, 0,55, 0.7);width: 60%;border-radius: 5px;height:210px;direction: rtl;color: white;margin-top: 35px;margin-right: 50px;padding-top: 2px;display: none">
        <p id="hint" style="font-family: Tahoma;font-size: small;color: white;margin-top: 20px;text-align: right;text-indent: 5px;">در مرحله سوم مشخصات خودرو یا خودروهایی که افراد دعوت شده به نیروگاه وارد می کنند در فرم سمت راست وارد می شود.همچنین محدوده تردد این خودروها نیز دز همین فرم قابل تعیین است. بعد از ثبت هر یک از این موارد ، فرم خالی شده و امکان ورود مشخصات خودرو بعدی وجود خواهد داشت. در این مرحله امکان ورود اطلاعات تعداد نامحدودی از خودروهایی که مایلیم در نیروگاه امکان تردد داشته باشند وجود دارد. بعد از تکمیل اطلاعات این مرحله وارد مرحله چهارم می شویم که در آن مشخصات وسایل الکترونیکی که این افراد با خود وارد نیروگاه می کنند ثبت می شود.</p>
    </div>
    <div id="s10" class="container" style="background-color:rgba(0, 0,55, 0.7);width: 60%;border-radius: 5px;height:180px;direction: rtl;color: white;margin-top: 35px;margin-right: 50px;padding-top: 2px;display: none">
        <p id="hint" style="font-family: Tahoma;font-size: small;color: white;margin-top: 20px;text-align: right;text-indent: 5px;">در مرحله چهارم مشخصات تجهیزات الکرونیکی که افراد دعوت شده به نیروگاه مجوز ورود به نیروگاه را دارند، در فرم سمت راست وارد می شود. بعد از ثبت هر یک از این موارد ، فرم خالی شده و امکان ورود مشخصات وسیله الکترونیکی بعدی وجود خواهد داشت. در این مرحله امکان ورود اطلاعات تعداد نامحدودی از وسایل الکترونیکی که مدعوین به همراه دارند وجود دارد. بعد از تکمیل اطلاعات این مرحله وارد مرحله پنجم می شویم که در آن مشخصات وسایل و تجهیزاتی که این افراد جهت انجام کار با خود وارد نیروگاه می کنند ثبت می شود.</p>
    </div>
    <div id="s11" class="container" style="background-color:rgba(0, 0,55, 0.7);width: 60%;border-radius: 5px;height:200px;direction: rtl;color: white;margin-top: 35px;margin-right: 50px;padding-top: 2px;display: none">
        <p id="hint" style="font-family: Tahoma;font-size: small;color: white;margin-top: 20px;text-align: right;text-indent: 5px;">در مرحله پنجم مشخصات تجهیزات مورد استفاده افراد دعوت شده به نیروگاه در فرم سمت راست وارد می شود. بعد از ثبت هر یک از این موارد ، فرم خالی شده و امکان ورود مشخصات سایر تجهیزات وجود خواهد داشت. در این مرحله امکان ورود اطلاعات تعداد نامحدودی از وسایلی که مدعوین به همراه دارند وجود دارد. روش دیگر برای ورود این اطلاعات آپلود کردن فایل پی دی اف حاوی این اطلاعات است. بعد از تکمیل اطلاعات این مرحله ، دکمه تکمیل فرایند ظاهر می شود و شما با کلیک بر روی آن ،درخواست خود را برای مسئول مستقیم ارسال می کنید. </p>
    </div>
    <div class="modal fade mt-3" id="s12" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 100px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">تنها امکان ارسال فایلهای پی دی اف وجود دارد</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s13" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 100px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">حجم فایل ارسالی بیشتر از مقدار مجاز است.حداکثر حجم مجاز برای ارسال 2 مگابایت می باشد.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s14" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 100px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">این فرد طبق درخواست شماره دارای مجوز ورود به نیروگاه می باشد</p>
                </div>
            </div>
        </div>
    </div>
@endsection


