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
                    url: "/report_queryp",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $(".reports").remove();
                        var day=''
                        var month=''
                        var year=''
                        var id_ef=''
                        var date_shamsi_enter=''
                        var date_shamsi_exit = ''
                        var date_shamsi_enter2=''
                        var date_shamsi_exit2 = ''
                        var f_name = ''
                        var l_name = ''
                        var code_melli = ''
                        var history = ''
                        var details = ''
                        var enterexit='';
                        var title='';
                        var company='';
                        var title1='';
                        var company1='';
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var row =''
                        var row2 =''
                        var row_th = '<tr class="bg-info reports" style="color: white;height: 30px;">' +
                            '<td style="text-align: center;width: 3%;border-left:1px white solid;font-size: smaller ">شماره درخواست</td>' +
                            '<td style="text-align: center;width: 12%;border-left:1px white solid;font-size: smaller">نام</td>' +
                            '<td style="text-align: center;width: 14%;border-left:1px white solid;font-size: smaller">نام خانوادگی</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;font-size: smaller">کد ملی</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;font-size: smaller">تاریخ ورود</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;font-size: smaller">تاریخ خروج</td>' +
                            '<td style="text-align: center;width: 23%;border-left:1px white solid;font-size: smaller">علت ورود</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;font-size: smaller">#</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;font-size: smaller">#</td>' +
                            '<td style="text-align: center;width: 8%;border-left:1px white solid;font-size: smaller">#</td></tr>'
                        // var row_th2 = '<tr style="height: 1px;">' +
                        //     '<td style="width: 50%;"></td>' +
                        //     '<td style="width: 50%;"></td></tr>'
                        // var row_th3 = '<tr style="height: 1px;">' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td>' +
                        //     '<td style="width: 10%;"></td></tr>'
                        $("#request_table2").append(row_th)
                        for (var i = 0; i < response.results.length; i++) {

                            id_ef = $('<td style="text-align: center;width: 3%;font-size: smaller">' + response.results[i]['id_ef'] + '</td>')
                            f_name = $('<td style="text-align: center;width: 12%;font-size: smaller">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="text-align: center;width: 14%;font-size: smaller">' + response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="text-align: center;width: 8%;font-size: smaller">' + response.results[i]['code_melli'] + '</td>')
                            day=response.results[i]['date_shamsi_enter'].substr(6,2)
                            month=response.results[i]['date_shamsi_enter'].substr(4,2)
                            year=response.results[i]['date_shamsi_enter'].substr(0,4)
                            date_shamsi_enter = $('<td style="text-align: center;width: 10%;font-size: smaller">'+ year +'/'+month+'/'+day+'</td>')
                            date_shamsi_enter2 = $('<td hidden style="text-align: center;width: 13%">'+ year+month+day+'</td>')
                            day=response.results[i]['date_shamsi_exit'].substr(6,2)
                            month=response.results[i]['date_shamsi_exit'].substr(4,2)
                            year=response.results[i]['date_shamsi_exit'].substr(0,4)
                            date_shamsi_exit = $('<td style="text-align: center;width: 10%;font-size: smaller">'+ year +'/'+month+'/'+day+'</td>')
                            date_shamsi_exit2 = $('<td hidden style="text-align: center;width: 13%">'+ year+month+day+'</td>')
                            history = $('<button type="button" class="btn-sm btn-primary history" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal44">گردش</button>').attr('id',  response.results[i]['id_ef'] + 1000)
                            enterexit = $('<button type="button" class="btn-sm btn-success enterexit" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo5">تردد</button>').attr('id',  response.results[i]['id_ep'] + 1000)
                            details = $('<button type="button" class="btn-sm btn-info details" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات</button>').attr('id',  response.results[i]['id_ef'])
                            t1 = $('<td style="text-align: center;width: 8%"></td>')
                            t1.append(history)
                            t2 = $('<td style="text-align: center;width: 8%"></td>')
                            t3 = $('<td style="text-align: center;width: 8%"></td>')
                            t2.append(enterexit)
                            t3.append(details)
                            row = $('<tr class="reports"></tr>')

                            for(var z1 = 0; z1 < response.forms.length; z1++) {
                                if(response.forms[z1]['id_ef']==response.results[i]['id_ef']){
                                    title1 = $('<td style="width: 100%;font-family: Tahoma;font-size: 10pt;text-align: right;margin-right: 100px">' +'دلیل حضور:' + '</td>')
                                    title = $('<td style="width: 100%;font-family: Tahoma;font-size: 10pt;text-align: right;margin-right: 100px;font-size: smaller">' + response.forms[z1]['title'] + '</td>')
                                    company1 = $('<td style="width: 100%;font-family: Tahoma;font-size: 10pt;text-align: right;margin-right: 100px">' +'مراجعه از:' + '</td>')
                                    company = $('<td style="width: 100%;font-family: Tahoma;font-size: 10pt;text-align: right;">' + response.forms[z1]['company'] + '</td>')
                                    row2 = $('<tr><td>'+response.forms[z1]['company']+'</td></tr>')
                                    break;
                                }

                            }

                            row.append(id_ef,f_name,l_name,code_melli,date_shamsi_enter,date_shamsi_exit,title,t2,t1,t3,date_shamsi_enter2,date_shamsi_exit2)


                            //$("#request_table2").append(row_th3)
                            $("#request_table2").append(row)
                        }
                        $(".history").on('click',function () {
                            var id_ef = Number($(this).closest('tr').find('td:eq(0)').text())+1000000;
                            $.ajaxSetup({
                                headers: {
                                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                }
                            });
                            var _token = $("input[name='_token']").val();
                            $.ajax({
                                url: '/workflow/'+id_ef,
                                method:'GET',
                                success: function (response) {
                                    $('#myModal44').modal('show');
                                    var description = ''
                                    var date_shamsi = ''
                                    var time = ''
                                    var l_name=''
                                    var row = ''
                                    $(".workflowrows").remove();
                                    for(var i = 0; i < response.results.length; i++) {
                                        description = $('<td style="width: 80%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                        date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                        time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                        row = $('<tr class="workflowrows"></tr>')
                                        for(var z = 0; z < response.users.length; z++) {
                                            if(response.users[z]['id']==response.results[i]['id_user']){
                                                l_name = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.users[z]['l_name'] + '</td>')
                                                break;
                                            }

                                        }
                                        row.append(date_shamsi,time,description,l_name)
                                        $("#workflow").append(row)
                                    }
                                }
                            })
                        })
                        $('.enterexit').click(function(event) {

                            $('#personinfo5').modal("show");
                            var code_melli = $(this).closest('tr').find('td:eq(3)').text();
                            var date1 = $('#date_exit_shamsi1').val();
                            var date2 = $('#date_exit_shamsi2').val();
                            date1 = date1.replace('/','');
                            date1 = date1.replace('/','');
                            date2 = $('#date_exit_shamsi2').val();
                            date2 = date2.replace('/','');
                            date2 = date2.replace('/','');
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax(
                                {
                                    url: "/personinfo3/" + code_melli+'/'+date1+'/'+date2,
                                    type: 'GET',
                                    data: {
                                        "id": code_melli,
                                        "_token": token,
                                    },
                                    success: function (response) {

                                        var edit=''
                                        var del=''
                                        var t1=''
                                        var t2=''
                                        var enter_exit = ''
                                        var id_ed = ''
                                        var date = ''
                                        var time = ''
                                        var row = ''
                                        $(".personinfo2").remove();
                                        for(var i = 0; i < response.individuals.length; i++) {
                                            id_ed = $('<td style="width:11%;text-align: center" class="personinfo2">' + response.individuals[i]['i_ed'] + '</td>')
                                            var enter_exit_val = $('<td hidden style="text-align: center" class="personinfo2">' +response.individuals[i]['enter_exit']+ '</td>')
                                            if(response.individuals[i]['enter_exit']==1){
                                                enter_exit = $('<td style="width: 15%;text-align: center" class="personinfo2">' +'ورود'+ '</td>')
                                            }else{
                                                enter_exit = $('<td style="width: 15%;text-align: center" class="personinfo2">' +'خروج'+ '</td>')
                                            }
                                            var day=response.individuals[i]['date_enter'].substr(6,2)
                                            var month=response.individuals[i]['date_enter'].substr(4,2)
                                            var year=response.individuals[i]['date_enter'].substr(0,4)
                                            var date = $('<td style="text-align: center;padding-right: 5px;width: 22%" class="personinfo2">' + year +'/'+month+'/'+day+'</td>')
                                            time = $('<td style="width: 22%;text-align: center" class="personinfo2">' + response.individuals[i]['time_enter'] + '</td>')
                                            edit = $('<button type="button" class="btn-sm btn-info" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#dailyenter2" disabled>اصلاح</button>').attr('id',  response.individuals[i]['i_ed']+1000)
                                            del = $('<button type="button" class="btn-sm btn-danger" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" disabled>حذف</button>').attr('id',  response.individuals[i]['i_ed']+2000)
                                            t1 = $('<td hidden style="width: 15%" class="personinfo2"></td>')
                                            t2 = $('<td hidden style="width: 15%" class="personinfo2"></td>')
                                            t1.append(edit)
                                            t2.append(del)
                                            row = $('<tr class="report_row"></tr>')
                                            row.append(id_ed,enter_exit,date,time,t1,t2,enter_exit_val)
                                            $("#person_table77").append(row)//data-toggle="modal" data-target="#personinfo"
                                            // $('#' + Number(response.individuals[i]['i_ed']+2000)).click(function () {
                                            //     var id_ed = $(this).closest('tr').find('td:eq(0)').text();
                                            //     var token = $("meta[name='csrf-token']").attr("content");
                                            //     $.ajax(
                                            //         {
                                            //             url: "/deleteindividuals/" + id_ed,
                                            //             type: 'DELETE',
                                            //             data: {
                                            //                 "id": id_ed,
                                            //                 "_token": token,
                                            //             },
                                            //             success: function (response) {
                                            //                 $('.individuals2').show()
                                            //                 $('.individuals2').toast('show');
                                            //                 $("#individuals2").html("مورد انتخابی حذف گردید")
                                            //             }
                                            //         });
                                            //     $(this).closest('tr').remove()
                                            //
                                            // })
                                            // $('#' + Number(response.individuals[i]['i_ed']+1000)).click(function () {
                                            //     $("#id_ed_edit").val($(this).closest('tr').find('td:eq(0)').text())
                                            //     $("#enter_exit_edit").val($(this).closest('tr').find('td:eq(6)').text())
                                            //     $("#date_shamsi_enter_edit").val($(this).closest('tr').find('td:eq(2)').text())
                                            //     $("#time_enter_edit").val($(this).closest('tr').find('td:eq(3)').text())
                                            // });
                                        }

                                    }
                                });
                        })
                        $('.details').on('click',function(){
                            var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                            $.ajax({
                                url: "/recivefirstreport1/"+id_ef,
                                method:'GET',
                                success: function (response) {
                                    $("#title1").text(response.title)
                                    $("#company1").text(response.company)
                                    var day=""
                                    var month=""
                                    var year=""
                                    var id_ep=""
                                    var f_name=""
                                    var l_name=""
                                    var id_et=""
                                    var nationality=""
                                    var age=""
                                    var time_enter=""
                                    var date_shamsi_enter=""
                                    var time_exit=""
                                    var date_shamsi_exit=""
                                    var code_melli=""
                                    var mobile=""
                                    $(".persons_row").remove();
                                    for(var i = 0; i < response.persons.length; i++) {
                                        id_ep = $('<td class="persons">' + response.persons[i]['id_ep'] + '</td>')
                                        f_name = $('<td class="persons">' + response.persons[i]['f_name'] + '</td>')
                                        l_name = $('<td class="persons">' + response.persons[i]['l_name'] + '</td>')
                                        nationality = $('<td class="persons">' + response.persons[i]['nationality'] + '</td>')
                                        age = $('<td class="persons">' + response.persons[i]['age'] + '</td>')
                                        time_enter = $('<td class="persons">' + response.persons[i]['time_enter'] + '</td>')
                                        year=response.persons[i]['date_shamsi_enter'].substr(0, 4);
                                        month=response.persons[i]['date_shamsi_enter'].substr(4, 2);
                                        day=response.persons[i]['date_shamsi_enter'].substr(6, 2);
                                        date_shamsi_enter = $('<td class="persons">' + year+'/'+month+'/'+day + '</td>')
                                        time_exit = $('<td class="persons">' + response.persons[i]['time_exit'] + '</td>')
                                        year=response.persons[i]['date_shamsi_exit'].substr(0, 4);
                                        month=response.persons[i]['date_shamsi_exit'].substr(4, 2);
                                        day=response.persons[i]['date_shamsi_exit'].substr(6, 2);
                                        date_shamsi_exit = $('<td class="persons">' + year+'/'+month+'/'+day + '</td>')
                                        code_melli = $('<td class="persons">' + response.persons[i]['code_melli'] + '</td>')
                                        mobile = $('<td class="persons">' + response.persons[i]['mobile'] + '</td>')
                                        for(var z = 0; z < response.titles.length; z++) {
                                            if(response.titles[z]['id_et']==response.persons[i]['id_et']){
                                                id_et = $('<td class="persons">' + response.titles[z]['description'] + '</td>')
                                                break;
                                            }

                                        }
                                        row = $('<tr class="persons_row" style="font-family: Tahoma;font-size: 11px;color: black"></tr>')
                                        row.append(id_ep,f_name,l_name,id_et,nationality,age,date_shamsi_enter,time_enter,date_shamsi_exit,time_exit,code_melli,mobile)
                                        $("#person_table").append(row)

                                    }
                                    var height1=(($('#person_table tr').length)*33).toString()+'px'
                                    var height2=(($('#person_table tr').length)*33+11).toString()+'px'
                                    $("#person_table").css('height',height1)
                                    $("#person_div").css('height',height2)

                                    var id_ec=""
                                    var car_name=""
                                    var driver_name=""
                                    var area=""
                                    var part1=""
                                    var part2=""
                                    var part3=""

                                    $(".cars_row").remove();
                                    for(var j = 0; j <response.cars.length; j++) {
                                        id_ec = $('<td class="cars">' + response.cars[j]['id_ec'] + '</td>')
                                        car_name = $('<td class="cars">' +response.cars[j]['car_name'] + '</td>')
                                        part1 = $('<td class="cars">' + response.cars[j]['car_no'].substr(3,3) + '</td>')
                                        part2 = $('<td class="cars">' + response.cars[j]['car_no'].substr(0,1) + '</td>')
                                        part3 = $('<td class="cars">' + response.cars[j]['car_no'].substr(1,2) + '</td>')
                                        driver_name = $('<td class="cars">' + response.cars[j]['driver_name'] + '</td>')
                                        area = $('<td class="cars">' + response.cars[j]['area'] + '</td>')

                                        row = $('<tr class="cars_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                        row.append(id_ec,car_name,driver_name,part1,part2,part3,area)
                                        $("#cars_table").append(row)

                                    }

                                    height1=(($('#cars_table tr').length)*25).toString()+'px'
                                    height2=(($('#cars_div tr').length)*25+11).toString()+'px'
                                    $("#cars_table").css('height',height1)
                                    $("#cars_div").css('height',height2)




                                    var id_ei=""
                                    var description1=""

                                    $(".els_row").remove();
                                    for(var z = 0; z <response.els.length; z++) {
                                        id_ei = $('<td class="els">' + response.els[z]['id_ei'] + '</td>')
                                        description1 = $('<td class="els">' +response.els[z]['description'] + '</td>')
                                        row = $('<tr class="els_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                        row.append(id_ei,description1)
                                        $("#el_table").append(row)

                                    }

                                    height1=(($('#el_table tr').length)*25).toString()+'px'
                                    height2=(($('#el_table tr').length)*25+11).toString()+'px'
                                    $("#el_table").css('height',height1)
                                    $("#el_div").css('height',height2)




                                    var id_ee=""
                                    var description2=""

                                    $(".eqs_row").remove();

                                    for(var f = 0; f <response.eqs.length; f++) {
                                        id_ee = $('<td class="eqs">' + response.eqs[f]['id_ee'] + '</td>')
                                        description2 = $('<td class="eqs">' +response.eqs[f]['description'] + '</td>')
                                        row = $('<tr class="eqs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                        row.append(id_ee,description2)
                                        $("#eq_table").append(row)

                                    }


                                    height1=(($('#eq_table tr').length)*25).toString()+'px'
                                    height2=(($('#eq_table tr').length)*25+11).toString()+'px'
                                    $("#eq_table").css('height',height1)
                                    $("#eq_div").css('height',height2)



                                    var id_eup=""
                                    var description3=""

                                    $(".equs_row").remove();

                                    for(var g = 0; g <response.equs.length; g++) {
                                        id_eup = $('<td class="equs">' + response.equs[g]['id_eup'] + '</td>')
                                        description3 = $('<td class="equs"><a href="./documents/'+response.equs[g]['id_eup']+'.pdf">'+response.equs[g]['description']+'</a> </td>')
                                        row = $('<tr class="equs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                        row.append(id_eup,description3)
                                        $("#equ_table").append(row)

                                    }


                                    height1=(($('#equ_table tr').length)*25).toString()+'px'
                                    height2=(($('#equ_table tr').length)*25+11).toString()+'px'
                                    $("#equ_table").css('height',height1)
                                    $("#equ_div").css('height',height2)


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
        <div class="row" style="height: 250px">
            <div class="col-1">
                <a href="/herasat2">
                    <img src="{{URL::to('/')}}/exit003.png" style="width: 50px;height: 50px;margin-top: 25px" data-toggle="tooltip" data-placement="bottom" title="بازگشت به صفحه قبل">
                </a>
            </div>
            <div class="col-7">
                <div class="row mylist" style="margin: auto;width:100%;height:320px;direction: rtl;margin-top: 15px;border: 1px solid black;border-radius: 5px;text-align: center;margin-right: 120px">
                    <div class="col-12" style="direction: rtl;height: 317px;overflow-y: scroll;background-color:rgba(0, 0,55, 0.4)">
                        <table id="request_table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small;color:white">
                            <tr class="bg-info reports" style="color: white;height: 30px;"><td style="border-left:1px white solid;width: 5%">شماره درخواست</td><td style="border-left:1px white solid;width: 10%">نام</td><td style="border-left:1px white solid;width:10%">نام خانوادگی</td><td style="border-left:1px white solid;width: 10%">کد ملی</td><td style="border-left:1px white solid;width: 10%">تاریخ ورود</td><td style="border-left:1px white solid;width: 10%">تاریخ خروج</td><td style="border-left:1px white solid;width: 10%">#</td><td style="border-left:1px white solid;width: 10%">#</td></tr>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-4" style="direction: rtl;background: rgba(171, 205, 239, 0.3);border-radius: 10px;color: white">
                <form class="mt-4" method="post" encType="multipart/form-data" id="create_report" action={{route('exit.report29')}}>
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
                                <div class="col" style="text-align: center"><p for="part" style="font-family: Tahoma;font-size: small;">در بازه زمانی مجاز:</p></div>
                                <div class="col" style="text-align: right">
                                    <select class="form-control" name="allow" id="allow" style="width:60%;font-family: Tahoma;font-size: small;margin-right: 5px">
                                        <option value=0>انتخاب</option>
                                        <option value=1>بله</option>
                                        <option value=2>خیر</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row field">
                                <div class="col" style="text-align: center"><p for="part" style="font-family: Tahoma;font-size: small;"> مربوط به بخش:</p></div>
                                <div class="col" style="text-align: right">
                                    <select class="form-control" name="part" id="part" style="width:100%;font-family: Tahoma;font-size: small;margin-right: 5px">
                                        <option value=0>انتخاب</option>
                                        @foreach($parts as $part)
                                            <option value="{{$part->id_request_part}}">{{$part->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row field">
                                <div class="col-5" style="text-align: center"><p style="font-family: Tahoma;font-size: small;"> فرد درخواست کننده:</p></div>
                                <div class="col-7" style="text-align: right">
                                    <select class="form-control" name="id_requester" id="id_requester" style="width: 100%;font-family: Tahoma;font-size: small;">
                                        <option value=0>انتخاب</option>
                                        @foreach($requesters as $requester)
                                            <option value="{{$requester['id_user']}}">{{\App\User::where('id',$requester['id_user'])->first()->f_name.' '.
                                            \App\User::where('id',$requester['id_user'])->first()->l_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row field">
                                <div class="col-5" style="text-align: center">
                                    <label for="code_melli" style="font-family: Tahoma;font-size: small;"> کد ملی:</label>
                                </div>
                                <div class="col-7" style="text-align: right">
                                    <input type="text" maxlength="20" class="form-control" id="code_melli" data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" style="direction:rtl;font-family:Tahoma;font-size:small;width: 100%"  title="کد ملی">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col"><button type="submit" class="btn btn-success" id="btnAdd" style="font-family: Tahoma;font-size: small;text-align: right">جستجو</button></div>
{{--                                <div class="col">--}}
{{--                                    <a href="{{url('/reporti')}}" class="btnprn3 btn">--}}
{{--                                        <p><img src="../../individual.png" style="width: 75px;height:65px;border-radius: 10px;"></p>--}}

{{--                                    </a>--}}
{{--                                </div>--}}

                            </div>
                        </div>

                    </div>


                </form>
            </div>
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
