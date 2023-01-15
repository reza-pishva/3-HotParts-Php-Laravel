@extends('layouts.app')
@section('content')

<div class="container">
    <h2>Last detail for exit</h2>
    <form method="post" action={{route('exit.update')}}>
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
            <label for="time_exit">time_exit:</label>
            <input type="text" class="form-control" id="time_exit" name="time_exit" value={{$mytime->toTimeString()}}>
        </div>
        <div class="form-group">
            <label for="date_exit_shamsi">date_exit_shamsi:</label>
            <input type="text" class="form-control" id="date_exit_shamsi" name="date_exit_shamsi" value={{$date_shamsi}}>
        </div>
        <div class="form-group">
            <label for="date_exit_miladi">date_exit_miladi:</label>
            <input type="text" class="form-control" id="date_exit_miladi" name="date_exit_miladi" value={{$mytime}}>
        </div>
        <div class="form-group">
            <label for="id_herasat_exit">id_herasat_exit:</label>
            <input type="text" class="form-control" id="id_herasat_exit" name="id_herasat_exit" value={{$user}}>
        </div>
        <div class="form-group">
            <label for="exit_timestamp">exit_timestamp:</label>
            <input type="text" class="form-control" id="exit_timestamp" name="exit_timestamp" value={{$mytime->timestamp}}>
        </div>
        <div class="form-group">
            <label for="id_car">driver:</label>
            <select class="form-control" name="id_car">
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
