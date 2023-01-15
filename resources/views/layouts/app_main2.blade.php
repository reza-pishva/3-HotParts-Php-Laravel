<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{URL::to('/')}}/jquery.min.js"></script>
    <script src="{{URL::to('/')}}/popper.min.js"></script>
    <script src="{{URL::to('/')}}/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{URL::to('/')}}/bootstrap.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mapna Group') }}</title>
<style>
    .name
    {
        width: 70%;
        font-family: Tahoma;
        font-size: small;
        color: black;
        text-align: right;
    }
    .number
    {
        width: 30%;
        font-family: Tahoma;
        font-size: small;
        color: black;
        text-align: right;
    }
    th,tr,td
    {
        font-family: Tahoma;
        font-size: small;
        color: white;
    }
    img.reza10:hover
    {
        opacity: 1.0;
        filter: alpha(opacity=100);
        outline: 2px solid white;
        outline-offset: 1px;
        width:100px;
        height:100px;
        cursor: pointer;
    }
    img.reza10
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
    img.reza4:hover
    {
        opacity: 1.0;
        filter: alpha(opacity=100);
        outline: 2px solid white;
        outline-offset: 1px;
        /*width:75px;*/
        /*height:75px;*/
        cursor: pointer;
    }
    img.reza4
    {
        border: 1px solid rgb(14,53,126);
        border-radius: 15px;
        opacity: 0.7;
        filter: alpha(opacity=90);
        width:60px;
        height:60px;
        margin: auto;
        margin-top: 7px;
    }
    div.card{
        height: 370px;
    }
    li a
    {
        color: white;
        font-size: small;
    }
    li.nav-item
    {
        margin-right: 30px;
    }
    body
    {
        margin:0;
        text-align: center;
        background-image: url('{{URL::to('/')}}/bg001.jpg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        backdrop-filter: brightness(40%);
    }
    #banner
    {
        width: 100%;
        height:95px;
        margin-top: 3px;
        border-radius: 5px;
    }
    #banner_text1
    {
        color: white;
        text-align: right;
        margin-top: 10px;
        font-family: Tahoma;
        font-size: large;
        font-weight: bold
    }
    #banner_text2
    {
        color: white;
        text-align: right;
        font-family: Tahoma;
        font-size: small;
        font-weight: bold
    }
    .carousel_img
    {
        border-radius: 5px;
        width:100% ;
        height:380px
    }
    #login_title_div
    {
        width: 100%;
        height: 30px;
        border-radius: 5px;
        padding-top: 1px;
    }
    #login_title_text
    {
        font-family: Tahoma;
        font-size: small;
        color: white;
        margin-top:3px;
    }
    #login_icons_div
    {
        background: rgba(171, 205, 239, 0.3);
        height: 350px;
        border-radius: 5px;
        margin-top: 2px
    }
    #pro_desc_div
    {
        margin-top: 100px;
        height: 160px;
        border-radius: 5px
    }
    #pro_desc_text
    {
        font-family: Tahoma;
        font-size: small;
        color:white;
        text-align: right;
        direction: rtl;
        text-indent: 10px;
        line-height:1.7;
    }
    #pro_title_div
    {
        width: 100%;
        height: 25px;
        margin: auto;
        border-radius: 10px
    }
    #pro_title_text
    {
        font-family: Tahoma;
        font-size: small;
        color: white;
        margin-top: 5px;
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
    <div class="row justify-content-center" style="height: 100px">
        <div class="col-12">
            <div class="bg-dark" id="banner">
                <div class="row justify-content-center" style="height: 100px">
                    <div class="col-2"><img src="{{URL::to('/')}}/mapna.jpg" class="rounded-circle mt-3 ml-3" alt="Cinque Terre"></div>
                    <div class="col-1"></div>
                    <div class="col-1"></div>
                    <div class="col-1"></div>
                    <div class="col-5"><p id="banner_text1">نیروگاه سیکل ترکیبی کازرون</p><p id="banner_text2">پورتال جامع نرم افزارهای مورد استفاده در نیروگاه</p></div>
                    <div class="col-1"></div>
                    <div class="col-1"></div>
                </div>

            </div>
        </div>
    </div>

                <nav class="navbar navbar-expand mt-0 bg-info rounded col-12" style="height: 30px;direction: rtl">
                    <ul id="menu_ul" class="navbar-nav" >
                        <li class="nav-item">
                            <a class="nav-link" href="/home">صفحه اصلی</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal10">معرفی نیروگاه</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal11">تماس با ما</a>
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
                                <img src="{{URL::to('/')}}/13.jpg" class="carousel_img">
                            </div>
                            <div class="carousel-item">
                                <img src="{{URL::to('/')}}/14.jpg"  class="carousel_img">
                            </div>
                            <div class="carousel-item">
                                <img src="{{URL::to('/')}}/16.jpg" class="carousel_img">
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
                      <div  class="bg-info" id="login_title_div">
                          <p id="login_title_text">ورود و ثبت نام</p>
                      </div>
                      <div id="login_icons_div">
                          <div class="container" >
                              <div class="row" >
                                  <div class="col-12" style="margin-top: 1px">
                                      <a href="/login">
                                          <img src="{{URL::to('/')}}/login001.png" class="reza4" data-toggle="tooltip" data-placement="right" title="ورود  login">
                                      </a>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <a href="/user-reg">
                                          <img src="{{URL::to('/')}}/reg001.png" class="reza4" data-toggle="tooltip" data-placement="right" title="ثبت نام Register">
                                      </a>
                                  </div>

                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <a href="/undercons" data-toggle="modal" data-target="#myModal12">
                                          <img src="{{URL::to('/')}}/forget001.png" class="reza4" data-toggle="tooltip" data-placement="right" title="فراموشی رمز عبور">
                                      </a>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <a href="/changepass">
                                          <img src="{{URL::to('/')}}/change_password.png" class="reza4" data-toggle="tooltip" data-placement="right" title="تغییر کلمه عبور">
                                      </a>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-12">
                                      <a href="/out">
                                          <img src="{{URL::to('/')}}/logout.png" class="reza4" data-toggle="tooltip" data-placement="right" title="logout">
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
               </div>
            </div>
        </div>

        <div class="row" style="margin-top: 50px">
            <div class="col-4">
                <div id="pro_desc_div">
                    <p id="pro_desc_text">در این بخش کلیه نرم افزارهای مورد استفاده در نیروگاه کازرون بصورت متمرکز قابل دسترسی است. این نرم افزارها مواردی چون سیستم آمار و دفاتر گزارش بخشهای مختلف و نیز مدیریت اسناد و بسیاری از موارد مورد استفاده همکاران در امور مالی و اداری را پوشش می دهد.برای این نرم افزارها سطوح دسترسی متناسب با نیاز همکاران تعریف شده که توسط مدیر سیستم اعمال گردیده است</p>
                </div>
            </div>
            <div class="col-8">

                <div id="pro_title_div" class="bg-info">

                        <p id="pro_title_text">نرم افزارهای مورد استفاده در نیروگاه</p>

                </div>
                <div style="background: rgba(171, 205, 239, 0.3);border-radius: 10px;margin-top: 2px;height: 250px">
                  <div class="row" style="height: 100px;margin-top: 30px">
                    <div class="col-12" style="border-radius: 5px;height: 60px;text-align: center">
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-2">
                                    <a href="http://172.28.232.13:833">
                                        <img src="{{URL::to('/')}}/statistic001.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="سیستم آمار نیروگاه">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="https://bahrebardari.mapnaom-kz.com">
                                        <img src="{{URL::to('/')}}/public/notebook2.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="دفاتر گزارش روزانه">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="/undercons">
                                        <img src="{{URL::to('/')}}/doc_management.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="مدیریت اسناد">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="/herasat">
                                        <img src="{{URL::to('/')}}/cargo01.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="نرم افزار مدیریت ورود و خروج قطعات و کالا">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="https://rahkaran.mapnaom.com/OM3g/x47ad57c0/Authentication/Login.aspx?ReturnUrl=%2fOM3g%2fx47ad57c0%2f%3frnd%3d8d7c42c6e65d969">
                                        <img src="{{URL::to('/')}}/accounting.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="نرم افزارهای امور مالی">
                                    </a>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </div>
                  </div>
                  <div class="row" style="height: 100px;margin-top: 30px">
                    <div class="col-12" style="border-radius: 5px;height: 60px;text-align: center">
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-2">
                                    <a href="/undercons">
                                        <img src="{{URL::to('/')}}/chemistry.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="سیستم آمارشیمی نیروگاه">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="/undercons">
                                        <img src="{{URL::to('/')}}/quality.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="تضمین کیفیت">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="/undercons">
                                        <img src="{{URL::to('/')}}/lakshit.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="اطلاعات لاک شیت">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="/undercons">
                                        <img src="{{URL::to('/')}}/hse.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="HSE">
                                    </a>
                                </div>
                                <div class="col-2">
                                    <a href="https://automation.mapnaom-kz.com">
                                        <img src="{{URL::to('/')}}/automation2.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="اتوماسیون اداری">
                                    </a>
                                </div>
                                <div class="col-1"></div>
                            </div>
                        </div>
                  </div>
                </div>


            </div>


        </div>
        <div style="width: 100%;height: 3px;margin: auto;border-radius: 20px;margin-top:5px" class="bg-info">.</div>

        <div class="row bg-dark" style="margin-top: 50px;border-radius: 5px">
            <div class="col-7 bg-dark mt-2" style="text-align: right;height: 370px;border-radius: 5px;"><p style="font-family: Tahoma;font-size:10pt;direction: rtl;color: white;margin-top: 23px;text-indent: 10px;line-height:1.7;"><img src="{{URL::to('/')}}/mapna04.jpg" style="width:370px;height:250px;margin-right:15px;float: left;margin-top: 5px;border-radius: 10px">گروه مپنا از آغاز بنیانگذاری در سال ۱۳۷۱، اجرای نزدیک به ۱۰۰ پروژه به ارزش بیش از ۳۰ میلیارد یورو را در کارنامهٔ خود ثبت نموده‌است. افزون بر آن ۶۰ محصول گوناگون و ۸۵ نوع خدمات مختلف را به مشتریان خود عرضه می‌کند.

                    مپنا، از سال ۱۳۸۶ وارد فعالیت در زمینهٔ پروژه‌های نفت و گاز نیز شده‌است. پروژه‌های حفاری چاه‌های نفت در خشکی و پروژهٔ تبدیل گاز به برق به نام پروژهٔ میدان گازی فروز B در محل ۴۵ کیلومتری جنوب شرقی جزیرهٔ کیش واقع در خلیج فارس از جمله این فعالیت‌ها به‌شمار می‌روند</p></div>
            <div class="col-5 bg-dark mt-2" style="text-align: right;height: 370px;border-radius: 5px">
                <img src="{{URL::to('/')}}/mapna002.jpg" style="width:430px;height:350px;margin:auto;margin-top: 8px;border-radius: 10px">
            </div>
        </div>
    </div>

    <div class="row bg-dark" style="margin: auto;border-radius: 5px;margin-top: 60px">
                    <div class="col-3"></div>
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
<div class="modal fade mt-3" id="myModal10" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist3" style="margin-top: 100px;margin-left: 600px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 550px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">معرفی نیروگاه</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10">.</div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <!-- List -->
            <div class="container"  style="margin: auto;background: rgb(171, 205, 239);width: 550px ;height: 400px;;overflow-y: scroll">
                <p style="font-family: Tahoma;font-size:10pt;direction: rtl;color: black;margin-top: 12px;text-align: right;direction: rtl">                    نیروگاه کازرون در زمینی به مساحت 100 هکتار در کیلومتر 12 جاده فراشبند واقع در جنوب شرقی شهرستان کازرون بنا شده است . فاز اول نیروگاه متشکل از دو واحد گازی ساخت شرکت میتسوبیشی ژاپن مدل MW701D در تابستان 1373 مورد بهره برداری قرار گرفت.
                    <img src="https://stnt.mapnaom-kz.com/public/kz.png" alt="Pineapple" style="width:280px;height:250px;margin-right:15px;float: left;margin-top: 5px;border-radius: 10px">فاز دوم در زمستان سال1379 با نصب چهار واحدگازی مدل V94.2 محصول شرکت ایران و ایتالیا آغاز و درسالهای 1381 و 1382 وارد مدار گردیدند. قدرت اسمی واحدهای میتسوبیشی درشرایط ISO  128.5  و واحدهای V94.2 ، 159 مگاوات است که در مجموع ظرفیت اسمی کل واحدهای نیروگاه به 893 مگاوات می رسد . شایان ذکر است اولین توربین گازی و اولین ژنراتور ساخت ایران در این نیروگاه نصب شده است . فاز سوم نیروگاه شامل سه واحد بخار هر کدام به ظرفیت 160 مگاوات محصول مشترک ایران و آلمان می باشد که اولین واحد آن اواخر سال 1385 و  دو واحد دیگر در سال 1386 به بهره برداری رسید.
                    پس از ورود واحدهای بخار به مدار قدرت اسمی این نیروگاه در حال حاضر به 1373 مگاوات رسیده است</p>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:550px"></div>

        </div>
    </div>
</div>
<div class="modal fade mt-3" id="myModal11" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist3" style="margin-top: 100px;margin-left: 600px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 550px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">تماس با ما</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10">.</div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <!-- List -->
            <div class="container"  style="margin: auto;background: rgb(171, 205, 239);width: 550px ;height: 400px;;overflow-y: scroll;">
                <table class="table table-striped" >
                    <thead>
                    <tr >
                        <th style="color: black;text-align: right">نام </th>
                        <th style="color: black;text-align: right">شماره</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="name">آقاي مهندس عبدالرضا داودي</td>
                        <td class="number">2232-2235</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهدي عارف</td>
                        <td class="number">2233-2235</td>
                    </tr>
                    <tr>
                        <td class="name">خانم مهندس فاطمه بحراني كازروني</td>
                        <td class="number">2240</td>
                    </tr>
                    <tr>
                        <td class="name">اپراتور گويا</td>
                        <td class="number">2201-2200</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس يداله بهمني تادواني</td>
                        <td class="number">2234</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس منوچهر مولوديان</td>
                        <td class="number">2209</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: محمدرضا كياني، سعيد محمدزاده، حسين عباسپور و سردار نوروزي</td>
                        <td class="number">2303</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: ابراهيم بازيار، پيشوا و موسوي</td>
                        <td class="number">2277</td>
                    </tr>
                    <tr>
                        <td class="name">تكنسين هاي گازي و بويلر آنسالدو امور بهره برداري</td>
                        <td class="number">2217</td>
                    </tr>
                    <tr>
                        <td class="name">اتاق فرمان یونیت</td>
                        <td class="number">2262</td>
                    </tr>
                    <tr>
                        <td class="name">پرسنل بهره برداری کولینگ</td>
                        <td class="number">2230-2567-2565</td>
                    </tr>
                    <tr>
                        <td class="name">آقای مهندس سید رحمت اله موسوی</td>
                        <td class="number">2226</td>
                    </tr>
                    <tr>
                        <td class="name">آقای مهندس سید محمد رضا موسوی</td>
                        <td class="number">2255-2207</td>
                    </tr>
                    <tr>
                        <td class="name">آقای مهندس سید محمدرضا موسوی</td>
                        <td class="number">2223</td>
                    </tr>
                    <tr>
                        <td class="name">آقایان مهندسین پیمان قدمگاهی عباس دهقان محمد نیکوخلق امیر نیک زاده</td>
                        <td class="number">2223-2247-2208</td>
                    </tr>
                    <tr>
                        <td class="name">آقایان مهندس مجتبی عرب زاده- مجتبی آدینه-دلجو-احسان شمس الدینی و قرائی</td>
                        <td class="number">2275-2257</td>
                    </tr>
                    <tr>
                        <td class="name">آقای مهندس حسین تقیان کازرونی</td>
                        <td class="number">2205</td>
                    </tr>
                    <tr>
                        <td class="name">آقایان مهندسین سید ستار هاشمی-محمد مهدی پرویزی-هادی شمشیری</td>
                        <td class="number">2206-2204</td>
                    </tr>

                    <tr>
                        <td class="name">آقايان مهندسين: بهزاد بازايي، هادي نيازي، عبداله عرب زاده، بهروزي و فرشاد يزداني</td>
                        <td class="number">2271-2270</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس جابر پرويزي</td>
                        <td class="number">2315</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: ابوذر گلستان، عبداله بشكار، احمد بشيري و حجت اله بهروزي نيا</td>
                        <td class="number">2312-2313</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: حسن شريفي، ايرج خدارحمي و حمداله زندي لك</td>
                        <td class="number">2285-2287</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان: زردشت يزدي، مرادي نژاد، آبسالان، مختارزاده، قاسم بشكار، رهبر</td>
                        <td class="number">2288</td>
                    </tr>

                    <tr>
                        <td class="name">آقاي محمد (شهرام) داودي</td>
                        <td class="number">2286</td>
                    </tr>
                    <tr>
                        <td class="name">محوطه كارگاه تعميرات مكانيك</td>
                        <td class="number">2305</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس مصطفي صانعي</td>
                        <td class="number">2327</td>
                    </tr>
                    <tr>
                        <td class="name">پرسنل پست ٤٠٠/٢٣٠ كيلو ولت</td>
                        <td class="number">2332-2325</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس رهنمايي</td>
                        <td class="number">2325</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس عباس نراقي</td>
                        <td class="number">2216</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: علي اكبر جواني و غلامرضا داودي</td>
                        <td class="number">2254-2329</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس محمدرضا زماني</td>
                        <td class="number">2232</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس رضا اسعدي</td>
                        <td class="number">2218</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس الماس بهارلويي</td>
                        <td class="number">2340</td>
                    </tr>


                    <tr>
                        <td class="name">آقاي مهندس مهدي فتحي پور</td>
                        <td class="number">2236</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس رضا ديهيم</td>
                        <td class="number">2339</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس مهدي زارع</td>
                        <td class="number">2342</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس ذبيح اله مهبودي</td>
                        <td class="number">2328</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس فضل اله ظاهرفرد</td>
                        <td class="number">2343</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس محمد رحيم خير</td>
                        <td class="number">2304</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس وحيد خداكرمي</td>
                        <td class="number">2219</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس محسن خيراتي</td>
                        <td class="number">2214</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس روح اله كريمي فرد</td>
                        <td class="number">2227</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس سياوش جوكار</td>
                        <td class="number">2238</td>
                    </tr>
                    <tr>
                        <td class="name">خانم مهندس مهسا حسيني نژاد</td>
                        <td class="number">2246</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: علي پاكوهي، مسعود كاوياني نيا، حسين كيخا و محمد علي جويا</td>
                        <td class="number">2284</td>
                    </tr>
                    <tr>
                        <td class="name">آقاي مهندس هشام دمستاني</td>
                        <td class="number">2274</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: روشن، ترابي، حسين زاده</td>
                        <td class="number">2289</td>
                    </tr>
                    <tr>
                        <td class="name">آقايان مهندسين: شمس الديني، وزيري، والي، مولا، چراغي، قاسمي وعلي محمدي</td>
                        <td class="number">2512-2212</td>
                    </tr>

                    </tbody>
                </table>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-primary" style="height: 20px;width:550px"></div>

        </div>
    </div>
</div>
<!-- Edit form -->
<div class="modal fade mt-3" id="myModal12" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="passrecovery" style="margin-top: 300px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">بازیابی کلمه عبور</p></div>
                    <div class="col-6">
                        <div class="row" style="width: 100%">
                            <div class="col-10">.</div>
                            <div class="col-2">
                                <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

            <!-- Edit form -->
            <div class="container" id="reason_win" style="margin: auto;background-color:lightgray ">
                <form method="post" encType="multipart/form-data" id="recovery_form_request" action="{{route('editform4.edit')}}">
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col mt-2">
                            <div class="form-group">
                                <input type="text" class="form-control" id="name"  name="name" placeholder="نام کاربری خود را وارد کنید" required title="لطفا نام کاربری را وارد کنید" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px">
                            </div>
                        </div>
                        <div class="col" style="margin-top: 20px">
                            <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">دریافت کلمه عبور</button>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px">

            </div>

        </div>
    </div>
</div>
</body>
</html>
