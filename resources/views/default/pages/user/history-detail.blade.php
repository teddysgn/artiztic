@extends('default.pages.user.main')
@section('user')
    <hr style="height: 1.1px; background: transparent">
    <div class="cart-table-area ml-0">
        <div class="container-fluid">
            <div class="login-title mt-15">
                <h4>Thông tin đơn hàng</h4>
                <div class="row">
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Mã đơn hàng</small>
                        <p>#{{ $item['cart_id'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Người đặt hàng</small>
                        <p>{{ $item['fullname'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Ngày đặt hàng</small>
                        <p>{{ date('H:i:s d/m/Y', strtotime($item['created'])) }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Phương thức thanh toán</small>
                        @php
                            switch($item['payment_method']){
                                case 'cash on delivery':
                                    $paymentMethod = 'Thanh toán trả sau';
                                    break;
                                case 'mobile banking':
                                    $paymentMethod = 'Thanh toán chuyển khoản';
                                    break;
                            }
                        @endphp
                        <p style="text-transform: capitalize">{{ $paymentMethod }}</p>
                    </div>
                </div>
            </div>
            <div class="login-title mt-30">
                <h4>Thông tin giao hàng</h4>
                <div class="row">
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Họ tên</small>
                        <p>{{ $item['fullname'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Địa chỉ email</small>
                        <p>{{ $item['email'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Số điện thoại</small>
                        <p>{{ $item['phone'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Địa chỉ nhận hàng</small>
                        <p>{{ $item['address'] }}</p>
                    </div>
                </div>
            </div>
            <div class="login-title mt-30">
                <h4>Tiến trình đơn hàng</h4>
                <div class="row">
                    <div class="col-12">
                        <div id="bar-progress" class="row text-left">
                            @php
                                $statusValue    = [
                                    '1'     => [
                                        'name' => 'Chờ xác nhận',
                                        'detail' => 'Artiz đang xác nhận đơn hàng của bạn.',
                                    ],
                                    '2'     => [
                                        'name' => 'Đã xác nhận',
                                        'detail' => 'Đơn hàng của bạn đã được xác nhận.',
                                    ],
                                    '3'     => [
                                        'name' => 'Đang đói gói',
                                        'detail' => 'Đơn hàng của bạn đang được đóng gói và chuyển cho đơn vị vận chuyển.',
                                    ],
                                    '4'     => [
                                        'name' => 'Đang vận chuyển',
                                        'detail' => 'Đơn hàng của bạn đang trên đường tới.',
                                    ],
                                    '5'     => [
                                        'name' => 'Giao hàng thành công',
                                        'detail' => 'Đơn hàng đã được giao thành công.',
                                    ],
                                ];

                                $status = [
                                    'pending'   => [1],
                                    'approved'  => [1,2],
                                    'packaging' => [1,2,3],
                                    'shipping'  => [1,2,3,4],
                                    'delivered' => [1,2,3,4,5],
                                ];
                                foreach($status as $key => $value){                                    
                                    if($item['status'] == $key){
                                        $max = max($value);
                                        foreach($value as $valueProcess){
                                            foreach($statusValue as $keyRoot => $valueRoot){
                                                if($valueProcess == $keyRoot){
                                                    $activeStep = ($max == $keyRoot && $item['cancel'] == 'default' && $refund == null) ? 'step-active' : '';
                                                    $pending = $max + 1;
                                                    echo '<div class="col-12 my-3">
                                                        <div class="step '.$activeStep.' row">
                                                            <div class="col-3">
                                                                <span class="number-container">
                                                                    <span class="number">'.$keyRoot.'</span>
                                                                </span>
                                                            </div>
                                                            <div class="col-9">
                                                                <h5 class="sans-serif">'.$valueRoot['name'].'</h5>
                                                                <small>'.$valueRoot['detail'].'</small>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                    
                                                }
                                            }
                                        }
                                    }
                                }
                                if($item['cancel'] == 'pending'){
                                    echo '<div class="col-12 my-3">
                                            <div class="step step-active row">
                                                <div class="col-3">
                                                    <span class="number-container">
                                                        <span class="number">'.$pending.'</span>
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="sans-serif">Chờ xác nhận hủy</h5>
                                                    <small>Artiz đang xác nhận yêu cầu hủy đơn của bạn.</small></br>
                                                    <small>Người hủy: '.$item['cancel_by'].'.</small></br>
                                                    <small>Ngày hủy: '.date('H:i:s d/m/Y', strtotime($item['cancel_date'])).'.</small>
                                                </div>
                                            </div>
                                        </div>';
                                } else if($item['cancel'] == 'approved'){
                                    $approved = $pending + 1;
                                    echo '<div class="col-12 my-3">
                                            <div class="step row">
                                                <div class="col-3">
                                                    <span class="number-container">
                                                        <span class="number">'.$pending.'</span>
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="sans-serif">Chờ xác nhận hủy</h5>
                                                    <small>Artiz đang xác nhận yêu cầu hủy đơn của bạn.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 my-3">
                                            <div class="step step-active row">
                                                <div class="col-3">
                                                    <span class="number-container">
                                                        <span class="number">'.$approved.'</span>
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="sans-serif">Đã hủy</h5>
                                                    <small>Hủy hàng thành công.</small></br>
                                                    <small>Người hủy: '.$item['cancel_by'].'.</small></br>
                                                    <small>Ngày hủy: '.date('H:i:s d/m/Y', strtotime($item['cancel_date'])).'.</small></br>
                                                    <small>Lý do: '.$item['reason_cancel'].'</small></br>
                                                </div>
                                            </div>
                                        </div>';
                                } else if($item['cancel'] == 'deny') {
                                    $approved = $pending + 1;
                                    echo '<div class="col-12 my-3">
                                            <div class="step row">
                                                <div class="col-3">
                                                    <span class="number-container">
                                                        <span class="number">'.$pending.'</span>
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="sans-serif">Chờ xác nhận hủy</h5>
                                                    <small>Artiz đang xác nhận yêu cầu hủy đơn của bạn.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 my-3">
                                            <div class="step step-active row">
                                                <div class="col-3">
                                                    <span class="number-container">
                                                        <span class="number">'.$approved.'</span>
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="sans-serif">Từ chối hủy</h5>
                                                    <small>Yêu cầu hủy của bạn bị từ chối.</small></br>
                                                    <small>Người hủy: '.$item['cancel_by'].'.</small></br>
                                                    <small>Ngày hủy: '.date('H:i:s d/m/Y', strtotime($item['cancel_date'])).'.</small></br>
                                                    <small>Lý do: '.$item['reason_cancel'].'</small></br>
                                                </div>
                                            </div>
                                        </div>';
                                }

                                if(isset($refund['status']))
                                    if($refund['status'] == 'pending'){
                                        $linkExchangeDetail = route('user/exchange-detail', ['id' => $item['cart_id']]);
                                        echo '<div class="col-12 my-3">
                                                <div class="step step-active row">
                                                    <div class="col-3">
                                                        <span class="number-container">
                                                            <span class="number">6</span>
                                                        </span>
                                                    </div>
                                                    <div class="col-9">
                                                        <h5 class="sans-serif">Chờ xác nhận đổi</h5>
                                                        <small>Artiz đang xác nhận yêu cầu đổi hàng của bạn.</small></br>
                                                        <small>Người gửi: '.$refund['created_by'].'.</small></br>
                                                        <small>Ngày gửi: '.date('H:i:s d/m/Y', strtotime($refund['created'])).'.</small></br>
                                                        <small><a href="'. $linkExchangeDetail .'" class="text-primary"><u>Xem chi tiết</u></a></small>
                                                    </div>
                                                </div>
                                            </div>';
                                    } else {
                                        $linkExchangeDetail = route('user/exchange-detail', ['id' => $item['cart_id']]);
                                        echo '<div class="col-12 my-3">
                                                <div class="step row">
                                                    <div class="col-3">
                                                        <span class="number-container">
                                                            <span class="number">6</span>
                                                        </span>
                                                    </div>
                                                    <div class="col-9">
                                                        <h5 class="sans-serif">Chờ xác nhận đổi</h5>
                                                        <small>Artiz đang xác nhận yêu cầu đổi hàng của bạn.</small></br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 my-3">
                                                <div class="step step-active row">
                                                    <div class="col-3">
                                                        <span class="number-container">
                                                            <span class="number">7</span>
                                                        </span>
                                                    </div>
                                                    <div class="col-9">
                                                        <h5 class="sans-serif">Đổi thành công</h5>
                                                        <small>Yêu cầu đổi hàng của bạn đã được xác nhận.</small></br>
                                                        <small>Người gửi: '.$refund['created_by'].'.</small></br>
                                                        <small>Ngày gửi: '.date('H:i:s d/m/Y', strtotime($refund['created'])).'.</small></br>
                                                        <small><a href="'. $linkExchangeDetail .'" class="text-primary"><u>Xem chi tiết</u></a></small>
                                                    </div>
                                                </div>
                                            </div>';
                                    }
                            @endphp
                        </div>
                    </div>
                    @if(($item['status'] == 'pending' || $item['status'] == 'approved' || $item['status'] == 'packaging') && $item['cancel'] == 'default')
                        <div class="col-6" id="block-cancel-{{ $item['cart_id'] }}">
                            <p onclick="showPopupCancel('{{ $item['cart_id'] }}')" class="btn artiz-btn-black w-100" style="min-width: 0">Hủy đơn hàng</p>
                        </div>
                    @else
                        @if ($item['status'] == 'delivered' && $refund == null  && $item['cancel'] == 'default' && strtotime($item['modified']) - (time() - 7*24*3600) > 0)
                            <div class="col-6" id="block-cancel-{{ $item['cart_id'] }}">
                                <p onclick="showPopupRefund('{{ $item['cart_id'] }}')" class="btn artiz-btn-black w-100" style="min-width: 0">Đổi hàng</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <div class="login-title mt-30">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <h4>Thông tin sản phẩm</h4>
                        @foreach ($details as $key => $value)
                            @if ($value['identify'] == $item['cart_id'])
                                @php
                                    $picture = asset(
                                        'public/images/product/' .
                                            $value['product_name'] .
                                            '/' .
                                            $value['product_picture1'],
                                    );
                                    $link = route('shop/detail', [
                                        'id' => $value['product_id'],
                                        'name' => Str::slug($value['product_name']),
                                    ]);
                                @endphp
                                <div class="cart-table clearfix">
                                    <div class="row">
                                        <div class="col-5 col-lg-4">
                                            <a href="{{ $link }}">
                                                <img src="{{ $picture }}" alt="Product">
                                            </a>
                                        </div>
                                        <div class="col-7 col-lg-8">
                                            <div class="single_product_desc">
                                                <div class="product-meta-data" style="position: relative">
                                                    <div class="line"></div>
                                                    <a href="{{ $link }}">
                                                        <h5>{{ $value['product_name'] }}</h5>
                                                    </a>
                                                    <div class="row my-2">
                                                        <div class="col-4">
                                                            <p class="p-0 m-0">Đơn giá</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="quantity">
                                                                <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                    @if($value['discount'] > 0)
                                                                        <span class="text-danger">{{ number_format($value['price'] , 0, ',', '.') }}<span class="currency">đ</span></span>
                                                                        <del></br>{{ number_format($value['price'] / ((100 - $value['discount']) / 100), 0, ',', '.') }}<span class="currency">đ</span></del> <span class="text-danger"><small><i>(Giảm {{ $value['discount'] }}%)</i></small></span>
                                                                    @else
                                                                        {{ number_format($value['price'], 0, ',', '.') }}<span class="currency">đ</span>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-4">
                                                            <p class="p-0 m-0">Số lượng</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="quantity">
                                                                <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                    {{ $value['quantity'] }} </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-4">
                                                            <p class="p-0 m-0">Size</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="quantity">
                                                                <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                    {{ $value['size'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-4">
                                                            <p class="p-0 m-0">Màu</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="quantity">
                                                                <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                    {{ $value['color'] }} </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col-4">
                                                            <p class="p-0 m-0">Tổng cộng</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <div class="quantity">
                                                                <p class="p-0 m-0">
                                                                    @if($value['discount'] > 0)
                                                                    <span class="text-danger m-0">{{ number_format($value['quantity'] * $value['price'], 0, ',', '.') }}<span class="currency">đ</span></span>
                                                                        <del></br>{{ number_format(($value['price'] / ((100 - $value['discount']) / 100)) * $value['quantity'], 0, ',', '.') }}<span class="currency">đ</span></del>
                                                                    @else
                                                                        {{ number_format($value['price'] * $value['quantity'], 0, ',', '.') }} <span class="currency">đ</span>
                                                                    @endif
                                                                </p>
                                                                @if($value['discount'] > 0)
                                                                    <small style="color: #008080"><i>(Tiết kiệm {{ number_format(($value['discount']) / 100 * $value['quantity'] * ($value['price'] / ((100 - $value['discount']) / 100)), 0, ',', '.') }}<span class="currency">đ</span>)</i></small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="height: 0.1px; background: transparent">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="cart-summary p-0 mt-0">
                                    <h4>Thông tin hóa đơn</h4>
                                    <ul class="summary-table">
                                        <li><span>Tạm tính:</span> <span id="subtotal">{{ $item['subtotal'] }}<span class="currency">đ</span></span></li>
                                        <li><span>Phí vận chuyển:</span> <span>Miễn phi</span></li>
                                        <li><span>Giảm giá:</span> <span id="discount">-{{ $item['discount'] }}<span class="currency">đ</span></span></li>
                                        <li><span>Thành viên:</span> <span id="discount">-{{ $item['member'] }}<span class="currency">đ</span></span></li>
                                        <li><span>Mã giảm:</span> <span id="voucher">-{{ $item['coupon_value'] }}<span class="currency">đ</span></span></li>
                                        <hr style="height: 0.1px">
                                        <li><span>Tổng cộng:</span> <span name="total" id="total">{{ $item['total'] }}<span class="currency">đ</span></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
        <script>
         function showPopupCancel(id) {
            if($('.popup').hasClass("fade-out")){
                $('popup').remove();
            }
            var html = '';
            const myPopup = new Popup({
                id: "my-popup-" + id,
                hideTitle: true,
                title: "",
                content: ``,
                loadCallback: () => {
                    html += `<div style="overflow: hidden; text-align: left">
                                <h3 class="sans-serif text-primary">Hủy đơn #`+id+`</h3>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-1-`+id+`" class="form-check-input not-other" type="radio" name="reason_cancel" value="Expected delivery date has changed and the product is arriving at a later date." checked>
                                    <label for="reason-1-`+id+`" class="form-check-label not-other" style="font-size: 16px; margin-top: 1%">
                                        Expected delivery date has changed and the product is arriving at a later date.
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-2-`+id+`" class="form-check-input not-other" type="radio" name="reason_cancel" value="Product is being delivered to a wrong address(Customer’s mistake)">
                                    <label for="reason-2-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                        Product is being delivered to a wrong address(Customer’s mistake).
                                    </p>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-3-`+id+`" class="form-check-input not-other" type="radio" name="reason_cancel" value="Product is not required anymore.">
                                    <label for="reason-3-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                        Product is not required anymore.
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-4-`+id+`" class="form-check-input not-other" type="radio" name="reason_cancel" value="Cheaper alternative available for lesser price.">
                                    <label for="reason-4-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                        Cheaper alternative available for lesser price.
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-5-`+id+`" class="form-check-input not-other" type="radio" name="reason_cancel" value="The price of the product has fallen due to sales/discounts and customer wants to get it at a lesser price.">
                                    <label for="reason-5-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                        The price of the product has fallen due to sales/discounts and customer wants to get it at a lesser price.
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-6-`+id+`" class="form-check-input not-other" type="radio" name="reason_cancel" value="Bad review from friends/relatives after ordering the product.">
                                    <label for="reason-6-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                        Bad review from friends/relatives after ordering the product.
                                    </label>
                                </div>
                                <div class="form-check d-flex align-items-center">
                                    <input id="reason-7-`+id+`" class="form-check-input" type="radio" name="reason_cancel" value="Other">
                                    <label for="reason-7-`+id+`" class="form-check-label"  style="font-size: 16px; margin-top: 1%">
                                        Other
                                    </label>
                                </div>
                                <div class="form-group d-none" id="reason-other-`+id+`">
                                    <label class="form-check-label my-2" for="other-`+id+`" style="font-size: 16px">
                                        Enter the reason *
                                        </label>
                                    <textarea type="text" class="form-control" name="invoice" id="other-`+id+`"></textarea>
                                    <small class="text-danger" id="error-reason-`+id+`" style="font-size: 13.2px"></small>
                                </div>
                                    
                                <div class="row">
                                    <div class="col-6">
                                        <a class="btn artiz-btn w-100 mt-4 text-white popup-button" style="min-width: 0">Close</a>
                                    </div>
                                    <div class="col-6">
                                        <a class="btn artiz-btn-black w-100 mt-4 text-white popup-cancel position-relative btn-add-to-cart" style="min-width: 0">
                                            <span class="btn-state state-default">Gửi</span>
                                            <span class="btn-state state-adding">
                                                <span class="animation-ellipsis">
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                            </span>Đang gửi</span>
                                        </a>
                                    </div>
                                </div>
                            </div>`;
                    $('.popup-body').html(html);
                    const button = document.querySelector(".popup-button");
                    $('.popup-button').click(function () {
                        myPopup.hide();
                    });

                    $('#reason-7-'+id).click(function(){
                        $('#reason-other-'+id).removeClass('d-none');
                        $('#other-'+id).attr("required", true);
                    })

                    $('.not-other').click(function(){
                        $('#reason-other-'+id).addClass('d-none');
                        $('#other-'+id).removeAttr("required");
                        document.getElementById("error-reason-"+id).textContent = '';
                    })

                    $('#other-'+id).keyup(function(){
                        document.getElementById("error-reason-"+id).textContent = '';
                       if($(this).val() == ''){
                            document.getElementById("error-reason-"+id).textContent = 'Vui lòng nhập lý do!';
                       }
                    })

                    $('.popup-cancel').click(function () {
                        const CSS_ADDING = 'cart-adding';
                        var reason = $('input[name="reason_cancel"]:checked').val();
                        if($('#other-'+id).prop('required') == true){
                            if($('#other-'+id).val() == '') {
                                document.getElementById("error-reason-"+id).textContent = 'Vui lòng nhập lý do!';
                            } else {
                                $(this).addClass(CSS_ADDING);
                                reason = $('#other-'+id).val();
                                $.ajax({
                                    url: "{{ route('user/cancel') }}?id=" + id + '&reason_cancel=' + reason,
                                    type: "GET",
                                    dataType: 'json',
                                    success: function(response) {
                                        $('.popup-cancel').removeClass(CSS_ADDING);
                                        if($('.step').hasClass("step-active")){
                                            $('.step').removeClass("step-active");
                                        }
                                        $('#block-cancel-'+id).html('');
                                        $('#bar-progress').append(`<div class="col-12 my-3">
                                            <div class="step step-active row">
                                                <div class="col-3">
                                                    <span class="number-container">
                                                        <span class="number">{{ $max + 1 }}</span>
                                                    </span>
                                                </div>
                                                <div class="col-9">
                                                    <h5 class="sans-serif">Chờ xác nhận hủy</h5>
                                                    <small>Artiz đang xác nhận đơn hàng hủy của bạn.</small></br>
                                                    <small>Người hủy: `+response.user+`.</small></br>
                                                    <small>Ngày hủy: `+response.time+`.</small></br>
                                                    <small>Lý do: `+response.reason+`</small></br>
                                                </div>
                                            </div>
                                        </div>`);
                                       
                                        myPopup.hide();
                                    
                                    }
                                });
                            }
                        } else {
                            $(this).addClass(CSS_ADDING);
                            reason = $('input[name="reason_cancel"]:checked').val();
                            $.ajax({
                                url: "{{ route('user/cancel') }}?id=" + id + '&reason_cancel=' + reason,
                                type: "GET",
                                dataType: 'json',
                                success: function(response) {
                                    $('.popup-cancel').removeClass(CSS_ADDING);
                                    if($('.step').hasClass("step-active")){
                                        $('.step').removeClass("step-active");
                                    }
                                    $('#block-cancel-'+id).html('');
                                    $('#bar-progress').append(`<div class="col-12 my-3">
                                        <div class="step step-active row">
                                            <div class="col-3">
                                                <span class="number-container">
                                                    <span class="number">{{ $max + 1 }}</span>
                                                </span>
                                            </div>
                                            <div class="col-9">
                                                <h5 class="sans-serif">Chờ xác nhận hủy</h5>
                                                <small>Artiz đang xác nhận yêu cầu hủy của bạn.</small></br>
                                                <small>Người hủy: `+response.user+`.</small></br>
                                                <small>Ngày hủy: `+response.time+`.</small></br>
                                                <small>Lý do: `+response.reason+`</small></br>
                                            </div>
                                        </div>
                                    </div>`);
                                    
                                    myPopup.hide();
                                
                                }
                            });
                        }                  
                    });
                },
            });
            myPopup.show();
        }

        function showPopupRefund(id) {
                if($('.popup').hasClass("fade-out")){
                    $('.popup').remove();
                }
                var html = '';
                var data = [];
                var src = '{{ asset('public/images/product/') }}';
                const myPopup = new Popup({
                    id: "my-popup-" + id,
                    hideTitle: true,
                    title: "",
                    content: ``,
                    loadCallback: () => {
                        $.ajax({
                            method: "GET",
                            url: "{{ route('user/history-refund') }}?id=" + id,
                            dataType: 'json',
                            success: function(response) {
                                    html += `<div style="overflow: hidden; text-align: left">
                                        <h3 class="sans-serif text-primary">Exchanging #`+id+`</h3>
                                        <form method="post" action="{{ route('user/refund') }}" id="formRefund">
                                            @csrf
                                                <div class="row">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="cart-table clearfix">
                                                                <table class="table table-responsive" tabindex="1" style="overflow: hidden; outline: none; touch-action: none;">
                                                                    <thead>
                                                                        <tr>
                                                                            <th style="width: 5%">#</th>
                                                                            <th style="width: 12%"></th>
                                                                            <th style="width: 35%">Tên</th>
                                                                            <th style="width: 13%">Số lượng</th>
                                                                            <th style="width: 20%">Màu</th>
                                                                            <th style="width: 20%">Size</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>`;
                                                        for(var item of response.details){
                                                            var disabled = item.discount > 0 ? 'disabled' : '';
                                                            var title = item.discount > 0 ? 'Sản phẩm không hợp lệ' : '';
                                                            html += `<tr>
                                                                        <td>
                                                                            <div class="form-check">
                                                                                <input class="form-check-input check-product check-`+item.product_id+`" `+disabled+` title="`+title+`" data-field="`+item.product_id+`" type="checkbox" name="product[`+item.product_id+`]" value="`+item.product_id+`">
                                                                            </div>
                                                                        </td>
                                                                        <td class="cart_product_img">
                                                                            <a href="#"><img src="` + src + `/` + item.product_name + `/` + item.product_picture1 + `" alt="Product"></a>
                                                                        </td>
                                                                        <td class="cart_product_desc">
                                                                            <p>`+item.product_name+`</p>
                                                                        </td>
                                                                        <td class="qty">
                                                                            <input class="form-control text-center" type="number" name="quantity[`+item.product_id+`]" max="`+item.quantity+`" min="1" value="`+item.quantity+`">
                                                                        </td>
                                                                        <td class="qty product-topbar">
                                                                            <p>`+item.color+`</p>
                                                                            <select class="form-select nice-select select-color d-none select-color-`+item.product_id+`" onchange="changeColor(`+item.product_id+`, '`+item.style+`')">
                                                                                <option value="default" selected>Đổi sang</option>`;
                                                                    var arrColor = item.product_color.split(',');
                                                                    for(var color of response.colors){
                                                                        for(var i = 0; i < arrColor.length; i++){
                                                                            if(arrColor[i] == color.id){
                                                                                html += `<option value="`+color.name+`">`+color.name+`</option>`;
                                                                            }
                                                                        }
                                                                    }
                                                                        
                                                                    
                                                                    html += `</select>
                                                                           
                                                                        </td>
                                                                        <td class="qty product-topbar">
                                                                            <p>`+item.size+`</p>
                                                                            <div id="block-size-`+item.product_id+`"></div>
                                                                            <input type="hidden" name="size[`+item.product_id+`]" class="size-`+item.product_id+`" value="">
                                                                            <input type="hidden" name="old_size[`+item.product_id+`]" value="`+item.size+`">
                                                                            <input type="hidden" name="color[`+item.product_id+`]" class="color-`+item.product_id+`" value="">
                                                                            <input type="hidden" name="old_color[`+item.product_id+`]" value="`+item.color+`">
                                                                            <input type="hidden" name="product[`+item.product_id+`]" class="product-`+item.product_id+`" value="">
                                                                            <input type="hidden" name="old_product[`+item.product_id+`]" value="`+item.product_id+`">
                                                                            <input type="hidden" name="style[`+item.product_id+`]" value="`+item.style+`">
                                                                        </td>
                                                                    </tr>`;
                                                        }
                                                            
                                                            html += `</tbody>
                                                                </table>
                                                                <small>Nếu bạn muốn đổi sang sản phẩm khác, <a href="../exchange/`+id+`"  class="text-primary"><small>Click vào đây</small></a></small>
                                                            </div>
                                                        </div>
                                                    </div>`;

                                        html += `<div class="form-check d-flex align-items-center">
                                                    <input id="reason-1-`+id+`" class="form-check-input not-other" type="radio" name="reason_refund" value="Sizing or fit issues." checked>
                                                    <label for="reason-1-`+id+`" class="form-check-label not-other" style="font-size: 16px; margin-top: 1%">
                                                        Sizing or fit issues.
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input id="reason-2-`+id+`" class="form-check-input not-other" type="radio" name="reason_refund" value="Damaged or defective item)">
                                                    <label for="reason-2-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                                        Damaged or defective item.
                                                    </p>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input id="reason-3-`+id+`" class="form-check-input not-other" type="radio" name="reason_refund" value="Did not meet expectations.">
                                                    <label for="reason-3-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                                        Did not meet expectations.
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input id="reason-4-`+id+`" class="form-check-input not-other" type="radio" name="reason_refund" value="Changed mind or impulse purchase.">
                                                    <label for="reason-4-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                                        Changed mind or impulse purchase.
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input id="reason-5-`+id+`" class="form-check-input not-other" type="radio" name="reason_refund" value="Incorrect order.">
                                                    <label for="reason-5-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                                        Incorrect order.
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input id="reason-6-`+id+`" class="form-check-input not-other" type="radio" name="reason_refund" value="The products did not match the description.">
                                                    <label for="reason-6-`+id+`" class="form-check-label not-other"  style="font-size: 16px; margin-top: 1%">
                                                        The products did not match the description.
                                                    </label>
                                                </div>
                                                <div class="form-check d-flex align-items-center">
                                                    <input id="reason-7-`+id+`" class="form-check-input" type="radio" name="reason_refund" value="Other">
                                                    <label for="reason-7-`+id+`" class="form-check-label"  style="font-size: 16px; margin-top: 1%">
                                                        Other
                                                    </label>
                                                </div>
                                                <div class="form-group d-none" id="reason-other-`+id+`">
                                                    <label class="form-check-label my-2" for="other-`+id+`" style="font-size: 16px">
                                                        Nhập lý do(*)
                                                        </label>
                                                    <textarea type="text" class="form-control" id="other-`+id+`"></textarea>
                                                    <small class="text-danger" id="error-reason-`+id+`" style="font-size: 13.2px"></small>
                                                </div>
                                                    
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a class="btn artiz-btn w-100 mt-4 text-white popup-button" style="min-width: 0">Đóng</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <button type="submit" class="btn artiz-btn-black w-100 mt-4 popup-refund" disabled style="min-width: 0">Chọn sản phẩm</button>
                                                        <input type="hidden" name="cart_id" value="`+id+`">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>`;
                                $('.popup-body').html(html);
                                const button = document.querySelector(".popup-button");
                                $('.popup-button').click(function () {
                                    myPopup.hide();
                                });

                                $('#reason-7-'+id).click(function(){
                                    $('#reason-other-'+id).removeClass('d-none');
                                    $('#other-'+id).attr("required", true);
                                });

                                $('.not-other').click(function(){
                                    $('#reason-other-'+id).addClass('d-none');
                                    $('#other-'+id).removeAttr("required");
                                    document.getElementById("error-reason-"+id).textContent = '';
                                });

                                $('#other-'+id).keyup(function(){
                                    document.getElementById("error-reason-"+id).textContent = '';
                                if($(this).val() == ''){
                                        document.getElementById("error-reason-"+id).textContent = 'Vui lòng nhập lý do!';
                                }
                                });
                            
                                $('.check-product').on('click',function(){
                                    var id = $(this).data('field');
                                    if($("input:checkbox").filter(":checked").length > 0){
                                        if($('.check-'+id).prop('checked')){
                                            $('.select-color-'+id).removeClass('d-none');
                                            $('.product-'+id).val(id);
                                        } else {
                                            $('.select-color-'+id).addClass('d-none');
                                            $('.select-size-'+id).addClass('d-none');
                                            $('.error-'+id).text('');
                                            $('.size-'+id).val('');
                                            $('.product-'+id).val('');
                                            $('.color-'+id).val('');
                                        }
                                    } else {
                                        $('.select-color-'+id).addClass('d-none');
                                        $('.select-size-'+id).addClass('d-none');
                                        $('.error-'+id).text('');
                                    }
                                    $('.popup-refund').text('Hoàn thành lựa chọn của bạn');
                                    $('.popup-refund').attr('disabled','disabled');
                                });                           
                            }
                        });
                    },
                });
                myPopup.show();
            }
        </script>
        <script type="text/javascript">
            function changeColor(id, style) {
                var color = $('.select-color-'+id).val();
                var html = ''
                $('.color-'+id).val(color);
                $.ajax({
                    type: "GET",
                    url: "{{ route('user/history-sku') }}?product_id=" + id + '&style=' + style + '&color=' + color,
                    
                    success: function(response) {
                        if(response.sizes != ''){
                            html += `<select class="form-select nice-select select-size select-size-`+id+`" onchange="changeSize(`+id+`)">
                                        <option value="default" selected>Đổi sang</option>`;
                            for(var sizeSlb of response.sizeSlb){
                                for(var size of response.sizes){
                                    if(size.size == sizeSlb.name){
                                        html += `<option value="`+size.size+`">`+size.size+`</option>`;
                                    }
                                }
                            }
                            html += `</select>`;
                        } else {
                            html += '<small class="text-danger error-'+id+'">Hết hàng</small>'
                        }
                        
                        $('#block-size-'+id).html(html);
                        $('.popup-refund').text('Hoàn thành lựa chọn của bạn');
                        $('.popup-refund').attr('disabled','disabled');
                    },
                });
            }

            function changeSize(id){
                var size = $('.select-size-'+id).val();
                var html = ''
                $('.size-'+id).val(size);
                if($('.select-size-'+id).val() != 'default'){
                    $('.size-'+id).val($('.select-size-'+id).val());
                    var error = $('.text-danger').text();
                    if(error == ''){
                        $('.popup-refund').text('Gửi');
                        $('.popup-refund').removeAttr('disabled');
                    } else {
                        $('.popup-refund').text('Vui lòng lựa chọn đúng');
                        $('.popup-refund').attr('disabled','disabled');
                    }
                } 
            };   
        </script>
        <script>
            $(document).ready(function(){
                const form = document.getElementById('formRefund');
                form.addEventListener('submit', function handler (e) {
                    if($('.text-danger').text() != ''){
                        e.preventDefault();
                        $('.popup-refund').text('Vui lòng lựa chọn đúng');
                        $('.popup-refund').attr('disabled','disabled');
                    } else {
                        form.removeEventListener('submit', handler);
                    }
                });
            });
        </script>
    <style>
        #bar-progress {
            width: 100%;
            display: inline-flex;
            justify-content: space-around;
        }

        #bar-progress .step {
            align-items: center
        }

        #bar-progress .step .col-3::after {
            content: '';
            width: 30px;
            height: 1px;
            background: #968B7E;
            position: absolute;
            top: 50%;
            left: 60%;
        }

        #bar-progress .step .number-container {
            display: inline-block;
            border: solid 1px #000;
            color: #968B7E;
            border-radius: 50%;
            width: 24px;
            height: 24px;
        }

        #bar-progress .step.step-active .number-container {
            background-color: #968B7E;
        }

        #bar-progress .step.step-active h5, #bar-progress .step.step-active small {
            color: #968B7E;
        }

        #bar-progress .step .number-container .number {
            font-weight: 700;
            font-size: .8em;
            line-height: 1.75em;
            display: block;
            text-align: center;
        }

        #bar-progress .step.step-active .number-container .number {
            color: white;
        }

        #bar-progress .step h5 {
            font-weight: 400;
            margin-bottom: 0px;
        }

        #bar-progress .seperator {
            display: block;
            width: 20px;
            height: 1px;
            background-color: rgba(0, 0, 0, .2);
            margin: auto;
        }

        select option {
            text-align: left;
        }
    </style>
@endsection
