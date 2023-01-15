<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
{{--    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>--}}
{{--    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>--}}
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
        .common_text {
            font-family: Tahoma;
            font-size: small;
            color: white;
            font-size: small;
            margin-right: 15px;
            margin-top: 20px;
            text-align: right;
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
                    <div class="col-5"><p style="color: white;text-align: right;margin-top: 10px;font-family: Tahoma;font-size: large;font-weight: bold">نیروگاه سیکل ترکیبی کازرون</p><p style="color: white;text-align: right;font-family: Tahoma;font-size: small;font-weight: bold"> پورتا جامع نرم افزارهای مورد استفاده در نیروگاه</p></div>
                    <div class="col-2 mt-3"></div>
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
    <div class="row" style="height: 660px;margin-top: 60px;">

                    @yield('content')

    </div>

</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
