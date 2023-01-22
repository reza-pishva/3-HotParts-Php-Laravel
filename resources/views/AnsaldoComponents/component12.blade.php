<div class="modal fade" id="myModal8" style="direction: rtl;margin-top: 100px">
    <div class="modal-dialog modal-md" style="margin-top: 25px">
        <div class="modal-content">
            <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F;width: 140%;margin-right: -70px" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">تعیین نحوه ثبت سابقه</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10"></div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white;">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container"  style="background-color:white;height: 350px;width: 140%;margin-right: -70px ">

                <div style="width:100%;height:220px;background-color: #5a6268;margin: auto;border-radius: 3px;overflow-y: scroll;direction: ltr;margin-top: 5px">
                    <div id="third_spinner" style="display: none;margin-top: 30px">
                        <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                    </div>
                    <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%;" id="table_view" class="table_1"></table>
                </div>
                    <div class="row mt-2"  style="text-align: center">
                        <div class="col">
                            <select class="form-control isclicked1" name="INSERT_TYPE" id="INSERT_TYPE" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                <option value="0">انتخاب نحوه ثبت سابقه</option>
                                <option value="1">فقط برای قطعه انتخابی</option>
                                <option value="2">برای کلیه قطعات این گروه</option>
                                <option value="3">بر اساس شماره ردیف</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-3"></div>
                        <div class="col-7">
                            <div style="display:none;" class="row" id="INSERT_TYPE_DIV">
                                <div class="col-4"><p style="font-family: Tahoma;font-size:x-small;margin-top: 2px">از شماره ردیف</p></div>
                                <div class="col-3" style="text-align: left"><input type="text" maxlength="20" class="form-control" id="radif_insert1"  data-toggle="tooltip" data-placement="right"  name="radif_insert1"  style="font-family: Tahoma;font-size: xx-small;width: 100%" required title="از شماره ردیف" ></div>
                                <div class="col-2"><p style="font-family: Tahoma;font-size:x-small;margin-top: 2px">تا</p></div>
                                <div class="col-3" style="text-align: right"><input type="text" maxlength="20" class="form-control" id="radif_insert2"  data-toggle="tooltip" data-placement="right"  name="radif_insert2"  style="font-family: Tahoma;font-size: xx-small;width: 100%" required title="تا شماره ردیف" ></div>
                            </div>
                        </div>
                        <div class="col-2"></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3" style="text-align: right"></div>
                        <div class="col-6" style="text-align: right"><button type="submit" class="btn btn-primary" id="final_insert" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت</button></div>
                        <div class="col-3" style="text-align: right"></div>
                    </div>

                <div id="ajax-alert4" class="toast-container toast-position-top-left" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width: 140%;margin-right: -70px">

            </div>

        </div>
    </div>
</div>