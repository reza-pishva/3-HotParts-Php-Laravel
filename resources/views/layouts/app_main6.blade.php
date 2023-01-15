<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" href="bootstrap.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mapna Group') }}</title>
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
            cursor: pointer;
        }
        img.reza2
        {
            opacity: 0.7;
            filter: alpha(opacity=100);
        }
        img.reza20
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            width:100%;
            height:100%;
            margin-top: 16px;
        }
        img.reza20:hover
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            width:100%;
            height:100%;
            margin-top: 16px;
            cursor: pointer;
        }
        img.reza3:hover
        {
            opacity: 1.0;
            filter: alpha(opacity=100);
            outline: 2px solid white;
            outline-offset: 1px;
            cursor: pointer;
        }
        img.reza3
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            opacity: 0.7;
            filter: alpha(opacity=100);
            width:53px;
            height:53px;
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
            background: url('Key Rules For Preventive and Predictive Maintenance System Setup.jpg') no-repeat fixed;
            background-size: cover;
            backdrop-filter: brightness(20%);
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
        @font-face {
            src: url('font/Sahel-Bold-WOL.ttf');
            font-family: "reza";
        }
    </style>
    <!-- Styles -->
{{--    <link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $.ajax({
                url: '/mygroup',
                method:'GET',
                success: function (response) {
                    var admin_link='';
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==278){
                            admin_link = $('<li class="nav-item"><a id="admin" class="nav-link" href="https://stnt.mapnaom-kz.com/groupcreate">پنل مدیریت</a></li>');
                            break;
                        }
                        admin_link = $('<li class="nav-item"><a hidden id="admin" class="nav-link" href="https://stnt.mapnaom-kz.com/groupcreate">پنل مدیریت</a></li>');
                    }
                    $('#menu_ul').append(admin_link)
                }
            })
        });
    </script>

</head>
<body>

<div class="container-fluid">

    <div class="row justify-content-center" style="width: 100%;margin: auto;height:700px">
        <div class="row" style="width: 100%;height: 200px">
            <div class="col-2" style="height: 110px">
                    <a href="/home">
                        <img src="exit100.png" id="btn_tamirat" style="width: 30px;height: 30px;margin-top: 10px;border-radius: 25px">
                    </a>
            </div>
            <div class="col-5" style="height: 110px"></div>
            <div class="col-5" style="height: 110px">
                <div style="height:90%;width: 70%;border-radius: 5px;background-color: #345764;margin-top: 25px;text-align: center;padding-top: 15px;margin-left: 150px">
                    <p style="font-family: reza;font-size: 20px;color: white;font-weight: bold">نرم افزار مدیریت سوابق قطعات داغ</p>
                    <p style="font-family: reza;font-size: 15px;color: white;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p>
                </div>
            </div>
        </div>
        <div class="row" style="width: 100%;height: 400px;padding-top: 20px">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row justify-content-center mt-1" style="width:100%;margin: auto;height:330px">
                    <div class="col-2" style="height: 50%">
                    </div>
                    <div class="col-4" style="height: 50%">
                        <div id="mit" style="margin: auto;width: 100%;height: 150px;">
                            <a href="/m-savabegh">
                                <img src="download (1).jpg" id="btn_tamirat" class="reza20 reza2">
                            </a>
                        </div>
                    </div>
                    <div class="col-4" style="height: 50%">
                        <div id="ans" style="margin: auto;width: 100%;height: 150px">
                            <a href="/savabegh">
                                <img src="newshome.jpg" id="btn_tamirat" class="reza20 reza2">
                            </a>
                        </div>
                    </div>
                    <div class="col-2" style="height: 50%">
                    </div>

                </div>
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row" style="width: 100%;height: 90px">
            <div class="col-2">

            </div>
            <div class="col-8"></div>
            <div class="col-2" style="margin-top: -15px;color: white"><p>Powered by Reza Pishva</p></div>
        </div>
    </div>



</div>
</body>
</html>
