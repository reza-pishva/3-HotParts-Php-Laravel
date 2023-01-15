@extends('layouts.entering.app_requester5')
@section('content')
    <script xmlns:center>
        $(document).ready(function(){
            $("#create_report").on('submit',function(event) {
                
                var date1=$("#date_exit_shamsi1").val();
                var date2=$("#date_exit_shamsi2").val();
                var day=0;
                var month=0;
                var year=0;
                day = date1.substr(8,2)
                month = date1.substr(5,2)
                year = date1.substr(0,4)
                date1=year+month+day;
                day = date2.substr(8,2)
                month = date2.substr(5,2)
                year = date2.substr(0,4)
                date2=year+month+day;
                

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();

                $.ajax({
                    url: "/vue-individuals-karkard2/"+date1+"/"+date2,
                    method:'GET',
                    beforeSend: function(){
                        $("#first_spinner").show();
                        $("#report_table").hide();
                    },
                    success: function (response) {
                        $("#first_spinner").hide();
                        $("#report_table").show();
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var karkard = ''
                        var karkard2 = ''
                        var code_melli = ''
                        var f_name = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;text-align:center">نام</td><td style="border-left:1px white solid;text-align:center">نام خانوادگی</td><td style="border-left:1px white solid;text-align:center">کد ملی</td><td style="border-left:1px white solid;text-align:center">کارکرد</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            f_name = $('<td style="width: 20%;text-align:center">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 25%;text-align:center">' + response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 30%;text-align:center">' + response.results[i]['code_melli'] + '</td>')
                            var hour=Math.ceil(response.results[i]['karkard']/3600);
                            hour=hour-1;
                            var minute=Math.ceil((60)*(Math.ceil(response.results[i]['karkard']/3600)-response.results[i]['karkard']/3600));
                            minute=60-minute;
                            karkard = $('<td style="width: 25%;text-align:center">' + hour + ':' + minute + '</td>')
                            karkard2 = $('<td style="width: 30%;text-align:center">' + response.results[i]['karkard'] + '</td>')
                            row = $('<tr style="color:white" class="report_row"></tr>')
                            row.append(f_name,l_name,code_melli,karkard)
                            $("#report_table").append(row)
                        }
                        // $(".mylist").hide();
                        // $(".mylist2").hide();
                        // $(".register").hide();
                        // $(".mylist2").fadeToggle(2000);
                    }})
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
        
        <div class="row" style="height: 250px">
            <div class="col-2">
                <div >
                    <a href="http://172.28.232.27:8000/home">
                        <img src="{{URL::to('/')}}/exit003.png" style="width: 70px;height: 70px;margin-top: 25px" data-toggle="tooltip" data-placement="bottom" title="بازگشت به صفحه قبل">
                    </a>
                </div>
            </div>
            <div class="col-5">

                <div class="row mylist" style="margin: auto;width:100%;height:320px;direction: rtl;margin-top: 15px;border: 1px solid black;border-radius: 5px;text-align: center;margin-right: 120px">
                    <div class="col-12" style="direction: rtl;height: 317px;overflow-y: scroll;background-color:rgba(0, 0,55, 0.4)">
                        <div id="first_spinner" style="display: none;margin-top: 90px">
                            <img src="preloader10.gif" style="width:200px;height:120px;border-radius: 100px">
                        </div>
                        <table id="report_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-3 mt-5" style="direction: rtl;background: rgba(171, 205, 239, 0.3);border-radius: 10px;color: white;height: 200px">
                <form class="mt-4" method="post" encType="multipart/form-data" id="create_report" action={{route('exit.report29')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div class="container-fluid">
                            <div class="field row mt-1" >
                                <div class="col" style="text-align: center"><label for="date_exit_shamsi1" style="font-family: Tahoma;font-size: smaller;display: inline"> تاریخ شروع:</label></div>
                                <div class="col" style="text-align: right"> <input type="text" maxlength="20" class="form-control" id="date_exit_shamsi1"  data-toggle="tooltip" data-placement="right"  name="date_exit_shamsi1" style="font-family: Tahoma;font-size: small;width: 100px;" required title="تاریخ شروع گزارش گیری"></div>
                            </div>
                            <div class="field row mt-1">
                                <div class="col" style="text-align: center"><label for="date_exit_shamsi2" style="font-family: Tahoma;font-size: small;display: inline"> تاریخ پایان:</label></div>
                                <div class="col" style="text-align: right"><input type="text" maxlength="20" class="form-control" id="date_exit_shamsi2"  data-toggle="tooltip" data-placement="right"  name="date_exit_shamsi2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100px" required title="تاریخ پایان گزارش گیری"></div>
                            </div>
                         
                            {{-- <div class="row field mt-1">
                                <div class="col-5" style="text-align: center">
                                    <label for="code_melli" style="font-family: Tahoma;font-size: small;"> کد ملی:</label>
                                </div>
                                <div class="col-7" style="text-align: right">
                                    <input type="text" maxlength="20" class="form-control" id="code_melli" data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" required style="direction:rtl;font-family:Tahoma;font-size:small;width: 100%"  title="کد ملی">
                                </div>
                            </div> --}}
                            <div class="row mt-3">
                                <div class="col"><button type="submit" class="btn btn-success" id="btnAdd" style="font-family: Tahoma;font-size: small;text-align: right">جستجو</button></div>
                                <div class="col">
                                    {{-- <a href="{{url('/selectindividuals2/14010101/14010619')}}" class="btnprn3 btn">
                                        <p><img src="{{URL::to('/')}}/printer.png" style="width: 35px;height:35px;border-radius: 10px;"></p>

                                    </a> --}}
                                </div>

                            </div>
                        </div>

                    </div>


                </form>
            </div>
            <div class="col-2">
                
            </div>
        </div>
    </div>



@endsection
