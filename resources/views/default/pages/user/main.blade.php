@extends('default.main')
@section('content')
    <div class="artiz_product_area section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                        <!-- Total Products -->
                        @php
                            $userInfo = Auth::user();
                        @endphp
                        <div class="total-products">
                            <p>TÀI KHOẢN CỦA BẠN</p>
                            <h2 class="text-capitalize">{{ $title }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shop_sidebar_area">
                <div class="widget catagory">
                    <div class="catagories-menu">
                        <ul class="d-flex justify-content-center flex-wrap">
                            <li class="px-3 py-2" id="detail"><a href="{{ route('user/profile') }}">Thông tin</a></li>
                            <li class="px-3 py-2" id="password"><a href="{{ route('user/password') }}">Mật khẩu</a></li>
                            <li class="px-3 py-2" id="history"><a href="{{ route('user/history') }}">Lịch sử đơn</a></li>
                            <li class="px-3 py-2" id="tracking"><a href="{{ route('user/tracking') }}">Tìm đơn</a></li>
                            <li class="px-3 py-2" id="wishlist"><a href="{{ route('user/wishlist') }}">Yêu thích</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @yield('user')
        </div>
    </div>
    </div>
    
    <script>
        var element = document.getElementById('{{ $target }}').classList.add('active');
    </script>
   
@endsection
