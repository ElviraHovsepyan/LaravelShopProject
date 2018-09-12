
@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
        <h4><span>Promocodes</span></h4>
    </section>
    <section class="main-content">
        <table class="table">
            <tr>
                <th>Header</th>
                <th>Body</th>
                <th>Is_Active</th>
                <th>Sending_date</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            @foreach($subscriptions as $subscription)
                <tr>
                    <td><input type="text" value="{{ $subscription->header }}" class="headerInput"></td>
                    <td><input type="text" value="{{ $subscription->body }}" class="bodyInput"></td>
                    <td><input type="text" value="{{ $subscription->is_active }}" class="activeInput"></td>
                    <td><input type="text" value="{{ $subscription->sending_date }}" class="dateInput"></td>
                    <td><button class="btn editSubscription" subscrId="{{ $subscription->id }}">Edit</button></td>
                    <td><button class="btn deleteSub" subscrId="{{ $subscription->id }}">Delete</button></td>
                </tr>
            @endforeach
            <tr>
                <td><input type="text" value="" placeholder="Header" class="headerInput"></td>
                <td><input type="text" value="" placeholder="Body" class="bodyInput"></td>
                <td><input type="text" value="" placeholder="Is_Active" class="activeInput"></td>
                <td><input type="text" value="" placeholder="Sending_date" class="dateInput"></td>
                <td><button class="btn addSubscription">Add</button></td>
            </tr>
        </table>

    </section>

@endsection

@section('rightBar')
@endsection












