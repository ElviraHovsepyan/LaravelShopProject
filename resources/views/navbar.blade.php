
<section class="navbar main-menu">
    <div class="navbar-inner main-menu">
        <a href="{{ route('products') }}" class="logo pull-left"><img src="/public/themes/images/logo.png" class="site_logo" alt=""></a>
        <nav id="menu" class="pull-right">
            <ul>
                @if(Auth::user() && Auth::user()->role==1)
                    <li><a href="#">Admin Pages</a>
                        <ul>
                            <li><a href="{{ route('admin') }}">Block Users</a></li>
                            <li><a href="{{ route('promocodes') }}">Promocodes</a></li>
                            <li><a href="{{ route('storage') }}">Storage</a></li>
                            <li><a href="{{ route('sale') }}">Best Sellers</a></li>
                            <li><a href="{{ route('subscriptions') }}">Subscriptions</a></li>

                        </ul>
                    </li>
                @endif
                @if(Auth::user())
                    <li class="buyProducts onePurchase"><a href="#">Buy</a></li>
                    <li><a href="{{ route('addNewItem') }}">Add new item</a> </li>
                @endif

                @foreach($cats as $key=>$value)
                <li><a href="{{ route('category',['id'=>$value->id ]) }}">{{ $value->cat_name }}</a>
                    <ul>
                        @foreach($value->subcat as $k=>$v)

                            <li><a href="{{ route('subCategory', ['id'=>$v->id]) }}">{{ $v->subcat_name }}</a></li>

                        @endforeach
                    </ul>
                </li>
                @endforeach

            </ul>
        </nav>
    </div>
</section>