@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Parts Edit</h2>
    <form method="post" action={{route('parts.edit')}}>
        {{csrf_field()}}
        <div class="form-group">
            <label for="id_request_part">id part:</label>
            <input type="text" class="form-control" id="id_request_part" name="id_request_part" value={{$id_request_part}}>
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
