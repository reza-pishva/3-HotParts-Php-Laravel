<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">
{{--    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>--}}
    <script src="{{URL::to('/')}}/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/sweetalert.min.css">
    <script src="{{URL::to('/')}}/toastr.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/toastr.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mapna Group') }}</title>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        table {
            border-collapse: collapse;
        }

        table, th, td {
            border-bottom: 1px solid black;
        }

        div.modal-body p{
            display: inline;
            font-family: Tahoma;
            font-size: small;
            direction: rtl;
        }
        #note{
            font-weight: bold;
            color: crimson;
        }
        img.reza2:hover
        {
            opacity: 1.0;
            filter: alpha(opacity=100);
            outline: 2px solid white;
            outline-offset: 1px;
            width:80px;
            height:80px;
            cursor: pointer;
        }
        img.reza2
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            opacity: 0.7;
            filter: alpha(opacity=100);
            width:70px;
            height:70px;
            margin-top: 10px;
        }
        li a
        {
            color: white;
            font-size: small;
        }
        li.nav-item{
            margin-right: 30px;
        }
        #request_table
        {
            border-collapse : collapse;
        }

        #request_table td
        {
            border-bottom : 2px solid black;
        }

        #request_table tr
        {
            text-align : center;
        }

        #request_table tr:first-child
        {
            font-weight : normal;
        }

        #request_table tr:nth-child(even)
        {
            background-color : white;
        }

        #request_table tr:nth-child(odd)
        {
            background-color : silver;

        }
    </style>
</head>
<body style="margin:0;text-align: center;background-image: url('{{URL::to('/')}}/bg001.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;backdrop-filter: brightness(40%);">
<div class="container-fluid">
    <div class="row justify-content-center" style="height: 100px">
        <div class="col-12">
            <div class="bg-dark" style="width: 100%;height:95px;margin-top: 3px;border-radius: 5px">
                <div class="row justify-content-center" style="height: 100px">
                    <div class="col-2"><img src="{{URL::to('/')}}/mapna.jpg" class="rounded-circle mt-3 ml-3" alt="Cinque Terre"></div>
                    <div class="col-1">1</div>
                    <div class="col-1">1</div>
                    <div class="col-1">1</div>
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 10px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">نرم افزار مدیریت ورود و خروج کالا و تجهیزات نیروگاهی</p></div>
                    <div class="col-1">1</div>
                    <div class="col-1">1</div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand bg-info rounded col-12" style="height: 30px;direction: rtl;margin-top: 1px">
                    <ul class="navbar-nav" >
                        <li class="nav-item">
                            <a class="nav-link" href="/home">صفحه اصلی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">معرفی نیروگاه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">معرفی نرم افزار</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">تماس با ما</a>
                        </li>

                    </ul>
                </nav>
    <div class="row" style="height: 660px">
        <div class="col-10 mt-1">
                <div style="border-radius: 5px;height: 660px;width: 1108px;">
                    @yield('content')
                </div>
        </div>
        <div class="col-2">
            <div class="row mt-1" style="height:100%;margin: auto;width:233px">
                <div class="col-10" style="border-radius: 5px;height: 660px;background-color:rgb(14,53,126);text-align: center">
                    <div class="bg-secondary" style="height: 30px;width: 100%;margin-top: 20px;border-radius: 3px">
                        <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">ایجاد فرم مجوز ورود و خروج</p>
                    </div>
                    <div>
                        <a href="/formcreate">
                            <img src="{{URL::to('/')}}/form.png" id="formcreate"  class="reza2" data-toggle="tooltip" data-placement="left" title="از این طریق می توانید فرم جدیدی برای درخواست مجوز خروج و یا ورود قطعه و یا کالا ایجاد کنید">
                        </a>

                    </div>
{{--                    <div class="bg-secondary" style="height: 40px;width: 100%;margin-top: 30px;border-radius: 3px">--}}
{{--                        <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">گزارشات مربوط به گردش درخواست</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <img src="./edit.png" id="first_report" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی را که هنوز مورد بررسی سرپرست قسمت قرار نگرفته اند تغییر داده و یا حذف کنید">--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <img src="./sent.jpg" id="second_report" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که توسط شما درخواست مجوز ورود و یا خروج شده اند ببینید">--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <img src="./nono.jpg" id="third_report" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که جهت خروج مورد تایید قرار نگرفته ببینید">--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <img  src="./return.png" id="fourth_report"  class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که به نیروگاه بازگشته مشاهده کنید">--}}
{{--                    </div>--}}
{{--                    <div class="bg-secondary" style="height: 30px;width: 100%;margin-top: 20px;border-radius: 3px">--}}
{{--                        <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">فرم گزارش گیری</p>--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <img src="./reports.png" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید گزارشات مورد نظر خود را تهیه کنید">--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2 bg-dark" style="margin: auto;border-radius: 5px">
                    <div class="col-3">
                        .
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d66032.83315615916!2d51.748110945722324!3d29.562284845899754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fb3de3a669facab%3A0x654adc71d45ea4bb!2z2YbbjNix2Yjar9in2Ycg2qnYp9iy2LHZiNmG2Iwg2KfYs9iq2KfZhiDZgdin2LHYs9iMINin24zYsdin2YY!5e0!3m2!1sfa!2sde!4v1596814171406!5m2!1sfa!2sde"
                                        width="80%" height="160px" frameborder="0" style="border:0;margin-top: 20px;border-radius: 5px" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                            <div class="col" style="font-family: Tahoma;font-size: small;color: white;direction: rtl">
                                <p style="text-align: right;font-weight: bold;margin-top: 5px">تلفنها و فاکس</p>
                                <hr style="border: 1px solid white">
                                <p style="text-align: right;margin-top: 5px">تلفنها:0714229628 0714228536 </p>
                                <p style="text-align: right"> روابط عمومی : 0714222536 2458</p>
                                <p style="text-align: right"> دبیرخانه : 0714222536 2458</p>
                                <p style="text-align: right"> شماره فاکس : 0714222536 2458</p>
                            </div>

                            <div class="col" style="font-family: Tahoma;font-size: small;color: white;direction: rtl">
                                <p style="text-align: right;font-weight: bold;margin-top: 5px">تماس با ما </p>
                                <hr style="border: 1px solid white">
                                <p style="text-align: right"> آدرس : کیلومتر 5 جاده کازرون شیراز روستای نصیرآباد</p>
                                <p style="text-align: right">نیروگاه سیکل ترکیبی کازرون</p>
                                <hr style="border: 1px solid white">
                                <p style="text-align: right">پست الکترونیکی:rpishva@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@include('sweetalert::alert')
</body>
</html>
