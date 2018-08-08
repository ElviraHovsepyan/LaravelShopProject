@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="/public/themes/images/pageBanner.png" alt="New products" >
        <h4><span>Our products</span></h4>
    </section>

    <section class="main-content">

        <div class="row">
            <div class="span9">
                <ul class="thumbnails listing-products">
                    @foreach($products as $product)


                    <li class="span3">
                        <div class="product-box">
                            <span class="sale_tag"></span>
                            <a href="{{ route('productDetails',['id'=>$product->id]) }}"><img alt="" src="/public/themes/images/prPics/{{ $product->pic }}.jpg"></a><br/>
                            <a href="#" class="title">{{ $product->name }}</a><br/>
                            <p class="price">{{ $product->price }}</p>
                        </div>
                    </li>

                    @endforeach


                </ul>
                <hr>
                <div class="pagination pagination-small pagination-centered">
                    {{--<ul>--}}
                        {{--<li><a href="#">Prev</a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">Next</a></li>--}}
                    {{--</ul>--}}
                </div>
            </div>

@endsection




