<div class="modal fade mt-3" id="myModal13" style="direction: rtl;">
    <div class="modal-dialog modal-md" style="margin-top: 200px">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام واحد نیروگاه</p></div>
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
                <form method="post" encType="multipart/form-data" id="un_edit" action="{{route('un.edit')}}">
                    {{csrf_field()}}
                    <div class="row mt-1">
                        <div class="col-4">
                            <select class="form-control isclicked1" name="ID_NN_EDIT" id="ID_NN_EDIT" style="width: 200px;font-family: Tahoma;font-size:x-small;display: inline">
                                @foreach($pps as $pp)
                                    <option value="{{$pp->ID_NN}}">{{$pp->NIROGAH_NAME}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-2">
                                <input type="hidden" class="form-control" id="ID_UN_EDIT" name="ID_UN_EDIT" >
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4">
                            <input type="text" maxlength="30" class="form-control" id="UNIT_NUMBER_EDIT"  data-toggle="tooltip" data-placement="right" title="نام واحد" placeholder="نام واحد" name="UNIT_NUMBER_EDIT" required style="font-family: Tahoma;font-size: x-small;width:100%">
                        </div>
                        <div class="col-4">
                            <input type="number" max="100" class="form-control" id="unitNumberDigit_EDIT"  data-toggle="tooltip" data-placement="right" title="شماره واحد" placeholder="شماره واحد" name="unitNumberDigit_EDIT" required style="font-family: Tahoma;font-size: x-small;width:100%">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate66" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
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

<div class="row addsaz" id="saz" style="display: none">
    <div class="col-1"></div>
    <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;"><p class="onvan">بخش تعیین نام شرکتهای سازنده</p></div>
    <div class="col-3"></div>
</div>