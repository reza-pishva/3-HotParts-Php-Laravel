@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Exit form Edit</h2>
    <form method="post" action={{route('exit.edit')}}>
        {{csrf_field()}}
        <div class="form-group">
            <label for="id_exit">id_exit:</label>
            <input type="text" class="form-control" id="id_exit" placeholder="Enter Exit no" name="id_exit" value={{$id_exit}}>
        </div>
        <div class="form-group">
            <label for="id_requester">id_exit:</label>
            <input type="text" class="form-control" id="id_requester"  name="id_requester" value={{$id_requester}}>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea type="text" id="description" name="description">{{$description}}</textarea>
        </div>
        <div class="form-group">
            <label for="exit_no">Exit no:</label>
            <input type="text" class="form-control" id="exit_no" placeholder="Enter Exit no" name="exit_no" value={{$exit_no}}>
        </div>
        <div class="form-group">
            <label for="jamdari_no">Jamdari no:</label>
            <input type="text" class="form-control" id="jamdari_no" name="jamdari_no" value={{$jamdari_no}}>
        </div>
        <div class="form-group">
            <label for="origin_destination">origin_destination:</label>
            <input type="text" class="form-control" id="origin_destination"  name="origin_destination" value={{$origin_destination}}>
        </div>
        <div class="form-group">
            <label for="with_return">with return:</label>
            <select class="form-control" name="with_return" id="with_return">
                <option value=1 {{$with_return==1 ? 'selected' : '' }}>بله</option>
                <option value=2 {{$with_return==2 ? 'selected' : '' }}>خیر</option>
            </select>
        </div>
        <div class="form-group">
            <label for="id_goods_type">Goods type:</label>
            <select class="form-control" name="id_goods_type" id="id_goods_type">
                @foreach($goodstypes as $goodstype)
                    <option value="{{ $goodstype->id_goods_type }}" {{$goodstype->id_goods_type == $id_goods_type ? 'selected' : '' }}>{{$goodstype->description}}</option>
                @endforeach
            </select>
        </div>

        @include('shared.errors')
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>
@endsection
