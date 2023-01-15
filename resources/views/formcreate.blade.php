@extends('layouts.app_requester2')
@section('content')
<script>
    $(document).ready(function() {
        var condition="";
        var date_shamsi=$("#date_shamsi").val();
        $("#first_btn").click(function() {
            var enter_exit=$("#enter_exit").val();
            if(enter_exit==0){
                $("#comm1").text('متاسفانه شما');
                $("#note").text(' نوع مجوز را انتخاب نکرده اید.');
                $("#comm2").text('لطفا مجددا جهت');
                $("#comm3").text('تعیین نوع مجوز');
                $("#comm4").text('به فرم مربوطه مراجعه کنید');
                $('#sub').attr("disabled", true);
            }
            if(enter_exit==1){
                $("#comm1").text('فرمی برای دریافت');
                $("#note").text('مجوز خروج');
                $("#comm2").text('توسط شما درخواست شده.در صورت اطمینان از این انتخاب');
                $("#comm3").text('بر روی دکمه');
                $("#comm4").text('ایجاد فرم کلیک کنید.در غیراینصورت بر روی دکمه بازگشت کلیک کنید.');
                $('#sub').attr("disabled", false);
            }
            if(enter_exit==2){
                $("#comm1").text('فرمی برای دریافت');
                $("#note").text('مجوز ورود');
                $("#comm2").text('توسط شما درخواست شده.در صورت اطمینان از این انتخاب');
                $("#comm3").text('بر روی دکمه');
                $("#comm4").text('ایجاد فرم کلیک کنید.در غیراینصورت بر روی دکمه بازگشت کلیک کنید.');
                $('#sub').attr("disabled", false);
            }

        });

    })
</script>

    <div class="container" style="direction: rtl">
        <div class="row">
            <div class="col-6  mt-3">
                <form method="post" action={{route('form.store')}}>
                    {{csrf_field()}}
                    <div class="form-group">
{{--                        <p style="display: inline;font-family: Tahoma;font-size: small">انتخاب نوع مجوز:</p>--}}
                        <select class="form-control" name="enter_exit" id="enter_exit" style="display: inline;font-family: Tahoma;font-size: small;width: 150px">
                            <option value=0>انتخاب نوع مجوز</option>
                            <option value=1>مجوز خروج</option>
                            <option value=2>مجوز ورود</option>
                        </select>
                        <button type="button" style="display: inline;font-family: Tahoma;font-size: small" class="btn btn-primary" id="first_btn" data-toggle="modal" data-target="#myModal">ایجاد فرم</button>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="date_shamsi"  name="date_shamsi" value={{$date_shamsi}}>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="date_miladi"  name="date_miladi" value={{$mytime}}>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="timestamp"  name="timestamp" value={{$mytime->timestamp}}>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="id_requester" placeholder="Enter the id of requester" name="id_requester" value={{$user}}>
                    </div>

                    <!-- The Modal -->
                    <div class="modal fade" id="myModal" style="direction: rtl">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <!-- Modal Header -->
                                <div class="modal-header bg-info">
                                    <div class="row" style="width: 100%">
                                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">یاداوری</p></div>
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

                                <!-- Modal body -->
                                <div class="modal-body" id="comment" style="font-family: Tahoma;font-size: small;direction: rtl">
                                    <p id="comm1">آیا شما از ایجاد فرمی برای اخذ</p>
                                    <p id="note" style="font-weight: bold"></p>
                                    <p id="comm2">اطمینان دارید</p>
                                    <p id="comm3">؟</p>
                                    <p id="comm4">در صورت انتخاب اشتباه نوع مجوز ، گردش این فرم با اشکالاتی مواجه خواهد شد.</p>
                                </div>

                                <!-- Modal footer -->
                                <div class="modal-footer">
                                    <button type="submit" style="font-family: Tahoma;font-size: small" class="btn btn-sm btn-primary" id="sub">ایجاد فرم</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    @include('shared.errors')


                </form>
            </div>
            <div class="col-3">.</div>
            <div class="col-3">.</div>
        </div>
    </div>


@endsection
