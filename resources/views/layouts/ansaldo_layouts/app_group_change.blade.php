<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="persian-date.js"></script>
    <script src="persian-datepicker.js"></script>
    <link rel="stylesheet" href="persian-datepicker.css">
    <script src="toastr.min.js"></script>
    <link rel="stylesheet" href="toastr.min.css">
    <script src="sweetalert.min.js"></script>
    <link rel="stylesheet" href="sweetalert.min.css">
    <script src="sweetalert2.js"></script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mapna Group') }}</title>

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
            margin-top: 16px;
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
        .onvan
        {
            font-family: Tahoma;
            font-size: small;
            color: #f9f9f9;
        }
        #personel_list tr
        {
            font-family: Tahoma;
            font-size: smaller;
            color: #636b6f;
        }

        body {
            background: url('Minimalist-Crumpled-Paper-Simple-Background-Image.jpg') no-repeat fixed;
            background-size: cover;
            backdrop-filter: brightness(50%);
        }

        .person{
            width: 25%;
            border-left: 1px solid black;
            font-family: Tahoma;
            font-size: smaller;
            font-weight: bold;
        }
        .person2{
            width: 25%;
            border-left: 1px solid black;

        }
        .person3{
            font-family:Tahoma;
            font-size: small;
            color: black;
            height: 5px;
            margin-top: 5px;
            color: #0069d9;
        }
        .form-control{
            font-family: Tahoma;
            font-size: small;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
</head>
<body style="margin:0;text-align: center;">
<div class="container-fluid" id="reza">
    {{--<div class="row justify-content-center" style="height: 100px">--}}
        {{--<div class="col-12">--}}
            {{--<div  style="width: 100%;height:95px;margin-top: 3px;border-radius: 5px;">--}}
                {{--<div class="row justify-content-center" style="height: 100px">--}}
                    {{--<div class="col-2"><img src="https://stnt.mapnaom-kz.com/public/mapna.jpg" class="rounded-circle mt-3 ml-3" alt="Cinque Terre"></div>--}}
                    {{--<div class="col-1">1</div>--}}
                    {{--<div class="col-1">1</div>--}}
                    {{--<div class="col-1">1</div>--}}
                    {{--<div class="col-5"><p style="color: white;text-align: right;margin-top: 10px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">ورود اطلاعات مربوط به برنامه ریزی تعمیرات</p></div>--}}
                    {{--<div class="col-1">1</div>--}}
                    {{--<div class="col-1">1</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<nav class="navbar navbar-expand bg-info rounded col-12" style="height: 30px;direction: rtl;margin-top: 1px">--}}
        {{--<ul class="navbar-nav" >--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" href="/bazsaz-form">ورود اطلاعات پایه</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item">--}}
                {{--<a class="nav-link" href="/home">صفحه اصلی</a>--}}
            {{--</li>--}}

        {{--</ul>--}}
                {{--</nav>--}}
    <div class="row" style="height: 625px;">
           @yield('content')
    </div>
        {{--<div class="col-2">--}}
            {{--<div class="row mt-3" style="height:100%;margin: auto;width:233px;">--}}
                {{--<div class="col-6" style="border-radius: 5px;height: 170px;background-color:rgba(14,53,126,0.5);text-align: center;margin-left:75px">--}}
                    {{--<div >--}}
                            {{--<img src="addlist.jpg" id="tainfoform" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان اطلاعات مربوط به تعمیرات را وارد نمود">--}}
                    {{--</div>--}}
                    {{--<div >--}}
                            {{--<img src="reports.png" id="ta_report" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان گزارشات مربوط به تعمیرات را ایجاد نمود">--}}
                    {{--</div>--}}


                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
</div>
<!-- Scripts -->
{{--@include('sweetalert::alert')--}}
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
