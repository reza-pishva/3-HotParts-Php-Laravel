@extends('layouts.entering.app_first_reciever_entering')
@section('content')
    <script>
        $(document).ready(function(){
            bootstrap.Toast.Default.delay = 4000
            $('#for_first_confirmation').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level1-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 25%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 20%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            var day=response.results[i]['date_shamsi'].substr(6,2)
                            var month=response.results[i]['date_shamsi'].substr(4,2)
                            var year=response.results[i]['date_shamsi'].substr(0,4)
                            date_shamsi = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + year +'/'+month+'/'+day+'</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 14%"></td>')
                            t1 = $('<td style="width: 8%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            edit1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">تایید</button>').attr('id',  response.results[i]['id_ef'])
                            t1.append(edit1)
                            t2 = $('<td style="width: 8%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            t3.append(detail)
                            row.append(id_ef,date_shamsi,title, company,l_name,t3, t2, t1)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + (response.results[i]['id_ef']+2000)).on('click',function(){
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
                            $('#' + (response.results[i]['id_ef']+1000)).on('click',function(){

                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();

                                $('#id_ef2').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#title2').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#company2').val($(this).closest('tr').find('td:eq(3)').text());

                            })
                            $('#' + response.results[i]['id_ef']).click(function () {
                                var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                    $.ajax(
                                        {
                                            url: "/confirm1-entering/" + id_exit,
                                            type: 'GET',
                                            data: {
                                                "id": id_exit,
                                                "_token": token,
                                            },
                                            success: function () {
                                                $('.toast').toast('show');
                                                $("#mytoast").text("درخواست انتخابی تایید و برای مسئول ایمنی ارسال گردید")
                                            }
                                        });

                                $(this).closest('tr').remove()

                            })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#for_herasat').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level2-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد ارسالی برای مسئول ایمنی</p>')
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 30%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 30%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            var day=response.results[i]['date_shamsi'].substr(6,2)
                            var month=response.results[i]['date_shamsi'].substr(4,2)
                            var year=response.results[i]['date_shamsi'].substr(0,4)
                            date_shamsi = $('<td style="text-align: right;padding-right: 5px;width: 12%" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            //detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            // t3 = $('<td style="width: 14%"></td>')
                            // t1 = $('<td style="width: 8%"></td>')
                            //edit1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef'])
                            //t1.append(edit1)
                            t2 = $('<td style="width: 17%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            // t3.append(detail)
                            row.append(id_ef,date_shamsi,title, company,l_name,detail, t2)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ef']).click(function () {
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartabl-entering/" + id_ef,
                                        type: 'GET',
                                        data: {
                                            "id": id_ef,
                                            "_token": token,
                                        },
                                        success: function () {
                                            bootstrap.Toast.Default.delay = 3000
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل موارد دریافتی بازگشت")
                                        }
                                    });
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#for_requester').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/not-confirmed-boss2-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که توسط شما تایید نشده و بازگشت داده شده</p>')
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 25%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 20%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            var day=response.results[i]['date_shamsi'].substr(6,2)
                            var month=response.results[i]['date_shamsi'].substr(4,2)
                            var year=response.results[i]['date_shamsi'].substr(0,4)
                            date_shamsi = $('<td style="text-align: right;padding-right: 5px;width: 12%" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            //detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 14%"></td>')
                            t1 = $('<td style="width: 8%"></td>')
                            //edit1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef'])
                            //t1.append(edit1)
                            t2 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            t3.append(detail)
                            row.append(id_ef,date_shamsi,title, company,l_name,detail, t2)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ef']).click(function () {
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartabl-entering/" + id_ef,
                                        type: 'GET',
                                        data: {
                                            "id": id_ef,
                                            "_token": token,
                                        },
                                        success: function () {
                                            bootstrap.Toast.Default.delay = 3000
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل موارد دریافتی بازگشت")
                                        }
                                    });
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#from_herasat').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/not-confirmed-boss3-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست مواردی که توسط مدیرحراست تایید نشده و بازگشت داده شده</p>')
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var reason2 = ''
                        var l_name = ''
                        var t1 = ''
                        var del2 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">علت عدم تایید از طرف مسئول حراست</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 35%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            reason2 = $('<td style="width: 35%;text-align: right;padding-right: 5px;color:red">' +response.results[i]['reason2'] + '</td>')
                            var day=response.results[i]['date_shamsi'].substr(6,2)
                            var month=response.results[i]['date_shamsi'].substr(4,2)
                            var year=response.results[i]['date_shamsi'].substr(0,4)
                            date_shamsi = $('<td style="text-align: right;padding-right: 5px;width: 12%" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            //detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            //t3 = $('<td style="width: 14%"></td>')
                            //t1 = $('<td style="width: 10%"></td>')
                            //edit1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef'] + 1000)
                            del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef'])
                            //t1.append(edit1)
                            t2 = $('<td style="width: 15%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            //t3.append(detail)
                            row.append(id_ef,date_shamsi,title, reason2,t2)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ef']).click(function () {
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartabl-entering/" + id_ef,
                                        type: 'GET',
                                        data: {
                                            "id": id_ef,
                                            "_token": token,
                                        },
                                        success: function () {
                                            bootstrap.Toast.Default.delay = 3000
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل موارد دریافتی بازگشت")
                                        }
                                    });
                                $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#total_part').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/totalparts',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست کلیه موارد ارسالی در بخش شما</p>')
                        var id_ef = ''
                        var date_shamsi = ''
                        var title = ''
                        var company = ''
                        var edit1 = ''
                        var del2 = ''
                        var detail2 = ''
                        var history=''
                        var t1 = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;width:5%">شماره درخواست</td><td style="border-left:1px white solid;;width:10%">تاریخ درخواست</td><td style="border-left:1px white solid;width:36%">عنوان فعالیت</td><td style="border-left:1px white solid;width:27%">نام شرکت یا مرکز</td><td style="border-left:1px white solid;width:12%">#</td><td style="border-left:1px white solid;width:11%">#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_ef = $('<td class="id_exit">' + response.results[i]['id_ef'] + '</td>')
                            var day=response.results[i]['date_shamsi'].substr(6,2)
                            var month=response.results[i]['date_shamsi'].substr(4,2)
                            var year=response.results[i]['date_shamsi'].substr(0,4)
                            date_shamsi = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            title = $('<td>' +response.results[i]['title'] + '</td>')
                            company = $('<td style="text-align: right">' + response.results[i]['company'] + '</td>')
                            // t1 = $('<td style="width:5%"></td>')
                            detail2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width:100%" data-toggle="modal" data-target="#myModal4">مشاهده جزئیات</button>').attr('id',  response.results[i]['id_ef'] + 2000)
                            edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width:100%" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',  response.results[i]['id_ef'] + 3000)
                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width:100%">حذف</button>').attr('id',  response.results[i]['id_ef'])
                            history = $('<button type="button" class="btn-sm btn-info history" style="font-family: Tahoma;font-size: smaller;text-align: center;width:100%">گردش مدرک</button>').attr('id',  response.results[i]['id_ef']+4000)
                            // t1.append(edit1)
                            // t2 = $('<td style="width:5%"></td>')
                            t3 = $('<td></td>')
                            t4 = $('<td></td>')
                            row = $('<tr class="report_row"></tr>')
                            // t2.append(del2)
                            t3.append(detail2)
                            t4.append(history)
                            row.append(id_ef, date_shamsi, title, company, t3,t4)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + (response.results[i]['id_ef']+2000)).on('click',function(){
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                $("#id_ef_del").val(0)
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
                                            $("#cars_table2").append(row)

                                        }

                                        height1=(($('#cars_table tr').length)*25).toString()+'px'
                                        height2=(($('#cars_div tr').length)*25+11).toString()+'px'
                                        $("#cars_table").css('height',height1)
                                        $("#cars_div").css('height',height2)




                                        var id_ei=""
                                        var description1=""

                                        $(".els_row").remove();
                                        for(var z = 0; z <response.els.length; z++) {
                                            id_ei = $('<td class="el2">' + response.els[z]['id_ei'] + '</td>')
                                            description1 = $('<td class="el2">' +response.els[z]['description'] + '</td>')
                                            row = $('<tr class="els_row" style="font-family: Tahoma;font-size: 12px;color: black;text-align: right"></tr>')
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
                                            id_ee = $('<td class="eq">' + response.eqs[f]['id_ee'] + '</td>')
                                            description2 = $('<td class="eq">' +response.eqs[f]['description'] + '</td>')
                                            row = $('<tr class="eqs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                            row.append(id_ee,description2)
                                            $("#eq_table2").append(row)

                                        }


                                        height1=(($('#eq_table2 tr').length)*25).toString()+'px'
                                        height2=(($('#eq_table2 tr').length)*25+11).toString()+'px'
                                        $("#eq_table2").css('height',height1)
                                        $("#eq_div").css('height',height2)



                                        var id_eup=""
                                        var description3=""

                                        $(".equs_row").remove();

                                        for(var g = 0; g <response.equs.length; g++) {
                                            id_eup = $('<td class="equ">' + response.equs[g]['id_eup'] + '</td>')
                                            description3 = $('<td class="equ"><a href="./documents/'+response.equs[g]['id_eup']+'.pdf">'+response.equs[g]['description']+'</a> </td>')
                                            row = $('<tr class="equs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                            row.append(id_eup,description3)
                                            $("#equ2_table").append(row)

                                        }


                                        height1=(($('#equ2_table tr').length)*25).toString()+'px'
                                        height2=(($('#equ2_table tr').length)*25+11).toString()+'px'
                                        $("#eq2_table").css('height',height1)
                                        $("#equ_div").css('height',height2)


                                    }
                                })
                            })
                            $('#' + (response.results[i]['id_ef']+4000)).on('click',function(){
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
                                        var row = ''
                                        $(".workflowrows").remove();
                                        for(var i = 0; i < response.results.length; i++) {
                                            description = $('<td style="width: 80%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['description'] + '</td>')
                                            date_shamsi = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['date_shamsi'] + '</td>')
                                            time = $('<td style="width: 10%;font-family: Tahoma;font-size: 10pt;text-align: right">' + response.results[i]['created_at'].substring(11,19) + '</td>')
                                            row = $('<tr class="workflowrows"></tr>')
                                            row.append(date_shamsi,time,description)
                                            $("#workflow").append(row)
                                        }
                                    }
                                })
                            })
                        }
                        // $(".mylist").hide();
                        // $(".mylist2").hide();
                        // $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }
                })
            })
            $("#edit_form_request").on('submit',function(event) {

                 event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/returnform-entering",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#myModal2').modal('toggle');
                        // refresh page--
                        $.ajax({
                            url: '/level1-entering',
                            method:'GET',
                            success: function (response) {
                                $(".report_row").remove();
                                $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                                var id_ef = ''
                                var date_shamsi = ''
                                var detail = ''
                                var title = ''
                                var company = ''
                                var l_name = ''
                                var t1 = ''
                                var edit1 = ''
                                var del2 = ''
                                var t2 = ''
                                var t3 = ''
                                var row = ''
                                var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                                $("#report_table").append(row_th)

                                for(var i = 0; i < response.results.length; i++) {
                                    id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                                    title = $('<td style="width: 25%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                                    company = $('<td style="width: 20%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                                    date_shamsi = $('<td style="width: 10%">' +response.results[i]['date_shamsi'] + '</td>')
                                    detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                                    for(var z = 0; z < response.users.length; z++) {
                                        if(response.users[z]['id']==response.results[i]['id_user']){
                                            l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                            break;
                                        }

                                    }
                                    t3 = $('<td style="width: 14%"></td>')
                                    t1 = $('<td style="width: 8%"></td>')
                                    edit1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef'] + 1000)
                                    del2 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">تایید</button>').attr('id',  response.results[i]['id_ef'])
                                    t1.append(edit1)
                                    t2 = $('<td style="width: 8%"></td>')
                                    row = $('<tr class="report_row"></tr>')
                                    t2.append(del2)
                                    t3.append(detail)
                                    row.append(id_ef,date_shamsi,title, company,l_name,t3, t2, t1)
                                    $("#report_table").append(row)
                                    $("#editlist").css("margin-top","100px");
                                    $('#' + (response.results[i]['id_ef']+1000)).on('click',function(){

                                        $('#ajax-alert1').hide();
                                        $('#ajax-alert2').hide();
                                        $('#ajax-alert3').hide();

                                        $('#id_ef2').val($(this).closest('tr').find('td:eq(0)').text());
                                        $('#title2').val($(this).closest('tr').find('td:eq(2)').text());
                                        $('#company2').val($(this).closest('tr').find('td:eq(3)').text());

                                    })
                                    $('#' + response.results[i]['id_ef']).click(function () {
                                        var id_exit = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        //$('.toast').toast('show');
                                        $.ajax(
                                            {
                                                url: "/confirm1-entering/" + id_exit,
                                                type: 'GET',
                                                data: {
                                                    "id": id_exit,
                                                    "_token": token,
                                                },
                                                success: function () {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی تایید و برای مدیر نیروگاه ارسال گردید")
                                                }
                                            });

                                        $(this).closest('tr').remove()

                                    })





                                }
                                $(".mylist").hide();
                                $(".mylist2").hide();
                                $(".register").hide();
                                $(".mylist2").fadeToggle(2000);
                            }})
                        //---------------
                        $('#ajax-alert1').hide();
                        $('#ajax-alert2').hide();
                        $('#ajax-alert3').addClass('alert-primary').show(function(){
                        $(this).html("درخواست انتخاب شده بازگشت داده شد و دلیل عدم تایید مشخص گردید");
                        });
                        // $("#id_exit2").val('')
                        // $("#description2").val('')
                        // $("#origin_destination2").val('')
                        // $("#id_goods_type").text('')
                        $("#reason1").val('')


                    }
                });
            });
            $(".isclicked1").on('focus',function (event) {
                $('#ajax-alert1').hide();
                $('#ajax-alert2').hide();
                $('#ajax-alert3').hide();
            })



        });
    </script>

        <div class="row mylist" style="margin: auto;width:80%;display: none">
            <div class="col-12 bg-info" style="height: 35px;margin-top: 30px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right"><p id="title" style="margin-top: 7px;"></p></div>

        </div>
    <!-- List of content -->
        <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
          <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
            <table id="request_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                <tr class="bg-primary" style="color: white">
                    <td>شماره درخواست</td>
                    <td>تاریخ درخواست</td>
                    <td>شرح درخواست</td>
                    <td>تعداد موارد</td>
                    <td>شماره جمعداری</td>
                    <td>نوع قطعه</td>
                    <td>همراه بازگشت</td>
                    <td>#</td>
                    <td>#</td>
                </tr>
            </table>
          </div>
        </div>
    <!-- Edit form -->
        <div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین علت عدم تایید</p></div>
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
                    <form method="post" encType="multipart/form-data" id="edit_form_request" action="{{route('returnform.edit')}}">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" id="id_ef2"  name="id_ef2">
                        <div class="row" style="height: 20px;margin-top: 10px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">مراجعه از:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" class="form-control" id="company2" name="company2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                            <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">علت درخواست:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-12">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" class="form-control" id="title2"  name="title2" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                </div>
                            </div>
                        </div>

                        <div class="row" style="height: 10px;margin-top: 10px">
                            <div class="col">
                                <p style="text-align: right;font-family: Tahoma;font-size: small">علت عدم تایید:</p>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 12px;height: 20px">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" maxlength="50" data-toggle="tooltip" data-placement="right" required title="در اینجا علت عدم تایید وارد شود" class="form-control" id="reason1"  name="reason1" style="direction:rtl;font-family:Tahoma;font-size:small;">
                                </div>
                            </div>

                        </div>


                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="hidden" class="form-control" id="jamdari_no2"  name="jamdari_no2" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" value={{old('jamdari_no')}}>
                                </div>
                            </div>
                            <div class="col" style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary" id="btnupdate" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
                            </div>
                        </div>

                    </form>
                    <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px">

                </div>

            </div>
        </div>
    </div>
    <!-- Title of report -->
    <div class="row mylist2" style="margin: auto;width:100%;display: none;margin-top: 10px">
        <div class="col-12" id="title_report" style="height: 35px;margin-top: 10px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color:rgb(14,53,126)"></div>
    </div>
    <!-- content of report -->
    <div class="row mylist2" style="margin: auto;width:100%;height:302px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
        <div class="col-12" style="direction: rtl;height: 300px;overflow-y: scroll;">
            <table id="report_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
        </div>
        <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
            <div class="toast-body"><p id="mytoast" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
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
@endsection
