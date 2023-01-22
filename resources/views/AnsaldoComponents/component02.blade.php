<div class="modal fade" id="myModal5" style="direction: rtl;margin-top: 70px">
    <div class="modal-dialog modal-md" style="margin-top: 25px">
    <div class="modal-content">
        <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
            <div class="row" style="width: 100%">
                <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جستجو در میان گروهها</p></div>
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
        <div class="container"  style="margin: auto;background-color:lightgray;height: 220px ">
            <form method="post" encType="multipart/form-data" id="group_report_form" action={{route('group2.store')}}>
                {{csrf_field()}}
                <br>
                <div class="row" style="text-align: center">

                    <div class="col">
                        <select class="form-control isclicked1 mt-2" name="ID_TG_R" id="ID_TG_R" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                            <option value="0">انتخاب نوع قطعات</option>
                            @foreach($ghataats as $ghataat)
                                <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mt-2"  style="text-align: center">
                    <div class="col">
                        <select class="form-control isclicked1" name="GROUP_TYPE_R" id="GROUP_TYPE_R" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                            <option value="0">انتخاب نوع گروه</option>
                            <option value="1">حقیقی</option>
                            <option value="2">مجازی</option>
                            <option value="3">ریجکت</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2"  style="text-align: center">
                    {{-- <div class="col">
                       <input type="text" placeholder="کد قطعه" id="EQ_CODE_R" name="EQ_CODE_R" style="font-family:Tahoma;font-size: small"/>
                    </div> --}}
                </div>
                <div class="row mt-4">
                    <div class="col-3" style="text-align: right"></div>
                    <div class="col-6" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >جستجو</button></div>
                    <div class="col-3" style="text-align: right"></div>
                </div>
            </form>
            <div id="ajax-alert4" class="toast-container toast-position-top-left" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer bg-info" style="height: 20px">

        </div>

    </div>
</div>
    </div>
