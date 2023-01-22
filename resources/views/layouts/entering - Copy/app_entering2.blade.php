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
            width:80%;
            height:100%;
            margin-top: 3px;
            font-family: Tahoma;
            font-size: 8px;
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
        .modal {
            position: relative;
            top: -700px;
            left: 50%;
        }
        .progress {
            margin-bottom: 20px;
        }

        .progress-bar {
            width: 0;
        }

        .bg-purple {
            background-color: #825CD6 !important;
        }

        .progress .progress-bar {
            transition: unset;
        }
    </style>
</head>
<body style="margin:0;text-align: center;background-image: url('./bg001.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;backdrop-filter: brightness(40%);">
<div class="container-fluid">
    <div class="row justify-content-center" style="height:75px;overflow: hidden">
        <div class="col-12" style="height: 100%">
            <div class="bg-dark" style="width: 100%;height:95%;margin-top: 3px;border-radius: 5px">
                <div class="row justify-content-center" style="height: 70%">
                    <div class="col-2"><img src="./mapna.jpg" class="rounded-circle mt-0 ml-3" alt="Cinque Terre"></div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 4px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">نرم افزار مدیریت ورود و خروج افراد به نیروگاه</p></div>
                    <div class="col-2 pt-1"><img src="./requester001.png" class="rounded-circle" style="width:30%;height:50%"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="height: 10%;">
        <div class="col-12">
           <div class="row" style="margin-top:3px;height: 100%">
               <div class="col-3">
                   <div >
                       <a href="./herasat2">
                           <img src="./exit003.png" style="width: 70px;height: 70px;margin-top: 25px" data-toggle="tooltip" data-placement="bottom" title="بازگشت به صفحه قبل">
                       </a>
                   </div>
               </div>
               <div class="col-6" style="background: rgba(0, 45, 90, 0.7);border-radius: 8px;height:100%">
                   <div class="row" style="border-radius: 5px;height:100%;margin-top:6px">
                       <div class="col">
                           <div class="row"  >
                               <div class="col">
                                   <div >
                                       <a href="#">
                                           <img src="./eq1.png" id="bs5"  class="reza2" data-toggle="tooltip" data-placement="bottom" title="در این مرحله می توان لیست کلیه وسایل کار این نفرات را وارد کرد">
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col">
                                   <div id="stage005" class="bg-secondary" style="height: 22px;width: 100%;margin-top: 3px;border-radius: 3px">
                                       <p style="font-family: Tahoma;font-size: smaller;margin-top: 4px;color: white">مرحله پنجم</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col">
                           <div class="row">
                               <div class="col">
                                   <div>
                                       <a href="#">
                                           <img src="./electronic1.png" id="bs4"  class="reza2" data-toggle="tooltip" data-placement="bottom" title="در این مرحله می توان لیست تجهیزات الکترونیکی که این افراد با خود وارد نیروگاه می کنند وارد کرد">
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col">
                                   <div id="stage004" class="bg-secondary" style="height: 22px;width: 100%;margin-top: 3px;border-radius: 3px">
                                       <p style="font-family: Tahoma;font-size: smaller;margin-top: 4px;color: white">مرحله چهارم</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col">
                           <div class="row">
                               <div class="col">
                                   <div>
                                       <a href="#">
                                           <img src="./car1.png" id="bs3"  class="reza2" data-toggle="tooltip" data-placement="bottom" title="در این مرحله می توانید مشخصات خودرو یا خودروهایی که این افراد وارد نیروگاه می کنند وارد نمایید">
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col">
                                   <div id="stage003" class="bg-secondary" style="height: 22px;width: 100%;margin-top: 3px;border-radius: 3px">
                                       <p style="font-family: Tahoma;font-size: smaller;margin-top: 4px;color: white">مرحله سوم</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col">
                           <div class="row">
                               <div class="col">
                                   <div>
                                       <a href="#">
                                           <img src="./user_add02.png" id="bs2"  class="reza2" data-toggle="tooltip" data-placement="bottom" title="در این مرحله می توانید اسامی افرادی که برای آنها درخواست مجوز کرده اید همراه با ساعت و تاریخ حضور وارد نمایید">
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col">
                                   <div id="stage002" class="bg-secondary" style="height: 22px;width: 100%;margin-top: 3px;border-radius: 3px">
                                       <p style="font-family: Tahoma;font-size: smaller;margin-top: 4px;color: white">مرحله دوم</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                       <div class="col">
                           <div class="row">
                               <div class="col">
                                   <div>
                                       <a href="#">
                                           <img src="./start01.png" id="bs1"  class="reza2" data-toggle="tooltip" data-placement="bottom" title="در این مرحله می توانید فرم جدیدی برای درخواست مجوز خروج و یا ورود افراد همراه با عنوان فعالیت و شرکت مربوطه ایجاد کنید">
                                       </a>
                                   </div>
                               </div>
                           </div>
                           <div class="row">
                               <div class="col">
                                   <div id="stage001" class="bg-secondary" style="height: 22px;width: 100%;margin-top: 3px;border-radius: 3px">
                                       <p style="font-family: Tahoma;font-size: smaller;margin-top: 4px;color: white">مرحله اول</p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-3"></div>
           </div>
        </div>
    </div>
    <div class="row mt-3" style="height: 83%;">
        <div class="col">
            <div class="row" style="border-radius: 5px;height: 500px;width: 100%;">
                <div class="col-7">@yield('content2')</div>
                <div class="col-5">@yield('content')</div>
            </div>
        </div>
    </div>

</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
