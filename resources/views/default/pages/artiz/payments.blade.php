

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
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">1. THANH TOÁN TRẢ SAU (COD)</strong>
                                        <div class="container-fluid">
                                            <small>Khách hàng sẽ thanh toán trực tiếp với nhân viên giao hàng ngay khi nhận hàng.</small>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">2. THANH TOÁN CHUYỂN KHOẢN</strong>
                                        <div class="container-fluid">
                                            <small>Khách hàng sẽ thanh toán chuyển khoản qua số tài khoản</small>
                                            <div class="container-fluid">
                                                <div class="container-fluid">
                                                    <ul>
                                                        <li><small><span class="text-primary">Ngân hàng:</span> Techcombank</small></li>
                                                        <li><small><span class="text-primary">Số tài khoản:</span> 012345678</small></li>
                                                        <li><small><span class="text-primary">Tên tài khoản:</span> Artiz Store</small></li>
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