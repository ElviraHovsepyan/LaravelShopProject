
@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
        <h4><span>Promocodes</span></h4>
    </section>
    <section class="main-content">
        <table class="table">
            <tr>
                <th>Promocode</th>
                <th>Is_Active</th>
                <th>Discount</th>
                <th>Period(months)</th>
                <th>Edit</th>
            </tr>
            @foreach($promocodes as $promocode)
                <tr>
                    <td><input type="text" value="{{ $promocode->promocode }}" class="nameInput"></td>
                    <td><input type="text" value="{{ $promocode->is_active }}" class="activeInput"></td>
                    <td><input type="text" value="{{ $promocode->discount }}" class="discInput"></td>
                    <td><input type="text" value="{{ $promocode->period_months }}" class="periodInput"></td>
                    <td><button class="btn editPromocode">Edit</button></td>
                </tr>
            @endforeach
            <tr>
                <td><input type="text" value="" placeholder="Promocode" class="nameInput"></td>
                <td><input type="text" value="" placeholder="Is active" class="activeInput"></td>
                <td><input type="text" value="" placeholder="Discount" class="discInput"></td>
                <td><input type="text" value="" placeholder="Period(months)" class="periodInput"></td>
                <td><button class="btn addPromocode">Add</button></td>
            </tr>
        </table>

    </section>

@endsection

@section('rightBar')
@endsection












