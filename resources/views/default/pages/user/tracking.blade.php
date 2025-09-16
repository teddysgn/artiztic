@extends('default.pages.user.main')
@section('user')

    
        <div class="row mt-3">
            <div class="col-8 col-lg-4">
                <div class="form-group">
                    <input type="text" class="form-control" name="search" placeholder="Mã đơn hàng (*)" id="input-search">
                    <small class="text-danger" id="error-history"></small>
                </div>
            </div>
            <div class="col-4 col-lg-2">
                <div class="form-group">
                    <button type="button" name="button-search" id="button-search" style="min-width: 0;" class="btn artiz-btn position-relative btn-add-to-cart w-100" >
                        <span class="btn-state state-default">Tìm kiếm</span>
                        <span class="btn-state state-adding">
                            <span class="animation-ellipsis">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </span>Đang xử lý</span>
                    </button>
                </div>
            </div>
        </div>
        <hr style="height: 1.1px; background: transparent">
        <div class="cart-table-area ml-0" id="result">
            
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
        <script>
            $(document).ready(function(){
                $('#button-search').click(function() {
                    var id = $('#input-search').val();
                    var error     = document.getElementById("error-history");
                    const CSS_ADDING = 'cart-adding';
                    if(id != ''){
                        var html = '';
                        var src = '{{ asset('public/images/product/') }}';
                        var pictureDefault = '{{ asset('public/default/img/core-img/more.png/') }}';
                        $(this).addClass(CSS_ADDING);
                            
                        $.ajax({
                            url: "{{ route('user/tracking') }}?id=" + id,
                            type: "GET",
                            dataType: 'json',
                            success: function(response) {
                                setTimeout(() => {
                                    $('#button-search').removeClass(CSS_ADDING);
                                }, 1000); 
                                if(response.item != null){
                                    $('#result').html('');
                                    var count = 0;
                                    html += `<div class="container-fluid">
                                                <div class="row align-items-center">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="cart-table clearfix">
                                                            <div class="row">`;
                                                                for(var detail of response.details){
                                                                    if(count < 2){     
                                                                        var name = detail.product_name.toLowerCase().replace(" ", "-");
                                                                        html += `<div class="col-4 col-lg-4">
                                                                                    <a href="../shop/detail/`+name+`-`+detail.product_id+`">
                                                                                        <img src="`+ src + '/' + detail.product_name + '/' + detail.product_picture1 +`">
                                                                                    </a>
                                                                                </div>`;
                                                                    } else {
                                                                        html += `<div class="col-4 col-lg-4 row text-center align-items-center">
                                                                                    <a href="history-detail/`+response.item.cart_id+`">
                                                                                        <img style="width: 50%" src="`+ pictureDefault +`">
                                                                                    </a>
                                                                                </div>`;
                                                                    }
                                                                    count++;
                                                                }                        
                                                            html += `
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="checkout_details_area mt-50 clearfix">
                                                            <div class="login-title">
                                                                <h4 class="sans-serif">#`+response.item.cart_id+`</h4>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-6 col-md-6">
                                                                    <small class="text-primary">Giá trị đơn hàng</small>
                                                                    <p>`+response.item.total+`<span class="currency">đ</span></p>
                                                                </div>
                                                                <div class="col-6 col-md-6">
                                                                    <small class="text-primary">Phương thức thanh toán</small>`;
                                                                    var paymentMethod = '';
                                                                    switch(response.item.payment_method){
                                                                        case 'cash on delivery':
                                                                            paymentMethod = 'Thanh toán trả sau';
                                                                            break;
                                                                        case 'mobile banking':
                                                                            paymentMethod = 'Thanh toán chuyển khoản';
                                                                            break;
                                                                    }
                                                            html += `<p style="text-transform: capitalize">`+paymentMethod+`</p>
                                                                </div>
                                                                <div class="col-6 col-md-6">
                                                                    <small class="text-primary">Ngày đặt hàng</small>
                                                                    <p>`+response.item.created+`</p>
                                                                </div>
                                                                <div class="col-6 col-md-6" id="block-time-`+response.item.cart_id+`">`;
                                                                    if(response.item.cancel == 'default'){
                                                                        var status = '';
                                                                        switch(response.item.status){
                                                                            case 'pending':
                                                                                status = 'Chờ xác nhận';
                                                                                break;
                                                                            case 'approved':
                                                                                status = 'Đã xác nhận';
                                                                                break;
                                                                            case 'packaging':
                                                                                status = 'Đang đói gói';
                                                                                break;
                                                                            case 'shipping':
                                                                                status = 'Đang vận chuyển';
                                                                                break;
                                                                            case 'delivered':
                                                                                status = 'Giao hàng thành công';
                                                                                break;
                                                                        }
                                                                        html += `<small class="text-primary">Trạng thái</small>
                                                                                <p style="text-transform: capitalize">`+status+`</p>`;
                                                                    } else {
                                                                        html += `<small class="text-primary">Ngày hủy đơn</small>
                                                                                <p style="text-transform: capitalize">`+response.item.cancel_date+`</p>`;
                                                                    }
                                                                    
                                                        html += `</div>
                                                                <div class="col-6 col-md-6">
                                                                    <small>    </small>
                                                                    <a href="history-detail/`+response.item.cart_id+`" class="btn artiz-btn w-100 text-white" style="min-width: 0">Xem chi tiết</a>
                                                                </div>
                                                                <div class="col-6 col-md-6" id="block-cancel-`+response.item.cart_id+`">`;
                                                                    if(response.item.cancel == 'default'){
                                                                        if(response.item.status == 'pending' || response.item.status == 'approved' || response.item.status == 'packaging'){
                                                                            html += `<small>    </small>
                                                                                    <p onclick="showPopupCancel('`+response.item.cart_id+`')" class="btn artiz-btn-black w-100" id="button-cancel" style="min-width: 0">Hủy đơn hàng</p>`;
                                                                        } 
                                                                    } else if(response.item.cancel == 'pending'){
                                                                            html += `<small>    </small>
                                                                                    <p class="btn artiz-btn-black w-100" style="min-width: 0">Chờ xác nhận hủy</p>`;
                                                                    } else if(response.item.cancel == 'approved') {
                                                                        html += `<small>    </small>
                                                                                <p class="btn artiz-btn-black w-100" style="min-width: 0">Hủy thành công</p>`;
                                                                    } else {
                                                                        html += `<small>    </small>
                                                                                <p class="btn artiz-btn-black w-100" style="min-width: 0">Từ chối hủy</p>`;
                                                                    }

                                                                    var currentdate = new Date();
                                                                    if(response.refund){
                                                                        if(response.item.status == 'delivered' && response.item.cancel == 'default'){
                                                                            if(response.refund.status == 'pending'){
                                                                                html += `<small>    </small>
                                                                                        <p class="btn artiz-btn-black w-100" style="min-width: 0">Chờ xác nhận đổi</p>`;
                                                                            }
                                                                            if(response.refund.status == 'approved') {
                                                                                    html += `<small>    </small>
                                                                                            <p class="btn artiz-btn-black w-100" style="min-width: 0">Đổi thành công</p>`;
                                                                            } else if(response.item.modified - (currentdate.getTime()/1000 - 7*24*3600) > 0){
                                                                                html += `<small>    </small>
                                                                                            <p onclick='showPopupRefund("`+response.item.cart_id+`")' class="btn artiz-btn-black w-100" id="button-refund" style="min-width: 0">Đổi hàng</p>`;
                                                                            }
                                                                        }
                                                                    } else if(response.item.modified - (currentdate.getTime()/1000 - 7*24*3600) > 0){
                                                                        html += `<small>    </small>
                                                                                    <p onclick='showPopupRefund("`+response.item.cart_id+`")' class="btn artiz-btn-black w-100" id="button-refund" style="min-width: 0">Đổi hàng</p>`;
                                                                    }
                                                                    
                                                                    
                                                        html += `</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`;
                                        $('#result').html(html);
                                } else {
                                    $('#result').html('');
                                    error.textContent = 'Rất tiếc, chúng tôi không tìm thấy đơn hàng nào';
                                }
                            }
                        });
                    }  else {
                        error.textContent = 'Vui lòng nhập mã đơn hàng';
                    }
                })
            });

            function showPopupCancel(id) {
                if($('.popup').hasClass("fade-out")){
                    $('.popup-').remove();
                }
                var html = '';
                const myPopup = new Popup({
                    id: "my-popup-" + id,
                    hideTitle: true,
                    title: "",
                    content: ``,
                    loadCallback: () => {
                        html += `<div style="overflow: hidden; text-align: left">
                                    <h3 class="sans-serif text-primary">Huy đơn #`+id+`</h3>
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
                                            Nhập lý do (*)
                                            </label>
                                        <textarea type="text" class="form-control" name="invoice" id="other-`+id+`"></textarea>
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

                var html = '';
                var data = [];
                var src = '{{ asset('public/images/product/') }}';
                const myPopup = new Popup({
                    id: "my-popup-" + id,
                    hideTitle: true,
                    title: "",
                    content: ``,
                    loadCallback: () => {
                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip()
                        });
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
                                                        Enter the reason *
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
            select option {
                text-align: left;
            }
        </style>
@endsection
