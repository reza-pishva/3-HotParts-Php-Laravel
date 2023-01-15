@extends('layouts.app')
@section('content')
    <div class="container">

        <h2>Cars form</h2>

        <form method="post" action={{route('cars.store')}}>
            {{csrf_field()}}
            <div class="form-group">
                <label for="car_no">Car No.:</label>
                <input type="text" class="form-control" id="car_no" placeholder="Enter the number of car" name="car_no" value={{old('car_no')}}>
            </div>
            <div class="form-group">
                <label for="driver_name">Driver Name:</label>
                <input type="text" class="form-control" id="driver_name" placeholder="enter driver name" name="driver_name" value={{old('driver_name')}}>
            </div>

            @include('shared.errors')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>

    <div class="container mt-5 ">
        <h1>Cars name</h1>
        <table class="table table-bordered table-sm" >
            <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
            <tr>
                <th style="width: 20px">id</th>
                <th style="width: 350px">car no</th>
                <th style="width: 350px">driver</th>
                <th>#</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                <tr style="color:black;text-align: center">
                    <td>{{$request['id_car']}}</td>
                    <td>{{$request['car_no']}}</td>
                    <td>{{$request['driver_name']}}</td>
                    <td><a  class="btn btn-primary" href={{"{{URL::to('/')}}/cars-edit-form/".$request['id_car']}}>Edit</a></td>
                    <td><a  class="btn btn-danger" href={{"{{URL::to('/')}}/cars-delete/".$request['id_car']}}>Delete</a></td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>

@endsection
