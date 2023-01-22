<div class="row">
    <div class="container" style="width: 100%;direction: rtl;background-color: #1b477a;border-radius: 5px;height: 40px">
        <div class="row">
            <div class="col-4">
                <div style="width: 100%;height: 30px;border-radius: 3px;margin-top: 5px;padding-top: 4px;background-color: #22a390">
                    <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe;margin-top:2px;direction: ltr"> (Ansaldo) فرم ایجاد سابقه برای قطعات</p>
                </div>
            </div>
            <div class="col-2"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col"></div>
            <div class="col">
                <a href="/savabegh"><p style="font-family: Tahoma;font-size: x-small;margin-top:8px;color: white">بازگشت</p></a>
            </div>
        </div>

    </div>

    <div class="container" style="width: 100%;height:570px;border-radius: 3px;margin-top: 4px;padding-top: 5px">
        <div class="row" style="direction: rtl">
            <div class="col-4" style="height: 370px">
                <div class="container row" style="width: 115%">
                    <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                        <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب گروه</p>
                    </div>
                    <div style="width:100%;height:45px;background-color: #0ec9cd;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                        <button class="btn" id="btn23" style="font-family: Tahoma;font-size: small;text-align: center;width:60%;background-color: #25395c;color: #fdfdfe" >جستجو درمیان گروهها</button>
                    </div>

                    <div style="width:100%;height:270px;background-color: #5a6268;margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                        <table id="first_table" style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%">
                            <thead style="color:white;text-align: center;font-size: x-small;font-family: Tahoma">
                            <tr style="background-color: #3c525f">
                                <th style="width: 5%;font-size: 10px;font-family: Tahoma">#</th>
                                <th style="width: 15%;font-size: 10px;font-family: Tahoma">کد گروه</th>
                                <th style="width: 70%;font-size: 10px;font-family: Tahoma">نوع قطعه</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                                <tr style="color:black;text-align: center;font-size: 10px;font-family: Tahoma;height:20px" class="table1">
                                    <td><button type="button" class="btn-sm border-info select_group" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;height: 20px;padding-top:1px"><p>>></p></button></td>
                                    <td hidden>{{$request['ID_G']}}</td>
                                    <td hidden>{{$request['ID_TG']}}</td>
                                    <td>{{$request['GROUP_CODE']}}</td>
                                    <td style=";border-right:1px dotted black">{{\App\Ansaldo_type_ghataat::where('ID_TG',$request['ID_TG'])->first()->GHATAAT_NAME}}</td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-6" style="height: 370px">
                <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب قطعات</p>
                </div>

                <div hidden class="row" style="width:100%;height:25px;margin: auto;margin-top:3px;border-radius: 3px;">
                    <div class="col-3">
                        <div class="row">
                            <div class="col" style="text-align:left"><input type="checkbox" class="ghataat2"></div>
                            <div class="col"><p style="font-family: Tahoma;font-size: xx-small;display: inline;margin-right:-40px;color: #fdfdfe;margin-top:2px">انتخاب همه</p></div>
                        </div>
                    </div>
                    <div class="col-9"></div>
                </div>
                <div style="width:100%;height:220px;background-color: white;margin: auto;border-radius: 3px;overflow-y: scroll;direction: ltr;margin-top: 5px">
                    <div id="first_spinner" style="display: none;margin-top: 30px">
                        <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                    </div>
                    <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%;" id="table2" class="table_1"></table>

                </div>
                <div style="width:100%;height:25px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 3px;margin-top: 10px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">نوع برنامه انتخابی جهت ایجاد سابقه جدید</p>
                </div>
                <div id="history_type" style="width:100%;height:40px;margin: auto;border-radius: 3px;padding-top: 3px;">

                    <table id="tamirat_table_report2" align="center" class="table_2" style="width: 100%;font-family: Tahoma;font-size: small;border-radius: 5px;background-color: #fdfdfe;margin-top: 5px">
                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>
                </div>

            </div>
            <div class="col-2" style="height: 370px;width: 110%;">
                <div style="width:130%;height:45px;background-color: #117a8b;margin-top:3px;border-radius: 3px;padding-top: 5px;margin-right: -25px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب نوع برنامه جهت ایجاد سابقه جدید</p>
                </div>
                <div style="background-color:rgba(105,105,105,0.5);height:80%;margin-top:-15px;width: 120%;border-radius: 10px;margin-right: -18px">
                    <div class="row mt-4" style="width: 95%;margin-right: 5px">
                        <div class="col" style="height:85px;">
                            <div class="row" style="margin-top:-10px">
                                <div class="col">
                                    <img src="Custom-Icon-Design-Pretty-Office-5-Maintenance.ico" id="btn_tamirat" class="reza2" data-toggle="tooltip" data-placement="bottom" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" >
                                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">تعمیرات دوره ای</p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="height:85px">
                            <div class="row" style="margin-top:-10px">
                                <div class="col">
                                    <img src="parts.png" id="btn_bazsazi" class="reza2" data-toggle="tooltip" data-placement="bottom" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" >
                                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">بازسازی</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1" style="width: 95%;margin-right: 5px">
                        <div class="col" style="height:85px">
                            <div class="row" style="margin-top:-10px">
                                <div class="col" >
                                    <img src="stock_out-512.webp" id="btn_anbar" class="reza2" data-toggle="tooltip" data-placement="bottom" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" >
                                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">انبار</p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="height:85px">
                            <div class="row" style="margin-top:-10px">
                                <div class="col" >
                                    <img src="Icons-Land-Transport-Lorry.ico" id="btn_buy" class="reza2" data-toggle="tooltip" data-placement="bottom" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" >
                                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">خرید</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1" style="width: 95%;margin-right: 5px">
                        <div class="col" style="height:85px">
                            <div class="row" style="margin-top:-10px">
                                <div class="col" >
                                    <img src="302331995792832846.png" id="btn_eex" class="reza2" data-toggle="tooltip" data-placement="bottom" >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col" >
                                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">ورود و خروج از نیروگاه</p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="height:85px"></div>
                    </div>
                </div>

            </div>
        </div>
        <div class="row" style="direction: rtl">
             <div class="col-4" style="height: 190px;text-align: right;">
                    <div class="row" style="width: 70%;margin-right: 3px;margin-top: 8px">
                        <select disabled class="form-control isclicked1" name="mizan_kharabi" id="mizan_kharabi" required style="width: 80%;font-family: Tahoma;font-size: xx-small">
                            <option value="0"><p style="font-size: x-small">میزان خرابی</p></option>
                            <option value="1"><p style="font-size: x-small">سالم و تمیزکاری</p>
                            <option value="2"><p style="font-size: x-small">سبک</p></option>
                            <option value="3"><p style="font-size: x-small">متوسط</p></option>
                            <option value="4"><p style="font-size: x-small">سنگین</p></option>
                        </select>
                    </div>
                    <div class="row mt-1" style="width: 70%;;margin-right: 3px">
                        <select disabled class="form-control isclicked1" name="vaz_nasb" id="vaz_nasb" required style="width: 80%;font-family: Tahoma;font-size: xx-small">
                            <option value="0">وضعیت نصب</option>
                            <option value="1">مونتاژ</option>
                            <option value="2">دمونتاژ</option>
                            <option value="3">دمونتاژ و مونتاژ</option>
                            <option value="4">بدون تغییر</option>
                        </select>
                    </div>
                    <div class="row mt-1" style="width: 70%;margin-right: 3px">
                        <div style="text-align: center;width: 80%"> <input disabled type="number" max="10000000" min="0" class="form-control" id="karkard"  data-toggle="tooltip" data-placement="right"  name="karkard"  style="font-family: Tahoma;font-size: xx-small;" required title="ساعت کارکرد" placeholder="ساعت کارکرد"></div>
                    </div>
                    <div class="row mt-1" style="width:100%;margin-right: 3px">
                        <div style="text-align: center;width: 100%"> <textarea disabled maxlength="200" class="form-control" id="description"  data-toggle="tooltip" data-placement="right"  name="description"  style="font-family: Tahoma;font-size: xx-small;height: 40px" required title="توضیحات" placeholder="توضیحات" rows="2" cols="20" wrap="hard"></textarea></div>
                    <div class="row" style="width:100%;margin-right: 3px">
                        <button disabled class="btn btn-info mt-2" id="insert_historty" style="font-family: Tahoma;font-size: small;text-align: center;width:100%;color: #fdfdfe" >ثبت</button>
                    </div>
            </div>
             </div>
             <div class="col-7" style="height: 190px;border-radius: 3px;overflow-y:scroll;overflow-x:scroll;background-color: white;">
                 <div id="second_spinner" style="display: none;margin-top: 10px">
                     <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                 </div>
                <table id="table_history" align="center" style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 170%">
                    {{--<tr class="bg-primary" style="color: white;font-size:x-small;">--}}
                        {{--<td>کد</td>--}}
                        {{--<td>کارکرد</td>--}}
                        {{--<td>میزان خرابی</td>--}}
                        {{--<td>وضعیت نصب</td>--}}
                        {{--<td>نوع عملیات</td>--}}
                        {{--<td>تاریخ شروع</td>--}}
                        {{--<td>تاریخ پایان</td>--}}
                        {{--<td>پیمانکار/تعمیرکار</td>--}}
                        {{--<td>مکان قطعه</td>--}}
                        {{--<td>توضیحات</td>--}}
                    {{--</tr>--}}
                </table>
            </div>
            <div class="col-1" style="height: 190px;border-radius: 3px">
                <div class="row" style="margin-top:-10px">
                    <div class="col">
                        <img style="display: none" src="edit.png" id="update_historty" class="reza2" data-toggle="tooltip" data-placement="bottom" title="ایجاد تغییرات در سوابق">
                    </div>
                </div>
                <div class="row" style="margin-top:-10px">
                    <div class="col">
                        <img style="display: none" src="Oxygen-Icons.org-Oxygen-Actions-document-close.ico" id="delete_historty" class="reza2" data-toggle="tooltip" data-placement="bottom" title="حالتهای مختلف حذف سابقه">
                    </div>
                </div>
            </div>
    </div>
</div>
</div>
