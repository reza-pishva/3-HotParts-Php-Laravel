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
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

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
            margin-top:3px;
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
            background: url('mapna001.jpg') no-repeat fixed;
            background-size: cover;
            backdrop-filter: brightness(20%);
        }

        .pegah{
            background-color:#2F96B4;
            color: white;
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
    <div class="row justify-content-center" style="height: 100px">
        <div class="col-12">
            <div  style="width: 100%;height:95px;margin-top: 3px;border-radius: 5px;">
                <div class="row justify-content-center" style="height: 100px">
                    <div class="col-2"><img src="mapna.jpg" class="rounded-circle mt-3 ml-3" alt="Cinque Terre"></div>
                    <div class="col-1">1</div>
                    <div class="col-1">1</div>
                    <div class="col-1">1</div>
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 10px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">(MITSUBISHI) ورود اطلاعات پایه نرم افزار ثبت سوابق</p></div>
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
                <a class="nav-link" href="/m-savabegh">بازگشت</a>
            </li>
        </ul>
    </nav>
    <div class="row justify-content-center bg-dark mt-1" style="width: 60%;height:60px;margin: auto;border-radius: 10px">
                            <div class="col">
                                <img src="repair.jpg" id="add_bazsaz" class="reza2" data-toggle="tooltip" data-placement="bottom" title="از اینجا می توان نام شرکت بازسازی کننده را وارد کرد و یا نام آنرا تغییر داد">
                            </div>
                            <div class="col">
                                <img src="seller.jpg" id="add_seller" class="reza2" data-toggle="tooltip" data-placement="bottom" title="از اینجا می توان نام شرکت فروشنده را وارد کرد و یا نام آنرا تغییر داد">
                            </div>
                            <div class="col">
                                <img src="repair2.png" id="add_tamirkar" class="reza2" data-toggle="tooltip" data-placement="bottom" title="از اینجا می توان نام تعمیرکاران را وارد کرد و یا نام آنرا تغییر داد">
                            </div>
                            <div class="col">
                                <img src="unnamed (1).jpg" id="add_sazandeh" class="reza2" data-toggle="tooltip" data-placement="bottom" title="از اینجا می توان نام شرکتهای سازنده را وارد کرد و یا نام آنرا تغییر داد">
                            </div>
                            <div class="col">
                                <img src="type.jpg" id="add_tamiratty" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تعیین نوع تعمیرات و تغییر آن">
                            </div>
                            <div class="col">
                                <img src="equip.png" id="add_typgha" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تعیین نوع قطعات و تغییر آن">
                            </div>
                            <div class="col">
                                <img src="power-plant.png" id="add_nir" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تعیین نام نیروگاهها">
                            </div>
                            <div class="col">
                                <img src="unit.png" id="add_unit" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تعیین نام واحدها">
                            </div>
    </div>
    <div class="row" style="height: 595px">
        <div class="col-12 mt-1" >
                <div style="height: 440px">
                    @yield('content')
                </div>
        </div>
        {{--<div class="col-2">--}}
            {{--<div class="row mt-3" style="height:100%;margin: auto;width:233px;">--}}
                {{--<div class="col-6" style="border-radius: 5px;height: 570px;background-color:rgba(14,53,126,0.5);text-align: center;margin-left:75px">--}}
                    {{--<div class="bg-secondary" style="height: 40px;width: 100%;margin-top: 5px;border-radius: 3px;padding-top: 10px">--}}
                        {{--<p style="font-family: Tahoma;font-size: small;color: white">اطلاعات پایه</p>--}}
                    {{--</div>--}}
                    {{--<div >--}}

                    {{--</div>--}}
                    {{--<div >--}}

                    {{--</div>--}}
                    {{--<div >--}}

                    {{--</div>--}}
                    {{--<div >--}}

                    {{--</div>--}}

                    {{--<div >--}}

                    {{--</div>--}}
                    {{--<div >--}}

                    {{--</div>--}}
                    {{--<div >--}}

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
