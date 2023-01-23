<div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
    <div class="modal-dialog modal-md" style="margin-top: 25px">
      <div class="modal-content">
      <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
          <div class="row" style="width: 100%">
              <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین نام گروه جدید</p></div>
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
          <form method="post" encType="multipart/form-data" id="group_form" action="{{route('group1.store')}}">
              {{csrf_field()}}
              <div class="row">
                  <div>
                      <input type="hidden" class="form-control" id="ID_G " name="ID_G " >
                  </div>
              </div>
              <br>
              <div class="row mt-0">
                  <div class="field row" >
                      <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">کد گروه</p></div>
                      <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="GROUP_CODE"  data-toggle="tooltip" data-placement="right"  name="GROUP_CODE"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="کد گروه" placeholder="کد گروه"></div>
                  </div>
              </div>
              <br>
              <div class="field row">
                  <div class="col-2" style="text-align: right;margin-right: 67px">
                      <select class="form-control isclicked1" name="GROUP_TYPE" required id="GROUP_TYPE" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                          <option value="">انتخاب نوع گروه</option>
                          <option value="1">حقیقی</option>
                          <option value="2">مجازی</option>
                          <option value="3">ریجکت</option>
                      </select>
                  </div>

              </div>
              <div class="field row">
                  <div class="col-2" style="text-align: right;margin-right: 67px">
                      <select class="form-control isclicked1 mt-2" required name="ID_TG" id="ID_TG" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                          <option value="0">انتخاب نوع قطعات</option>
                          @foreach($ghataats as $ghataat)
                              <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <br>
              <div class="field row mt-0">
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