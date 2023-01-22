<div class="row addtypgha" style="display: none">
    <div class="col-1  mt-3">.</div>
    <div class="col-8  mt-3">
        <form method="post" encType="multipart/form-data" id="typgha_form" action={{route('typgha.store')}}>
            {{csrf_field()}}
            <div class="row">
                <div>
                    <input type="hidden" class="form-control" id="ID_TG" name="ID_TG" >
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-8">
                    <input type="text" maxlength="40" class="form-control" id="GHATAAT_NAME"  data-toggle="tooltip" data-placement="right" placeholder="نام قطعه" name="GHATAAT_NAME" title="نام قطعه" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
                <div class="col-4">
                    <input type="number" max="999999" class="form-control" id="TIME_STANDARD"  data-toggle="tooltip" data-placement="left" placeholder="ساعت استاندارد" name="TIME_STANDARD" title="ساعت استاندارد" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-4">
                    <input type="text" maxlength="2" class="form-control" id="TYPE_CODE"  data-toggle="tooltip" data-placement="right" placeholder="کد نوع قطعه" title="کد نوع قطعه" name="TYPE_CODE" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
                <div class="col-4">
                    <input type="number" max="999999" class="form-control" id="SET_COUNT"  data-toggle="tooltip" data-placement="bottom" placeholder="تعداد مجاز بازسازی" title="تعداد مجاز بازسازی" name="SET_COUNT" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
                <div class="col-4">
                    <input type="number" max="999999" class="form-control" id="COUNTB_REJECT" data-toggle="tooltip" data-placement="left" placeholder="تعداد منجر به ریجکت" title="تعداد منجر به ریجکت" name="COUNTB_REJECT" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
            </div>

            <div class="row mt-1">
                <div class="col-4">
                    <input type="number" max="999999" class="form-control" id="TIME_REJECT"  data-toggle="tooltip" data-placement="right" placeholder="ساعت ریجکت" title="ساعت ریجکت" name="TIME_REJECT" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
                <div class="col-4" style="text-align: right">
                    <button type="submit" class="btn btn-primary" id="btnupdate44" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                        <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                            <table id="typgha_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                <tr class="bg-primary" style="color: white;font-size:x-small;">
                                    <td>کد</td>
                                    <td>نام قطعه</td>
                                    <td>کد قطعه</td>
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
<div class="row usergroup5" style="display: none">
    <div class="col-2"></div>
    <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش اصلاح نوع قطعه</p></div>
    <div class="col-2"></div>
</div>