
@extends('layout')

@section('content')
    <section class="header_text sub">
        <img class="pageBanner" src="/public/themes/images/pageBanner.png" alt="New products" >
        <h4><span>Product Details</span></h4>
    </section>
    <section class="main-content">
        <div class="row">
            <div class="span9">
                <div class="row">
                    <div class="span4">
                        <a href="/public/themes/images/ladies/1.jpg" class="thumbnail" data-fancybox-group="group1" title="Description 1"><img alt="" src="/public/themes/images/prPics/{{ $pr['pic'] }}.jpg"></a>
                        <ul class="thumbnails small">

                        </ul>
                    </div>
                    <div class="span5">
                        <address>
                            {{--<strong>Brand:</strong> <span>Apple</span><br>--}}
                            <strong>Product Name:</strong> <span>{{ $pr['name'] }}</span><br>
                            <strong>Reward Points:</strong> <span>0</span><br>
                            <strong>Availability:</strong> <span>Out Of Stock</span><br>
                        </address>
                        <h4><strong>Price:
                                @if(Auth::user() && $discount!=1)
                                    ${{ ($pr['price'])-($pr['price'])*$discount }}
                                @else
                                    ${{ $pr['price'] }}
                                @endif
                            </strong></h4>
                    </div>
                    <div class="span5">
                        <form class="form-inline">
                            <label class="checkbox">
                                <input type="checkbox" value=""> Option one is this and that
                            </label>
                            <br/>
                            <label class="checkbox">
                                <input type="checkbox" value=""> Be sure to include why it's great
                            </label><br><br>
                            <p>Available: {{ $pr['storage']->quantity }}</p>
                            @if(Auth::user())
                            <a href="{{ route('updateView',['uId'=>$pr['id']]) }}"><button class="btn btn-inverse" type="button">----Edit----</button></a><br><br>
                            <a href="{{ route('deleteItem',['prId'=>$pr['id']]) }}"><button class="btn btn-inverse" type="button">DELETE</button></a><br><br>
                            <button class="btn btn-inverse addButton" type="button" productId = "{{ $pr['id'] }}">Add</button>
                            <input type="number" id="quantity" name="quantity" min="1" max="{{ $pr['storage']->quantity }}" step="1" value="1">

                            @endif
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="span9">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a href="#home">Description</a></li>
                            <li class=""><a href="#profile">Additional Information</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="home">{{ $pr['info'] }}</div>
                            <div class="tab-pane" id="profile">
                                <table class="table table-striped shop_attributes">
                                    <tbody>
                                    <tr class="">
                                        <th>Size</th>
                                        <td>Large, Medium, Small, X-Large</td>
                                    </tr>
                                    <tr class="alt">
                                        <th>Colour</th>
                                        <td>Orange, Yellow</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="span9">
                        <br>
                        <h4 class="title">
                            <span class="pull-left"><span class="text"><strong>Related</strong> Products</span></span>
                            <span class="pull-right">
										<a class="left button" href="#myCarousel-1" data-slide="prev"></a><a class="right button" href="#myCarousel-1" data-slide="next"></a>
									</span>
                        </h4>
                        <div id="myCarousel-1" class="carousel slide">
                            <div class="carousel-inner">
                                <div class="active item">
                                    <ul class="thumbnails listing-products">
                                        <li class="span3">
                                            <div class="product-box">
                                                <span class="sale_tag"></span>
                                                <a href="product_detail.html"><img alt="" src="/public/themes/images/ladies/6.jpg"></a><br/>
                                                <a href="product_detail.html" class="title">Wuam ultrices rutrum</a><br/>
                                                <a href="#" class="category">Suspendisse aliquet</a>
                                                <p class="price">$341</p>
                                            </div>
                                        </li>
                                        <li class="span3">
                                            <div class="product-box">
                                                <span class="sale_tag"></span>
                                                <a href="product_detail.html"><img alt="" src="/public/themes/images/ladies/5.jpg"></a><br/>
                                                <a href="product_detail.html" class="title">Fusce id molestie massa</a><br/>
                                                <a href="#" class="category">Phasellus consequat</a>
                                                <p class="price">$341</p>
                                            </div>
                                        </li>
                                        <li class="span3">
                                            <div class="product-box">
                                                <a href="product_detail.html"><img alt="" src="/public/themes/images/ladies/4.jpg"></a><br/>
                                                <a href="product_detail.html" class="title">Praesent tempor sem</a><br/>
                                                <a href="#" class="category">Erat gravida</a>
                                                <p class="price">$28</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="item">
                                    <ul class="thumbnails listing-products">
                                        <li class="span3">
                                            <div class="product-box">
                                                <span class="sale_tag"></span>
                                                <a href="product_detail.html"><img alt="" src="/public/themes/images/ladies/1.jpg"></a><br/>
                                                <a href="product_detail.html" class="title">Fusce id molestie massa</a><br/>
                                                <a href="#" class="category">Phasellus consequat</a>
                                                <p class="price">$341</p>
                                            </div>
                                        </li>
                                        <li class="span3">
                                            <div class="product-box">
                                                <a href="product_detail.html"><img alt="" src="/public/themes/images/ladies/2.jpg"></a><br/>
                                                <a href="product_detail.html">Praesent tempor sem</a><br/>
                                                <a href="#" class="category">Erat gravida</a>
                                                <p class="price">$28</p>
                                            </div>
                                        </li>
                                        <li class="span3">
                                            <div class="product-box">
                                                <span class="sale_tag"></span>
                                                <a href="product_detail.html"><img alt="" src="/public/themes/images/ladies/3.jpg"></a><br/>
                                                <a href="product_detail.html" class="title">Wuam ultrices rutrum</a><br/>
                                                <a href="#" class="category">Suspendisse aliquet</a>
                                                <p class="price">$341</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection

@section('script')
                                        <script>
                                            $(function () {
                                                $('#myTab a:first').tab('show');
                                                $('#myTab a').click(function (e) {
                                                    e.preventDefault();
                                                    $(this).tab('show');
                                                })
                                            })
                                            $(document).ready(function() {
                                                $('.thumbnail').fancybox({
                                                    openEffect  : 'none',
                                                    closeEffect : 'none'
                                                });

                                                $('#myCarousel-2').carousel({
                                                    interval: 2500
                                                });
                                            });
                                        </script>
    @parent
    @show