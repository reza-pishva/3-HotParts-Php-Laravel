<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mapna Group') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script>
        $(document).ready(function(){
            $('.btnprn1').printPage();
            $('.btnprn2').printPage();
        })
    </script>
    <style>
        table {
            border-collapse: collapse;
        }
        /*table, th, td {*/
        /*    border-bottom: 1px solid black;*/
        /*}*/
        #request_table tr
        {
            text-align : center;
            font-family: Tahoma;
            font-size: small;
            color: black;
        }
        p{
            text-align : center;
            font-family: Tahoma;
            font-size: medium;
            color: blue;
        }
        .title{
            text-align : center;
            font-family: Tahoma;
            font-size: small;
            color: black;
        }
        th{
            text-align : right;
            font-family: Tahoma;
            font-size: small;
            color: black;
        }
    </style>
</head>
<body style="margin:0;text-align: center;">
<div class="container-fluid">
    <div class="row" style="height: 660px;margin-top: 60px;text-align: center">
        <div class="col-1"></div>
        <div class="col-10">@yield('content')</div>
        <div class="col-1"></div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
