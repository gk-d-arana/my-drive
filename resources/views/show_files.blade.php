@extends('layouts.app')

@section('content')
    <div class="container">
                            @if (session('danger'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('danger') }}
                            </div>
                        @endif
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>File Name</th>
                <th>Uploaded At</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
            <tr>
                <td >{{$file->id}}</td>
                <td >{{$file->name}}</td>
                <td style="width: min-content">{{$file->created_at}}</td>
                <td style="width: min-content;text-align: center;">
                    <a class="btn btn-primary" target="_blank" href="/storage/{{$file->file}}"> <i class="fa fa-pencil mr-1" aria-hidden="true"></i>Show File</a>
                    <a class="btn btn-danger" href="{{route('delete_file', ['id' => $file->id])}}"> <i class="fa fa-pencil mr-1" aria-hidden="true"></i>Delete File</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
@endsection
