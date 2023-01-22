<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="toastr.min.js"></script>
    <link rel="stylesheet" href="toastr.min.css">
    <script src="persian-date.js"></script>
    <script src="persian-datepicker.js"></script>
    <link rel="stylesheet" href="persian-datepicker.css">
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
            cursor: pointer;
        }
        img.reza2
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            opacity: 0.7;
            filter: alpha(opacity=100);
            width:55%;
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
            color: white;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-top: 1px solid black ;
        }
        .el
        {
            color: white;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-left: 1px solid black;
            border-top: 1px solid black ;
            border-right: 1px solid black;
            padding-right: 10px;
        }
        .el2
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
            color: white;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-top: 1px solid black ;
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
            color: white;
            font-size: smaller;
            font-family: Tahoma;
            text-align: center;
            border-top: 1px solid black ;
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
        /*.container{*/
        /*    width: 800px;*/
        /*    margin: 0 auto;*/
        /*}*/
        .title_tab{
          font-family: Tahoma;
          font-size: smaller;
          margin: auto;
            padding: 10px;
        }
        .tab_div{
            width: 100%;
            border: 1px solid black;
            border-radius: 5px;
            background-color: #005cbf;
            color: white;
        }
        .tab_div:hover{
            background-color: #c82333;
            color: white;
        }


        ul.tabs{
            margin: 0px;
            padding: 0px;
            list-style: none;
        }
        ul.tabs li{
            background: none;
            color: #222;
            display: inline-block;
            padding: 10px 15px;
            cursor: pointer;
        }

        ul.tabs li.current{
            color: #222;
        }

        .tab-content{
            display: none;
            padding: 15px;
        }

        .tab-content.current{
            display: inherit;
        }
    </style>
</head>
<body style="margin:0;text-align: center;background-image: url('./kz6.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;backdrop-filter: brightness(40%)">
<div class="container-fluid">
    <div class="row justify-content-center" style="height: 100px">
        <div class="col-12">
            <div class="bg-dark" style="width: 100%;height:95px;margin-top: 3px;border-radius: 5px">
                <div class="row justify-content-center" style="height: 100px">
                    <div class="col-2"><img src="./mapna.jpg" class="rounded-circle mt-3 ml-3" alt="Cinque Terre"></div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 10px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">نرم افزار مدیریت درخواست مجوز ورود افراد به نیروگاه</p></div>
                    <div class="col-2 mt-3"><img src="./requester001.png" class="rounded-circle" style="width: 30%;height: 50%"><p style="color: white;text-align: center;font-family: Tahoma;font-size: small">{{$full_name}}</p></div>
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
            <div class="row" style="border-radius: 5px;height: 700px;width: 100%;">
                <div class="col-1"></div>
                <div class="col-10">@yield('content')</div>
                <div class="col-1"></div>
            </div>
        </div>
        <div class="col-2">
            <div class="row mt-1" style="height:100%;margin: auto;width:100%">
                    <div class="col-10" style="border-radius: 5px;height: 680px;background-color:rgba(14,53,126,0.5);text-align: center">
                        <div class="bg-secondary" style="height: 45px;width: 100%;margin-top: 20px;border-radius: 3px">
                            <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">ایجاد فرم درخواست مجوز ورود افراد</p>
                        </div>
                        <div>
                            <a href="/enteringform">
                                <img src="./form.png" id="formcreate"  class="reza2" data-toggle="tooltip" data-placement="left" title="از این طریق می توانید فرم جدیدی برای درخواست مجوز ورود افراد به نیروگاه ایجاد کنید">
                            </a>

                        </div>
                        <div class="bg-secondary" style="height: 40px;width: 100%;margin-top: 30px;border-radius: 3px">
                            <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">گزارشات مربوط به گردش درخواست</p>
                        </div>
                        <div>
                            <img src="./edit.png" id="first_report" class="reza2" data-toggle="tooltip" data-placement="left" title="موارد ارسالی برای مسئول مستقیم.در اینجا می توانید مواردی را که هنوز مورد بررسی سرپرست قسمت قرار نگرفته اند تغییر داده و یا حذف کنید">
                        </div>
                        <div>
                            <img src="./sent.jpg" id="second_report" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که توسط شما درخواست مجوز شده اند ببینید">
                        </div>
                        <div>
                            <img src="./nono.jpg" id="third_report" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید فرمهایی که جهت مجوز مورد تایید قرار نگرفته ببینید">
                        </div>
                        <div>
                            <img  src="./permit02.png" id="fourth_report"  class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی که مجوز ورود به نیروگاه گرفته اند مشاهده کنید">
                        </div>
                        <div class="bg-secondary" style="height: 30px;width: 100%;margin-top: 20px;border-radius: 3px">
                            <p style="font-family: Tahoma;font-size: small;margin-top: 4px;color: white">فرم گزارش گیری</p>
                        </div>
                        <div class="col">
                            <a href="/reportp">
                                <img src="./reports.png" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید گزارشات مورد نظر خود را تهیه کنید">
                            </a>
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
