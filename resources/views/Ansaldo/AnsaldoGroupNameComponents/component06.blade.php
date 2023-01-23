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