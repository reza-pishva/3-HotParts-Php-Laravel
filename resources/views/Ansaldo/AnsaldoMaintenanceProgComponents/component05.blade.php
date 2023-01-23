<div class="row tarep" style="display: none;width: 120%;margin-left: 100px">
    <div class="col-1"></div>
    <div class="col-8 bg-info  pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan"> گزارش گیری از اطلاعات تعمیرات برنامه ریزی شده</p></div>
    <div class="col-3"></div>
</div>
<div class="row tarep" style="display: none;;width: 120%;margin-left: -115px;direction: rtl">
    <div class="col-1  mt-3"></div>
    <div class="col-8  mt-1" style="background-color:rgba(134,179,223,0.5);border-radius: 10px;height: 420px ">
        <form method="post" encType="multipart/form-data" id="tprep_form" action={{route('tp.store')}}>
            {{csrf_field()}}
            <div hidden class="row">
                <div class="col-3 mt-2">
                    <select class="form-control isclicked1" name="ID_NN_REP" id="ID_NN_REP" style="width: 100%;font-family: Tahoma;font-size:small;display: inline">
                        @foreach($anns as $ann)
                            <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3">
                    <select class="form-control isclicked1" name="ID_UN_REP" id="ID_UN_REP" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="0"><p style="font-size: xx-small">واحد</p></option>
                        @foreach($auns as $aun)
                            <option value="{{$aun->ID_UN}}">{{$aun->UNIT_NUMBER}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <select class="form-control isclicked1" name="ID_TT_REP" id="ID_TT_REP" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="0">نوع تعمیرات</option>
                        @foreach($atts as $att)
                            <option value="{{$att->ID_TT}}">{{$att->TAMIRAT_TYPE}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-5">
                    <select class="form-control isclicked1" name="ID_TA_REP" id="ID_TA_REP" required style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="0">انتخاب پیمانکار</option>
                        @foreach($ats as $at)
                            <option value="{{$at->ID_TA }}">{{$at->TAMIRKAR}}</option>
                        @endforeach
                    </select>
                </div>
                <br><br>
            </div>
            <br>
            <div class="field row">
                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">وضعیت انجام تعمیرات</p></div>
                <div class="col-3" style="text-align: left">
                    <select class="form-control isclicked1" name="ANGAM_REP" id="ANGAM_REP" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="0">انتخاب</option>
                        <option value="1">تعمیرات انجام شده</option>
                        <option value="2">تعمیرات انجام نشده</option>
                    </select>
                </div>
                <div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">وضعیت تایید تعمیرات</p></div>
                <div class="col-3" style="text-align: left">
                    <select class="form-control isclicked1" name="CONFIR_REP" id="CONFIR_REP" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                        <option value="0">انتخاب</option>
                        <option value="1">تعمیرات تایید شده</option>
                        <option value="2">تعمیرات تایید نشده</option>
                    </select>
                </div>
                    <div class="col-2" style="text-align: right">
                        <button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >جستجو </button>
                    </div>

            </div>


            <div class="row">
                <div class="col-12">
                    <div class="row mylist" style="margin: auto;width:100%;height:258px;direction: rtl;margin-top: 12px;border: 1px solid black;border-radius: 5px;background-color: beige">
                        <div class="col-12" style="direction: rtl;height: 253px;overflow-y: scroll">
                            <table id="tamirat_table_report" class="table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
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