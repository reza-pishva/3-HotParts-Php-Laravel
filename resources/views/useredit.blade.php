@extends('layouts.app')
@section('content')
<div class="container">
    <h2>User Edit</h2>
    <form method="post" action={{route('user.edit')}}>
        {{csrf_field()}}
        <div class="form-group">
            <label for="id">id:</label>
            <input type="text" class="form-control" id="id" name="id" value={{$id}}>
        </div>
        <div class="form-group">
            <label for="name">name:</label>
            <textarea type="text" id="name" name="name">{{$name}}</textarea>
        </div>
        <div class="form-group">
            <label for="f_name">First Name:</label>
            <input type="text" class="form-control" id="f_name"  name="f_name" value={{$f_name}}>
        </div>
        <div class="form-group">
            <label for="l_name">Last Name:</label>
            <input type="text" class="form-control" id="l_name"  name="l_name" value={{$l_name}}>
        </div>
        <div class="form-group">
            <label for="id_request_part">Part name:</label>
            <select class="form-control" name="id_request_part" id="id_request_part">
                @foreach($parts as $part)
                    <option value="{{ $part->id_request_part }}" {{$part->id_request_part == $id_request_part ? 'selected' : '' }}>{{$part->description}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="email"  name="email" value={{$email}}>
        </div>

        @include('shared.errors')
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>
@endsection
