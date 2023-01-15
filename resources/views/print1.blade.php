@extends('layouts.app_guard_print')
@section('content')
            <a href="{{url('/print1')}}" class="btnprn1 btn">
                <p><img src="{{URL::to('/')}}/printer.png" style="width: 100px;height: 100px"></p>
            </a>
            <p class="title">لیست قطعات نیروگاهی و کالاهای در انتظار خروج</p>
            <table class="table table-bordered table-sm" style="font-size: small;direction: rtl">
                <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                <tr>
                    <th style="width: 5%">شماره درخواست</th>
                    <th style="width: 7%">تاریخ درخواست</th>
                    <th style="width: 10%">ارسال کننده</th>
                    <th style="width: 12%">بخش</th>
                    <th style="width: 33%">توضیحات</th>
                    <th style="width: 10%">نوع کالا</th>
                    <th style="width: 7%">کد جمعداری</th>

                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr style="color:black;text-align: right">
                        <td>{{$request['id_exit']}}</td>
                        <td>{{$request['date_request_shamsi']}}</td>
                        <td>{{\App\User::where('id',$request['id_requester'])->first()->f_name.' '.
                              \App\User::where('id',$request['id_requester'])->first()->l_name}}
                        </td>
                        <td>{{\App\Requestpart::where('id_request_part',$request['id_request_part'])->first()->description}}</td>
                        <td>{{$request['description']}}</td>
                        <td>{{\App\Goodstype::where('id_goods_type',$request['id_goods_type'])->first()->description}}</td>
                        <td>{{$request['jamdari_no']}}</td>

                    </tr>
                @endforeach


                </tbody>
            </table>
@endsection
