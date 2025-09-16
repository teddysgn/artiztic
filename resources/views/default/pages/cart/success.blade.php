@extends('default.main')
@section('content')
<div class="login-table-area section-padding-100">
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-12 col-lg-12">
                <div class="login-title mt-50">
                    <img src="{{ asset('public/default/img/core-img/success.png') }}" style="width: 10%" class="mb-5" alt="">
                    <h2>Cảm ơn bạn đã mua hàng</h2>
                    <p>Artiz đã nhận được đơn hàng và bạn sẽ nhận được sản phẩm từ 2 - 4 ngày làm việc.</p>
                    <p>Mã đơn hàng của bạn là <strong><a href="{{ route('user/history-detail', ['id' => session('order_id')]) }}">#{{ session('order_id') }}</a></strong></p>
                    <p>Bạn có thể xem lại hóa đơn trong email của mình</p>
                    <p>Hoặc vào <a href="{{ route('user/history') }}"><u>'Lịch sử đơn'</u></a> trong <a href="{{ route('user') }}"><u>'Tài khoản'</u></a> của bạn</p>
                    <a href="{{ route('shop') }}" class="d-flex justify-content-center">
                        <button type="button" class="btn artiz-btn" style="width: 25%">Tiếp tục mua sắm</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
