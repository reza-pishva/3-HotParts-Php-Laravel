<div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
    <div class="modal-dialog modal-md" style="margin-top: 25px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح اطلاعات تعمیرات</p></div>
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
            <div class="container"  style="margin: auto;background-color:lightgray;height: 370px ">
                <form method="post" encType="multipart/form-data" id="tainfoedit" action="{{route('tp.edit')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_T_EDIT" name="ID_T_EDIT" >
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-3">
                            <select class="form-control isclicked1" name="ID_NN_EDIT" id="ID_NN_EDIT" style="width: 150px;font-family: Tahoma;font-size: small;display: inline">
                                @foreach($anns as $ann)
                                    <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3 mr-5">
                            <select class="form-control isclicked1" name="ID_UN_EDIT" id="ID_UN_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value=""><p style="font-size: xx-small">مربوط به واحد</p></option>
                                @foreach($auns as $aun)
                                    <option value="{{$aun->ID_UN}}">{{$aun->UNIT_NUMBER}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3 ">
                            <select class="form-control isclicked1" name="ID_TT_EDIT" id="ID_TT_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">نوع تعمیرات</option>
                                @foreach($atts as $att)
                                    <option value="{{$att->ID_TT}}">{{$att->TAMIRAT_TYPE}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3" style="margin-right: 100px">
                            <select class="form-control isclicked1" name="ID_TA_EDIT" id="ID_TA_EDIT" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="">انتخاب پیمانکار</option>
                                @foreach($ats as $at)
                                    <option value="{{$at->ID_TA }}">{{$at->TAMIRKAR}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row mt-0">
                        <div class="field row" >
                            <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ شروع تعمیرات</p></div>
                            <div class="col-3" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_BEGIN_SH_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGIN_SH_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ شروع تعمیرات"></div>
                            <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ پایان تعمیرات</p></div>
                            <div class="col-3" style="text-align: center"><input type="text" maxlength="10" class="form-control" id="DATE_END_SH_EDIT"  data-toggle="tooltip" data-placement="right"  name="DATE_END_SH_EDIT" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" required title="تاریخ پایان تعمیرات"></div>
                        </div>
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کارکرد واقعی</p></div>
                        <div class="col-4" style="text-align: center"> <input type="number" max="9999999" class="form-control" id="TIME_WORK_REAL_EDIT"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_REAL_EDIT" placeholder="کارکرد واقعی" style="font-family: Tahoma;font-size: small;width: 70%;" required title="کارکرد واقعی"></div>
                        <div class="col-6" style="text-align: center">
                            <input style="color: #4e555b;font-size: smaller" type="file" id="select_file_edit" placeholder="الصاق فایل" name="select_file_edit">
                        </div>
                    </div>
                    <div class="field row">
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کارکرد معادل</p></div>
                        <div class="col-4" style="text-align: center"><input type="number" max="9999999" class="form-control" id="TIME_WORK_EQUAL_EDIT"  data-toggle="tooltip" data-placement="right"  name="TIME_WORK_EQUAL_EDIT" placeholder="کارکرد معادل" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="کارکرد معادل"></div>
                        <div class="col-6" style="text-align: center"><p id="FILE_NAME_EDIT" style="text-align: right;font-size: small;font-family: Tahoma"></p></div>
                    </div>
                    <br>
                    <div class="field row">
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma"></p></div>
                        <div class="col-1" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma">تایید شد</p></div>
                        <div class="col-2" style="text-align: left">
                            <input style="font-size: 4px" class="form-control" type="checkbox" id="CONFIR_EDIT" name="CONFIR_EDIT" value="1">
                        </div>
                        <div class="col-2" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma"></p></div>
                        <div class="col-1" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma">انجام شد</p></div>
                        <div class="col-2" style="text-align: left">
                            <input style="font-size: 4px" class="form-control" type="checkbox" id="ANGAM_EDIT" name="ANGAM_EDIT" value="1">
                        </div>
                    </div>
                    <div class="field row mt-0">
                        <div class="col-8" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION_EDIT"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION_EDIT" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100%" title="توضیحات"></div>
                        <div class="col-4" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
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