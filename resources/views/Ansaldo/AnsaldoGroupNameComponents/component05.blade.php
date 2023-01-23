    <!-- Edit group code -->
    <div class="modal fade" id="myModal2" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <!-- Recieve Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح گروههای تعریف شده</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Recieve Header -->
                <div class="container"  style="margin: auto;background-color:lightgray;height: 220px ">
                    <form method="post" encType="multipart/form-data" id="group_edit_form" action="{{route('group.edit')}}">
                        {{csrf_field()}}
                        <div class="row">
                            <div>
                                <input hidden class="form-control" id="ID_G_EDIT" name="ID_G_EDIT" >
                            </div>
                        </div>
                        <br>
                        <div class="row mt-0">
                            <div class="field row" >
                                <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کد گروه</p></div>
                                <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="GROUP_CODE_EDIT"  data-toggle="tooltip" data-placement="right"  name="GROUP_CODE_EDIT"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="کد گروه" placeholder="کد گروه"></div>
                            </div>
                        </div>
                        <br>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1" name="GROUP_TYPE_EDIT" required id="GROUP_TYPE_EDIT" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="">انتخاب نوع گروه</option>
                                    <option value="1">حقیقی</option>
                                    <option value="2">مجازی</option>
                                    <option value="3">ریجکت</option>
                                </select>
                            </div>

                        </div>
                        <div class="field row">
                            <div class="col-2" style="text-align: right;margin-right: 67px">
                                <select class="form-control isclicked1 mt-2" name="ID_TG_EDIT" required id="ID_TG_EDIT" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="0">انتخاب نوع قطعات</option>
                                    @foreach($ghataats as $ghataat)
                                        <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="field row mt-0">
                            {{--<div class="col-9" style="text-align: right"><input type="text" maxlength="100" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%" required title="توضیحات"></div>--}}
                            <div class="col-3" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >ثبت </button></div>
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