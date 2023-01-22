<div class="row addseller" style="display: none">
    <div class="col-1  mt-3">.</div>
    <div class="col-8  mt-3">
        <form method="post" encType="multipart/form-data" id="seller_form" action={{route('seller.store')}}>
            {{csrf_field()}}
            <div class="row">
                <div>
                    <input type="hidden" class="form-control" id="ID_SE" name="ID_SE" >
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-8">
                    <input type="text" maxlength="40" class="form-control" id="SELLER" data-toggle="tooltip" data-placement="right" title="نام شرکت فروشنده" placeholder="نام شرکت فروشنده" name="SELLER" required style="font-family: Tahoma;font-size: small;width:100%">
                </div>
                <div class="col-4" style="text-align: right">
                    <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                        <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                            <table id="seller_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                <tr class="bg-primary" style="color: white;font-size:x-small;">
                                    <td>کد</td>
                                    <td>نام شرکت فروشنده</td>
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