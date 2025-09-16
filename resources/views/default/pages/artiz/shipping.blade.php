

@extends('default.main')
@section('content')<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <div class="login-table-area section-padding-100 pt-0">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-12 col-lg-12">
                    <div class="checkout_details_area mt-50 clearfix">
                        <div class="login-title">
                            <h2>THỜI GIAN & CHI PHÍ GIAO HÀNG</h2>
                        </div>
                        <div class="row my-5">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">1. THỜI GIAN</strong>
                                        <div class="container-fluid">
                                            <div class="container-fluid">
                                                <ul>
                                                    <li><p><span class="text-primary">Nội thành Sài Gòn:</span> 1 - 2 ngày làm việc.</p></li>
                                                    <li><p><span class="text-primary">Nội thành Sài Gòn:</span> 2 - 3 ngày làm việc.</p></li>
                                                    <li><p><span class="text-primary">Khu vực khác:</span> 4 - 5 ngày làm việc.</p></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-5">
                                        <strong class="text-primary">2. CHI PHÍ</strong>
                                        <div class="container-fluid">
                                            <div class="container-fluid">
                                                <ul>
                                                    <li><p><span class="text-primary">Miễn phí cho mọi đơn hàng.</span></p></li>
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