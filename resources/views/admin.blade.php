
@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
        <h4><span>Users</span></h4>
    </section>
    <section class="main-content">

        @foreach($users as $user)
            @if($user->block == 0)
            <h4>{{ $user->name }} <button class="btn block-users" id="{{ $user->id }}">Block</button></h4>
            @else
            <h4>{{ $user->name }} <button class="btn block-users" id="{{ $user->id }}">Unblock</button></h4>
            @endif
        @endforeach

    </section>

@endsection

@section('rightBar')
@endsection












