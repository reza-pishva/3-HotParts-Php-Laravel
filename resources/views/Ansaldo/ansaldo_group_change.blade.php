@extends('layouts.ansaldo_layouts.app_group_change')
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
                    url: '/gh-gr2/' + group2 +'/'+ ghataats,
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
                    url: '/gh-gr3/' + group1 +'/'+ ghataats,
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
                    url: '/gh-gr/' + id_g,
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
                    url: '/group-total2/' + id_tg,
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
                                    url: '/gh-gr/' + id_g,
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
                    url: "/group-rep",
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
                                        url: '/gh-gr/' + id_g,
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
                                        url: '/group-total2/' + id_tg,
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
                                                        url: '/gh-gr/' + id_g,
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
@include('Ansaldo.AnsaldoGroupChangeComponents.component01')
@include('Ansaldo.AnsaldoGroupChangeComponents.component02')

@endsection

