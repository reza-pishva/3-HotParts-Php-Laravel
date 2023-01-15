@extends('layouts.app_guard_print')
@section('content')
            <a href="{{url('/print3')}}" class="btnprn2 btn">
                <p><img src="En-logo-H.png" style="width: 250px;height: 120px"></p>
            </a>
            <p class="title">لیست قطعات نیروگاهی و سایر کالاها </p>
            <table class="table table-bordered table-sm" style="font-size: small;direction: rtl">
                <thead class="table table-bordered table-sm bg-primary " style="color:white;text-align: center">
                <tr>
                    <th style="width: 3%;font-size:8px">شماره درخواست</th>
                    <th style="width: 4%;font-size:8px">تاریخ درخواست</th>
                    <th style="width: 10%;font-size:10px">ارسال کننده</th>
                    <th style="width: 6%;font-size:10px">بخش</th>
                    <th style="width: 24%;font-size:10px">توضیحات</th>
                    <th style="width: 4%;font-size:8px">نوع کالا</th>
                    <th style="width: 3%;font-size:8px">نوع درخواست</th>
                    <th style="width: 4%;font-size:10px">کد جمعداری</th>
                    <th style="width: 7%;font-size:10px">راننده خارج کننده</th>
                    <th style="width: 7%;font-size:10px">شماره پلاک</th>
                    <th style="width: 7%;font-size:10px">تاریخ خروج</th>
                    <th style="width: 7%;font-size:10px">راننده وارد کننده</th>
                    <th style="width: 7%;font-size:10px">شماره پلاک</th>
                    <th style="width: 7%;font-size:10px">تاریخ ورود</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr style="color:black;text-align: right">
                        <td style="font-size:10px">{{$request->id_exit}}</td>
                        <td style="font-size:10px">{{$request->date_request_shamsi}}</td>
                        <td style="font-size:10px">{{\App\User::where('id',$request->id_requester)->first()->f_name.' '.
                              \App\User::where('id',$request->id_requester)->first()->l_name}}
                        </td>
                        <td style="font-size:10px">{{\App\Requestpart::where('id_request_part',$request->id_request_part)->first()->description}}</td>
                        <td style="font-size:10px">{{$request->description}}</td>
                        <td style="font-size:10px">{{\App\Goodstype::where('id_goods_type',$request->id_goods_type)->first()->description}}</td>
                        <td style="font-size:10px">{{$request->enter_exit === 2 ? "ورود" : "خروج"}}</td>
                        <td style="font-size:10px">{{$request->jamdari_no}}</td>
                        
                        <td style="font-size:10px">{{$request->exit_driver}}</td>
                        <td style="font-size:10px">{{substr($request->car_no_exit,4,3).' '.substr($request->car_no_exit,0,2).' '.substr($request->car_no_exit,2,2)}}</td>
                        <td style="font-size:10px">{{$request->date_exit_shamsi}}</td>
                        <td style="font-size:10px">{{$request->enter_driver}}</td>
                        <td style="font-size:10px">{{substr($request->car_no_enter,4,3).' '.substr($request->car_no_enter,0,2).' '.substr($request->car_no_enter,2,2)}}</td>                        
                        <td style="font-size:10px">{{$request->date_enter_shamsi}}</td>
                        

                    </tr>
                @endforeach


                </tbody>
            </table>
@endsection
