@extends('layouts.app_requester4')
@section('content')
    <script xmlns:center>
        $(document).ready(function(){
            $("#create_report").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/report_query_people1",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(".reports").remove();
                        var enter_exit=''
                        var with_return=''
                        var id_exit = ''
                        var exit_no = ''
                        var date_request_shamsi = ''
                        var description = ''
                        var condition = ''
                        var l_name = ''
                        var history = ''
                        var t1 = ''
                        var t2 = ''
                        var row =''
                        var row_th = '<tr class="bg-info reports" style="color: white;height: 30px;">' +
                            '<td style="text-align: center;width: 4%;border-left:1px white solid; ">شماره</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;">تاریخ</td>' +
                            '<td style="text-align: center;width: 7%;border-left:1px white solid;">درخواست کننده</td>' +
                            '<td style="text-align: center;width: 5%;border-left:1px white solid;">نوع</td>' +
                            '<td style="text-align: center;width: 3%;border-left:1px white solid;">همراه بازگشت</td>' +
                            '<td style="text-align: right;width: 36%;border-left:1px white solid;padding-right: 4px">توضیحات</td>' +
                            '<td style="text-align: center;width: 7%;border-left:1px white solid;">مقدار</td>' +
                            '<td style="text-align: center;width: 17%;border-left:1px white solid;">وضعیت درخواست</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;">#</td></tr>'
                        $("#request_table2").append(row_th)
                        for (var i = 0; i < response.results.length; i++) {
                            id_exit = $('<td style="text-align: center">' + response.results[i]['id_exit'] + '</td>')
                            date_request_shamsi = $('<td style="text-align: center">' + response.results[i]['date_request_shamsi'] + '</td>')
                            description = $('<td style="text-align: right;padding-right: 4px">' + response.results[i]['description'] + '</td>')
                            exit_no = $('<td style="text-align: right;padding-right: 4px;font-size: xx-small">' + response.results[i]['exit_no'] + '</td>')
                            condition=response.results[i]['level']
                            t1 = $('<td></td>')

                            history = $('<button type="button" class="btn-sm btn-primary history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">گردش</button>').attr('id',  response.results[i]['id_exit'] + 1000)
                            if(condition==1){
                                t2 = $('<td style="text-align: right;padding-right: 3px">نزد مدیرقسمت</td>')
                            }
                            if(condition==-1){
                                t2 = $('<td style="text-align: right;padding-right: 3px">تایید نشده مدیرقسمت</td>')
                            }
                            if(condition==2){
                                t2 = $('<td style="text-align: right;padding-right: 3px">نزد مسئول حراست</td>')
                            }
                            if(condition==-2){
                                t2 = $('<td style="text-align: right;padding-right: 3px">تایید نشده مدیرحراست</td>')
                            }
                            if(condition==3){
                                t2 = $('<td style="text-align: right;padding-right: 3px">نزد مدیر نیروگاه</td>')
                            }
                            if(condition==-3){
                                t2 = $('<td style="text-align: right;padding-right: 3px">تایید نشده مدیر نیروگاه</td>')
                            }
                            if(condition==4){
                                t2 = $('<td style="text-align: right;padding-right: 3px">منتظر خروج</td>')
                            }
                            if(condition==5){
                                t2 = $('<td style="text-align: right;padding-right: 3px">خروج از نیروگاه</td>')
                            }
                            if(condition==6){
                                t2 = $('<td style="text-align: right;padding-right: 3px">منتظر ورود</td>')
                            }
                            if(condition==7){
                                t2 = $('<td style="text-align: right;padding-right: 3px">ورود به نیروگاه</td>')
                            }
                            if(condition==8){
                                t2 = $('<td style="text-align: right;padding-right: 3px">خروج از نیروگاه</td>')
                            }
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_requester']){
                                    l_name = $('<td style="width: 7%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }



                            if(response.results[i]['enter_exit']==1){
                                enter_exit = $('<td>' +'خروج'+'</td>')
                            }
                            if(response.results[i]['enter_exit']==2){
                                enter_exit = $('<td>' +'ورود'+'</td>')
                            }
                            if(response.results[i]['with_return']==1){
                                with_return = $('<td>' +'بلی'+'</td>')
                            }
                            if(response.results[i]['with_return']==2){
                                with_return = $('<td>' +'خیر'+'</td>')
                            }


                            t1.append(history)
                            row = $('<tr class="reports"></tr>')
                            row.append(id_exit,date_request_shamsi,l_name,enter_exit,with_return,description,exit_no,t2,t1)
                            $("#request_table2").append(row)
                        }
                        $(".history").on('click',function () {

                            var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                            $.ajaxSetup({
                                headers: {
                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            });
                            var _token = $("input[name='_token']").val();
                            $.ajax({
                                url: '/workflow/'+id_exit,
                                method:'GET',
                                success: function (response) {
                                    $('#myModal4').modal('show');
                                    var description = ''
                                    var date_shamsi = ''
                                    var time = ''
                                    var l_name = ''
                                    var row = ''
                                    $(".workflowrows").remove();
                                    for(var i = 0; i < response.results.length; i++) {
                                        description = $('<td style="width: 70%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                        date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                        time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                        for(var z = 0; z < response.users.length; z++) {
                                            if(response.users[z]['id']==response.results[i]['id_user']){
                                                l_name = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.users[z]['l_name'] + '</td>')
                                                break;
                                            }

                                        }
                                        row = $('<tr class="workflowrows"></tr>')
                                        row.append(date_shamsi,time,description,l_name)
                                        $("#workflow").append(row)
                                    }
                                }
                            })
                        })
                    }

                })
                $(".mylist").show();
            });
            $("#date_exit_shamsi1").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_exit_shamsi2").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $(".history").on('click',function () {

                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '/workflow/'+id_exit,
                    method:'GET',
                    success: function (response) {
                        $('#myModal4').modal('show');
                        var description = ''
                        var date_shamsi = ''
                        var time = ''
                        var l_name = ''
                        var row = ''
                        $(".workflowrows").remove();
                        for(var i = 0; i < response.results.length; i++) {
                            description = $('<td style="width: 70%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                            date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                            time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            row = $('<tr class="workflowrows"></tr>')
                            row.append(date_shamsi,time,description,l_name)
                            $("#workflow").append(row)
                        }
                    }
                })
            })
        });
    </script>
    <!-- Register form -->
    <div class="container-fluid">
        <div class="row" style="height: 400px">

            <div class="col-8">
                <div class="row mylist" style="margin: auto;width:95%;height:320px;direction: rtl;margin-top: 15px;border: 1px solid black;border-radius: 5px;text-align: center;margin-right: 120px">
                    <div class="col-12" style="direction: rtl;height: 317px;overflow-y: scroll;background-color:rgba(0, 0,55, 0.4)">
                        <table id="request_table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small;color:white">
                            <tr class="bg-info reports" style="color: white;height: 30px;"><td style="border-left:1px white solid;width: 5%">شماره درخواست</td><td style="border-left:1px white solid;width: 10%">تاریخ</td><td style="border-left:1px white solid;width:10%">درخواست کننده</td><td style="border-left:1px white solid;width: 45%">توضیحات</td><td style="border-left:1px white solid;width: 20%">مقدار</td><td style="border-left:1px white solid;width: 20%">وضعیت درخواست</td><td style="width: 10%">#</td></tr>
                        </table>

                    </div>
                    <a href="/print3">
                        <img src="{{URL::to('/')}}/printer002.png" class="reza10" data-toggle="tooltip" data-placement="bottom" title="چاپ گزارش" style="width: 50px;height: 50px;margin-top: 20px">
                    </a>
                </div>
            </div>

            <div class="col-4" style="direction: rtl;background: rgba(171, 205, 239, 0.3);border-radius: 10px;color: white">
                <form class="mt-4" method="post" encType="multipart/form-data" id="create_report" action={{route('exit.report')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div class="container-fluid">
                            <div class="field row" >
                                <div class="col" style="text-align: center"><label for="date_exit_shamsi1" style="font-family: Tahoma;font-size: smaller;display: inline"> تاریخ شروع:</label></div>
                                <div class="col" style="text-align: right"> <input type="text" maxlength="20" class="form-control" id="date_exit_shamsi1"  data-toggle="tooltip" data-placement="right"  name="date_exit_shamsi1" style="font-family: Tahoma;font-size: small;width: 100px;" required title="تاریخ شروع گزارش گیری"></div>
                            </div>
                            <div class="field row">
                                <div class="col" style="text-align: center"><label for="date_exit_shamsi2" style="font-family: Tahoma;font-size: small;display: inline"> تاریخ پایان:</label></div>
                                <div class="col" style="text-align: right"><input type="text" maxlength="20" class="form-control" id="date_exit_shamsi2"  data-toggle="tooltip" data-placement="right"  name="date_exit_shamsi2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100px" required title="تاریخ پایان گزارش گیری"></div>
                            </div>
                            <div class="row field">
                                <div class="col" style="text-align: center"><p for="part" style="font-family: Tahoma;font-size: small;"> مربوط به بخش:</p></div>
                                <div class="col" style="text-align: right">
                                    <select class="form-control" name="part" id="part" style="width:100%;font-family: Tahoma;font-size: small;margin-right: 5px">
                                        <option value=0>انتخاب</option>
{{--                                        @foreach($parts as $part)--}}
{{--                                            <option value="{{$part->id_request_part}}">{{$part->description}}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row field">
                                <div class="col-5" style="text-align: center"><p style="font-family: Tahoma;font-size: small;"> فرد درخواست کننده:</p></div>
                                <div class="col-7" style="text-align: right">
                                    <select class="form-control" name="id_requester" id="id_requester" style="width: 100%;font-family: Tahoma;font-size: small;">
                                        <option value=0>انتخاب</option>
{{--                                        @foreach($requesters as $requester)--}}
{{--                                            <option value="{{$requester['id_user']}}">{{\App\User::where('id',$requester['id_user'])->first()->f_name.' '.--}}
{{--                                            \App\User::where('id',$requester['id_user'])->first()->l_name}}</option>--}}
{{--                                        @endforeach--}}
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col"><button type="submit" class="btn btn-success" id="btnAdd" style="font-family: Tahoma;font-size: small;text-align: right">جستجو</button></div>
                                <div class="col">

                                </div>

                            </div>
                        </div>

                    </div>


                </form>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="myModal4" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">گردش درخواست</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10"></div>
                                <div class="col-2">
                                    <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <!-- List -->
                <div class="container"  style="margin: auto;background-color:#c4e6f5;width: 850px ;height: 400px;;overflow-y: scroll">
                    <table class="table table-striped" id="workflow" style="width: 800px">
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>

@endsection
