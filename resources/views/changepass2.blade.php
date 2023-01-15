@extends('layouts.app')
@section('content')
    <script>
        $(document).ready(function(){
            $("#changepass").on("submit",function(e){
                if($("#f_password").val()!=$("#password").val()){
                    e.preventDefault();
                    $('#ajax-alert3').addClass('alert-danger').show(function(){
                        $(this).html("کلمات عبور وارد شده یکسان نیستند");
                    });
                }
            });
        })
    </script>
    <div class="container">
        <form id="changepass" method="post" action={{route('user.reset')}}>
            {{csrf_field()}}
            <div class="row">
                <div class="col-4"></div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="f_password"><p style="font-family: Tahoma;font-size: small;color: white">کلمه عبور جدید</p></label>
                        <input type="password" maxlength="10" required class="form-control" id="f_password" name="f_password" value={{old('f_password')}}>
                    </div>
                    <div class="form-group">
                        <label for="password"><p style="font-family: Tahoma;font-size: small;color: white">تکرار کلمه عبور جدید</p></label>
                        <input type="password" maxlength="10" required class="form-control" id="password" name="password" value={{old('password')}}>
                    </div>
                    <div id="ajax-alert3" class="alert" style="display:none;font-family: Tahoma;font-size: small"></div>
                </div>
                <div class="col-4"></div>
            </div>


            @include('shared.errors')
            <button type="submit" class="btn btn-primary"><p style="font-family: Tahoma;font-size: small;color: white">اعمال تغییرات</p></button>
        </form>


    </div>



@endsection
