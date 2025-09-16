<div class="mobile-nav">
    <div class="artiz-navbar-brand">
        <a href="{{ route('home') }}"><img src="{{ asset('public/default/img/logo/logo.png') }}" alt=""></a>
    </div>
    <div class="artiz-navbar-toggler">
        <span></span><span></span><span></span>
    </div>
</div>
<header class="header-area clearfix custom-nav" id="top">
        <div class="nav-close">
            <i class="fa fa-close" aria-hidden="true"></i>
        </div>
        <div class="logo">
            <a href="{{ route('home') }}"><img src="{{ asset('public/default/img/logo/logo.png') }}"
                    alt=""></a>
        </div>
        <nav class="artiz-nav">
            <ul>
                <li id="home"><a href="{{ route('home') }}">Trang chủ</a></li>
                <li id="shop"><a href="{{ route('shop') }}">Sản phẩm</a></li>
                @if($active == 'shop')
                    @include('default.template.accordion')
                @endif
                <li id="shop-by"><a href="{{ route('shop-by') }}">Shop By</a></li>
                <li id="sales"><a href="{{ route('sales') }}">Sales</a></li>
                <li id="new-in"><a href="{{ route('new-in') }}">New In</a></li>
                <li id="collection"><a href="{{ route('collections') }}">Bộ sưu tập</a></li>
                <li id="news"><a href="{{ route('home/news') }}">Tin tức</a></li>
            </ul>
        </nav>
        <hr style="width: 150px">
        <nav class="artiz-nav">
            <ul>
                <li id="cart">
                    <div class="d-flex align-items-center">
                        <box-icon name='cart'></box-icon>
                        @php
                            $count = Cart::count() > 0 ? Cart::count() : 0;
                        @endphp
                        <a style="margin: 5px 0 0 10px" href="{{ route('user/cart') }}" class="cart-nav">GIỎ HÀNG <span id="total-cart">({{ $count }})</span></a>
                    </div>
                </li>
              
                @if(Auth::check())
                    <li>
                        <div class="d-flex align-items-center">
                            @if(Auth::user()->level == 'admin')
                                <box-icon name='universal-access'></box-icon>       
                                <a style="margin: 5px 0 0 10px" id="admin" href="{{ route('admin') }}">Admin</a>
                            @endif
                            
                        </div>
                    </li>

                    <li id="user">
                        <div class="d-flex align-items-center">
                            <box-icon name='user'></box-icon>
                            <a style="margin: 5px 0 0 10px" href="{{ route('user/profile') }}">TÀI KHOẢN</a>
                        </div>
                    </li>

                    <li id="favorite">
                        <div class="d-flex align-items-center">
                            <box-icon name='heart'></box-icon>
                            <a style="margin: 5px 0 0 10px" href="{{ route('user/wishlist') }}" class="fav-nav">YÊU THÍCH</a>
                        </div>
                    </li>
                @endif
                <li id="login">
                    <div class="d-flex align-items-center">
                        @if(Auth::check())
                            <box-icon name='log-out-circle'></box-icon>
                            <a style="margin: 5px 0 0 10px" href="{{ route('auth/logout') }}">ĐĂNG XUẤT</a>
                        @else
                            <box-icon name='user'></box-icon>
                            <a style="margin: 5px 0 0 10px" href="{{ route('auth/login') }}">ĐĂNG NHẬP</a>
                        @endif
                    </div>
                </li>
            </ul>
        </nav>
</header>

