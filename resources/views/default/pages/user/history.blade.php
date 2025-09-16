@extends('default.pages.user.main')
@section('user')
    
    @if(count($items) > 0)
        <hr style="height: 1.1px; background: transparent">
        <div class="cart-table-area ml-0" id="result">
            <div class="row filter-new-in justify-content-center mb-3">
                <ul class="d-flex justify-content-center flex-wrap filter-ajax">
                    <li class="active filter" data-filter="all" style="cursor: pointer">
                        <a>Tất cả</a>
                    </li>
                    @foreach ($items as $key => $value)
                        @php
                            $arrFilter[] = $value['status'];
                            $result = array_unique($arrFilter);
                        @endphp
                    @endforeach
                    @foreach ($result as $key => $value)
                    @php
                        switch($value){
                            case 'pending':
                                $filterStatus = 'Chờ xác nhận';
                                break;
                            case 'approved':
                                $filterStatus = 'Đã xác nhận';
                                break;
                            case 'packaging':
                                $filterStatus = 'Đang đói gói';
                                break;
                            case 'shipping':
                                $filterStatus = 'Đang vận chuyển';
                                break;
                            case 'delivered':
                                $filterStatus = 'Giao hàng thành công';
                                break;
                        }
                    @endphp
                        <li style="cursor: pointer" class="px-3 py-2 filter" data-filter="{{ $value }}"><a style="text-transform: capitalize">{{ $filterStatus }}</a></li>
                    @endforeach
                </ul>
            </div>
            @foreach($items as $keyItem => $valueItem)
                <div class="container-fluid order {{ $valueItem['status'] }}" data-field="{{ $valueItem['status'] }}">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-6">
                            <div class="cart-table clearfix">
                                <div class="row">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach($details as $keyDetail => $valueDetail)
                                        @if($valueDetail['identify'] == $valueItem['cart_id'] && $count < 3)
                                            @php
                                                if($count < 2){
                                                    $link = route('shop/detail', ['id' => $valueDetail['product_id'], 'name' => Str::slug($valueDetail['product_name'])]);
                                                    $picture = '<img src="'.asset('public/images/product/' . $valueDetail['product_name'] . '/' . $valueDetail['product_picture1']).'">';
                                                    
                                                    $block = '  <div class="col-4 col-lg-4">
                                                                    <a href="'.$link.'">
                                                                        '.$picture.'
                                                                    </a>
                                                                </div>';
                                                } else{
                                                    $picture = '<img style="width: 50%" src="'.asset('public/default/img/core-img/more.png/').'">';
                                                    $link =  route('user/history-detail', ['id' => $valueItem['cart_id']]);
                                                    $block = '  <div class="col-4 col-lg-4 row text-center align-items-center">
                                                                    <a href="'.$link.'">
                                                                            '.$picture.'
                                                                    </a>
                                                                </div>';
                                                }
                                                    
                                                $count++;
                                            @endphp

                                            {!! $block !!}

                                        @endif                                    
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="checkout_details_area mt-50 clearfix">
                                <div class="login-title">
                                    <h4 class="sans-serif">#{{ $valueItem['cart_id'] }}</h4>
                                </div>
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <small class="text-primary">Giá trị đơn hàng</small>
                                        <p>{{ $valueItem['total'] }}<span class="currency">đ</span></p>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <small class="text-primary">Phương thức thanh toán</small>
                                        @php
                                            switch($valueItem['payment_method']){
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
                                    <div class="col-6 col-md-6">
                                        <small class="text-primary">Ngày đặt hàng</small>
                                        <p>{{ date('H:i:s d/m/Y', strtotime($valueItem['created'])); }}</p>
                                    </div>
                                    
                                    <div class="col-6 col-md-6" id="block-time-{{ $valueItem['cart_id'] }}">
                                        @foreach($refund as $key => $value)
                                            @if ($value['cart_id'] == $valueItem['cart_id'])
                                                <small class="text-primary">Ngày đổi hàng</small>
                                                <p style="text-transform: capitalize">{{ date('H:i:s d/m/Y', strtotime($value['created'])); }}</p>
                                            @endif
                                        @endforeach
                                        @if($valueItem['cancel'] == 'default')
                                            <small class="text-primary">Trạng thái</small>
                                            @php
                                                switch($valueItem['status']){
                                                    case 'pending':
                                                        $status = 'Chờ xác nhận';
                                                        break;
                                                    case 'approved':
                                                        $status = 'Đã xác nhận';
                                                        break;
                                                    case 'packaging':
                                                        $status = 'Đang đói gói';
                                                        break;
                                                    case 'shipping':
                                                        $status = 'Đang vận chuyển';
                                                        break;
                                                    case 'delivered':
                                                        $status = 'Giao hàng thành công';
                                                        break;
                                                }
                                            @endphp
                                            <p style="text-transform: capitalize">{{ $status }}</p>
                                        @endif
                                        @if($valueItem['cancel'] == 'approved' || $valueItem['cancel'] == 'pending')
                                            <small class="text-primary">Ngày hủy đơn</small>
                                            <p style="text-transform: capitalize">{{ date('H:i:s d/m/Y', strtotime($valueItem['cancel_date'])); }}</p>
                                        @endif
                                        
                                    </div>

                                    <div class="col-6 col-md-6">
                                        <small>    </small>
                                        <a href="{{ route('user/history-detail', ['id' => $valueItem['cart_id']]) }}" class="btn artiz-btn w-100 text-white" style="min-width: 0">Xem chi tiết</a>
                                    </div>
                                    

                                    <div class="col-6 col-md-6" id="block-cancel-{{ $valueItem['cart_id'] }}">
                                        @if($valueItem['cancel'] == 'default')
                                            @if($valueItem['status'] == 'pending' || $valueItem['status'] == 'approved' || $valueItem['status'] == 'packaging')
                                                <small>    </small>
                                                <p onclick="showPopupCancel('{{ $valueItem['cart_id'] }}')" class="btn artiz-btn-black w-100" id="button-cancel" style="min-width: 0">Hủy đơn hàng</p>
                                            @endif
                                        @else
                                            @if($valueItem['cancel'] == 'pending')
                                                <small>    </small>
                                                <p class="btn artiz-btn-black w-100" style="min-width: 0">Chờ xác nhận hủy</p>
                                            @else 
                                                @if($valueItem['cancel'] == 'approved')
                                                    <small>    </small>
                                                    <p class="btn artiz-btn-black w-100" style="min-width: 0">Hủy thành công</p>
                                                @else
                                                    <small>    </small>
                                                    <p class="btn artiz-btn-black w-100" style="min-width: 0">Từ chối hủy</p>
                                                @endif
                                            @endif
                                        @endif
                                        
                                        @if($valueItem['status'] == 'delivered' && $valueItem['cancel'] == 'default')
                                            @if($refund != null)
                                                @php
                                                    $flag = false;
                                                @endphp
                                                @foreach ($refund as $key => $value)
                                                    @if ($value['cart_id'] == $valueItem['cart_id'])
                                                        @php
                                                            $flag = true;
                                                        @endphp
                                                        @if($value['status'] == 'pending')
                                                            <small> </small>
                                                            <p class="btn artiz-btn-black w-100" style="min-width: 0">Chờ xác nhận đổi</p>
                                                        @endif
                                                        @if ($value['status'] == 'approved')
                                                            <small>    </small>
                                                            <p class="btn artiz-btn-black w-100" style="min-width: 0">Đổi thành công</p>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                @if(strtotime($valueItem['modified']) - (time() - 7*24*3600) > 0 && $flag == false)
                                                    <small>    </small>
                                                    <p onclick='showPopupRefund("{{ $valueItem["cart_id"] }}")' class="btn artiz-btn-black w-100" id="button-refund" style="min-width: 0">Đổi hàng</p>
                                                @endif
                                            @else
                                                @if (strtotime($valueItem['modified']) - (time() - 7*24*3600) > 0)
                                                    <small>    </small>
                                                    <p onclick='showPopupRefund("{{ $valueItem["cart_id"] }}")' class="btn artiz-btn-black w-100" id="button-refund" style="min-width: 0">Đổi hàng</p>
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="height: 1.1px; background: transparent">
                </div>
                
            @endforeach
            {!! $items->appends(request()->input())->links('default.template.pagination') !!}
        </div>
        <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script type="text/javascript">
            function showPopupCancel(id) {
                if($('.popup').hasClass("fade-out")){
                    $('.popup').remove();
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
                                            Vui lòng nhập lý do! (*)
                                            </label>
                                        <textarea type="text" class="form-control" name="reason_cancel" id="other-`+id+`"></textarea>
                                        <small class="text-danger" id="error-reason-`+id+`" style="font-size: 13.2px"></small>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col-6">
                                            <a class="btn artiz-btn w-100 mt-4 text-white popup-button" style="min-width: 0">Đóng</a>
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
                                    document.getElementById("error-reason-"+id).textContent = 'Vui lòng nhập lý do!!';
                                } else {
                                    $(this).addClass(CSS_ADDING);
                                    reason = $('#other-'+id).val();
                                        $.ajax({
                                        url: "{{ route('user/cancel') }}?id=" + id + '&reason_cancel=' + reason,
                                        type: "GET",
                                        dataType: 'json',
                                        success: function(response) {
                                            $('.popup-cancel').removeClass(CSS_ADDING);
                                            $('#block-cancel-'+id).html(`<p class="btn artiz-btn-black w-100" style="min-width: 0">`+response.message+`</p>`);
                                            $('#block-time-'+id).html(`<small class="text-primary">Ngày hủy đơn</small>
                                                                        <p style="text-transform: capitalize">`+response.time+`</p>`
                                                                    );
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
                                            $('#block-cancel-'+id).html(`<p class="btn artiz-btn-black w-100" style="min-width: 0">`+response.message+`</p>`);
                                            $('#block-time-'+id).html(`<small class="text-primary">Ngày hủy đơn</small>
                                                                        <p style="text-transform: capitalize">`+response.time+`</p>`
                                                                    );
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
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
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
                                        <h3 class="sans-serif text-primary">Đổi hàng #`+id+`</h3>
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
                                                                                <input class="form-check-input check-product check-`+item.product_id+`" data-field="`+item.product_id+`" `+disabled+` title="`+title+`" type="checkbox" name="product[`+item.product_id+`]" value="`+item.product_id+`">
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
                                                                                <option value="default" selected>Change to</option>`;
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
                                                                <small>Nếu bạn muốn đổi sang sản phẩm khác, <a href="exchange/`+id+`"  class="text-primary"><small>Click vào đây</small></a></small>
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
                                                        Nhập lý do (*)
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

            $('.filter').click(function() {
                $(this).addClass('active').siblings().removeClass('active');
                var filter = $(this).attr('data-filter');

                if (filter == 'all') {
                    $('.order').show(400);
                } else {
                    $('.order').not('.' + filter).hide(200);
                    $('.order').filter('.' + filter).show(400);
                }
            })
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
    @else
    <div class="row text-center justify-content-center">
        <img fetchpriority="high" style="width: 200px" class="my-5" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/result.png') }}">
        <div class="col-md-12 text-center">
            <h2>You don’t currently have any orders</h2>
            <p class="mt-3">Once you have checked out, you can view and track your order here</p>
            <a style="text-decoration: underline" href="{{ route('new-in') }}">Shop What's New</a>
        </div>
    </div>
    @endif
    <style>
        .filter-new-in li {
            padding: 8px 15px;
        }

        .filter-new-in li.active {
            background: #800020;
            color: #ffffff;
        }

        select option {
            text-align: left;
        }
    </style>
@endsection
