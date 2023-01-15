{{--حراست نیروگاه--}}
@extends('layouts.entering.app_fourth_reciever_entering')
@section('content')
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
            $('#first_report').click(function(event) {
                $('.mylist2').hide();
                $('#codemelli_modal').modal("show");
            })
            $('#sixth_report').click(function(event) {
                $('.mylist2').hide();
                $('#dailyenter').modal("show");
            })
            $('#second_report').click(function(event) {

                event.preventDefault();
                $.ajax({
                    url: '/auth-peaple',
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
            $('#codesearach').click(function(event) {
                $('#personinfo2').modal("show");
            })
            $('#codesearach').click(function (event) {
                var code_melli = $('#code_melli_s').val();
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

                            $("#person_table44").append(row)

                            $("#title44").html(response.job)
                            $("#company44").html(response.company)
                            $("#cardno44").html(response.cardno)
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
                            if(toEnglishNumber(response.date1)<=toEnglishNumber(response.date)
                               &&
                               toEnglishNumber(response.date2)>=toEnglishNumber(response.date)){
                                $("#img_ok").show()
                                $("#img_no").hide()
                            }else{
                                $("#img_no").show()
                                $("#img_ok").hide()
                            }

                        }
                    });
            })
            $("#addindividuals").on('submit',function(event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                    $.ajax({
                        url: "/addindividuals",
                        method: 'POST',
                        data: new FormData(this),
                        dataType: 'JSON',
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $("#addindividuals")[0].reset();
                            $('.toast').show()
                            $('.toast').toast('show');
                            $("#individuals").html("اطلاعات این فرد ثبت گردید")
                        }
                    });
            });
            $("#date_shamsi_enter").persianDatepicker({
                format: 'YYYY/MM/DD'
            });
        });
    </script>

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
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 395px">
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
    <div class="modal fade mt-3" id="personinfo2" style="direction: rtl;">
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
                            <table id="person_table44" align="center" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
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
                                    <p id="title44" style="font-family: Tahoma;font-size: smaller;color: blue"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col" style="height:25px">
                            <div class="row">
                                <div class="col-4" style="height:25px">
                                    <p style="font-family: Tahoma;font-size: smaller;color: black">نام شرکت یا مرکز:</p>
                                </div>
                                <div class="col-8" style="height:25px;text-align: right">
                                    <p id="company44" style="font-family: Tahoma;font-size: smaller;color: blue"></p>
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
                            <p id="cardno44" style="font-family: Tahoma;font-size: smaller;color: black;display: inline"></p>
                        </div>
                    </div>
                    <div id="first44" class="row" style="text-align: right">
                        <div id="cars_div44" class="col" style="height:30px;text-align: right">
                            <table id="hefazat_table44" style="width: 100%;font-family: Tahoma;font-size: small;margin-top: 5px;">
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
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

            </div>
        </div>
    </div>
    <div class="modal fade mt-2" id="dailyenter" style="direction: rtl;">
        <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 400px">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 550px " >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">ورود اطلاعات ورود و خروج</p></div>
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
                <div class="container"  style="margin: auto;background-color: #d7d7d7;width: 550px ;height: 280px;">

                    <div class="row" style="margin-top: 10px">

                        <div id="person_div88" class="col" style="height:50px">

                            <div id="s2" class="container" style="text-align: left;background-color:#17a2b8;width: 95%;border-radius: 5px;height:250px;direction: rtl;color: white;margin-top:2px;padding-top: 2px;">
                                <form method="post" encType="multipart/form-data" id="addindividuals" action="{{route('addindividuals.store')}}">
                                    {{csrf_field()}}
                                    <div class="row" style="height: 10px;margin-top: 10px;width: 100%">
                                        <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام:</p></div>
                                        <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام خانوادگی:</p></div>
                                    </div>

                                    <div class="row" style="margin-top: 10px">
                                        <div class="col-6">
                                            <div class="form-group" style="height: 15px">
                                                <input type="text" maxlength="50" class="form-control" id="f_name" data-toggle="tooltip" data-placement="right" placeholder="نام مهمان:" name="f_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام فرد دعوت شده وارد شود">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" style="height: 15px">
                                                <input type="text" maxlength="50" class="form-control" id="l_name" data-toggle="tooltip" data-placement="right" placeholder="نام خانوادگی مهمان:" name="l_name" style="direction:rtl;font-family:Tahoma;font-size:small" required title="در اینجا نام خانوادگی فرد دعوت شده وارد شود">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="height: 20px;margin-top: 20px">
                                        <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">تاریخ ورود یا خروج:</p></div>
                                        <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">ساعت ورود یا خروج:</p></div>
                                    </div>

                                    <div class="row" style="height: 15px">
                                        <div class="col">
                                            <div class="form-group" >
                                                <input type="text" maxlength="10" class="form-control" id="date_shamsi_enter"  data-toggle="tooltip" data-placement="right" placeholder="تاریخ شروع فعالیت:" name="date_enter" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 73%" required title="تاریخ ورود یا خروج">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group" >
                                                <input type="time" maxlength="10" class="form-control" id="time_enter"  data-toggle="tooltip" data-placement="right"  name="time_enter" style="direction: rtl;font-family: Tahoma;font-size: smaller;width: 73%" required title="ساعت ورود یا خروج">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="height: 20px;margin-top: 20px">
                                        <div class="col"><p style="text-align: right;font-family: Tahoma;font-size: small">کد ملی:</p></div>
                                    </div>

                                    <div class="row" style="height: 15px">
                                        <div class="col">
                                            <div class="form-group" >
                                                <input type="text" maxlength="10" class="form-control" id="code_melli"  data-toggle="tooltip" data-placement="right" placeholder="کد ملی:" name="code_melli" style="direction: rtl;font-family: Tahoma;font-size: small;width: 30%" required title="کد ملی فرد وارد گردد">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top:30px">
                                        <div class="col" style="text-align:center">
                                            <button type="submit" class="btn btn-primary" id="btnupdate" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:50%">ثبت اطلاعات</button>
                                        </div>
                                        <div class="col" style="text-align:center">
                                            <button type="button" class="btn btn-danger" id="history_btn" style="text-align:left;font-family: Tahoma;font-size: small;text-align: center;width:50%">سابقه فرد</button>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px;width:550px">
                    <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                        <div class="toast-body"><p id="individuals" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
