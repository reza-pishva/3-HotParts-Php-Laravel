<div class="modal fade mt-3" id="myModal12" style="direction: rtl;">
    <div class="modal-dialog modal-md" style="margin-top: 200px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام نیروگاه</p></div>
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
                <form method="post" encType="multipart/form-data" id="nir_edit" action="{{route('nir.edit')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="ID_NN_EDIT" name="ID_NN_EDIT" >
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" maxlength="30" class="form-control" id="NIROGAH_NAME_EDIT"  placeholder="نام نیروگاه" name="NIROGAH_NAME_EDIT" required style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
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

<div class="row addunit" id="unit" style="display: none">
    <div class="col-1"></div>
    <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام واحدهای نیروگاه</p></div>
    <div class="col-3"></div>
</div>