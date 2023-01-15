@extends('layouts.app')
@section('content')
    <form method="post" action={{route('roles.store')}}>
    <div class="container mt-5 ">
        <h1>Users name</h1>
        <table class="table table-bordered table-sm" >
            <thead class="table table-bordered table-sm bg-success " style="color:white;text-align: center">
            <tr>
                <th>#</th>
                <th style="width: 20px">id</th>
                <th style="width: 350px">First Name</th>
                <th style="width: 350px">Last Name </th>
                <th style="width: 350px">Name</th>
                <th style="width: 350px">Email</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <form method="post" action={{route('roles.store')}}>
                {{csrf_field()}}
                @foreach($users as $user)
                    <tr>
                        <td><input type="checkbox"  name={{$user->id}} value={{$user->id}}></td>
                        <td>{{$user['id']}}</td>
                        <td>{{$user['f_name']}}</td>
                        <td>{{$user['l_name']}}</td>
                        <td>{{$user['name']}}</td>
                        <td>{{$user['email']}}</td>
                        <td><a  type="confirm"  class="btn btn-primary" href={{"{{URL::to('/')}}/user-role/".$user['id']}}>Roles</a></td>
                    </tr>
                @endforeach
            </form>
            </tbody>
        </table>
    </div>

    <div class="container mt-5 ">
        <h1>Roles</h1>
            {{csrf_field()}}
            @foreach($roles as $role)
                @if(\App\User_role::where('id_user',$person)->where('id_role',$role->id_role)->exists())
                    <input type="checkbox"  name={{$role->role}} value={{$role->id_role}} checked>
                @else
                    <input type="checkbox"  name={{$role->role}} value={{$role->id_role}}>
                @endif
                <label for={{$role->role}}>{{$role->role}}</label><br>
            @endforeach
        <button type="confirm" class="btn btn-danger">Save</button>
    </div>

    </form>
    {{$user->id}}
@endsection
