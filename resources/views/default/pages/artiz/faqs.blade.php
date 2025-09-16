

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>NHỮNG CÂU HỎI THƯỜNG GẶP</h2>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <a href="{{ route('customer-service/frequently-asked-questions/shipping') }}"><p class="text-primary font-weight-bold">1. Dịch vụ giao hàng của Artiz</p></a>
                                        <a href="{{ route('customer-service/frequently-asked-questions/exchange') }}"><p class="text-primary font-weight-bold">2. Đổi hàng & Trả hàng</p></a>
                                        <a href="{{ route('customer-service/frequently-asked-questions/payments') }}"><p class="text-primary font-weight-bold">3. Phương thức thanh toán</p></a>
                                        <a href="{{ route('customer-service/frequently-asked-questions/information') }}"><p class="text-primary font-weight-bold">4. Tài khoản và Đơn hàng</p></a>
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