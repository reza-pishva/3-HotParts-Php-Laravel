@extends('layouts.app')
@section('content')
    <div class="container">

        <h2>Reasons</h2>

        <form method="post" action={{route('reasons3.store')}}>
            {{csrf_field()}}
            <div class="form-group">
                <label for="id_exit">reason:</label>
                <input type="text" class="form-control" id="id_exit" name="id_exit" value={{$requests->id_exit}}>
            </div>
            <div class="form-group">
                <label for="reason">reason:</label>
                <input type="text" class="form-control" id="reason" placeholder="Enter the reasons" name="reason">
            </div>
            @include('shared.errors')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


    </div>


@endsection
