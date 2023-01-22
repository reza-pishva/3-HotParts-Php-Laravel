        <div class="modal fade" id="myModal7" style="direction: rtl;margin-top: 20px">
                <div class="modal-dialog modal-md" style="margin-top: 25px">
                    <div class="modal-content">
                        <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                            <div class="row" style="width: 100%">
                                <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم ایجاد تغییرات در سوابق</p></div>
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
                        <div class="container"  style="margin: auto;background-color:lightgray;height: 460px ">
                            <div id="forth_spinner" style="display: none;margin-top: 30px">
                                <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                            </div>
                            <div id="edit_div">
                                <div class="row">
                                    <div class="col bg-info" style="height: 20px;margin-top: 5px">
                                        <p style="font-family: Tahoma;font-size: x-small;margin-top:2px;color: #fdfdfe">تغییرات در جزئیات سابقه</p>
                                    </div>
                                </div>
                                <div class="row" style="width: 70%;margin-right: 3px;margin-top: 8px">
                                    <select class="form-control isclicked1" name="mizan_kharabi" id="mizan_kharabi_edit" required style="width: 50%;font-family: Tahoma;font-size: xx-small">
                                        <option value="0"><p style="font-size: x-small">میزان خرابی</p></option>
                                        <option value="1"><p style="font-size: x-small">سالم و تمیزکاری</p>
                                        <option value="2"><p style="font-size: x-small">سبک</p></option>
                                        <option value="3"><p style="font-size: x-small">متوسط</p></option>
                                        <option value="4"><p style="font-size: x-small">سنگین</p></option>
                                    </select>
                                </div>
                                <div class="row mt-1" style="width: 70%;;margin-right: 3px">
                                    <select class="form-control isclicked1" name="vaz_nasb" id="vaz_nasb_edit" required style="width: 50%;font-family: Tahoma;font-size: xx-small">
                                        <option value="0">وضعیت نصب</option>
                                        <option value="1">مونتاژ</option>
                                        <option value="2">دمونتاژ</option>
                                        <option value="3">دمونتاژ و مونتاژ</option>
                                        <option value="4">بدون تغییر</option>
                                    </select>
                                </div>
                                <div class="row mt-1" style="width: 70%;margin-right: 3px">
                                    <div style="text-align: center;width: 80%"> <input type="text" maxlength="20" class="form-control" id="karkard_edit"  data-toggle="tooltip" data-placement="right"  name="karkard"  style="font-family: Tahoma;font-size: xx-small;width: 50%" required title="ساعت کارکرد" placeholder="ساعت کارکرد"></div>
                                </div>
                                <div class="row mt-1" style="width:100%;margin-right: 3px">
                                    <div style="text-align: center;width: 100%"> <textarea maxlength="200" class="form-control" id="description_edit"  data-toggle="tooltip" data-placement="right"  name="description"  style="font-family: Tahoma;font-size: xx-small;height: 40px;width: 100%" required title="توضیحات" placeholder="توضیحات" rows="2" cols="20" wrap="hard"></textarea></div>

                                </div>
                                <div class="row" style="margin-top: 15px">
                            </div>
                                <div class="col bg-info" style="height: 20px">
                                    <p style="font-family: Tahoma;font-size: x-small;margin-top:2px;color: #fdfdfe">تغییر برنامه تعریف شده</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" style="margin-top: 15px">
                                    <div class="row" style="margin-top:-10px">
                                        <div class="col">
                                            <img src="perrep.jpg" id="btn_tamirat2" class="reza3" data-toggle="tooltip" data-placement="bottom" title="تعمیرات دوره ای">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" >
                                            <p style="color: black;font-family: Tahoma;font-size:x-small">تعمیرات دوره ای</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" style="margin-top: 15px">
                                    <div class="row" style="margin-top:-10px">
                                        <div class="col">
                                            <img src="parts.png" id="btn_bazsazi2" class="reza3" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه بازسازی قطعه">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" >
                                            <p style="color: black;font-family: Tahoma;font-size:x-small">بازسازی</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" style="margin-top: 15px">
                                    <div class="row" style="margin-top:-10px">
                                        <div class="col" >
                                            <img src="4735794.png" id="btn_anbar2" class="reza3" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه ورود و خروج انبار">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" >
                                            <p style="color: black;font-family: Tahoma;font-size:x-small">انبار</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" style="margin-top: 15px">
                                    <div class="row" style="margin-top:-10px">
                                        <div class="col" >
                                            <img src="ico-yellow-brand-vehicle-tracking-system-cdr.jpg" id="btn_buy2" class="reza3" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه ارسال قطعه">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" >
                                            <p style="color: black;font-family: Tahoma;font-size:x-small">خرید</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col" style="margin-top: 15px">
                                    <div class="row" style="margin-top:-10px">
                                        <div class="col" >
                                            <img src="97-970395_truck-clipart-green-truck-green-dump-truck-clip-art.png" id="btn_eex2" class="reza3" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه ارسال قطعه">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col" >
                                            <p style="color: black;font-family: Tahoma;font-size:x-small">ورود و خروج از نیروگاه</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col bg-info" style="height: 2px"></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                {{--<div class="col"></div>--}}
                                <div class="col">
                                    <input disabled type="text" maxlength="20" class="form-control" id="id_t1_edit"  data-toggle="tooltip" data-placement="right"  name="id_t1_edit"  style="font-family: Tahoma;font-size: xx-small;width: 50%" required title="کد برنامه" placeholder="کد برنامه">
                                </div>
                                <div class="col">
                                    <input disabled type="text" maxlength="20" class="form-control" id="barnameh_edit"  data-toggle="tooltip" data-placement="right"  name="barnameh_edit"  style="font-family: Tahoma;font-size: xx-small;" required title="عنوان برنامه" placeholder="عنوان برنامه">
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col bg-info" style="height: 2px"></div>
                            </div>
                            <div class="row" style="width:100%;margin-right: 3px">
                                <div class="col" style="margin-top: 10px">
                                    <select class="form-control isclicked1" name="UPDATE_TYPE" id="UPDATE_TYPE" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="0">انتخاب نحوه اصلاح سابقه</option>
                                    <option value="1">فقط برای قطعه انتخابی</option>
                                    <option value="2">برای کلیه قطعات این گروه</option>
                                    <option value="3">بر اساس شماره ردیف</option>
                                    </select>
                                </div>
                                <div class="col" style="margin-top: 2px">

                                </div>
                                <div class="col"><button  class="btn btn-primary mt-2" id="final_edit" style="font-family: Tahoma;font-size: small;text-align: center;width:100%;color: #fdfdfe" >ثبت</button></div>

                            </div>
                            <div class="row mt-2">
                                <div class="col-7">
                                    <div style="display:none;" class="row" id="UPDATE_TYPE_DIV">
                                        <div class="col-4"><p style="font-family: Tahoma;font-size:x-small;margin-top: 2px">از شماره ردیف</p></div>
                                        <div class="col-3" style="text-align: left"><input type="text" maxlength="20" class="form-control" id="radif_update1"  data-toggle="tooltip" data-placement="right"  name="radif_update1"  style="font-family: Tahoma;font-size: xx-small;width: 100%" required title="از شماره ردیف" ></div>
                                        <div class="col-2"><p style="font-family: Tahoma;font-size:x-small;margin-top: 2px">تا</p></div>
                                        <div class="col-3" style="text-align: right"><input type="text" maxlength="20" class="form-control" id="radif_update2"  data-toggle="tooltip" data-placement="right"  name="radif_update2"  style="font-family: Tahoma;font-size: xx-small;width: 100%" required title="تا شماره ردیف" ></div>
                                    </div>
                                </div>
                                <div class="col-5"></div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer bg-info" style="height: 20px">

                        </div>

                    </div>
                </div>
            </div>
