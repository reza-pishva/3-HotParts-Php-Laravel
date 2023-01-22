<div class="modal fade" id="myModal13" style="direction: rtl;margin-top: 80px">
    <div class="modal-dialog modal-md" style="margin-top: 25px">
        <div class="modal-content">
            <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">حذف سوابق</p></div>
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
            <div class="container"  style="margin: auto;background-color:lightgray;height: 120px ">
                <div id="forth_spinner" style="display: none;margin-top: 30px">
                    <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                </div>
                <div id="edit_div">
                    <div class="row">
                        <div class="col bg-info" style="height: 20px;margin-top: 5px">
                            <p style="font-family: Tahoma;font-size: x-small;margin-top:2px;color: #fdfdfe">انتخاب نوع حذف</p>
                        </div>
                    </div>
                <div class="row" style="width:100%;margin-right: 3px">
                    <div class="col" style="margin-top: 10px">
                        <select class="form-control isclicked1" name="DELETE_TYPE" id="DELETE_TYPE" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                        <option value="0">انتخاب نحوه حذف سابقه</option>
                        <option value="1">فقط برای قطعه انتخابی</option>
                        <option value="2">برای کلیه قطعات این گروه</option>
                        <option value="3">بر اساس شماره ردیف</option>
                        </select>
                    </div>
                    <div class="col" style="margin-top: 2px">

                    </div>
                    <div class="col"><button  class="btn btn-primary mt-2" id="final_delete" style="font-family: Tahoma;font-size: small;text-align: center;width:100%;color: #fdfdfe" >حذف</button></div>

                </div>
                <div class="row mt-2">
                    <div class="col-7">
                        <div style="display:none;" class="row" id="DELETE_TYPE_DIV">
                            <div class="col-4"><p style="font-family: Tahoma;font-size:x-small;margin-top: 2px">از شماره ردیف</p></div>
                            <div class="col-3" style="text-align: left"><input type="text" maxlength="20" class="form-control" id="radif_update3"  data-toggle="tooltip" data-placement="right"  name="radif_update3"  style="font-family: Tahoma;font-size: xx-small;width: 100%" required title="از شماره ردیف" ></div>
                            <div class="col-2"><p style="font-family: Tahoma;font-size:x-small;margin-top: 2px">تا</p></div>
                            <div class="col-3" style="text-align: right"><input type="text" maxlength="20" class="form-control" id="radif_update4"  data-toggle="tooltip" data-placement="right"  name="radif_update4"  style="font-family: Tahoma;font-size: xx-small;width: 100%" required title="تا شماره ردیف" ></div>
                        </div>
                    </div>
                    <div class="col-5"></div>
                </div>
            </div>

            <!-- Modal footer -->
            <!-- <div class="modal-footer bg-info" style="height: 20px">

            </div> -->

        </div>
    </div>
</div>
</div>