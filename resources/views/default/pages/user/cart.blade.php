@extends('default.main')
@section('content')
    <div class="login-table-area section-padding-100 pt-5">
        <div class="container-fluid">
                @if (Cart::content()->count() != 0)
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="login-title mt-50">
                                <h2>Chi tiết giỏ hàng</h2>
                            </div>

                            <div class="cart-table clearfix">
                                @php
                                    $totalDiscount = 0;
                                    $totalOrderValue = 0;
                                @endphp
                                @foreach ($items as $value)
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
                                    @endphp
                                    
                                        <div class="row">
                                            <div class="col-4 col-lg-4">
                                                <a href="{{ route('shop/detail', ['id' => $id, 'name' => Str::slug($name)]) }}"><img src="{{ $picture }}" alt="Product"></a>
                                            </div>
                                            <div class="col-8 col-lg-8">
                                                <div class="single_product_desc">
                                                    <div class="product-meta-data" style="position: relative">
                                                        <div class="line"></div>
                                                        <a href="{{ route('shop/detail', ['id' => $id, 'name' => Str::slug($name)]) }}"><h5>{{ $name }}</h5></a>
                                                        
                                                        <div class="row my-2">
                                                            <div class="col-3">
                                                                <p class="p-0 m-0">Đơn giá</p>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="quantity">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                        @if($discount != $price)
                                                                        <span class="text-danger"><span class="currency">đ</span>{{ number_format($discount, 0, ',', '.') }}</span>
                                                                            <del></br><span class="currency">đ</span>{{ number_format($price, 0, ',', '.') }}</del> <span class="text-danger"><small><i>(Giảm {{ $value->options->discount }}%)</i></small></span>
                                                                        @else
                                                                        <span class="currency">đ</span>{{ number_format($price, 0, ',', '.') }}
                                                                        @endif
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-3">
                                                                <p class="p-0 m-0">Số lượng</p>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="quantity">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                        {{ $quantity }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-3">
                                                                <p class="p-0 m-0">Size</p>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="size">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                        {{ $size }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row my-2">
                                                            <div class="col-3">
                                                                <p class="p-0 m-0">Màu</p>
                                                            </div>
                                                            <div class="col-9">
                                                                <div class="color">
                                                                    <p style="font-weight: 500" class="product-price p-0 m-0">
                                                                        {{ $color }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr style="height: 0.1px; background: black">
                                                        <div class="row my-2">
                                                            <div class="col-3">
                                                                <p class="p-0 m-0">Tổng cộng</p>
                                                            </div>
                                                            <div class="col-9">
                                                                <p class="p-0 m-0">
                                                                    @if($discount != $price)
                                                                    <span class="text-danger">{{ number_format($discount * $quantity, 0, ',', '.') }}<span class="currency">đ</span></span>
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
                                                        <div class="row my-2">
                                                            <div class="col-6">
                                                                <button style="min-width: 0" type="button" onclick="showPopup('{{ $value->id }}', '{{ $value->rowId }}', '{{ $quantity }}', '{{ $size }}', '{{ $color }}')" class="btn artiz-btn-black w-100">Sửa</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <a style="min-width: 0" href="{{ route($controllerName . '/cart/remove', ['id' => $value->rowId]) }}" class="btn artiz-btn">Xóa</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <hr style="height: 0.1px">
                                @endforeach
                            </div>
                            <div class="row my-2">
                                <div class="col-6">
                                    <a style="min-width: 0" href="{{ route($controllerName . '/cart/destroy') }}" class="btn artiz-btn">Xóa tất cả</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="cart-summary">
                                <h4>Hóa đơn tạm tính</h4>
                                <ul class="summary-table">
                                    @php
                                        $totalValue = str_replace(".", "", Cart::subtotal());
                                        $memberDiscount = ($totalValue - $totalDiscount) * ($member['discount'])/100;
                                    @endphp
                                    <li><span>tạm tính:</span> <span>{{ Cart::subtotal() }}</span></li>
                                    <li><span>phí vận chuyển:</span> <span>Miễn phí</span></li>
                                    <li><span>giảm giá:</span> <span><span class="ai-achievement"></span>-{{ number_format($totalDiscount, 0, ',', '.') }}</span></li>
                                    <li><span>thành viên:</span> <span id="discount">{{ number_format(-$memberDiscount, 0, ',', '.') }}</span></li>
                                    <hr style="height: 0.1px">
                                    <li><span>tổng cộng:</span> <span name="total" id="total">{{ number_format($totalValue - $totalDiscount - $memberDiscount , 0, ',', '.') }}</span></li>
                                <div class="cart-btn mt-100">
                                    <a href="{{ route('cart/checkout') }}" class="btn artiz-btn w-100">TIẾN HÀNH THANH TOÁN</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="row text-center justify-content-center">
                        <img fetchpriority="high" style="width: 200px" class="my-5" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/result.png') }}">
                        <div class="col-md-12 text-center">
                            <h2>Hiện chưa có sản phẩm nào trong giỏ</h2>
                            <p class="mt-3">Mua sắm ngay</p>
                            <a style="text-decoration: underline" href="{{ route('shop') }}">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
    <script>
        function showPopup(id, cartId, quantity, thisSize, thisColor) {
            if($('.popup').hasClass("fade-out")){
                $('.popup').remove();
            }
            var html = '';
            var src = '{{ asset('public/images/product/') }}';
            var colorSrc = '{{ asset('public/images/color/') }}';
            var action = "cart/update?id=" + cartId;
            const myPopup = new Popup({
                id: "my-popup-" + id,
                hideTitle: true,
                title: "",
                content: ``,
                loadCallback: () => {
                    $.ajax({
                        method: "GET",
                        url: "{{ route('shop/detail-quick-view') }}?id=" + id,
                        dataType: 'json',
                        success: function(response) {
                            var name = response.item.name.toLowerCase().replace(
                                " ", "-");
                            
                            html += `<div class="single-product-area clearfix pt-0">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12 col-lg-6 justify-content-center">
                                                    <div class="row justify-content-center">
                                                        <div class="loader" style="display: none"></div>
                                                    </div>
                                                    <div class="row quick-view-inside" id="thumnail-ajax">
                                                        <div class="col-12">
                                                            <img src="` + src + `/` + response.item.name + `/` + response.item.picture1 + `">
                                                        </div>`;
                                            if (response.item.picture2 != null)
                                                html += `<div class="col-12">
                                                            <img src="` + src + `/` + response.item.name + `/` + response.item.picture2 + `">
                                                        </div>`;
                                            if (response.item.picture3 != null)
                                                html += `<div class="col-12">
                                                            <img src="` + src + `/` + response.item.name + `/` + response.item.picture3 + `">
                                                        </div>`;
                                            if (response.item.picture4 != null)
                                                html += `<div class="col-12">
                                                            <img src="` + src + `/` + response.item.name + `/` + response.item.picture4 + `">
                                                        </div>`;
                                            if (response.item.picture5 != null)
                                                html += `<div class="col-12">
                                                            <img src="` + src + `/` + response.item.name + `/` + response.item.picture5 + `">
                                                        </div>`;
                                            if (response.item.picture6 != null)
                                                html += `<div class="col-12">
                                                            <img src="` + src + `/` + response.item.name + `/` + response.item.picture6 + `">
                                                        </div>`;
                                                html +=
                                                    `</div>
                                                </div>
                                                <div class="col-12 col-lg-6" style="text-align: left">
                                                    <div class="single_product_desc">
                                                        <div class="product-meta-data" style="position: relative">
                                                            <div class="line"></div>
                                                            <h3>`+response.item.name+`</h3>
                                                            <strong class="product-price" style="font-weight: 500">`;
                                                                if(response.item.discount > 0){
                                                                    html += `<p class="text-primary">` + new Intl.NumberFormat().format(response.item.price * (100 - response.item.discount) / 100) + `<span class="currency">đ</span></p>
                                                                            <del>` + new Intl.NumberFormat().format(response.item.price) + `<span class="currency">đ</span></del>
                                                                            <span class="btn btn-artiz" style="width: 50px; background-color: #968B7E; color: white; border-radius: 5px; border-color: #968B7E; padding: 0; margin-bottom: 5px">-`+response.item.discount+`%</span>`;
                                                                } else {
                                                                    html += new Intl.NumberFormat().format(response.item.price) + `<span class="currency">đ</span>`;
                                                                }                                        
                                                    html += `</strong>
                                                        </div>
                                                        <form class="cart clearfix" method="post"  action="`+action+`">
                                                            @csrf                            
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-12">
                                                                    <div class="widget color">
                                                                        <div class="widget-desc">
                                                                            <p class="p-0">Màu sắc <span class="color-text"></span></p>
                                                                            <div>
                                                                                <ul class="d-flex">`;
                                                                                    var arrColor = [response.item.color.split(',')];
                                                                                    for(var color of arrColor[0]){
                                                                                        for(var arr of response.colorSlb){
                                                                                            if(color == arr.id){
                                                                                                html += `
                                                                                                <li class="active-color">
                                                                                                    <a class="color-ajax-`+arr.id+`" aria-label="Color" onclick="changeColor('`+arr.id+`', '`+response.item.style+`', '`+quantity+`', '`+id+`', '`+thisSize+`', '`+thisColor+`')" data-toggle="tooltip" data-placement="right" title="` + arr.name + `">
                                                                                                        <img src="`+colorSrc + '/' +arr.name+`/`+arr.picture+`" alt="">
                                                                                                    </a>
                                                                                                </li>`;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                        html += `</ul>
                                                                                <input type="hidden" value="" name="color" id="color">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-lg-12">
                                                                    <div class="widget color">
                                                                        <div class="widget-desc">
                                                                            <p class="p-0">Size <span class="size-text"></span</p>
                                                                            <div>
                                                                                <ul class="d-flex" id="ajax-size">`;
                                                                                    var arrSize = [response.item.size.split(',')];
                                                                                    for(var size of arrSize[0]){
                                                                                        for(var arr of response.sizeSlb){
                                                                                            if(size == arr.id){
                                                                                                html += `<li class="check-size size-`+arr.name+`" onclick="activeSize('`+arr.name+`')" data-field="`+arr.name+`">`+arr.name+`</li>`;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                        html += `</ul>
                                                                                <input type="hidden" value="" name="size" id="size">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-lg-12">
                                                                    <div class="widget color">
                                                                        <div class="widget-desc row">
                                                                            <div class="col-4">
                                                                                <p class="p-0 m-0">Số lượng</p>
                                                                            </div>
                                                                            <div class="col-8">
                                                                                <div class="quantity">
                                                                                    <input type="number" class="qty-text" id="quantity"
                                                                                        step="1" min="0" onchange="changeQuantity()"
                                                                                        max="`+response.item.quantity+`"
                                                                                        name="qty" value="`+quantity+`">
                                                                                    <small class="text-danger ml-5" id="error-quantity"></small>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <a class="btn artiz-btn w-100 mt-4 text-white popup-button" style="min-width: 0">Đóng</a>
                                                                </div>
                                                                <div class="col-6">
                                                                    <button type="submit" class="btn artiz-btn-black w-100 mt-4 text-white popup-edit" style="min-width: 0" disabled>Chọn Màu & Size</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            $('.popup-body').html(html);
                            const button = document.querySelector(".popup-button");
                            $('.popup-button').click(function () {
                                myPopup.hide();
                            });
                            
                        }
                    });
                    
                },
            });
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            myPopup.show();
        }

        function changeColor(id, style, quantity, productId, thisSize, thisColor) {
            $('.active-color').removeClass('active');
            $('.color-ajax-'+id).parent().addClass('active');
            let thumnail = '';
            let slider = '';
            var src = '{{ asset('public/images/detail/') }}';

            $('#thumnail-ajax').html('');

            $.ajax({
                    method: "GET",
                    url: "{{ route('shop/detail-ajax') }}?color=" + id + '&style=' + style,
                    dataType: "json",
                    beforeSend: () => {
                        $('.loader').show();
                    },
                    complete: () => {
                        $('.loader').hide();
                    },
                    success: function(response) {
                        if (response.items.picture1 != null) {
                            let pic1 = src + '/' + style + '/' + '/' + response.items.color + '/' + response.items.picture1;
                            thumnail += `   <div class="col-12">
                                                <img src="` + pic1 + `">
                                            </div>`;
                        }
                        if (response.items.picture2 != null) {
                            let pic2 = src + '/' + style + '/' + '/' + response.items.color + '/' + response.items.picture2;
                            thumnail += `    <div class="col-12">
                                                <img src="` + pic2 + `">
                                            </div>`;
                        }
                        if (response.items.picture3 != null) {
                            let pic3 = src + '/' + style + '/' + '/' + response.items.color + '/' + response.items.picture3;
                            thumnail += `   <div class="col-12">
                                                <img src="` + pic3 + `">
                                            </div>`;
                        }
                        if (response.items.picture4 != null) {
                            let pic4 = src + '/' + style + '/' + '/' + response.items.color + '/' + response.items.picture4;
                            thumnail += `   <div class="col-12">
                                                <img src="` + pic4 + `">
                                            </div>`;
                        }
                        if (response.items.picture5 != null) {
                            let pic5 = src + '/' + style + '/' + '/' + response.items.color + '/' + response.items.picture5;
                            thumnail += `   <div class="col-12">
                                                <img src="` + pic5 + `">
                                            </div>`;
                        }
                        if (response.items.picture6 != null) {
                            let pic6 = src + '/' + style + '/' + '/' + response.items.color + '/' + response.items.picture6;
                            thumnail += `   <div class="col-12">
                                                <img src="` + pic6 + `">
                                            </div>`;
                        }

                        var htmlSize = '';
                        var sizeS = false;
                        var sizeM = false;
                        var sizeL = false;
                        for(var size of response.sizes){
                            if(size.size == 'S'){
                                sizeS = true;
                            }
                                
                            if(size.size == 'M'){
                                sizeM = true;
                            }

                            if(size.size == 'L'){
                                sizeL = true;
                            }
                        }

                        if(sizeS == true)
                            htmlSize += `<li class="check-size size-S" onclick="activeSize('S', '`+quantity+`', '`+productId+`', '`+response.items.color+`', '`+style+`', '`+thisSize+`', '`+thisColor+`')"  data-field="S">S</li>`;
                        else 
                            htmlSize += `<li class="check-size-disabled" data-placement="bottom" data-toggle="tooltip" title="Hết hàng">S</li>`;

                        if(sizeM == true)
                            htmlSize += `<li class="check-size size-M" onclick="activeSize('M', '`+quantity+`', '`+productId+`', '`+response.items.color+`', '`+style+`', '`+thisSize+`', '`+thisColor+`')"  data-field="M">M</li>`;
                        else 
                            htmlSize += `<li class="check-size-disabled" data-placement="bottom" data-toggle="tooltip" title="Hết hàng">M</li>`;

                        if(sizeL == true)
                            htmlSize += `<li class="check-size size-L" onclick="activeSize('L', '`+quantity+`', '`+productId+`', '`+response.items.color+`', '`+style+`', '`+thisSize+`', '`+thisColor+`')"  data-field="L">L</li>`;
                        else 
                            htmlSize += `<li class="check-size-disabled" data-placement="bottom" data-toggle="tooltip" title="Hết hàng">L</li>`;

                        $('#size').val('');
                        $('.size-text').text('');
                        $('#ajax-size').html(htmlSize);

                        $('#color').val(response.items.color);
                        $('.color-text').text('- ' + response.items.color);
                        $('#thumnail-ajax').html(thumnail);
                        if($('#size').val() == ''){
                            $('.popup-edit').text('Chon Size');
                            $('#error-quantity').text('');
                            $('#quantity').removeClass('d-none');
                            $('.popup-edit').attr('disabled','disabled');
                        } else {
                            $('.popup-edit').text('Cập nhật');
                            $('#error-quantity').text('');
                            $('#quantity').removeClass('d-none');
                            $('.popup-edit').removeAttr('disabled');
                        }
                        $('#quantity').val($('#quantity').val());
                    }
                });
        }

        function activeSize(size, quantity, id, color, style, thisSize, thisColor){
            $('.check-size').removeClass('check')
            $('.size-'+size).addClass('check');
            $('#size').val(size);
            $('.size-text').text('- '+ size);
            $.ajax({
                method: "GET",
                url: "{{ route('user/check-sku') }}?id=" + id + '&size=' + size + '&color=' + color + '&style=' + style,
                dataType: 'json',
                success: function(response) {
                    if(size == thisSize && color == thisColor){
                        $('#quantity').attr({"max" : response.stock});
                        if(response.stock < 0){
                            $('#error-quantity').text('Hết hàng');
                            $('#quantity').addClass('d-none');
                            $('.popup-edit').attr('disabled','disabled');
                            $('.popup-edit').text('Hết hàng');
                        } else if($('#color').val() == ''){
                            $('#quantity').removeClass('d-none');
                            $('#error-quantity').text('');
                            $('.popup-edit').text('Select Color');
                            $('.popup-edit').attr('disabled','disabled');
                        } else if(Number($('#quantity').val()) > Number($('#quantity').attr('max'))) {
                            $('#error-quantity').text('Chỉ còn ' + $('#quantity').attr('max') + ' sản phẩm');
                            $('.popup-edit').text('Nhập số lượng');
                            $('.popup-edit').attr('disabled','disabled');
                        } else {
                            $('#quantity').removeClass('d-none');
                            $('#error-quantity').text('');
                            $('.popup-edit').text('Update');
                            $('.popup-edit').removeAttr('disabled');
                        }
                    } else {
                        $('#quantity').attr({"max" : response.stock - response.quantity});
                        if(response.stock - response.quantity < 0){
                            $('#error-quantity').text('Hết hàng');
                            $('#quantity').addClass('d-none');
                            $('.popup-edit').attr('disabled','disabled');
                            $('.popup-edit').text('Hết hàng');
                        } else if($('#color').val() == ''){
                            $('#quantity').removeClass('d-none');
                            $('#error-quantity').text('');
                            $('.popup-edit').text('Chọn màu');
                            $('.popup-edit').attr('disabled','disabled');
                        } else if(Number($('#quantity').val()) > Number($('#quantity').attr('max'))) {
                            $('#error-quantity').text('Chỉ còn ' + $('#quantity').attr('max') + ' sản phẩm');
                            $('.popup-edit').text('Nhập số lượng');
                            $('.popup-edit').attr('disabled','disabled');
                        } else {
                            $('#quantity').removeClass('d-none');
                            $('#error-quantity').text('');
                            $('.popup-edit').text('Update');
                            $('.popup-edit').removeAttr('disabled');
                        }
                    }
                    
                    $('#quantity').val($('#quantity').val());
                    if(response.stock < 0){
                        $('#error-quantity').text('Hết hàng');
                        $('#quantity').addClass('d-none');
                        $('.popup-edit').attr('disabled','disabled');
                        $('.popup-edit').text('Hết hàng');
                    } else if($('#color').val() == ''){
                        $('#quantity').removeClass('d-none');
                        $('#error-quantity').text('');
                        $('.popup-edit').text('Chọn màu');
                        $('.popup-edit').attr('disabled','disabled');
                    } else if(Number($('#quantity').val()) > Number($('#quantity').attr('max'))) {
                        $('#error-quantity').text('Chỉ còn ' + $('#quantity').attr('max') + ' sản phẩm');
                        $('.popup-edit').text('Nhập số lượng');
                        $('.popup-edit').attr('disabled','disabled');
                    }else {
                        $('#quantity').removeClass('d-none');
                        $('#error-quantity').text('');
                        $('.popup-edit').text('Cập nhật');
                        $('.popup-edit').removeAttr('disabled');
                    }
                }
            });
        }

        function changeQuantity(){
            var max = Number($('#quantity').attr('max'));
            var value = Number($('#quantity').val());
            if(value > max){
                $('#error-quantity').text('Chỉ còn ' + max + ' sản phẩm');
                $('.popup-edit').text('Nhập số lượng');
                $('.popup-edit').attr('disabled','disabled');
            } else {
                $('#error-quantity').text('');
                if($('#color').val() == '' || $('#size').val() == ''){
                    $('.popup-edit').text('Chọn Màu & Size');
                    $('.popup-edit').attr('disabled','disabled');
                } else {
                    $('.popup-edit').text('Cập nhật');
                    $('.popup-edit').removeAttr('disabled');
                }
            }
        }
    </script>
@endsection
