<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">
    <script src="{{URL::to('/')}}/toastr.min.js"></script>
    <link rel="{{URL::to('/')}}stylesheet" href="/toastr.min.css">
    <script src="{{URL::to('/')}}/persian-date.js"></script>
    <script src="{{URL::to('/')}}/persian-datepicker.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/persian-datepicker.css">
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
        .chk1
        {
            font-family: Tahoma;
            font-size: small;
            color: black;
        }
        .personinfo{
            border-right: 1px solid black;
            border-left: 1px solid black;
        }
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
            width:50px;
            height:50px;
            margin-top: 10px;
        }
        img.reza3
        {
            /*border: 1px solid rgb(14,53,126);*/
            /*border-radius: 15px;*/
            /*opacity: 0.7;*/
            /*filter: alpha(opacity=100);*/
            width:90px;
            height:90px;
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
        .report_row2
        {
            color: black;
            font-size:smaller;
            font-family: Tahoma;
            text-align: center;
            border-bottom: 1px solid black ;
            padding-right: 20px;
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
<body style="margin:0;text-align: center;background-image: url('{{URL::to('/')}}/p1.jpg');background-repeat: no-repeat;background-attachment: fixed;background-size: cover;backdrop-filter: brightness(35%);">
<div class="container-fluid">
    <div class="row justify-content-center" style="height:100px;overflow: hidden">
        <div class="col-12" style="height: 100%">
            <div class="bg-dark" style="width: 100%;height:100%;margin-top: 3px;border-radius: 5px">
                <div class="row justify-content-center" style="height: 100%">
                    <div class="col-2"><img src="{{URL::to('/')}}/mapna.jpg" class="rounded-circle mt-2 ml-3" alt="Cinque Terre"></div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-1">.</div>
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 4px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold">نرم افزار مدیریت ورود و خروج افراد به نیروگاه</p></div>
                    <div class="col-2 pt-1"><img src="{{URL::to('/')}}/herasat004.png" class="rounded-circle" style="width:30%;height:50%"><p style="color: white;text-align: center;font-family: Tahoma;font-size: small">{{$full_name}}</p></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2" style="height:550px">
        <div class="col-12">
           <div class="row" style="margin-top:3px;height: 100px">
               <div class="col-3">
                   <a href="/herasat2">
                       <img src="exit003.png" id="report" class="reza2" data-toggle="tooltip" data-placement="bottom" title="بازگشت">
                   </a>
               </div>
               <div class="col-6" style="background: rgba(0, 45, 90, 0.7);border-radius: 8px;height:80%;font-size: smaller">
                   <div class="row" style="border-radius: 5px;height:100%;margin-top:0px">
                       <div class="col">
                           <a href="/report_people1">
                               <img src="{{URL::to('/')}}/reports.png" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید گزارشات مورد نظر خود را تهیه کنید">
                           </a>
                       </div>
{{--                       <div class="col">--}}
{{--                           <img src="./edit_enter_exit.png" id="sixth_report2" class="reza2" data-toggle="tooltip" data-placement="left" title="ایجاد تغییر در اطلاعات ورود و خروج">--}}
{{--                       </div >--}}
                       <div class="col">
                           <img src="{{URL::to('/')}}/total3.png" id="total" class="reza2" data-toggle="tooltip" data-placement="left" title="مشاهده کلیه درخواستها جهت اعمال تغییرات">
                       </div >
                       <div class="col">
                           <img src="{{URL::to('/')}}/person_search002.png" id="present" class="reza2" data-toggle="tooltip" data-placement="left" title="مشاهده افراد حاضر در نیروگاه">
                       </div >
                       <div class="col">
                           <img src="{{URL::to('/')}}/enter010.jpg" id="for_requester2" class="reza2" data-toggle="tooltip" data-placement="left" title="موارد تایید نشده توسط شما">
                       </div >
                       <div class="col">
                           <img src="{{URL::to('/')}}/nono.jpg" id="for_requester" class="reza2" data-toggle="tooltip" data-placement="left" title="موارد تایید نشده توسط شما">
                       </div>
                       <div class="col">
                           <img src="{{URL::to('/')}}/modir004.jpg" id="for_modir" class="reza2" data-toggle="tooltip" data-placement="left" title="از اینجا می توانید مواردی را که هنوز توسط مدیر نیروگاه مورد بررسی قرار نگرقته مجددا به کارتابل موارد دریافتی برگردانید">
                       </div>
                       <div class="col">
                           <img src="{{URL::to('/')}}/sent.jpg" id="first_report" class="reza2" data-toggle="tooltip" data-placement="left" title="لیست درخواستهای مجوز ورود که از طرف امور حراست شده اند">
                       </div>
                   </div>
               </div>
               <div class="col-3"></div>
           </div>
        </div>
    </div>
    <div class="row" style="height: 100%;text-align: center">
        <div class="col-12 " >
            <div class="row" style="border-radius: 5px;height: 100%;width: 70%;">
                <div class="col" style="text-align: center">@yield('content')</div>
            </div>
        </div>
    </div>

</div>
<!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
</body>
</html>
