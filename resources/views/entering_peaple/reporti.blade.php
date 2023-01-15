@extends('layouts.entering.app_requester5')
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
                    url: "/report_queryi",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    beforeSend: function(){
                        $("#first_spinner").show();
                        $("#request_table2").hide();
                    },
                    success: function (response) {
                        $("#first_spinner").hide();
                        $("#request_table2").show();
                        $(".reports").remove();
                        var day=''
                        var month=''
                        var year=''
                        var i_ed=''
                        var date_shamsi_enter=''
                        var time_enter = ''
                        var enterexit = '';
                        var row =''
                        var row2 =''
                        var row_th = '<tr class="bg-info reports" style="color: white;height: 30px;">' +
                            '<td style="text-align: center;width: 25%;border-left:1px white solid;font-size: smaller ">کد تردد</td>' +
                            '<td style="text-align: center;width: 15%;border-left:1px white solid;font-size: smaller">نوع تردد</td>' +
                            '<td style="text-align: center;width: 30%;border-left:1px white solid;font-size: smaller">مربوط به تاریخ</td>' +
                            '<td style="text-align: center;width: 30%;border-left:1px white solid;font-size: smaller">ساعت تردد</td></tr>'
                        $("#request_table2").append(row_th)
                        for (var i = 0; i < response.results.length; i++) {

                            i_ed = $('<td style="text-align: center;width: 3%;font-size: small">' + response.results[i]['i_ed'] + '</td>')
                            enterexit=response.results[i]['enter_exit']
                            if(enterexit==1){
                                enterexit = $('<td style="text-align: center;width: 3%;font-size: small">' + 'ورود' + '</td>')
                            }
                            if(enterexit==2){
                                enterexit = $('<td style="text-align: center;width: 3%;font-size: small">' + 'خروج' + '</td>')
                            }
                            time_enter = $('<td style="text-align: center;width: 12%;font-size: small">' + response.results[i]['time_enter'] + '</td>')
                            day=response.results[i]['date_enter'].substr(6,2)
                            month=response.results[i]['date_enter'].substr(4,2)
                            year=response.results[i]['date_enter'].substr(0,4)
                            date_shamsi_enter = $('<td style="text-align: center;width: 10%;font-size: small">'+ year +'/'+month+'/'+day+'</td>')
                            row = $('<tr style="height: 25px" class="reports"></tr>')
                            row.append(i_ed,enterexit,date_shamsi_enter,time_enter)
                            $("#request_table2").append(row)
                        }
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

        <div class="row" style="height: 250px">
            <div class="col-2">
                <div >
                    <a href="./herasat2">
                        <img src="{{URL::to('/')}}/exit003.png" style="width: 70px;height: 70px;margin-top: 25px" data-toggle="tooltip" data-placement="bottom" title="بازگشت به صفحه قبل">
                    </a>
                </div>
            </div>
            <div class="col-5">
                <div class="row mylist" style="margin: auto;width:100%;height:320px;direction: rtl;margin-top: 15px;border: 1px solid black;border-radius: 5px;text-align: center;margin-right: 120px">
                    <div class="col-12" style="direction: rtl;height: 317px;overflow-y: scroll;background-color:rgba(0, 0,55, 0.4)">
                        <div id="first_spinner" style="display: none;margin-top: 90px">
                            <img src="spinner-sm.gif" style="width:170px;height:135px;border-radius: 100px">
                        </div>
                        <table id="request_table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small;color:white">
                            <tr class="bg-info reports" style="color: white;height: 30px;"><td style="border-left:1px white solid;width: 5%;text-align: center">کد تردد</td><td style="border-left:1px white solid;width: 10%;text-align: center">نوع تردد</td><td style="border-left:1px white solid;width:10%;text-align: center">مربوط به تاریخ</td><td style="border-left:1px white solid;width: 10%;text-align: center">ساعت تردد</td></tr>
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
                         
                            <div class="row field mt-1">
                                <div class="col-5" style="text-align: center">
                                    <label for="code_melli" style="font-family: Tahoma;font-size: small;"> کد ملی:</label>
                                </div>
                                <div class="col-7" style="text-align: right">
                                    <input type="text" maxlength="20" class="form-control" id="code_melli" data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" required style="direction:rtl;font-family:Tahoma;font-size:small;width: 100%"  title="کد ملی">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col"><button type="submit" class="btn btn-success" id="btnAdd" style="font-family: Tahoma;font-size: small;text-align: right">جستجو</button></div>
                                <div class="col">
                                    <a href="{{url('/selectindividuals')}}" class="btnprn3 btn">
                                        <p><img src="{{URL::to('/')}}/printer.png" style="width: 35px;height:35px;border-radius: 10px;"></p>

                                    </a>
                                </div>

                            </div>
                        </div>

                    </div>


                </form>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
    <div class="modal fade mt-3" id="myModal44" style="direction: rtl;">
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
    <div class="modal fade mt-3" id="personinfo5" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 60px;margin-left: 460px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 600px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اطلاعات ورود و خروج</p></div>
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
                <div class="container"  style="margin: auto;background-color:white;width: 600px ;height: 260px;overflow-y: scroll">
                    <a href="{{url('/selectindividuals')}}" class="btnprn3 btn">
                        <p><img src="{{URL::to('/')}}/printer.png" style="width: 30px;height: 30px"></p>
                    </a>
                    <div class="row" style="margin-top: 10px">
                        <div id="person_div2" class="col" style="height:50px">
                            <input hidden type="text" id="code_melli_s3">
                            <table id="person_table77" align="center" style="width: 90%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="person" style="width: 5%">کد</td>
                                    <td class="person" style="width: 10%">ورود/خروج</td>
                                    <td class="person" style="width: 10%">تاریخ</td>
                                    <td class="person" style="width: 7%">ساعت</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:600px">
                    <div class="toast bg-danger individuals2" style="margin-top:20px;margin: auto;border-radius: 10px">
                        <div class="toast-body"><p id="individuals2" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="myModal4" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جزئیات درخواست</p></div>
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
                <div class="container"  style="margin: auto;background-color:white;width: 850px ;height: 400px;overflow-y: scroll">
                    <div class="row mt-3">
                        <div class="col" style="height:25px">
                            <div class="row">
                                <div class="col-4" style="height:25px">
                                    <p style="font-family: Tahoma;font-size: smaller;color: black">عنوان فعالیت:</p>
                                </div>
                                <div class="col-8" style="height:25px;text-align: right">
                                    <p id="title1" style="font-family: Tahoma;font-size: smaller;color: black"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="height:25px">
                            <div class="row">
                                <div class="col-4" style="height:25px">
                                    <p style="font-family: Tahoma;font-size: smaller;color: black">نام شرکت یا مرکز:</p>
                                </div>
                                <div class="col-8" style="height:25px;text-align: right">
                                    <p id="company1" style="font-family: Tahoma;font-size: smaller;color: black"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col" style="height:25px;text-align: right">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px">مشخصات افراد دعوت شده به نیروگاه:</p>
                        </div>
                    </div>
                    <div class="row">
                        <div id="person_div" class="col" style="height:50px">
                            <table id="person_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="person" style="width: 5%">کد</td>
                                    <td class="person" style="width: 10%">نام</td>
                                    <td class="person" style="width: 14%">نام خانوادگی</td>
                                    <td class="person" style="width: 8%">عنوان فرد</td>
                                    <td class="person" style="width: 5%">ملیت</td>
                                    <td class="person" style="width: 4%">سن</td>
                                    <td class="person" style="width: 10%">تاریخ شروع</td>
                                    <td class="person" style="width: 7%">ساعت شروع</td>
                                    <td class="person" style="width: 10%">تاریخ پایان</td>
                                    <td class="person" style="width: 7%">ساعت پایان</td>
                                    <td class="person" style="width: 10%">کد ملی</td>
                                    <td class="person" style="width: 10%">شماره تلفن</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div id="first1" class="row">
                        <div id="ec_txt" class="col" style="height:25px;text-align: right;">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">مشخصات خودروهای مجاز به ورود به نیروگاه:</p>
                        </div>
                        <div id="ec_txt" class="col" style="height:25px;text-align: right;">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">فهرست لوازم الکترونیکی مجاز به ورود به نیروگاه:</p>
                        </div>
                    </div>
                    <div id="first2" class="row" style="text-align: right">
                        <div id="cars_div" class="col" style="height:30px;text-align: right">
                            <table id="cars_table" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;border: 1px solid black;">
                                <tr style="color: black;height: 25px;font-family: Tahoma;font-size: small;color: black">
                                    <td class="car" style="width: 10%;text-align: center;border: 1px solid black">کد</td>
                                    <td class="car" style="width: 15%;text-align: center;border: 1px solid black">نام خودرو</td>
                                    <td class="car" style="width: 20%;text-align: center;border: 1px solid black">نام راننده</td>
                                    <td class="car" style="width: 5%;text-align: center;border: 1px solid black"></td>
                                    <td class="car" style="width: 1%;font-size: 7px;text-align: center;border: 1px solid black">پلاک</td>
                                    <td class="car" style="width: 5%;text-align: center;border: 1px solid black"></td>
                                    <td class="car" style="width: 15%;text-align: center;border: 1px solid black">محدوده تردد</td>

                                </tr>
                            </table>
                        </div>
                        <div id="el_div" class="col" style="height:50px;text-align: right">
                            <table id="el_table" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="el" style="width: 15%">کد</td>
                                    <td class="el" style="width: 85%">نام وسیله الکترونیکی</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div id="eq_txt" class="col" style="height:25px;text-align: right">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">فهرست لوازم کار مجاز به ورود به نیروگاه:</p>
                        </div>
                        <div id="equ_txt" class="col" style="height:25px;text-align: right">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">فهرست فایلهای پیوست شده:</p>
                        </div>
                    </div>
                    <div class="row">
                        <div id="eq_div" class="col" style="height:200px;text-align: right">
                            <table id="eq_table" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="eq" style="width: 15%">کد</td>
                                    <td class="eq" style="width: 85%">نام وسیله </td>
                                </tr>
                            </table>
                        </div>
                        <div id="equ_div" class="col" style="height:200px;text-align: right">
                            <table id="equ_table" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="equ" style="width: 15%">کد</td>
                                    <td class="equ" style="width: 85%">عنوان فایل</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>
@endsection
