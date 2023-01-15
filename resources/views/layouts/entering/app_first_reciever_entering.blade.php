<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">
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
        .description{
            text-align: right;
        }
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
            /*width:80px;*/
            /*height:80px;*/
            cursor: pointer;
        }
        img.reza2
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            opacity: 0.7;
            filter: alpha(opacity=100);
            width:55px;
            height:55px;
            margin-top: 12px;
        }
        .person
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
        }
        .cars
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
        }
        .car
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
        }
        .els
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
        }
        .el
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
            padding-right: 10px;
        }
        .eqs
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
        }
        .eq
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
            padding-right: 10px;
        }

        .equs
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
        }
        .equ
        {
            color: black;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
            padding-right: 10px;
        }
        #person_table{
            border: 1px solid black;
        }
        .persons
        {
            border-right: 1px solid black;
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
            text-align : right;
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
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 10px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">نرم افزار مدیریت درخواست مجوز ورود افراد به نیروگاه</p></div>
                    <div class="col-2 mt-3"><img src="{{URL::to('/')}}/modir001.png" class="rounded-circle" style="width: 30%;height: 50%"><p style="color: white;text-align: center;font-family: Tahoma;font-size: small">{{$full_name}}</p></div>
                </div>
            </div>
        </div>
    </div>
    <nav class="navbar navbar-expand bg-info rounded col-12" style="height: 30px;direction: rtl;margin-top: 1px">
        <ul class="navbar-nav" >
            <li class="nav-item">
                <a class="nav-link" href="/home">صفحه اصلی</a>
            </li>

        </ul>
    </nav>
    <div class="row" style="height: 700px">
        <div class="col-10">
            <div class="row" style="border-radius: 5px;height: 600px;width: 100%;">
                <div class="col-1"></div>
                <div class="col-10">@yield('content')</div>
                <div class="col-1"></div>
            </div>
        </div>
        <div class="col-2">
            <div class="row mt-1" style="height:100%;margin: auto;width:100%">
                <div class="row mt-1" style="height:100%;margin: auto;width:233px">
                    <div class="col-10" style="border-radius: 5px;height: 600px;background-color:rgba(14,53,126,0.5);text-align: center">
                        <div class="bg-secondary" style="height: 60px;width: 100%;margin-top: 5px;border-radius: 3px;padding-top: 7px">
                            <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">گزارشات مربوط به گردش درخواست</p>
                        </div>
                        <div>
                            <img src="{{URL::to('/')}}/sent.jpg" id="for_first_confirmation" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که جهت تایید برای شما ارسال شده اند ببینید">
                        </div>
                        <div>
                            <img src="{{URL::to('/')}}/imeni002.png" id="for_herasat" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی را که هنوز از طرف مسئول ایمنی مورد بررسی قرار نگرفته اند مجددا به کارتابل موارد دریافتی برگردانید">
                        </div>
                        <div>
                            <img src="{{URL::to('/')}}/nono.jpg" id="for_requester" class="reza2" data-toggle="tooltip" data-placement="left" title="در اینجا می توانید مواردی که از طرف شما مورد تایید قرار نگرفته ببینید و در صورت تمایل به کارتابل موارد دریافتی بازگردانید">
                        </div>
                        <div>
                            <img  src="{{URL::to('/')}}/enter010.jpg"  id="from_herasat"  class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که مورد تایید مدیر نیروگاه واقع نشده مشاهده کنید و در صورت تمایل به کارتابل موارد دریافتی بازگردانید">
                        </div>
                        <div>
                            <img src="{{URL::to('/')}}/total.jpg" id="total_part" class="reza2" data-toggle="tooltip" data-placement="left" title="کلیه درخواستهای ارسالی در این بخش">
                        </div>
                        <div class="bg-secondary" style="height: 40px;width: 100%;margin-top: 10px;border-radius: 3px;padding-top: 6px">
                            <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">فرم گزارش گیری</p>
                        </div>
                        <div class="col">
                            <a href="/reportp">
                                <img src="{{URL::to('/')}}/reports.png" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید گزارشات مورد نظر خود را تهیه کنید">
                            </a>
                        </div>
                        <div class="col">
                            <a href="/reporti">
                                <img src="{{URL::to('/')}}/individual.png" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید گزارشات تردد را تهیه کنید">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
