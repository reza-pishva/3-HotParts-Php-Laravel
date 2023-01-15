@extends('layouts.app_guard_print')
@section('content')

    <a href="{{url('/selectcar/'.$id_ec)}}" class="btnprn3 btn" onclick="window.print()">
        <p><img src="{{URL::to('/')}}/mapna.jpg" style="width: 80px;height: 80px"></p>
    </a>
<div class="container-fluid">
    <hr>
    <div class="row">
        <div class="col" style="background-color:lavender;">
            <p style="font-family: Tahoma;font-size: xx-large">شماره پلاک خودرو</p>
        </div>
    </div>
    <div class="row">
        <div class="col-1" style="background-color:lavender;"></div>
        <div class="col-1" style="background-color:lavender;"></div>
        <div class="col-1" style="background-color:lavender;"></div>
        <div class="col-2" style="background-color:lavender;text-align: right">
            <p style="font-size:  60px;font-family: Tahoma">{{$p2}}</p>
        </div>
        <div class="col-2" style="background-color:lavender;text-align: right">
            <p style="font-size:  60px;font-family: Tahoma">{{$p1}}</p>
        </div>
        <div class="col-2" style="background-color:lavender;text-align: right">
            <p style="font-size:  60px;font-family: Tahoma">{{$p3}}</p>
        </div>
        <div class="col-1" style="background-color:lavender;"></div>
        <div class="col-2" style="background-color:lavender;"></div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col" style="background-color:lavender;">
                    <p style="font-family: Tahoma;font-size: x-large">محدوده تردد</p>
                </div>
            </div>
            <div class="row">
                <div class="col" style="background-color:lavender;">
                    <p style="font-family: Tahoma;font-size: 40px;font-family: Tahoma">{{$area}}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col" style="background-color:lavender;">
                    <p style="font-family: Tahoma;font-size: x-large">مجوز تردد تا تاریخ</p>
                </div>
            </div>
            <div class="row">
                <div class="col" style="background-color:lavender;">
                    <p style="font-family: Tahoma;font-size: 40px;font-family: Tahoma">{{$date_shamsi_exit}}</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="row">
                <div class="col" style="background-color:lavender;">
                    <p style="font-family: Tahoma;font-size: x-large">نام راننده</p>
                </div>
            </div>
            <div class="row">
                <div class="col" style="background-color:lavender;">
                    <p style="font-family: Tahoma;font-size: 40px;">{{$driver_name}}</p>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col" style="background-color:lavender;text-align: center;border: 1px solid black">
            <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                امضاء مدیر حراست و یا جانشین ایشان
            </p>
        </div>
        <div class="col" style="background-color:lavender;text-align: right;border: 1px solid black">
            <table style="width:100%">
                <tr>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            این مجوز در مدت زمان و محدوده تعیین شده دارای اعتبار است
                        </p>
                    </td>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            *
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            این برگه بدون امضا مدیر حفاظت فاقد اعتبار است
                        </p>
                    </td>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            *
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            این مجوز تردد فقط برای انجام امور محوله است لذا برای توقف طولانی مدت، خودرو را به پارکینگ منتقل نمایید
                        </p>
                    </td>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            *
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            عدم رعایت موارد فوق منجر به حذف مجوز تردد خواهد شد
                        </p>
                    </td>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            *
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            این مجوز پس از پایان اعتبار باید به انتظامات نیروگاه تحویل داده شود
                        </p>
                    </td>
                    <td>
                        <p style="font-size:  14px;font-family: Tahoma;direction: ltr;text-align: right">
                            *
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

</div>
@endsection
