@extends('layouts.app')
@section('content')
    <div class="container">

        <h2>Goods form</h2>

        <form method="post" action={{route('goods.store')}}>
            {{csrf_field()}}
            <div class="form-group">
                <label for="description">Goods Type:</label>
                <input type="text" class="form-control" id="description" placeholder="Enter the Type of goods" name="description" value={{old('description')}}>
            </div>
            @include('shared.errors')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>
    <div class="container mt-5 ">
        <h1>Parts name</h1>
        <table class="table table-bordered table-sm" >
            <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
            <tr>
                <th style="width: 20px">id</th>
                <th style="width: 350px">Description</th>
                <th>#</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            @foreach($requests as $request)
                <tr style="color:black;text-align: center">
                    <td>{{$request['id_goods_type']}}</td>
                    <td>{{$request['description']}}</td>
                    <td><a  class="btn btn-primary" href={{"http://localhost:8000/goods-edit-form/".$request['id_goods_type']}}>Edit</a></td>
                    <td><a  class="btn btn-danger" href={{"http://localhost:8000/goods-delete/".$request['id_goods_type']}}>Delete</a></td>
                </tr>
            @endforeach


            </tbody>
        </table>
    </div>

@endsection
