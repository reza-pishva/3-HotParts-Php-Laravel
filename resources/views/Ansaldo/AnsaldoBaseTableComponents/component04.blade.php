<div class="modal fade mt-3" id="myModal6" style="direction: rtl;">
    <div class="modal-dialog modal-md" style="margin-top: 200px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام شرکت بازسازی کننده</p></div>
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
            <div class="container"  style="margin: auto;background-color:lightgray ">
                <form method="post" encType="multipart/form-data" id="bazsaz_edit" action="{{route('bazsaz.edit')}}">
                    {{csrf_field()}}
                    <input type="hidden" class="form-control" id="ID_BA_EDIT"  name="ID_BA_EDIT">
                    <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                        <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام شرکت بازسازی کننده:</p></div>
                    </div>
                    <div class="row" style="margin-top: 10px">
                        <div class="col-12">
                            <div class="form-group" style="height: 15px">
                                <input type="text" maxlength="40" class="form-control" id="BAZSAZ_EDIT" required name="BAZSAZ_EDIT" style="direction:rtl;font-family:Tahoma;font-size:small" >
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                        </div>
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