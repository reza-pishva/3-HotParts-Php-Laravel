@extends('layouts.entering.app_third_reciever_entering2')
@section('content')
    {{--    مسئول حراست--}}
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
            bootstrap.Toast.Default.delay = 3000
            $('ul.tabs li').click(function(){
                var tab_id = $(this).attr('data-tab');

                $('ul.tabs li').removeClass('current');
                $('.tab-content').removeClass('current');

                $(this).addClass('current');
                $("#"+tab_id).addClass('current');
            })
            $('#first_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level4-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد دریافتی جهت تایید</p>')
                        var notconfirm=''
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit = ''
                        var del2 = ''
                        var confirm = ''
                        var t6=''
                        var t5 = ''
                        var t4 = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;font-size:x-small">شماره درخواست</td><td style="border-left:1px white solid;font-size:x-small">تاریخ درخواست</td><td style="border-left:1px white solid;font-size:x-small">علت درخواست</td><td style="border-left:1px white solid;font-size:x-small">مراجعه از</td><td style="border-left:1px white solid;font-size:x-small">درخواست کننده</td><td style="border-left:1px white solid;font-size:x-small">#</td><td style="border-left:1px white solid;font-size:x-small">#</td><td style="border-left:1px white solid;font-size:x-small">#</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            day=response.results[i]['date_shamsi'].substr(6,2)
                            month=response.results[i]['date_shamsi'].substr(4,2)
                            year=response.results[i]['date_shamsi'].substr(0,4)
                            id_ef = $('<td style="width: 5%;font-size:x-small">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 15%;text-align: right;padding-right: 5px;font-size:x-small">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 10%;text-align: right;padding-right: 5px;font-size:x-small">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 6%;font-size:x-small">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 7%;font-size:x-small">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 11%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-outline-dark del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#p_modal">لیست نفرات</button>').attr('id',  response.results[i]['id_ef'])
                            notconfirm = $('<button type="button" class="btn-sm btn-outline-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef']+4000)
                            confirm = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">ارسال</button>').attr('id',  response.results[i]['id_ef']+3000)
                            edit = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal3">ویرایش</button>').attr('id',  response.results[i]['id_ef']+5000)
                            t2 = $('<td style="width: 9%"></td>')
                            t4 = $('<td style="width: 6%"></td>')
                            t5 = $('<td style="width: 7%"></td>')
                            t6 = $('<td style="width: 6%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t2.append(del2)
                            t3.append(detail)
                            t4.append(confirm)
                            t5.append(notconfirm)
                            t6.append(edit)
                            row.append(id_ef,date_shamsi,title, company,l_name,t3,t6,t2,t4,t5)
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
                                        url: "/confirm3-entering/" + id_ef,
                                        type: 'GET',
                                        data: {
                                            "id": id_ef,
                                            "_token": token,
                                        },
                                        success: function () {
                                            $('.toast').toast('show');
                                            $("#mytoast").text("درخواست انتخابی تایید و برای مدیر نیروگاه ارسال گردید")
                                        }
                                    });

                                $(this).closest('tr').remove()
                            })
                            $('#' + (response.results[i]['id_ef']+4000)).on('click',function(){

                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();

                                $('#id_ef2').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#title2').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#company2').val($(this).closest('tr').find('td:eq(3)').text());

                            })
                            $('#' + (response.results[i]['id_ef']+5000)).on('click',function(){
                                $("#persons_table").empty();
                                $("#cars_table22").empty();
                                $("#ins_table").empty();
                                $("#eq1_table").empty();
                                $("#eq2_table").empty();
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                $("#id_ef_del").val(id_ef)
                                $("#id_ef1000").val(id_ef)
                                $("#id_ef1001").val(id_ef)
                                $("#id_ef1002").val(id_ef)
                                $("#id_ef1003").val(id_ef)
                                $("#id_ef1004").val(id_ef)
                                $.ajax({
                                    url: "/recivefirstreport1/"+id_ef,
                                    method:'GET',
                                    success: function (response) {
                                        $("#title_edit").val(response.title)
                                        $("#company_edit").val(response.company)
                                        var edit1=""
                                        var del1=""
                                        var day=""
                                        var month=""
                                        var year=""
                                        var id_ep=""
                                        var f_name=""
                                        var l_name=""
                                        var l_name2=""
                                        var t2=""
                                        var t3=""
                                        var id_et=""
                                        var nationality=""
                                        var age=""
                                        var time_enter=""
                                        var date_shamsi_enter=""
                                        var time_exit=""
                                        var date_shamsi_exit=""
                                        var code_melli=""
                                        var mobile=""
                                        var title=""
                                        $(".persons_row").remove();

                                        for(var i = 0; i < response.persons.length; i++) {
                                            id_ep = $('<td class="persons_edit">' + response.persons[i]['id_ep'] + '</td>')
                                            l_name2 = $('<td class="persons_edit">' + response.persons[i]['f_name'] +' '+response.persons[i]['l_name'] + '</td>')
                                            l_name = $('<td hidden class="persons_edit">' + response.persons[i]['l_name'] + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm btn-primary edit11" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s2_2">ویرایش</button>').attr('id',(Number(response.persons[i]['id_ep'])+8000))
                                            del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',(Number(response.persons[i]['id_ep'])+9000))
                                            f_name = $('<td hidden class="persons_edit">' + response.persons[i]['f_name'] + '</td>')
                                            id_et = $('<td hidden class="persons_edit">' + response.persons[i]['id_et'] + '</td>')
                                            nationality = $('<td hidden class="persons">' + response.persons[i]['nationality'] + '</td>')
                                            age = $('<td hidden class="persons">' + response.persons[i]['age'] + '</td>')
                                            time_enter = $('<td hidden class="persons">' + response.persons[i]['time_enter'] + '</td>')
                                            year=response.persons[i]['date_shamsi_enter'].substr(0, 4);
                                            month=response.persons[i]['date_shamsi_enter'].substr(4, 2);
                                            day=response.persons[i]['date_shamsi_enter'].substr(6, 2);
                                            date_shamsi_enter = $('<td hidden class="persons">' + year+'/'+month+'/'+day + '</td>')
                                            time_exit = $('<td hidden class="persons">' + response.persons[i]['time_exit'] + '</td>')
                                            year=response.persons[i]['date_shamsi_exit'].substr(0, 4);
                                            month=response.persons[i]['date_shamsi_exit'].substr(4, 2);
                                            day=response.persons[i]['date_shamsi_exit'].substr(6, 2);
                                            date_shamsi_exit = $('<td hidden class="persons">' + year+'/'+month+'/'+day + '</td>')
                                            code_melli = $('<td hidden class="persons">' + response.persons[i]['code_melli'] + '</td>')
                                            mobile = $('<td hidden class="persons">' + response.persons[i]['mobile'] + '</td>')
                                            for(var z = 0; z < response.titles.length; z++) {
                                                if(response.titles[z]['id_et']==response.persons[i]['id_et']){
                                                    id_et = $('<td hidden class="persons">' + response.titles[z]['id_et'] + '</td>')
                                                    break;
                                                }

                                            }
                                            t2 = $('<td style="font-size: 12px"></td>')
                                            t3 = $('<td></td>')
                                            t2.append(edit1)
                                            t3.append(del1)
                                            row = $('<tr class="persons_row" style="font-family: Tahoma;font-size: 11px;color: white"></tr>')
                                            row.append(id_ep,l_name,f_name,l_name2,nationality,age,time_enter,date_shamsi_enter,time_exit,date_shamsi_exit,code_melli,mobile,id_et,t2,t3)
                                            $("#persons_table").append(row)
                                            $('#' + (response.persons[i]['id_ep']+8000)).on('click',function(){
                                                $("#id_ep_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#f_name_edit").val($(this).closest('tr').find('td:eq(2)').text());
                                                $("#l_name_edit").val($(this).closest('tr').find('td:eq(1)').text());
                                                $("#nationality_edit").val($(this).closest('tr').find('td:eq(4)').text());
                                                $("#age_edit").val($(this).closest('tr').find('td:eq(5)').text());
                                                $("#time_enter_edit").val($(this).closest('tr').find('td:eq(6)').text());
                                                $("#date_shamsi_enter_edit").val($(this).closest('tr').find('td:eq(7)').text());
                                                $("#time_exit_edit").val($(this).closest('tr').find('td:eq(8)').text());
                                                $("#date_shamsi_exit_edit").val($(this).closest('tr').find('td:eq(9)').text());
                                                $("#code_melli_edit").val($(this).closest('tr').find('td:eq(10)').text());
                                                $("#mobile_edit").val($(this).closest('tr').find('td:eq(11)').text());
                                                $("#id_et_edit").val($(this).closest('tr').find('td:eq(12)').text());
                                            })
                                            $('#' + (response.persons[i]['id_ep']+9000)).on('click',function() {
                                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/enter-delete2/" + id_ep,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ep,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if (true) {
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این فرد از این فرم حذف گردید');

                                                        }
                                                        $("#" + (Number(id_ep) + 9000)).closest('tr').remove();
                                                    }
                                                });
                                            })

                                        }
                                        var height1=(($('#person_table tr').length)*33).toString()+'px'
                                        var height2=(($('#person_table tr').length)*33+11).toString()+'px'
                                        $("#person_table").css('height',height1)
                                        $("#person_div").css('height',height2)
                                        var edit2=""
                                        var del2=""
                                        var id_ec=""
                                        var car_name=""
                                        var car_no=""
                                        var driver_name=""
                                        var area=""
                                        var part1=""
                                        var part2=""
                                        var part3=""
                                        var t2=""
                                        var t3=""
                                        $(".cars_row").remove();
                                        for(var j = 0; j <response.cars.length; j++) {
                                            id_ec = $('<td>' + response.cars[j]['id_ec'] + '</td>')
                                            car_name = $('<td>' +response.cars[j]['car_name'] + '</td>')
                                            edit2 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s3_2">ویرایش</button>').attr('id',response.cars[j]['id_ec'] + 8000)
                                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.cars[j]['id_ec']+9000)
                                            part1 = $('<td hidden class="cars">' + response.cars[j]['car_no'].substr(3,3) + '</td>')
                                            part2 = $('<td hidden class="cars">' + response.cars[j]['car_no'].substr(0,1) + '</td>')
                                            part3 = $('<td hidden class="cars">' + response.cars[j]['car_no'].substr(1,2) + '</td>')
                                            car_no = $('<td hidden class="cars">' + response.cars[j]['car_no'] + '</td>')
                                            driver_name = $('<td>' + response.cars[j]['driver_name'] + '</td>')
                                            area = $('<td hidden class="cars">' + response.cars[j]['area'] + '</td>')
                                            row = $('<tr class="cars_row" style="font-family: Tahoma;font-size: 12px;color: white"></tr>')
                                            t2 = $('<td></td>')
                                            t3 = $('<td></td>')
                                            t2.append(edit2)
                                            t3.append(del2)

                                            row.append(id_ec,car_name,driver_name,car_no,area,part1,part2,part3,t2,t3)
                                            $("#cars_table22").append(row)
                                            $('#' + (Number(response.cars[j]['id_ec']+8000))).on('click',function(){
                                                $("#id_ec_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#car_name_edit").val($(this).closest('tr').find('td:eq(1)').text());
                                                $("#car_no_edit").val($(this).closest('tr').find('td:eq(3)').text());
                                                $("#driver_name_edit").val($(this).closest('tr').find('td:eq(2)').text());
                                                $("#area_edit").val($(this).closest('tr').find('td:eq(4)').text());
                                                $("#no1_edit").val($(this).closest('tr').find('td:eq(5)').text());
                                                $("#no2_edit").val($(this).closest('tr').find('td:eq(6)').text());
                                                $("#no3_edit").val($(this).closest('tr').find('td:eq(7)').text());

                                            })
                                            $('#' + (Number(response.cars[j]['id_ec']+9000))).on('click',function(){
                                                var id_ec =  $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/car-delete2/" + id_ec,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ec,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {

                                                        if(response.car==0){
                                                            $('#s3_3').modal('toggle')
                                                        }
                                                        if(response.car>0){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این خودرو از این فرم حذف گردید');

                                                        }
                                                    }
                                                });
                                                $(this).closest('tr').remove();






                                            })
                                        }

                                        height1=(($('#cars_table22 tr').length)*25).toString()+'px'
                                        height2=(($('#cars_div tr').length)*25+11).toString()+'px'
                                        $("#cars_table22").css('height',height1)
                                        $("#cars_div").css('height',height2)

                                        var id_ei=""
                                        var description1=""
                                        var serial_no1=""
                                        var row=""
                                        var edit3=""
                                        var del3=""
                                        var t4=""
                                        var t5=""

                                        $(".els_row").remove();
                                        for(var z = 0; z <response.els.length; z++) {
                                            id_ei = $('<td class="els">' + response.els[z]['id_ei'] + '</td>')
                                            description1 = $('<td class="els">' +response.els[z]['description'] + '</td>')
                                            serial_no1 = $('<td hidden class="el2">' +response.els[z]['serial_no'] + '</td>')
                                            edit3 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s4_2">ویرایش</button>').attr('id',response.els[z]['id_ei'] + 8000)
                                            del3 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.els[z]['id_ei']+9000)
                                            row = $('<tr class="els_row" style="font-family: Tahoma;font-size: 12px;color: white"></tr>')
                                            t4 = $('<td></td>')
                                            t5 = $('<td></td>')
                                            t4.append(edit3)
                                            t5.append(del3)
                                            row.append(id_ei,description1,t4,t5,serial_no1)
                                            $("#ins_table").append(row)
                                            $('#' + (response.els[z]['id_ei']+8000)).on('click',function(){
                                                $("#id_ei_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#description_ins_edit").val($(this).closest('tr').find('td:eq(1)').text());
                                                $("#serial_no_ins_edit").val($(this).closest('tr').find('td:eq(4)').text());
                                            })
                                            $('#' + (response.els[z]['id_ei']+9000)).on('click',function(){
                                                var id_ei =  $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/ins-delete2/" + id_ei,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ei,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(true){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این وسیله از فرم حذف گردید');

                                                        }
                                                        $("#"+(Number(id_ei)+9000)).closest('tr').remove();
                                                    }
                                                });

                                            })

                                        }
                                        height1=(($('#ins_table tr').length)*25).toString()+'px'
                                        height2=(($('#ins_table tr').length)*25+11).toString()+'px'
                                        $("#ins_table").css('height',height1)
                                        $("#ins_div").css('height',height2)




                                        var id_ee=""
                                        var description2=""
                                        var edit4=""
                                        var del4=""
                                        var t6 = ""
                                        var t7 = ""

                                        $(".eqs_row").remove();

                                        for(var k = 0; k <response.eqs.length; k++) {
                                            id_ee = $('<td class="eqs">' + response.eqs[k]['id_ee'] + '</td>')
                                            description2 = $('<td class="eqs">'+response.eqs[k]['description']+'</td>')
                                            row = $('<tr class="eqs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                            edit4 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s5_2">ویرایش</button>').attr('id',response.eqs[k]['id_ee']+8000)
                                            del4 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.eqs[k]['id_ee']+9000)
                                            t6 = $('<td></td>')
                                            t7 = $('<td></td>')
                                            t6.append(edit4)
                                            t7.append(del4)
                                            row.append(id_ee,description2,t6,t7)
                                            $("#eq1_table").append(row)
                                            $('#' + (response.eqs[k]['id_ee']+8000)).on('click',function(){
                                                $("#id_ee_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#description_eq_edit").val($(this).closest('tr').find('td:eq(1)').text());

                                            })
                                            $('#' + (response.eqs[k]['id_ee']+9000)).on('click',function(){
                                                var id_ee =  $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/eq-delete2/" + id_ee,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ee,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(true){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این وسیله از فرم حذف گردید');

                                                        }
                                                        $("#"+(Number(id_ee)+9000)).closest('tr').remove();
                                                    }
                                                });

                                            })

                                        }

                                        // height1=(($('#eq_table tr').length)*25).toString()+'px'
                                        // height2=(($('#eq_table tr').length)*25+11).toString()+'px'
                                        // $("#eq_table").css('height',height1)
                                        // $("#eq_div").css('height',height2)



                                        var id_eup=""
                                        var description3=""
                                        var del5=""
                                        var t8 = ""

                                        $(".equs_row").remove();

                                        for(var g = 0; g <response.equs.length; g++) {
                                            id_eup = $('<td>' + response.equs[g]['id_eup'] + '</td>')
                                            description3 = $('<td class="equs1"><a href="./documents/'+response.equs[g]['id_eup']+'.pdf">'+response.equs[g]['description']+'</a> </td>')
                                            row = $('<tr class="equs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                            del5 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.equs[g]['id_eup']+9000)
                                            t8 = $('<td></td>')
                                            t8.append(del5)
                                            row.append(id_eup,description3,t8)
                                            $("#eq2_table").append(row)
                                            $('#' + (response.equs[g]['id_eup']+9000)).click(function () {
                                                var id_eup = $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/eup-delete/" + id_eup,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_eup,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(response.eup==0){

                                                            $('#finish').hide();
                                                            $("#stage005").css("background-color","red");
                                                            $('#s5_3_2').modal('toggle')
                                                        }
                                                        if(response.eup>0){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این فایل الصاقی از این فرم حذف گردید');

                                                        }
                                                    }
                                                });
                                                $(this).closest('tr').remove();
                                            })

                                        }

                                        //
                                        // height1=(($('#equ_table tr').length)*25).toString()+'px'
                                        // height2=(($('#equ_table tr').length)*25+11).toString()+'px'
                                        // $("#equ_table").css('height',height1)
                                        // $("#equ_div").css('height',height2)


                                    }
                                })
                            })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#total').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/total-peaple',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">کلیه موارد</p>')
                        var notconfirm=''
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit = ''
                        var del2 = ''
                        var confirm = ''
                        var t6=''
                        var t5 = ''
                        var t4 = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;font-size:x-small">شماره درخواست</td><td style="border-left:1px white solid;font-size:x-small">تاریخ درخواست</td><td style="border-left:1px white solid;font-size:x-small">علت درخواست</td><td style="border-left:1px white solid;font-size:x-small">مراجعه از</td><td style="border-left:1px white solid;font-size:x-small">درخواست کننده</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            day=response.results[i]['date_shamsi'].substr(6,2)
                            month=response.results[i]['date_shamsi'].substr(4,2)
                            year=response.results[i]['date_shamsi'].substr(0,4)
                            id_ef = $('<td style="width: 4%;font-size:x-small">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 12%;text-align: right;padding-right: 5px;font-size:x-small">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 10%;text-align: right;padding-right: 5px;font-size:x-small">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 4%;font-size:x-small">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 5%;font-size:x-small">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 4%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-outline-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            del2 = $('<button type="button" class="btn-sm btn-outline-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#p_modal">لیست نفرات</button>').attr('id',  response.results[i]['id_ef'])
                            notconfirm = $('<button type="button" class="btn-sm btn-outline-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal2">عدم تایید</button>').attr('id',  response.results[i]['id_ef']+4000)
                            confirm = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">ارسال</button>').attr('id',  response.results[i]['id_ef']+3000)
                            edit = $('<button type="button" class="btn-sm btn-outline-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal3">ویرایش</button>').attr('id',  response.results[i]['id_ef']+5000)
                            t6 = $('<td style="width: 4%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(detail)
                            t6.append(edit)
                            row.append(id_ef,date_shamsi,title,company,l_name,t6,t3)
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





                            $('#' + (response.results[i]['id_ef']+4000)).on('click',function(){

                                $('#ajax-alert1').hide();
                                $('#ajax-alert2').hide();
                                $('#ajax-alert3').hide();

                                $('#id_ef2').val($(this).closest('tr').find('td:eq(0)').text());
                                $('#title2').val($(this).closest('tr').find('td:eq(2)').text());
                                $('#company2').val($(this).closest('tr').find('td:eq(3)').text());

                            })
                            $('#' + (response.results[i]['id_ef']+5000)).on('click',function(){
                                $("#persons_table").empty();
                                $("#cars_table22").empty();
                                $("#ins_table").empty();
                                $("#eq1_table").empty();
                                $("#eq2_table").empty();
                                var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                $("#id_ef_del").val(id_ef)
                                $("#id_ef1000").val(id_ef)
                                $("#id_ef1001").val(id_ef)
                                $("#id_ef1002").val(id_ef)
                                $("#id_ef1003").val(id_ef)
                                $("#id_ef1004").val(id_ef)
                                $.ajax({
                                    url: "/recivefirstreport1/"+id_ef,
                                    method:'GET',
                                    success: function (response) {
                                        $("#title_edit").val(response.title)
                                        $("#company_edit").val(response.company)
                                        var edit1=""
                                        var del1=""
                                        var history=""
                                        var day=""
                                        var month=""
                                        var year=""
                                        var id_ep=""
                                        var f_name=""
                                        var l_name=""
                                        var l_name2=""
                                        var t2=""
                                        var t3=""
                                        var t4=""
                                        var id_et=""
                                        var nationality=""
                                        var age=""
                                        var time_enter=""
                                        var date_shamsi_enter=""
                                        var time_exit=""
                                        var date_shamsi_exit=""
                                        var code_melli=""
                                        var mobile=""
                                        var title=""
                                        $(".persons_row").remove();

                                        for(var i = 0; i < response.persons.length; i++) {
                                            id_ep = $('<td class="persons_edit">' + response.persons[i]['id_ep'] + '</td>')
                                            l_name2 = $('<td class="persons_edit">' + response.persons[i]['f_name'] +' '+response.persons[i]['l_name'] + '</td>')
                                            l_name = $('<td hidden class="persons_edit">' + response.persons[i]['l_name'] + '</td>')
                                            edit1 = $('<button type="button" class="btn-sm btn-primary edit11" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s2_2">ویرایش</button>').attr('id',(Number(response.persons[i]['id_ep'])+8000))
                                            del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',(Number(response.persons[i]['id_ep'])+9000))
                                            history = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo4">سابقه فرد</button>').attr('id',(Number(response.persons[i]['id_ep'])+7000))
                                            f_name = $('<td hidden class="persons_edit">' + response.persons[i]['f_name'] + '</td>')
                                            id_et = $('<td hidden class="persons_edit">' + response.persons[i]['id_et'] + '</td>')
                                            nationality = $('<td hidden class="persons">' + response.persons[i]['nationality'] + '</td>')
                                            age = $('<td hidden class="persons">' + response.persons[i]['age'] + '</td>')
                                            time_enter = $('<td hidden class="persons">' + response.persons[i]['time_enter'] + '</td>')
                                            year=response.persons[i]['date_shamsi_enter'].substr(0, 4);
                                            month=response.persons[i]['date_shamsi_enter'].substr(4, 2);
                                            day=response.persons[i]['date_shamsi_enter'].substr(6, 2);
                                            date_shamsi_enter = $('<td hidden class="persons">' + year+'/'+month+'/'+day + '</td>')
                                            time_exit = $('<td hidden class="persons">' + response.persons[i]['time_exit'] + '</td>')
                                            year=response.persons[i]['date_shamsi_exit'].substr(0, 4);
                                            month=response.persons[i]['date_shamsi_exit'].substr(4, 2);
                                            day=response.persons[i]['date_shamsi_exit'].substr(6, 2);
                                            date_shamsi_exit = $('<td hidden class="persons">' + year+'/'+month+'/'+day + '</td>')
                                            code_melli = $('<td hidden class="persons">' + response.persons[i]['code_melli'] + '</td>')
                                            mobile = $('<td hidden class="persons">' + response.persons[i]['mobile'] + '</td>')
                                            for(var z = 0; z < response.titles.length; z++) {
                                                if(response.titles[z]['id_et']==response.persons[i]['id_et']){
                                                    id_et = $('<td hidden class="persons">' + response.titles[z]['id_et'] + '</td>')
                                                    break;
                                                }

                                            }
                                            t2 = $('<td style="font-size: 12px"></td>')
                                            t3 = $('<td></td>')
                                            t4 = $('<td></td>')
                                            t2.append(edit1)
                                            t3.append(del1)
                                            t4.append(history)
                                            row = $('<tr class="persons_row" style="font-family: Tahoma;font-size: 11px;color: white"></tr>')
                                            row.append(id_ep,l_name,f_name,l_name2,nationality,age,time_enter,date_shamsi_enter,time_exit,date_shamsi_exit,code_melli,mobile,id_et,t2,t4)
                                            $("#persons_table").append(row)
                                            $('#' + (response.persons[i]['id_ep']+8000)).on('click',function(){
                                                $("#id_ep_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#f_name_edit").val($(this).closest('tr').find('td:eq(2)').text());
                                                $("#l_name_edit").val($(this).closest('tr').find('td:eq(1)').text());
                                                $("#nationality_edit").val($(this).closest('tr').find('td:eq(4)').text());
                                                $("#age_edit").val($(this).closest('tr').find('td:eq(5)').text());
                                                $("#time_enter_edit").val($(this).closest('tr').find('td:eq(6)').text());
                                                $("#date_shamsi_enter_edit").val($(this).closest('tr').find('td:eq(7)').text());
                                                $("#time_exit_edit").val($(this).closest('tr').find('td:eq(8)').text());
                                                $("#date_shamsi_exit_edit").val($(this).closest('tr').find('td:eq(9)').text());
                                                $("#code_melli_edit").val($(this).closest('tr').find('td:eq(10)').text());
                                                $("#mobile_edit").val($(this).closest('tr').find('td:eq(11)').text());
                                                $("#id_et_edit").val($(this).closest('tr').find('td:eq(12)').text());
                                            })
                                            $('#' + (response.persons[i]['id_ep']+9000)).on('click',function() {
                                                var id_ep = $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/enter-delete2/" + id_ep,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ep,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if (true) {
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این فرد از این فرم حذف گردید');

                                                        }
                                                        $("#" + (Number(id_ep) + 9000)).closest('tr').remove();
                                                    }
                                                });
                                            })
                                            $('#' + (response.persons[i]['id_ep']+7000)).on('click',function(){

                                                var code_melli = $(this).closest('tr').find('td:eq(10)').text();;

                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax(
                                                    {
                                                        url: "/enterexit-history/" + code_melli,
                                                        type: 'GET',
                                                        data: {
                                                            "id": code_melli,
                                                            "_token": token,
                                                        },
                                                        success: function (response) {
                                                            var id_ef = ''
                                                            var id_ep = ''
                                                            var date1 = ''
                                                            var date2 = ''
                                                            var row = ''
                                                            $(".personinfo2").remove();
                                                            for(var i = 0; i < response.results.length; i++) {
                                                                id_ep = $('<td style="width:11%;text-align: center" class="personinfo2">' + response.results[i]['id_ep'] + '</td>')
                                                                id_ef = $('<td style="width:11%;text-align: center" class="personinfo2">' + response.results[i]['id_ef'] + '</td>')
                                                                var day=response.results[i]['date_shamsi_enter'].substr(6,2)
                                                                var month=response.results[i]['date_shamsi_enter'].substr(4,2)
                                                                var year=response.results[i]['date_shamsi_enter'].substr(0,4)
                                                                var date1 = $('<td style="text-align: center;padding-right: 5px;width: 22%" class="personinfo2">' + year +'/'+month+'/'+day+'</td>')
                                                                var day=response.results[i]['date_shamsi_exit'].substr(6,2)
                                                                var month=response.results[i]['date_shamsi_exit'].substr(4,2)
                                                                var year=response.results[i]['date_shamsi_exit'].substr(0,4)
                                                                var date2 = $('<td style="text-align: center;padding-right: 5px;width: 22%" class="personinfo2">' + year +'/'+month+'/'+day+'</td>')
                                                                row = $('<tr class="report_row"></tr>')
                                                                row.append(id_ef,id_ep,date1,date2)
                                                                $("#person_table66").append(row)
                                                            }

                                                        }
                                                    });
                                            })

                                        }
                                        var height1=(($('#person_table tr').length)*33).toString()+'px'
                                        var height2=(($('#person_table tr').length)*33+11).toString()+'px'
                                        $("#person_table").css('height',height1)
                                        $("#person_div").css('height',height2)
                                        var edit2=""
                                        var del2=""
                                        var id_ec=""
                                        var car_name=""
                                        var car_no=""
                                        var driver_name=""
                                        var area=""
                                        var part1=""
                                        var part2=""
                                        var part3=""
                                        var t2=""
                                        var t3=""
                                        $(".cars_row").remove();
                                        for(var j = 0; j <response.cars.length; j++) {
                                            id_ec = $('<td>' + response.cars[j]['id_ec'] + '</td>')
                                            car_name = $('<td>' +response.cars[j]['car_name'] + '</td>')
                                            edit2 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s3_2">ویرایش</button>').attr('id',response.cars[j]['id_ec'] + 8000)
                                            del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.cars[j]['id_ec']+9000)
                                            part1 = $('<td hidden class="cars">' + response.cars[j]['car_no'].substr(3,3) + '</td>')
                                            part2 = $('<td hidden class="cars">' + response.cars[j]['car_no'].substr(0,1) + '</td>')
                                            part3 = $('<td hidden class="cars">' + response.cars[j]['car_no'].substr(1,2) + '</td>')
                                            car_no = $('<td hidden class="cars">' + response.cars[j]['car_no'] + '</td>')
                                            driver_name = $('<td>' + response.cars[j]['driver_name'] + '</td>')
                                            area = $('<td hidden class="cars">' + response.cars[j]['area'] + '</td>')
                                            row = $('<tr class="cars_row" style="font-family: Tahoma;font-size: 12px;color: white"></tr>')
                                            t2 = $('<td></td>')
                                            t3 = $('<td></td>')
                                            t2.append(edit2)
                                            t3.append(del2)

                                            row.append(id_ec,car_name,driver_name,car_no,area,part1,part2,part3,t2,t3)
                                            $("#cars_table22").append(row)
                                            $('#' + (Number(response.cars[j]['id_ec']+8000))).on('click',function(){
                                                $("#id_ec_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#car_name_edit").val($(this).closest('tr').find('td:eq(1)').text());
                                                $("#car_no_edit").val($(this).closest('tr').find('td:eq(3)').text());
                                                $("#driver_name_edit").val($(this).closest('tr').find('td:eq(2)').text());
                                                $("#area_edit").val($(this).closest('tr').find('td:eq(4)').text());
                                                $("#no1_edit").val($(this).closest('tr').find('td:eq(5)').text());
                                                $("#no2_edit").val($(this).closest('tr').find('td:eq(6)').text());
                                                $("#no3_edit").val($(this).closest('tr').find('td:eq(7)').text());

                                            })
                                            $('#' + (Number(response.cars[j]['id_ec']+9000))).on('click',function(){
                                                var id_ec =  $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/car-delete2/" + id_ec,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ec,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {

                                                        if(response.car==0){
                                                            $('#s3_3').modal('toggle')
                                                        }
                                                        if(response.car>0){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این خودرو از این فرم حذف گردید');

                                                        }
                                                    }
                                                });
                                                $(this).closest('tr').remove();






                                            })
                                        }

                                        height1=(($('#cars_table22 tr').length)*25).toString()+'px'
                                        height2=(($('#cars_div tr').length)*25+11).toString()+'px'
                                        $("#cars_table22").css('height',height1)
                                        $("#cars_div").css('height',height2)

                                        var id_ei=""
                                        var description1=""
                                        var serial_no1=""
                                        var row=""
                                        var edit3=""
                                        var del3=""
                                        var t4=""
                                        var t5=""

                                        $(".els_row").remove();
                                        for(var z = 0; z <response.els.length; z++) {
                                            id_ei = $('<td class="els">' + response.els[z]['id_ei'] + '</td>')
                                            description1 = $('<td class="els">' +response.els[z]['description'] + '</td>')
                                            serial_no1 = $('<td hidden class="el2">' +response.els[z]['serial_no'] + '</td>')
                                            edit3 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s4_2">ویرایش</button>').attr('id',response.els[z]['id_ei'] + 8000)
                                            del3 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.els[z]['id_ei']+9000)
                                            row = $('<tr class="els_row" style="font-family: Tahoma;font-size: 12px;color: white"></tr>')
                                            t4 = $('<td></td>')
                                            t5 = $('<td></td>')
                                            t4.append(edit3)
                                            t5.append(del3)
                                            row.append(id_ei,description1,t4,t5,serial_no1)
                                            $("#ins_table").append(row)
                                            $('#' + (response.els[z]['id_ei']+8000)).on('click',function(){
                                                $("#id_ei_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#description_ins_edit").val($(this).closest('tr').find('td:eq(1)').text());
                                                $("#serial_no_ins_edit").val($(this).closest('tr').find('td:eq(4)').text());
                                            })
                                            $('#' + (response.els[z]['id_ei']+9000)).on('click',function(){
                                                var id_ei =  $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/ins-delete2/" + id_ei,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ei,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(true){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این وسیله از فرم حذف گردید');

                                                        }
                                                        $("#"+(Number(id_ei)+9000)).closest('tr').remove();
                                                    }
                                                });

                                            })

                                        }
                                        height1=(($('#ins_table tr').length)*25).toString()+'px'
                                        height2=(($('#ins_table tr').length)*25+11).toString()+'px'
                                        $("#ins_table").css('height',height1)
                                        $("#ins_div").css('height',height2)




                                        var id_ee=""
                                        var description2=""
                                        var edit4=""
                                        var del4=""
                                        var t6 = ""
                                        var t7 = ""

                                        $(".eqs_row").remove();

                                        for(var k = 0; k <response.eqs.length; k++) {
                                            id_ee = $('<td class="eqs">' + response.eqs[k]['id_ee'] + '</td>')
                                            description2 = $('<td class="eqs">'+response.eqs[k]['description']+'</td>')
                                            row = $('<tr class="eqs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                            edit4 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s5_2">ویرایش</button>').attr('id',response.eqs[k]['id_ee']+8000)
                                            del4 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.eqs[k]['id_ee']+9000)
                                            t6 = $('<td></td>')
                                            t7 = $('<td></td>')
                                            t6.append(edit4)
                                            t7.append(del4)
                                            row.append(id_ee,description2,t6,t7)
                                            $("#eq1_table").append(row)
                                            $('#' + (response.eqs[k]['id_ee']+8000)).on('click',function(){
                                                $("#id_ee_edit").val($(this).closest('tr').find('td:eq(0)').text());
                                                $("#description_eq_edit").val($(this).closest('tr').find('td:eq(1)').text());

                                            })
                                            $('#' + (response.eqs[k]['id_ee']+9000)).on('click',function(){
                                                var id_ee =  $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/eq-delete2/" + id_ee,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_ee,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(true){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این وسیله از فرم حذف گردید');

                                                        }
                                                        $("#"+(Number(id_ee)+9000)).closest('tr').remove();
                                                    }
                                                });

                                            })

                                        }

                                        // height1=(($('#eq_table tr').length)*25).toString()+'px'
                                        // height2=(($('#eq_table tr').length)*25+11).toString()+'px'
                                        // $("#eq_table").css('height',height1)
                                        // $("#eq_div").css('height',height2)



                                        var id_eup=""
                                        var description3=""
                                        var del5=""
                                        var t8 = ""

                                        $(".equs_row").remove();

                                        for(var g = 0; g <response.equs.length; g++) {
                                            id_eup = $('<td>' + response.equs[g]['id_eup'] + '</td>')
                                            description3 = $('<td class="equs1"><a href="./documents/'+response.equs[g]['id_eup']+'.pdf">'+response.equs[g]['description']+'</a> </td>')
                                            row = $('<tr class="equs_row" style="font-family: Tahoma;font-size: 12px;color: black"></tr>')
                                            del5 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.equs[g]['id_eup']+9000)
                                            t8 = $('<td></td>')
                                            t8.append(del5)
                                            row.append(id_eup,description3,t8)
                                            $("#eq2_table").append(row)
                                            $('#' + (response.equs[g]['id_eup']+9000)).click(function () {
                                                var id_eup = $(this).closest('tr').find('td:eq(0)').text();
                                                var token = $("meta[name='csrf-token']").attr("content");
                                                $.ajax({
                                                    url: "/eup-delete/" + id_eup,
                                                    type: 'DELETE',
                                                    data: {
                                                        "id": id_eup,
                                                        "_token": token,
                                                    },
                                                    success: function (response) {
                                                        if(response.eup==0){

                                                            $('#finish').hide();
                                                            $("#stage005").css("background-color","red");
                                                            $('#s5_3_2').modal('toggle')
                                                        }
                                                        if(response.eup>0){
                                                            toastr.options = {
                                                                "closeButton": true,
                                                                "debug": false,
                                                                "positionClass": "toast-top-right",
                                                                "onclick": null,
                                                                "showDuration": "300",
                                                                "hideDuration": "1000",
                                                                "timeOut": "3000",
                                                                "extendedTimeOut": "1000",
                                                                "showEasing": "swing",
                                                                "hideEasing": "linear",
                                                                "showMethod": "fadeIn",
                                                                "hideMethod": "fadeOut"
                                                            };
                                                            toastr.error('این فایل الصاقی از این فرم حذف گردید');

                                                        }
                                                    }
                                                });
                                                $(this).closest('tr').remove();
                                            })

                                        }

                                        //
                                        // height1=(($('#equ_table tr').length)*25).toString()+'px'
                                        // height2=(($('#equ_table tr').length)*25+11).toString()+'px'
                                        // $("#equ_table").css('height',height1)
                                        // $("#equ_div").css('height',height2)


                                    }
                                })
                            })
                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})
            })
            $('#for_modir').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level5-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد ارسالی برای مدیر نیروگاه</p>')
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var confirm = ''
                        var t4 = ''
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
                            title = $('<td style="width: 30%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 18%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 9%">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 14%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            // del2 = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#p_modal">لیست نفرات</button>').attr('id',  response.results[i]['id_ef'])
                            confirm = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef']+3000)
                            // t2 = $('<td style="width: 12%"></td>')
                            t4 = $('<td style="width: 20%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            // t2.append(del2)
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
                                        url: "/kartabl3-entering/" + id_ef,
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
            $('#for_requester').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/level3-3entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد تاید نشده توسط شما</p>')
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var confirm = ''
                        var t4 = ''
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
                            title = $('<td style="width: 30%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 18%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            date_shamsi = $('<td style="width: 9%">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
                            t3 = $('<td style="width: 14%"></td>')
                            detail = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#myModal4">جزئیات درخواست</button>').attr('id',  response.results[i]['id_ef'] +2000)
                            // del2 = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#p_modal">لیست نفرات</button>').attr('id',  response.results[i]['id_ef'])
                            confirm = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">بازگشت به کارتابل</button>').attr('id',  response.results[i]['id_ef']+3000)
                            // t2 = $('<td style="width: 12%"></td>')
                            t4 = $('<td style="width: 20%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            // t2.append(del2)
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
                                        url: "/kartabl3-entering/" + id_ef,
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
            $('#for_requester2').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/3not-confirmed-boss3-entering',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست موارد تایید نشده توسط مدیر نیروگاه</p>')
                        var day=''
                        var month=''
                        var year=''
                        var id_ef = ''
                        var date_shamsi = ''
                        var detail = ''
                        var title = ''
                        var company = ''
                        var l_name = ''
                        var t1 = ''
                        var edit1 = ''
                        var del2 = ''
                        var confirm = ''
                        var reason3=''
                        var t4 = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;"><td style="border-left:1px white solid;">شماره درخواست</td><td style="border-left:1px white solid;">تاریخ درخواست</td><td style="border-left:1px white solid;">علت درخواست</td><td style="border-left:1px white solid;">مراجعه از</td><td style="border-left:1px white solid;">درخواست کننده</td><td style="border-left:1px white solid;">علت عدم تایید مدیر نیروگاه</td><td style="border-left:1px white solid;">#</td><td style="border-left:1px white solid;">#</td></tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            day=response.results[i]['date_shamsi'].substr(6,2)
                            month=response.results[i]['date_shamsi'].substr(4,2)
                            year=response.results[i]['date_shamsi'].substr(0,4)
                            id_ef = $('<td style="width: 4%">' + response.results[i]['id_ef'] + '</td>')
                            title = $('<td style="width: 20%;text-align: right;padding-right: 5px">' + response.results[i]['title'] + '</td>')
                            company = $('<td style="width: 15%;text-align: right;padding-right: 5px">' +response.results[i]['company'] + '</td>')
                            reason3 = $('<td style="width: 17%;text-align: right;padding-right: 5px;color:red">' +response.results[i]['reason3'] + '</td>')
                            date_shamsi = $('<td style="width: 8%">' + year+'/'+month+'/'+day + '</td>')

                            for(var z = 0; z < response.users.length; z++) {
                                if(response.users[z]['id']==response.results[i]['id_user']){
                                    l_name = $('<td style="width: 10%">' + response.users[z]['l_name'] + '</td>')
                                    break;
                                }

                            }
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
                            row.append(id_ef,date_shamsi,title, company,l_name,reason3,t3,t4)
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
                                        url: "/kartabl3-entering/" + id_ef,
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
            $('#second_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/auth-peaple2',
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
                        var t3 = ''
                        var t2 = ''
                        var row = ''
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
                            form = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo">توضیحات</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ep']).click(function () {

                                // $("#sixth_report33").show()
                                // $("#sixth_report34").show()
                                var code_melli = $(this).closest('tr').find('td:eq(3)').text();
                                // $('#code_melli_s2').val($('#code_melli_s').val());
                                // $('#code_melli').val(code_melli);
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

                                            // if(response.let_show =="0"){
                                            //     alert('مجوز ورود این فرد هنوز صادر نشده')
                                            //     $("#sixth_report33").hide()
                                            //     $("#sixth_report34").hide()
                                            // }

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

                                            $("#person_table33").append(row)

                                            $("#title22").html(response.job)
                                            $("#company22").html(response.company)
                                            $("#cardno22").html(response.cardno)
                                            // var date_exit=Number(toEnglishNumber(response.date2));
                                            // var date_current=Number(toEnglishNumber(response.date));
                                            // alert(date_exit);
                                            // alert(date_current);
                                            // if(date_current>date_exit){
                                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                                            //     $("#sixth_report33").hide()
                                            // }
                                            // if(date_current<date_exit){
                                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد')
                                            //     $("#sixth_report33").show()
                                            //     $("#sixth_report34").show()
                                            // }



                                            if(response.cardno>=1){$("#cardno44").text(response.cardno)}else{$("#cardno44").text('ندارد')}

                                            var id_ehf = ''
                                            var description = ''
                                            var row = ''
                                            $(".hefazatinfo").remove();
                                            // alert(response.hefazat);
                                            for(var u = 0; u < response.hefazat.length; u++) {
                                                id_ehf = $('<td style="width: 5%;text-align: center;color: #007be6" class="personinfo">' + response.hefazat[u]['id_ehf'] + '</td>')
                                                description = $('<td style="width: 13%;text-align: right;padding-right: 5px;color: #007be6" class="personinfo">' + response.hefazat[u]['description'] + '</td>')
                                                row = $('<tr class="report_row"></tr>')
                                                row.append(id_ehf, description)
                                                $("#hefazat_table2").append(row)
                                            }
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




                        }
                        $(".mylist").hide();
                        $('.mylist2').hide();
                        $('.mylist3').hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#present').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/presence',
                    method:'GET',
                    success: function (response) {
                        alert('تعداد حاضرین: '+response.count_persons+'نفر ');
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افراد وارد شده به نیروگاه</p>')
                        var id_ep = ''
                        var id_ef = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var herasat = ''
                        var form = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
                        var row_th ='<tr class="bg-info report_row" style="color: white;height: 30px;">' +
                            '<td style="border-left:1px white solid;">کد درخواست</td>' +
                            '<td style="border-left:1px white solid;">کد فرد</td>' +
                            '<td style="border-left:1px white solid;">نام</td>' +
                            '<td style="border-left:1px white solid;">نام خانوادگی</td>' +
                            '<td style="border-left:1px white solid;">کد ملی</td>' +
                            '<td style="border-left:1px white solid;">شماره تماس</td>' +
                            '<td style="border-left:1px white solid;">تحت عنوان</td>' +
                            '</tr>'
                        $("#report_table").append(row_th)

                        for(var i = 0; i < response.results.length; i++) {
                            id_ef = $('<td style="width: 6%;text-align: center">' + response.results[i]['id_ef'] + '</td>')
                            id_ep = $('<td style="width: 7%;text-align: center">' + response.results[i]['id_ep'] + '</td>')
                            f_name = $('<td style="width: 16%;text-align: center;padding-right: 5px">' + response.results[i]['f_name'] + '</td>')
                            l_name = $('<td style="width: 22%;text-align: center;padding-right: 5px">' +response.results[i]['l_name'] + '</td>')
                            code_melli = $('<td style="width: 22%;text-align: center;padding-right: 5px">' + response.results[i]['code_melli'] + '</td>')
                            tell = $('<td style="width: 15%;text-align: center;padding-right: 5px">' +response.results[i]['mobile'] + '</td>')
                            id_et=response.results[i]['id_et']
                            for(var z = 0; z < response.titles.length; z++) {
                                if(response.titles[z]['id_et']==response.results[i]['id_et']){
                                    title = $('<td style="width: 12%">' + response.titles[z]['description'] + '</td>')
                                    break;
                                }

                            }
                            form = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo">توضیحات</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            row.append(id_ef,id_ep,f_name,l_name,code_melli,tell,title)
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

                                            // var id_ehf = ''
                                            // var description = ''
                                            // var row = ''
                                            // $(".hefazatinfo").remove();
                                            // for(var i = 0; i < response.hefazat.length; i++) {
                                            //     id_ehf = $('<td style="width: 5%;text-align: center" class="personinfo">' + response.hefazat[i]['id_ehf'] + '</td>')
                                            //     description = $('<td style="width: 13%;text-align: right;padding-right: 5px" class="personinfo">' + response.hefazat[i]['description'] + '</td>')
                                            //     row = $('<tr class="report_row"></tr>')
                                            //     row.append(id_ehf, description)
                                            //     $("#hefazat_table2").append(row)
                                            // }

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
            $('#third_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/unauth-peaple',
                    method:'GET',
                    success: function (response) {
                        $(".report_row").remove();
                        $('#title_report').html('<p id="title" style="margin-top: 7px;color: white">لیست افراد غیر مجاز برای ورود به نیروگاه</p>')
                        var id_ep = ''
                        var f_name = ''
                        var id_et = ''
                        var code_melli = ''
                        var tell = ''
                        var title = ''
                        var l_name = ''
                        var herasat = ''
                        var form = ''
                        var t3 = ''
                        var t2 = ''
                        var row = ''
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
                            form = $('<button type="button" class="btn-sm btn-info del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#personinfo">توضیحات</button>').attr('id',  response.results[i]['id_ep'])
                            t3 = $('<td style="width: 12%"></td>')
                            row = $('<tr class="report_row"></tr>')
                            t3.append(form)
                            row.append(id_ep,f_name,l_name,code_melli,tell,title,t3)
                            $("#report_table").append(row)
                            $("#editlist").css("margin-top","100px");
                            $('#' + response.results[i]['id_ep']).click(function () {
                                // $("#sixth_report33").show()
                                // $("#sixth_report34").show()
                                var code_melli = $(this).closest('tr').find('td:eq(3)').text();
                                // $('#code_melli_s2').val($('#code_melli_s').val());
                                // $('#code_melli').val(code_melli);
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
                                            // if(response.let_show =="0"){
                                            //     alert('مجوز ورود این فرد هنوز صادر نشده')
                                            //     $("#sixth_report33").hide()
                                            //     $("#sixth_report34").hide()
                                            // }

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

                                            $("#person_table33").append(row)

                                            $("#title22").html(response.job)
                                            $("#company22").html(response.company)
                                            $("#cardno22").html(response.cardno)
                                            // var date_exit=Number(toEnglishNumber(response.date2));
                                            // var date_current=Number(toEnglishNumber(response.date));
                                            // alert(date_exit);
                                            // alert(date_current);
                                            // if(date_current>date_exit){
                                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه نمی باشد')
                                            //     $("#sixth_report33").hide()
                                            // }
                                            // if(date_current<date_exit){
                                            //     alert('این فرد در بازه زمانی مجاز برای ورود به نیروگاه می باشد')
                                            //     $("#sixth_report33").show()
                                            //     $("#sixth_report34").show()
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
                                                $("#hefazat_table2").append(row)
                                            }
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




                        }
                        $(".mylist").hide();
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#fourth_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/auth-cards',
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
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#fifth_report').click(function(event) {
                event.preventDefault();
                $.ajax({
                    url: '/unauth-cards',
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
                        $(".mylist2").hide();
                        $(".register").hide();
                        $(".mylist2").fadeToggle(2000);
                    }})

            })
            $('#sixth_report2').click(function(event) {
                $('.mylist2').hide();
                $('.mylist3').hide();
                $('#codemelli_modal2').modal("show");
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
                    url: "/update-conditions",
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
            $('#cond1').click(function() {
                if ($("#cond1").is(":checked") == true) {
                    $('#cardno').fadeIn()
                } else {
                    $('#cardno').fadeOut()
                }
            });
            $("#edit_form_request").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/returnform3-entering",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $.ajax({
                            url: '/level5-entering',
                            method:'GET',
                            success: function (response) {
                                $('#myModal2').modal('toggle');
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
                                    date_shamsi = $('<td style="width: 10%">' +response.results[i]['date_shamsi'] + '</td>')

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
                                        var id_ef = $(this).closest('tr').find('td:eq(0)').text();
                                        var token = $("meta[name='csrf-token']").attr("content");
                                        //$('.toast').toast('show');
                                        $.ajax(
                                            {
                                                url: "/confirm2-entering/" + id_ef,
                                                type: 'GET',
                                                data: {
                                                    "id": id_ef,
                                                    "_token": token,
                                                },
                                                success: function () {
                                                    $('.toast').toast('show');
                                                    $("#mytoast").text("درخواست انتخابی تایید و برای سرپرست حراست ارسال گردید")
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

                        $("#reason2").val('')


                    }
                });
            });
            $("#addpersons").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addpersons",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.reapeted==1){
                            alert("اشکال در تاریخ انتخابی: بازه زمانی انتخابی مجاز نمی باشد")
                        }
                        s2=1;
                        $("#stage002").removeClass( "bg-secondary" )
                        $("#stage002").css('background-color','green')
                        $("#next_s3").show()
                        $('#s8').hide()
                        $("#s2_1").fadeIn()
                        if(response.people==1){
                            $('#s2_3_1').modal('toggle')
                        }
                        if(response.people>1){
                            toastr.success("مشخصات این فرد به فرم اضافه گردید", "", {
                                "timeOut": "2000",
                                "extendedTImeout": "0"
                            });
                        }
                        var id_ep = $('<td>' + response.id_ep + '</td>')
                        var id_et = $('<td hidden>' +$('#id_et').val() + '</td>')
                        var nationality = $('<td hidden>' + $('#nationality').val() + '</td>')
                        var age = $('<td hidden>' + $('#age').val() + '</td>')
                        var full_name = $('<td>' + $('#f_name').val() +' '+ $('#l_name').val()+'</td>')
                        var f_name = $('<td hidden>' + $('#f_name').val() +'</td>')
                        var l_name = $('<td hidden>' + $('#l_name').val() +'</td>')
                        var time_enter = $('<td hidden>' + response.t_en + '</td>')
                        var day=response.d_en.substr(6,2)
                        var month=response.d_en.substr(4,2)
                        var year=response.d_en.substr(0,4)
                        var date_shamsi_enter = $('<td hidden>' + year +'/'+month+'/'+day+ '</td>')
                        var time_exit = $('<td hidden>' + response.t_ex + '</td>')
                        var day=response.d_ex.substr(6,2)
                        var month=response.d_ex.substr(4,2)
                        var year=response.d_ex.substr(0,4)
                        var date_shamsi_exit = $('<td hidden>' + year +'/'+month+'/'+day+ '</td>')
                        var code_melli = $('<td hidden>' + $('#code_melli').val() + '</td>')
                        var mobile = $('<td hidden>' + $('#mobile').val() + '</td>')
                        var edit1 = $('<button type="button" class="btn-sm btn-primary edit1" style="font-family: Tahoma;font-size: xx-small;text-align: center;width: 100%" data-toggle="modal" data-target="#s2_2">ویرایش</button>').attr('id',response.id_ep + 8000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: xx-small;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ep+9000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr class="persons_row").remove();"></tr>')
                        if(response.reapeted==0){
                            row.append(id_ep,l_name,f_name,full_name,nationality,age,time_enter,date_shamsi_enter,time_exit,date_shamsi_exit,code_melli,mobile,id_et,t1,t2)
                        }


                        $("#persons_table").append(row)
                        $('#f_name').val('');
                        $('#l_name').val('');
                        $('#time_enter').val('');
                        $('#date_shamsi_enter').val('');
                        $('#date_shamsi_exit').val('');
                        $('#time_exit').val('');
                        $('#code_melli').val('');
                        $('#mobile').val('');
                        $('#id_et').val('0');
                        $('#nationality').val('ایرانی');
                        $('#age').val('');

                        $('#' + (Number(response.id_ep) + 8000)).click(function () {
                            $("#id_ep_edit").val($(this).closest('tr').find('td:eq(0)').text());
                            $("#f_name_edit").val($(this).closest('tr').find('td:eq(2)').text());
                            $("#l_name_edit").val($(this).closest('tr').find('td:eq(1)').text());
                            $("#nationality_edit").val($(this).closest('tr').find('td:eq(4)').text());
                            $("#age_edit").val($(this).closest('tr').find('td:eq(5)').text());
                            $("#time_enter_edit").val($(this).closest('tr').find('td:eq(6)').text());
                            $("#date_shamsi_enter_edit").val($(this).closest('tr').find('td:eq(7)').text());
                            $("#time_exit_edit").val($(this).closest('tr').find('td:eq(8)').text());
                            $("#date_shamsi_exit_edit").val($(this).closest('tr').find('td:eq(9)').text());
                            $("#code_melli_edit").val($(this).closest('tr').find('td:eq(10)').text());
                            $("#mobile_edit").val($(this).closest('tr').find('td:eq(11)').text());
                            $("#id_et_edit").val($(this).closest('tr').find('td:eq(12)').text());

                            // $('#id_ep_edit').val($(this).closest('tr').find('td:eq(0)').text());
                            // $('#f_name_edit').val($(this).closest('tr').find('td:eq(10)').text());
                            // $('#l_name_edit').val($(this).closest('tr').find('td:eq(11)').text());
                            // $('#time_enter_edit').val($(this).closest('tr').find('td:eq(3)').text());
                            // $('#date_shamsi_enter_edit').val($(this).closest('tr').find('td:eq(2)').text());
                            // $('#date_shamsi_exit_edit').val($(this).closest('tr').find('td:eq(4)').text());
                            // $('#time_exit_edit').val($(this).closest('tr').find('td:eq(5)').text());
                            // $('#code_melli_edit').val($(this).closest('tr').find('td:eq(8)').text());
                            // $('#mobile_edit').val($(this).closest('tr').find('td:eq(9)').text());
                            // $('#id_et_edit').val($(this).closest('tr').find('td:eq(12)').text());
                            // $('#nationality_edit').val($(this).closest('tr').find('td:eq(13)').text());
                            // $('#age_edit').val($(this).closest('tr').find('td:eq(14)').text());
                        })
                        $('#' + (Number(response.id_ep)+9000)).click(function () {
                            var id_ep = $('#' + (Number(response.id_ep)+9000)).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax({
                                url: "/enter-delete/" + id_ep,
                                type: 'DELETE',
                                data: {
                                    "id": id_ep,
                                    "_token": token,
                                },
                                success: function (response) {
                                    if(response.people==0){
                                        $('#next_s3').hide();
                                        $("#stage002").css("background-color","red");
                                        $('#s2_3').modal('toggle')
                                    }
                                    if(response.people>0){
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-top-right",
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "3000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        };
                                        toastr.error('این فرد از این فرم حذف گردید');
                                    }

                                }
                            });
                            $('#' + (Number(response.id_ep)+9000)).closest('tr').remove();
                        })
                    }
                });

            });
            $("#updatepersons").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatepersons",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        // row.append(id_ep,l_name,f_name,l_name2,nationality,age,time_enter,date_shamsi_enter,time_exit,date_shamsi_exit,code_melli,mobile,id_et,t2,t3)
                        if(response.repeat==0){
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(10)').text($("#code_melli_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(11)').text($("#mobile_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(2)').text($("#f_name_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(1)').text($("#l_name_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(12)').text($("#id_et_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(4)').text($("#nationality_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(5)').text($("#age_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(6)').text($("#time_enter_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(8)').text($("#time_exit_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(7)').text($("#date_shamsi_enter_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(9)').text($("#date_shamsi_exit_edit").val());
                            $('#' + (Number(response.id_ep)+8000)).closest('tr').find('td:eq(3)').text($("#f_name_edit").val()+' '+$("#l_name_edit").val());
                            toastr.options = {
                                "closeButton": true,
                                "debug": false,
                                "positionClass": "toast-top-right",
                                "onclick": null,
                                "showDuration": "300",
                                "hideDuration": "1000",
                                "timeOut": "3000",
                                "extendedTimeOut": "1000",
                                "showEasing": "swing",
                                "hideEasing": "linear",
                                "showMethod": "fadeIn",
                                "hideMethod": "fadeOut"
                            };
                            toastr.info('اطلاعات مربوط به این فرد تغییر داده شد');
                            $('#s2_2').modal('toggle')
                        }else{
                            alert("تاریخ انتخاب شده مجاز نیست")
                        }


                    }
                });

            });
            $("#updateins").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updateins",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ei)+8000)).closest('tr').find('td:eq(0)').text($("#id_ei_edit").val());
                        $('#' + (Number(response.id_ei)+8000)).closest('tr').find('td:eq(1)').text($("#description_ins_edit").val());
                        $('#' + (Number(response.id_ei)+8000)).closest('tr').find('td:eq(4)').text($("#serial_no_ins_edit").val());
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.info('اطلاعات مربوط به این قطعه الکترونیکی تغییر داده شد');
                        $('#s4_2').modal('toggle')
                    }
                });

            });
            $("#updateeq").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updateeq",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ee)+8000)).closest('tr').find('td:eq(0)').text($("#id_ee_edit").val());
                        $('#' + (Number(response.id_ee)+8000)).closest('tr').find('td:eq(1)').text($("#description_eq_edit").val());
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.info('اطلاعات مربوط به این وسیله تغییر داده شد');
                        $('#s5_2').modal('toggle')
                    }
                });

            });
            $("#with_el").on('change',function(event) {
                if($("#with_el").val()==0){
                    $("#permission2").val(0);
                    $('#s4_1').hide()
                    $("#btnic").hide()
                    $('.el_title').hide()
                    $("#s4").height('120px');
                    $("#s4_footer").height('50px');

                }
                if($("#with_el").val()==1){
                    $("#permission2").val(1);
                    $('.el_title').fadeIn()
                    $('#s4_1').show()
                    $("#btnic").show();
                    $("#s4").height('270px');
                    $("#s4_footer").height('50px');
                    $("#btnic").html("افزودن موارد جدید")
                    //$("#ins_table").find("tr:gt(0)").remove();

                }
                if($("#with_el").val()==2){
                    $("#permission2").val(2);
                    $('#s4_1').hide()
                    $("#btnic").hide()
                    $('.el_title').hide()
                    $("#s4").height('140px');
                    $("#s4_footer").height('65px');
                    $("#btnic").show()
                    $("#btnic").html("ثبت تغییرات")
                }
            });
            $("#btnic").on('click',function(){
                if($('#with_el').val()==2){
                    id_ef=$("#id_ef_del").val()
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: "/ins-delete-all/"+id_ef,
                        type: 'DELETE',
                        data: {
                            "id": id_ef,
                            "_token": token,
                        },
                        success: function (response) {
                            if(true){
                                $("#ins_table").empty();
                                $("#ins_table").hide();
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "positionClass": "toast-top-right",
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "3000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                };
                                toastr.error('کلیه قطعات الکترونیکی که در این فرم برای آنها مجوز اخذ شده بود حذف شدند.');

                            }
                        }


                    });

                }

            })
            $("#addins").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addins2",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        s4=1;
                        $("#stage004").removeClass( "bg-secondary" )
                        $("#stage004").css('background-color','green')
                        $('#s10').hide()
                        $("#next_s5").show()
                        $("#s4_1").fadeIn()
                        $("#s4_footer").height('65px');
                        if(response.ins>1){
                            toastr.success("مشخصات این قطعه الکترونیکی به فرم اضافه گردید", "", {
                                "timeOut": "2000",
                                "extendedTImeout": "0"
                            });
                        }
                        if(response.ins==1){
                            $('#s4_3_1').modal('toggle')
                        }
                        var id_ei = $('<td class="els">' + response.id_ei + '</td>')
                        var description = $('<td class="els">' + $('#description').val() +'</td>')
                        var serial_no = $('<td hidden class="els">' + $('#serial_no').val() +'</td>')
                        var edit1 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s4_2">ویرایش</button>').attr('id',response.id_ei + 8000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ei+9000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr style="text-align: right"></tr>')
                        row.append(id_ei, description,t1,t2,serial_no)
                        $("#ins_table").append(row)
                        $('#description').val('');
                        $('#serial_no').val('');

                        $('#' + (response.id_ei+8000)).on('click',function(){
                            $("#id_ei_edit").val($(this).closest('tr').find('td:eq(0)').text());
                            $("#description_ins_edit").val($(this).closest('tr').find('td:eq(1)').text());
                            $("#serial_no_ins_edit").val($(this).closest('tr').find('td:eq(4)').text());

                        })
                        $('#' + (response.id_ei+9000)).on('click',function(){
                            var id_ei =  $(this).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax({
                                url: "/ins-delete2/" + id_ei,
                                type: 'DELETE',
                                data: {
                                    "id": id_ei,
                                    "_token": token,
                                },
                                success: function (response) {
                                    if(true){
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-top-right",
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "3000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        };
                                        toastr.error('این وسیله از فرم حذف گردید');

                                    }
                                    $("#"+(Number(id_ei)+9000)).closest('tr').remove();
                                }
                            });

                        })
                    }
                });

            });
            $("#updatecars").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/updatecars",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(0)').text($("#id_ec_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(1)').text($("#car_name_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(2)').text($("#driver_name_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(3)').text($("#car_no_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(5)').text($("#no1_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(6)').text($("#no2_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(7)').text($("#no3_edit").val());
                        $('#' + (Number(response.id_ec)+8000)).closest('tr').find('td:eq(4)').text($("#area_edit").val());


                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.info('اطلاعات مربوط به این خودرو تغییر داده شد');
                        $('#s3_2').modal('toggle')
                    }
                });

            });
            $("#with_car").on('change',function(event) {
                if($("#with_car").val()==0){
                    $("#permission1").val(0);
                    // $('#s3_1').hide()
                    $('.car_title').hide()
                    $("#s3").height('105px');
                    $('#btncar').hide()
                    $("#s3_footer").height('50px');
                    $('#next_s4').hide()
                    $('#s3_1').hide()
                }
                if($("#with_car").val()==1){
                    $("#permission1").val(1);
                    $('.car_title').fadeIn();
                    $("#s3").height('250px');
                    $("#s3_footer").height('50px');
                    $('#btncar').fadeIn();
                    $('#btncar').html("افزودن مورد جدید")
                    $('#s3_1').fadeIn();
                }
                if($("#with_car").val()==2){
                    $("#permission1").val(2);
                    $('.car_title').hide()
                    $("#s3").height('125px');
                    $("#s3_footer").height('50px');
                    $('#btncar').fadeIn();
                    $('#btncar').html("ثبت تغییرات")
                    $('#s3_1').hide()
                    $("#cars_table").empty();
                    $("#cars_table").hide();
                    $(".cars_row").remove();
                }
            });
            $("#btncar2").on('click',function(event){
                $("#car_no_edit").val($("#no2_edit").val()+$("#no3_edit").val()+$("#no1_edit").val());
            });
            $("#addcars").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addcars2",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {

                        var id_ec = $('<td>' + response.id_ec + '</td>')
                        var car_name = $('<td>' + $('#car_name').val() +'</td>')
                        var area = $('<td hidden>' + $('#area').val() +'</td>')
                        var driver_name = $('<td >' + $('#driver_name').val() +'</td>')
                        var car_no = $('<td hidden>' + $('#car_no').val() +'</td>')
                        // var car_no = $('#car_no').val()
                        var part3 = $('<td hidden>' + $('#car_no').val().toString().substr(1,2) +'</td>')
                        var part2 = $('<td hidden>' + $('#car_no').val().toString().substr(0,1) +'</td>')
                        var part1 = $('<td hidden>' + $('#car_no').val().toString().substr(3,3) +'</td>')
                        var edit2 = $('<button type="button" class="btn-sm btn-primary del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s3_2">ویرایش</button>').attr('id',response.id_ec + 8000)
                        var del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ec+9000)
                        var t2 = $('<td></td>')
                        var t3 = $('<td></td>')
                        t2.append(edit2)
                        t3.append(del2)
                        var row=$('<tr></tr>')
                        row.append(id_ec,car_name,driver_name,car_no,area,part1,part2,part3,t2,t3)
                        $("#cars_table22").append(row)
                        $('#car_name').val('');
                        $('#car_no').val('');
                        $('#driver_name').val('');
                        $('#no1').val('');
                        $('#no2').val('');
                        $('#no3').val('');
                        $('#area').val('');
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "positionClass": "toast-top-right",
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "3000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        };
                        toastr.info('این خودرو به فرم درخواست اضافه گردید');
                        $('#' + (Number(response.id_ec+8000))).on('click',function(){
                            $("#id_ec_edit").val($(this).closest('tr').find('td:eq(0)').text());
                            $("#car_name_edit").val($(this).closest('tr').find('td:eq(1)').text());
                            $("#car_no_edit").val($(this).closest('tr').find('td:eq(3)').text());
                            $("#driver_name_edit").val($(this).closest('tr').find('td:eq(2)').text());
                            $("#area_edit").val($(this).closest('tr').find('td:eq(4)').text());
                            $("#no1_edit").val($(this).closest('tr').find('td:eq(5)').text());
                            $("#no2_edit").val($(this).closest('tr').find('td:eq(6)').text());
                            $("#no3_edit").val($(this).closest('tr').find('td:eq(7)').text());

                        })
                        $('#' + (Number(response.id_ec+9000))).on('click',function(){
                            var id_ec =  $(this).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $(this).closest('tr').remove();
                            $.ajax({
                                url: "/car-delete2/" + id_ec,
                                type: 'DELETE',
                                data: {
                                    "id": id_ec,
                                    "_token": token,
                                },
                                success: function (response) {
                                    toastr.options = {
                                        "closeButton": true,
                                        "debug": false,
                                        "positionClass": "toast-top-right",
                                        "onclick": null,
                                        "showDuration": "300",
                                        "hideDuration": "1000",
                                        "timeOut": "3000",
                                        "extendedTimeOut": "1000",
                                        "showEasing": "swing",
                                        "hideEasing": "linear",
                                        "showMethod": "fadeIn",
                                        "hideMethod": "fadeOut"
                                    };
                                    toastr.error('این خودرو از این فرم حذف گردید');

                                }
                            });

                        })
                    }

                });

            });
            $("#btncar").on('click',function(){
                $("#car_no").val($("#no2").val()+$("#no3").val()+$("#no1").val());
                if($('#with_car').val()==2){
                    id_ef=$("#id_ef_del").val()
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: "/car-delete-all/"+id_ef,
                        type: 'DELETE',
                        data: {
                            "id": id_ef,
                            "_token": token,
                        },
                        success: function (response) {
                            $("#cars_table").empty();
                            $("#cars_table").hide();
                            $(".cars_row").remove();
                            if(true){
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "positionClass": "toast-top-right",
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "3000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                };
                                toastr.error('کلیه خودروهایی که در این فرم برای آنها مجوز اخذ شده بود حذف شدند.');

                            }
                        }


                    });

                }

            })
            $("#addeq").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/addeq2",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        s5=1;
                        $("#stage005").removeClass( "bg-secondary" )
                        $("#stage005").css('background-color','green')
                        toastr.success("مشخصات این وسیله به فرم اضافه گردید", "", {
                            "timeOut": "2000",
                            "extendedTImeout": "0"
                        });
                        var id_ee = $('<td class="eqs">' + response.id_ee + '</td>')
                        var description = $('<td class="eqs">' + $('#description_eq').val() +'</td>')
                        var edit1 = $('<button type="button" class="btn-sm btn-success del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%" data-toggle="modal" data-target="#s5_2">ویرایش</button>').attr('id',response.id_ee + 8000)
                        var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.id_ee+9000)
                        var t1=$('<td></td>')
                        var t2=$('<td></td>')
                        t1.append(edit1)
                        t2.append(del1)
                        var row=$('<tr></tr>')
                        row.append(id_ee, description,t1,t2)
                        $("#eq1_table").append(row)
                        $('#description_eq').val('');

                        $('#' + (Number(response.id_ee) + 8000)).click(function () {
                            $('#id_ee_edit').val($(this).closest('tr').find('td:eq(0)').text());
                            $('#description_eq_edit').val($(this).closest('tr').find('td:eq(1)').text());
                        })
                        $('#' + (Number(response.id_ee)+9000)).click(function () {
                            var id_ee = $('#' + (Number(response.id_ee)+9000)).closest('tr').find('td:eq(0)').text();
                            var token = $("meta[name='csrf-token']").attr("content");
                            $.ajax({
                                url: "/eq-delete2/" + id_ee,
                                type: 'DELETE',
                                data: {
                                    "id": id_ee,
                                    "_token": token,
                                },
                                success: function (response) {
                                    if(response.eqs==0){

                                        $('#finish').hide();
                                        $("#stage005").css("background-color","red");
                                        $('#s5_3_2').modal('toggle')
                                    }
                                    if(response.eqs>0){
                                        toastr.options = {
                                            "closeButton": true,
                                            "debug": false,
                                            "positionClass": "toast-top-right",
                                            "onclick": null,
                                            "showDuration": "300",
                                            "hideDuration": "1000",
                                            "timeOut": "3000",
                                            "extendedTimeOut": "1000",
                                            "showEasing": "swing",
                                            "hideEasing": "linear",
                                            "showMethod": "fadeIn",
                                            "hideMethod": "fadeOut"
                                        };
                                        toastr.error('این وسیله از این فرم حذف گردید');

                                    }
                                }
                            });
                            $('#' + (Number(response.id_ee)+9000)).closest('tr').remove();
                        })
                    }
                });

            });
            $("#with_eq").on('change',function(event) {
                if($("#with_eq").val()==0){
                    $("#permission3").val(0);
                    $('.eq_title').hide()
                    $("#btneq").hide()
                    $("#s5").height('120px');
                    $("#s5_footer").height('50px');
                    $("#send_type_lable").hide()
                    $("#send_type").hide()
                }
                if($("#with_eq").val()==1){
                    $("#send_type").val(0)
                    $("#btneq2").hide()
                    $("#s5").height('170px');
                    $("#s5_footer").height('50px');
                    $("#send_type").attr('display','inline')
                    $("#send_type_lable").attr('display','inline')
                    $("#send_type_lable").fadeIn(500)
                    $("#send_type").fadeIn(500)
                    $('#s5_1_1').show()
                    $('#s5_1_2').show()

                }
                if($("#with_eq").val()==2){
                    $("#send_type").val(0)
                    $("#permission3").val(2);
                    $("#btneq2").fadeIn(500)
                    $('#s5_1_1').hide()
                    $('#s5_1_2').hide()
                    $('#s11').fadeIn(500)
                    //$('#finish').show()
                    $('#addeq').hide()
                    $('#equpload').hide()
                    $('#send_type').hide()
                    $('#send_type_lable').hide()
                    $("#s5").height('150px');
                    $("#s5_footer").height('50px');

                }
            });
            $("#btnupload").on('click',function(){
                if($('#with_eq').val()==2){
                    id_ef=$("#id_ef_del").val()
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax({
                        url: "/eq-delete-all/"+id_ef,
                        type: 'DELETE',
                        data: {
                            "id": id_ef,
                            "_token": token,
                        },
                        success: function (response) {
                            $("#equp_table").empty();
                            $("#eq_table").empty();
                            if(true){
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "positionClass": "toast-top-right",
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "3000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                };
                                toastr.error('کلیه وسایل کاری که در این فرم برای آنها مجوز اخذ شده بود حذف شدند.');

                            }
                        }


                    });

                }

            })
            $("#send_type").on('change',function(event) {
                $("#s11").hide()
                if($('#equp_table tr').length>1 || $('#eq_table tr').length>1){
                    $('#finish').show()
                }else{
                    $('#finish').hide()
                }
                if($("#send_type").val()==0){
                    $("#s5_1").hide()
                    $("#s5_1_2").hide()
                    $("#s5").height('180px');
                    $("#s5_footer").height('50px');
                    $("#equpload").fadeOut(500)
                    $("#addeq").fadeOut(500)
                    $("#btneq").fadeOut(500)
                }
                if($("#send_type").val()==1){
                    $("#s5_1").fadeIn()
                    $('#s5_1_1').show()
                    $('#s5_1_2').show()
                    $("#permission3").val(1);
                    $("#addeq").fadeIn(500)
                    $("#equpload").fadeOut(500)
                    $("#s5").height('290px');
                    $("#s5_footer").height('50px');
                    //$("#btneq").fadeIn(500)
                    // $("#eq_table").find("tr:gt(0)").remove();
                }
                if($("#send_type").val()==2){
                    $('#s5_1_1').show()
                    $('#s5_1_2').show()
                    $("#s5_1").hide()
                    $("#permission3").val(1);
                    $("#equpload").show()
                    $("#addeq").hide()
                    $("#s5").height('330px');
                    $("#s5_footer").height('50px');
                    $("#btneq").show()
                }
            });
            $("#create_request").on('submit',function(event) {

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/edit-title",
                    method:'POST',
                    data:new FormData(this),
                    dataType:'JSON',
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        toastr.success("این تغییرات اعمال گردید", "", {
                            "timeOut": "2000",
                            "extendedTImeout": "0"
                        });
                    }
                });
            });
            $('#equpload').on('submit',function(event){

                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/store-file",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if(response.ext && response.size){
                            s5=1;
                            $("#stage005").removeClass( "bg-secondary" )
                            $("#stage005").css('background-color','green')
                            $("#finish").show()
                            $("#s5_footer").height('50px');

                            $(".progress-bar").show()
                            var delay = 1500;
                            $(".progress-bar").each(function(i) {
                                $(this).delay(delay * i).animate({
                                    width: $(this).attr('aria-valuenow') + '%'
                                }, delay);

                                $(this).prop('Counter', 0).animate({
                                    //Counter: $(this).text()
                                }, {
                                    duration: delay,
                                    easing: 'swing',
                                    step: function(now) {
                                        $(this).text(Math.ceil(now) + '%');
                                    }
                                });
                            });
                            setTimeout(function(){$(".progress-bar").hide();}, 3000);



                            $("#s5_1").hide();
                            $("#s5_1_2").fadeIn();
                            var id_eup = $('<td style="width: 5%">' + response.id_eup + '</td>')
                            var description = $('<td style="text-align: right;padding-right: 10px;width: 65%">' + $('#description_upload').val() +'</td>')
                            var del1 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: smaller;text-align: center;width: 100%">حذف</button>').attr('id',response.id_eup+2000)
                            var t2=$('<td style="width: 25%"></td>')
                            t2.append(del1)
                            var row=$('<tr></tr>')
                            row.append(id_eup,description,t2)
                            $("#eq2_table").append(row)
                            $('#description_eq').val('');
                            $("#file").val('')
                            $("#description_upload").val('')
                            $('#' + (Number(response.id_eup)+2000)).click(function () {
                                var id_eup = $('#' + (Number(response.id_eup)+2000)).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/eup-delete/" + id_eup,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_eup,
                                        "_token": token,
                                    },
                                    success: function (response) {
                                        if(response.eup==0){

                                            $('#finish').hide();
                                            $("#stage005").css("background-color","red");
                                            $('#s5_3_2').modal('toggle')
                                        }
                                        if(response.eup>0){
                                            toastr.options = {
                                                "closeButton": true,
                                                "debug": false,
                                                "positionClass": "toast-top-right",
                                                "onclick": null,
                                                "showDuration": "300",
                                                "hideDuration": "1000",
                                                "timeOut": "3000",
                                                "extendedTimeOut": "1000",
                                                "showEasing": "swing",
                                                "hideEasing": "linear",
                                                "showMethod": "fadeIn",
                                                "hideMethod": "fadeOut"
                                            };
                                            toastr.error('این فایل الصاقی از این فرم حذف گردید');

                                        }
                                    }
                                });
                                $('#' + (Number(response.id_eup)+2000)).closest('tr').remove();
                            })
                        }else{
                            if(response.ext==0){
                                $("#s12").modal('show');
                                $("#s13").hide()

                            }
                            if(response.size==0){
                                $("#s13").modal('show');
                                $("#s12").hide()
                            }
                        }


                    },
                });

            });
            $("#date_shamsi_exit").prop('readonly', true);
            $("#date_shamsi_enter").prop('readonly', true);
            $("#date_shamsi_exit_edit").prop('readonly', true);
            $("#date_shamsi_enter_edit").prop('readonly', true);
            $("#date_shamsi_exit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_enter").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_exit_edit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
            $("#date_shamsi_enter_edit").persianDatepicker({
                format: 'YYYY/MM/DD'
            });

        });
    </script>

    <div class="modal fade mt-3" id="codemelli_modal2" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 0px;margin-left: 395px">
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
    <div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline"></p></div>
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
                        <select class="form-control" name="part_reciever" id="part_reciever" style="width: 50%;font-family: Tahoma;font-size: small;margin-top: 20px" required title="بخش دریافت کننده انتخاب شود">
                            <option value=''>انتخاب بخش دریافت کننده</option>
                            <option value='1'>بازگشت به ایمنی</option>
                            <option value='2'>بازگشت به درخواست کننده</option>
                        </select>
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
                                    <input type="text" maxlength="50" data-toggle="tooltip" data-placement="right" required title="در اینجا علت عدم تایید وارد شود" class="form-control" id="reason2"  name="reason2" style="direction:rtl;font-family:Tahoma;font-size:small;">
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
                                <button type="submit" class="btn btn-primary" id="btnupdate55" style="font-family: Tahoma;font-size: small;text-align: right">ذخیره</button>
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
    <div class="row mylist2" style="width:100%;display: none;margin-top: -450px;margin-left: 200px">
        <div class="col-12" id="title_report" style="height: 35px;margin-top: 10px;border-radius: 5px;font-family: Tahoma;font-size: small;direction: rtl;color: white;text-align: right;background-color:rgb(14,53,126)"></div>
    </div>
    <!-- content of report -->
    <div class="row mylist2" style="width:100%;height:302px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;display: none;background-color: beige;margin-left: 200px">
        <div class="col-12" style="direction: rtl;height: 300px;overflow-y: scroll;">
            <table id="report_table" align="center" style="width: 110%;font-family: Tahoma;font-size: small"></table>
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
    <div class="modal fade" id="c_modal" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 10px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم تعیین الزامات حفاظت فیزیکی</p></div>
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
                        <div class="row">
                            <div class="col-4" style="text-align: right"><input type="number" class="form-control" id="cardno" name="cardno" style="font-family: Tahoma;font-size: smaller;width:42%;text-align: center;display: inline"><p style="font-family: Tahoma;font-size: smaller;direction: rtl;display: inline;margin-left: 2px">شماره کارت</p></div>
                            <div class="col-5" style="text-align: right"><p class="chk1" >كارت مهمان/بازديد تحويل شود</p></div>
                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond1" name="cond1" value=0 ></div>

                        </div>
                        <div class="row">
                            <div class="col-9" style="text-align: right"><p class="chk1" >برگه تاييد ميزبان صادر شود</p></div>
                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond2" name="cond2" value=0 ></div>
                        </div>
                        <div class="row">
                            <div class="col-9" style="text-align: right"><p class="chk1" >فرد توسط پرسنل حفاظت فيزيكي همراهي شود</p></div>
                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond3" name="cond3" value=0 ></div>
                        </div>
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-9" style="text-align: right"><p class="chk1" >در بدو ورود خودرو با اداره ايمني و آتش نشاني هماهنگي نموده و پس از حضور ايمني وارد نيروگاه شوند</p></div>--}}
                        {{--                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond4" name="cond4" value=0 ></div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-9" style="text-align: right"><p class="chk1" >فرد/گروه جهت آموزش نكات ايمني به اداره ايمني و آتش نشاني مراجعه نمايند</p></div>--}}
                        {{--                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond5" name="cond5" value=0 ></div>--}}
                        {{--                        </div>--}}
                        <div class="row">
                            <div class="col-9" style="text-align: right"><p class="chk1" >فرم ورود وسايل الكترونيكي/تجهيزات عملياتي صادر شود</p></div>
                            <div class="col-3" style="text-align: left"><input style="display: inline;margin-left: 10px" type="checkbox" class="form-check-input chk1" id="cond6" name="cond6" value=0 ></div>
                        </div>
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
    <div class="modal fade mt-3" id="myModal3" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 1000px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">اصلاح درخواست</p></div>
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
            {{--                rgb(39,55,97)--}}
            <!-- List -->
                <div class="container"  style="margin: auto;background-color:#101820FF;width: 1000px ;height: 435px;overflow-y: scroll">
                    <ul class="tabs">

                        <li class="tab-link" data-tab="tab-1">
                            <div class="tab_div">
                                <p class="title_tab">فهرست نفرات</p>
                            </div>
                        </li>
                        <li class="tab-link" data-tab="tab-2">
                            <div class="tab_div">
                                <p class="title_tab">مجوز ورود خودرو</p>
                            </div>

                        </li>
                        <li class="tab-link" data-tab="tab-3">
                            <div class="tab_div">
                                <p class="title_tab">مجوز وسایل الکترونیکی</p>
                            </div>

                        </li>
                        <li class="tab-link" data-tab="tab-4">
                            <div class="tab_div">
                                <p class="title_tab">مجوز ورود وسایل کار</p>
                            </div>

                        </li>
                        <li class="tab-link" data-tab="tab-5">
                            <div class="tab_div">
                                <p class="title_tab" >عنوان درخواست</p>
                            </div>

                        </li>
                    </ul>


                    <div id="tab-1" class="tab-content current">
                        <div class="row">
                            <div class="col-6">
                                <div id="s2" class="container" style="text-align: left;background-color:#17a2b8;width: 90%;border-radius: 5px;height:250px;direction: rtl;color: white;margin-top:2px;padding-top: 2px;">
                                    <form method="post" encType="multipart/form-data" id="addpersons" action="{{route('addpersons.store')}}">
                                        {{csrf_field()}}
                                        <input type="text" hidden maxlength="50" class="form-control" id="id_ef1000"   name="id_ef">
                                        <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام:</p></div>
                                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام خانوادگی:</p></div>
                                        </div>

                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-6">
                                                <div class="form-group" style="height: 15px">
                                                    <input type="text" maxlength="15" class="form-control" id="f_name" data-toggle="tooltip" data-placement="right" placeholder="نام مهمان:" name="f_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام فرد دعوت شده وارد شود">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group" style="height: 15px">
                                                    <input type="text" maxlength="20" class="form-control" id="l_name" data-toggle="tooltip" data-placement="right" placeholder="نام خانوادگی مهمان:" name="l_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام خانوادگی فرد دعوت شده وارد شود">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">عنوان فرد:</p></div>
                                        </div>
                                        <div class="row" style="margin-top: 10px">
                                            <div class="col-5">
                                                <div class="form-group" style="height: 15px">
                                                    <select class="form-control" name="id_et" id="id_et" style="width: 150px;font-family: Tahoma;font-size: small;" required title="عنوان این فرد وارد شود">
                                                        <option value="">----</option>
                                                        @foreach($persons as $person)
                                                            <option value="{{$person->id_et}}">{{$person->description}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group" style="height: 15px">
                                                    <select  class="form-control" name="nationality" id="nationality" style="width: 100%;font-family: Tahoma;font-size: small;">
                                                        <option value='ایرانی'>ایرانی</option>
                                                        <option value='افغان'>افغان</option>
                                                        <option value='ایتالیایی'>ایتالیایی</option>
                                                        <option value='هلندی'>هلندی</option>
                                                        <option value='فرانسوی'>فرانسوی</option>
                                                        <option value='آلمانی'>آلمانی</option>
                                                        <option value='انگلیسی'>انگلیسی</option>
                                                        <option value='هندی'>هندی</option>
                                                        <option value='ترک'>ترک</option>
                                                        <option value='عراقی'>عراقی</option>
                                                        <option value='پاکستانی'>پاکستانی</option>
                                                        <option value='روس'>روس</option>
                                                        <option value='سوری'>سوری</option>
                                                        <option value='آمریکایی'>آمریکایی</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group" style="height: 15px">
                                                    <input hidden type="number" max=100 min=1 class="form-control" id="age"  data-toggle="tooltip" data-placement="right" placeholder="سن:" name="age" style="direction: rtl;font-family: Tahoma;font-size:small;width: 100%"  title="سن این فرد وارد شود">
                                                </div>
                                            </div>
                                        </div>
                                        <div hidden class="row" style="height: 20px;margin-top: 20px">
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ شروع فعالیت:</p></div>
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت شروع فعالیت:</p></div>
                                        </div>

                                        <div hidden class="row" style="height: 15px">
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_shamsi_enter" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 73%"  title="تاریخ شروع به کار فرد در نیروگاه وارد شود">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="time" maxlength="10" class="form-control" id="time_enter"  data-toggle="tooltip" data-placement="right" placeholder="ساعت شروع فعالیت:" name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 73%"  title="ساعت شروع به کار فرد در نیروگاه وارد شود">
                                                </div>
                                            </div>
                                        </div>
                                        <div hidden class="row" style="height: 20px;margin-top: 20px">
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ پایان فعالیت:</p></div>
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت پایان فعالیت:</p></div>
                                        </div>

                                        <div hidden class="row" style="height: 15px">
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="text" maxlength="10" class="form-control" id="date_shamsi_exit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ پایان فعالیت:" name="date_shamsi_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ پایان کار فرد در نیروگاه وارد شود">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="time" maxlength="10" class="form-control" id="time_exit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت پایان فعالیت:" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="ساعت پایان کار فرد در نیروگاه وارد شود">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="height: 20px;margin-top: 20px">
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">کد ملی:</p></div>
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">شماره تلفن:</p></div>
                                        </div>

                                        <div class="row" style="height: 15px">
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="text"  pattern="[0-9]{10}"  class="form-control" id="code_melli"  data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="کد ملی فرد وارد گردد">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="text" maxlength="11" class="form-control" id="mobile"  data-toggle="tooltip" data-placement="right" placeholder="شماره تلفن:" name="mobile" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="شماره موبایل فرد وارد گردد">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-top:30px">
                                            <div class="col" style="text-align:center">
                                                <button type="submit" class="btn btn-dark" id="btnupdate" disabled style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:60%">ثبت مورد جدید</button>
                                            </div>
                                        </div>

                                    </form>
                                    <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="s2_1" class="container" style="margin: auto;background-color:#17a2b8;width: 100%;border-radius: 5px;height:250px;direction: rtl;color: black;margin-top: 10px;padding-top: 2px;overflow-y: scroll">
                                    <table id="persons_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white">
                                            <td style="border-left: 1px white solid;width: 8%;font-family: Tahoma;font-size: smaller;height: 10px">شماره سریال</td>
                                            <td style="border-left: 1px white solid;width: 18%;font-family: Tahoma;font-size: smaller;">نام و نام خانوادگی</td>
                                            {{--                                            <td style="border-left: 1px white solid;width: 13%;font-family: Tahoma;font-size: smaller;">تاریخ شروع</td>--}}
                                            {{--                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">ساعت شروع</td>--}}
                                            {{--                                            <td style="border-left: 1px white solid;width: 13%;font-family: Tahoma;font-size: smaller;">تاریخ پایان</td>--}}
                                            {{--                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">ساعت پایان</td>--}}
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-content">
                        <div class="row">
                            <div class="col-7">
                                <div id="s3" class="container" style="margin: auto;background-color:#17a2b8;width: 80%;border-radius: 5px;height:100px;direction: rtl;color: white;margin-top: 5px;padding-top: 20px;">
                                    <form method="post" encType="multipart/form-data" id="addcars" action="{{route('addcars.store')}}">
                                        {{csrf_field()}}
                                        <input type="text" hidden maxlength="50" class="form-control" id="id_ef1001"   name="id_ef">
                                        <div  class="form-group" style="text-align: right">
                                            <label for="with_car" style="font-family: Tahoma;font-size: small;display: inline">نیاز به صدور مجوز تردد خودرو مهمان:</label>
                                            <select class="form-control" name="with_car" id="with_car" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                                <option value=0>---</option>
                                                <option value=1>بله</option>
                                                <option value=2>خیر</option>
                                            </select>
                                        </div>
                                        <div class="row" style="margin-top:15px">
                                            <div class="col">
                                                <button type="submit" class="btn btn-dark" id="btncar" disabled style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;display: none">ثبت اطلاعات</button>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid white">
                                        <div class="row car_title" style="height: 10px;margin-top: 10px;display: none">
                                            <div class="col" >
                                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام خودرو:</p>
                                            </div>
                                            <div class="col" style="text-align: right;">
                                                <p style="text-align: right;font-family: Tahoma;font-size: small;">شماره پلاک:</p>
                                            </div>
                                        </div>

                                        <div class="row car_title" style="margin-top: 12px;height: 20px;display: none" id="car_title2">
                                            <div class="col">
                                                <div class="form-group car_title">
                                                    <input type="text" maxlength="15" class="form-control" id="car_name" placeholder="نام خودرو:" name="car_name" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group" style="text-align: right">
                                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no" placeholder="شماره پلاک خودرو:" name="car_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px">
                                                    <input type="text" maxlength="3" class="form-control" id="no1" style="font-family:Tahoma;font-size:small;width: 50px;display: inline" required placeholder="532">
                                                    <input type="text" maxlength="1" class="form-control" id="no2" style="font-family:Tahoma;font-size:small;width: 35px;display: inline" required placeholder="ب">
                                                    <input type="text" maxlength="2" class="form-control" id="no3" style="font-family:Tahoma;font-size:small;width: 40px;display: inline" required placeholder="98">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row car_title" style="height: 20px;margin-top: 20px;display: none" id="car_title3">
                                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نام راننده:</p></div>
                                        </div>

                                        <div class="row car_title" style="height: 15px;display: none" id="car_title4">
                                            <div class="col">
                                                <div class="form-group" >
                                                    <input type="text" maxlength="20" class="form-control" id="driver_name"  data-toggle="tooltip" data-placement="right" placeholder="نام راننده:" name="driver_name" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="نام راننده وارد گردد">
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group" >
                                                    <select class="form-control" name="area" id="area" style="width:100%;font-family: Tahoma;font-size: small;" required>
                                                        <option value=''>محدوده تردد</option>
                                                        <option value='ساختمان اداری'>ساختمان اداری</option>
                                                        <option value='محدوده انبار'>محدوده انبار</option>
                                                        <option value='محدوده پست انتقال'>محدوده پست انتقال</option>
                                                        <option value='محدوده واحدهای گازی'>محدوده واحدهای گازی</option>
                                                        <option value='محدوده واحدهای بخار'>محدوده واحدهای بخار</option>
                                                        <option value='محدوده واحدهای گازی و بخار'>محدوده واحدهای گازی و بخار</option>
                                                        <option value='ساختمان اتاق فرمان'>ساختمان اتاق فرمان</option>
                                                        <option value='اطراف کارگاهها'>اطراف کارگاهها</option>
                                                        <option value='محدوده باغ زیتون'>محدوده باغ زیتون</option>
                                                        <option value='محدوده ایستگاه گاز'>محدوده ایستگاه گاز</option>
                                                        <option value='محدوده مخازن سوخت'>محدوده مخازن سوخت</option>
                                                        <option value='محدوده پارکینگ شمالی'>محدوده پارکینگ شمالی</option>
                                                        <option value='محدوده پارکینگ جنوبی'>محدوده پارکینگ جنوبی</option>
                                                        <option value='محدوده مهمانسرا'>محدوده مهمانسرا</option>
                                                        <option value='تردد در کل سایت'>تردد در کل سایت</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>




                                    </form>
                                </div>
                            </div>
                            <div class="col-5">
                                <div id="s3_1" class="container" style="margin: auto;background-color: #17a2b8;width: 100%;border-radius: 5px;height:250px;direction: rtl;color: white;margin-top: 5px;padding-top: 2px;overflow-y: scroll">
                                    <table id="cars_table22" align="center" style="width: 100%;font-family: Tahoma;font-size: small;">
                                        <tr class="bg-primary" style="color: white">
                                            <th style="border-left: 1px white solid;width: 17%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</th>
                                            <th style="border-left: 1px white solid;width: 20%;font-family: Tahoma;font-size: smaller;">نام خودرو</th>
                                            <th style="border-left: 1px white solid;width: 25%;font-family: Tahoma;font-size: smaller;">نام راننده</th>
                                            <th style="border-left: 1px white solid;width: 15%;font-family: Tahoma;font-size: smaller;">#</th>
                                            <th style="border-left: 1px white solid;width: 15%;font-family: Tahoma;font-size: smaller;">#</th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-content">
                        <div class="row">
                            <div class="col-6">
                                <div id="s4" class="container" style="margin: auto;background-color:#17a2b8;width: 80%;border-radius: 5px;height:125px;direction: rtl;color: white;margin-top: 5px;padding-top: 20px;">
                                    <form method="post" encType="multipart/form-data" id="addins" action="{{route('addins.store')}}">
                                        {{csrf_field()}}
                                        <input type="text" hidden maxlength="50" class="form-control" id="id_ef1002"   name="id_ef">
                                        <div  class="form-group" style="text-align: right">
                                            <label for="with_el" style="font-family: Tahoma;font-size: small;">نیاز به صدور مجوز ورود لوازم الكترونيكي مهمان:</label>
                                            <select class="form-control isclicked1" name="with_el" id="with_el" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                                <option value=0>----</option>
                                                <option value=1>بله</option>
                                                <option value=2>خیر</option>
                                            </select>
                                        </div>
                                        <div class="row" style="margin-top: 15px">
                                            <div class="col">
                                                <button type="submit" class="btn btn-dark" id="btnic" disabled style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;display: none">ثبت اطلاعات</button>
                                            </div>
                                        </div>
                                        <hr style="border-top: 1px solid white">
                                        <div class="row el_title" style="height: 10px;margin-top: 10px;display: none">
                                            <div class="col">
                                                <p style="text-align: right;font-family: Tahoma;font-size: small">نام وسیله الکترونیکی:</p>
                                            </div>
                                        </div>

                                        <div class="row el_title" style="margin-top: 12px;height: 20px;display: none">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" maxlength="100" class="form-control" id="description" placeholder="نام وسیله الکترونیکی:" name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 90%" required title="نام وسیله الکترونیکی وارد گردد">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row el_title" style="margin-top: 15px;height: 20px;display: none">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" maxlength="50" class="form-control" id="serial_no" placeholder="شماره سریال:" name="serial_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 40%"  title="شماره سریال در صورت وجود وارد شود">
                                                </div>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="s4_1" class="container" style="margin: auto;background-color: #17a2b8;width: 100%;border-radius: 5px;height:210px;direction: rtl;color: white;margin-top: 5px;padding-top: 2px;overflow-y: scroll">
                                    <table id="ins_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white">
                                            <td style="border-left: 1px white solid;width: 16%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</td>
                                            <td style="border-left: 1px white solid;width: 60%;font-family: Tahoma;font-size: smaller;">نام وسیله الکترونیکی</td>
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-content">
                        <div class="row">
                            <div class="col-6">
                                <div id="s5" class="container" style="margin: auto;background-color:#17a2b8;width: 75%;border-radius: 5px;height:120px;direction: rtl;color: white;margin-top: 5px;padding-top: 20px;">
                                    <div  class="form-group" style="text-align: right">
                                        <label for="with_eq" style="font-family: Tahoma;font-size: small;">نیاز به صدور مجوز برای وسایل کارمهمان:</label>
                                        <select class="form-control isclicked1" name="with_eq" id="with_eq" style="width: 110px;font-family: Tahoma;font-size: small;display: inline">
                                            <option value=0>----</option>
                                            <option value=1>بله</option>
                                            <option value=2>خیر</option>
                                        </select>
                                    </div>

                                    <div  class="form-group" style="text-align: right">
                                        <label for="send_type" id="send_type_lable" style="font-family: Tahoma;font-size: small;display: none">انتخاب روش مشخص کردن وسایل کار:</label>
                                        <select  class="form-control isclicked1" name="send_type" id="send_type" style="width: 100%;font-family: Tahoma;font-size: small;display: none">
                                            <option value=0>----</option>
                                            <option value=1>ورود اطلاعات بصورت دستی </option>
                                            <option value=2>ارسال فایل حاوی اطلاعات مربوط به این وسایل</option>
                                        </select>
                                    </div>
                                    <hr style="border-top: 1px solid white">
                                    <div class="row" style="margin-top: 5px">
                                        <div class="col">
                                            <button type="submit" class="btn btn-dark" id="btneq2" disabled style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;display: none">ثبت تغییرات</button>
                                        </div>
                                    </div>

                                    <form method="post" encType="multipart/form-data" id="addeq" action="{{route('addeq.store')}}" style="display: none">

                                        {{csrf_field()}}
                                        <input type="text" hidden maxlength="50" class="form-control" id="id_ef1003"   name="id_ef">
                                        <div class="row" style="margin-top: 5px">
                                            <div class="col">
                                                <button type="submit" class="btn btn-dark" id="btneq" style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;">ثبت تغییرات</button>
                                            </div>
                                        </div>
                                        <div class="row eq_title" style="height: 10px;margin-top: 10px">
                                            <div class="col">
                                                <p style="text-align: right;font-family: Tahoma;font-size: small">نام وسیله :</p>
                                            </div>
                                        </div>

                                        <div class="row eq_title" style="margin-top: 12px;height: 20px">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="text" maxlength="100" class="form-control" id="description_eq" placeholder="نام وسیله:" name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 90%" required title="نام وسیله وارد گردد">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <form method="post" encType="multipart/form-data" id="equpload" action="{{route('equpload.store')}}" style="display: none">
                                        {{csrf_field()}}
                                        <input type="text" hidden maxlength="50" class="form-control" id="id_ef1004"   name="id_ef">
                                        <div class="row" style="margin-top: 0px">
                                            <div class="col">
                                                <button type="submit" class="btn btn-dark" id="btneq3" style="font-family: Tahoma;font-size: small;text-align: center;width: 80%;">ثبت تغییرات</button>
                                            </div>
                                        </div>
                                        <div class="row upload" style="margin-top: 12px;height: 20px">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input hidden type="text" maxlength="100" class="form-control" id="description_upload" placeholder="انتخاب نام فایل جهت ارسال:" name="description_upload" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 85%" required title="نام انتخابی برای فایل" value="لیست وسایل">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row upload" style="margin-top: 22px;height: 20px">
                                            <div class="col">
                                                <div class="form-group">
                                                    <input type="file" name="file" placeholder="انتخاب فایل :" id="file">
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="container">
                                            <div class="progress border">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"  style="direction: rtl"></div>
                                            </div>
                                        </div>
                                        {{--            <div class="toast" id="uploadsuccess">--}}
                                        {{--                <div class="toast-body bg-success">--}}
                                        {{--                    <p style="text-align: right;font-family: Tahoma;font-size: small;color: white">فایل انتخاب شده با موفقیت ارسال گردید</p>--}}
                                        {{--                </div>--}}
                                        {{--            </div>--}}

                                    </form>
                                </div>
                            </div>
                            <div class="col-6">
                                <div id="s5_1_1" class="container" style="margin: auto;background-color:#17a2b8;width: 100%;border-radius: 5px;height:150px;direction: rtl;color: white;margin-top: 5px;padding-top: 2px;overflow-y: scroll">
                                    <table id="eq1_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;height: 20px">
                                            <td style="border-left: 1px white solid;width: 16%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</td>
                                            <td style="border-left: 1px white solid;width: 60%;font-family: Tahoma;font-size: smaller;">نام وسیله </td>
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="s5_1_2" class="container" style="margin: auto;background-color:#A0E5D9;width: 100%;border-radius: 5px;height:150px;direction: rtl;color: white;margin-top: 5px;padding-top: 2px;overflow-y: scroll">
                                    <table id="eq2_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;height: 20px">
                                            <td style="border-left: 1px white solid;width: 16%;font-family: Tahoma;font-size: smaller;height: 30px">شماره سریال</td>
                                            <td style="border-left: 1px white solid;width: 60%;font-family: Tahoma;font-size: smaller;">نام فایل </td>
                                            <td style="border-left: 1px white solid;width: 12%;font-family: Tahoma;font-size: smaller;">#</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-content ">
                        <div id="s1" class="container" style="margin: auto;width: 40%;border-radius: 5px;height:350px;direction: rtl;margin-top: 5px;padding-top: 20px;background-color: #17a2b8;color: white">
                            <form method="post" encType="multipart/form-data" id="create_request" action="{{route('create_request.update')}}">
                                {{csrf_field()}}

{{--                                <div  class="row" style="height: 20px;margin-top: 10px">--}}
{{--                                    <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ شروع فعالیت:</p></div>--}}
{{--                                    <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت شروع فعالیت:</p></div>--}}
{{--                                </div>--}}

{{--                                <div  class="row" style="height: 15px">--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="form-group" >--}}
{{--                                            <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_shamsi_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ شروع به کار فرد در نیروگاه وارد شود">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="form-group" >--}}
{{--                                            <input type="time" maxlength="10" class="form-control" id="time_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت شروع فعالیت:" name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 80%"  title="ساعت شروع به کار فرد در نیروگاه وارد شود">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div  class="row" style="height: 20px;margin-top: 20px">--}}
{{--                                    <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ پایان فعالیت:</p></div>--}}
{{--                                    <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت پایان فعالیت:</p></div>--}}
{{--                                </div>--}}

{{--                                <div  class="row" style="height: 15px">--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="form-group" >--}}
{{--                                            <input type="text" maxlength="10" class="form-control" id="date_shamsi_exit_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ پایان فعالیت:" name="date_shamsi_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ پایان کار فرد در نیروگاه وارد شود">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="form-group" >--}}
{{--                                            <input type="time" maxlength="10" class="form-control" id="time_exit_edit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت پایان فعالیت:" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 80%"  title="ساعت پایان کار فرد در نیروگاه وارد شود">--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="row" style="height: 10px;margin-top: 30px;width: 100%">
                                    <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">عنوان فعالیت:</p></div>
                                </div>

                                <div class="row" style="margin-top: 10px">
                                    <div class="col-12">
                                        <div class="form-group" style="height: 15px">
                                            <input type="text" maxlength="200" class="form-control" id="title_edit" data-toggle="tooltip" data-placement="right" placeholder="عنوان فعالیت:" name="title" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا عنوان فعالیتی که قرار است انجام شود وارد کنید">
                                        </div>
                                    </div>
                                </div>
                                <div class="row" style="height: 20px;margin-top: 20px">
                                    <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نام شرکت یا مرکز:</p></div>
                                </div>

                                <div class="row" style="height: 15px">
                                    <div class="col">
                                        <div class="form-group" >
                                            <input type="text" maxlength="30" class="form-control" id="company_edit"  data-toggle="tooltip" data-placement="right" placeholder="نام شرکت یا مرکز:" name="company" style="direction: rtl;font-family: Tahoma;font-size: small;width: 80%" required title="نام شرکت یا مرکزی که این فرد یا افراد از آنجا به نیروگاه معرفی شده اند وارد گردد">
                                        </div>
                                    </div>
                                </div>



                                <div class="row" style="margin-top: 45px">
                                    <div class="col">
                                        <button type="submit" class="btn btn-dark" id="firststage" style="font-family: Tahoma;font-size: small;text-align: center;width: 70%">ثبت تغییرات</button>
                                    </div>
                                </div>
                                <div id="alert1" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
                                <input hidden type="text"  id="id_ef_del"  name="id_ef">
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:1000px"></div>

            </div>
        </div>
    </div>

    <div class="modal fade mt-3" id="s2_2" style="direction: rtl;margin-top: 20px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top:50px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray">
                    <form method="post" encType="multipart/form-data" id="updatepersons" action="{{route('updatepersons.update')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ep_edit" name="id_ep">
                        <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام:</p></div>
                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام خانوادگی:</p></div>
                        </div>

                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="20" class="form-control" id="f_name_edit" data-toggle="tooltip" data-placement="right" placeholder="نام مهمان:" name="f_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام فرد دعوت شده وارد شود">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <input type="text" maxlength="25" class="form-control" id="l_name_edit" data-toggle="tooltip" data-placement="right" placeholder="نام خانوادگی مهمان:" name="l_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام خانوادگی فرد دعوت شده وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                            <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">عنوان فرد:</p></div>

                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-6">
                                <div class="form-group" style="height: 15px">
                                    <select class="form-control" name="id_et" id="id_et_edit" required style="width: 150px;font-family: Tahoma;font-size: small;">
                                        <option value="">----</option>
                                        @foreach($persons as $person)
                                            <option value="{{$person->id_et}}">{{$person->description}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group" style="height: 15px">
                                    <select  class="form-control" name="nationality" id="nationality_edit" style="width: 100%;font-family: Tahoma;font-size: x-small;">
                                        <option value='ایرانی'>ایرانی</option>
                                        <option value='افغان'>افغان</option>
                                        <option value='ایتالیایی'>ایتالیایی</option>
                                        <option value='هلندی'>هلندی</option>
                                        <option value='فرانسوی'>فرانسوی</option>
                                        <option value='آلمانی'>آلمانی</option>
                                        <option value='انگلیسی'>انگلیسی</option>
                                        <option value='هندی'>هندی</option>
                                        <option value='ترک'>ترک</option>
                                        <option value='عراقی'>عراقی</option>
                                        <option value='پاکستانی'>پاکستانی</option>
                                        <option value='روس'>روس</option>
                                        <option value='سوری'>سوری</option>
                                        <option value='آمریکایی'>آمریکایی</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group" style="height: 15px">
                                    <input hidden type="number" max=100 min=1 class="form-control" id="age_edit"  data-toggle="tooltip" data-placement="right" placeholder="سن:" name="age" style="direction: rtl;font-family: Tahoma;font-size: x-small;width: 100%"  title="سن این فرد وارد شود">
                                </div>
                            </div>
                        </div>
                        <div  class="row" style="height: 20px;margin-top: 20px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ شروع فعالیت:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت شروع فعالیت:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_shamsi_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ شروع به کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <input type="time" maxlength="10" class="form-control" id="time_enter_edit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت شروع فعالیت:" name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="ساعت شروع به کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                        </div>
                        <div  class="row" style="height: 20px;margin-top: 20px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ پایان فعالیت:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت پایان فعالیت:</p></div>
                        </div>

                        <div  class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="10" class="form-control" id="date_shamsi_exit_edit"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ پایان فعالیت:" name="date_shamsi_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="تاریخ پایان کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <input type="time" maxlength="10" class="form-control" id="time_exit_edit"  data-toggle="tooltip" data-placement="right" placeholder="ساعت پایان فعالیت:" name="time_exit" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="ساعت پایان کار فرد در نیروگاه وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 20px;margin-top: 20px">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">کد ملی:</p></div>
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">شماره تلفن:</p></div>
                        </div>

                        <div class="row" style="height: 15px">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text"  pattern="[0-9]{10}" class="form-control" id="code_melli_edit"  data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%" required title="کد ملی فرد وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="11" class="form-control" id="mobile_edit"  data-toggle="tooltip" data-placement="right" placeholder="شماره تلفن:" name="mobile" style="direction: rtl;font-family: Tahoma;font-size: small;width: 70%"  title="شماره موبایل فرد وارد گردد">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin-top: 35px">
                            <div class="col" style="text-align:center">
                                <button type="submit" class="btn btn-primary" id="updatepeople2" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:50%;margin-top: 5px">ثبت تغییرات</button>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px"></div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="s3_2" style="direction: rtl;margin-top:-200px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color: #005299" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="updatecars" action="{{route('updatecars.edit')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ec_edit"  name="id_ec">
                        <div class="row car_title" style="height: 10px;margin-top: 10px">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام خودرو:</p>
                            </div>
                            <div class="col" style="text-align: right;">
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">شماره پلاک:</p>
                            </div>
                        </div>

                        <div class="row car_title" style="margin-top: 12px;height: 20px;" id="car_title2">
                            <div class="col">
                                <div class="form-group car_title">
                                    <input type="text" maxlength="15" class="form-control" id="car_name_edit" placeholder="نام خودرو:" name="car_name" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px" required title="نام خودرو وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" style="text-align: right">
                                    <input hidden type="text" maxlength="50" class="form-control" id="car_no_edit" placeholder="شماره پلاک خودرو:" name="car_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 200px">
                                    <input type="text" maxlength="3" class="form-control" id="no1_edit" style="font-family:Tahoma;font-size:small;width: 60px;display: inline" required placeholder="532">
                                    <input type="text" maxlength="1" class="form-control" id="no2_edit" style="font-family:Tahoma;font-size:small;width: 35px;display: inline" required placeholder="ب">
                                    <input type="text" maxlength="2" class="form-control" id="no3_edit" style="font-family:Tahoma;font-size:small;width: 40px;display: inline" required placeholder="98">
                                </div>
                            </div>
                        </div>
                        <div class="row car_title" style="height: 20px;margin-top: 20px;" id="car_title3">
                            <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">نام راننده:</p></div>
                        </div>
                        <div class="row car_title" style="height: 15px;" id="car_title4">
                            <div class="col">
                                <div class="form-group" >
                                    <input type="text" maxlength="15" class="form-control" id="driver_name_edit"  data-toggle="tooltip" data-placement="right" placeholder="نام راننده:" name="driver_name" style="direction: rtl;font-family: Tahoma;font-size: small;width: 200px" required title="نام راننده وارد گردد">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group" >
                                    <select class="form-control" name="area" id="area_edit" style="width:100%;font-family: Tahoma;font-size: small;" required>
                                        <option value=''>محدوده تردد</option>
                                        <option value='ساختمان اداری'>ساختمان اداری</option>
                                        <option value='محدوده انبار'>محدوده انبار</option>
                                        <option value='محدوده پست انتقال'>محدوده پست انتقال</option>
                                        <option value='محدوده واحدهای گازی'>محدوده واحدهای گازی</option>
                                        <option value='محدوده واحدهای بخار'>محدوده واحدهای بخار</option>
                                        <option value='محدوده واحدهای گازی و بخار'>محدوده واحدهای گازی و بخار</option>
                                        <option value='ساختمان اتاق فرمان'>ساختمان اتاق فرمان</option>
                                        <option value='اطراف کارگاهها'>اطراف کارگاهها</option>
                                        <option value='محدوده باغ زیتون'>محدوده باغ زیتون</option>
                                        <option value='محدوده ایستگاه گاز'>محدوده ایستگاه گاز</option>
                                        <option value='محدوده مخازن سوخت'>محدوده مخازن سوخت</option>
                                        <option value='محدوده پارکینگ شمالی'>محدوده پارکینگ شمالی</option>
                                        <option value='محدوده پارکینگ جنوبی'>محدوده پارکینگ جنوبی</option>
                                        <option value='محدوده مهمانسرا'>محدوده مهمانسرا</option>
                                        <option value='تردد در کل سایت'>تردد در کل سایت</option>
                                    </select>
                                </div>
                            </div>
                        </div>



                        <div class="row" style="margin-top: 45px">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="btncar2" style="font-family: Tahoma;font-size: small;text-align: right;margin-bottom: 10px">ثبت اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="height: 20px;background-color: #b3d7ff"></div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="s4_2" style="direction: rtl;margin-top:-200px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color: #005299" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="updateins" action="{{route('updateins.edit')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ei_edit"  name="id_ei">
                        <div class="row car_title" style="height: 10px;margin-top: 10px;">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام قطعه الکترونیکی:</p>
                            </div>
                        </div>
                        <div class="row car_title" style="margin-top: 12px;height: 20px;" id="car_title2">
                            <div class="col">
                                <div class="form-group car_title">
                                    <input type="text" maxlength="100" class="form-control" id="description_ins_edit"  name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 80%" required title="نام قطعه وارد گردد">
                                </div>
                            </div>
                        </div>
                        <div class="row car_title" style="height: 10px;margin-top: 15px;">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">شماره سریال:</p>
                            </div>
                        </div>
                        <div class="row car_title" style="margin-top: 12px;height: 20px;" id="car_title2">
                            <div class="col">
                                <div class="form-group car_title">
                                    <input type="text" maxlength="50" class="form-control" id="serial_no_ins_edit"  name="serial_no" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 40%"  title="شماره سریال وارد شود">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 45px;margin-bottom: 10px">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="updateins" style="font-family: Tahoma;font-size: small;text-align: right;">ثبت اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="height: 20px;background-color: #b3d7ff"></div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="s5_2" style="direction: rtl;margin-top:-200px">
        <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color: #005299" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات</p></div>
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
                <div class="container" style="margin: auto;background-color:lightgray ">
                    <form method="post" encType="multipart/form-data" id="updateeq" action="{{route('updateins.edit')}}">
                        {{csrf_field()}}
                        <input type="text" hidden id="id_ee_edit"  name="id_ee">
                        <div class="row car_title" style="height: 10px;margin-top: 10px;">
                            <div class="col" >
                                <p style="text-align: right;font-family: Tahoma;font-size: small;">نام وسیله:</p>
                            </div>
                        </div>

                        <div class="row car_title" style="margin-top: 12px;height: 20px;" id="car_title2">
                            <div class="col">
                                <div class="form-group car_title">
                                    <input type="text" maxlength="50" class="form-control" id="description_eq_edit"  name="description" data-toggle="tooltip" data-placement="right" style="direction:rtl;font-family:Tahoma;font-size:small;width: 80%" required title="نام وسیله وارد گردد">
                                </div>
                            </div>
                        </div>




                        <div class="row" style="margin-top: 45px">
                            <div class="col">
                                <button type="submit" class="btn btn-primary" id="updateins" style="font-family: Tahoma;font-size: small;text-align: right;margin-bottom: 10px">ثبت اطلاعات</button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer" style="height: 20px;background-color: #b3d7ff"></div>

            </div>
        </div>
    </div>
    <div class="modal fade mt-3" id="s3_3" style="direction: rtl;top: 100px;border-radius: 10px">
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
                <div class="container" style="margin: auto;background-color:lightgray ;text-align:right;height: 150px;">
                    <p style="font-family: Tahoma;font-size: small;color: black;margin-top: 30px;text-indent: 5px"> به علت حذف کلیه موارد امکان به جریان افتادن این درخواست وجود ندارد.لطفا یا درخواست مجوز ورود خودرو را خیر انتخاب کنید و یا در صورت انتخاب بله حداقل مشخصات یک خودرو وارد شود.</p>
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
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">سابقه مجوزهای ثبت شده برای این فرد</p></div>
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
                            <input hidden type="text" id="code_melli_s2">
                            <table id="person_table66" align="center" style="width: 90%;font-family: Tahoma;font-size: small;margin-top: 5px;">
                                <tr style="color: black">
                                    <td class="person" style="width: 5%">شماره درخواست</td>
                                    <td class="person" style="width: 5%">شماره فرد</td>
                                    <td class="person" style="width: 10%">تاریخ ورود</td>
                                    <td class="person" style="width: 10%">تاریخ خروج</td>
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
    <div class="modal fade mt-3" id="personinfo6" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اعمال تغییرات در اطلاعات ورود و خروج افراد</p></div>
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
                        <div id="sixth_report35" style="margin-left: 15px">
                            <img  src="https://stnt.mapnaom-kz.com/public/edit2.png"  class="reza2" data-toggle="tooltip" data-placement="left" title="اصلاح اطلاعات ورود و خروج این فرد">
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>

@endsection
