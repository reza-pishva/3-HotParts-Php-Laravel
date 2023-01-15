@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Parts Edit</h2>
    <form method="post" action={{route('goods.edit')}}>
        {{csrf_field()}}
        <div class="form-group">
            <label for="id_goods_type">id part:</label>
            <input type="text" class="form-control" id="id_goods_type" name="id_goods_type" value={{$id_goods_type}}>
        </div>
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea type="text" id="description" name="description">{{$description}}</textarea>
        </div>
        @include('shared.errors')
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


</div>
@endsection
