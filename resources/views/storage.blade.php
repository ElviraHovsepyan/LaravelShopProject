
@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="themes/images/pageBanner.png" alt="New products" >
        <h4><span>Storage</span></h4>
    </section>
    <section class="main-content">
        <table class="table">
            <tr>
                <th>Product_name</th>
                <th>Product_id</th>
                <th>Quantity</th>
                <th>Edit</th>
            </tr>
            @foreach($storage as $product)
                <tr>
                    <td><span>{{ $product['product']->name }}</span></td>
                    <td><span class="idSpan">{{ $product->product_id }}</span></td>
                    <td><input type="text" value="{{ $product->quantity }}" class="quantity"></td>
                    <td><button class="btn editStorage">Edit</button></td>
                </tr>
            @endforeach
        </table>
    </section>
@endsection

@section('rightBar')
@endsection












