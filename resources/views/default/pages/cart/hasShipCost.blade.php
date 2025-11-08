@extends('default.main')
@section('content')
<div class="login-table-area section-padding-100 pt-5">
    <div class="container-fluid">
        @if (Cart::content()->count() != 0)
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="login-title mt-50">
                        <h2>Thanh toán</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="login-title">
                        <h4>Đơn hàng của bạn</h4>
                    </div>

                    <div class="cart-table clearfix">
                        
                        <table class="table table-responsive" style="overflow: hidden; outline: none; cursor: grab; touch-action: none;">
                            <tbody>
                                @php
                                    $totalDiscount = 0;
                                    $totalOrderValue = 0;
                                @endphp
                                @foreach (Cart::content() as $value)
                                    @php
                                        $id = $value->id;
                                        $name = $value->name;
                                        $picture = asset(
                                            'public/images/product/' . $value->name . '/' . $value->options->picture,
                                        );
                                        $color = $value->options->color;
                                        $size = $value->options->size;

                                        $price = $value->price;
                                        $percentDiscount = ($value->options->discount * $value->price) / 100; // you save
                                        $discount = $value->price - $percentDiscount; // final price / unit
                                        $quantity = $value->qty;
                                        $total = $quantity * $discount; // total price / product
                                        $totalDiscount += $percentDiscount * $quantity; // sale product

                                        $disable = '';
                                        $title = '';
                                        if($totalDiscount > 0){
                                            $disable = 'disabled';
                                            $title = 'Không áp dụng cho sản phẩm giảm giá';
                                        }
                                    @endphp
                                        <div class="row">
                                            <div class="col-5 col-lg-4">
                                                <a href="{{ route('shop/detail', ['id' => $id, 'name' => Str::slug($name)]) }}"><img src="{{ $picture }}" alt="Product"></a>
                                            </div>
                                            <div class="col-7 col-lg-8">
                                                <div class="single_product_desc">
                                                    <div class="product-meta-data" style="position: relative">
                                                        <div class="line"></div>
                                                        <a href="{{ route('shop/detail', ['id' => $id, 'name' => Str::slug($name)]) }}"><h5>{{ $name }}</h5></a>
                                                        
                                                        <div class="row my-2">
                                                            <div class="col-4">
                                                                <p class="p-0 m-0">Đơn giá</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="quantity">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                        @if($discount != $price)
                                                                        <span class="text-danger m-0">{{ number_format($discount, 0, ',', '.') }}<span class="currency">đ</span></span>
                                                                            <del></br>{{ number_format($price, 0, ',', '.') }}<span class="currency">đ</span></del><span class="text-danger"><small><i> (Giảm {{ $value->options->discount }}%)</i></small></span>
                                                                        @else
                                                                            {{ number_format($price, 0, ',', '.') }}<span class="currency">đ</span>
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
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">{{ number_format($quantity, 0, ',', '.') }} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-4">
                                                                <p class="p-0 m-0">Size</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="quantity">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">{{ $size }} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-4">
                                                                <p class="p-0 m-0">Màu</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <div class="quantity">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">{{ $color }} </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row my-2">
                                                            <div class="col-4">
                                                                <p style="font-weight: 500" class="p-0 m-0">Tổng cộng</p>
                                                            </div>
                                                            <div class="col-8">
                                                                <p class="p-0 m-0">
                                                                    @if($discount != $price)
                                                                    <span class="text-danger m-0">{{ number_format($discount * $quantity, 0, ',', '.') }}<span class="currency">đ</span></span>
                                                                        <del></br>{{ number_format($price * $quantity, 0, ',', '.') }}<span class="currency">đ</span></del>
                                                                    @else
                                                                        {{ number_format($total, 0, ',', '.') }}<span class="currency">đ</span>
                                                                    @endif
                                                                </p>
                                                                @if($discount != $price)
                                                                    <small style="color: #008080"><i>(Tiết kiệm {{ number_format($percentDiscount * $quantity, 0, ',', '.') }}<span class="currency">đ</span>)</i></small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr style="height: 0.1px; background: transparent">
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <form action="{{ route('cart/submit') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-12 mt-5">
                                <div class="checkout_details_area clearfix">
                                    <div class="login-title">
                                        <h4>Thông tin giao hàng</h4>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12 mb-3">
                                            <input type="text" class="form-control" name="fullname" id="fullname" value="{{ Auth::user()->fullname }}" placeholder="Tên người nhận hàng" required="">
                                        </div>
                                        <div class="col-12 col-md-12 mb-3">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{ Auth::user()->email }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <input type="number" class="form-control" name="phone" id="phone" min="0" placeholder="Số điện thoại" value="{{ Auth::user()->phone }}" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <select class="form-control" name="shipping_city" id="city" aria-label="form-select-sm" required>
                                                <option value="" selected>Chọn Tỉnh/Thành phố</option>           
                                            </select>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <input type="text" class="form-control mb-3" name="address" id="address" placeholder="Địa chỉ nhận hàng" value="{{ Auth::user()->address }}" required>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <textarea class="form-control w-100" name="note" id="note" cols="30" rows="5" placeholder="Ghi chú cho đơn hàng" style="height: 70px"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <div class="cart-summary p-0 mt-5">
                                    <h4>Thông tin hóa đơn</h5>
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="text" class="form-control" name="coupon" id="coupon" placeholder="Nhập mã giảm" {{ $disable }}>
                                                <small class="text-danger" id="error-coupon"></small>
                                                <small class="text-success" id="success-coupon"></small>
                                                <small class="text-danger">{{ $title }}</small>
                                            </div>
                                            <div class="col-4">
                                                <button type="button" name="button-coupon" id="button-coupon" style="min-width: 0;" class="btn artiz-btn position-relative btn-add-to-cart w-100" {{ $disable }}>
                                                    <span class="btn-state state-default">Tìm kiếm</span>
                                                    <span class="btn-state state-adding">
                                                        <span class="animation-ellipsis">
                                                            <span class="dot"></span>
                                                            <span class="dot"></span>
                                                            <span class="dot"></span>
                                                        </span>Đang tìm</span>
                                                </button>
                                            </div>
                                        </div>
                                        
                                    <ul class="summary-table">
                                        @php
                                            $totalValue = str_replace(".", "", Cart::subtotal());
                                            $memberDiscount = ($totalValue - $totalDiscount) * ($member['discount'])/100;
                                        @endphp
                                        <li><span>Tạm tính:</span> <span id="subtotal">{{ Cart::subtotal() }}</span></li>
                                        <li><span>Phí vận chuyển:</span> <span id="shipping">Tùy khu vực</span></li>
                                        <li><span>Giảm giá:</span> <span id="discount">-{{ number_format($totalDiscount, 0, ',', '.') }}</span></li>
                                        <li><span>Thành viên:</span> <span id="member">{{ number_format(-$memberDiscount, 0, ',', '.') }}</span></li>
                                        <li><span>Mã giảm:</span> <span id="voucher">0</span></li>
                                        <hr style="height: 0.1px">
                                        <li><span>Tổng cộng:</span> <span name="total" id="total">{{ number_format($totalValue - $totalDiscount - $memberDiscount , 0, ',', '.') }}</span></li>
                                    </ul>
                
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" value="cash on delivery" id="cod" checked>
                                        <label class="form-check-label" for="cod">
                                          Thanh toán khi nhận hàng
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="payment_method" value="mobile banking" id="qr" onclick="showPopup({{ $totalValue - $totalDiscount - $memberDiscount }})">
                                        <label class="form-check-label" for="qr">
                                          Quét mã QR
                                        </label>
                                      </div>
                                      <div class="form-group d-none" id="screenshot">
                                        <label class="form-check-label my-2" for="invoice">
                                            Màn hình hóa đơn chuyển khoản *
                                          </label>
                                        <input type="file" class="form-control" name="invoice" id="invoice">
                                        <img id="display_invoice" style="background-color: #FFC3C0" src="" alt="">
                                      </div>
                                    
                                      <div class="login-btn mt-100">
                                        <input type="hidden" name="totalHidden" id="totalHidden" value="{{ number_format($totalValue - $totalDiscount - $memberDiscount, 0, ',', '.') }}">
                                        <input type="hidden" name="subtotal"  value="{{ Cart::subtotal() }}">
                                        <input type="hidden" name="member" id="memberHidden" value="{{ number_format($memberDiscount, 0, ',', '.') }}">
                                        <input type="hidden" name="discount" id="discount" value="{{ number_format($totalDiscount, 0, ',', '.') }}">
                                        <input type="hidden" name="coupon_value" id="coupon_value" value="0">
                                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                                        <button type="submit" class="btn artiz-btn w-100">XÁC NHẬN ĐẶT HÀNG</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Hiện chưa có sản phẩm nào trong giỏ</h2>
                    <p class="mt-3">Mua sắm ngay</p>
                    <a style="text-decoration: underline" href="{{ route('shop') }}">Tiếp tục mua sắm</a>
                </div>
            </div>
        @endif
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    $(document).ready(function(){
        var coupon          = document.getElementById('coupon');
        var errorCoupon     = document.getElementById("error-coupon");
        var successCoupon   = document.getElementById("success-coupon");
        var subtotal        = document.getElementById("subtotal");
        var shipping        = document.getElementById("shipping");
        var shipping_cost   = document.getElementById("shipping_cost");
        var voucher         = document.getElementById("voucher");
        var discount        = document.getElementById("discount");
        var member          = document.getElementById("member");
        var totalValue      = document.getElementById("total");
        var totalHidden     = document.getElementById("totalHidden");
        var couponValue     = document.getElementById("coupon_value");

        

        const addToCartButton = document.querySelector('.btn-add-to-cart');

        $('#city').change(function() {
            var zone = $('#city').val();
            var before = shipping_cost.value;
            var cost = '35.000';
            var display = 35000;
            if(zone == 'Thành phố Hồ Chí Minh'){
                cost = '25.000';
                display = 25000;
            } else if(zone == 'Thành phố Hà Nội'){
                cost = '30.000';
                display = 30000;
            }

            var final = new Intl.NumberFormat().format(display - Number(before.replaceAll(".", "")));
            shipping.textContent         = cost;
            $('#shipping_cost').val(cost);

            var total = new Intl.NumberFormat().format(Number(totalHidden.value.replaceAll(".", "")) + Number(final.replaceAll(",", "")));
            totalValue.textContent          = total.replaceAll(",", ".");
            totalHidden.value               = total.replaceAll(",", ".");
        })
        
        

        $('#button-coupon').click(function(){
            errorCoupon.textContent      = '';
            successCoupon.textContent      = '';
            if(coupon.value != ''){
                const CSS_ADDING = 'cart-adding';
                $(this).addClass(CSS_ADDING);
                $.ajax({
                    url: "{{ route('cart/check-coupon') }}?coupon=" + coupon.value,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        $('#button-coupon').removeClass(CSS_ADDING);
                        if(response.item != null){
                            errorCoupon.textContent         = '';
                            var ship = shipping.textContent == 'Tùy khu vực' ? '0' : shipping.textContent;
                            var total                       = Number(subtotal.textContent.replaceAll(".", "")) + Number(discount.textContent.replaceAll(".", "")) + Number(member.textContent.replaceAll(".", "")) + Number(ship.replaceAll(".", ""));
                            var tempShippingCost            = shipping_cost.value.replaceAll(".", "");
                            var tempTotal                   = Number(total) - Number(tempShippingCost);
                            if(response.item.maximum > 0 || response.item.maximum != null){
                                var totalOrderValue             = Math.ceil(tempTotal - response.item.maximum + Number(tempShippingCost)).toLocaleString();
                                successCoupon.textContent       = 'Bạn được giảm '+response.item.value+'% (Tối đa '+Number(response.item.maximum).toLocaleString().replaceAll(",", ".")+'đ)';
                                voucher.textContent             = '-'+Math.floor(response.item.maximum).toLocaleString().replaceAll(",", ".");
                                couponValue.value               = Math.floor(response.item.maximum).toLocaleString().replaceAll(",", ".");
                            } else {
                                var totalOrderValue             = Math.ceil(tempTotal * (100 - response.item.value)/100 + Number(tempShippingCost)).toLocaleString();
                                successCoupon.textContent       = 'Bạn được giảm '+response.item.value+'%';
                                voucher.textContent             = '-'+Math.floor((tempTotal * response.item.value / 100)).toLocaleString().replaceAll(",", ".");
                                couponValue.value               = Math.floor((tempTotal * response.item.value / 100)).toLocaleString().replaceAll(",", ".");
                            }
                            totalValue.textContent          = totalOrderValue.replaceAll(",", ".");
                            totalHidden.value               = totalOrderValue.replaceAll(",", ".");
                        } else {
                            successCoupon.textContent       = '';
                            errorCoupon.textContent         = 'Mã giảm không tồn tại';
                        }
                        alert(total);
                        alert(tempTotal);
                    }
                });
            } else {
                errorCoupon.textContent      = 'Vui lòng nhập mã';
            }
        });

        $('#qr').click(function(){
            $('#screenshot').removeClass('d-none');
            $('#invoice').attr("required", true);
        })

        $('#cod').click(function(){
            $('#screenshot').addClass('d-none');
            $('#invoice').removeAttr("required");
        });
        
        const invoice = document.querySelector("#invoice");
        var upload_invoice = "";

        invoice.addEventListener("change", function() {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                upload_invoice = reader.result;
                document.querySelector("#display_invoice").src = `${upload_invoice}`;
            });
            reader.readAsDataURL(this.files[0]);
        });

        var citis = document.getElementById("city");
        var districts = document.getElementById("district");
        var wards = document.getElementById("ward");
        var Parameter = {
            url: "{{ asset('public/default/json/data.json') }}", 
            method: "GET", 
            responseType: "application/json", 
        };
        var promise = axios(Parameter);
        promise.then(function (result) {
            renderCity(result.data);
        });

        function renderCity(data) {
            for (const x of data) {
                citis.options[citis.options.length] = new Option(x.Name, x.Name);
            }
        }

        $("#city").html($("#city option").sort(function (a, b) {
            return a.text == b.text ? 0 : a.text < b.text ? -1 : 1
        }))
    });

    function showPopup() {
        var total = $('#totalHidden').val();
        var html = '';
        var src = '{{ asset('public/images/product/') }}';
        const myPopup = new Popup({
            id: "my-popup",
            hideTitle: true,
            title: "",
            content: ``,
            loadCallback: () => {
                html += `<div style="overflow: hidden">
                            <h2 class="sans-serif text-primary">`+total+`<span class="currency">đ</span></h2>
                            <div class="scan">
                                <div class="qrcode"></div>
                                <div class="border"></div>
                            </div>
                            <p class="m-0 mt-4 text-primary">Tên ngân hàng: Techcombank</p>
                            <p class="m-0 text-primary">Số tài khoản: 1900 1234 5678 9012</p>
                            <p class="m-0 text-primary">Tên tài khoản: Pham Nguyen Hoang Thien Toan</p>
                            <a class="btn artiz-btn w-100 mt-4 text-white popup-button" style="min-width: 0">Đóng</a>
                        </div>`;
                $('.popup-body').html(html);
                const button = document.querySelector(".popup-button");
                $('.popup-button').click(function () {
                    myPopup.hide();
                });
            },
        });
        myPopup.show();
    }
</script>
<style>
    input[type=radio] {
            accent-color: #968B7E;
    }

    .popup-content{
        align-items: center;
    }

    .scan {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .scan .qrcode {
        position: relative;
        width: 200px;
        height: 200px;
        background: url("{{ asset('public/default/img/core-img/QR_Code01.png') }} ");
        background-size: 200px;
    }

    .scan .qrcode::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        background: url("{{ asset('public/default/img/core-img/QR_Code02.png') }}");
        background-size: 200px;
        overflow: hidden;
        animation: animate 4s ease-in-out infinite;
    }

    @keyframes animate {
        0%, 100% {
            height: 20px;
        }

        50% {
            height: calc(100% - 20px);
        }
    }

    .scan .qrcode::after {
        content: '';
        position: absolute;
        inset: 20px;
        width: calc(100% - 40px);
        height: 2px;
        background: #968B7E;
        filter: drop-shadow(0 0 20px #968B7E) drop-shadow(0 0 60px #968B7E);
        animation: animateLine 4s ease-in-out infinite;
    }

    @keyframes animateLine {
        0% {
            top: 20px;
        }

        50% {
            top: calc(100% - 20px);
        }
    }

    .border {
        position: absolute;
        inset: 0;
        background: url("{{ asset('public/default/img/core-img/border.png') }}");
        background-size: 200px;
        background-repeat: no-repeat;
        width: 200px;
        margin: 0 auto;
    }
</style>
@endsection
