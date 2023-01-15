@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body" style="background-color:rgba(14,53,126,0.5)">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <input hidden id="plain_pass" type="text"  name="plain_pass" >
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('نام کاربری') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" maxlength="50" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('آدرس پست الکترونیکی') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" maxlength="50" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('تلفن همراه') }}</label>

                            <div class="col-md-6">
                                <input id="mobile" maxlength="11" minlength="11" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">

                                @error('mobile')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"  class="col-md-4 col-form-label text-md-right">{{ __('کلمه عبور') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" maxlength="20" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('f_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('تایید کلمه عبور') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" maxlength="20" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="f_name" class="col-md-4 col-form-label text-md-right">{{ __('نام کاربر') }}</label>

                            <div class="col-md-6">
                                <input id="f_name" type="text" maxlength="20" class="form-control @error('f_name') is-invalid @enderror" name="f_name" required autocomplete="f_name">

                                @error('f_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="l_name" class="col-md-4 col-form-label text-md-right">{{ __('نام خانوادگی کاربر') }}</label>

                            <div class="col-md-6">
                                <input id="l_name" type="text" maxlength="20" class="form-control @error('l_name') is-invalid @enderror" name="l_name" required autocomplete="l_name">

                                @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="id_request_part" class="col-md-4 col-form-label text-md-right">{{ __('محل خدمت') }}</label>
                            <div class="col-md-6">
                                <select class="form-control" name="id_request_part">
                                    @foreach($parts as $part)
                                        <option value="{{$part->id_request_part}}">{{$part->description}}</option>
                                    @endforeach
                                </select>
                                @error('id_request_part')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('ثبت') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{--<div class="container mt-5 ">--}}
{{--    <h1>Users name</h1>--}}
{{--    <table class="table table-bordered table-sm" >--}}
{{--        <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">--}}
{{--        <tr>--}}
{{--            <th style="width: 20px">id</th>--}}
{{--            <th style="width: 350px">First Name</th>--}}
{{--            <th style="width: 350px">Last Name </th>--}}
{{--            <th style="width: 350px">Name</th>--}}
{{--            <th style="width: 350px">Email</th>--}}
{{--            <th>#</th>--}}
{{--            <th>#</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($requests as $request)--}}
{{--            <tr style="color:black;text-align: center">--}}
{{--                <td>{{$request['id']}}</td>--}}
{{--                <td>{{$request['f_name']}}</td>--}}
{{--                <td>{{$request['l_name']}}</td>--}}
{{--                <td>{{$request['name']}}</td>--}}
{{--                <td>{{$request['email']}}</td>--}}
{{--                <td><a  class="btn btn-primary" href={{"http://localhost:8000/users-edit-form/".$request['id']}}>Edit</a></td>--}}
{{--                <td><a  class="btn btn-danger" href={{"http://localhost:8000/users-delete/".$request['id']}}>Delete</a></td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}


{{--        </tbody>--}}
{{--    </table>--}}
{{--</div>--}}
@endsection
