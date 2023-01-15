@extends('layouts.app_guard_print')
@section('content')


    <div class="row">
        <div class="col-2"></div>
        <div class="col-8" style="text-align: center">
                 <p style="font-family: '2  Homa';font-size: xx-large;color: #2F96B4">گزارش کارکرد پرسنل روزمزد</p>
        </div>
        <div class="col-2">
        
        </div>
    </div>
    <div class="row" style="text-align: center">
        <div class="col-2" >
            <a href="#" class="btnprn3 btn" onclick="window.print()">
                <p><img src="{{URL::to('/')}}/printer.png" style="width: 30px;height: 30px"></p>
            </a>
        </div>
        <div class="col-8">
            <div class="row" style="height: 20px">
                <div class="col-8"></div>
                <div class="col-2">               </div>
                <div class="col-2">

                </div>
            </div>

        </div>
        <div class="col-2"><a href="http://172.28.232.27:8080/report-table05">
            <img src="{{URL::to('/')}}/exit003.png" style="width: 30px;height: 30px;margin-top: 25px" data-toggle="tooltip" data-placement="bottom" title="بازگشت به صفحه قبل">
        </a></div>

    </div>
    <div class="row">
        <div class="col-1">
        </div>
        <div class="col-8">
            <div id="cars_div" class="col" >
                <table class="table table-bordered table-sm" style="font-size: small;text-align: right;direction: rtl">
                    <thead class="table table-bordered table-sm bg-dark " style="color:white;text-align: center">
                    <tr>
                        <th style="color:white;width: 15%;text-align: center">نام</th>
                        <th style="color:white;width: 20%;text-align: center">نام خانوادگی</th>
                        <th style="color:white;width: 20%;text-align: center">کد ملی</th>
                        {{-- <th style="color:white;width: 20%;text-align: center">تاریخ</th> --}}
                        <th style="color:white;width: 25%;text-align: center">کارکرد</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr style="color:black;text-align: right">
                            <td style="width: 15%;text-align: center">{{$data->f_name}}</td>
                            <td style="width: 20%;text-align: center">{{$data->l_name}}</td>
                            <td style="width: 20%;text-align: center">{{$data->code_melli}}</td>                            
                            {{-- <td style="width: 20%;text-align: center">{{substr($data->date_shamsi,0,4).'/'.substr($data->date_shamsi,4,2).'/'.substr($data->date_shamsi,6,2)}}</td> --}}
                            <td style="width: 25%;text-align: center"> {{floor($data->karkard / 3600) }}:{{floor(($data->karkard / 3600 - floor($data->karkard / 3600)) * 60)}}:00</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-3"> </div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8"></div>
        <div class="col-2"></div>
    </div>
@endsection
