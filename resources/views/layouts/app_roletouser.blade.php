<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">
    <script src="{{URL::to('/')}}/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/sweetalert.min.css">
    <script src="{{URL::to('/')}}/toastr.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/toastr.min.css">
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
            width:70px;
            height:70px;
            margin-top: 7px;
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
            background: url('{{URL::to('/')}}/bg001.jpg') no-repeat fixed;
            background-size: cover;
            backdrop-filter: brightness(40%);
        }

        .pegah{
            background-color: #007be6;
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
<div class="container-fluid" id="reza" >
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
        </ul>
                </nav>
    <div class="row" style="height: 670px">
        <div class="col-10 mt-1">
                <div style="border-radius: 5px;height: 660px;width: 1108px;">
                    @yield('content')
                </div>
        </div>
        <div class="col-2">
            <div class="row mt-1" style="height:100%;margin: auto;width:233px">
                <div class="col-10" style="border-radius: 5px;height: 650px;background-color:rgba(14,53,126,0.5);text-align: center;">
                    <div class="bg-secondary" style="height: 30px;width: 100%;margin-top: 20px;border-radius: 3px">
                        <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">تخصیص سطوح دستزسی</p>
                    </div>
                    <div >
                            <img src="{{URL::to('/')}}/update-user.png" id="add_user" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید کاربران موجود را ویرایش کنید">
                    </div>
                    <div >
                            <img src="{{URL::to('/')}}/group030.png" id="add_group" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید گروه جدید تعریف کنید">
                    </div>
                    <div >
                            <img src="{{URL::to('/')}}/group002.png" id="user_to_group" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان کاربران را به گروه انتخابی نسبت داد">
                    </div>
                    <div >
                            <img src="{{URL::to('/')}}/group028.png" id="add_role" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان عنوانهای سطوح دسترسی را مشخص کرد">
                    </div>
                    <div >
                            <img src="{{URL::to('/')}}/group013.png" id="role_to_group" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان سطوح دسترسی را به گروههای تعریف شده نسبت داد">
                    </div>
                    <div class="bg-secondary" style="height: 30px;width: 100%;margin-top: 20px;border-radius: 3px">
                        <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">ویرایش اطلاعات پایه</p>
                    </div>
                    <div >
                        <img src="{{URL::to('/')}}/types01.png" id="add_goods_type" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان نوع قطعات را تغییر داد و یا اضافه کرد">
                    </div>
                    <div >
                        <img src="{{URL::to('/')}}/parts01.png" id="add_parts_type" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توان بخش درخواست کننده را تغییر داد">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
{{--@include('sweetalert::alert')--}}
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
