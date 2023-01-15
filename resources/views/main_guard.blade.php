@extends('layouts.app_guard')
@section('content')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            $.ajax({
                url: '/mygroup',
                method:'GET',
                success: function (response) {
                    var second_reciever_link='';
                    var first_reciever_link='';
                    var requester_link='';
                    var fourth_reciever_link='';
                    var third_reciever_link='';
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==274 || response.results[i]['id_gr']==278){
                            second_reciever_link = $('<div class="row" ><div class="col-12"><a href="/second-reciever" ><img src="/herasat004.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="مسئول حراست در اینجا درخواست مجوز را تایید و برای مدیر نیروگاه ارسال می کند"></a></div></div>');
                            break;
                        }
                        second_reciever_link = $('<div class="row" ><div class="col-12"><a  href="#"><img src="./herasat004.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="مسئول حراست در اینجا درخواست مجوز را تایید و برای مدیر نیروگاه ارسال می کند" ></a></div></div>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==273 || response.results[i]['id_gr']==278){
                            first_reciever_link = $('<div class="row" ><div class="col-12"><a href="/first-reciever" ><img src="https://stnt.mapnaom-kz.com/public/modir001.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="سرپرست مستقیم فرد درخواست کننده مجوز"></a></div></div>');
                            break;
                        }
                        first_reciever_link = $('<div class="row" ><div class="col-12"><a  href="#"><img src="./modir001.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="سرپرست مستقیم فرد درخواست کننده مجوز" ></a></div></div>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==272 || response.results[i]['id_gr']==278){
                            requester_link = $('<div class="row" ><div class="col-12"><a href="/requester" ><img src="https://stnt.mapnaom-kz.com/public/requester001.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="درخواست کننده مجوز ورود یا خروج قطعات به نیروگاه"></a></div></div>');
                            break;
                        }
                        requester_link = $('<div class="row" ><div class="col-12"><a  href="#"><img src="https://stnt.mapnaom-kz.com/public/requester001.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="درخواست کننده مجوز ورود یا خروج قطعات به نیروگاه"></a></div></div>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==276 || response.results[i]['id_gr']==278){
                            fourth_reciever_link = $('<div class="row" ><div class="col-12"><a href="/fourth-reciever" ><img src="https://stnt.mapnaom-kz.com/public/herasat005.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="حراست نیروگاه درمورد قطعات و یا تجهیزاتی که مجوز ورود یا خروج آنها اخذ شده اجازه انتقال می دهند"></a></div></div>');
                            break;
                        }
                        fourth_reciever_link = $('<div class="row" ><div class="col-12"><a  href="#"><img src="./herasat005.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="حراست نیروگاه درمورد قطعات و یا تجهیزاتی که مجوز ورود یا خروج آنها اخذ شده اجازه انتقال می دهند"></a></div></div>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==275 || response.results[i]['id_gr']==278){
                            third_reciever_link = $('<div class="row" ><div class="col-12"><a href="/third-reciever" ><img src="https://stnt.mapnaom-kz.com/public/modir004.jpg" class="reza2" data-toggle="tooltip" data-placement="bottom" title="مدیر نیروگاه درخواست مجوز را تایید نهایی می کند و به حراست نیروگاه انتقال می دهد"></a></div></div>');
                            break;
                        }
                        third_reciever_link = $('<div class="row" ><div class="col-12"><a  href="#"><img src="https://stnt.mapnaom-kz.com/public/modir004.jpg" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="مدیر نیروگاه درخواست مجوز را تایید نهایی می کند و به حراست نیروگاه انتقال می دهد"></a></div></div>');
                    }



                    $('#requester').append(requester_link)
                    $('#first_reciever').append(first_reciever_link)
                    $('#second_reciever').append(second_reciever_link)
                    $('#third_reciever').append(third_reciever_link)
                    $('#fourth_reciever').append(fourth_reciever_link)


                }
            })
        })
    </script>
    <div class="container" style="border-radius: 5px;width: 25%;height: 50%;background: rgba(171, 205, 239, 0.3);">
        <div class="container">
            <div class="row" >
                <div class="col-12">
                    <div class="row mt-1">
                        <div class="col-4 " id="requester"></div>
                        <div class="col-4 " id="first_reciever"></div>
                        <div class="col-4 " id="second_reciever"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row" >
                <div class="col-12">
                    <div class="row" style="margin-top: 30px">
                        <div class="col-4" id="third_reciever"></div>
                        <div class="col-4"></div>
                        <div class="col-4" id="fourth_reciever"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
