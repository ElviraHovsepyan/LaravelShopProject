@extends('layout')

@section('content')
<section class="header_text sub">
    <img class="pageBanner" src="/public/themes/images/pageBanner.png" alt="New products" >
    <h4><span>Our products</span></h4>
</section>

<section class="main-content">

    <div class="row">
        <div class="span9">
            <ul class="thumbnails listing-products main-products-page">
                @if(!empty($products))
                     @foreach($products as $product)
                         <li class="span3">
                             <div class="product-box">
                                 <span class="sale_tag"></span>
                                 <a href="{{ route('productDetails',['id'=>$product->id]) }}"><img alt="" src="/public/themes/images/prPics/{{ $product->pic }}.jpg"></a><br/>
                                 <a href="#" class="title">{{ $product->name }}</a><br/>
                                 <p class="price"> ${{ $product->price }}</p>
                             </div>
                         </li>
                     @endforeach
                @else
                    <h3 style="margin-left: 30px">No Results</h3>
                @endif
            </ul>
            <hr>
        </div>

@endsection




