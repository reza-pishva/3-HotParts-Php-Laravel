
    <div>

        <div class="container mt-5 ">
            <h1>Our Books</h1>

        </div>
        <div>

            <div class="container mt-5 ">
                <h1>Recieved request</h1>
                <table class="table table-bordered table-sm" >
                    <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
                    <tr>
                        <th style="width: 20px">Request No</th>
                        <th style="width: 350px">Description</th>
                        <th style="width: 20px">Goods type</th>
                        <th style="width: 120px">Jamdari No</th>
                        <th style="width: 120px">Date request</th>
                        <th>#</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($requests as $request)
                        <tr style="color:black;text-align: center">
                            <td>{{$request['id_exit']}}</td>
                            <td>{{$request['description']}}</td>
                            <td>{{$request['id_goods_type']}}</td>
                            <td>{{$request['jamdari_no']}}</td>
                            <td>{{$request['date_request_shamsi']}}</td>
                            <td><a  class="btn btn-primary" href={{"http://localhost:8000/confirm1/".$request['id_exit']}}>Confirm</a></td>
                            <td><a  class="btn btn-danger" href={{"http://localhost:8000/return1/".$request['id_exit']}}>Return</a></td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>



        </div>



    </div>
@endsection
