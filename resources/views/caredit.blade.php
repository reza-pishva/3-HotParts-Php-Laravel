@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Cars Edit</h2>
    <form method="post" action={{route('cars.edit')}}>
        {{csrf_field()}}
        <div class="form-group">
            <label for="id_car">id car:</label>
            <input type="text" class="form-control" id="id_car" name="id_car" value={{$id_car}}>
        </div>
        <div class="form-group">
            <label for="car_no">car no:</label>
            <input type="text" class="form-control" id="car_no" name="car_no" value={{$car_no}}>
        </div>
        <div class="form-group">
            <label for="driver_name">driver name:</label>
            <textarea type="text" class="form-control" id="driver_name" name="driver_name">{{$driver_name}}</textarea>
        </div>
        @include('shared.errors')
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>
@endsection
