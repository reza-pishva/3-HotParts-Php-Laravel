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
        img.reza20
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            width:100%;
            height:100%;
            margin-top: 16px;
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
            <div class="col-3" style="height: 190px">
                <img src="mitsubishi01.jpg" id="btn_tamirat" class="reza20">
            </div>
            <div class="col-3" style="height: 190px">
                <img src="mitsubishi02.jpg" id="btn_tamirat" class="reza20">
            </div>
            <div class="col-3" style="height: 190px">
                <img src="mitsubishi03.jpg" id="btn_tamirat" class="reza20">
            </div>
            <div class="col-3" style="height: 190px">
                <div style="height:60%;width: 80%;border-radius: 5px;background-color: #228383;margin-top: 25px;text-align: center;padding-top: 18px;margin-left: 30px">
                    <p style="font-family: reza;font-size: 25px;color: white;font-weight: bold">مدیریت سوابق قطعات داغ</p>
                </div>
                <div style="height:25%;width: 80%;border-radius: 5px;background-color: #212027;margin-top: 5px;text-align: center;padding-top: 7px;margin-left: 30px">
                    <p style="font-family: reza;font-size: 20px;color: #d0d374;font-weight: bold">میتسوبیشی</p>
                </div>
            </div>
        </div>
        <div class="row" style="width: 100%;height: 400px;padding-top: 20px">
            <div class="col-2">
                <ul class="navbar-nav" >
                    <li class="nav-item">
                        <a href="/fsavabegh">
                            <img src="exit100.png" id="btn_tamirat" style="width: 30px;height: 30px;margin-top: 10px;border-radius: 25px">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-8">
                <div class="row justify-content-center" style="width:100%;margin: auto;height:330px">
                    <div class="row" style="width: 110%">
                        <div class="col" style="border-radius: 5px;text-align: center;background-color: #36528a">
                            <p style="font-family: reza;font-size: 15px;margin-top: 16px;color: white">فرمهای مربوط به تعریف برنامه</p>
                        </div>
                        <div class="col ml-2" style="border-radius: 5px;text-align: center;background-color: #36528a">
                            <p style="font-family: reza;font-size: 15px;margin-top: 16px;color: white">فرمهای مربوط به اطلاعات پایه</p>
                        </div>
                        <div class="col ml-2" style="border-radius: 5px;text-align: center;background-color: #36528a">
                            <p style="font-family: reza;font-size: 15px;margin-top: 16px;color: white">فرمهای مربوط به ثبت سوابق</p>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col" style="height:310px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border-top-left-radius: 5px;border-top-right-radius: 5px;background-color: rgba(104,128,162,0.5)">
                            <div class="row" style="margin-left: 35px">
                                <div class="row mt-1" style="width: 95%;margin-right: 5px">
                                    <div class="col" style="height:85px;">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-tapr-form">
                                                    <img src="perrep.jpg" id="btn_tamirat" class="reza2" data-toggle="tooltip" data-placement="bottom" title="تعمیرات دوره ای">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">تعمیرات دوره ای</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-tasepr-form">
                                                    <img src="parts.png" id="btn_bazsazi" class="reza2" data-toggle="tooltip" data-placement="bottom" title="برنامه ارسال برای بازسازی">
                                                </a>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">بازسازی</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2" style="width: 95%;margin-right: 5px">
                                    <div class="col" style="margin:auto;height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-tain-form">
                                                    <img src="4735794.png" id="btn_anbar" class="reza2" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه ورود و خروج از انبار">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">انبار</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-buy-form">
                                                    <img src="ico-yellow-brand-vehicle-tracking-system-cdr.jpg" id="btn_buy" class="reza2" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه خرید">
                                                </a>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">خرید</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3" style="width: 95%;margin-right: 5px">
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-out-form">
                                                    <img src="97-970395_truck-clipart-green-truck-green-dump-truck-clip-art.png" id="btn_eex" class="reza2" data-toggle="tooltip" data-placement="bottom" title=" ایجاد برنامه ارسال قطعه">
                                                </a>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">ورود و خروج از نیروگاه</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" style="height:85px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col ml-2" style="height:210px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border-top-left-radius: 5px;border-top-right-radius: 5px;background-color: rgba(104,128,162,0.5)">
                            <div class="row" style="margin-left: 35px">
                                <div class="row mt-1" style="width: 95%;margin-right: 5px">
                                    <div class="col" style="height:85px;">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-bazsaz-form">
                                                    <img src="base.png" id="btn_tamirat" class="reza2" data-toggle="tooltip" data-placement="bottom" title="اطلاعات پایه">
                                                </a>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">فرم ورود اطلاعات پایه</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-group-form">
                                                    <img src="addlist.png" id="btn_bazsazi" class="reza2" data-toggle="tooltip" data-placement="bottom" title="فرم ایجاد گروه">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">فرم ایجاد گروه</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3" style="width: 95%;margin-right: 5px">
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-group-change">
                                                    <img src="type.jpg" id="btn_anbar" class="reza2" data-toggle="tooltip" data-placement="bottom" title="فرم جابجایی قطعات گروهها">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">فرم جابجایی قطعات </p>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col" style="text-align: center">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col ml-2" style="height:110px;border-bottom-left-radius: 20px;border-bottom-right-radius: 20px;border-top-left-radius: 5px;border-top-right-radius: 5px;background-color: rgba(104,128,162,0.5)">
                            <div class="row" style="margin-left: 35px">
                                <div class="row mt-1" style="width: 95%;margin-right: 5px">
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-savabegh-form">
                                                    <img src="total.jpg" id="btn_buy" class="reza2" data-toggle="tooltip" data-placement="bottom" title="ثبت سوابق">
                                                </a>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">ثبت سوابق</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col" style="height:85px">
                                        <div class="row" style="margin-top:-10px">
                                            <div class="col" style="text-align: center">
                                                <a href="/m-savabegh-search-by-ide">
                                                    <img src="reports.png" id="btn_eex" class="reza2" data-toggle="tooltip" data-placement="bottom" title="گزارش گیری">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col" style="text-align: center">
                                                <p style="color: #fdfdfe;font-family: Tahoma;font-size:x-small">گزارش گیری</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1" style="width: 95%;margin-right: 5px">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2">

            </div>

        </div>
        <div class="row" style="width: 100%;height: 90px">
            <div class="col-10"></div>
            <div class="col-2" style="margin-top: -15px;color: white"><p>Powered by Reza Pishva</p></div>
        </div>
    </div>



</div>
</body>
</html>
