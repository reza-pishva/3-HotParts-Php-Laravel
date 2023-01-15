@extends('layouts.app_guard2')
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
                    var fifth_reciever_link='';
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==286 || response.results[i]['id_gr']==278){
                            second_reciever_link = $('<a href="/third-reciever-entering" ><img src="./herasat004.png" class="reza2"  data-toggle="tooltip" data-placement="bottom" title="مسئول حراست"></a>');
                            break;
                        }
                        second_reciever_link = $('<a  href="#"><img src="./herasat004.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="مسئول حراست" ></a>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==284 || response.results[i]['id_gr']==278){
                            first_reciever_link = $('<a href="/first-reciever-entering" ><img src="./modir001.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="مسئول مستقیم"></a>');
                            break;
                        }
                        first_reciever_link = $('<a  href="#"><img src="./modir001.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="مسئول مستقیم" ></a>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==283 || response.results[i]['id_gr']==278){
                            requester_link = $('<a href="/enteringfirstrequester" ><img src="./requester001.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="درخواست کننده ورود افراد"></a>');
                            break;
                        }
                        requester_link = $('<a  href="#"><img src="./requester001.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="درخواست کننده ورود افراد"></a>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==288 || response.results[i]['id_gr']==278){
                            fourth_reciever_link = $('<a href="/fourth-reciever-entering" ><img src="./herasat005.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="حراست نیروگاه"></a>');
                            break;
                        }
                        fourth_reciever_link = $('<a  href="#"><img src="./herasat005.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="حراست نیروگاه"></a>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==287 || response.results[i]['id_gr']==278){
                            third_reciever_link = $('<a href="/second-reciever-entering" ><img src="./modir004.jpg" class="reza2" data-toggle="tooltip" data-placement="bottom" title="مدیر نیروگاه"></a>');
                            break;
                        }
                        third_reciever_link = $('<a  href="#"><img src="./modir004.jpg" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="مدیر نیروگاه"></a>');
                    }
                    for (var i = 0; i < response.results.length; i++) {
                        if(response.results[i]['id_gr']==285 || response.results[i]['id_gr']==278){
                            fifth_reciever_link = $('<a href="/imeni-reciever-entering" ><img src="./imeni002.png" class="reza2" data-toggle="tooltip" data-placement="bottom" title="مسئول ایمنی"></a>');
                            break;
                        }
                        fifth_reciever_link = $('<a  href="#"><img src="./imeni002.png" class="reza3"  data-toggle="tooltip" data-placement="bottom" title="مسئول ایمنی"></a>');
                    }


                    $('#requester').append(requester_link)
                    $('#first_reciever').append(first_reciever_link)
                    $('#second_reciever').append(second_reciever_link)
                    $('#third_reciever').append(third_reciever_link)
                    $('#fourth_reciever').append(fourth_reciever_link)
                    $('#fifth_reciever').append(fifth_reciever_link)


                }
            })
        })
    </script>
    <div class="container" style="border-radius: 5px;width: 30%;height: 30%;background: rgba(171, 205, 239, 0.3)">
        <div class="row mt-1" style="height: 50%">
            <div class="col-4 " id="requester" ></div>
            <div class="col-4 " id="first_reciever" ></div>
            <div class="col-4" id="fifth_reciever" ></div>
        </div>
        <div class="row" style="height: 50%">
            <div class="col-4 " id="second_reciever" ></div>
            <div class="col-4" id="third_reciever" ></div>
            <div class="col-4" id="fourth_reciever" ></div>
        </div>
    </div>
@endsection
