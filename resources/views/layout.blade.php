
@section('header')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>lshop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!--[if ie]><meta content='IE=8' http-equiv='X-UA-Compatible'/><![endif]-->
    <!-- bootstrap -->
    <link href="/public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/public/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/public/themes/css/bootstrappage.css" rel="stylesheet"/>

    <!-- global styles -->
    <link href="/public/themes/css/flexslider.css" rel="stylesheet"/>
    <link href="/public/themes/css/main.css" rel="stylesheet"/>
    <link href="/public/css/style.css" rel="stylesheet"/>
    <!-- scripts -->
    <script src="/public/themes/js/jquery-1.7.2.min.js"></script>
    <script src="/public/bootstrap/js/bootstrap.min.js"></script>
    <script src="/public/themes/js/superfish.js"></script>
    <script src="/public/themes/js/jquery.scrolltotop.js"></script>
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="top-bar" class="container">
    <div class="row">
        <div class="span4">
            <form method="POST" class="search_form" action="{{ route('searchAll') }}">
                {{ csrf_field() }}
                <input name = 'searchName' value = "@if(!empty($key)){{ $key }} @endif" type="text" class="input-block-level search-query" Placeholder="eg. T-sirt" style="color:black; position:relative;">
                <div class="showResults"></div>

            </form>


        </div>
        <div class="span8">
            <div class="account pull-right">

                <ul class="user-menu">
                    {{--<li><a href="#">My Account</a></li>--}}

                    @if(Auth::guest())

                        <li><a href="{{ route('registerView') }}">Login / Register</a></li>

                    @else
                        @if(Auth::user()->role==1)
                            <li>Hello Admin!</li>
                            <li><a href="{{ route('admin') }}">Admin Page</a></li>

                        @else
                            <li>Hello {{Auth::user()->name}}</li>
                        @endif

                        <li><a href="{{ route('logout') }}">Log Out</a></li>
                        <li><a href="{{ route('token') }}">Get Token</a></li>
                        <li><a href="{{ route('index') }}">Google API</a></li>

                    @endif
                </ul>

            </div>
        </div>
    </div>
</div>
<div id="wrapper" class="container">


 @show


 @include('navbar')

 @yield('content')

 @section('rightBar')


        <div class="span3 col">
            <div class="block">
                <ul class="nav nav-list">
                    <li class="nav-header">SUB CATEGORIES</li>
                    <li><a href="#">Nullam semper elementum</a></li>
                    <li class="active"><a href="#">Phasellus ultricies</a></li>
                    <li><a href="#">Donec laoreet dui</a></li>
                    <li><a href="#">Nullam semper elementum</a></li>
                    <li><a href="#">Phasellus ultricies</a></li>
                    <li><a href="#">Donec laoreet dui</a></li>
                </ul>
                <br/>
                <ul class="nav nav-list below">
                    <li class="nav-header">MANUFACTURES</li>
                    <li><a href="#">Adidas</a></li>
                    <li><a href="#">Nike</a></li>
                    <li><a href="#">Dunlop</a></li>
                    <li><a href="#">Yamaha</a></li>
                </ul>
            </div>
            <div class="block">
                <h4 class="title">
                    <span class="pull-left"><span class="text">Randomize</span></span>
                    <span class="pull-right">
									<a class="left button" href="#myCarousel" data-slide="prev"></a><a class="right button" href="#myCarousel" data-slide="next"></a>
								</span>
                </h4>
                <div id="myCarousel" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="active item">
                            <ul class="thumbnails listing-products">
                                <li class="span3">
                                    <div class="product-box">
                                        <span class="sale_tag"></span>
                                        <img alt="" src="/public/themes/images/ladies/1.jpg"><br/>
                                        <a href="product_detail.html" class="title">Fusce id molestie massa</a><br/>
                                        <a href="#" class="category">Suspendisse aliquet</a>
                                        <p class="price">$261</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="item">
                            <ul class="thumbnails listing-products">
                                <li class="span3">
                                    <div class="product-box">
                                        <img alt="" src="/public/themes/images/ladies/2.jpg"><br/>
                                        <a href="product_detail.html" class="title">Tempor sem sodales</a><br/>
                                        <a href="#" class="category">Urna nec lectus mollis</a>
                                        <p class="price">$134</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="block">
                <h4 class="title"><strong>Best</strong> Seller</h4>
                <ul class="small-product">
                    <li>
                        <a href="#" title="Praesent tempor sem sodales">
                            <img src="/public/themes/images/ladies/3.jpg" alt="Praesent tempor sem sodales">
                        </a>
                        <a href="#">Praesent tempor sem</a>
                    </li>
                    <li>
                        <a href="#" title="Luctus quam ultrices rutrum">
                            <img src="/public/themes/images/ladies/4.jpg" alt="Luctus quam ultrices rutrum">
                        </a>
                        <a href="#">Luctus quam ultrices rutrum</a>
                    </li>
                    <li>
                        <a href="#" title="Fusce id molestie massa">
                            <img src="/public/themes/images/ladies/5.jpg" alt="Fusce id molestie massa">
                        </a>
                        <a href="#">Fusce id molestie massa</a>
                    </li>
                </ul>
            </div>
        </div>



</div>

</section>
@show

@section('footer')


        <section id="footer-bar">
            <div class="row">
                <div class="span3">
                    <h4>Navigation</h4>
                    <ul class="nav">
                        <li><a href="./index.html">Homepage</a></li>
                        <li><a href="./about.html">About Us</a></li>
                        <li><a href="./contact.html">Contac Us</a></li>
                        <li><a href="./cart.html">Your Cart</a></li>
                        <li><a href="./register.html">Login</a></li>
                    </ul>
                </div>
                <div class="span4">
                    <h4>My Account</h4>
                    <ul class="nav">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Order History</a></li>
                        <li><a href="#">Wish List</a></li>
                        <li><a href="#">Newsletter</a></li>
                    </ul>
                </div>
                <div class="span5">
                    <p class="logo"><img src="/public/themes/images/logo.png" class="site_logo" alt=""></p>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. the  Lorem Ipsum has been the industry's standard dummy text ever since the you.</p>
                    <br/>
                    <span class="social_icons">
							<a class="facebook" href="#">Facebook</a>
							<a class="twitter" href="#">Twitter</a>
							<a class="skype" href="#">Skype</a>
							<a class="vimeo" href="#">Vimeo</a>
						</span>
                </div>
            </div>
        </section>
        <section id="copyright">
            <span>Copyright 2013 bootstrappage template  All right reserved.</span>
        </section>
</div>
<script src="/public/themes/js/common.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="/public/js/script.js"></script>

@show

</body>
</html>


