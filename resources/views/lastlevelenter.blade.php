@extends('layouts.app')
@section('content')
    <div>

        <div class="container mt-5 ">
            <h1>Last level</h1>
            <table class="table table-bordered table-sm" >
                <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                <tr>
                    <th style="width: 20px">Request No</th>
                    <th style="width: 350px">Description</th>
                    <th style="width: 20px">Goods type</th>
                    <th style="width: 120px">Jamdari No</th>
                    <th style="width: 120px">Date request</th>
                    <th>#</th>
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
                        <td><a  class="btn btn-info" href={{"http://localhost:8000/lastdetailenter/".$request['id_exit']}}>Enter permission</a></td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>



    </div>
@endsection
