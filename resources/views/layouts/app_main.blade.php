<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>
    <script>
        $( function() {
            $( "#tabs" ).tabs();
        } );
        // $( function() {
        //     $( "#accordion" ).accordion();
        // } );
    </script>
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
        th,tr,td
        {
            font-family: Tahoma;
            font-size: small;
            color: white;
        }
        img.reza2:hover
        {
            opacity: 1.0;
            filter: alpha(opacity=100);
            outline: 2px solid white;
            outline-offset: 1px;
            width:100px;
            height:100px;
            cursor: pointer;
        }
        img.reza2
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            opacity: 0.7;
            filter: alpha(opacity=100);
            width:80px;
            height:80px;
            margin-top: 10px;
            margin-left: 35px;
        }
        img.reza3:hover
        {
            opacity: 1.0;
            filter: alpha(opacity=100);
            outline: 2px solid white;
            outline-offset: 1px;
            width:100px;
            height:100px;
            cursor: pointer;
        }
        img.reza3
        {
            border: 1px solid rgb(14,53,126);
            border-radius: 15px;
            opacity: 0.7;
            filter: alpha(opacity=100);
            width:80px;
            height:80px;
            margin: auto;
            margin-top: 25px;
        }
        div.card{
            height: 370px;
        }
        li a
        {
            color: white;
            font-size: small;
        }
        li.nav-item{
            margin-right: 30px;
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

                <nav class="navbar navbar-expand mt-0 bg-info rounded col-12" style="height: 30px;direction: rtl">
                    <ul class="navbar-nav" >
                        <li class="nav-item">
                            <a class="nav-link" href="/home">صفحه اصلی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">معرفی نیروگاه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">معرفی نرم افزار</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">تماس با ما</a>
                        </li>

                    </ul>
                </nav>


    <div class="container">
        <div class="row" style="height: 380px">
            <div class="col-10 mt-3">
                 <div id="demo" class="carousel slide" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1"></li>
                            <li data-target="#demo" data-slide-to="2"></li>
                        </ul>

                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{URL::to('/')}}/13.jpg"  width=100% height="380" style="border-radius: 5px">
                            </div>
                            <div class="carousel-item">
                                <img src="{{URL::to('/')}}/14.jpg"  width=100% height="380" style="border-radius: 5px">
                            </div>
                            <div class="carousel-item">
                                <img src="{{URL::to('/')}}/16.jpg"  width=100% height="380" style="border-radius: 5px">
                            </div>
                        </div>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#demo" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#demo" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
            </div>
            <div class="col-2 mt-3" style="margin: auto">
              <div class="row" style="margin-top:3px">
                  <div class="col-12">
                      <div  class="bg-info" style="width: 100%;height: 25px;border-radius: 5px;padding-top: 1px;">
                          <p style="font-family: Tahoma;font-size: small;color: white">گزارشات پر کاربرد</p>
                      </div>
                      <div style="background-color: darkgrey;backdrop-filter: opacity(30%);height: 350px;border-radius: 5px;margin-top: 2px">
                          <img src="{{URL::to('/')}}/enter011.jpg" class="reza3" data-toggle="tooltip" data-placement="left" title="مواردی که مجوز خروج از نیروگاه را دارند">
                          <img src="{{URL::to('/')}}/enter001.png" class="reza3" data-toggle="tooltip" data-placement="left" title="مواردی که مجوز ورود به نیروگاه را دارند">
                          <img src="{{URL::to('/')}}/enter010.jpg" class="reza3" data-toggle="tooltip" data-placement="left" title="مواردی که برای ورود یا خروج مجوز نگرفته اند">
                      </div>
                  </div>
              </div>
            </div>
        </div>
        <div class="row" style="height: 150px;margin-top: 30px">
                <div style="width: 60%;height: 3px;margin: auto;border-radius: 20px" class="bg-info">.</div>
                <div class="col-12" style="border-radius: 5px;height: 90px;text-align: center">

                    <a href="{{URL::to('/')}}/requester">
                        <img src="{{URL::to('/')}}/requester001.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="درخواست کننده مجوز ورود یا خروج قطعات  به نیروگاه">
                    </a>
                    <a href="{{URL::to('/')}}/first-reciever">
                        <img src="{{URL::to('/')}}/modir001.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="سرپرست مستقیم فرد درخواست کننده مجوز">
                    </a>
                    <a href="{{URL::to('/')}}/second-reciever">
                        <img src="{{URL::to('/')}}/herasat004.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="مسئول حراست در اینجا درخواست مجوز را تایید و برای مدیر نیروگاه ارسال می کند">
                    </a>
                    <a href="{{URL::to('/')}}/third-reciever">
                        <img src="{{URL::to('/')}}/modir004.jpg" class="reza2" data-toggle="tooltip" data-placement="bottom" title="مدیر نیروگاه درخواست مجوز را تایید نهایی می کند و به حراست نیروگاه انتقال می دهد">
                    </a>
                    <a href="{{URL::to('/')}}/fourth-reciever">
                        <img src="{{URL::to('/')}}/herasat005.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="حراست نیروگاه درمورد قطعات و یا تجهیزاتی که مجوز ورود یا خروج آنها اخذ شده اجازه انتقال می دهند">
                    </a>


                </div>
                <div style="width: 60%;height: 3px;margin: auto;border-radius: 20px;margin-top:5px" class="bg-info">.</div>
            </div>
        <div class="row" style="height: 500px;margin-top: 60px">
            <div class="col-12">
                <div class="container">
                    <h6 style="color: white;font-family: Tahoma;font-weight: bold">کلیه درخواستهای یک ماه اخیر</h6>
                    <p style="color: white;font-family: Tahoma;font-size: small">این موارد در یک ماه گذشته جهت خروج از نیروگاه مجوز مدیریت نیروگاه را اخذ کرده اند</p>
                    <table class="table table-dark table-hover" style="direction: rtl;border-radius: 10px">
                        <thead>
                        <tr class="bg-info" style="border-radius: 10px">
                            <th>شماره درخواست</th>
                            <th>تاریخ</th>
                            <th>شرح درخواست</th>
                            <th>نوع قطعه</th>
                            <th>شماره جمعداری</th>
                            <th>بخش درخواست کننده</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $request)
                            <tr style="color:black;text-align: center">
                                <td>{{$request['id_exit']}}</td>
                                <td>{{$request['date_request_shamsi']}}</td>
                                <td>{{$request['description']}}</td>
                                <td>{{$goodstypes->where('id_goods_type',$request['id_goods_type'])->first()->description}}</td>
                                <td>{{$request['jamdari_no']}}</td>
                                <td>{{\App\Requestpart::where('id_request_part',$request['id_request_part'])->first()->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row bg-dark" style="margin: auto;border-radius: 5px">
                    <div class="col-3">
                        1
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <div class="col">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d66032.83315615916!2d51.748110945722324!3d29.562284845899754!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3fb3de3a669facab%3A0x654adc71d45ea4bb!2z2YbbjNix2Yjar9in2Ycg2qnYp9iy2LHZiNmG2Iwg2KfYs9iq2KfZhiDZgdin2LHYs9iMINin24zYsdin2YY!5e0!3m2!1sfa!2sde!4v1596814171406!5m2!1sfa!2sde"
                                        width="80%" height="160px" frameborder="0" style="border:0;margin-top: 20px;border-radius: 5px" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                            </div>
                            <div class="col" style="font-family: Tahoma;font-size: small;color: white;direction: rtl">
                                <p style="text-align: right;font-weight: bold;margin-top: 5px">تلفنها و فاکس</p>
                                <hr style="border: 1px solid white">
                                <p style="text-align: right;margin-top: 5px">تلفنها:0714229628 0714228536 </p>
                                <p style="text-align: right"> روابط عمومی : 0714222536 2458</p>
                                <p style="text-align: right"> دبیرخانه : 0714222536 2458</p>
                                <p style="text-align: right"> شماره فاکس : 0714222536 2458</p>
                            </div>

                            <div class="col" style="font-family: Tahoma;font-size: small;color: white;direction: rtl">
                                <p style="text-align: right;font-weight: bold;margin-top: 5px">تماس با ما </p>
                                <hr style="border: 1px solid white">
                                <p style="text-align: right"> آدرس : کیلومتر 5 جاده کازرون شیراز روستای نصیرآباد</p>
                                <p style="text-align: right">نیروگاه سیکل ترکیبی کازرون</p>
                                <hr style="border: 1px solid white">
                                <p style="text-align: right">پست الکترونیکی:rpishva@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
