@extends('layouts.entering.app_imeni_reciever_entering')
@section('content')
    <script>
        $(document).ready(function(){
            bootstrap.Toast.Default.delay = 3000
            $('#first_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level2-imeni_entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت بررسی و ارسال</p>')
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var confirm=''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t4=''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            day=response.results[i]['date_shamsi'].substr(6,2)
                            month=response.results[i]['date_shamsi'].substr(4,2)
                            year=response.results[i]['date_shamsi'].substr(0,4)
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 25%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 17%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 9%">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 13%"></td>')
                            t4 = $('<td style="width: 10%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            del2 = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#p_modal">لیست نفرات</button>').attr('id',  response.results[i]['id_ef'])
                            confirm = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">ارسال</button>').attr('id',  response.results[i]['id_ef']+6000)
                            t2 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            t3.append(detail)
                            t4.append(confirm)
                            row.append(id_ef,date_shamsi,title, company,l_name,t3,t2,t4)
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
                            $('#' + (response.results[i]['id_ef']+6000)).on('click',function(){
                                    var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                    var token = $("meta[name='csrf-token']").attr("content");
                                    $.ajax(
                                        {
                                            url: "/confirm_imeni-entering/" + id_ef,
                                            type: 'GET',
                                            data: {
                                                "id": id_ef,
                                                "_token": token,
                                            },
                                            success: function () {
                                                $('.toast').toast('show');
                                                $("#mytoast").text("درخواست انتخابی تایید و برای مسئول حراست ارسال گردید")
                                            }
                                        });

                                    $(this).closest('tr').remove()

                            })
                            $('#' + response.results[i]['id_ef']).click(function () {
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                event.preventDefault();
                                $.ajax({
                                    url: '/persons_recieve/'+id_ef,
                                    method:'GET',
                                    success: function (response) {
                                        $(".report_row2").remove();
                                        var id_ep = ''
                                        var f_name = ''
                                        var l_name = ''
                                        var title = ''
                                        var condition = ''
                                        var t4 = ''
                                        var row = ''
                                        var row_th = '<tr class="bg-info report_row2" style="color: white"><td style="border-left:1px white solid;" class="persons_title">کد شخص</td><td style="border-left:1px white solid;" class="persons_title">نام</td><td style="border-left:1px white solid;" class="persons_title">نام خانوادگی</td><td style="border-left:1px white solid;" class="persons_title">تحت عنوان</td><td style="border-left:1px white solid;" class="persons_title">#</td></tr>'
                                        $("#person_table2").append(row_th)

                                        for (var i = 0; i < response.results.length; i++) {
                                            id_ep = $('<td style="width: 15%" class="persons_col">' + response.results[i]['id_ep'] + '</td>')
                                            f_name = $('<td style="width: 20%" class="persons_col">' + response.results[i]['f_name'] + '</td>')
                                            l_name = $('<td style="width: 25%" class="persons_col">' + response.results[i]['l_name'] + '</td>')
                                            t4 = $('<td style="width: 25%" class="persons_col"></td>')
                                            for(var z = 0; z < response.titles.length; z++) {
                                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                                    title = $('<td class="persons_col" style="width: 15%">' + response.titles[z]['description'] + '</td>')
                                                    break;
                                                }

                                            }
                                            condition = $('<button type="button" class="btn-sm btn-primary condition" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#c_modal">الزامات HSE</button>').attr('id', response.results[i]['id_ep'])
                                            row = $('<tr class="report_row2" style="color: white"></tr>')
                                            t4.append(condition)
                                            row.append(id_ep, f_name, l_name,title, t4)
                                            $("#person_table2").append(row)
                                            $('#' + response.results[i]['id_ep']).click(function () {
                                                $("#cond1").val(0)
                                                $("#cond2").val(0)
                                                $("#cond3").val(0)
                                                $("#cond4").val(0)
                                                $("#cond5").val(0)
                                                $("#cond6").val(0)
                                                $("#cardno").val(0)
                                                $("#cond1").attr('checked',false)
                                                $("#cond2").attr('checked',false)
                                                $("#cond3").attr('checked',false)
                                                $("#cond4").attr('checked',false)
                                                $("#cond5").attr('checked',false)
                                                $("#cond6").attr('checked',false)
                                                $("#cardno").val(0)
                                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                                $("#id_ep2").val(id_ep)
                                                event.preventDefault();
                                                $.ajax({
                                                    url: '/hefazat_cond/'+id_ep,
                                                    method: 'GET',
                                                    success: function (response) {
                                                       $("#cond41").attr('value',response.cond4)
                                                       $("#cond51").attr('value',response.cond5)
                                                       $("#id_ef111").html(response.id_ef)
                                                       $("#title111").html(response.title)
                                                       $("#company111").html(response.company)
                                                       $("#f_name112").html(response.f_name)
                                                       $("#l_name112").html(response.l_name)
                                                       $("#id_ep112").html(id_ep)
                                                       if(response.cond4==1){$("#cond4").attr('checked',true)}else{$("#cond4").attr('checked',false)}
                                                       if(response.cond5==1){$("#cond5").attr('checked',true)}else{$("#cond5").attr('checked',false)}
                                                    }
                                                })


                                            })
                                        }
                                    }
                                })

                            })
                            // $('#' + response.results[i]['id_ef']+6000).click(function () {
                            //     alert('hi')
                            //     // var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                            //     // alert(id_ef)
                            //     // var token = $("meta[name='csrf-token']").attr("content");
                            //     // $.ajax(
                            //     //     {
                            //     //         url: "/confirm_imeni-entering/" + id_ef,
                            //     //         type: 'GET',
                            //     //         data: {
                            //     //             "id": id_ef,
                            //     //             "_token": token,
                            //     //         },
                            //     //         success: function () {
                            //     //             $('.toast').toast('show');
                            //     //             $("#mytoast").text("درخواست انتخابی تایید و برای مسئول حراست ارسال گردید")
                            //     //         }
                            //     //     });
                            //     //
                            //     // $(this).closest('tr').remove()
                            //
                            // })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#second_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level-herasatboss-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white"> لیست موارد ارسال شده برای مسئول حراست</p>')
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var confirm=''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var t4=''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            day=response.results[i]['date_shamsi'].substr(6,2)
                            month=response.results[i]['date_shamsi'].substr(4,2)
                            year=response.results[i]['date_shamsi'].substr(0,4)
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 25%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 20%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 10%">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 15%"></td>')
                            t4 = $('<td style="width: 20%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            confirm = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef']+6000)
                            row = $('<tr class="report_row"></tr>')
                            t3.append(detail)
                            t4.append(confirm)
                            row.append(id_ef,date_shamsi,title, company,l_name,t3,t4)
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
                            $('#' + (response.results[i]['id_ef']+6000)).on('click',function(){
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/kartablherasat-entering/" + id_ef,
                                        type: 'GET',
                                        data: {
                                            "id": id_ef,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی مجددا به کارتابل بازگشت داده شد")
                                        }
                                    });

                                $(this).closest('tr').remove()

                            })
                            // $('#' + response.results[i]['id_ef']).click(function () {
                            //     var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                            //     event.preventDefault();
                            //     $.ajax({
                            //         url: '/persons_recieve/'+id_ef,
                            //         method:'GET',
                            //         success: function (response) {
                            //             $(".report_row2").remove();
                            //             var id_ep = ''
                            //             var f_name = ''
                            //             var l_name = ''
                            //             var title = ''
                            //             var condition = ''
                            //             var t4 = ''
                            //             var row = ''
                            //             var row_th = '<tr class="bg-info report_row2" style="color: white"><td style="border-left:1px white solid;" class="persons_title">کد شخص</td><td style="border-left:1px white solid;" class="persons_title">نام</td><td style="border-left:1px white solid;" class="persons_title">نام خانوادگی</td><td style="border-left:1px white solid;" class="persons_title">تحت عنوان</td><td style="border-left:1px white solid;" class="persons_title">#</td></tr>'
                            //             $("#person_table2").append(row_th)
                            //
                            //             for (var i = 0; i < response.results.length; i++) {
                            //                 id_ep = $('<td style="width: 15%" class="persons_col">' + response.results[i]['id_ep'] + '</td>')
                            //                 f_name = $('<td style="width: 20%" class="persons_col">' + response.results[i]['f_name'] + '</td>')
                            //                 l_name = $('<td style="width: 25%" class="persons_col">' + response.results[i]['l_name'] + '</td>')
                            //                 t4 = $('<td style="width: 25%" class="persons_col"></td>')
                            //                 for(var z = 0; z < response.titles.length; z++) {
                            //                     if(response.titles[z]['id_et']==response.results[i]['id_et']){
                            //                         title = $('<td class="persons_col" style="width: 15%">' + response.titles[z]['description'] + '</td>')
                            //                         break;
                            //                     }
                            //
                            //                 }
                            //                 condition = $('<button type="button" class="btn-sm btn-primary condition" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#c_modal">الزامات حفاظت فیزیکی</button>').attr('id', response.results[i]['id_ep'])
                            //                 row = $('<tr class="report_row2" style="color: white"></tr>')
                            //                 t4.append(condition)
                            //                 row.append(id_ep, f_name, l_name,title, t4)
                            //                 $("#person_table2").append(row)
                            //                 $('#' + response.results[i]['id_ep']).click(function () {
                            //                     //$( 'input[type="checkbox"]' ).prop('checked', false);
                            //                     //$( 'input[type="checkbox"]' ).prop('value', 0);
                            //                     $("#cond1").val(0)
                            //                     $("#cond2").val(0)
                            //                     $("#cond3").val(0)
                            //                     $("#cond4").val(0)
                            //                     $("#cond5").val(0)
                            //                     $("#cond6").val(0)
                            //                     $("#cardno").val(0)
                            //                     $("#cond1").attr('checked',false)
                            //                     $("#cond2").attr('checked',false)
                            //                     $("#cond3").attr('checked',false)
                            //                     $("#cond4").attr('checked',false)
                            //                     $("#cond5").attr('checked',false)
                            //                     $("#cond6").attr('checked',false)
                            //                     $("#cardno").val(0)
                            //                     var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                            //                     $("#id_ep2").val(id_ep)
                            //                     event.preventDefault();
                            //                     $.ajax({
                            //                         url: '/hefazat_cond/'+id_ep,
                            //                         method: 'GET',
                            //                         success: function (response) {
                            //                             $("#cond11").attr('value',response.cond1)
                            //                             $("#cond21").attr('value',response.cond2)
                            //                             $("#cond31").attr('value',response.cond3)
                            //                             $("#cond41").attr('value',response.cond4)
                            //                             $("#cond51").attr('value',response.cond5)
                            //                             $("#cond61").attr('value',response.cond6)
                            //                             $("#id_ef111").html(response.id_ef)
                            //                             $("#title111").html(response.title)
                            //                             $("#company111").html(response.company)
                            //                             $("#f_name112").html(response.f_name)
                            //                             $("#l_name112").html(response.l_name)
                            //                             $("#id_ep112").html(id_ep)
                            //                             $("#cardno").val(response.cardno)
                            //                             if(response.cond1==1){$("#cond1").attr('checked',true)}else{$("#cond1").attr('checked',false)}
                            //                             if(response.cond2==1){$("#cond2").attr('checked',true)}else{$("#cond2").attr('checked',false)}
                            //                             if(response.cond3==1){$("#cond3").attr('checked',true)}else{$("#cond3").attr('checked',false)}
                            //                             if(response.cond4==1){$("#cond4").attr('checked',true)}else{$("#cond4").attr('checked',false)}
                            //                             if(response.cond5==1){$("#cond5").attr('checked',true)}else{$("#cond5").attr('checked',false)}
                            //                             if(response.cond6==1){$("#cond6").attr('checked',true)}else{$("#cond6").attr('checked',false)}
                            //                             if(response.cond1==1){$("#cardno").show()}else{$("#cardno").hide()}
                            //                         }
                            //                     })
                            //
                            //
                            //                 })
                            //             }
                            //         }
                            //     })
                            //
                            // })
                            // $('#' + response.results[i]['id_ef']+6000).click(function () {
                            //     alert('hi')
                            //     // var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                            //     // alert(id_ef)
                            //     // var token = $("meta[name='csrf-token']").attr("content");
                            //     // $.ajax(
                            //     //     {
                            //     //         url: "/confirm_imeni-entering/" + id_ef,
                            //     //         type: 'GET',
                            //     //         data: {
                            //     //             "id": id_ef,
                            //     //             "_token": token,
                            //     //         },
                            //     //         success: function () {
                            //     //             $('.toast').toast('show');
                            //     //             $("#mytoast").text("درخواست انتخابی تایید و برای مسئول حراست ارسال گردید")
                            //     //         }
                            //     //     });
                            //     //
                            //     // $(this).closest('tr').remove()
                            //
                            // })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#for_requester2').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/not-confirmed-imeni-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد تایید نشده توسط مسئول حراست</p>')
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var reason = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var confirm = ''
                        var t4 = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">علت عدم تایید</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            day=response.results[i]['date_shamsi'].substr(6,2)
                            month=response.results[i]['date_shamsi'].substr(4,2)
                            year=response.results[i]['date_shamsi'].substr(0,4)
                            id_ef = $('<td style="width: 5%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 20%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 15%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 10%">' + year+'/'+month+'/'+day + '</td>')
                            reason=$('<td style="width: 23%;text-align: right;padding-right: 5px;color:red">' + response.results[i]['reason2'] + '</td>')
                            // for(var z = 0; z < response.users.length; z++) {
                            //     if(response.users[z]['id']==response.results[i]['id_user']){
                            //         l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                            //         break;
                            //     }
                            //
                            // }
                            t3 = $('<td style="width: 13%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            // del2 = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#p_modal">لیست نفرات</button>').attr('id',  response.results[i]['id_ef'])
                            confirm = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef']+3000)
                            // t2 = $('<td style="width: 12%"></td>')
                            t4 = $('<td style="width: 19%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            // t2.append(del2)
                            t3.append(detail)
                            t4.append(confirm)
                            row.append(id_ef,date_shamsi,title, company,reason,t3,t4)
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
                            $('#' + response.results[i]['id_ef']).click(function () {
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                event.preventDefault();
                                $.ajax({
                                    url: '/persons_recieve/'+id_ef,
                                    method:'GET',
                                    success: function (response) {
                                        $(".report_row2").remove();
                                        var id_ep = ''
                                        var f_name = ''
                                        var l_name = ''
                                        var title = ''
                                        var condition = ''
                                        var t4 = ''
                                        var row = ''
                                        var row_th = '<tr class="bg-info report_row2" style="color: white"><td style="border-left:1px white solid;" class="persons_title">کد شخص</td><td style="border-left:1px white solid;" class="persons_title">نام</td><td style="border-left:1px white solid;" class="persons_title">نام خانوادگی</td><td style="border-left:1px white solid;" class="persons_title">تحت عنوان</td><td style="border-left:1px white solid;" class="persons_title">#</td></tr>'
                                        $("#person_table2").append(row_th)

                                        for (var i = 0; i < response.results.length; i++) {
                                            id_ep = $('<td style="width: 15%" class="persons_col">' + response.results[i]['id_ep'] + '</td>')
                                            f_name = $('<td style="width: 20%" class="persons_col">' + response.results[i]['f_name'] + '</td>')
                                            l_name = $('<td style="width: 25%" class="persons_col">' + response.results[i]['l_name'] + '</td>')
                                            t4 = $('<td style="width: 25%" class="persons_col"></td>')
                                            for(var z = 0; z < response.titles.length; z++) {
                                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                                    title = $('<td class="persons_col" style="width: 15%">' + response.titles[z]['description'] + '</td>')
                                                    break;
                                                }

                                            }
                                            condition = $('<button type="button" class="btn-sm btn-primary condition" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#c_modal">الزامات حفاظت فیزیکی</button>').attr('id', response.results[i]['id_ep'])
                                            row = $('<tr class="report_row2" style="color: white"></tr>')
                                            t4.append(condition)
                                            row.append(id_ep, f_name, l_name,title, t4)
                                            $("#person_table2").append(row)
                                            $('#' + response.results[i]['id_ep']).click(function () {
                                                //$( 'input[type="checkbox"]' ).prop('checked', false);
                                                //$( 'input[type="checkbox"]' ).prop('value', 0);
                                                $("#cond1").val(0)
                                                $("#cond2").val(0)
                                                $("#cond3").val(0)
                                                $("#cond4").val(0)
                                                $("#cond5").val(0)
                                                $("#cond6").val(0)
                                                $("#cardno").val(0)
                                                $("#cond1").attr('checked',false)
                                                $("#cond2").attr('checked',false)
                                                $("#cond3").attr('checked',false)
                                                $("#cond4").attr('checked',false)
                                                $("#cond5").attr('checked',false)
                                                $("#cond6").attr('checked',false)
                                                $("#cardno").val(0)
                                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                                $("#id_ep2").val(id_ep)
                                                event.preventDefault();
                                                $.ajax({
                                                    url: '/hefazat_cond/'+id_ep,
                                                    method: 'GET',
                                                    success: function (response) {
                                                        $("#cond11").attr('value',response.cond1)
                                                        $("#cond21").attr('value',response.cond2)
                                                        $("#cond31").attr('value',response.cond3)
                                                        $("#cond41").attr('value',response.cond4)
                                                        $("#cond51").attr('value',response.cond5)
                                                        $("#cond61").attr('value',response.cond6)
                                                        $("#id_ef111").html(response.id_ef)
                                                        $("#title111").html(response.title)
                                                        $("#company111").html(response.company)
                                                        $("#f_name112").html(response.f_name)
                                                        $("#l_name112").html(response.l_name)
                                                        $("#id_ep112").html(id_ep)
                                                        $("#cardno").val(response.cardno)
                                                        if(response.cond1==1){$("#cond1").attr('checked',true)}else{$("#cond1").attr('checked',false)}
                                                        if(response.cond2==1){$("#cond2").attr('checked',true)}else{$("#cond2").attr('checked',false)}
                                                        if(response.cond3==1){$("#cond3").attr('checked',true)}else{$("#cond3").attr('checked',false)}
                                                        if(response.cond4==1){$("#cond4").attr('checked',true)}else{$("#cond4").attr('checked',false)}
                                                        if(response.cond5==1){$("#cond5").attr('checked',true)}else{$("#cond5").attr('checked',false)}
                                                        if(response.cond6==1){$("#cond6").attr('checked',true)}else{$("#cond6").attr('checked',false)}
                                                        if(response.cond1==1){$("#cardno").show()}else{$("#cardno").hide()}
                                                    }
                                                })


                                            })
                                        }
                                    }
                                })

                            })
                            $('#' + (response.results[i]['id_ef']+3000)).on('click',function(){
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/kartablherasat-entering/" + id_ef,
                                        type: 'GET',
                                        data: {
                                            "id": id_ef,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("بازگشت به کارتابل")
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
            $("#updatecondition").on('submit',function(event) {
                if ($("#cond1").is(":checked") == true) {
                    $('#cond11').val(1);
                    $('#cardno').fadeIn()
                } else {
                    $('#cond11').val(0);
                    $('#cardno').val(0)
                    $('#cardno').fadeOut()
                }
                if ($("#cond2").is(":checked") == true) {
                    $('#cond21').val(1);
                } else {
                    $('#cond21').val(0);
                }
                if ($("#cond3").is(":checked") == true) {
                    $('#cond31').val(1);
                } else {
                    $('#cond31').val(0);
                }
                if ($("#cond4").is(":checked") == true) {
                    $('#cond41').val(1);
                } else {
                    $('#cond41').val(0);
                }
                if ($("#cond5").is(":checked") == true) {
                    $('#cond51').val(1);
                } else {
                    $('#cond51').val(0);
                }
                if ($("#cond6").is(":checked") == true) {
                    $('#cond61').val(1);
                } else {
                    $('#cond61').val(0);
                }
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/update-conditions2",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function () {
                        $('.toast').show()
                        $('.toast').toast('show');
                        $("#mytoast22").html("موارد انتخابی در مورد این فرد لحاظ گردید")
                    }
                });
            });
            $('#c_modal').on('hidden.bs.modal', function () {
                $('#updatecondition').trigger("reset");
            });
        });
    </script>

        <div class="row mylist" style="margin: auto;width:80%;display: none">
            <div class="col-12 bg-info" style="height: 35px;margin-top: 30px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right"><p id="title" style="margin-top: 7px;"></p></div>
        </div>
    <!-- List of content -->
        <div class="row mylist" style="margin: auto;width:80%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
          <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
            <table id="request_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                <tr class="bg-primary" style="color: white">
                    <td style="border-left:1px white solid;">شماره درخواست</td>
                    <td style="border-left:1px white solid;">تاریخ درخواست</td>
                    <td style="border-left:1px white solid;">شرح درخواست</td>
                    <td style="border-left:1px white solid;">تعداد موارد</td>
                    <td style="border-left:1px white solid;">شماره جمعداری</td>
                    <td style="border-left:1px white solid;">نوع قطعه</td>
                    <td style="border-left:1px white solid;">همراه بازگشت</td>
                    <td style="border-left:1px white solid;">#</td>
                    <td style="border-left:1px white solid;">#</td>
                </tr>
            </table>
          </div>
        </div>
    <!-- Edit form -->
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
    <div class="modal fade mt-3" id="p_modal" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 450px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height:35px;padding-top: 5px;width: 650px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فهرست نفرات مورد درخواست</p></div>
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
                <div class="container"  style="margin: auto;background-color:#3c525f;width: 650px ;height: 400px;;overflow-y: scroll">
                    <table class="table table-striped" id="person_table2" style="width: 600px">
                    </table>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:650px"></div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="c_modal" style="direction: rtl;margin-left: -50px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 10px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین الزامات HSE</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10">.</div>
                                <div class="col-2">
                                    <button id="btnupdate99" type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>

                <!-- Edit form -->
                <div class="container" id="reason_win111" style="margin: auto;background-color:lightgray;text-align: right;direction: ltr ;padding: 20px">
                    <div class="row" style="direction: rtl;font-family: Tahoma;font-size: smaller;color: #007be6">
                        <div class="col"><p style="display: inline;margin-left: 4px" id="f_name112"></p><p style="display: inline;">.</p><p style="display: inline;margin-right: 4px" id="l_name112"></p></div>
                    </div>
                    <div class="row mb-3" style="direction: rtl;font-family: Tahoma;font-size: smaller;color: #007be6">
                        <div class="col"><p style="display: inline;margin-left: 4px" id="title111"></p><p style="display: inline;">.مراجعه از</p><p style="display: inline;margin-right: 4px" id="company111"></p></div>
                    </div>
{{--                    <div class="row" style="margin-bottom: 5px">--}}
{{--                        <div id="person_div111" class="col" style="height:50px;direction: rtl">--}}
{{--                            <table id="person_table111" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">--}}
{{--                                <tr style="color: black">--}}
{{--                                    <td class="person" style="width: 5%">کد فرم</td>--}}
{{--                                    <td class="person" style="width: 10%">عنوان فعالیت</td>--}}
{{--                                    <td class="person" style="width: 14%">مراجعه از</td>--}}
{{--                                </tr>--}}
{{--                                <tr style="color: black">--}}
{{--                                    <td style="width: 5%"><p id="id_ef111"></p></td>--}}
{{--                                    <td style="width: 10%"><p id="title111"></p></td>--}}
{{--                                    <td style="width: 14%"><p id="company111"></p></td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row" style="margin-bottom: 5px">--}}
{{--                        <div id="person_div112" class="col" style="height:50px;direction: rtl">--}}
{{--                            <table id="person_table112" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">--}}
{{--                                <tr style="color: black">--}}
{{--                                    <td class="person" style="width: 5%">کد</td>--}}
{{--                                    <td class="person" style="width: 10%">نام</td>--}}
{{--                                    <td class="person" style="width: 14%">نام خانوادگی</td>--}}
{{--                                </tr>--}}
{{--                                <tr style="color: black">--}}
{{--                                    <td style="width: 5%"><p id="id_ep112"></p></td>--}}
{{--                                    <td style="width: 10%"><p id="f_name112"></p></td>--}}
{{--                                    <td style="width: 14%"><p id="l_name112"></p></td>--}}
{{--                                </tr>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <form method="post" encType="multipart/form-data" id="updatecondition" action="{{route('updatecondition.edit')}}">
                        {{csrf_field()}}
                        <input type="hidden" class="form-control" id="id_ep2"  name="id_ep2">
                        <input type="hidden" class="form-control" id="cond11"  name="cond11">
                        <input type="hidden" class="form-control" id="cond21"  name="cond21">
                        <input type="hidden" class="form-control" id="cond31"  name="cond31">
                        <input type="hidden" class="form-control" id="cond41"  name="cond41">
                        <input type="hidden" class="form-control" id="cond51"  name="cond51">
                        <input type="hidden" class="form-control" id="cond61"  name="cond61">
                        <input type="hidden" class="form-control" id="id_ep2"  name="id_ep">
{{--                        <div class="row">--}}
{{--                            <div class="col-4" style="text-align: right"><input type="number" class="form-control" id="cardno" name="cardno" style="font-family: Tahoma;font-size: smaller;width:42%;text-align: center;display: inline"><p style="font-family: Tahoma;font-size: smaller;direction: rtl;display: inline;margin-left: 2px">شماره کارت</p></div>--}}
{{--                            <div class="col-5" style="text-align: right"><p class="chk1" >كارت مهمان/بازديد تحويل شود</p></div>--}}
{{--                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond1" name="cond1" value=0 ></div>--}}

{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-9" style="text-align: right"><p class="chk1" >برگه تاييد ميزبان صادر شود</p></div>--}}
{{--                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond2" name="cond2" value=0 ></div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-9" style="text-align: right"><p class="chk1" >فرد/گروه توسط پرسنل حفاظت فيزيكي همراهي شود</p></div>--}}
{{--                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond3" name="cond3" value=0 ></div>--}}
{{--                        </div>--}}
                        <div class="row">
                            <div class="col-9" style="text-align: right"><p class="chk1" >در بدو ورود خودرو یا نفر با اداره ايمني و آتش نشاني هماهنگي نموده و پس از حضور ايمني وارد نيروگاه شوند</p></div>
                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond4" name="cond4" value=0 ></div>
                        </div>
                        <div class="row">
                            <div class="col-9" style="text-align: right"><p class="chk1" >فرد جهت آموزش نكات ايمني به اداره ايمني و آتش نشاني مراجعه نمايند</p></div>
                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond5" name="cond5" value=0 ></div>
                        </div>
{{--                        <div class="row">--}}
{{--                            <div class="col-9" style="text-align: right"><p class="chk1" >فرم ورود وسايل الكترونيكي/تجهيزات عملياتي صادر شود</p></div>--}}
{{--                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond6" name="cond6" value=0 ></div>--}}
{{--                        </div>--}}
                        <div class="row">
                            <div class="col-2" style="text-align: center"></div>
                            <div class="col-8" style="text-align: center">
                                <button type="submit" class="btn btn-success" id="btnupdate88" style="font-family: Tahoma;font-size: small;text-align: center;width: 100%">ثبت</button>
                                <div class="toast bg-info" style="margin-top:15px;border-radius: 10px;display: none">
                                    <div class="toast-body"><p id="mytoast22" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                                </div>
                            </div>
                            <div class="col-2" style="text-align: center"></div>
                        </div>

                    </form>

                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px">

                </div>

            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="personinfo" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">توضیحات</p></div>
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
                <div class="container"  style="margin: auto;background-color:white;width: 850px ;height: 260px;overflow-y: scroll">

                    <div class="row" style="margin-top: 10px">
                        <div id="person_div" class="col" style="height:50px">
                            <table id="person_table33" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
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
                    <div class="row" style="margin-top: 20px">
                        <div class="col" style="height:25px">
                            <div class="row">
                                <div class="col-4" style="height:25px">
                                    <p style="font-family: Tahoma;font-size: smaller;color: black">عنوان فعالیت:</p>
                                </div>
                                <div class="col-8" style="height:25px;text-align: right">
                                    <p id="title22" style="font-family: Tahoma;font-size: smaller;color: black"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="height:25px">
                            <div class="row">
                                <div class="col-4" style="height:25px">
                                    <p style="font-family: Tahoma;font-size: smaller;color: black">نام شرکت یا مرکز:</p>
                                </div>
                                <div class="col-8" style="height:25px;text-align: right">
                                    <p id="company22" style="font-family: Tahoma;font-size: smaller;color: black"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="first1" class="row" style="margin-top: 10px">
                        <div id="ec_txt" class="col" style="height:25px;text-align: right;">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">لیست الزامات HSE این فرد:</p>
                        </div>
                        <div id="ec_txt" class="col" style="height:25px;text-align: right;">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;display: inline">شماره کارت مهمان:</p>
                            <p id="cardno22" style="font-family: Tahoma;font-size: smaller;color: black;display: inline"></p>
                        </div>
                    </div>
                    <div id="first2" class="row" style="text-align: right">
                        <div id="cars_div" class="col" style="height:30px;text-align: right">
                            <table id="hefazat_table2" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="el" style="width: 10%">کد</td>
                                    <td class="el" style="width: 85%">الزامات HSE</td>
                                </tr>
                            </table>
                        </div>
                        <div id="el_div" class="col" style="height:50px;text-align: right">

                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>

@endsection
