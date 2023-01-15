@extends('layouts.app')
@section('content')
    <div>

        <div class="container mt-5 ">
            <h1>First Confirmation level</h1>
            <table class="table table-bordered table-sm" style="font-size: small">
                <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                <tr>
                    <th style="width: 5%">Request No</th>
                    <th style="width: 10%">sender</th>
                    <th style="width: 12%">part</th>
                    <th style="width: 33%">Description</th>
                    <th style="width: 10%">Goods type</th>
                    <th style="width: 7%">Jamdari No</th>
                    <th style="width: 7%">Date request</th>
                    <th style="width: 8%">#</th>
                    <th style="width: 8%">#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr style="color:black;text-align: center">
                        <td>{{$request['id_exit']}}</td>
                        <td>{{\App\User::where('id',$request['id_requester'])->first()->f_name.' '.
                              \App\User::where('id',$request['id_requester'])->first()->l_name}}
                        </td>
                        <td>{{\App\Requestpart::where('id_request_part',$request['id_request_part'])->first()->description}}</td>
                        <td>{{$request['description']}}</td>
                        <td>{{$goodstypes->where('id_goods_type',$request['id_goods_type'])->first()->description}}</td>
                        <td>{{$request['jamdari_no']}}</td>
                        <td>{{$request['date_request_shamsi']}}</td>
                        <td><a  class="btn btn-primary" href={{"{{URL::to('/')}}/confirm1/".$request['id_exit']}}>Confirm</a></td>
                        <td><a  class="btn btn-danger" href={{"{{URL::to('/')}}/return1/".$request['id_exit']}}>Return</a></td>
                    </tr>
                @endforeach


                </tbody>
            </table>
        </div>



    </div>
@endsection
