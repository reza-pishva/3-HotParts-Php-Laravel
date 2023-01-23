<div class="container" style="width: 100%;height:6%;border-radius: 2px">
    <div class="row">
        <div class="container" style="width: 100%;direction: rtl;background-color: #1b477a;border-radius: 5px;height: 40px">
            <div class="row">
                <div class="col-4">
                    <div style="width: 100%;height: 30px;border-radius: 3px;margin-top: 5px;padding-top: 4px;background-color: #22a390">
                        <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe;margin-top:2px;direction: ltr"> (Ansaldo) جستجو در بخش سوابق قطعات</p>
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
                <div class="col-1" style="height: 370px;width: 110%;"></div>
                <div class="col-3" style="height: 370px">
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
                <div class="col-7" style="height: 370px">
                    <div style="width:100%;height:40px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                        <div class="row" style="width: 100%;margin-right: 3px">
                            <div class="col-4"><input type="text"  class="form-control" id="serial_no_search"  data-toggle="tooltip" data-placement="right"  name="serial_no"  style="font-family: Tahoma;font-size: xx-small;width:100%"  title="شماره سریال قطعه" placeholder="شماره سریال قطعه"></div>
                            <div class="col-4" style="text-align: right"><button class="btn btn-dark" id="search_ide_btn" style="font-family: Tahoma;font-size: x-small;text-align: center;width:80%;color: #fdfdfe;height:95%" >جستجوی قطعه</button></div>
                            <div class="col-4"><label style="font-weight:bold;color:#fdfdfe;font-size:small" id="group_name">--</label></div>
                        </div>
                    </div>

                    <div style="width:100%;height:300px;background-color: white;margin: auto;border-radius: 3px;overflow-y: scroll;direction: ltr;margin-top: 5px">
                        <div id="first_spinner" style="display: none;margin-top: 65px">
                            <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                        </div>
                        <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%;" id="table2" class="table_1"></table>

                    </div>
                    <div style="width:100%;height:25px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 3px;margin-top: 10px;display:none">
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
                <div class="col-1" style="height: 370px;width: 110%;">
                </div>
            </div>
            <div class="row" style="direction: rtl">
                 <div class="col-2" style="height: 190px;text-align: right;">

                 </div>
                 <div class="col-8" style="height: 190px;border-radius: 3px;overflow-y:scroll;overflow-x:scroll;background-color: white;">
                     <div id="second_spinner" style="display: none;margin-top: 10px">
                         <img src="preloader10.gif" style="width:250px;height:150px;border-radius: 300px">
                     </div>
                    <table id="table_history" align="center" style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 170%">

                    </table>
                </div>
                <div class="col-2" style="height: 190px;border-radius: 3px;display:none">
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

</div>