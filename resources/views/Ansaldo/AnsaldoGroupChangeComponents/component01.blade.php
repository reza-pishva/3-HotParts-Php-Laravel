<div class="container bg-dark" style="width: 100%;height:6%;">
    <div class="row">
        <div class="col">
            <ul class="navbar-nav" >
                <li class="nav-item">
                    <a class="nav-link" href="/savabegh"><p style="font-family: Tahoma;font-size: x-small">بازگشت</p></a>
                </li>
            </ul>
        </div>
        <div class="col-2"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col"></div>
        <div class="col-4">
            <div style="width: 100%;height: 65%;border-radius: 3px;margin-top: 4px;padding-top: 5px;background-color: #2F4F4F">
                <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe"> (Ansaldo)  جابجایی قطعات بین گروههای تعریف شده </p>
            </div>
        </div>
    </div>
    <div class="row" style="direction: rtl">
        <div class="col-3" style="height: 550px">
            <div class="row">
                <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب گروه اول</p>
                </div>
                <div style="width:100%;height:45px;background-color: #0ec9cd;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <button class="btn" id="btn23" style="font-family: Tahoma;font-size: small;text-align: center;width:60%;background-color: #25395c;color: #fdfdfe" >جستجودرمیان گروهها</button>
                </div>
                <div style="width:100%;height: 250px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                    <table id="first_table" style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%">
                        <thead style="color:white;text-align: center;font-size: x-small;font-family: Tahoma">
                        <tr style="background-color: rgb(61,64,73)">
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
                                <td>{{\App\Ansaldo_type_ghataat::where('ID_TG',$request['ID_TG'])->first()->GHATAAT_NAME}}</td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mt-2">
                <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">سابقه گروه انتخابی</p>
                </div>
                <div style="background-color:rgb(61,64,73);border-radius: 5px;width: 100%;margin-top: 5px;width: 100%;height: 155px">
                    ..
                </div>
            </div>
        </div>
        <div class="col-2" style="height: 550px">
            <div class="row">
                <div style="width:95%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">قطعات گروه اول</p>
                </div>
                <div style="width:90%;height: 500px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                    <div id="first_spinner" style="display: none;margin-top: 160px">
                        <img src="loading-18.gif" style="width:150px;height:120px;border-radius: 300px">
                    </div>
                    <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%" id="table2"></table>
                </div>
            </div>
        </div>
        <div class="col-2" style="height: 550px">
            <div class="row" style="height: 200px;width:100%;margin: auto;margin-top: 60px;background-color:rgba(38,104,136,0.5);border-radius: 5px">
                    <div class="col-12">
                        <button disabled class="btn btn-success mt-3" id="btn12" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >انتقال قطعات انتخابی از گروه اول به دوم</button>
                    </div>
                    <div class="col-12">
                        <button disabled class="btn btn-info" id="btn21" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >انتقال قطعات انتخابی از گروه دوم به اول</button>
                    </div>
            </div>
        </div>
        <div class="col-2" style="height: 550px">
            <div class="row">
                <div style="width:95%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">قطعات گروه دوم</p>
                </div>
                <div style="width:90%;height: 500px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                    <div id="second_spinner" style="display: none;margin-top: 160px">
                        <img src="loading-18.gif" style="width:150px;height:120px;border-radius: 300px">
                    </div>
                    <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%" id="table4"></table>
                </div>
            </div>
        </div>
        <div class="col-3" style="height: 550px">
            <div class="row">
                <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب گروه دوم</p>
                </div>
                <div style="width:100%;height: 250px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                    <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%" id="table3"></table>
                </div>
            </div>
            <div class="row mt-2">
                <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                    <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">سابقه گروه انتخابی</p>
                </div>
                <div style="background-color:rgb(61,64,73);border-radius: 5px;width: 100%;margin-top: 5px;width: 100%;height: 200px">
                    ..
                </div>
            </div>
        </div>
    </div>
</div>