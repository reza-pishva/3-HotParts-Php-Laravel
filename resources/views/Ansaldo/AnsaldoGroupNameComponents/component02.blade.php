<div class="container" style="width: 100%;height:48%;margin-top: 6px">
    <div class="row">
        <div class="col-3" style="height:300px">
            <div style="width: 95%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">جستجو در گروههای تعریف شده</p>
            </div>
            <div style="width: 95%;height: 165px;margin: auto;margin-top:3px;border-radius: 3px;background-color:rgba(105,105,105,0.5)">
                <form method="post" encType="multipart/form-data" id="group_report_form" action={{route('group2.store')}}>
                    {{csrf_field()}}
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
                    <div class="row mt-4">
                        <div class="col-3" style="text-align: right"></div>
                        <div class="col-6" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >جستجو</button></div>
                        <div class="col-3" style="text-align: right"></div>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-9">
            <div class="row">
                <div class="col-10">
                    <div style="width: 100%;height: 25px;background-color: #25395c;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 2px">
                        <p style="font-family: Tahoma;font-size:smaller;color: #fdfdfe">لیست گروههای ایجاد شده</p>
                    </div>
                    <div style="width:100%;height: 265px;background-color:rgba(105,105,105,0.5);margin-right: 2px;margin-top:3px;border-radius: 3px">
                        <div style="width: 95%;height: 250px;background-color: #5a6268;margin: auto;margin-top:3px;border-radius: 3px;overflow-y: scroll;">
                            <table id="table1" align="center" style="width: 100%;font-family: Tahoma;font-size: small;direction: rtl;background-color: white;"></table>
                        </div>
                    </div>
                </div>
                <div class="col-2" style="background-color:rgba(105,105,105,0.5);border-radius: 3px;margin-top: 32px">
                    <div class="row" style="height: 25%;margin-top: -5px">
                        <div class="col" >
                            <img src="start01.png" id="add_send" class="reza2" data-toggle="tooltip" data-placement="bottom" title=" ایجاد گروه جدید">
                        </div>
                    </div>
                    <div class="row mt-2" style="height: 25%">
                        <div class="col" >
                            <a href="/bazsaz-form" ><img src="base.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="افزودن اطلاعات پایه" style="border-radius: 15px ;margin-top: 4px"></a>
                        </div>
                    </div>
                    <div class="row " style="height: 25%;margin-top: -5px">
                        <div class="col" >
                            <a hidden href="/bazsaz-form" ><img src="equip.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="تعیین لیست قطعات" style="border-radius: 15px ;margin-top: 4px"></a>
                        </div>
                    </div>
                    <div class="row " style="height: 25%;margin-top: -5px">
                        <div class="col" >
                            <a hidden href="/tapr-form" ><img src="repair2.png" class="reza2" id="add_send2" data-toggle="tooltip" data-placement="bottom" title="ایجاد برنامه تعمیراتی" style="border-radius: 15px ;margin-top: 4px"></a>
                        </div>
                    </div>
                 </div>

            </div>
        </div>
    </div>
 </div>