@extends('default.pages.user.main')
@section('user')
    <hr style="height: 1.1px; background: transparent">
    <div class="cart-table-area ml-0">
        <div class="container-fluid">
            <div class="login-title mt-15">
                <h4>Order Details</h4>
                <div class="row">
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Order Number</small>
                        <p>#{{ $item['cart_id'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Customer Order</small>
                        <p>{{ $item['fullname'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Date of Order</small>
                        <p>{{ date('H:i:s d/m/Y', strtotime($item['created'])) }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Payment Method</small>
                        <p style="text-transform: capitalize">{{ $item['payment_method'] }}</p>
                    </div>
                </div>
            </div>
            <div class="login-title mt-30">
                <h4>Shipping Details</h4>
                <div class="row">
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Full Name</small>
                        <p>{{ $item['fullname'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Email Address</small>
                        <p>{{ $item['email'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Phone Number</small>
                        <p>{{ $item['phone'] }}</p>
                    </div>
                    <div class="col-6 col-md-3">
                        <small class="text-primary">Shipping Address</small>
                        <p>{{ $item['address'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="row mt-30">
                <div class="col-12 col-lg-6">
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
                                                        <p class="p-0 m-0">Quantity</p>
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
                                                        <p class="p-0 m-0">Color</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <div class="quantity">
                                                            <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                {{ $value['color'] }} </p>
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
                                <h4>Billing Details</h4>
                                <ul class="summary-table">
                                    <li><span>subtotal:</span> <span id="subtotal">{{ $item['subtotal'] }}</span></li>
                                    <li><span>delivery:</span> <span>Free</span></li>
                                    <li><span>discount:</span> <span id="discount">-{{ $item['discount'] }}</span></li>
                                    <li><span>Member:</span> <span id="discount">-{{ $item['member'] }}</span></li>
                                    <li><span>coupon:</span> <span id="voucher">-{{ $item['coupon_value'] }}</span></li>
                                    <hr style="height: 0.1px">
                                    <li><span>total:</span> <span name="total" id="total">{{ $item['total'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    </style>
@endsection
