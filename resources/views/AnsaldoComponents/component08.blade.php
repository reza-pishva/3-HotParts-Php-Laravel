        <div class="modal fade" id="myModal11" style="direction: rtl;">
                <div class="modal-dialog modal-lg" style="margin-top: 20px;">
                    <div class="modal-content" style="background-color: #b9bbbe">
                        <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                            <div class="row" style="width: 100%">
                                <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جستجو در میان برنامه های خرید</p></div>
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
                        <div class="row tarep " style="width: 100%;margin-left: -150px;direction: rtl;height: 340px;">
                            {{--<div class="col-1  mt-3"></div>--}}
                            <div class="col-12  mt-1" style="height: 445px;margin-right: 10px">
                                <form method="post" encType="multipart/form-data" id="tp_buy_rep_form" action={{route('buy.store')}}>
                                    {{csrf_field()}}
                                    <div hidden class="row">
                                        <div class="col-3 mt-2">
                                            <select class="form-control isclicked1" name="ID_NN_REP" id="ID_NN_REP" style="width: 100%;font-family: Tahoma;font-size:small;display: inline">
                                                @foreach($anns as $ann)
                                                    <option value="{{$ann->ID_NN}}">{{$ann->NIROGAH_NAME}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-3">
                                            <select class="form-control" name="ID_TG_R" id="ID_TG_R" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                                <option value="0">انتخاب نوع قطعات</option>
                                                @foreach($ghataats as $ghataat)
                                                    <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control" name="ID_SE_R" id="ID_SE_R" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                                <option value="">فروشنده</option>
                                                @foreach($sellers as $seller)
                                                    <option value="{{$seller->ID_SE }}">{{$seller->SELLER}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-3" style="text-align: left">
                                            <select class="form-control isclicked1" name="RESV_R" id="RESV_R" style="width: 180px;font-family: Tahoma;font-size: small;display: inline">
                                                <option value="">وضعیت دریافت</option>
                                                <option value="1">دریافت شده</option>
                                                <option value="2">دریافت نشده</option>
                                            </select>
                                        </div>
                                        <div class="col-2" style="text-align: right">
                                            <button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:80%" >جستجو </button>
                                        </div>
                                        {{--<div class="field row" >--}}
                                            {{--<div class="col-3" style="text-align: center"><p style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px">تاریخ شروع جستجو</p></div>--}}
                                            {{--<div class="col-3" style="text-align: center"> <input type="text" maxlength="20" class="form-control" id="DATE_BEGIN_BUY_REP"  data-toggle="tooltip" data-placement="right"  name="DATE_BEGINR"  style="font-family: Tahoma;font-size: small;width: 80%;" required title="تاریخ شروع تعمیرات"></div>--}}
                                            {{--<div class="col-3" style="text-align: center"><label for="date_shamsi2" style="font-family: Tahoma;font-size: smaller;display: inline;color: #fdfdfe;margin-right: 30px"> تاریخ پایان جستجو:</label></div>--}}
                                            {{--<div class="col-3" style="text-align: center"><input type="text" maxlength="20" class="form-control" id="DATE_END_BUY_REP"  data-toggle="tooltip" data-placement="right"  name="DATE_ENDR" style="direction: rtl;font-family: Tahoma;font-size: small;width: 80%" required title="تاریخ پایان تعمیرات"></div>--}}
                                        {{--</div>--}}
                                    </div>
                                    {{--<br>--}}
                                    {{--<div class="field row">--}}
                                        {{--<div class="col-2" style="text-align: center"><p style="text-align: left;font-size:12px;font-family: Tahoma;color: #fdfdfe">وضعیت انجام تعمیرات</p></div>--}}

                                        {{--<div class="col-2" style="text-align: center"></div>--}}
                                        {{--<div class="col-3" style="text-align: left"></div>--}}


                                    {{--</div>--}}


                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row mylist" style="margin: auto;width:100%;height:202px;direction: rtl;margin-top: 12px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                                <div class="col-12" style="direction: rtl;height: 200px;overflow-y: scroll">
                                                    <table id="buy_table_report" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                                            <td>کد</td>
                                                            <td>نام شرکت</td>
                                                            <td>#</td>
                                                            <td>#</td>
                                                        </tr>
                                                    </table>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </form>
                                {{--<div  style="text-align: center;margin-top: 15px">--}}
                                <button class="btn btn-primary" id="confirm4" style="font-family: Tahoma;font-size: small;text-align: center;width:30%;margin-top: 25px" >تایید مورد انتخاب شده</button>
                                {{--</div>--}}
                            </div>

                        </div>

                        <!-- Modal footer -->
                        {{--<div class="modal-footer bg-info" style="height: 20px">--}}

                    </div>

                </div>
            </div>
        </div>
