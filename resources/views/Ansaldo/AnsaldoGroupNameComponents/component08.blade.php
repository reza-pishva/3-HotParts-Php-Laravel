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