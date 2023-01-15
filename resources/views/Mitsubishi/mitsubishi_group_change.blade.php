@extends('layouts.mitsubishi_layouts.app_group_change')
@section('content')
    <script>
        $(document).ready(function() {
            bootstrap.Toast.Default.delay = 2000
            var group1 =0
            var group2 =0
            var ghataat1 =[]
            var ghataat2 =[]
            var ghataats=[]
            $("#btn23").on('click',function (event) {
                $('#myModal5').modal('show');
            })
            $("#btn12").on('click',function (event) {
                $(".del12").hide("slow");
                ghataat2=[]
                $('#btn12').prop('disabled', true);
                $('#btn21').prop('disabled', true);
                $('.ghataat1').prop('checked', false);
                $('.ghataat2').prop('checked', false);
                ghataats=ghataat1
                ghataat1=[]
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '/m-gh-gr2/' + group2 +'/'+ ghataats,
                    method: 'GET',
                    success: function (response) {
                        toastr.success('قطعات انتخاب شده به گروه مورد نظر منتقل گردید');
                        var ID_E = ''
                        var SERIYAL_NUMBER = ''
                        var ID_G = ''
                        var chk = ''
                        var t1 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td style="text-align: center">#</td><td style="text-align: center">شماره سریال</td></tr>')
                        $("#table4").empty();
                        $("#table4").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            ID_E = $('<td hidden style="width:5%;text-align: center">' + response.results[i]['ID_E'] + '</td>')
                            ID_G = $('<td hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                            chk = $('<input type="checkbox" class="ghataat2">').bind('change', function () {
                                if ($(this).is(':checked')){
                                    $('.ghataat1').prop('checked', false);
                                    $(this).closest('tr').addClass("del21");
                                    ghataat2.push($(this).closest('tr').find('td:eq(1)').text());
                                    ghataat1 =[]
                                    if(ghataat2.length>0){
                                        $('#btn21').prop('disabled', false);
                                        $('#btn12').prop('disabled', true);
                                    }
                                }else{
                                    var index = ghataat2.indexOf($(this).closest('tr').find('td:eq(1)').text());
                                    if (index !== -1) {
                                        ghataat2.splice(index, 1);
                                        $(this).closest('tr').removeClass("del21");
                                    }
                                    if(ghataat2.length==0){
                                        $('#btn21').prop('disabled', true);
                                        $('#btn12').prop('disabled', true);
                                    }
                                }
                            });
                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                            t1 = $('<td style="width: 4%"></td>')
                            t1.append(chk)
                            if(response.results[i]['FLAG']==1){
                                row = $('<tr style="color:white;background-color: IndianRed;font-weight: bold;" class="table2"></tr>')
                            }else{
                                row = $('<tr style="color:black" class="table2"></tr>')
                            }                   
                            row.append(t1,ID_E,ID_G,SERIYAL_NUMBER)
                            $("#table4").append(row)
                        }
                    }
                })
            })
            $("#btn21").on('click',function (event) {
                $(".del21").hide("slow");
                ghataat1=[]
                $('#btn12').prop('disabled', true);
                $('#btn21').prop('disabled', true);
                $('.ghataat1').prop('checked', false);
                $('.ghataat2').prop('checked', false);
                ghataats=ghataat2
                ghataat2=[]
                toastr.success('قطعات انتخاب شده به گروه مورد نظر منتقل گردید');
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '/m-gh-gr3/' + group1 +'/'+ ghataats,
                    method: 'GET',
                    success: function (response) {
                        var ID_E = ''
                        var SERIYAL_NUMBER = ''
                        var ID_G = ''
                        var chk = ''
                        var t1 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color:white;text-align: center;font-size: x-small;font-family: Tahoma"><td style="text-align: center">#</td><td style="text-align: center">شماره سریال</td></tr>')
                        $("#table2").empty();
                        $("#table2").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            ID_E = $('<td hidden style="width:5%;text-align: center">' + response.results[i]['ID_E'] + '</td>')
                            ID_G = $('<td hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                            chk = $('<input type="checkbox" class="ghataat1">').bind('change', function () {
                                if ($(this).is(':checked')){
                                    $('.ghataat2').prop('checked', false);
                                    $(this).closest('tr').addClass("del12");
                                    ghataat1.push($(this).closest('tr').find('td:eq(1)').text());
                                    ghataat2 =[]
                                    if(ghataat1.length>0){
                                        $('#btn12').prop('disabled', false);
                                        $('#btn21').prop('disabled', true);
                                    }
                                }else{
                                    var index = ghataat1.indexOf($(this).closest('tr').find('td:eq(1)').text());
                                    if (index !== -1) {
                                        ghataat1.splice(index, 1);
                                        $(this).closest('tr').removeClass("del12");
                                    }
                                    if(ghataat1.length==0){
                                        $('#btn12').prop('disabled', true);
                                        $('#btn21').prop('disabled', true);
                                    }
                                }
                            });
                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                            t1 = $('<td style="width: 4%"></td>')
                            t1.append(chk)
                            if(response.results[i]['FLAG']==1){
                                row = $('<tr style="color:white;background-color: IndianRed;font-weight: bold;" class="row2"></tr>')
                            }else{
                                row = $('<tr style="color:black" class="row2"></tr>')
                            }                            
                            row.append(t1,ID_E,ID_G,SERIYAL_NUMBER)
                            $("#table2").append(row)
                        }
                    }
                })

            })
            $(".select_group").on('click',function (event) {
                group1=$(this).closest('tr').find('td:eq(1)').text();
                group2=0;
                $('#btn21').prop('disabled', true);
                $('#btn12').prop('disabled', true);
                $("tr.table1").css("background-color", "white");
                $("tr.table1").css("color", "black");
                $(this).closest('tr.table1').css("background-color", "#2975cd");
                $(this).closest('tr.table1').css("color", "white");
                $("#table4").empty();
                var id_g = $(this).closest('tr').find('td:eq(1)').text();
                var id_tg = $(this).closest('tr').find('td:eq(2)').text();
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '/m-gh-gr/' + id_g,
                    method: 'GET',
                        beforeSend: function(){
                            $("#first_spinner").show();
                            $("#table2").hide();
                            },
                        success: function (response) {
                            $("#first_spinner").hide();
                            $("#table2").show();
                        var ID_E = ''
                        var SERIYAL_NUMBER = ''
                        var ID_G = ''
                        var chk = ''
                        var t1 = ''
                        var row = ''
                        var th = $('<tr class="bg-primary" style="color:white;text-align: center;font-size: x-small;font-family: Tahoma"><td style="text-align: center">#</td><td style="text-align: center">شماره سریال</td></tr>')
                        $("#table2").empty();
                        $("#table2").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            ID_E = $('<td hidden style="width:5%;text-align: center">' + response.results[i]['ID_E'] + '</td>')
                            ID_G = $('<td hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                            chk = $('<input type="checkbox" class="ghataat1">').bind('change', function () {
                                if ($(this).is(':checked')){
                                    $('.ghataat2').prop('checked', false);
                                    $(this).closest('tr').addClass("del12");
                                    ghataat1.push($(this).closest('tr').find('td:eq(1)').text());
                                    ghataat2 =[]
                                    if(ghataat1.length>0 && group2>0){
                                        $('#btn12').prop('disabled', false);
                                        $('#btn21').prop('disabled', true);
                                    }
                                }else{
                                        var index = ghataat1.indexOf($(this).closest('tr').find('td:eq(1)').text());
                                        if (index !== -1) {
                                            ghataat1.splice(index, 1);
                                            $(this).closest('tr').removeClass("del12");
                                        }
                                        if(ghataat1.length==0){
                                            $('#btn12').prop('disabled', true);
                                            $('#btn21').prop('disabled', true);
                                        }
                                }
                            });
                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                            t1 = $('<td style="width: 4%"></td>')
                            t1.append(chk)
                            row = $('<tr class="row2"></tr>')
                            row.append(t1,ID_E,ID_G,SERIYAL_NUMBER)
                            $("#table2").append(row)
                        }
                    }
                })
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: '/m-group-total2/' + id_tg,
                    method: 'GET',
                    success: function (response) {
                        var select = ''
                        var ID_G = ''
                        var ID_USER = ''
                        var ID_TG = ''
                        var ID_TG2 = ''
                        var GROUP_CODE = ''
                        var t4 = ''
                        var row = ''
                        var th = $('<tr style="color: white;font-size:x-small;background-color:darkblue;"><td>#</td><td style="text-align: center">کد گروه</td><td style="text-align: center">نوع قطعه</td></tr>')
                        $("#table3").empty();
                        $("#table3").append(th)
                        for (var i = 0; i < response.results.length; i++) {
                            for (var j = 0; j < response.ID_TGS.length; j++) {
                                if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                    ID_TG = $('<td style="width: 80%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                    ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                    break;
                                }
                            }
                            for (var z = 0; z < response.ID_USERS.length; z++) {
                                if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                    ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                    break;
                                }
                            }
                            select = $('<button type="button" class="btn-sm border-info select_group" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;height: 20px;padding-top:1px"><p>>></p></button>').on('click', function (event) {
                                if(ghataat1.length>0){
                                    $('#btn12').prop('disabled', false);
                                    $('#btn21').prop('disabled', true);
                                }
                                group2=$(this).closest('tr').find('td:eq(1)').text();
                                event.preventDefault();
                                $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                var id_g = $(this).closest('tr').find('td:eq(1)').text()
                                $("tr.table3").css("background-color", "white");
                                $("tr.table3").css("color", "black");
                                $(this).closest('tr.table3').css("background-color", "#66CDAA");
                                $(this).closest('tr.table3').css("color", "white");
                                $('#ID_G_GH').val($(this).closest('tr').find('td:eq(1)').text())
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/m-gh-gr/' + id_g,
                                    method: 'GET',
                                    beforeSend: function(){
                                        $("#second_spinner").show();
                                        $("#table4").hide();
                                        },
                                    success: function (response) {
                                        $("#second_spinner").hide();
                                        $("#table4").show();
                                        var ID_E = ''
                                        var SERIYAL_NUMBER = ''
                                        var ID_G = ''
                                        var chk = ''
                                        var t1 = ''
                                        var row = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td style="text-align: center">#</td><td style="text-align: center">شماره سریال</td></tr>')
                                        $("#table4").empty();
                                        $("#table4").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            ID_E = $('<td hidden style="width:5%;text-align: center">' + response.results[i]['ID_E'] + '</td>')
                                            ID_G = $('<td hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                            chk = $('<input type="checkbox" class="ghataat2">').bind('change', function () {
                                                if ($(this).is(':checked')){
                                                    $('.ghataat1').prop('checked', false);
                                                    $(this).closest('tr').addClass("del21");
                                                    ghataat2.push($(this).closest('tr').find('td:eq(1)').text());
                                                    ghataat1 =[]
                                                    if(ghataat2.length>0 && group1>0){
                                                        $('#btn21').prop('disabled', false);
                                                        $('#btn12').prop('disabled', true);
                                                    }
                                                }else{
                                                    var index = ghataat2.indexOf($(this).closest('tr').find('td:eq(1)').text());
                                                    if (index !== -1) {
                                                        ghataat2.splice(index, 1);
                                                        $(this).closest('tr').removeClass("del21");
                                                    }
                                                    if(ghataat2.length==0){
                                                        $('#btn21').prop('disabled', true);
                                                        $('#btn12').prop('disabled', true);
                                                    }
                                                }
                                            });
                                            SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                            t1 = $('<td style="width: 4%"></td>')
                                            t1.append(chk)
                                            row = $('<tr class="table2"></tr>')
                                            row.append(t1,ID_E,ID_G,SERIYAL_NUMBER)
                                            $("#table4").append(row)
                                        }
                                    }
                                })
                            })
                            ID_G = $('<td hidden style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_G'] + '</td>')
                            GROUP_CODE = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_CODE'] + '</td>')
                            t4 = $('<td style="width: 4%"></td>')
                            t4.append(select)
                            row = $('<tr class="table3"></tr>')
                            if(response.results[i]['ID_G'] != id_g){
                                row.append(t4, ID_G,GROUP_CODE,ID_TG,ID_TG2)
                            }
                            $("#table3").append(row)
                        }
                    }
                })

            })
            $("#group_report_form").on('submit', function (event) {
                event.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                var _token = $("input[name='_token']").val();
                $.ajax({
                    url: "/m-group-rep",
                    method: 'POST',
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    processData: false,
                success: function (response) {
                    
                        if(response.results.length>0){
                            $('#myModal5').modal('hide');
                            $("#add_recieve").hide();
                            $("#edit_recieve").hide();
                            $("#description2").text('');
                            $("#ID_T_SUB2").text('');
                            $("#table2").empty();
                            $("#table3").empty();
                            $("#table4").empty();
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var select = ''
                            var ID_G = ''
                            var ID_USER = ''
                            var ID_TG = ''
                            var ID_TG2 = ''
                            var GROUP_CODE = ''
                            var GROUP_TYPE = ''
                            var GROUP_TYPE2 = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            var th = $('<tr style="background-color: #3c525f">\n' +
                                '                                    <th style="width: 5%;font-size: 10px;font-family: Tahoma;color:white">#</th>\n' +
                                '                                    <th style="width: 15%;font-size: 10px;font-family: Tahoma;color:white">کد گروه</th>\n' +
                                '                                    <th style="width: 70%;font-size: 10px;font-family: Tahoma;color:white">نوع قطعه</th>\n' +
                                '                                </tr>')
                            $("#first_table").empty();
                            $("#first_table").append(th)
                            for (var i = 0; i < response.results.length; i++) {
                                for (var j = 0; j < response.ID_TGS.length; j++) {
                                    if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                        ID_TG = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                        ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                        break;
                                    }
                                }
                                for (var z = 0; z < response.ID_USERS.length; z++) {
                                    if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                        ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                        break;
                                    }
                                }
                                select = $('<button type="button" class="btn-sm border-info select_group" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;height: 20px;padding-top:1px"><p>>></p></button>').on('click', function (event) {
                                    group1=$(this).closest('tr').find('td:eq(1)').text();
                                    group2=0;
                                    $('#btn21').prop('disabled', true);
                                    $('#btn12').prop('disabled', true);
                                    $("tr.table1").css("background-color", "white");
                                    $("tr.table1").css("color", "black");
                                    $(this).closest('tr.table1').css("background-color", "#2975cd");
                                    $(this).closest('tr.table1').css("color", "white");
                                    $("#table4").empty();
                                    var id_g = $(this).closest('tr').find('td:eq(1)').text();
                                    var id_tg = $(this).closest('tr').find('td:eq(4)').text();
                                    event.preventDefault();
                                    $.ajaxSetup({
                                        headers: {
                                            'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                        }
                                    });
                                    var _token = $("input[name='_token']").val();
                                    $.ajax({
                                        url: '/m-gh-gr/' + id_g,
                                        method: 'GET',
                                        beforeSend: function(){
                                            $("#first_spinner").show();
                                            $("#table2").hide();
                                        },
                                        success: function (response) {
                                            $("#first_spinner").hide();
                                            $("#table2").show();
                                            var ID_E = ''
                                            var SERIYAL_NUMBER = ''
                                            var ID_G = ''
                                            var chk = ''
                                            var t1 = ''
                                            var row = ''
                                            var th = $('<tr class="bg-primary" style="color:white;text-align: center;font-size: x-small;font-family: Tahoma"><td style="text-align: center">#</td><td style="text-align: center">شماره سریال</td></tr>')
                                            $("#table2").empty();
                                            $("#table2").append(th)

                                            for (var i = 0; i < response.results.length; i++) {
                                                ID_E = $('<td hidden style="width:5%;text-align: center">' + response.results[i]['ID_E'] + '</td>')
                                                ID_G = $('<td hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                                chk = $('<input type="checkbox" class="ghataat1">').bind('change', function () {
                                                    if ($(this).is(':checked')){
                                                        $('.ghataat2').prop('checked', false);
                                                        $(this).closest('tr').addClass("del12");
                                                        ghataat1.push($(this).closest('tr').find('td:eq(1)').text());
                                                        ghataat2 =[]
                                                        if(ghataat1.length>0 && group2>0){
                                                            $('#btn12').prop('disabled', false);
                                                            $('#btn21').prop('disabled', true);
                                                        }
                                                    }else{
                                                        var index = ghataat1.indexOf($(this).closest('tr').find('td:eq(1)').text());
                                                        if (index !== -1) {
                                                            ghataat1.splice(index, 1);
                                                            $(this).closest('tr').removeClass("del12");
                                                        }
                                                        if(ghataat1.length==0){
                                                            $('#btn12').prop('disabled', true);
                                                            $('#btn21').prop('disabled', true);
                                                        }
                                                    }
                                                });
                                                SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                t1 = $('<td style="width: 4%"></td>')
                                                t1.append(chk)
                                                row = $('<tr class="row2"></tr>')
                                                row.append(t1,ID_E,ID_G,SERIYAL_NUMBER)
                                                $("#table2").append(row)
                                            }
                                        }
                                    })
                                    $.ajaxSetup({
                                        headers: {
                                            'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                        }
                                    });
                                    var _token = $("input[name='_token']").val();

                                    $.ajax({
                                        url: '/m-group-total2/' + id_tg,
                                        method: 'GET',
                                        success: function (response) {

                                            var select = ''
                                            var ID_G = ''
                                            var ID_USER = ''
                                            var ID_TG = ''
                                            var ID_TG2 = ''
                                            var GROUP_CODE = ''
                                            var t4 = ''
                                            var row = ''
                                            var th = $('<tr style="color: white;font-size:x-small;background-color:darkblue;"><td>#</td><td style="text-align: center">کد گروه</td><td style="text-align: center">نوع قطعه</td></tr>')
                                            $("#table3").empty();
                                            $("#table3").append(th)
                                            for (var i = 0; i < response.results.length; i++) {
                                                for (var j = 0; j < response.ID_TGS.length; j++) {
                                                    if (response.ID_TGS[j]['ID_TG'] == response.results[i]['ID_TG']) {
                                                        ID_TG = $('<td style="width: 80%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.ID_TGS[j]['GHATAAT_NAME'] + '</td>');
                                                        ID_TG2 = $('<td hidden style="width: 7%;font-family: Tahoma;font-size: 10px;text-align: right">' + response.ID_TGS[j]['ID_TG'] + '</td>');
                                                        break;
                                                    }
                                                }
                                                for (var z = 0; z < response.ID_USERS.length; z++) {
                                                    if (response.ID_USERS[z]['id'] == response.results[i]['ID_USER']) {
                                                        ID_USER = $('<td hidden style="width: 7%">' + response.ID_USERS[z]['l_name'] + '</td>')
                                                        break;
                                                    }
                                                }
                                                select = $('<button type="button" class="btn-sm border-info select_group" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;height: 20px;padding-top:1px"><p>>></p></button>').on('click', function (event) {
                                                    if(ghataat1.length>0){
                                                        $('#btn12').prop('disabled', false);
                                                        $('#btn21').prop('disabled', true);
                                                    }
                                                    group2=$(this).closest('tr').find('td:eq(1)').text();
                                                    event.preventDefault();
                                                    $('#description2').text($(this).closest('tr').find('td:eq(5)').text())
                                                    var id_g = $(this).closest('tr').find('td:eq(1)').text()
                                                    $("tr.table3").css("background-color", "white");
                                                    $("tr.table3").css("color", "black");
                                                    $(this).closest('tr.table3').css("background-color", "#66CDAA");
                                                    $(this).closest('tr.table3').css("color", "white");
                                                    $('#ID_G_GH').val($(this).closest('tr').find('td:eq(1)').text())
                                                    $.ajaxSetup({
                                                        headers: {
                                                            'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                        }
                                                    });
                                                    var _token = $("input[name='_token']").val();
                                                    $.ajax({
                                                        url: '/m-gh-gr/' + id_g,
                                                        method: 'GET',
                                                        beforeSend: function(){
                                                            $("#second_spinner").show();
                                                            $("#table4").hide();
                                                        },
                                                        success: function (response) {
                                                            $("#second_spinner").hide();
                                                            $("#table4").show();
                                                            var ID_E = ''
                                                            var SERIYAL_NUMBER = ''
                                                            var ID_G = ''
                                                            var chk = ''
                                                            var t1 = ''
                                                            var row = ''
                                                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;text-align: center"><td style="text-align: center">#</td><td style="text-align: center">شماره سریال</td></tr>')
                                                            $("#table4").empty();
                                                            $("#table4").append(th)
                                                            for (var i = 0; i < response.results.length; i++) {
                                                                ID_E = $('<td hidden style="width:5%;text-align: center">' + response.results[i]['ID_E'] + '</td>')
                                                                ID_G = $('<td hidden style="text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                                                chk = $('<input type="checkbox" class="ghataat2">').bind('change', function () {
                                                                    if ($(this).is(':checked')){
                                                                        $('.ghataat1').prop('checked', false);
                                                                        $(this).closest('tr').addClass("del21");
                                                                        ghataat2.push($(this).closest('tr').find('td:eq(1)').text());
                                                                        ghataat1 =[]
                                                                        if(ghataat2.length>0 && group1>0){
                                                                            $('#btn21').prop('disabled', false);
                                                                            $('#btn12').prop('disabled', true);
                                                                        }
                                                                    }else{
                                                                        var index = ghataat2.indexOf($(this).closest('tr').find('td:eq(1)').text());
                                                                        if (index !== -1) {
                                                                            ghataat2.splice(index, 1);
                                                                            $(this).closest('tr').removeClass("del21");
                                                                        }
                                                                        if(ghataat2.length==0){
                                                                            $('#btn21').prop('disabled', true);
                                                                            $('#btn12').prop('disabled', true);
                                                                        }
                                                                    }
                                                                });
                                                                SERIYAL_NUMBER = $('<td style="width: 13%;text-align: center;font-size: 10px">' + response.results[i]['SERIYAL_NUMBER'] + '</td>')
                                                                t1 = $('<td style="width: 4%"></td>')
                                                                t1.append(chk)
                                                                row = $('<tr class="table2"></tr>')
                                                                row.append(t1,ID_E,ID_G,SERIYAL_NUMBER)
                                                                $("#table4").append(row)
                                                            }
                                                        }
                                                    })
                                                })
                                                ID_G = $('<td hidden style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                                GROUP_CODE = $('<td style="width: 20%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_CODE'] + '</td>')
                                                t4 = $('<td style="width: 4%"></td>')
                                                t4.append(select)
                                                row = $('<tr class="table3"></tr>')
                                                if(response.results[i]['ID_G'] != id_g){
                                                    row.append(t4, ID_G,GROUP_CODE,ID_TG,ID_TG2)
                                                }
                                                $("#table3").append(row)
                                            }
                                        }
                                    })

                                })
                                ID_G = $('<td hidden style="width: 4%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['ID_G'] + '</td>')
                                GROUP_CODE = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_CODE'] + '</td>')
                                GROUP_TYPE = $('<td hidden style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">' + response.results[i]['GROUP_TYPE'] + '</td>')
                                if(response.results[i]['GROUP_TYPE']==1){
                                    GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">حقیقی</td>')
                                }
                                if(response.results[i]['GROUP_TYPE']==2){
                                    GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">مجازی</td>')
                                }
                                if(response.results[i]['GROUP_TYPE']==3){
                                    GROUP_TYPE2 = $('<td style="width: 10%;font-family: Tahoma;font-size: 10px;text-align: center">ریجکت</td>')
                                }

                                t1 = $('<td style="width: 4%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 4%"></td>')
                                t2.append(del2)
                                t3 = $('<td style="width: 4%"></td>')
                                t3.append(detail1)
                                t4 = $('<td style="width: 4%"></td>')
                                t4.append(select)
                                row = $('<tr style="color:black;text-align: center;font-size: 10px;font-family: Tahoma;height:20px" class="table1">')
                                row.append(t4,ID_G,GROUP_CODE,ID_TG,ID_TG2)
                                $("#first_table").append(row)
                            }
                        }else{
                            Swal.fire('موردی یافت نشد', '', 'info')
                        }

                    }
                });
            })

        })
    </script>
        <div class="container bg-dark" style="width: 100%;height:6%;">
            <div class="row">
                <div class="col">
                    <ul class="navbar-nav" >
                        <li class="nav-item">
                            <a class="nav-link" href="/m-savabegh"><p style="font-family: Tahoma;font-size: x-small">بازگشت</p></a>
                        </li>
                    </ul>
                </div>
                <div class="col-2"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col"></div>
                <div class="col-4">
                    <div style="width: 100%;height: 65%;border-radius: 3px;margin-top: 4px;padding-top: 5px;background-color: #2F4F4F">
                        <p style="font-family: Tahoma;font-size: smaller;color: #fdfdfe"> (Mitsubishi)  جابجایی قطعات بین گروههای تعریف شده </p>
                    </div>
                </div>
            </div>
            <div class="row" style="direction: rtl">
                <div class="col-3" style="height: 550px">
                    <div class="row">
                        <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب گروه اول</p>
                        </div>
                        <div style="width:100%;height:45px;background-color: #0ec9cd;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <button class="btn" id="btn23" style="font-family: Tahoma;font-size: small;text-align: center;width:60%;background-color: #25395c;color: #fdfdfe" >جستجودرمیان گروهها</button>
                        </div>
                        <div style="width:100%;height: 250px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                            <table id="first_table" style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%">
                                <thead style="color:white;text-align: center;font-size: x-small;font-family: Tahoma">
                                <tr style="background-color: rgb(61,64,73)">
                                    <th style="width: 5%;font-size: 10px;font-family: Tahoma">#</th>
                                    <th style="width: 15%;font-size: 10px;font-family: Tahoma">کد گروه</th>
                                    <th style="width: 70%;font-size: 10px;font-family: Tahoma">نوع قطعه</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $request)
                                    <tr style="color:black;text-align: center;font-size: 10px;font-family: Tahoma;height:20px" class="table1">
                                        <td><button type="button" class="btn-sm border-info select_group" style="font-family: Tahoma;font-size: x-small;text-align: center;width: 100%;height: 20px;padding-top:1px"><p>>></p></button></td>
                                        <td hidden>{{$request['ID_G']}}</td>
                                        <td hidden>{{$request['ID_TG']}}</td>
                                        <td>{{$request['GROUP_CODE']}}</td>
                                        <td>{{\App\Mitsubishi_type_ghataat::where('ID_TG',$request['ID_TG'])->first()->GHATAAT_NAME}}</td>
                                    </tr>
                                @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">سابقه گروه انتخابی</p>
                        </div>
                        <div style="background-color:rgb(61,64,73);border-radius: 5px;width: 100%;margin-top: 5px;width: 100%;height: 155px">
                            ..
                        </div>
                    </div>
                </div>
                <div class="col-2" style="height: 550px">
                    <div class="row">
                        <div style="width:95%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">قطعات گروه اول</p>
                        </div>
                        <div style="width:90%;height: 500px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                            <div id="first_spinner" style="display: none;margin-top: 160px">
                                <img src="loading-18.gif" style="width:150px;height:120px;border-radius: 300px">
                            </div>
                            <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%" id="table2"></table>
                        </div>
                    </div>
                </div>
                <div class="col-2" style="height: 550px">
                    <div class="row" style="height: 200px;width:100%;margin: auto;margin-top: 60px;background-color:rgba(38,104,136,0.5);border-radius: 5px">
                            <div class="col-12">
                                <button disabled class="btn btn-success mt-3" id="btn12" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >انتقال قطعات انتخابی از گروه اول به دوم</button>
                            </div>
                            <div class="col-12">
                                <button disabled class="btn btn-info" id="btn21" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >انتقال قطعات انتخابی از گروه دوم به اول</button>
                            </div>
                    </div>
                </div>
                <div class="col-2" style="height: 550px">
                    <div class="row">
                        <div style="width:95%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">قطعات گروه دوم</p>
                        </div>
                        <div style="width:90%;height: 500px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                            <div id="second_spinner" style="display: none;margin-top: 160px">
                                <img src="loading-18.gif" style="width:150px;height:120px;border-radius: 300px">
                            </div>
                            <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%" id="table4"></table>
                        </div>
                    </div>
                </div>
                <div class="col-3" style="height: 550px">
                    <div class="row">
                        <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">انتخاب گروه دوم</p>
                        </div>
                        <div style="width:100%;height: 250px;background-color: rgb(61,64,73);margin: auto;margin-top:10px;border-radius: 3px;overflow-y: scroll;direction: ltr">
                            <table style="font-size: small;direction: rtl;background-color: #fdfdfe;width: 100%" id="table3"></table>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div style="width:100%;height:30px;background-color: #117a8b;margin: auto;margin-top:3px;border-radius: 3px;padding-top: 5px">
                            <p style="color: #fdfdfe;font-family: Tahoma;font-size:small">سابقه گروه انتخابی</p>
                        </div>
                        <div style="background-color:rgb(61,64,73);border-radius: 5px;width: 100%;margin-top: 5px;width: 100%;height: 200px">
                            ..
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="myModal5" style="direction: rtl;margin-top: 70px">
        <div class="modal-dialog modal-md" style="margin-top: 25px">
            <div class="modal-content">
                <div class="modal-header" style="height: 35px;padding-top: 5px;background-color:#2F4F4F" >
                    <div class="row" style="width: 100%">
                        <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">جستجو در میان گروهها</p></div>
                        <div class="col-6">
                            <div class="row" style="width: 100%">
                                <div class="col-10">.</div>
                                <div class="col-2">
                                    <button type="button" class="close" data-dismiss="modal" style="text-align: center;display: inline;color: white;">&times;</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="container"  style="margin: auto;background-color:lightgray;height: 180px ">
                    <form method="post" encType="multipart/form-data" id="group_report_form" action={{route('group2.store')}}>
                        {{csrf_field()}}
                        <br>
                        <div class="row" style="text-align: center">

                            <div class="col">
                                <select class="form-control isclicked1 mt-2" name="ID_TG_R" id="ID_TG_R" style="width: 200px;font-family: Tahoma;font-size: smaller;display: inline">
                                    <option value="0">انتخاب نوع قطعات</option>
                                    @foreach($ghataats as $ghataat)
                                        <option value="{{$ghataat->ID_TG}}">{{$ghataat->GHATAAT_NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2"  style="text-align: center">
                            <div class="col">
                                <select class="form-control isclicked1" name="GROUP_TYPE_R" id="GROUP_TYPE_R" style="width: 200px;font-family: Tahoma;font-size: small;display: inline">
                                    <option value="0">انتخاب نوع گروه</option>
                                    <option value="1">حقیقی</option>
                                    <option value="2">مجازی</option>
                                    <option value="3">ریجکت</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-3" style="text-align: right"></div>
                            <div class="col-6" style="text-align: right"><button type="submit" class="btn btn-info" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >جستجو</button></div>
                            <div class="col-3" style="text-align: right"></div>
                        </div>
                    </form>
                    <div id="ajax-alert4" class="toast-container toast-position-top-left" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer bg-info" style="height: 20px">

                </div>

            </div>
        </div>
    </div>


@endsection

