@extends('layouts.entering.app_entering33')
@section('content')
{{--حراست نیروگاه--}}
    <script>
        function toEnglishNumber(strNum) {
            var pn = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
            var en = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
            var an = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
            var cache = strNum;
            for (var i = 0; i < 10; i++) {
                var regex_fa = new RegExp(pn[i], 'g');
                var regex_ar = new RegExp(an[i], 'g');
                cache = cache.replace(regex_fa, en[i]);
                cache = cache.replace(regex_ar, en[i]);
            }
            return cache;
        }
        $(document).ready(function(){
            $("#date_exit_shamsi1").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_exit_shamsi2").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $('#time_enter_edit').timepicker();
            // $('#time_enter').timepicker();
            $('#setTimeButton').on('click', function() {
                $('#time_enter_edit').timepicker('setTime', new Date());
            });
            $("#code_melli").prop('readonly', true)
            $("#date_shamsi_enter_edit").prop('readonly', true)
            $("#date_shamsi_enter").prop('readonly', true)
            bootstrap.Toast.Default.delay = 3000
            $('#notebook').click(function(event) {
                $('#daftar_modal').modal('toggle');
            })
            $('#first_report').click(function(event) {
                $('.mylist2').hide();
                $('.mylist3').hide();
                $('#codemelli_modal').modal("show");
            })
            $('#sixth_report333').click(function(event) {
                // $('.mylist2').hide();
                // $('.mylist3').hide();
                $('#dailyenter333').modal('toggle');
                $('#enter_info_ind').modal('toggle');

            })
            $('#sixth_report34').click(function(event) {

                $('.mylist2').hide();
                $('.mylist3').hide();
                $('#codemelli_modal').modal('toggle');
                $('#personinfo4').modal("show");
                var code_melli = $('#code_melli_s2').val();
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: "/personinfo3/" + code_melli+'/'+'0'+'/'+'99999999999999',
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
                                // edit = $('<button type="button" class="btn-sm btn-info" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#dailyenter2">اصلاح</button>').attr('id',  response.individuals[i]['i_ed']+1000)
                                // del = $('<button type="button" class="btn-sm btn-danger" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',  response.individuals[i]['i_ed']+2000)
                                t1 = $('<td style="width: 15%" class="personinfo2"></td>')
                                t2 = $('<td style="width: 15%" class="personinfo2"></td>')
                                // t1.append(edit)
                                // t2.append(del)
                                row = $('<tr class="report_row"></tr>')
                                row.append(id_ed,enter_exit,date,time,enter_exit_val)
                                $("#person_table66").append(row)//data-toggle="modal" data-target="#personinfo"
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
            $('#sixth_report35').click(function(event) {
                $('.mylist2').hide();
                $('.mylist3').hide();
                $('#codemelli_modal2').modal('toggle');
                $('#personinfo5').modal("show");

                var code_melli = $('#code_melli_s3').val();

                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: "/personinfo4/" + code_melli,
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
                                edit = $('<button type="button"  disabled class="btn-sm btn-info" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#dailyenter2">اصلاح</button>').attr('id',  response.individuals[i]['i_ed']+1000)
                                del = $('<button type="button" class="btn-sm btn-danger" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',  response.individuals[i]['i_ed']+2000)
                                t1 = $('<td style="width: 15%" class="personinfo2"></td>')
                                t2 = $('<td style="width: 15%" class="personinfo2"></td>')
                                t1.append(edit)
                                t2.append(del)
                                row = $('<tr class="report_row"></tr>')
                                row.append(id_ed,enter_exit,date,time,t1,t2,enter_exit_val)
                                $("#person_table77").append(row)
                                $('#' + Number(response.individuals[i]['i_ed']+2000)).click(function () {
                                    alert('ورود و خروج این فرد بطور همزمان حذف خواهد شد.در ادامه شما باید ورود و خروج این فرد را مجددا وارد کنید')
                                    var id_ed = $(this).closest('tr').find('td:eq(0)').text();
                                    var token = $("meta[name='csrf-token']").attr("content");
                                    $.ajax(
                                        {
                                            
                                            url: "/deleteindividuals/" + id_ed,
                                            type: 'DELETE',
                                            data: {
                                                "id": id_ed,
                                                "_token": token,
                                            },
                                            success: function (response) {
                                                $('.individuals222').show()
                                                $('.individuals222').toast('show');
                                                $("#individuals222").html("ردیف انتخابی حذف گردید")
                                            }
                                        });
                                        $(".personinfo2").remove();

                                })
                                $('#' + Number(response.individuals[i]['i_ed']+1000)).click(function () {
                                    $("#id_ed_edit").val($(this).closest('tr').find('td:eq(0)').text())
                                    $("#enter_exit_edit").val($(this).closest('tr').find('td:eq(6)').text())
                                    $("#date_shamsi_enter_edit").val($(this).closest('tr').find('td:eq(2)').text())
                                    $("#time_enter_edit").val($(this).closest('tr').find('td:eq(3)').text())
                                });
                            }

                        }
                    });
            })
            $('#seventh_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/truecars',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report3').html('<p id="title" style="margin-top: 7px;color: white">لیست خودروهای مجاز به ورود به نیروگاه </p>')
                        var id_ef
                        var id_ec = ''
                        var car_name =''
                        var area = ''
                        var driver_name = ''
                        var car_no44 = ''
                        var car_no = ''
                        var car_no3 = ''
                        var car_no2 = ''
                        var car_no1 = ''
                        var details=''
                        var link=''
                        var print=''
                        var t1=''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد</td><td style="border-left:1px white solid;">نام خودرو</td><td style="border-left:1px white solid;">نام راننده</td><td style="border-left:1px white solid;">.</td><td style="border-left:1px white solid;"><p style="font-size: xx-small">پلاک</p></td><td style="border-left:1px white solid;">.</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table3").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            link='./selectcar/'+response.results[i]['id_ec']
                            print=$('<a href='+link+'>پرینت</a>');
                            id_ef = $('<td hidden style="width: 10%">' + response.results[i]['id_ef'] + '</td>')
                            id_ec = $('<td style="width: 10%">' + response.results[i]['id_ec'] + '</td>')
                            car_name = $('<td style="width: 15%">' + response.results[i]['car_name'] +'</td>')
                            driver_name = $('<td style="width: 20%">' + response.results[i]['driver_name'] +'</td>')
                            car_no = response.results[i]['car_no']
                            car_no1 = $('<td style="width: 3%">' + car_no.toString().substr(1,2) +'</td>')
                            car_no2 = $('<td style="width: 2%">' + car_no.toString().substr(0,1) +'</td>')
                            car_no3 = $('<td style="width: 3%">' + car_no.toString().substr(3,3) +'</td>')
                            t1 = $('<td style="width: 15%"></td>')
                            // details=$('<button type="button" class="btn-sm btn-success" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">اطلاعات تکمیلی</button>').attr('id',  response.results[i]['id_ec'])
                            t1.append(print)
                            row = $('<tr class="report_row"></tr>')
                            row.append(id_ec,car_name,driver_name,car_no3,car_no2,car_no1,t1,id_ef)
                            $("#report_table3").append(row)
                            $("#editlist3").css("margin-top","100px");
                            $('#' + (response.results[i]['id_ec'])).on('click',function(){
                                var id_ef = $(this).closest('tr').find('td:eq(7)').text();
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
                                            mobile = $('<td style="border-left: 1px solid black" class="persons">' + response.persons[i]['mobile'] + '</td>')
                                            for(var z = 0; z < response.titles.length; z++) {
                                                if(response.titles[z]['id_et']==response.persons[i]['id_et']){
                                                    id_et = $('<td class="persons">' + response.titles[z]['description'] + '</td>')
                                                    break;
                                                }

                                            }
                                            row = $('<tr class="persons_row" style="font-family: Tahoma;font-size: 11px;color: black"></tr>')
                                            row.append(id_ep,f_name,l_name,id_et,nationality,age,date_shamsi_enter,time_enter,date_shamsi_exit,time_exit,code_melli,mobile)
                                            $("#person_table888").append(row)

                                        }
                                        var height1=(($('#person_table888 tr').length)*33).toString()+'px'
                                        var height2=(($('#person_table888 tr').length)*33+11).toString()+'px'
                                        $("#person_table888").css('height',height1)
                                        $("#person_div888").css('height',height2)

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
                                            $("#cars_table123").append(row)

                                        }

                                        height1=(($('#cars_table123 tr').length)*25).toString()+'px'
                                        height2=(($('#cars_div123 tr').length)*25+11).toString()+'px'
                                        $("#cars_table123").css('height',height1)
                                        $("#cars_div123").css('height',height2)




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
                        // $('.mylist2').hide();
                        // $('.mylist3').hide();
                        // $(".mylist3").fadeToggle(2000);
                    }})
                $('.mylist2').hide();
                $('.mylist3').hide();
                $(".mylist3").fadeToggle(2000);
            })
            $('#eighth_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/falsecars',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report3').html('<p id="title" style="margin-top: 7px;color: white">لیست خودروهای غیر مجاز به ورود به نیروگاه </p>')
                        var id_ef
                        var id_ec = ''
                        var car_name =''
                        var area = ''
                        var driver_name = ''
                        var car_no44 = ''
                        var car_no = ''
                        var car_no3 = ''
                        var car_no2 = ''
                        var car_no1 = ''
                        var details=''
                        var print=''
                        var t1=''
                        var row = ''
                        var link=''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد</td><td style="border-left:1px white solid;">نام خودرو</td><td style="border-left:1px white solid;">نام راننده</td><td style="border-left:1px white solid;">.</td><td style="border-left:1px white solid;"><p style="font-size: xx-small">پلاک</p></td><td style="border-left:1px white solid;">.</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table3").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            link='./selectcar/'+response.results[i]['id_ec']
                            print=$('<a href='+link+'>پرینت</a>');
                            id_ef = $('<td hidden style="width: 10%">' + response.results[i]['id_ef'] + '</td>')
                            id_ec = $('<td style="width: 10%">' + response.results[i]['id_ec'] + '</td>')
                            car_name = $('<td style="width: 15%">' + response.results[i]['car_name'] +'</td>')
                            driver_name = $('<td style="width: 20%">' + response.results[i]['driver_name'] +'</td>')
                            car_no = response.results[i]['car_no']
                            car_no1 = $('<td style="width: 3%">' + car_no.toString().substr(1,2) +'</td>')
                            car_no2 = $('<td style="width: 2%">' + car_no.toString().substr(0,1) +'</td>')
                            car_no3 = $('<td style="width: 3%">' + car_no.toString().substr(3,3) +'</td>')
                            t1 = $('<td style="width: 15%"></td>')
                            t1.append(print)
                            row = $('<tr class="report_row"></tr>')
                            row.append(id_ec,car_name,driver_name,car_no3,car_no2,car_no1,t1,id_ef)
                            $("#report_table3").append(row)
                            $("#editlist3").css("margin-top","100px");
                            $('#' + (response.results[i]['id_ec'])).on('click',function(){
                                var id_ef = $(this).closest('tr').find('td:eq(7)').text();
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
                                            mobile = $('<td style="border-left: 1px solid black" class="persons">' + response.persons[i]['mobile'] + '</td>')
                                            for(var z = 0; z < response.titles.length; z++) {
                                                if(response.titles[z]['id_et']==response.persons[i]['id_et']){
                                                    id_et = $('<td class="persons">' + response.titles[z]['description'] + '</td>')
                                                    break;
                                                }

                                            }
                                            row = $('<tr class="persons_row" style="font-family: Tahoma;font-size: 11px;color: black"></tr>')
                                            row.append(id_ep,f_name,l_name,id_et,nationality,age,date_shamsi_enter,time_enter,date_shamsi_exit,time_exit,code_melli,mobile)
                                            $("#person_table888").append(row)

                                        }
                                        var height1=(($('#person_table888 tr').length)*33).toString()+'px'
                                        var height2=(($('#person_table888 tr').length)*33+11).toString()+'px'
                                        $("#person_table888").css('height',height1)
                                        $("#person_div888").css('height',height2)

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
                                            $("#cars_table123").append(row)

                                        }

                                        height1=(($('#cars_table123 tr').length)*25).toString()+'px'
                                        height2=(($('#cars_div123 tr').length)*25+11).toString()+'px'
                                        $("#cars_table123").css('height',height1)
                                        $("#cars_div123").css('height',height2)




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
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".mylist3").fadeToggle(2000);
                    }})

            })
            $('#sixth_report2').click(function(event) {
                $('.mylist2').hide();
                $('.mylist3').hide();
                $('#codemelli_modal2').modal("show");
            })
            $('#second_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/auth-peaple-not-block2',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افراد مجاز به ورود به نیروگاه</p>')
                        var id_ep = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var herasat = ''
                        var form = ''
                        var t4=''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var enterexit=''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد فرد</td><td style="border-left:1px white solid;">نام</td><td style="border-left:1px white solid;">نام خانوادگی</td><td style="border-left:1px white solid;">کد ملی</td><td style="border-left:1px white solid;">شماره تماس</td><td style="border-left:1px white solid;">تحت عنوان</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ep = $('<td style="width: 5%">' + response.results[i]['id_ep'] + '</td>')
                            f_name = $('<td style="width: 13%;text-align: right;padding-right: 5px">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 17%;text-align: right;padding-right: 5px">' +response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 15%;text-align: right;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            tell = $('<td style="width: 15%;text-align: right;padding-right: 5px">' +response.results[i]['mobile'] + '</td>')
                            id_et=response.results[i]['id_et']
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                    title = $('<td style="width: 10%">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            form = $('<button type="button" class="btn-sm btn-danger form" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">لغو مجوز ورود</button>').attr('id',  response.results[i]['id_ep']+5000)
                            enterexit= $('<button hidden type="button" class="btn-sm btn-danger enterexit" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo5">اطلاعات ورود و خروج</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 10%"></td>')
                            t4 = $('<td style="width: 17%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            t4.append(enterexit)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('.form').on('click',function(){
                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/set-block/" + id_ep,
                                        type: 'GET',
                                        data: {
                                            "id": id_ep,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("این فرد بطور موقت بلاک گردید")
                                        }
                                    });

                                $(this).closest('tr').remove()
                            })
                            $(".enterexit").click(function () {
                                var code_melli = $(this).closest('tr').find('td:eq(3)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/personinfo3/" + code_melli,
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
                                                t1 = $('<td style="width: 15%" class="personinfo2"></td>')
                                                t2 = $('<td style="width: 15%" class="personinfo2"></td>')
                                                row = $('<tr class="report_row"></tr>')
                                                row.append(id_ed,enter_exit,date,time,enter_exit_val)
                                                $("#person_table77").append(row)//data-toggle="modal" data-target="#personinfo"
                                            }

                                        }
                                    });

                            })




                        }
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#daftarsearach').click(function(event) {
                $('#daftar_modal').modal('toggle');
                // var date_exit_shamsi1=$('#date_exit_shamsi1').val();
                // var date_exit_shamsi2=$('#date_exit_shamsi2').val();
                var date_exit_shamsi1=$('#date_exit_shamsi1').val().toString();
                var year1=date_exit_shamsi1.slice(0,4)
                var month1=date_exit_shamsi1.slice(5,7)
                var day1=date_exit_shamsi1.slice(8,10)
                var date_exit_shamsi1=year1+month1+day1;
                var date_exit_shamsi2=$('#date_exit_shamsi2').val().toString();
                var year2=date_exit_shamsi2.slice(0,4)
                var month2=date_exit_shamsi2.slice(5,7)
                var day2=date_exit_shamsi2.slice(8,10)
                var date_exit_shamsi2=year2+month2+day2;
                event.preventDefault();
                $.ajax({
                    url: "/total-individuals"+"/"+date_exit_shamsi1+"/"+date_exit_shamsi2,
                    type: 'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست ورود و خروج افراد به نیروگاه</p>')
                        var i_ed = ''
                        var enter_exit=""
                        var f_name = ''
                        var l_name = ''
                        var l_name2 = ''
                        var code_melli = ''
                        var date_enter = ''
                        var time_enter = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;text-align: center">کد تردد</td><td style="border-left:1px white solid;text-align: center">نوع تردد</td><td style="border-left:1px white solid;text-align: center">نام</td><td style="border-left:1px white solid;text-align: center">نام خانوادگی</td><td style="border-left:1px white solid;text-align: center">کد ملی</td><td style="border-left:1px white solid;text-align: center">تاریخ</td><td style="border-left:1px white solid;text-align: center">ساعت</td><td style="border-left:1px white solid;text-align: center">ثبت کننده</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            for(var z = 0; z < response.peaples.length; z++) {
                                if(response.peaples[z]['code_melli']==response.results[i]['code_melli']){
                                    f_name = $('<td style="width: 10%;text-align: center">' + response.peaples[z]['f_name'] + '</td>')
                                    l_name = $('<td style="width: 15%;text-align: center">' + response.peaples[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            for(var u = 0; u < response.users.length; u++) {
                                if(response.users[u]['id']==response.results[i]['id_user']){
                                    l_name2 = $('<td style="width: 10%;text-align: center">' + response.users[u]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            i_ed = $('<td style="width: 5%;text-align: center;padding-right: 5px">' + response.results[i]['i_ed'] + '</td>')
                            enter_exit=response.results[i]['enter_exit']
                            if(enter_exit==1){
                                enter_exit = $('<td style="width: 7%;text-align: center;padding-right: 5px">' + 'ورود' + '</td>')
                            }
                            if(enter_exit==2){
                                enter_exit = $('<td style="width: 7%;text-align: center;padding-right: 5px">' + 'خروج' + '</td>')
                            }
                            code_melli = $('<td style="width: 10%;text-align: center;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            var day=response.results[i]['date_enter'].substr(6,2)
                            var month=response.results[i]['date_enter'].substr(4,2)
                            var year=response.results[i]['date_enter'].substr(0,4)
                            date_enter = $('<td style="width: 10%;text-align: center;padding-right: 5px">' + year +'/'+month+'/'+day+'</td>')
                            time_enter = $('<td style="width: 10%;text-align: center;padding-right: 5px">' + response.results[i]['time_enter'] + '</td>')
                            row = $('<tr class="report_row"></tr>')
                            row.append(i_ed,enter_exit,f_name,l_name,code_melli,date_enter,time_enter,l_name2)
                            $("#report_table").append(row)
                        }
                        $("#editlist").css("margin-top","100px");
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#third_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/auth-peaple-block',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افرادی که بطور موقت مجوز ورود آنها لغو شده </p>')
                        var id_ep = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var herasat = ''
                        var form = ''
                        var t4=''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var enterexit=''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد فرد</td><td style="border-left:1px white solid;">نام</td><td style="border-left:1px white solid;">نام خانوادگی</td><td style="border-left:1px white solid;">کد ملی</td><td style="border-left:1px white solid;">شماره تماس</td><td style="border-left:1px white solid;">تحت عنوان</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_ep = $('<td style="width: 5%">' + response.results[i]['id_ep'] + '</td>')
                            f_name = $('<td style="width: 13%;text-align: right;padding-right: 5px">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 17%;text-align: right;padding-right: 5px">' +response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 15%;text-align: right;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            tell = $('<td style="width: 15%;text-align: right;padding-right: 5px">' +response.results[i]['mobile'] + '</td>')
                            id_et=response.results[i]['id_et']
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                    title = $('<td style="width: 10%">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            form = $('<button type="button" class="btn-sm btn-success form" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">دادن مجوز</button>')
                            enterexit= $('<button hidden type="button" class="btn-sm btn-danger enterexit" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo5">اطلاعات ورود و خروج</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 10%"></td>')
                            t4 = $('<td style="width: 17%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            t4.append(enterexit)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('.form').on('click',function(){
                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/reset-block/" + id_ep,
                                        type: 'GET',
                                        data: {
                                            "id": id_ep,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("این فرد از بلاک لیست خارج شد")
                                        }
                                    });

                                $(this).closest('tr').remove()
                            })
                            $(".enterexit").click(function () {
                                var code_melli = $(this).closest('tr').find('td:eq(3)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/personinfo3/" + code_melli,
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
                                                t1 = $('<td style="width: 15%" class="personinfo2"></td>')
                                                t2 = $('<td style="width: 15%" class="personinfo2"></td>')
                                                row = $('<tr class="report_row"></tr>')
                                                row.append(id_ed,enter_exit,date,time,enter_exit_val)
                                                $("#person_table77").append(row)//data-toggle="modal" data-target="#personinfo"
                                            }

                                        }
                                    });

                            })




                        }
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#third2_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/block-history',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افرادی که تاکنون وارد بلاک لیست شده اند </p>')
                        var id_ep = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var herasat = ''
                        var form = ''
                        var t4=''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var enterexit=''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد فرد</td><td style="border-left:1px white solid;">نام</td><td style="border-left:1px white solid;">نام خانوادگی</td><td style="border-left:1px white solid;">کد ملی</td><td style="border-left:1px white solid;">شماره تماس</td><td style="border-left:1px white solid;">تحت عنوان</td></tr>'
                        $("#report_table").append(row_th)
                        for(var i = 0; i < response.results.length; i++) {
                            id_ep = $('<td style="width: 5%">' + response.results[i]['id_ep'] + '</td>')
                            f_name = $('<td style="width: 13%;text-align: right;padding-right: 5px">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 17%;text-align: right;padding-right: 5px">' +response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 15%;text-align: right;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            tell = $('<td style="width: 15%;text-align: right;padding-right: 5px">' +response.results[i]['mobile'] + '</td>')
                            id_et=response.results[i]['id_et']
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                    title = $('<td style="width: 10%">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            form = $('<button hidden type="button" class="btn-sm btn-success form" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">دادن مجوز</button>')
                            enterexit= $('<button hidden type="button" class="btn-sm btn-danger enterexit" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo5">اطلاعات ورود و خروج</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 10%"></td>')
                            t4 = $('<td style="width: 17%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            t4.append(enterexit)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('.form').on('click',function(){
                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                //$('.toast').toast('show');
                                $.ajax(
                                    {
                                        url: "/reset-block/" + id_ep,
                                        type: 'GET',
                                        data: {
                                            "id": id_ep,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("این فرد از بلاک لیست خارج شد")
                                        }
                                    });

                                $(this).closest('tr').remove()
                            })
                            $(".enterexit").click(function () {
                                var code_melli = $(this).closest('tr').find('td:eq(3)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/personinfo3/" + code_melli,
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
                                                t1 = $('<td style="width: 15%" class="personinfo2"></td>')
                                                t2 = $('<td style="width: 15%" class="personinfo2"></td>')
                                                row = $('<tr class="report_row"></tr>')
                                                row.append(id_ed,enter_exit,date,time,enter_exit_val)
                                                $("#person_table77").append(row)//data-toggle="modal" data-target="#personinfo"
                                            }

                                        }
                                    });

                            })




                        }
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#fourth_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/auth-cards2',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افراد دارای کارت ورود معتبر</p>')
                        var id_ep = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var carno = ''
                        var form = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد فرد</td><td style="border-left:1px white solid;">نام</td><td style="border-left:1px white solid;">نام خانوادگی</td><td style="border-left:1px white solid;">کد ملی</td><td style="border-left:1px white solid;">شماره تماس</td><td style="border-left:1px white solid;">تحت عنوان</td><td style="border-left:1px white solid;">شماره کارت</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ep = $('<td style="width: 5%">' + response.results[i]['id_ep'] + '</td>')
                            f_name = $('<td style="width: 10%;text-align: right;padding-right: 5px">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 14%;text-align: right;padding-right: 5px">' +response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 14%;text-align: center;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            tell = $('<td style="width: 15%;text-align: center;padding-right: 5px">' +response.results[i]['mobile'] + '</td>')
                            cardno = $('<td style="width: 7%;text-align: center;padding-right: 5px">' +response.results[i]['cardno'] + '</td>')
                            id_et=response.results[i]['id_et']
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                    title = $('<td style="width: 10%">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            form = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo">اطلاعات فرد</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title,cardno,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ep']).click(function () {
                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/personinfo/" + id_ep,
                                        type: 'GET',
                                        data: {
                                            "id": id_ep,
                                            "_token": token,
                                        },
                                        success: function (response) {
                                            $(".personinfo").remove();
                                            var day=response.date1.substr(6,2)
                                            var month=response.date1.substr(4,2)
                                            var year=response.date1.substr(0,4)
                                            var id_ep = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.id_ep + '</td>')
                                            var f_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.f_name + '</td>')
                                            var l_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.l_name + '</td>')
                                            var job = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.job + '</td>')
                                            var nationality = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.nationality + '</td>')
                                            var age = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.age + '</td>')
                                            var date1 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                                            var time1 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.time1 + '</td>')
                                            var day=response.date2.substr(6,2)
                                            var month=response.date2.substr(4,2)
                                            var year=response.date2.substr(0,4)
                                            var date2 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                                            var time2 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.time2 + '</td>')
                                            var code_melli = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.code_melli + '</td>')
                                            var mobile = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.mobile + '</td>')

                                            row = $('<tr class="person_row"></tr>')
                                            row.append(id_ep,f_name,l_name,job,nationality,age,date1,time1,date2,time2,code_melli,mobile)
                                            $("#person_table33").append(row)
                                            //alert(response.title)
                                            $("#title22").text(response.title2)
                                            $("#company22").text(response.company2)
                                            if(response.cardno>=1){$("#cardno22").text(response.cardno)}else{$("#cardno22").text('ندارد')}

                                            var id_ehf = ''
                                            var description = ''
                                            var row = ''
                                            $(".hefazatinfo").remove();
                                            for(var i = 0; i < response.hefazat.length; i++) {
                                                id_ehf = $('<td style="width: 5%;text-align: center" class="personinfo">' + response.hefazat[i]['id_ehf'] + '</td>')
                                                description = $('<td style="width: 13%;text-align: right;padding-right: 5px" class="personinfo">' + response.hefazat[i]['description'] + '</td>')
                                                row = $('<tr class="report_row"></tr>')
                                                row.append(id_ehf, description)
                                                $("#hefazat_table2").append(row)
                                            }

                                        }
                                    });
                                // $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#fifth_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/unauth-cards2',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افراد دارای کارت منقضی شده</p>')
                        var id_ep = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var cardno = ''
                        var form = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">کد فرد</td><td style="border-left:1px white solid;">نام</td><td style="border-left:1px white solid;">نام خانوادگی</td><td style="border-left:1px white solid;">کد ملی</td><td style="border-left:1px white solid;">شماره تماس</td><td style="border-left:1px white solid;">تحت عنوان</td><td style="border-left:1px white solid;">شماره کارت</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ep = $('<td style="width: 5%">' + response.results[i]['id_ep'] + '</td>')
                            f_name = $('<td style="width: 13%;text-align: right;padding-right: 5px">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 17%;text-align: right;padding-right: 5px">' +response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 15%;text-align: right;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            tell = $('<td style="width: 15%;text-align: right;padding-right: 5px">' +response.results[i]['mobile'] + '</td>')
                            cardno = $('<td style="width: 7%;text-align: center;padding-right: 5px">' +response.results[i]['cardno'] + '</td>')
                            id_et=response.results[i]['id_et']
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                    title = $('<td style="width: 10%">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            form = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo">توضیحات</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title,cardno,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ep']).click(function () {
                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax(
                                    {
                                        url: "/personinfo/" + id_ep,
                                        type: 'GET',
                                        data: {
                                            "id": id_ep,
                                            "_token": token,
                                        },
                                        success: function (response) {
                                            $(".personinfo").remove();
                                            var day=response.date1.substr(6,2)
                                            var month=response.date1.substr(4,2)
                                            var year=response.date1.substr(0,4)
                                            var id_ep = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.id_ep + '</td>')
                                            var f_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.f_name + '</td>')
                                            var l_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.l_name + '</td>')
                                            var job = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.job + '</td>')
                                            var nationality = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.nationality + '</td>')
                                            var age = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.age + '</td>')
                                            var date1 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                                            var time1 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.time1 + '</td>')
                                            var day=response.date2.substr(6,2)
                                            var month=response.date2.substr(4,2)
                                            var year=response.date2.substr(0,4)
                                            var date2 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                                            var time2 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.time2 + '</td>')
                                            var code_melli = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.code_melli + '</td>')
                                            var mobile = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.mobile + '</td>')

                                            row = $('<tr class="person_row"></tr>')
                                            row.append(id_ep,f_name,l_name,job,nationality,age,date1,time1,date2,time2,code_melli,mobile)
                                            $("#person_table33").append(row)
                                            //alert(response.title)
                                            $("#title22").text(response.title2)
                                            $("#company22").text(response.company2)
                                            if(response.cardno>=1){$("#cardno22").text(response.cardno)}else{$("#cardno22").text('ندارد')}

                                            var id_ehf = ''
                                            var description = ''
                                            var row = ''
                                            $(".hefazatinfo").remove();
                                            for(var i = 0; i < response.hefazat.length; i++) {
                                                id_ehf = $('<td style="width: 5%;text-align: center" class="personinfo">' + response.hefazat[i]['id_ehf'] + '</td>')
                                                description = $('<td style="width: 13%;text-align: right;padding-right: 5px" class="personinfo">' + response.hefazat[i]['description'] + '</td>')
                                                row = $('<tr class="report_row"></tr>')
                                                row.append(id_ehf, description)
                                                $("#hefazat_table2").append(row)
                                            }

                                        }
                                    });
                                // $(this).closest('tr').remove()

                            })




                        }
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#codesearach').click(function (event) {
                $("#sixth_report34").show()
                var code_melli = $('#code_melli_s').val();
                $('#code_melli_s2').val($('#code_melli_s').val());
                $('#code_melli').val(code_melli);
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: "/persons_recieve2/" + code_melli,
                        type: 'GET',
                        data: {
                            "id": code_melli,
                            "_token": token,
                        },
                        success: function (response) {
                            if((response.x3>=response.x1 && response.x3<=response.x2) && response.let_show =="1" && response.notlet2 =="0"){
                                alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد');
                                $("#sixth_report33").show();
                                $("#sixth_report34").show();
                            }
                            if((response.x3>response.x2) && response.let_show =="1" && response.notlet2 =="0"){
                                alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                                $("#sixth_report33").hide();
                                $("#sixth_report34").show();
                            }
                            if(response.length =="0"){
                                alert('برای این فرد مجوزی برای ورود به نیروگاه صادر نشده')
                                $("#sixth_report33").hide();
                                $("#sixth_report34").show();
                            }
                            if(response.notlet2=='1'){
                                alert('این فرد با نظر مسئول حراست با وجود مجوز اخذ شده در این تاریخ موقتا مجاز به ورود به نیروگاه نمی باشد. در این رابطه با مدیر حراست هماهنگ شود')
                                $("#sixth_report33").hide();
                                $("#sixth_report34").hide();
                            }

                            if(response.let_show !=1){
                                alert('مجوز ورود این فرد هنوز صادر نشده')
                                $("#sixth_report33").hide()
                                $("#sixth_report34").hide()
                            }


                            $('#personinfo2').modal("show");

                            $(".personinfo").remove();
                            var id_et="";
                            var day=response.results[0]['date_shamsi_enter'].substr(6,2)
                            var month=response.results[0]['date_shamsi_enter'].substr(4,2)
                            var year=response.results[0]['date_shamsi_enter'].substr(0,4)
                            var id_ep = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['id_ep']+ '</td>')
                            var f_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['f_name'] + '</td>')
                            var l_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.results[0]['l_name'] + '</td>')
                            var nationality = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['nationality'] + '</td>')
                            var age = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.results[0]['age'] + '</td>')
                            var date1 = $('<td style="text-align: right;padding-right: 5px;color: #218838" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            var time1 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['time_enter'] + '</td>')
                            var time2 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['time_exit'] + '</td>')
                            var day=response.results[0]['date_shamsi_exit'].substr(6,2)
                            var month=response.results[0]['date_shamsi_exit'].substr(4,2)
                            var year=response.results[0]['date_shamsi_exit'].substr(0,4)
                            var date2 = $('<td style="text-align: right;padding-right: 5px;color: #c82333" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            var code_melli = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['code_melli'] + '</td>')
                            var mobile = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['mobile'] + '</td>')
                            //alert(response.titles.length)
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[0]['id_et']){
                                    id_et = $('<td class="personinfo">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            var row = $('<tr class="person_row"></tr>')
                            row.append(id_ep,f_name,l_name,id_et,nationality,age,date1,time1,date2,time2,code_melli,mobile)//,date1,time1,date2,time2,

                            $("#person_table999").append(row)

                            $("#title44").html(response.job)
                            $("#company44").html(response.company)
                            $("#cardno44").html(response.cardno)
                            //  var date_exit=Number(toEnglishNumber(response.date2));
                            //  var date_current=Number(toEnglishNumber(response.date));
                            // // alert(date_exit);
                            // // alert(date_current);
                            // if(date_current>date_exit){
                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                            //    $("#sixth_report33").hide()
                            // }
                            // if(date_current<date_exit){
                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد')
                            //     $("#sixth_report33").show()
                            //     $("#sixth_report34").show()
                            // }


                            var date_enter=Number(toEnglishNumber(response.date1));
                            var date_exit=Number(toEnglishNumber(response.date2));
                            var date_current=Number(toEnglishNumber(response.date));
                            // if(date_current>date_exit || date_current<date_enter){
                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                            //     $("#sixth_report33").hide()
                            // }
                            // if(date_current<=date_exit && date_current>=date_enter){
                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد')
                            //     $("#sixth_report33").show()
                            // }


                            if(response.cardno>=1){$("#cardno44").text(response.cardno)}else{$("#cardno44").text('ندارد')}

                            var id_ehf = ''
                            var description = ''
                            var row = ''
                            $(".hefazatinfo").remove();
                            for(var u = 0; u < response.hefazat.length; u++) {
                                id_ehf = $('<td style="width: 5%;text-align: center;color: #007be6" class="personinfo">' + response.hefazat[u]['id_ehf'] + '</td>')
                                description = $('<td style="width: 13%;text-align: right;padding-right: 5px;color: #007be6" class="personinfo">' + response.hefazat[u]['description'] + '</td>')
                                row = $('<tr class="report_row"></tr>')
                                row.append(id_ehf, description)
                                $("#hefazat_table44").append(row)
                            }
                            // if(toEnglishNumber(response.date1)<=toEnglishNumber(response.date)
                            //     &&
                            //     toEnglishNumber(response.date2)>=toEnglishNumber(response.date)){
                            //     $("#img_ok").show()
                            //     $("#img_no").hide()
                            // }
                            // if(toEnglishNumber(response.date1)>toEnglishNumber(response.date)
                            //     ||
                            //     toEnglishNumber(response.date2)<toEnglishNumber(response.date)){
                            //     $("#img_no").show()
                            //     $("#img_ok").hide()
                            // }
                            $('#code_melli_s').val('')

                        },
                        error: function() {
                            $('#personinfo2').modal("hide");
                            alert('برای این فرد درخواست مجوزی صادر نشده')

                        }
                    });
            })
            $('#codesearach2').click(function (event) {
                var code_melli = $('#code_melli_ss').val();
                $('#code_melli_s3').val($('#code_melli_ss').val());
                $('#code_melli').val(code_melli);
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: "/persons_recieve2/" + code_melli,
                        type: 'GET',
                        data: {
                            "id": code_melli,
                            "_token": token,
                        },
                        success: function (response) {
                            var notlet2=response.notlet2;


                            $('#personinfo6').modal("show");

                            $(".personinfo").remove();
                            var id_et="";
                            var day=response.results[0]['date_shamsi_enter'].substr(6,2)
                            var month=response.results[0]['date_shamsi_enter'].substr(4,2)
                            var year=response.results[0]['date_shamsi_enter'].substr(0,4)
                            var id_ep = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['id_ep']+ '</td>')
                            var f_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['f_name'] + '</td>')
                            var l_name = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.results[0]['l_name'] + '</td>')
                            var nationality = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['nationality'] + '</td>')
                            var age = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' +response.results[0]['age'] + '</td>')
                            var date1 = $('<td style="text-align: right;padding-right: 5px;color: #218838" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            var time1 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['time_enter'] + '</td>')
                            var time2 = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['time_exit'] + '</td>')
                            var day=response.results[0]['date_shamsi_exit'].substr(6,2)
                            var month=response.results[0]['date_shamsi_exit'].substr(4,2)
                            var year=response.results[0]['date_shamsi_exit'].substr(0,4)
                            var date2 = $('<td style="text-align: right;padding-right: 5px;color: #c82333" class="personinfo">' + year +'/'+month+'/'+day+'</td>')
                            var code_melli = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['code_melli'] + '</td>')
                            var mobile = $('<td style="text-align: right;padding-right: 5px" class="personinfo">' + response.results[0]['mobile'] + '</td>')
                            //alert(response.titles.length)
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[0]['id_et']){
                                    id_et = $('<td class="personinfo">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            var row = $('<tr class="person_row"></tr>')
                            row.append(id_ep,f_name,l_name,id_et,nationality,age,date1,time1,date2,time2,code_melli,mobile)//,date1,time1,date2,time2,

                            $("#person_table123").append(row)

                            $("#title55").html(response.job)
                            $("#company55").html(response.company)
                            $("#cardno55").html(response.cardno)
                            var date_enter=Number(toEnglishNumber(response.date1));
                            var date_exit=Number(toEnglishNumber(response.date2));
                            var date_current=Number(toEnglishNumber(response.date));

                            // if(date_current>date_exit || date_current<date_enter){
                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                            //     $("#sixth_report33").hide()
                            //     $("#sixth_report35").hide()
                            // }
                            // if(date_current<=date_exit && date_current>=date_enter){
                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد')
                            //     $("#sixth_report33").show()
                            //     $("#sixth_report35").show()
                            // }
                            if((date_current>date_exit || date_current<date_enter) && notlet2=='0'){
                                alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                                $("#sixth_report33").hide()
                            }
                            if((date_current<=date_exit && date_current>=date_enter) && notlet2=='0'){
                                alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد')
                                $("#sixth_report33").show()
                            }
                            if(notlet2=='1'){
                                alert('این فرد با نظر مسئول حراست با وجود مجوز اخذ شده در این تاریخ موقتا مجاز به ورود به نیروگاه نمی باشد. در این رابطه با مدیر حراست هماهنگ شود')
                                $("#sixth_report33").hide()
                                $("#sixth_report34").hide()
                            }


                            if(response.cardno>=1){$("#cardno44").text(response.cardno)}else{$("#cardno44").text('ندارد')}

                            var id_ehf = ''
                            var description = ''
                            var row = ''
                            $(".hefazatinfo").remove();
                            for(var u = 0; u < response.hefazat.length; u++) {
                                id_ehf = $('<td style="width: 5%;text-align: center;color: #007be6" class="personinfo">' + response.hefazat[u]['id_ehf'] + '</td>')
                                description = $('<td style="width: 13%;text-align: right;padding-right: 5px;color: #007be6" class="personinfo">' + response.hefazat[u]['description'] + '</td>')
                                row = $('<tr class="report_row"></tr>')
                                row.append(id_ehf, description)
                                $("#hefazat_table55").append(row)
                            }
                            if(toEnglishNumber(response.date1)<=toEnglishNumber(response.date)
                                &&
                                toEnglishNumber(response.date2)>=toEnglishNumber(response.date)){
                                $("#img_ok").show()
                                $("#img_no").hide()
                            }
                            if(toEnglishNumber(response.date1)>toEnglishNumber(response.date)
                                ||
                                toEnglishNumber(response.date2)<toEnglishNumber(response.date)){
                                $("#img_no").show()
                                $("#img_ok").hide()
                            }
                            $('#code_melli_s').val('')


                            // if(toEnglishNumber(response.date1)<=toEnglishNumber(response.date)
                            //     &&
                            //     toEnglishNumber(response.date2)>=toEnglishNumber(response.date)){
                            //     $("#img_ok").show()
                            //     $("#img_no").hide()
                            // }else{
                            //     $("#img_no").show()
                            //     $("#img_ok").hide()
                            // }
                            // $('#code_melli_s').val('')

                        },
                        error: function() {
                            $('#personinfo2').modal("hide");
                            alert('برای این فرد درخواست مجوزی صادر نشده')

                        }
                    });
            })
            $("#addindividuals2").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updateindividuals",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        // alert(response.id_ed)
                        // alert(response.time)
                        // alert(response.date)

                        $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(6)').text($("#enter_exit_edit").val());
                        $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(2)').text($("#date_shamsi_enter_edit").val());
                        $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(3)').text($("#time_enter_edit").val());
                        if($('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(6)').text()==1){
                            $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(1)').text('ورود');
                        }
                        if($('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(6)').text()==2){
                            $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(1)').text('خروج');
                        }
                        $("#time_enter_edit").val('');
                        $("#enter_exit_edit").val('');
                        $("#date_shamsi_enter_edit").val('');

                        $('.individuals22').show()
                        $('.individuals22').toast('show');
                        $("#individuals22").html("تغییرات اعمال گردید")
                    }
                });
            });
            $("#date_shamsi_enter_edit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_enter").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#individuals_edit").on('submit',function(event) {
                event.preventDefault();
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updateindividuals",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(6)').text($("#enter_exit_edit").val());
                        $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(2)').text($("#date_shamsi_enter_edit").val());
                        $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(3)').text($("#time_enter_edit").val());
                        if($('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(6)').text()==1){
                            $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(1)').text('ورود');
                        }
                        if($('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(6)').text()==2){
                            $('#' + (Number(response.id_ed)+1000)).closest('tr').find('td:eq(1)').text('خروج');
                        }
                        $('.individuals22').show()
                        $('.individuals22').toast('show');
                        $("#individuals22").html("اطلاعات این فرد اصلاح گردید")
                    }
                });

            });
            $("#addindividuals").on('submit',function(event) {
                
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addindividuals2",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        
                        $("#time_enter").val('');
                        $("#enter_exit").val('');
                        var enter_exit = 0;
                        var i_ed = $('<td style="text-align: center" class="personinfo2">' + response.i_ed + '</td>')
                        var date_enter = $('<td style="text-align: center" class="personinfo2">' + response.date_enter + '</td>')
                        var time_enter = $('<td style="text-align: center" class="personinfo2">' + response.time_enter + '</td>')
                        var enter_exit_val = $('<td hidden style="text-align: center" class="personinfo2">' +response.enter_exit+ '</td>')
                        if(response.enter_exit==1){
                            enter_exit = $('<td style="text-align: center" class="personinfo2">' +'ورود'+ '</td>')
                        }else{
                            enter_exit = $('<td style="text-align: center" class="personinfo2">' +'خروج'+ '</td>')
                        }
                        var edit1 = $('<button  disabled type="button" class="btn-sm btn-info edit1 personinfo2" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%" data-toggle="modal" data-target="#dailyenter2">اصلاح</button>').attr('id',response.i_ed+1000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del personinfo2" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%">حذف</button>').attr('id',response.i_ed+2000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr></tr>')
                        row.append(i_ed, enter_exit, date_enter, time_enter,t1,t2,enter_exit_val)
                        $("#person_table77").append(row)

                        $('#' + Number(response.i_ed+1000)).click(function () {
                            $("#id_ed_edit").val($(this).closest('tr').find('td:eq(0)').text())
                            $("#enter_exit_edit").val($(this).closest('tr').find('td:eq(6)').text())
                            $("#date_shamsi_enter_edit").val($(this).closest('tr').find('td:eq(2)').text())
                            $("#time_enter_edit").val($(this).closest('tr').find('td:eq(3)').text())
                        });
                        $('.individuals333').show()
                        $('.individuals333').toast('show');
                        $("#individuals333").html("اطلاعات این فرد ثبت گردید")
                    }
                });
            });
            $('#setTimeButton1').on('click', function() {
                $('#time_enter').timepicker('setTime', new Date());
                var code_melli= $('#code_melli').val().toString();
                var date_enter= $('#date_shamsi_enter').val().toString();
                var time_enter= $('#time_enter').val().toString();

                var day=date_enter.substr(8,2)
                var month=date_enter.substr(5,2)
                var year=date_enter.substr(0,4)
                date_enter=year+month+day;
                date_enter=toEnglishNumber(date_enter);
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: "/set-entering/" + code_melli + "/" + date_enter + "/" + time_enter,
                        type: 'GET',
                        data: {
                            "id": code_melli,
                            "date": date_enter,
                            "time": time_enter,
                            "_token": token,
                        },
                        success: function (response) {
                            alert('ورود این فرد ثبت شد')
                        }
                    });
            });
            $('#setTimeButton2').on('click', function() {
                $('#time_enter').timepicker('setTime', new Date());
                var code_melli= $('#code_melli').val().toString();
                var date_enter= $('#date_shamsi_enter').val().toString();
                var time_enter= $('#time_enter').val().toString();

                var day=date_enter.substr(8,2)
                var month=date_enter.substr(5,2)
                var year=date_enter.substr(0,4)
                date_enter=year+month+day;
                date_enter=toEnglishNumber(date_enter);

                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax(
                    {
                        url: "/set-exiting/" + code_melli + "/" + date_enter + "/" + time_enter,
                        type: 'GET',
                        data: {
                            "id": code_melli,
                            "date": date_enter,
                            "time": time_enter,
                            "_token": token,
                        },
                        success: function (response) {
                            alert('خروج این فرد ثبت شد')
                        }
                    });
            });
        });
    </script>

    <div class="row mylist2" style="margin: auto;width:70%;display: none;margin-top: 5px">
        <div class="col-12" id="title_report" style="height: 35px;margin-top: 5px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color:rgb(14,53,126)"></div>
    </div>
    <div class="row mylist2" style="margin: auto;width:70%;height:310px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
        <div class="col-12" style="direction: rtl;height: 300px;overflow-y: scroll;">
            <table id="report_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
        </div>

        <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
            <div class="toast-body"><p id="mytoast" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
        </div>
    </div>
    <div class="row mylist3" style="margin: auto;width:50%;display: none;margin-top: 5px">
        <div class="col-12" id="title_report3" style="height: 35px;margin-top: 5px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color:rgb(14,53,126)"></div>
    </div>
    <div class="row mylist3" style="margin: auto;width:50%;height:200px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige">
        <div class="col-12" style="direction: rtl;height: 195px;overflow-y: scroll;">
            <table id="report_table3" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
        </div>

        <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
            <div class="toast-body"><p id="mytoast3" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
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
                        <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">لیست الزامات حفاظت فیزیکی این فرد:</p>
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
                                <td class="el" style="width: 85%">الزامات حفاظت فیزیکی</td>
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
    <div class="modal fade mt-3" id="codemelli_modal" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist" style="margin-top: 100px;margin-left: 395px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 498px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جستجو</p></div>
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
            <div class="container"  style="margin: auto;background-color:white;width: 495px ;height: 160px">

                <div class="row" style="margin-top: 30px">
                    <div class="col">
                        <input type="text" id="code_melli_s" name="code_melli_s" placeholder="کد ملی فرد مورد نظر" style="font-family: Tahoma;font-size: smaller;width:30%;text-align: center;">
                    </div>
                </div>
                <div class="row" style="margin-top: 30px">
                    <div class="col">
                        <button type="button" id="codesearach" class="btn btn-success" style="font-family: Tahoma;font-size: small;color: white;width: 70%">بررسی وضعیت شخص</button>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:498px"></div>

        </div>
    </div>
</div>
    <div class="modal fade mt-3" id="codemelli_modal2" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist200" style="margin-top: 100px;margin-left: 395px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 498px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جستجو</p></div>
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
            <div class="container"  style="margin: auto;background-color:white;width: 495px ;height: 160px">

                <div class="row" style="margin-top: 30px">
                    <div class="col">
                        <input type="text" id="code_melli_ss" name="code_melli_s" placeholder="کد ملی فرد مورد نظر" style="font-family: Tahoma;font-size: smaller;width:30%;text-align: center;">
                    </div>
                </div>
                <div class="row" style="margin-top: 30px">
                    <div class="col">
                        <button type="button" id="codesearach2" class="btn btn-success" style="font-family: Tahoma;font-size: small;color: white;width: 70%">بررسی وضعیت شخص</button>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:498px"></div>

        </div>
    </div>
</div>
    <div class="modal fade mt-3" id="personinfo3" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 460px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 600px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اطلاعات درخواستی</p></div>
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
                    <div class="row" style="margin-top: 10px">

                        <div id="person_div2" class="col" style="height:50px">
                            <table id="person_table55" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="person" style="width: 5%">کد</td>
                                    <td class="person" style="width: 10%">ورود/خروج</td>
                                    <td class="person" style="width: 10%">تاریخ</td>
                                    <td class="person" style="width: 7%">ساعت</td>
                                    <td class="person" style="width: 7%">#</td>
                                    <td class="person" style="width: 7%">#</td>
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
                        <div id="person_div888" class="col" style="height:50px">
                            <table id="person_table888" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
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
                    <br>
                    <div id="first1" class="row">
                        <div id="ec_txt" class="col" style="height:25px;text-align: right;">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">مشخصات خودروهای مجاز به ورود به نیروگاه:</p>
                        </div>
                        <div id="ec_txt" class="col" style="height:25px;text-align: right;">
                            <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">فهرست لوازم الکترونیکی مجاز به ورود به نیروگاه:</p>
                        </div>
                    </div>
                    <div id="first2" class="row" style="text-align: right">
                        <div id="cars_div123" class="col" style="height:30px;text-align: right">
                            <table id="cars_table123" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;border: 1px solid black;">
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
                    <br>
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
    <div class="modal fade mt-3" id="s13" style="direction: rtl;top: -400px;border-radius: 10px">
        <div class="modal-dialog modal-md" id="editlist" >
            <div class="modal-content">
                <div class="modal-header bg-danger" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">هشدار</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 100px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px">حجم فایل ارسالی بیشتر از مقدار مجاز است.حداکثر حجم مجاز برای ارسال 2 مگابایت می باشد.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="personinfo4" style="direction: rtl;">
       <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 50px;margin-left: 460px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 600px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اطلاعات درخواستی</p></div>
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
                <div class="row" style="margin-top: 10px">
                    <div id="person_div2" class="col" style="height:50px">
                        <input hidden type="text" id="code_melli_s3">

                        <table id="person_table66" align="center" style="width: 90%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                            <tr style="color: black">
                                <td class="person" style="width: 5%">کد</td>
                                <td class="person" style="width: 10%">ورود/خروج</td>
                                <td class="person" style="width: 10%">تاریخ</td>
                                <td class="person" style="width: 7%">ساعت</td>
                                <td class="person" style="width: 10%">#</td>
                                <td class="person" style="width: 7%">#</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:600px">
{{--                <div class="toast bg-danger individuals2" style="margin-top:20px;margin: auto;border-radius: 10px">--}}
{{--                    <div class="toast-body"><p id="individuals2" style="font-family: Tahoma;font-size: small;color: white;"></p></div>--}}
{{--                </div>--}}
            </div>

        </div>
    </div>
    </div>
    <div class="modal fade mt-3" id="personinfo6" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                <div class="row" style="width: 100%">
                    <div class="col-6">
                        <div id="el_div" class="col" style="height:50px;text-align: center">
                            <img style="display: none" src="{{URL::to('/')}}/ok.jpg" id="img_ok" class="reza5"  >
                            <img style="display: none" src="{{URL::to('/')}}/ok.jpg" id="img_no" class="reza5" >
                            <p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات در اطلاعات ورود و خروج افراد</p>
                        </div>

                    </div>
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
                        <table id="person_table123" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
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
                                <p id="title55" style="font-family: Tahoma;font-size: smaller;color: blue"></p>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="height:25px">
                        <div class="row">
                            <div class="col-4" style="height:25px">
                                <p style="font-family: Tahoma;font-size: smaller;color: black">نام شرکت یا مرکز:</p>
                            </div>
                            <div class="col-8" style="height:25px;text-align: right">
                                <p id="company55" style="font-family: Tahoma;font-size: smaller;color: blue"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="first1" class="row" style="margin-top: 10px">
                    <div id="ec_txt2" class="col" style="height:25px;text-align: right;">
                        <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;">لیست الزامات حفاظت فیزیکی این فرد:</p>
                    </div>
                    <div id="ec_txt3" class="col" style="height:25px;text-align: right;">
                        <p style="font-family: Tahoma;font-size: smaller;color: black;margin-right: 15px;display: inline">شماره کارت مهمان:</p>
                        <p id="cardno55" style="font-family: Tahoma;font-size: smaller;color: black;display: inline"></p>
                    </div>
                </div>
                <div id="first44" class="row" style="text-align: right">
                    <div id="cars_div44" class="col" style="height:30px;text-align: right">
                        <table id="hefazat_table55" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                            <tr style="color: black">
                                <td class="el" style="width: 10%">کد</td>
                                <td class="el" style="width: 85%">الزامات حفاظت فیزیکی</td>
                            </tr>
                        </table>
                    </div>
                    <div id="el_div" class="col" style="height:50px;text-align: center">
                        <img style="display: none" src="{{URL::to('/')}}/authorised003.png" id="img_ok" class="reza3"  >
                        <img style="display: none" src="{{URL::to('/')}}/unauthorised002.jpg" id="img_no" class="reza3" >
                    </div>
{{--                    <div id="sixth_report333"style="margin-left: 5px">--}}
{{--                        <img  src="./dailyenter003.png"  class="reza2" data-toggle="tooltip" data-placement="left" title="ورود اطلاعات ورود و خروج">--}}
{{--                    </div>--}}
                    <div id="sixth_report35" style="margin-left: 65px">
                        <img  src="{{URL::to('/')}}/enter_edit.jpg"  class="reza4" data-toggle="tooltip" data-placement="left" title="ورود و اصلاح اطلاعات ورود و خروج این فرد">
                    </div>
                    {{-- <div id="setTimeButton1" style="margin-left: 5px">
                        <img  src="{{URL::to('/')}}/PWEG.png"  class="reza4" data-toggle="tooltip" data-placement="left" title="اعمال حضور فرد در نیروگاه">
                    </div>
                    <div id="setTimeButton2" style="margin-left: 5px">
                        <img  src="{{URL::to('/')}}/PWER.png"  class="reza4" data-toggle="tooltip" data-placement="left" title="اعمال خروج فرد از نیروگاه">
                    </div> --}}
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

        </div>
    </div>
</div>
    <div class="modal fade mt-3" id="personinfo5" style="direction: rtl;">
       <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 50px;margin-left: 460px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 600px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اطلاعات درخواستی</p></div>
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
            <div class="container"  style="margin: auto;background-color:white;width: 600px ;height: 400px;overflow-y: scroll">
                <div class="row" style="margin-top: 10px">
                    <div id="person_div2" class="col" style="height:50px">
                        <div id="s2" class="container" style="text-align: left;background-color:#37473B;width: 100%;border-radius: 5px;height:170px;direction: rtl;color: white;margin-top:2px;padding-top: 2px;">
                            <form method="post" encType="multipart/form-data" id="addindividuals" action="{{route('addindividuals.store2')}}">
                                {{csrf_field()}}
                                <div class="row" style="height: 15px">
                                    <select  class="form-control" name="enter_exit" id="enter_exit" style="width: 30%;font-family: Tahoma;font-size: small;margin-top: 10px;margin-right: 10px" required>
                                        <option value=''>انتخاب ورود یا خروج</option>
                                        <option value='1'>ثبت ورود</option>
                                        <option value='2'>ثبت خروج</option>
                                    </select>
                                </div>
                                <br>

                                <input hidden type="text" id="code_melli" name="code_melli">
                                <div class="row" style="height: 15px">
                                    <div class="col">
                                        <div class="form-group" >
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row" style="height: 20px;margin-top: 20px">
                                                        <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ ورود یا خروج:</p>
                                                        </div>
                                                        <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت ورود یا خروج:</p></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 55%"  required title="تاریخ ورود یا خروج">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="time" class="form-control" id="time_enter"  data-toggle="tooltip"  name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 55%;text-align:center" required placeholder="ساعت ورود یا خروج">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row" style="margin-top:45px">
                                    <div class="col" style="text-align:center">
                                        <button type="submit" class="btn btn-primary" id="btnupdate" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:25%">ثبت اطلاعات</button>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <input hidden type="text" id="code_melli_s4">
                        <table id="person_table77" align="center" style="width: 90%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                            <tr style="color: black">
                                <td class="person" style="width: 5%">کد</td>
                                <td class="person" style="width: 10%">ورود/خروج</td>
                                <td class="person" style="width: 10%">تاریخ</td>
                                <td class="person" style="width: 7%">ساعت</td>
                                <td class="person" style="width: 10%">#</td>
                                <td class="person" style="width: 7%">#</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:600px">
                    <div class="toast bg-danger individuals222" style="margin-top:5px;margin: auto;border-radius: 10px">
                        <div class="toast-body"><p id="individuals222" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                    </div>
                    <div class="toast bg-success individuals333" style="margin-top:5px;margin: auto;border-radius: 10px">
                        <div class="toast-body"><p id="individuals333" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                    </div>
            </div>

        </div>
    </div>
    </div>
    <div class="modal fade mt-2" id="dailyenter2" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 50px;margin-left: 435px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 550px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح اطلاعات ورود و خروج</p></div>
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
            <div class="container"  style="margin: auto;background-color: #d7d7d7;width: 550px ;height: 145px;">

                <div class="row" style="margin-top:10px">

                    <div id="person_div88_edit" class="col" style="height:50px">

                        <div id="s2_edit" class="container" style="text-align: left;background-color:#17a2b8;width: 100%;border-radius: 5px;height:125px;direction: rtl;color: white;margin-top:2px;padding-top: 2px;">
                            <form method="post" encType="multipart/form-data" id="addindividuals2" action="{{route('addindividuals.store')}}">
                                {{csrf_field()}}
                                <div class="row" style="height: 15px">
                                    <div class="col-9">
                                        <select  class="form-control" name="enter_exit" id="enter_exit_edit" style="width: 35%;font-family: Tahoma;font-size: small;margin-top: 10px;margin-right: 10px" required>
                                            <option value=''>انتخاب ورود یا خروج</option>
                                            <option value='1'>ثبت ورود</option>
                                            <option value='2'>ثبت خروج</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-success" id="btnupdate" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:100%">ثبت اطلاعات</button>
                                    </div>


                                </div>
                                <br>
                                <br>
                                <input hidden type="text" id="code_melli" name="code_melli">
                                <input hidden type="text" name="i_ed" id="id_ed_edit"/>
                                <div class="row" style="height: 15px">
                                    <div class="col">
                                        <div class="form-group" >
                                            <div class="row">
                                                <div class="col-12">
{{--                                                    <div class="row">--}}
{{--                                                        <div class="col-7">--}}
{{--                                                            <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ ورود یا خروج:" name="date_enter" style="direction: rtl;font-family: Tahoma;font-size:small;width: 73%;text-align:center"  required title="تاریخ ورود یا خروج">--}}
{{--                                                        </div>--}}

{{--                                                    </div>--}}
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <input type="text" maxlength="10" class="form-control" id="time_enter_edit"  data-toggle="tooltip"  name="time_enter" style="direction: rtl;font-family: Tahoma;font-size:small;width: 73%;text-align:center" required placeholder="ساعت ورود یا خروج">
                                                        </div>
                                                        <div class="col-6">
                                                            <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ ورود یا خروج:" name="date_enter" style="direction: rtl;font-family: Tahoma;font-size:small;width: 73%;text-align:center"  required title="تاریخ ورود یا خروج">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:550px">
                <div class="toast bg-success individuals22" style="margin-top:20px;margin: auto;border-radius: 10px">
                    <div class="toast-body"><p id="individuals22" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                </div>
            </div>

        </div>
    </div>
</div>
    <div class="modal fade mt-3" id="daftar_modal" style="direction: rtl;">
    <div class="modal-dialog modal-md" id="editlist" style="margin-top: 100px;margin-left: 395px">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 498px " >
                <div class="row" style="width: 100%">
                    <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">تعیین بازه زمانی جستجو</p></div>
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
            <div class="container"  style="margin: auto;background-color:white;width: 495px ;height: 160px">

                <div class="row" style="margin-top: 30px">
                    <div class="col">
                        <div class="field row" >
                            <div class="col" style="text-align: left"><label for="date_exit_shamsi1" style="font-family: Tahoma;font-size: smaller;display: inline"> تاریخ شروع:</label></div>
                            <div class="col" style="text-align: center"><input type="text" maxlength="20" class="form-control" id="date_exit_shamsi1"  data-toggle="tooltip" data-placement="right"  name="date_exit_shamsi1" style="font-family: Tahoma;font-size: small;width: 100px;" required title="تاریخ شروع گزارش گیری"></div>
                        </div>
                        <div class="field row">
                            <div class="col" style="text-align: left"><label for="date_exit_shamsi2" style="font-family: Tahoma;font-size: small;display: inline"> تاریخ پایان:</label></div>
                            <div class="col" style="text-align: center"><input type="text" maxlength="20" class="form-control" id="date_exit_shamsi2"  data-toggle="tooltip" data-placement="right"  name="date_exit_shamsi2" style="direction: rtl;font-family: Tahoma;font-size: small;width: 100px" required title="تاریخ پایان گزارش گیری"></div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col">
                        <button type="button" id="daftarsearach" class="btn btn-success" style="font-family: Tahoma;font-size: small;color: white;width: 35%">جستجو</button>
                    </div>
                </div>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer bg-info" style="height: 20px;width:498px"></div>

        </div>
    </div>
</div>



@endsection


