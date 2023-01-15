@extends('layouts.app')
@section('content')
    <script src="jquery.printPage.js"></script>
    <script>
        $(document).ready(function(){
            $('.btnprn').printPage();
        })
    </script>
    <div class="container">

        <h2>Parts form</h2>

        <form method="post" action={{route('parts.store')}}>
            {{csrf_field()}}
            <div class="form-group">
                <label for="description">Part name:</label>
                <input type="text" class="form-control" id="description" placeholder="Enter the part you work" name="description" value={{old('description')}}>
            </div>
            @include('shared.errors')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>
    <div>

        <div class="container mt-5 ">
            <h1>Parts name</h1>
            <a href="{{url('/parts-reg')}}" class="btnprn btn">print preview</a>
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
                        <td>{{$request['id_request_part']}}</td>
                        <td>{{$request['description']}}</td>
                        <td><a  class="btn btn-primary" href={{"http://localhost:8000/parts-edit-form/".$request['id_request_part']}}>Edit</a></td>
                        <td><a  class="btn btn-danger" href={{"http://localhost:8000/parts-delete/".$request['id_request_part']}}>Delete</a></td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>



    </div>

@endsection
