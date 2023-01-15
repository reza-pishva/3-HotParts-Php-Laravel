@extends('layouts.app_guard4')
@section('content')

    <div class="container" style="border-radius: 5px;width: 55%;height: 53%;background: rgba(171, 205, 239, 0.3)">
        <div class="row mt-0" style="height: 50%">
            <div class="col-3 " id="requester" >
                <a  href="http://172.28.232.13:833/Reports/report_kz6.aspx"><img src="./rand.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبه تولید اکتیو و راکتیو ، گاز و گازوئیل مصرفی و مصرف داخلی و راندمان هر واحد به تفکیک در بازه زمانی انتخابی" ></a>
            </div>
            <div class="col-3 " id="first_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_kz4.aspx"><img src="./production.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبه تولید اکتیو و راکتیو ، گاز و گازوئیل مصرفی و مصرف داخلی و راندمان نیروگاه در بازه زمانی انتخابی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_kz_sookht_type.aspx"><img src="./gass.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبه توان تولیدی و ابراز شده بر حسب سوخت انتخابی و محاسبه اختلاف دو مقدار در بازه زمانی انتخابی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/hour.aspx"><img src="./time.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبه کارکرد ، کارکرد بی باری ، تحت تعمیر ، آماده برای بهره برداری در بازه زمانی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/rand_report.aspx"><img src="./report49.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبه راندمان تولید اکتیو و راکتیو و مصرفی داخلی هر واحد به تفکیک" ></a>
            </div>

            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_kz1.aspx"><img src="./report94.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title=" محاسبات حداکثر و حداقل اکتیو و راکتیو و تاریخ و ساعت مربوطه" ></a>
            </div>

            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_daily_mapna4.aspx"><img src="./report76.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش اول روزانه مپنا" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_daily_mapna7.aspx"><img src="./report87.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش دوم روزانه مپنا داشبورد مدیریتی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_monthly_mapna3.aspx"><img src="./report99.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش ماهانه مپنا" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_monthly_hararati.aspx"><img src="./report123.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش اول برق حرارتی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_monthly_hararati2.aspx"><img src="./report234.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش دوم برق حرارتی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_kz5.aspx"><img src="./amar3.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="مشاهده توضیحات گزارشات روزانه در تاریخهای مختلف" ></a>
            </div>

            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/ab.aspx"><img src="./water.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبات مربوط به آب مصرفی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/igv-media-freq.aspx"><img src="./freq.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبات مربوط به ساعات کنترل فرکانس و IGV و MEDIA در بازه زمانی انتخابی برای هر واحد به تفکیک" ></a>
            </div>
{{--            <div class="col-3" id="fifth_reciever" >--}}
{{--                <a  href="#"><img src="./energy.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="مشاهده گزارشهای تایید شده در تاریخهای مختلف" ></a>--}}
{{--            </div>--}}
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/ready_show_f/fasli_ready_show_kz_f11.aspx"><img src="./energy.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش توان از دست رفته کلیه واحدها ناشی از عوامل داخلی و خارجی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/ready_show_f/fasli_ready_show_kz_f5.aspx"><img src="./report66.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="محاسبات مربوط به نمایه آمادگی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/ready_show_f/fasli_ready_show_kz_f6.aspx"><img src="./report33.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="تست محاسبات نمایه آمادگی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/ready_show_f/fasli_ready_show_kz_f10.aspx"><img src="./code.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="توان از دست رفته ناشی از محدودیتهای مختلف در ساعات و تاریخهای اعمال شده" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/ready_show_f/fasli_ready_show_kz_f9.aspx"><img src="./report44.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش توان تولیدی و ابراز شده و کدهای تخصیصی" ></a>
            </div>
            <div class="col-3" id="fifth_reciever" >
                <a  href="http://172.28.232.13:833/Reports/report_gassoil_60.aspx"><img src="./gass.jpg" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="گزارش گازوئیل مصرفی 60 درجه" ></a>
            </div>
        </div>
    </div>
@endsection
