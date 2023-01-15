@extends('layouts.app')
@section('content')
    <div>

        <div class="container mt-5 ">
            <h1>Second return(for first person who confirmed)</h1>
            <table class="table table-bordered table-sm" >
                <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                <tr>
                    <th style="width: 5%">Request No</th>
                    <th style="width: 45%">Description</th>
                    <th style="width: 10%">Goods type</th>
                    <th style="width: 10%">Jamdari No</th>
                    <th style="width: 10%">Date request</th>
                    <th style="width: 10%">#</th>
                    <th style="width: 10%">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr style="color:black;text-align: center">
                        <td>{{$request['id_exit']}}</td>
                        <td>{{$request['description']}}</td>
                        <td>{{$goodstypes->where('id_goods_type',$request['id_goods_type'])->first()->description}}</td>
                        <td>{{$request['jamdari_no']}}</td>
                        <td>{{$request['date_request_shamsi']}}</td>
                        <td><a  class="btn btn-primary" href={{"http://localhost:8000/confirm2/".$request['id_exit']}}>Confirm</a></td>
                        <td><a  class="btn btn-danger" href={{"http://localhost:8000/return2/".$request['id_exit']}}>Return</a></td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>



    </div>
@endsection
