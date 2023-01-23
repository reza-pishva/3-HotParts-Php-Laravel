<div class="row tainfo" style="display: none;width: 120%;margin-left: 100px">
    <div class="col-1"></div>
    <div class="col-8 bg-info  pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan"> ورود اطلاعات برنامه تعمیرات</p></div>
    <div class="col-3"></div>
</div>
<div class="row tainfo " style="display: none;width: 120%;margin-left: -115px;direction: rtl">
    <div class="col-1  mt-3"></div>
    <div class="col-8  mt-1" style="background-color:rgba(47,47,119,0.5);border-radius: 10px;height: 420px ">
        <form method="post" encType="multipart/form-data" id="tp_form" action={{route('tp.store')}}>
            {{csrf_field()}}
            <div class="row">
                <div>
                    <input type="hidden" class="form-control" id="ID_T" name="ID_T" >
                    <input type="hidden" class="form-control" id="flag">
                </div>
                <div class="col-3 mt-2">
                    <select hidden class="form-control isclicked1" name="ID_NN" id="ID_NN" style="width: 100%;font-family: Tahoma;font-size:small;display: inline">
                        @foreach($anns as $ann)
                            <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <select class="form-control isclicked1" name="ID_UN" id="ID_UN" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value=""><p style="font-size: xx-small">واحد</p></option>
                        @foreach($auns as $aun)
                            <option value="{{$aun->ID_UN}}">{{$aun->UNIT_NUMBER}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-control isclicked1" name="ID_TT" id="ID_TT" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="">نوع تعمیرات</option>
                        @foreach($atts as $att)
                            <option value="{{$att->ID_TT}}">{{$att->TAMIRAT_TYPE}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <select class="form-control isclicked1" name="ID_TA" id="ID_TA" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="">انتخاب پیمانکار</option>
                        @foreach($ats as $at)
                            <option value="{{$at->ID_TA }}">{{$at->TAMIRKAR}}</option>
                        @endforeach
                    </select>
                </div>
                <br><br>
                <div class="field row" >
                    <div class="col-3" style="text-align: center"><p style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px">تاریخ شروع تعمیرات</p></div>
                    <div class="col-3" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_BEGIN_SH"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGIN_SH"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>
                    <div class="col-3" style="text-align: center"><label for="date_shamsi2" style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px"> تاریخ پایان تعمیرات:</label></div>
                    <div class="col-3" style="text-align: center"><input type="text" maxlength="10" class="form-control" id="DATE_END_SH"  data-toggle="tooltip" data-placement="right"  name="DATE_END_SH" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" required title="تاریخ پایان تعمیرات"></div>
                </div>
            </div>
            <br>
            <div class="field row">
                    <div class="col-3" style="text-align: center;"> <input style="font-size: 10px;font-family: Tahoma" type="number" max="9999999" class="form-control" id="TIME_WORK_REAL"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_REAL" placeholder="کارکرد واقعی" style="font-family: Tahoma;font-size: small;width: 60%;" required title="کارکرد واقعی"></div>
                    <div class="col-3" style="text-align: center;"><input style="font-size: 10px;font-family: Tahoma" type="number" max="9999999" class="form-control" id="TIME_WORK_EQUAL"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_EQUAL" placeholder="کارکرد معادل" style="direction: rtl;font-family: Tahoma;font-size: small;width: 60%" required title="کارکرد معادل"></div>

            </div>
            <br>
            <div class="field row">
                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">تایید شد</p></div>
                <div class="col-1" style="text-align: left">
                    <input style="font-size: 4px" class="form-control" type="checkbox" id="CONFIR" name="CONFIR" value="1">
                </div>
                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">انجام شد</p></div>
                <div class="col-1" style="text-align: left">
                    <input style="font-size: 4px" class="form-control" type="checkbox" id="ANGAM" name="ANGAM" value="1">
                </div>

                <div class="col-2"><p style="font-size: 12px;font-family: Tahoma;color: #fdfdfe">الصاق فایل</p></div>
                <div class="col-2"><input style="color: #fdfdfe;font-size: smaller" type="file" id="select_file"  placeholder="الصاق فایل" name="select_file"></div>
            </div>

            <div class="field row mt-0">
                    <div class="col-8" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" title="توضیحات"></div>
                    <div class="col-4" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
                </div>
            <div class="row">
                <div class="col-12">
                    <div class="row mylist" style="margin: auto;width:100%;height:168px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                        <div class="col-12" style="direction: rtl;height: 163px;overflow-y: scroll">
                            <table id="tamirat_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                <tr class="bg-primary" style="color: white;font-size:x-small;">
                                    <td>کد</td>
                                    <td>نام شرکت</td>
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