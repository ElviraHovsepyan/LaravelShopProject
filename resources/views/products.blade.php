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
                    @foreach($products as $key => $value)


                    <li class="span3">
                        <div class="product-box">
                            <span class="sale_tag"></span>
                            <a href="{{ route('productDetails',['id'=>$products[$key]['id']]) }}"><img alt="" src="/public/themes/images/prPics/{{ $products[$key]['pic'] }}.jpg"></a><br/>
                            <a href="#" class="title">{{ $products[$key]['name'] }}</a><br/>
                            <p class="price"> ${{ $products[$key]['price'] }}</p>
                        </div>
                    </li>

                    @endforeach

                </ul>
                <hr>
                <div class="pagination pagination-small pagination-centered">
                    {{--<ul>--}}
                        {{--<li><a href="#">Prev</a></li>--}}
                        {{--@for($x = 0;$x < $pages; $x++)--}}

                            {{--<li class="oneButton"><a href="{{ route('products',['page'=>$x]) }}">{{ $x+1 }}</a></li>--}}

                        {{--@endfor--}}
                        {{--<li><a href="#">Next</a></li>--}}
                    {{--</ul>--}}
                </div>
            </div>

@endsection




