@extends('layouts.app_roletouser')
@section('content')
<script>
    $(document).ready(function() {
        bootstrap.Toast.Default.delay = 2000
        $("#add_user").on('click',function (event) {
            event.preventDefault();
            $(".addrole").hide()
            $(".usergroup").hide()
            $(".rolegroup").hide()
            $(".usercreate").hide()
            $(".addgroup").hide()
            $(".adduser").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/userstotal2',
                method:'GET',
                success: function (response) {
                    var f_name = ''
                    var l_name = ''
                    var email = ''
                    var name = ''
                    var id_user = ''
                    var id_request_part = ''
                    var t1 = ''
                    var t2 = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>نام کاربر</td><td>نام خانوادگی کاربر</td><td>پست الکترونیکی</td><td>نام کاربری</td><td>#</td><td>#</td><td>#</td></tr>')
                    var row = ''

                    $("#user_table2").empty();
                    $("#user_table2").append(th)
                    for (var i = 0; i < response.results.length; i++) {
                        edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal7">ویرایش</button>').attr('id', response.results[i]['id_user'] + 2000)
                        del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id', response.results[i]['id_user'] + 3000)
                        id_user = $('<td style="width: 5%">' + response.results[i]['id'] + '</td>')
                        f_name = $('<td style="width: 20%">' + response.results[i]['f_name'] + '</td>')
                        l_name = $('<td style="width: 25%">' + response.results[i]['l_name'] + '</td>')
                        email = $('<td style="width: 25%">' + response.results[i]['email'] + '</td>')
                        name = $('<td style="width: 18%">' + response.results[i]['name'] + '</td>')
                        id_request_part=$('<td style="width: 18%;color: beige">' + response.results[i]['id_request_part'] + '</td>')
                        t1 = $('<td style="width: 7%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 8%"></td>')
                        t2.append(del2)
                        row = $('<tr></tr>')
                        row.append(id_user, f_name, l_name, email, name,id_request_part, t1, t2)
                        $("#user_table2").append(row)
                    }
                    $(".del1").on('click', function () {
                        var id_user = $(this).closest('tr').find('td:eq(0)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: "/user-delete/" + id_user,
                            type: 'DELETE',
                            data: {
                                "id": id_user,
                                "_token": token,
                            },
                            success: function (response) {

                                $.ajax({
                                    url: '/userstotal2',
                                    method: 'GET',
                                    success: function (response) {
                                        var f_name = ''
                                        var l_name = ''
                                        var email = ''
                                        var id_user = ''
                                        var t1 = ''
                                        var t2 = ''
                                        var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>نام کاربر</td><td>نام خانوادگی کاربر</td><td>پست الکترونیکی</td><td>#</td><td>#</td></tr>')
                                        var row = ''

                                        $("#user_table2").empty();
                                        $("#user_table2").append(th)
                                        for (var i = 0; i < response.results.length; i++) {
                                            edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id', response.results[i]['id_user'] + 2000)
                                            del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id', response.results[i]['id_user'] + 3000)
                                            id_user = $('<td style="width: 5%">' + response.results[i]['id'] + '</td>')
                                            f_name = $('<td style="width: 25%">' + response.results[i]['f_name'] + '</td>')
                                            l_name = $('<td style="width: 25%">' + response.results[i]['l_name'] + '</td>')
                                            email = $('<td style="width: 30%">' + response.results[i]['email'] + '</td>')
                                            t1 = $('<td style="width: 7%"></td>')
                                            t1.append(edit1)
                                            t2 = $('<td style="width: 8%"></td>')
                                            t2.append(del2)
                                            row = $('<tr></tr>')
                                            row.append(id_user, f_name, l_name, email, t1, t2)
                                            $("#user_table2").append(row)
                                        }

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
                                        toastr.error('کاربر انتخاب شده حذف گردید');
                                    }
                                })
                            }
                        });
                    })
                    $(".edit1").on('click', function () {
                        $('#id_user_edit').val($(this).closest('tr').find('td:eq(0)').text())
                        $('#name_edit').val($(this).closest('tr').find('td:eq(4)').text())
                        $('#f_name_edit').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#l_name_edit').val($(this).closest('tr').find('td:eq(2)').text())
                        $('#email_edit').val($(this).closest('tr').find('td:eq(3)').text())
                        $('#id_request_part_edit').val($(this).closest('tr').find('td:eq(5)').text());
                    })
                }
            })
        })
        $("#add_group").on('click',function (event) {
              event.preventDefault();
            $(".addrole").hide()
            $(".usergroup").hide()
            $(".rolegroup").hide()
            $(".usercreate").hide()
            $(".adduser").hide()
            $(".addgroup").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/groupstotal',
                method:'GET',
                success: function (response) {
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var id_gr = ''
                    var gr_name = ''
                    var op=''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    $("#request_table").empty();
                    for(var i = 0; i < response.results.length; i++) {
                        edit1 = $('<button type="button" class="btn-sm btn-success edit" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',response.results[i]['id_gr']+2000)
                        del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_gr']+3000)
                        detail1 = $('<button type="button" class="btn-sm btn-info persons" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal3">افراد گروه</button>').attr('id',response.results[i]['id_gr']+4000)
                        detail2 = $('<button type="button" class="btn-sm btn-info level" style="font-family: Tahoma;font-size: x-small;text-align: right">سطوح دسترسی</button>').attr('id',response.results[i]['id_gr']+5000)
                        id_gr = $('<td class="id_gr" style="width: 10%">' + response.results[i]['id_gr'] + '</td>')
                        gr_name = $('<td style="width: 40%;text-align: right">' + response.results[i]['gr_name'] + '</td>')
                        t1 = $('<td style="width: 10%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 10%"></td>')
                        t2.append(del2)
                        t3 = $('<td style="width: 10%"></td>')
                        t3.append(detail1)
                        t4 = $('<td style="width: 20%"></td>')
                        t4.append(detail2)
                        row = $('<tr></tr>')
                        row.append(id_gr, gr_name,t1,t2,t3,t4)

                        $("#request_table").append(row)

                    }


                    {{--<select class="form-control" name="id_gr" id="id_gr2" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">--}}
                    {{--    <option>انتخاب گروه</option>--}}
                    {{--    @foreach($groups as $group)--}}
                    {{--    <option value="{{$group['id_gr']}}">{{$group['gr_name']}}</option>--}}
                    {{--    @endforeach--}}
                    {{--</select>--}}



                    $(".edit").on('click',function () {

                        $('#id_gr_edit').val($(this).closest('tr').find('td:eq(0)').text())
                        $('#gr_name_edit').val($(this).closest('tr').find('td:eq(1)').text())
                    })
                    $(".del").on('click',function () {
                        event.preventDefault();
                        var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: "/group-delete/" + id_gr,
                            type: 'DELETE',
                            data: {
                                "id": id_gr,
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
                                toastr.error('گروه انتخاب شده حذف گردید');
                                $('#' + (Number(id_gr) + 3000)).closest('tr').remove();

                                $(".selectgroups").empty();
                                op=$('<option>گروه مورد نظر را انتخاب کنید</option>')
                                $(".selectgroups").append(op)
                                for(var j= 0; j < response.data2.length; j++) {
                                    op=$('<option></option>').attr("value",response.data2[j]['id_gr'],"id",response.data2[j]['id_gr']).text(response.data2[j]['gr_name']);
                                    $(".selectgroups").append(op)
                                }
                            }
                        });
                    })
                    $(".persons").on('click',function () {
                        var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                        $.ajaxSetup({
                            headers: {
                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var _token = $("input[name='_token']").val();
                        $.ajax({
                            url: '/group-persons/'+id_gr,
                            method:'GET',
                            success: function (response) {
                                $('#myModal3').modal('show');
                                var fname = ''
                                var lname = ''
                                var email = ''
                                var row = ''
                                $(".personlist").remove();
                                for(var i = 0; i < response.data1.length; i++) {
                                    for(var j = 0; j < response.data2.length; j++){
                                        if(response.data1[i]['id_user']==response.data2[j]['id']){
                                            fname = $('<td style="width: 30%">' + response.data2[j]['f_name'] + '</td>')
                                            lname = $('<td style="width: 30%">' + response.data2[j]['l_name'] + '</td>')
                                            email = $('<td style="width: 30%">' + response.data2[j]['email'] + '</td>')
                                            row = $('<tr class="personlist"></tr>')
                                            row.append(fname, lname,email)
                                            $("#personel_list").append(row)
                                        }
                                    }
                                }
                            }
                        })
                    })
                    $(".level").on('click',function () {
                        var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                        $.ajaxSetup({
                            headers: {
                                'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        var _token = $("input[name='_token']").val();
                        $.ajax({
                            url: '/group-levels/'+id_gr,
                            method:'GET',
                            success: function (response) {
                                $('#myModal4').modal('show');
                                var level = ''
                                var row = ''
                                $(".levellist").remove();
                                for(var i = 0; i < response.data1.length; i++) {
                                    for(var j = 0; j < response.data2.length; j++){
                                        if(response.data1[i]['id_role']==response.data2[j]['id_role']){
                                            level = $('<td style="width: 30%;font-family: Tahoma;font-size: small">' + response.data2[j]['role_fa'] + '</td>')
                                            row = $('<tr class="levellist"></tr>')
                                            row.append(level)
                                            $("#level_list").append(row)
                                        }
                                    }
                                }
                            }
                        })

                    })
                }
            })
        })
        $("#add_role").on('click',function (event) {
            event.preventDefault();
            $(".addgroup").hide()
            $(".usergroup").hide()
            $(".rolegroup").hide()
            $(".usercreate").hide()
            $(".adduser").hide()
            $(".addrole").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/rolestotal',
                method:'GET',
                success: function (response) {
                    var edit1 = ''
                    var del2 = ''
                    var detail1 = ''
                    var detail2 = ''
                    var id_gr = ''
                    var gr_name = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>سطح دسترسی</td><td>سطح دسترسی</td><td>#</td><td>#</td></tr>')
                    $("#role_table").empty();
                    $("#role_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['id_role']+2000)
                        del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_role']+3000)
                        id_role = $('<td class="id_gr" style="width: 10%">' + response.results[i]['id_role'] + '</td>')
                        role = $('<td style="width: 40%">' + response.results[i]['role'] + '</td>')
                        role_fa = $('<td style="width: 40%">' + response.results[i]['role_fa'] + '</td>')
                        t1 = $('<td style="width: 10%"></td>')
                        t1.append(edit1)
                        t2 = $('<td style="width: 10%"></td>')
                        t2.append(del2)
                        row = $('<tr></tr>')
                        row.append(id_role, role,role_fa,t1,t2)
                        $("#role_table").append(row)

                    }
                    $(".edit1").on('click',function () {
                        $('#id_role_edit').val($(this).closest('tr').find('td:eq(0)').text())
                        $('#role_en_edit').val($(this).closest('tr').find('td:eq(1)').text())
                        $('#role_fa_edit').val($(this).closest('tr').find('td:eq(2)').text())
                    })
                    $(".del1").on('click',function () {
                        var id_role = $(this).closest('tr').find('td:eq(0)').text();
                        var token = $("meta[name='csrf-token']").attr("content");
                        $.ajax({
                            url: "/role-delete/" + id_role,
                            type: 'DELETE',
                            data: {
                                "id": id_role,
                                "_token": token,
                            },
                            success: function () {
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
                                toastr.error('سطح دسترسی انتخاب شده حذف گردید');
                                $('#' + (Number(id_role) + 3000)).closest('tr').remove();

                            }
                        });
                    })
                }
            })
        })
        $("#user_to_group").on('click',function (event) {
            event.preventDefault();
            $(".addrole").hide()
            $(".addgroup").hide()
            $(".rolegroup").hide()
            $(".usercreate").hide()
            $(".adduser").hide()
            $(".usergroup").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/userstotal',
                method:'GET',
                success: function (response) {
                    var f_name = ''
                    var l_name = ''
                    var email = ''
                    var id_user = ''
                    var chk = ''
                    var t1 = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام کاربر</td><td>نام خانوادگی کاربر</td><td>پست الکترونیکی</td></tr>')
                    var row = ''

                    $("#user_table").empty();
                    $("#user_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        chk=$('<input class="users" type="checkbox"/>').attr('value',response.results[i]['id'])
                        id_user = $('<td style="width: 10%">' + response.results[i]['id'] + '</td>')
                        f_name = $('<td style="width: 25%">' + response.results[i]['f_name'] + '</td>')
                        l_name = $('<td style="width: 30%">' + response.results[i]['l_name'] + '</td>')
                        email=$('<td style="width: 30%">' + response.results[i]['email'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(chk)
                        row = $('<tr ></tr>')
                        row.append(t1,id_user, f_name,l_name,email)
                        $("#user_table").append(row)

                    }
                }
            })
        })
        $("#role_to_group").on('click',function (event) {
            event.preventDefault();
            $(".addrole").hide()
            $(".addgroup").hide()
            $(".usergroup").hide()
            $(".usercreate").hide()
            $(".adduser").hide()
            $(".rolegroup").fadeToggle(2000);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/rolestotal',
                method:'GET',
                success: function (response) {
                    var checkbox1=''
                    var id_gr = ''
                    var gr_name = ''
                    var t1 = ''
                    var t2 = ''
                    var t3 = ''
                    var t4 = ''
                    var row = ''
                    $("#role_table2").empty();
                    for(var i = 0; i < response.results.length; i++) {
                        // edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['id_role']+2000)
                        // del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_role']+3000)
                        checkbox1=$('<input class="roles" type="checkbox">').attr('value',response.results[i]['id_role'])
                        id_role = $('<td style="width: 10%" class="id_gr" style="width: 10%">' + response.results[i]['id_role'] + '</td>')
                        role = $('<td style="width: 35%">' + response.results[i]['role'] + '</td>')
                        role_fa = $('<td style="width: 40%">' + response.results[i]['role_fa'] + '</td>')
                        // t1 = $('<td style="width: 10%"></td>')
                        // t1.append(edit1)
                        t2 = $('<td style="width: 5%"></td>')
                        t2.append(checkbox1)
                        row = $('<tr style="background-color: cornsilk"></tr>')
                        row.append(t2,id_role, role,role_fa)
                        $("#role_table2").append(row)

                    }
                }
            })
        })
        $("#group_form").on('submit', function (event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/groupstore",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {

                    toastr.success("گروه جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });

                    var new_id_gr=response.data
                    $.ajax({
                        url: '/groupstotal',
                        method:'GET',
                        success: function (response) {
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var id_gr = ''
                            var gr_name = ''
                            var op=''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            $("#request_table").empty();

                            for(var i = 0; i < response.results.length; i++) {
                                edit1 = $('<button type="button" class="btn-sm btn-success edit" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',response.results[i]['id_gr']+2000)
                                del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_gr']+3000)
                                detail1 = $('<button type="button" class="btn-sm btn-info persons" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal3">افراد گروه</button>').attr('id',response.results[i]['id_gr']+4000)
                                detail2 = $('<button type="button" class="btn-sm btn-info level" style="font-family: Tahoma;font-size: x-small;text-align: right">سطوح دسترسی</button>').attr('id',response.results[i]['id_gr']+5000)
                                id_gr = $('<td class="id_gr" style="width: 10%">' + response.results[i]['id_gr'] + '</td>')
                                gr_name = $('<td style="width: 40%">' + response.results[i]['gr_name'] + '</td>')
                                t1 = $('<td style="width: 10%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 10%"></td>')
                                t2.append(del2)
                                t3 = $('<td style="width: 10%"></td>')
                                t3.append(detail1)
                                t4 = $('<td style="width: 20%"></td>')
                                t4.append(detail2)
                                row = $('<tr></tr>')
                                row.append(id_gr, gr_name,t1,t2,t3,t4)

                                $("#request_table").append(row)

                            }
                            // op=$('<option></option>').attr("value",new_id_gr).text($('#gr_name').val());
                            // $(".selectgroups").append(op)
                            $('#gr_name').val('')
                            $(".selectgroups").empty();
                            op=$('<option>گروه مورد نظر را انتخاب کنید</option>')
                            $(".selectgroups").append(op)
                            for(var j= 0; j < response.results.length; j++) {
                                op=$('<option></option>').attr("value",response.results[j]['id_gr'],"id",response.results[j]['id_gr']).text(response.results[j]['gr_name']);
                                $(".selectgroups").append(op)
                            }

                            $(".edit").on('click',function () {
                                $('#id_gr_edit').val($(this).closest('tr').find('td:eq(0)').text())
                                $('#gr_name_edit').val($(this).closest('tr').find('td:eq(1)').text())
                            })
                            $(".del").on('click',function () {
                                event.preventDefault();
                                var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/group-delete/" + id_gr,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_gr,
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
                                        toastr.error('گروه انتخاب شده حذف گردید');
                                        $('#' + (Number(id_gr) + 3000)).closest('tr').remove();

                                        $(".selectgroups").empty();
                                        op=$('<option>گروه مورد نظر را انتخاب کنید</option>')
                                        $(".selectgroups").append(op)
                                        for(var j= 0; j < response.data2.length; j++) {
                                            op=$('<option></option>').attr("value",response.data2[j]['id_gr'],"id",response.data2[j]['id_gr']).text(response.data2[j]['gr_name']);
                                            $(".selectgroups").append(op)
                                        }
                                    }
                                });
                            })
                            $(".persons").on('click',function () {
                                var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/group-persons/'+id_gr,
                                    method:'GET',
                                    success: function (response) {
                                        $('#myModal3').modal('show');
                                        var fname = ''
                                        var lname = ''
                                        var email = ''
                                        var row = ''
                                        $(".personlist").remove();
                                        for(var i = 0; i < response.data1.length; i++) {
                                            for(var j = 0; j < response.data2.length; j++){
                                                if(response.data1[i]['id_user']==response.data2[j]['id']){
                                                    fname = $('<td style="width: 30%">' + response.data2[j]['f_name'] + '</td>')
                                                    lname = $('<td style="width: 30%">' + response.data2[j]['l_name'] + '</td>')
                                                    email = $('<td style="width: 30%">' + response.data2[j]['email'] + '</td>')
                                                    row = $('<tr class="personlist"></tr>')
                                                    row.append(fname, lname,email)
                                                    $("#personel_list").append(row)
                                                }
                                            }
                                        }
                                    }
                                })
                            })
                        }
                    })

                }
            });
        })
        $("#role_form").on('submit', function (event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/rolestore",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                processData: false,
                success: function (response) {
                    $('#role_latin').val('')
                    $('#role_farsi').val('')
                    toastr.success("سطح دسترسی جدید با موفقیت ایجاد گردید", "", {
                        "timeOut": "3500",
                        "extendedTImeout": "0"
                    });
                    $.ajax({
                        url: '/rolestotal',
                        method:'GET',
                        success: function (response) {
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var id_gr = ''
                            var gr_name = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            $("#role_table").empty();
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>سطح دسترسی</td><td>سطح دسترسی</td><td>#</td><td>#</td></tr>')
                            $("#role_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['id_role']+2000)
                                del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_role']+3000)
                                id_role = $('<td class="id_gr" style="width: 10%">' + response.results[i]['id_role'] + '</td>')
                                role = $('<td style="width: 40%">' + response.results[i]['role'] + '</td>')
                                role_fa = $('<td style="width: 40%">' + response.results[i]['role_fa'] + '</td>')
                                t1 = $('<td style="width: 10%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 10%"></td>')
                                t2.append(del2)
                                row = $('<tr></tr>')
                                row.append(id_role, role,role_fa,t1,t2)
                                $("#role_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#id_role_edit').val($(this).closest('tr').find('td:eq(0)').text())
                                $('#role_en_edit').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#role_fa_edit').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_role = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/role-delete/" + id_role,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_role,
                                        "_token": token,
                                    },
                                    success: function () {
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
                                        toastr.error('گروه انتخاب شده حذف گردید');
                                        $('#' + (Number(id_role) + 3000)).closest('tr').remove();

                                    }
                                });
                            })
                        }
                    })


                }
            });
        })
        $("#btnupdate5").on('click',function (event) {
            var id_gr2 = $("#id_gr2").val();
            var selected_user = []; // initialize empty array
            $(".users:checked").each(function(){
                selected_user.push($(this).val());
            });
            selected_user.push(id_gr2);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/usertogroup",
                type:'POST',
                data: {
                    _token:_token,
                    data1: selected_user
                },
                success: function(response){
                    $('.toast').toast('show');
                    $("#mytoast_usergroup").text("این افراد به گروه انتخابی منتقل شدند")
                }
            });
        })
        $("#btnupdate6").on('click',function (event) {
            var id_gr3 = $("#id_gr3").val();
            var selected_role = []; // initialize empty array
            $(".roles:checked").each(function(){
                selected_role.push($(this).val());
            });
            selected_role.push(id_gr3);
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/roletogroup",
                type:'POST',
                data: {
                    _token:_token,
                    data2: selected_role
                },
                success: function(response){
                    $('.toast').toast('show');
                    $("#mytoast_rolegroup").text("این سطوح دسترسی به گروه انتخابی تخصیص داده شد")
                }
            });
        })
        $("#edit_form_user").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/edituser",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
                    $('.toast').toast('show');
                    $("#mytoast").text("اطلاعات مربوط به کاربر انتخابی تغییر داده شد")
                    // $('#gr_name').val('')
                    $.ajax({
                        url: '/userstotal2',
                        method:'GET',
                        success: function (response) {
                            var f_name = ''
                            var l_name = ''
                            var email = ''
                            var name = ''
                            var id_user = ''
                            var id_request_part = ''
                            var t1 = ''
                            var t2 = ''
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>نام کاربر</td><td>نام خانوادگی کاربر</td><td>پست الکترونیکی</td><td>نام کاربری</td><td>#</td><td>#</td><td>#</td></tr>')
                            var row = ''

                            $("#user_table2").empty();
                            $("#user_table2").append(th)
                            for (var i = 0; i < response.results.length; i++) {
                                edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal7">ویرایش</button>').attr('id', response.results[i]['id_user'] + 2000)
                                del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id', response.results[i]['id_user'] + 3000)
                                id_user = $('<td style="width: 5%">' + response.results[i]['id'] + '</td>')
                                f_name = $('<td style="width: 20%">' + response.results[i]['f_name'] + '</td>')
                                l_name = $('<td style="width: 25%">' + response.results[i]['l_name'] + '</td>')
                                email = $('<td style="width: 25%">' + response.results[i]['email'] + '</td>')
                                name = $('<td style="width: 18%">' + response.results[i]['name'] + '</td>')
                                id_request_part=$('<td style="width: 18%;color: beige">' + response.results[i]['id_request_part'] + '</td>')
                                t1 = $('<td style="width: 7%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 8%"></td>')
                                t2.append(del2)
                                row = $('<tr></tr>')
                                row.append(id_user, f_name, l_name, email, name,id_request_part, t1, t2)
                                $("#user_table2").append(row)
                            }
                            $(".del1").on('click', function () {
                                var id_user = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/user-delete/" + id_user,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_user,
                                        "_token": token,
                                    },
                                    success: function () {
                                        $.ajax({
                                            url: '/userstotal2',
                                            method: 'GET',
                                            success: function (response) {
                                                var f_name = ''
                                                var l_name = ''
                                                var email = ''
                                                var id_user = ''
                                                var t1 = ''
                                                var t2 = ''
                                                var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>نام کاربر</td><td>نام خانوادگی کاربر</td><td>پست الکترونیکی</td><td>#</td><td>#</td></tr>')
                                                var row = ''

                                                $("#user_table2").empty();
                                                $("#user_table2").append(th)
                                                for (var i = 0; i < response.results.length; i++) {
                                                    edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id', response.results[i]['id_user'] + 2000)
                                                    del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id', response.results[i]['id_user'] + 3000)
                                                    id_user = $('<td style="width: 5%">' + response.results[i]['id'] + '</td>')
                                                    f_name = $('<td style="width: 25%">' + response.results[i]['f_name'] + '</td>')
                                                    l_name = $('<td style="width: 25%">' + response.results[i]['l_name'] + '</td>')
                                                    email = $('<td style="width: 30%">' + response.results[i]['email'] + '</td>')
                                                    t1 = $('<td style="width: 7%"></td>')
                                                    t1.append(edit1)
                                                    t2 = $('<td style="width: 8%"></td>')
                                                    t2.append(del2)
                                                    row = $('<tr></tr>')
                                                    row.append(id_user, f_name, l_name, email, t1, t2)
                                                    $("#user_table2").append(row)
                                                }
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
                                                toastr.error('کاربر انتخاب شده حذف گردید');
                                            }
                                        })
                                    }
                                });
                            })
                            $(".edit1").on('click', function () {
                                $('#id_user_edit').val($(this).closest('tr').find('td:eq(0)').text())
                                $('#name_edit').val($(this).closest('tr').find('td:eq(4)').text())
                                $('#f_name_edit').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#l_name_edit').val($(this).closest('tr').find('td:eq(2)').text())
                                $('#email_edit').val($(this).closest('tr').find('td:eq(3)').text())
                                $('#id_request_part_edit').val($(this).closest('tr').find('td:eq(5)').text());
                            })
                        }
                    })
                }
            });
            $('#myModal7').modal('hide');
        });
        $("#edit_form_group").on('submit',function(event) {

            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/editgroup",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
                    $('.toast').toast('show');
                    $("#mytoast").text("نام گروه انتخابی تغییر داده شد")
                    $('#gr_name').val('')


                    $.ajax({
                        url: '/groupstotal',
                        method:'GET',
                        success: function (response) {
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var id_gr = ''
                            var gr_name = ''
                            var op=''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''
                            $("#request_table").empty();
                            for(var i = 0; i < response.results.length; i++) {
                                edit1 = $('<button type="button" class="btn-sm btn-success edit" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal2">ویرایش</button>').attr('id',response.results[i]['id_gr']+2000)
                                del2 = $('<button type="button" class="btn-sm btn-danger del" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_gr']+3000)
                                detail1 = $('<button type="button" class="btn-sm btn-info persons" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal3">افراد گروه</button>').attr('id',response.results[i]['id_gr']+4000)
                                detail2 = $('<button type="button" class="btn-sm btn-info level" style="font-family: Tahoma;font-size: x-small;text-align: right">سطوح دسترسی</button>').attr('id',response.results[i]['id_gr']+5000)
                                id_gr = $('<td class="id_gr" style="width: 10%">' + response.results[i]['id_gr'] + '</td>')
                                gr_name = $('<td style="width: 40%">' + response.results[i]['gr_name'] + '</td>')
                                t1 = $('<td style="width: 10%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 10%"></td>')
                                t2.append(del2)
                                t3 = $('<td style="width: 10%"></td>')
                                t3.append(detail1)
                                t4 = $('<td style="width: 20%"></td>')
                                t4.append(detail2)
                                row = $('<tr></tr>')
                                row.append(id_gr, gr_name,t1,t2,t3,t4)

                                $("#request_table").append(row)

                            }
                            $(".selectgroups").empty();
                            op=$('<option>گروه مورد نظر را انتخاب کنید</option>')
                            $(".selectgroups").append(op)
                            for(var j= 0; j < response.results.length; j++) {
                                op=$('<option></option>').attr("value",response.results[j]['id_gr']).text(response.results[j]['gr_name']);
                                $(".selectgroups").append(op)
                            }

                            $(".edit").on('click',function () {

                                $('#id_gr_edit').val($(this).closest('tr').find('td:eq(0)').text())
                                $('#gr_name_edit').val($(this).closest('tr').find('td:eq(1)').text())
                            })
                            $(".del").on('click',function () {
                                event.preventDefault();
                                var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/group-delete/" + id_gr,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_gr,
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
                                        toastr.error('گروه انتخاب شده حذف گردید');
                                        $('#' + (Number(id_gr) + 3000)).closest('tr').remove();
                                        $(".selectgroups").empty();
                                        op=$('<option>گروه مورد نظر را انتخاب کنید</option>')
                                        $(".selectgroups").append(op)
                                        for(var j= 0; j < response.data2.length; j++) {
                                            op=$('<option></option>').attr("value",response.data2[j]['id_gr'],"id",response.data2[j]['id_gr']).text(response.data2[j]['gr_name']);
                                            $(".selectgroups").append(op)
                                        }
                                    }
                                });
                            })
                            $(".persons").on('click',function () {
                                var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/group-persons/'+id_gr,
                                    method:'GET',
                                    success: function (response) {
                                        $('#myModal3').modal('show');
                                        var fname = ''
                                        var lname = ''
                                        var email = ''
                                        var row = ''
                                        $(".personlist").remove();
                                        for(var i = 0; i < response.data1.length; i++) {
                                            for(var j = 0; j < response.data2.length; j++){
                                                if(response.data1[i]['id_user']==response.data2[j]['id']){
                                                    fname = $('<td style="width: 30%">' + response.data2[j]['f_name'] + '</td>')
                                                    lname = $('<td style="width: 30%">' + response.data2[j]['l_name'] + '</td>')
                                                    email = $('<td style="width: 30%">' + response.data2[j]['email'] + '</td>')
                                                    row = $('<tr class="personlist"></tr>')
                                                    row.append(fname, lname,email)
                                                    $("#personel_list").append(row)
                                                }
                                            }
                                        }
                                    }
                                })
                            })
                            $(".level").on('click',function () {
                                var id_gr = $(this).closest('tr').find('td:eq(0)').text();
                                $.ajaxSetup({
                                    headers: {
                                        'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                    }
                                });
                                var _token = $("input[name='_token']").val();
                                $.ajax({
                                    url: '/group-levels/'+id_gr,
                                    method:'GET',
                                    success: function (response) {
                                        $('#myModal4').modal('show');
                                        var level = ''
                                        var row = ''
                                        $(".levellist").remove();
                                        for(var i = 0; i < response.data1.length; i++) {
                                            for(var j = 0; j < response.data2.length; j++){
                                                if(response.data1[i]['id_role']==response.data2[j]['id_role']){
                                                    level = $('<td style="width: 30%;font-family: Tahoma;font-size: small">' + response.data2[j]['role_fa'] + '</td>')
                                                    row = $('<tr class="levellist"></tr>')
                                                    row.append(level)
                                                    $("#level_list").append(row)
                                                }
                                            }
                                        }
                                    }
                                })

                            })
                        }
                    })
                }
            });
            $('#myModal2').modal('hide');
        });
        $("#edit_form_role").on('submit',function(event) {
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: "/editrole",
                method:'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType:false,
                processData:false,
                success: function () {
                    $('.toast').toast('show');
                    $("#mytoast5").text("نام سطح دسترسی انتخابی تغییر داده شد")
                    $.ajax({
                        url: '/rolestotal',
                        method:'GET',
                        success: function (response) {
                            var edit1 = ''
                            var del2 = ''
                            var detail1 = ''
                            var detail2 = ''
                            var id_gr = ''
                            var gr_name = ''
                            var t1 = ''
                            var t2 = ''
                            var t3 = ''
                            var t4 = ''
                            var row = ''

                            $("#role_table").empty();
                            var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>کد</td><td>سطح دسترسی</td><td>سطح دسترسی</td><td>#</td><td>#</td></tr>')
                            $("#role_table").append(th)
                            for(var i = 0; i < response.results.length; i++) {
                                edit1 = $('<button type="button" class="btn-sm btn-success edit1" style="font-family: Tahoma;font-size: x-small;text-align: right" data-toggle="modal" data-target="#myModal6">ویرایش</button>').attr('id',response.results[i]['id_role']+2000)
                                del2 = $('<button type="button" class="btn-sm btn-danger del1" style="font-family: Tahoma;font-size: x-small;text-align: right">حذف</button>').attr('id',response.results[i]['id_role']+3000)
                                id_role = $('<td class="id_gr" style="width: 10%">' + response.results[i]['id_role'] + '</td>')
                                role = $('<td style="width: 40%">' + response.results[i]['role'] + '</td>')
                                role_fa = $('<td style="width: 40%">' + response.results[i]['role_fa'] + '</td>')
                                t1 = $('<td style="width: 10%"></td>')
                                t1.append(edit1)
                                t2 = $('<td style="width: 10%"></td>')
                                t2.append(del2)
                                row = $('<tr></tr>')
                                row.append(id_role, role,role_fa,t1,t2)
                                $("#role_table").append(row)

                            }
                            $(".edit1").on('click',function () {
                                $('#id_role_edit').val($(this).closest('tr').find('td:eq(0)').text())
                                $('#role_en_edit').val($(this).closest('tr').find('td:eq(1)').text())
                                $('#role_fa_edit').val($(this).closest('tr').find('td:eq(2)').text())
                            })
                            $(".del1").on('click',function () {
                                var id_role = $(this).closest('tr').find('td:eq(0)').text();
                                var token = $("meta[name='csrf-token']").attr("content");
                                $.ajax({
                                    url: "/role-delete/" + id_role,
                                    type: 'DELETE',
                                    data: {
                                        "id": id_role,
                                        "_token": token,
                                    },
                                    success: function () {
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
                                        toastr.error('سطح دسترسی انتخاب شده حذف گردید');
                                        $('#' + (Number(id_role) + 3000)).closest('tr').remove();

                                    }
                                });
                            })
                        }
                    })
                }
            });
            $('#myModal6').modal('hide');
        });
        $("#id_gr2").on('change',function (event) {
           var id_gr=$(this).val();
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/userstotal',
                method:'GET',
                data: {
                    _token:_token,
                    data1: id_gr
                },
                success: function (response) {
                    var f_name = ''
                    var l_name = ''
                    var email = ''
                    var id_user = ''
                    var chk = ''
                    var t1 = ''
                    var th = $('<tr class="bg-primary" style="color: white;font-size:x-small;"><td>#</td><td>کد</td><td>نام کاربر</td><td>نام خانوادگی کاربر</td><td>پست الکترونیکی</td></tr>')
                    var row = ''

                    $("#user_table").empty();
                    $("#user_table").append(th)
                    for(var i = 0; i < response.results.length; i++) {
                        chk=$('<input class="users" type="checkbox"/>').attr( { value:response.results[i]['id'], id:response.results[i]['id']} );
                        id_user = $('<td style="width: 10%">' + response.results[i]['id'] + '</td>')
                        f_name = $('<td style="width: 25%">' + response.results[i]['f_name'] + '</td>')
                        l_name = $('<td style="width: 30%">' + response.results[i]['l_name'] + '</td>')
                        email=$('<td style="width: 30%">' + response.results[i]['email'] + '</td>')
                        t1 = $('<td style="width: 5%"></td>')
                        t1.append(chk)
                        row = $('<tr ></tr>')
                        row.append(t1,id_user, f_name,l_name,email)
                        $("#user_table").append(row)

                    }
                    for(var j = 0; j < response.results.length; j++) {
                        for(var x = 0; x < response.selected.length; x++) {
                                if(response.selected[x]['id_user']==response.results[j]['id']){
                                    $("#"+response.selected[x]['id_user']).prop('checked',true)
                                }
                        }

                    }
                }
            })
        })
        $("#id_gr3").on('change',function (event) {
            var id_gr=$(this).val();
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            var _token = $("input[name='_token']").val();
            $.ajax({
                url: '/rolestotal',
                method:'GET',
                data: {
                    _token:_token,
                    data1: id_gr
                },
                success: function (response) {
                        var checkbox1=''
                        var id_role = ''
                        var role = ''
                        var role_fa = ''
                        var t2 = ''
                        var t3 = ''
                        var t4 = ''
                        var row = ''
                        $("#role_table2").empty();
                        for(var i = 0; i < response.results.length; i++) {

                            // checkbox1=$('<input class="roles" type="checkbox">').attr('value',response.results[i]['id_role'])
                             checkbox1=$('<input class="roles" type="checkbox"/>').attr( { value:response.results[i]['id_role'], id:response.results[i]['id_role']} );
                            id_role = $('<td style="width: 10%" class="id_gr" style="width: 10%">' + response.results[i]['id_role'] + '</td>')
                            role = $('<td style="width: 35%">' + response.results[i]['role'] + '</td>')
                            role_fa = $('<td style="width: 40%">' + response.results[i]['role_fa'] + '</td>')
                            // t1 = $('<td style="width: 10%"></td>')
                            // t1.append(edit1)
                            t2 = $('<td style="width: 5%"></td>')
                            t2.append(checkbox1)
                            row = $('<tr style="background-color: cornsilk"></tr>')
                            row.append(t2,id_role, role,role_fa)
                            $("#role_table2").append(row)

                        }
                    for(var j = 0; j < response.results.length; j++) {
                        for(var x = 0; x < response.selected.length; x++) {
                            if(response.selected[x]['id_role']==response.results[j]['id_role']){
                               $("#"+response.selected[x]['id_role']).prop('checked',true)
                            }
                        }

                    }
                }
            })
        })
    })
</script>
<!-- List of content -->

    <div class="container" style="direction: rtl;">
        <div class="row adduser" style="display: none">
            <div class="col-2  mt-3">.</div>
            <div class="col-8  mt-3">
                <div class="row">
                    <div class="col-12">
                        <div class="row mylist" style="margin: auto;width:100%;height:300px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                            <div class="col-12" style="direction: rtl;height: 298px;overflow-y: scroll">
                                <table id="user_table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small;">

                                </table>
                            </div>
                            <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                                <div class="toast-body"><p id="mytoast" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2  mt-3">.</div>
        </div>
        <div class="row addgroup" style="display: none">
            <div class="col-2  mt-3">.</div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px"><p class="onvan">بخش تعیین نام گروههای مورد نیاز</p></div>
            <div class="col-2  mt-3">.</div>
        </div>
        <div class="row addgroup" style="display: none">
            <div class="col-2  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="group_form" action={{route('group.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="id_gr" name="id_gr" >
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control gr_name" id="gr_name"  placeholder="نام گروه" name="gr_name" style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-success" id="btnupdate3" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت</button>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="request_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
{{--                                        <tr class="bg-primary" style="color: white;font-size:x-small;">--}}
{{--                                            <td>شماره گروه</td>--}}
{{--                                            <td>نام گروه</td>--}}
{{--                                            <td>#</td>--}}
{{--                                            <td>#</td>--}}
{{--                                            <td>#</td>--}}
{{--                                            <td>#</td>--}}
{{--                                        </tr>--}}
                                    </table>

                                </div>
                                <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                                    <div class="toast-body"><p id="mytoast" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2  mt-3">.</div>
        </div>
        <div class="row addrole" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تعیین نام سطوح دسترسی</p></div>
            <div class="col-2"></div>
        </div>
        <div class="row addrole" style="display: none">
            <div class="col-2  mt-3">.</div>
            <div class="col-8  mt-3">
                <form method="post" encType="multipart/form-data" id="role_form" action={{route('role.store')}}>
                    {{csrf_field()}}
                    <div class="row">
                        <div>
                            <input type="hidden" class="form-control" id="id_role" name="id_role" >
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" id="role_latin"  placeholder="نام نقش به انگلیسی" name="role" style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right">
                            <button type="submit" class="btn btn-primary" id="btnupdate4" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                        </div>

                    </div>
                    <div class="row mt-1">
                        <div class="col-8">
                            <input type="text" class="form-control" id="role_farsi"  placeholder="نام نقش به فارسی" name="role_fa" style="font-family: Tahoma;font-size: small;width:100%">
                        </div>
                        <div class="col-4" style="text-align: right"></div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: beige">
                                <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                                    <table id="role_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small">
                                        <tr class="bg-primary" style="color: white;font-size:x-small;">
                                            <td>شماره نقش</td>
                                            <td>سطح دسترسی</td>
                                            <td>سطح دسترسی</td>
                                            <td>#</td>
                                            <td>#</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                                    <div class="toast-body"><p id="mytoast5" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2  mt-3">.</div>
        </div>
        <div class="row usergroup" style="display: none">
            <div class="col-2"></div>
            <div class="col-8  pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تخصیص افراد به گروههای موجود</p></div>
            <div class="col-2"></div>
        </div>
        <div class="row mt-1 usergroup" style="display: none">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row">
                    <div class="col-8">
                        <select class="form-control selectgroups" name="id_gr" id="id_gr2" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                            <option>گروه مورد نظر را انتخاب کنید</option>
                            @foreach($groups as $group)
                                <option value="{{$group['id_gr']}}">{{$group['gr_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-info" id="btnupdate5" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-1 usergroup" style="display: none">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: white">
                    <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll">
                        <table class="table table-hover bg-light" id="user_table" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
                    </div>
                    <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                        <div class="toast-body"><p id="mytoast_usergroup" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
        <div class="row rolegroup" style="display: none">
            <div class="col-2"></div>
            <div class="col-8 pegah pt-1" style="height: 30px;border-radius: 5px;margin-top: 50px;width: 90%"><p class="onvan">بخش تخصیص سطوح دسترسی به گروههای موجود</p></div>
            <div class="col-2"></div>
        </div>
        <div class="row mt-1 rolegroup" style="display: none">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row">
                    <div class="col-8">
                        <select class="form-control selectgroups" name="id_gr" id="id_gr3" style="width: 100%;font-family: Tahoma;font-size: small;display: inline">
                            <option>گروه مورد نظر را انتخاب کنید</option>
                            @foreach($groups as $group)
                                <option value="{{$group['id_gr']}}">{{$group['gr_name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                        <button type="button" class="btn btn-primary" id="btnupdate6" style="font-family: Tahoma;font-size: small;text-align: center;width:100%" >ثبت </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mt-1 rolegroup" style="display: none;">
            <div class="col-2"></div>
            <div class="col-8">
                <div class="row mylist" style="margin: auto;width:100%;height:185px;direction: rtl;margin-top: 4px;border: 1px solid black;border-radius: 5px;background-color: white">
                    <div class="col-12" style="direction: rtl;height: 183px;overflow-y: scroll;background-color: blanchedalmond">
                        <table class="table table-hover bg-light" id="role_table2" align="center" style="width: 100%;font-family: Tahoma;font-size: small"></table>
                    </div>
                    <div class="toast bg-success" style="margin-top:20px;margin: auto;border-radius: 10px">
                        <div class="toast-body"><p id="mytoast_rolegroup" style="font-family: Tahoma;font-size: small;color: white;"></p></div>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>

        <!-- Edit form1 -->
        <div class="modal fade mt-3" id="myModal2" style="direction: rtl;">
            <div class="modal-dialog modal-md" id="editlist" style="margin-top: 300px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام گروههای دسترسی</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="edit_form_group" action="{{route('editform1.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="id_gr_edit"  name="id_gr">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام گروه:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="gr_name_edit"  name="gr_name" style="direction:rtl;font-family:Tahoma;font-size:small" >
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
        <!-- Edit form2 -->
        <div class="modal fade mt-3" id="myModal6" style="direction: rtl;">
            <div class="modal-dialog modal-md" style="margin-top: 300px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح نام سطوح دسترسی</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="edit_form_role" action="{{route('editform2.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="id_role_edit"  name="id_role">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام سطح دسترسی به حروف لاتین:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="role_en_edit"  name="role" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">نام سطح دسترسی به فارسی:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="role_fa_edit"  name="role_fa" style="direction:rtl;font-family:Tahoma;font-size:small" >
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
                        <div id="ajax-alert4" class="alert" style="display:none;font-family: Tahoma;font-size: small;text-align: center"></div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-info" style="height: 20px">

                    </div>

                </div>
            </div>
        </div>
        <!-- Edit form3 -->
        <div class="modal fade mt-3" id="myModal7" style="direction: rtl;">
            <div class="modal-dialog modal-md" id="editlist7" style="margin-top: 300px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;" >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فرم اصلاح مشخصات کاربران</p></div>
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
                    <div class="container"  style="margin: auto;background-color:lightgray ">
                        <form method="post" encType="multipart/form-data" id="edit_form_user" action="{{route('editform3.edit')}}">
                            {{csrf_field()}}
                            <input type="hidden" class="form-control" id="id_user_edit"  name="id">
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام کاربری:</p></div>
                                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">محل خدمت:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-6">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="name_edit"  name="name" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" style="height: 15px">
                                        <select id="id_request_part_edit" class="form-control" name="id_request_part">
                                            @foreach($parts as $part)
                                                <option value="{{$part->id_request_part}}">{{$part->description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-12"><p style="text-align: right;font-family: Tahoma;font-size: small">پست الکترونیکی:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-12">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="email_edit"  name="email" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 10px;margin-top: 25px;width: 100%">
                                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام کاربر:</p></div>
                                <div class="col-6"><p style="text-align: right;font-family: Tahoma;font-size: small">نام خانوادگی کاربر:</p></div>
                            </div>
                            <div class="row" style="margin-top: 10px">
                                <div class="col-6">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="f_name_edit"  name="f_name" style="direction:rtl;font-family:Tahoma;font-size:small" >
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group" style="height: 15px">
                                        <input type="text" class="form-control" id="l_name_edit"  name="l_name" style="direction:rtl;font-family:Tahoma;font-size:small" >
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
        <!-- Personel list -->
        <div class="modal fade mt-3" id="myModal3" style="direction: rtl;">
            <div class="modal-dialog modal-md" id="editlist2" style="margin-top: 100px;margin-left: 600px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فهرست افراد این گروه</p></div>
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
                    <div class="container"  style="margin: auto;background-color:#c4e6f5;width: 850px ;height: 400px;;overflow-y: scroll">
                        <table class="table table-striped" id="personel_list" style="width: 800px">
                            <thead>
                            <tr style="background-color: darkslateblue;color: #f9f9f9;font-family: Tahoma;font-size: small">
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>پست الکترونیک</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-info" style="height: 20px;width:850px"></div>

                </div>
            </div>
        </div>
        <!-- level list -->
        <div class="modal fade mt-3" id="myModal4" style="direction: rtl;">
            <div class="modal-dialog modal-md" id="editlist3" style="margin-top: 100px;margin-left: 600px">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header bg-dark" style="height: 35px;padding-top: 5px;width: 850px " >
                        <div class="row" style="width: 100%">
                            <div class="col-6"><p class="modal-title" style="color: white;font-family: Tahoma;font-size: small;display: inline">فهرست سطوح دسترسی این گروه</p></div>
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
                    <div class="container"  style="margin: auto;background-color:#c4e6f5;width: 850px ;height: 400px;;overflow-y: scroll">
                        <table class="table table-striped" id="level_list" style="width: 800px">
                            <thead>
                            <tr style="background-color: darkslateblue;color: #f9f9f9;font-family: Tahoma;font-size: small">
                                <th>سطح دسترسی</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer bg-info" style="height: 20px;width:850px">

                    </div>

                </div>
            </div>
        </div>
    </div>



@endsection

