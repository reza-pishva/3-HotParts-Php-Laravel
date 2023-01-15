@extends('layouts.app_guard_print')
@section('content')
<a href="#" class="btnprn3 btn" onclick="window.print()">
{{--    <p><img src="../../printer.png" style="width: 30px;height: 30px"></p>--}}
    <p><img src="{{URL::to('/')}}/printer.png" style="width: 30px;height: 30px"></p>
</a>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="row">
                <div class="col-3">
{{--                    <a href="javascript:window.print()" class="btn btn-outline-primary pull-right">print</a>--}}
                </div>
{{--                <div class="col-2"><p style="font-size: smaller;text-align: right">{{$date2}}</p></div>--}}
{{--                <div class="col-1"><p style="font-size: xx-small;text-align: left">لغایت</p></div>--}}
{{--                <div class="col-2"><p style="font-size: smaller;text-align: right">{{$date1}}</p></div>--}}
{{--                <div class="col-1"><p style="font-size: xx-small;text-align: left">از تاریخ</p></div>--}}
                <div class="col-2">
{{--                    <p style="font-size: small;font-family: Tahoma;text-align: right;font-weight: bold">{{$l_name}}</p>--}}
                </div>
                <div class="col-1">
{{--                    <p style="font-size: small;font-family: Tahoma;text-align: left;font-weight: bold">{{$f_name}}</p>--}}
                </div>

            </div>
{{--            <div class="row">--}}
{{--                <div class="col-3"><a href="javascript:window.print()" class="btn btn-outline-primary pull-right">print</a></div>--}}
{{--                <div class="col-2"><p style="font-size: smaller;text-align: right">{{$code_melli}}</p></div>--}}
{{--                <div class="col-1"><p style="font-size: xx-small;text-align: left">:کد ملی</p></div>--}}
{{--                <div class="col-2"><p style="font-size: smaller;text-align: right">{{$mobile}}</p></div>--}}
{{--                <div class="col-1"><p style="font-size: xx-small;text-align: left">:شماره همراه</p></div>--}}
{{--                <div class="col-2">--}}
{{--                    <p style="font-size: small;font-family: Tahoma;text-align: right;font-weight: bold">{{$l_name}}</p>--}}
{{--                </div>--}}
{{--                <div class="col-1">--}}
{{--                    <p style="font-size: small;font-family: Tahoma;text-align: left;font-weight: bold">{{$f_name}}</p>--}}
{{--                </div>--}}

{{--            </div>--}}

        </div>
        <div class="col-2">
            <a href="./reporti">
                <img src="{{URL::to('/')}}/exit003.png" style="width: 30px;height: 30px;margin-top: 25px" data-toggle="tooltip" data-placement="bottom" title="بازگشت به صفحه قبل">
            </a>
        </div>

    </div>
    <div class="row" style="text-align: center">
        <div class="col-2" >

        </div>
        <div class="col-8">
            <div class="row" style="height: 20px">
                <div class="col-8"></div>
                <div class="col-2"></div>
                <div class="col-2">

                </div>
            </div>

        </div>
        <div class="col-2"></div>

    </div>
    <div class="row">
        <div class="col-3">
            <p style="font-family: '2  Homa';color: #0b2e13 ">کد ملی</p><p style="font-family: '2  Homa';font-size: xx-large;color: #2F96B4;text-align: center">{{$code}}</p>
            <p style="font-family: '2  Homa';color: #0b2e13">نام</p><p style="font-family: '2  Homa';font-size: xx-large;color: #2F96B4;text-align: center">{{$f_name}}</p>
            <p style="font-family: '2  Homa';color: #0b2e13">نام خانوادگی</p><p style="font-family: '2  Homa';font-size: xx-large;color: #2F96B4;text-align: center">{{$l_name}}</p>
        </div>
        <div class="col-8">
            <div id="cars_div" class="col" >
                <table class="table table-bordered table-sm" style="font-size: small;text-align: right;direction: rtl">
                    <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                    <tr>
                        <th style="width: 25%;text-align: center">کد</th>
                        <th style="width: 25%;text-align: center">ورود/خروج</th>
                        <th style="width: 25%;text-align: center">ساعت</th>
                        <th style="width: 25%;text-align: center">تاریخ</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($datas as $data)
                        <tr style="color:black;text-align: right">
                            <td style="width: 25%;text-align: center">{{$data['i_ed']}}</td>
                            <td style="width: 25%;text-align: center">{{$data['enter_exit'] == 1 ? 'ورود' : 'خروج'}}</td>
                            <td style="width: 25%;text-align: center">{{$data['time_enter']}}</td>
                            <td style="width: 25%;text-align: center">{{substr($data['date_enter'],0,4).'/'.substr($data['date_enter'],4,2).'/'.substr($data['date_enter'],6,2)}}</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-1"> </div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8"></div>
        <div class="col-2"></div>
    </div>
@endsection
