

@extends('default.main')
@section('content')
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>CHÍNH SÁCH BÁN HÀNG</h2>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <strong class="text-primary">VẤN ĐỀ THƯỜNG GẶP</strong>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-6 col-lg-3 text-center">
                                                <a href="{{ route('customer-service/exchanges') }}">
                                                    <img width="120" src="{{ asset('public/default/img/core-img/exchange.png') }}" alt="">
                                                    </br>
                                                    <p>Đổi Trả</p>
                                                </a>
                                            </div>
                                            <div class="col-6 col-lg-3 text-center">
                                                <a href="{{ route('customer-service/information-collection') }}">
                                                    <img width="120" src="{{ asset('public/default/img/core-img/information.png') }}" alt="">
                                                    </br>
                                                    <p>Thông tin</p>
                                                </a>
                                            </div>
                                            <div class="col-6 col-lg-3 text-center">
                                                <a href="{{ route('customer-service/payments') }}">
                                                    <img width="120" src="{{ asset('public/default/img/core-img/payment.png') }}" alt="">
                                                    </br>
                                                    <p>Thanh toán</p>
                                                </a>
                                            </div>
                                            <div class="col-6 col-lg-3 text-center">
                                                <a href="{{ route('customer-service/shipping') }}">
                                                    <img width="120" src="{{ asset('public/default/img/core-img/shipping.png') }}" alt="">
                                                    </br>
                                                    <p>Giao hàng</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 my-1">
                                        <strong class="text-primary">LIÊN HỆ</strong>
                                    </div>
                                    <div class="col-12 my-1">
                                        <div class="row" style="justify-content: space-evenly">
                                            <div class="col-12 col-lg-3 text-center p-3" style="background: rgb(245, 245, 245)">
                                                <div>
                                                    <img width="50" src="{{ asset('public/default/img/core-img/chat.png') }}" alt="">
                                                    </br>
                                                    <p class="m-0"><small>Nhắn tin</small></p>
                                                    <p class="m-0"><small>T2 - CN: 8AM - 7PM</small></p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 text-center p-3" style="background: rgb(245, 245, 245)">
                                                <div >
                                                    <img width="50" src="{{ asset('public/default/img/core-img/email.png') }}" alt="">
                                                    </br>
                                                    <p class="m-0"><small>Gửi mail</small></p>
                                                    <p class="m-0"><small><a style="text-decoration: underline" href="mailto: letter@artiz.store">Nhấn vào đây</a> hoặc gửi mail đến letter@artiz.store</small></p>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-3 text-center p-3" style="background: rgb(245, 245, 245)">
                                                <div>
                                                    <img width="50" src="{{ asset('public/default/img/core-img/hotline.png') }}" alt="">
                                                    </br>
                                                    <p class="m-0"><small>Hotline</small></p>
                                                    <p class="m-0"><small><a style="text-decoration: underline" href="tel: 0903838081">Nhấn vào đây</a> hoặc gọi đến 0903838081</small></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-1">
                                        <small>Khi liên hệ với Artiz, bạn đồng ý với Artiz rằng có thể sử dụng thông tin của bạn như được mô tả trong <a href="{{ asset('public/default/img/core-img/information.png') }}"><u>Chính sách bảo mật</u></a> và <a href="{{ route('customer-service/term-of-use') }}"><u>Điều khoản dịch vụ</u></a> của Artiz.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 my-1">
                                        <strong class="text-primary">KHÁC</strong>
                                    </div>
                                    <div class="col-12 my-1">
                                        <div class="row">
                                            <div class="container-fluid">
                                                <div class="col-12 pl-4">
                                                    <a href="{{ route('customer-service/term-of-use') }}"><p class="m-0"><u>Điều khoản của Artiz</u></p></a>
                                                    <a href="{{ route('customer-service/frequently-asked-questions') }}"><p class="m-0"><u>Hỏi đáp - FAQs</u></p></a>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection