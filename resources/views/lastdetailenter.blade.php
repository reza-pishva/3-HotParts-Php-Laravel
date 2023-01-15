@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Last detail for enter</h2>
    <form method="post" action={{route('enter.update')}}>
        {{csrf_field()}}
        <div class="form-group">
            <label for="id_exit">id_exit:</label>
            <input type="text" class="form-control" id="id_exit" name="id_exit" value={{$id}}>
        </div>
        <div class="form-group">
            <label for="id_request_part">id_request_part:</label>
            <input type="text" class="form-control" id="id_request_part" name="id_request_part" value={{\App\Exit_goods_permission::where('id_exit',$id)->get()->first()->id_request_part}}>
        </div>
        <div class="form-group">
            <label for="date_shamsi">date_shamsi:</label>
            <input type="text" class="form-control" id="date_shamsi" name="date_shamsi" value={{$date_shamsi}}>
        </div>
        <div class="form-group">
            <label for="id_request_part">id_requester:</label>
            <input type="text" class="form-control" id="id_requester" name="id_requester" value={{\App\Exit_goods_permission::where('id_exit',$id)->get()->first()->id_requester}}>
        </div>
        <div class="form-group">
            <label for="date_enter_shamsi">date_enter_shamsi:</label>
            <input type="text" class="form-control" id="date_enter_shamsi" name="date_enter_shamsi" value={{$date_shamsi}}>
        </div>
        <div class="form-group">
            <label for="id_herasat_enter">id_herasat_enter:</label>
            <input type="text" class="form-control" id="id_herasat_enter" name="id_herasat_enter" value={{$user}}>
        </div>
        <div class="form-group">
            <label for="time_enter">time_enter:</label>
            <input type="text" class="form-control" id="time_enter" name="time_enter" value={{$mytime->toTimeString()}}>
        </div>

        <div class="form-group">
            <label for="date_enter_miladi">date_enter_miladi:</label>
            <input type="text" class="form-control" id="date_enter_miladi" name="date_enter_miladi" value={{$mytime}}>
        </div>
        <div class="form-group">
            <label for="enter_timestamp">enter_timestamp:</label>
            <input type="text" class="form-control" id="enter_timestamp" name="enter_timestamp" value={{$mytime->timestamp}}>
        </div>
        <div class="form-group">
            <label for="enter_no">enter_no:</label>
            <input type="text" class="form-control" id="enter_no" name="enter_no" placeholder="enter the number of goods entered">
        </div>
        <div class="form-group">
            <label for="id_car_enter">driver:</label>
            <select class="form-control" name="id_car_enter">
                @foreach($cars as $car)
                    <option value="{{$car->id_car}}">{{$car->driver_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="with_return">with_return:</label>
            <input type="text" class="form-control" id="with_return" name="with_return" value={{$request->with_return}}>
        </div>

        @include('shared.errors')
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
