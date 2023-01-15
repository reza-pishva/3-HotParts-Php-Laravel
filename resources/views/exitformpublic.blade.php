@extends('layouts.app_requester2')
@section('content')
    <script>
        $(document).ready(function(){
            $("#upload_form_request").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/exit-store",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // alert(data.enter_exit)
                        toastr.success("درخواست جدید با موفقیت به فرم الصاق گردید", "", {
                            "timeOut": "3500",
                            "extendedTImeout": "0"
                        });
                            // $('#ajax-alert2').addClass('alert-success').show(function () {
                            //     $(this).html("این آیتم با موفقیت به فرم درخواست جاری اضافه گردید");
                            // });
                            $('#ajax-alert2').hide();
                            $('#ajax-alert1').hide();
                            $('#ajax-alert3').hide();
                            $("#id_exit").val(data.data);
                            $(".mylist").show();
                            $("#title").text('مربوط به فرم درخواست ' + $("#id_form").val());
                            var id_exit = $('<td class="id_exit">' + $("#id_exit").val() + '</td>')
                            var date_request_shamsi = $('<td>' + $('#date_request_shamsi').val() + '</td>')
                            var origin_destination = $('<td hidden>' + $('#origin_destination').val() + '</td>')
                            var description = $('<td>' + $('#description').val() + '</td>')
                            var exit_no = $('<td>' + $('#exit_no').val() + '</td>')
                            var jamdari_no = $('<td>' + $('#jamdari_no').val() + '</td>')
                            var goods_type_value = $('<td hidden>' + $('#id_goods_type').val() + '</td>')
                            var id_goods_type = $('<td>' + $('#id_goods_type option:selected').text() + '</td>')
                            var with_return_value = $('<td hidden>' + $('#with_return').val() + '</td>')
                            // if(data.enter_exit==1){
                            //     var with_return = $('<td>' + $('#with_return option:selected').text() + '</td>')
                            // }
                            // if(data.enter_exit==2){
                            //     var with_return = $('<td>--</td>')
                            // }
                        if(true){
                            var with_return = $('<td>' + $('#with_return option:selected').text() + '</td>')
                        }
                            // var with_return = $('<td>' + $('#with_return option:selected').text() + '</td>')
                            var t1 = $('<td></td>')
                            var edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: small;text-align: right" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',data.data + 5000)
                            var del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: small;text-align: right">حذف</button>').attr('id',data.data+4000)
                            t1.append(edit1)
                            var t2 = $('<td></td>')
                            var row = $('<tr></tr>')
                            t2.append(del2)
                            row.append(id_exit, date_request_shamsi, description, exit_no, jamdari_no, id_goods_type, with_return, t2, t1,origin_destination,goods_type_value,with_return_value)

                            $('#jamdari_no').val('');
                            $('#description').val('');
                            $('#description12').val('');
                            $('#origin_destination').val('');
                            $('#exit_no').val('');
                            $('#id_goods_type').prop("selectedIndex", 0);
                            $('#with_return').prop("selectedIndex", 0);
                            $('#unit').prop("selectedIndex", 0);

                            $("#request_table1").append(row)
                            $('#' + (Number(data.data) + 5000)).click(function () {
                                //alert($(this).closest('tr').find('td:eq(11)').text());
                                $('#ajax-alert3').hide();
                                $('#id_exit2').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#description2').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#exit_no2').val($(this).closest('tr').find('td:eq(3)').text());
                                $('#jamdari_no2').val($(this).closest('tr').find('td:eq(4)').text());
                                $('#id_goods_type2').val($(this).closest('tr').find('td:eq(10)').text());
                                $('#with_return2').val($(this).closest('tr').find('td:eq(11)').text());
                                $('#origin_destination2').val($(this).closest('tr').find('td:eq(9)').text());

                                $('tr').find('td:eq(2)').removeClass('description');
                                $('tr').find('td:eq(3)').removeClass('exit_no');
                                $('tr').find('td:eq(4)').removeClass('jamdari_no');
                                $('tr').find('td:eq(5)').removeClass('goods_type');
                                $('tr').find('td:eq(6)').removeClass('with_return');
                                $('tr').find('td:eq(9)').removeClass('origin_destination');
                                $('tr').find('td:eq(10)').removeClass('goods_type_value');
                                $('tr').find('td:eq(11)').removeClass('with_return_text');

                                $(this).closest('tr').find('td:eq(2)').addClass('description');
                                $(this).closest('tr').find('td:eq(3)').addClass('exit_no');
                                $(this).closest('tr').find('td:eq(4)').addClass('jamdari_no');
                                $(this).closest('tr').find('td:eq(5)').addClass('goods_type');
                                $(this).closest('tr').find('td:eq(6)').addClass('with_return');
                                $(this).closest('tr').find('td:eq(9)').addClass('origin_destination');
                                $(this).closest('tr').find('td:eq(10)').addClass('goods_type_value');
                                $(this).closest('tr').find('td:eq(11)').addClass('with_return_text');


                            })
                            $('#' + (Number(data.data)+4000)).click(function () {
                                var id_exit = $('#' + (Number(data.data)+4000)).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/exit-delete/" + id_exit,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_exit,
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
                                        toastr.error('این درخواست از این فرم حذف گردید');
                                        // $('#ajax-alert1').addClass('alert-danger').show(function () {
                                        //     $(this).html("این آیتم با موفقیت از فرم درخواست جاری حذف گردید");
                                        // });
                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                    }
                                });
                                $('#' + (Number(data.data)+4000)).closest('tr').remove();
                        })
                    }
                });

            });
            $("#edit_form_request").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/editform",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('.description').text(response.description);
                        $('.jamdari_no').text(response.jamdari_no);
                        $('.exit_no').text(response.exit_no);
                        if(true){
                            $('.with_return').text(response.with_return_text);
                        }
                        // if(response.enter_exit==2){
                        //     $('.with_return').text('--');
                        // }
                        $('.goods_type').text(response.goods_type);
                        $('.origin_destination').text(response.origin_destination);
                        $('.goods_type_value').text(response.id_goods_type);
                        $('.with_return_text').text(response.with_return);
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
                        toastr.info('این درخواست تغییر داده شد');

                        $('#ajax-alert1').hide();
                        $('#ajax-alert2').hide();
                        $('#ajax-alert3').hide();
                        // $('#ajax-alert3').addClass('alert-primary').show(function(){
                        //     $(this).html("آیتمهای درخواست جاری به روز رسانی گردید");
                        // });
                    }
                });
            });
            $(".isclicked1").on('focus',function (event) {
                $('#ajax-alert1').hide();
                $('#ajax-alert2').hide();
                $('#ajax-alert3').hide();
            })
        });
    </script>
    <!-- Title of Register form -->
        <div hidden class="row register" style="margin: auto;width:80%">
            <div class="col-2" style="width: 25px">.</div>
            <div class="col-8" style="height: 35px;margin-top: 30px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color: slateblue"><p style="margin-top: 7px;">فرم تعیین قطعات و کالاها</p></div>
            <div class="col-2" style="width: 25px">.</div>

        </div>
    <!-- Register form -->
        <div class="row register" style="margin: auto;width:100%;direction: rtl">
            <div class="col-2 mt-5">.</div>
            <div class="col-8 pt-3" style="background-color: gainsboro;border-radius: 5px;margin-top: 3px;">
                <form method="post" encType="multipart/form-data" id="upload_form_request" action={{route('exit.store')}}>
                    {{csrf_field()}}
                     <div class="row">
                        <div class="col">
                            <input type="hidden" class="form-control" id="id_form"  name="id_form" value={{$forms->id_form}}>
                            <input type="hidden" class="form-control" id="enter_exit"  name="enter_exit" value={{$forms->enter_exit}}>
                            <input type="hidden" class="form-control" id="date_request_shamsi"  name="date_request_shamsi" value={{$date_shamsi}}>
                            <input type="hidden" class="form-control" id="date_request_miladi"  name="date_request_miladi" value={{$mytime}}>
                            <input type="hidden" class="form-control" id="time_request"  name="time_request" value={{$mytime->toTimeString()}}>
                            <input type="hidden" class="form-control" id="request_timestamp"  name="request_timestamp" value={{$mytime->timestamp}}>
                            <input type="hidden" class="form-control" id="id_requester" placeholder="Enter the id of requester" name="id_requester" value={{$user}}>
                            <input type="hidden" class="form-control" id="id_request_part" name="id_request_part" value={{$part}}>
                            <div class="form-group" >
                                <input type="text" maxlength="30" class="form-control isclicked1" id="origin_destination" data-toggle="tooltip" data-placement="right" placeholder="مبدا یا مقصد قطعه:" name="origin_destination" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا مبدا یا مقصد این قطعه را وارد کنید">
                            </div>
                            <div class="form-group">
                                <input type="text" maxlength="50" class="form-control isclicked1" id="description" data-toggle="tooltip" data-placement="right" placeholder="شرح کالا یا قطعه:" name="description" style="direction:rtl;font-family:Tahoma;font-size:small" required title="شرح کالا و یا قطعه مورد نظر برای ورود یا خروج از نیروگاه">
                            </div>
                            <div class="form-group">
                                <input type="text" maxlength="200" class="form-control isclicked1" id="description12" data-toggle="tooltip" data-placement="right" placeholder="توضیحات:" name="description12" style="direction:rtl;font-family:Tahoma;font-size:small;background-color:#b8daff"  title="اطلاعاتی که لازم است مدیر نیروگاه و سایر گیرندگان این درخواست در جریان باشند در اینجا وارد شود">
                            </div>
                            <div class="form-group" style="text-align: right">
                                <input type="number" max="10000" min="1" class="form-control isclicked1" id="exit_no" data-toggle="tooltip" data-placement="right" placeholder="تعداد موارد:" name="exit_no" style="direction:rtl;font-family:Tahoma;font-size:small;width:120px;display: inline" required title="تعداد مواردی که باید وارد یا خارج از نیروگاه شوند">
                                <select class="form-control isclicked1" name="unit" id="unit" style="width:100px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value='عدد'>عدد</option>
                                    <option value='دستگاه'>دستگاه</option>
                                    <option value='کیلو'>کیلو</option>
                                    <option value='تن'>تن</option>
                                    <option value='لیتر'>لیتر</option>
                                    <option value='مترمکعب'>مترمکعب</option>
                                    <option value='متر'>متر</option>
                                    <option value='ست'>ست</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <input type="text" maxlength="20" class="form-control isclicked1" id="jamdari_no" data-toggle="tooltip" data-placement="right" placeholder="شماره سریال یا جمعداری:" name="jamdari_no" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره سریال یا جمعداری در این قسمت وارد شود">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group" style="text-align: right">
                                <p style="font-family: Tahoma;font-size: small;display: inline"> نوع قطعه:</p>
                                <select class="form-control isclicked1" name="id_goods_type" id="id_goods_type" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                    @foreach($goodstypes as $goodstype)
                                        <option value="{{$goodstype->id_goods_type}}">{{$goodstype->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                                                            <div  class="form-group" style="text-align: right">
                                                                 <label for="with_return" style="font-family: Tahoma;font-size: small;display: inline"> همراه با بازگشت:</label>
                                                                    <select class="form-control isclicked1" name="with_return" id="with_return" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                                                        <option value=1>بله</option>
                                                                        <option value=2>خیر</option>
                                                                    </select>
                                                                    <br><br><br>

                                                            </div>
{{--                            @if($forms->enter_exit==2)--}}

{{--                                <div  hidden class="form-group" style="text-align: right">--}}
{{--                                    <label for="with_return" style="font-family: Tahoma;font-size: small;display: inline"> همراه با بازگشت:</label>--}}
{{--                                    <select class="form-control isclicked1" name="with_return" id="with_return" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">--}}
{{--                                        <option value=1>بله</option>--}}
{{--                                        <option value=2>خیر</option>--}}
{{--                                    </select>--}}
{{--                                    <br><br><br>--}}

{{--                                </div>--}}
{{--                            @endif--}}
{{--                            @if($forms->enter_exit==1)--}}
{{--                                <div  class="form-group" style="text-align: right">--}}
{{--                                     <label for="with_return" style="font-family: Tahoma;font-size: small;display: inline"> همراه با بازگشت:</label>--}}
{{--                                        <select class="form-control isclicked1" name="with_return" id="with_return" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">--}}
{{--                                            <option value=1>بله</option>--}}
{{--                                            <option value=2>خیر</option>--}}
{{--                                        </select>--}}
{{--                                        <br><br><br>--}}

{{--                                </div>--}}
{{--                            @endif--}}

                            <button type="submit" class="btn btn-primary" id="btnAdd" style="font-family: Tahoma;font-size: small;text-align: right">ثبت درخواست</button>
                        </div>
                    </div>
                    @include('shared.errors')
                    <div id="ajax-alert1" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
                    <div id="ajax-alert2" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
{{--                    <div id="validation" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>--}}
                    <input type="hidden" class="form-control" id="id_exit">

                </form>
            </div>
            <div class="col-2 mt-5">.</div>
        </div>
    <!-- Title of list of items -->
        <div class="row mylist" style="margin: auto;width:100%;display: none">
            <div class="col-12 bg-info" style="height: 35px;margin-top: 15px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right"><p id="title" style="margin-top: 7px;"></p></div>
        </div>
    <!-- List of content -->
        <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
          <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
            <table id="request_table1" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                <tr class="bg-primary" style="color: white">
                    <td>شماره درخواست</td>
                    <td>تاریخ درخواست</td>
                    <td>شرح درخواست</td>
                    <td>تعداد موارد</td>
                    <td>شماره جمعداری</td>
                    <td>نوع قطعه</td>
                    <td>همراه بازگشت</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
            </table>
          </div>
        </div>
    <!-- Edit form -->
        <div class="modal fade mt-3" id="myModal2" style="direction: rtl;margin-top:10px;position: relative;top: -800px;left: 10%;">
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request" action="{{route('editform.edit')}}">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" id="id_form2"  name="id_form" value={{$forms->id_form}}>
                        <input type="hidden" class="form-control" id="id_exit2"  name="id_exit2">
                        <input type="hidden" class="form-control" id="enter_exit2"  name="enter_exit" value={{$forms->enter_exit}}>
                        <input type="hidden" class="form-control" id="date_request_shamsi2"  name="date_request_shamsi" value={{$date_shamsi}}>
                        <input type="hidden" class="form-control" id="date_request_miladi2"  name="date_request_miladi" value={{$mytime}}>
                        <input type="hidden" class="form-control" id="time_request2"  name="time_request" value={{$mytime->toTimeString()}}>
                        <input type="hidden" class="form-control" id="request_timestamp2"  name="request_timestamp" value={{$mytime->timestamp}}>
                        <input type="hidden" class="form-control" id="id_requester2" placeholder="Enter the id of requester" name="id_requester" value={{$user}}>
                        <input type="hidden" class="form-control" id="id_request_part2" name="id_request_part" value={{$part}}>
                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">مقصد:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نوع قطعه:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="30" class="form-control" id="origin_destination2"  data-toggle="tooltip" data-placement="right" placeholder="مقصد قطعه:" name="origin_destination2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="لطفا مبدا یا مقصد این قطعه را وارد کنید">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <select class="form-control" name="id_goods_type2" id="id_goods_type2" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                        @foreach($goodstypes as $goodstype)
                                            <option value="{{$goodstype->id_goods_type}}">{{$goodstype->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">شرح انتقال:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-12">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="50" class="form-control" id="description2" data-toggle="tooltip" data-placement="right" placeholder="شرح کالا یا قطعه:" name="description2" style="direction:rtl;font-family:Tahoma;font-size:small" required title="شرح کالا و یا قطعه مورد نظر برای ورود یا خروج از نیروگاه">
                                </div>
                                <div class="form-group">
                                    <input type="text" maxlength="200" class="form-control isclicked1" id="description3" data-toggle="tooltip" data-placement="right" placeholder="توضیحات:" name="description3" style="direction:rtl;font-family:Tahoma;font-size:small;background-color:#b8daff"  title="اطلاعاتی که لازم است مدیر نیروگاه و سایر گیرندگان این درخواست در جریان باشند در اینجا وارد شود">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">تعداد قطعه:</p>
                            </div>
                            <div class="col">
{{--                                @if($forms->enter_exit==2)--}}
{{--                                  <p hidden style="text-align: right;font-family: Tahoma;font-size: small">همراه با بازگشت:</p>--}}
{{--                                @endif--}}
                                @if(true)
                                  <p  style="text-align: right;font-family: Tahoma;font-size: small">همراه با بازگشت:</p>
                                @endif
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col">
                                <div class="form-group">
                                    <input type="number" max="10000" min="1" class="form-control isclicked1" id="exit_no2" data-toggle="tooltip" data-placement="right" placeholder="تعداد موارد:" name="exit_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width:110px;display: inline" required title="تعداد مواردی که باید وارد یا خارج از نیروگاه شوند">
                                    <select class="form-control isclicked1" name="unit2" id="unit2" style="width:95px;font-family: Tahoma;font-size: small;display: inline">
                                        <option value='عدد'>عدد</option>
                                        <option value='دستگاه'>دستگاه</option>
                                        <option value='کیلو'>کیلو</option>
                                        <option value='تن'>تن</option>
                                        <option value='لیتر'>لیتر</option>
                                        <option value='مترمکعب'>مترمکعب</option>
                                        <option value='متر'>متر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
{{--                                @if($forms->enter_exit==2)--}}
{{--                                <div hidden class="form-group" style="text-align: right">--}}
{{--                                    <select class="form-control" name="with_return2" id="with_return2" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">--}}
{{--                                        <option value=1>بله</option>--}}
{{--                                        <option value=2>خیر</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                @endif--}}
                                    @if(true)
                                        <div  class="form-group" style="text-align: right">
                                            <select class="form-control" name="with_return2" id="with_return2" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                                <option value=1>بله</option>
                                                <option value=2>خیر</option>
                                            </select>
                                        </div>
                                    @endif
                            </div>
                        </div>

                        <div class="row" style="height: 20px;margin-top:18px">
                            <div class="col-12">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">شماره جمعداری یا شماره سریال:</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="text" maxlength="20" class="form-control" id="jamdari_no2" data-toggle="tooltip" data-placement="right" placeholder="شماره جمعداری یا شماره سریال:" name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px"  title="شماره جمعداری در این قسمت وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">اعمال تغییرات</button>
                            </div>
                        </div>
                        <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>


@endsection
