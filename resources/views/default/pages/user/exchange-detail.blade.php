@extends('default.main')
@section('content')
<div class="exchange-table-area">
    <div class="container-fluid">
        <div class="container-fluid">
            <form method="post" action="{{ route('user/refund') }}" id="formRefund">
                <div class="row">
                    @csrf
                    <div class="col-12 col-lg-12">
                        <div class="cart-title mt-50">
                            <h2>Chi tiết đổi hàng</h2>
                        </div>
                        <div class="login-title mt-15">
                            <div class="row">
                                <div class="col-6 col-md-3">
                                    <small class="text-primary">Mã đơn hàng</small>
                                    <p>#{{ $params['id'] }}</p>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small class="text-primary">Người đổi hàng</small>
                                    <p>{{ $refund['created_by'] }}</p>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small class="text-primary">Ngày đổi hàng</small>
                                    <p>{{ date('H:i:s d/m/Y', strtotime($refund['created'])) }}</p>
                                </div>
                                <div class="col-6 col-md-3">
                                    <small class="text-primary">Trạng thái</small>
                                    @php
                                        switch($refund['status']){
                                            case 'pending':
                                                $status = 'Chờ xác nhận đổi';
                                                break;
                                            case 'approved':
                                                $status = 'Đổi thành công';
                                                break;
                                        }
                                    @endphp
                                    <p>{{ $status }}</p>
                                </div>
                                <div class="col-12 col-md-12">
                                    <small class="text-primary">Lý do đổi hàng</small>
                                    
                                    <p style="text-transform: capitalize">{{ $refund['reason'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-9">
                                <div class="cart-table clearfix">
                                    <table class="table table-responsive" tabindex="1" style="overflow: scroll !important; outline: none; touch-action: none;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%">#</th>
                                                <th style="width: 45%">Từ</th>
                                                <th style="width: 45%">Sang</th>
                                                <th style="width: 5%">SL</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($refundDetails as $key => $value)
                                                @php
                                                    $id             = $value['id'];
                                                    $quantity       = $value['quantity'];
                                                    $newName        = $value['product_name'];
                                                    $newId          = $value['to_product'];
                                                    $newStyle       = $value['product_style'];
                                                    $newColor       = $value['to_color'];
                                                    $newSize        = $value['to_size'];
                                                    $newPicture     = asset('public/images/product/' . $value['product_name']) . '/' . $value['product_picture1'];
                                                @endphp
                                                @foreach($items as $keyCart => $valueCart)
                                                    @if($valueCart['product_id'] == $value['product_id'])
                                                        @php
                                                            $oldName        = $valueCart['product_name'];
                                                            $oldId          = $valueCart['product_id'];
                                                            $oldStyle       = $valueCart['product_style'];
                                                            $oldColor       = $value['color'];
                                                            $oldSize        = $value['size'];
                                                            $oldPicture     = $valueCart['product_name'];
                                                            $oldPicture     = asset('public/images/product/' . $valueCart['product_name']) . '/' . $valueCart['product_picture1'];
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-12 col-lg-4">
                                                                <a href="{{ route('shop/detail', ['id' => $oldId, 'name' => Str::slug($oldName)]) }}">
                                                                    <img width="120" src="{!! $oldPicture !!}" alt="">
                                                                </a>
                                                            </div>
                                                            <div class="col-12 col-lg-8 p-0">
                                                                <h4>{!! $oldName !!}</h4>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        Màu:
                                                                    </div>
                                                                    <div class="col-8">
                                                                        {!! $oldColor !!}
                                                                    </div>
                                                                    <div class="col-4">
                                                                        Size:
                                                                    </div>
                                                                    <div class="col-8">
                                                                        {!! $oldSize !!}
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="row">
                                                            <div class="col-12 col-lg-4">
                                                                <a href="{{ route('shop/detail', ['id' => $newId, 'name' => Str::slug($newName)]) }}">
                                                                    <img width="120" src="{!! $newPicture !!}" alt="">
                                                                </a>
                                                                
                                                            </div>
                                                            <div class="col-12 col-lg-8 p-0">
                                                                <h4>{!! $newName !!}</h4>
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        Màu:
                                                                    </div>
                                                                    <div class="col-8">
                                                                        {!! $newColor !!}
                                                                    </div>
                                                                    <div class="col-4">
                                                                        Size:
                                                                    </div>
                                                                    <div class="col-8">
                                                                        {!! $newSize !!}
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">{{ $quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>                            
                            <div class="col-12 col-lg-3">
                                <div class="cart-summary p-0 mt-0">
                                    <h4>Thông tin hóa đơn</h5>
                                        
                                    <ul class="summary-table">
                                        <li><span>Tạm tính:</span> <span id="subtotal">{{ number_format($refund['amount']) }}đ</span></li>
                                        <li><span>Vận chuyển:</span> <span id="shipping">Free</span></li>
                                        <li><span>Giảm giá:</span> <span id="discount">-0đ</span></li>
                                        <li><span>Thành viên:</span> <span id="member">-0đ</span></li>
                                        <li><span>Mã giảm:</span> <span id="voucher">-0đ</span></li>
                                        <hr style="height: 0.1px">
                                        <li><span>Tổng cộng:</span> <span name="total" id="total">{{ number_format($refund['amount']) }}đ</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
