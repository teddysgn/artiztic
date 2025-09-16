

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>PHƯƠNG THỨC THANH TOÁN</h2>
                            <p><a href="{{ route('customer-service') }}">Dịch vụ khách hàng</a> &#8725; <a href="{{ route('customer-service/frequently-asked-questions') }}">FAQs</a> &#8725; <a class="text-primary" href="{{ route('customer-service/frequently-asked-questions/payments') }}">Phương thức thanh toán</a></p>
                        </div>
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Artiz chấp nhận những hình thức thanh toán nào?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Hiện tại bạn có thể thanh toán bằng cách <span class="text-primary"><u>Chuyển khoản ngân hàng</u></span> hoặc <span class="text-primary"><u>Thanh toán khi nhận hàng (COD)</u></span>.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Làm thế nào để tôi nhận được mã khuyến mãi?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Artiz sẽ cung cấp các mã khuyến mãi đối với những khách hàng thành viên thông qua email cá nhân khi đăng ký tài khoản.</small></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <p><small class="font-weight-bold">Hỏi:<span class="text-primary"> Tôi có thể sử dụng nhiều hơn một mã khuyến mãi cho một đơn hàng không?</span></small></p>
                                                <p><small class="font-weight-bold">Đáp:</small></p>
                                                <div class="container-fluid">
                                                    <div class="container-fluid">
                                                        <ul>
                                                            <li><small>Mỗi một đơn hàng chỉ được phép áp dụng 1 mã giảm giá.</small></li>
                                                        </ul>
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
    </div>
<style>
    .checkout_details_area li {
        list-style: disc !important;
    }

    .checkout_details_area p {
        margin-bottom: 0;
        color: black;
    }
</style>
@endsection