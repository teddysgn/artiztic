<footer class="footer_area clearfix">
    <div class="container">
        <div class="row align-items-center">
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-2">
                <div class="single_widget_area">
                    <!-- Logo -->
                    <div class="footer-logo mr-50">
                        <a href="{{ route('home') }}"><img width="120" src="{{ asset('public/default/img/logo/logo.png') }}" alt=""></a>
                    </div>
                    <!-- Copywrite Text -->
                    <p class="copywrite text-primary">                    
                        &copy;2024 <a class="text-primary" href="{{ route('home') }}">artiz.store</a>
                    </p>
                </div>
            </div>
            <!-- Single Widget Area -->
            <div class="col-12 col-lg-10">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <strong class="text-primary">TÀI KHOẢN</strong>
                        <p class="mb-0"><a href="{{ route('user') }}">Tài khoản Artiz</a></p>
                        <p class="mb-0"><a href="">Ưu đãi & Đặc quyền</a></p>
                        <p class="mb-0"><a href="{{ route('user/tracking') }}">Kiểm tra đơn hàng</a></p>
                        <p><a href="{{ route('user/history') }}">Lịch sử đơn hàng</a></p>
                    </div>
                    <div class="col-6 col-lg-3">
                        <strong class="text-primary">SẢN PHẨM</strong>
                        <p class="mb-0"><a href="{{ route('shop') }}">Tất cả sản phẩm</a></p>
                        <p class="mb-0"><a href="{{ route('new-in') }}">Sản phẩm mới</a></p>
                        <p class="mb-0"><a href="{{ route('sales') }}">Sản phẩm giảm giá</a></p>
                        <p><a href="{{ route('collection') }}">Bộ sưu tập</a></p>
                    </div>
                    <div class="col-6 col-lg-3">
                        <strong class="text-primary">DỊCH VỤ</strong>
                        <p class="mb-0"><a href="{{ route('customer-service/frequently-asked-questions') }}">Hỏi đáp - FAQs</a></p>
                        <p><a href="{{ route('customer-service') }}">Trung tâm dịch vụ</a></p>

                        <strong class="text-primary">ĐIỀU KHOẢN</strong>
                        <p><a href="{{ route('customer-service/term-of-use') }}">Điều khoản sử dụng</a></p>
                    </div>
                    <div class="col-6 col-lg-3">
                        <strong class="text-primary">CHÍNH SÁCH</strong>
                        <p class="mb-0"><a href="{{ route('customer-service/information-collection') }}">Chính sách bảo mật</a></p>
                        <p class="mb-0"><a href="{{ route('customer-service/shipping') }}">Chính sách giao hàng</a></p>
                        <p class="mb-0"><a href="{{ route('customer-service/exchanges') }}">Chính sách đổi trả</a></p>
                        <p><a href="{{ route('customer-service/payments') }}">Chính sách thanh toán</a></p>
                    </div>
                </div>
                {{-- <div class="single_widget_area">
                    <!-- Footer Menu -->
                    <div class="footer_menu">
                        <nav class="navbar navbar-expand-lg justify-content-end">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#footerNavContent" aria-controls="footerNavContent" aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                            <div class="collapse navbar-collapse" id="footerNavContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item active">
                                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('about') }}">About</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('customer-service') }}">Customer Service</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</footer>