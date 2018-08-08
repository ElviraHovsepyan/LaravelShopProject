@extends('layout')

@section('content')

    @if($auth)
        <h2>Files list</h2>
        <a href="{{route('list')}}">List</a><br><br>
        @foreach($files as $file)
          <img src="https://drive.google.com/uc?id={{ $file->id }}">
          <p> Filename : {{ $file->name }} </p>
          <p> File Id : {{ $file->id }} </p>
        @endforeach
        <hr>
        <h2>Upload File</h2>
        <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="file"><br><br>
            <input type="submit">
        </form>
        <hr>
        <h2>Create folder</h2>
        <a href="{{ route('createFolder') }}">Create folder</a><br><br>
        <hr>
        <h2>Move to next folder</h2>
        <a href="{{ route('move') }}">Move file</a><br><br>
        <hr>
    @else
        <a href="/google">Auth</a>
    @endif


@endsection

@section('rightBar')
    @endsection
@section('footer')
    @endsection

