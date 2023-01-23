<div class="modal fade" id="myModal1" style="direction: rtl;margin-top: 70px">
    <div class="modal-dialog modal-md" style="margin-top: 25px">
      <div class="modal-content">
      <!-- Send Header -->
      <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
          <div class="row" style="width: 100%">
              <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ایجاد برنامه خرید قطعات</p></div>
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

      <!-- Send form -->
      <div class="container"  style="margin: auto;background-color:lightgray;height: 300px ">
          <form method="post" encType="multipart/form-data" id="buy_form" action="{{route('buy.store')}}">
              {{csrf_field()}}
              <div class="row">
                  <div>
                      <input type="hidden" class="form-control" id="ID_T" name="ID_T" >
                  </div>
              </div>
              <div class="row mt-4">
                  <div class="col-3 ">
                      <select class="form-control isclicked1" name="ID_TG" id="ID_TG" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                          <option value="">انتخاب نوع قطعات</option>
                          @foreach($ghataats as $ghataat)
                              <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                          @endforeach
                      </select>
                  </div>
                  <div class="col-3" style="margin-right: 100px">
                      <select class="form-control isclicked1" name="ID_SE" id="ID_SE" required style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                          <option value="">فروشنده</option>
                          @foreach($sellers as $seller)
                              <option value="{{$seller->ID_SE }}">{{$seller->SELLER}}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <br>
              <div class="row mt-0">
                  <div class="field row" >
                      <div class="col-5" style="text-align: center"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تاریخ خرید</p></div>
                      <div class="col-7" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="DATE_SHAMSI"  data-toggle="tooltip" data-placement="right"  name="DATE_SHAMSI"  style="font-family: Tahoma;font-size: small;width: 100%;" required title="تاریخ ارسال یا دریافت"></div>
                  </div>
              </div>
              <br>
              <div class="field row">
                  <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">تعداد قطعات</p></div>
                  <div class="col-4" style="text-align: center"> <input type="number" max="100000" min="0" class="form-control" id="GROUP_COUNT"  data-toggle="tooltip" data-placement="right"  name="GROUP_COUNT" placeholder="تعداد قطعات" style="font-family: Tahoma;font-size: smaller;width: 80%;" required title="تعداد قطعات"></div>
                  <div class="col-2" style="text-align: right"><p style="text-align: left;font-size: xx-small;font-family: Tahoma">شماره قرارداد</p></div>
                  <div class="col-4" style="text-align: center"> <input type="text" maxlength="10" class="form-control" id="SHOMAREH_GHARAR"  data-toggle="tooltip" data-placement="right"  name="SHOMAREH_GHARAR" placeholder="شماره قرارداد" style="font-family: Tahoma;font-size: smaller;width: 80%;"  title="شماره قرارداد"></div>
              </div>
              <div class="row mt-2">
                  <div class="col-4">
                      <select class="form-control isclicked1" name="RESV" id="RESV" required style="width: 180px;font-family: Tahoma;font-size: small;display: inline">
                          <option value="">وضعیت دریافت</option>
                          <option value="1">دریافت شده</option>
                          <option value="2">دریافت نشده</option>
                      </select>
                  </div>
              </div>
              <br>
              <div class="field row mt-0">
                  <div class="col-9" style="text-align: right"><input type="text" maxlength="150" class="form-control" id="DISCRIPTION"  data-toggle="tooltip" data-placement="right"  name="DISCRIPTION" placeholder="توضیحات" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 100%"  title="توضیحات"></div>
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