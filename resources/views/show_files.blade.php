@extends('layouts.app')

@section('content')
    <div class="container">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>File Name</th>
                <th>Uploaded At</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td>{{$file->id}}</td>
                <td>{{$file->name}}</td>
                <td>{{$file->created_at}}</td>
                <td>
                    <a class="btn btn-primary" target="_blank" href="/storage/{{$file->file}}"> <i class="fa fa-pencil mr-1" aria-hidden="true"></i>Show File</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
