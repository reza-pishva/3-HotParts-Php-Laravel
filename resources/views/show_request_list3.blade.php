@extends('layouts.app')
@section('content')
    <div>

        <div class="container mt-5 ">
            <h1>Our Books</h1>
            <table class="table table-bordered table-sm" >
                <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                <tr>
                    <th>Book name</th>
                    <th>Page number</th>
                    <th>ISBN</th>
                    <th>Price</th>
                    <th>Published at</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($books as $book)
                    <tr style="color:black;text-align: center">
                        <td>{{$book['name']}}</td>
                        <td>{{$book['pages']}}</td>
                        <td>{{$book['ISBN']}}</td>
                        <td>{{$book['price']}}</td>
                        <td>{{$book['publish_at']}}</td>
                        <td><a href={{"http://localhost:8000/books/".$book['id']}} class="button">more details</a></td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>



    </div>
@endsection
