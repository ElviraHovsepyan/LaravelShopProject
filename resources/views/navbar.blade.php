

<section class="navbar main-menu">
    <div class="navbar-inner main-menu">
        <a href="{{ route('products') }}" class="logo pull-left"><img src="/public/themes/images/logo.png" class="site_logo" alt=""></a>
        <nav id="menu" class="pull-right">
            <ul>
                @if(Auth::user())
                    <li><a href="{{ route('addNewItem') }}">Add new item</a> </li>
                @endif

                @foreach($cats as $key=>$value)
                <li><a href="#">{{ $cats[$key]->cat_name }}</a>
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