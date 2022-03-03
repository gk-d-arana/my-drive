@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Username</th>
                <th>Password</th>
                <th>Files</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr>
                <td>{{$user->id}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->show_password}}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('user_files', ["id"=>$user->id]) }}"> <i class="fa fa-pencil mr-1" aria-hidden="true"></i>See Files</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



</div>
@endsection
