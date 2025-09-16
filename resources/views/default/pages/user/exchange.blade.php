@extends('default.main')
@section('content')
<div class="artiz_product_area">
    <div class="container-fluid">
        <div class="container-fluid">
            <form method="post" action="{{ route('user/refund') }}" id="formRefund">
                <div class="row">
                    @csrf
                    <div class="col-12 col-lg-12">
                        <div class="cart-title mt-50">
                            <h2>Đổi hàng #{{ $params['id'] }}</h2>
                        </div>

                        <div class="cart-table clearfix">
                            <table class="table table-responsive" tabindex="1" style="overflow: scroll !important; outline: none; touch-action: none;">
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
                                <tbody>
                                    @foreach($details as $key => $value)
                                        @php
                                            $disable = $value['discount'] > 0 ? 'disabled' : '';
                                            $title = $value['discount'] > 0 ? 'Sản phẩm không hợp lệ' : '';
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input check-product check-{{ $value['product_id'] }}" {{ $disable }} data-toggle="tooltip" data-placement="right" title="{{ $title }}" data-field="{{ $value['product_id'] }}" type="checkbox" name="product[{{ $value['product_id'] }}]" value="{{ $value['product_id'] }}">
                                                </div>
                                            </td>
                                            <td class="cart_product_img">
                                                <a href="#"><img src="{{ asset('public/images/product/' . $value['product_name']) . '/' . $value['product_picture1'] }}" alt="Product"></a>
                                            </td>
                                            <td class="cart_product_desc">
                                                <p class="m-0">{{ $value['product_name'] }}</p>
                                                <div id="block-pay-{{ $value['product_id'] }}">

                                                </div>
                                                <div id="block-product-{{ $value['product_id'] }}">

                                                </div>
                                            </td>
                                            <td class="qty">
                                                <input class="form-control text-center quantity-{{ $value['product_id'] }}" onchange="changeQuantity({{ $value['product_id'] }})" type="number" name="quantity[{{ $value['product_id'] }}]" max="{{ $value['quantity'] }}" min="1" value="{{ $value['quantity'] }}">
                                                <input type="hidden" class="hidden-quantity-{{ $value['product_id'] }}" value="{{ $value['quantity'] }}">
                                            </td>
                                            <td class="qty">
                                                <p class="m-0">{{ $value['color'] }}</p>
                                                <div id="block-color-{{ $value['product_id'] }}">

                                                </div>
                                            </td>
                                            <td class="qty">
                                                <p class="m-0">{{ $value['size'] }}</p>
                                                <div id="block-size-{{ $value['product_id'] }}">
                                                    
                                                </div>
                                                <input type="hidden" class="amount-{{ $value['product_id'] }}" value="0">
                                                <input type="hidden" class="single-{{ $value['product_id'] }}" value="0">
                                                <input type="hidden" name="price[{{ $value['product_id'] }}]" class="price-{{ $value['product_id'] }}" value="{{ $value['price'] * (100 - $value['discount']) / 100 }}">
                                                <input type="hidden" name="size[{{ $value['product_id'] }}]" class="size-{{ $value['product_id'] }}" value="">
                                                <input type="hidden" name="old_size[{{ $value['product_id'] }}]" value="{{ $value['size'] }}">
                                                <input type="hidden" name="color[{{ $value['product_id'] }}]" class="color-{{ $value['product_id'] }}" value="">
                                                <input type="hidden" name="old_color[{{ $value['product_id'] }}]" value="{{ $value['color'] }}">
                                                <input type="hidden" name="product[{{ $value['product_id'] }}]" class="product-{{ $value['product_id'] }}" value="">
                                                <input type="hidden" name="old_product[{{ $value['product_id'] }}]" value="{{ $value['product_id'] }}">
                                                <input type="hidden" name="style[{{ $value['product_id'] }}]" class="style-{{ $value['product_id'] }}" value="{{ $value['style'] }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-1" class="form-check-input not-other" type="radio" name="reason_refund" value="Sizing or fit issues." checked>
                                        <label for="reason-1" class="form-check-label not-other">
                                            Sizing or fit issues.
                                        </label>
                                    </div>
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-2" class="form-check-input not-other" type="radio" name="reason_refund" value="Damaged or defective item)">
                                        <label for="reason-2" class="form-check-label not-other">
                                            Damaged or defective item.
                                        </p>
                                    </div>
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-3" class="form-check-input not-other" type="radio" name="reason_refund" value="Did not meet expectations.">
                                        <label for="reason-3" class="form-check-label not-other">
                                            Did not meet expectations.
                                        </label>
                                    </div>
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-4" class="form-check-input not-other" type="radio" name="reason_refund" value="Changed mind or impulse purchase.">
                                        <label for="reason-4" class="form-check-label not-other">
                                            Changed mind or impulse purchase.
                                        </label>
                                    </div>
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-5" class="form-check-input not-other" type="radio" name="reason_refund" value="Incorrect order.">
                                        <label for="reason-5" class="form-check-label not-other">
                                            Incorrect order.
                                        </label>
                                    </div>
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-6" class="form-check-input not-other" type="radio" name="reason_refund" value="The products did not match the description.">
                                        <label for="reason-6" class="form-check-label not-other">
                                            The products did not match the description.
                                        </label>
                                    </div>
                                    <div class="form-check d-flex col-12">
                                        <input id="reason-7" class="form-check-input" type="radio" name="reason_refund" value="Other">
                                        <label for="reason-7" class="form-check-label">
                                            Khác
                                        </label>
                                    </div>
                                    <div class="form-group d-none col-12" id="reason-other">
                                        <label class="form-check-label my-2" for="other" style="font-size: 16px">
                                            Lý do đổi hàng (*)
                                            </label>
                                        <textarea type="text" class="form-control" id="other"></textarea>
                                        <small class="text-danger" id="error-reason" style="font-size: 13.2px"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-50">
                        <div class="note"></div>
                        <input type="hidden" name="amount" class="amount" value="0">
                        <button type="submit" class="btn artiz-btn-black w-100 mt-4 popup-refund" disabled style="min-width: 0">Chọn sản phẩm</button>
                        <input type="hidden" name="cart_id" value="{{ $params['id'] }}">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('.check-product').on('click',function(){
            var html = '';
            var id = $(this).data('field');
            var amount_product =  Number($('.amount-'+id).val());
            var amount =  Number($('.amount').val());
            var quantity = $('.quantity-'+id).val();
            if($("input:checkbox").filter(":checked").length > 1){
                if($('.check-'+id).prop('checked')){
                    $('.product-'+id).val(id);
                    $('.select-product-'+id).removeClass('d-none').html('');
                    $('#block-pay-'+id).removeClass('d-none').html('');

                    if(amount > 0){
                        $('.amount').val(Number(amount + amount_product));
                        $('.note').html(`<small class="text-primary">Note: Bạn cần trả thêm `+new Intl.NumberFormat().format(amount + amount_product)+`<span class="currency">đ</span></small>`);
                    } else {
                        $('.amount').val(Number(amount));
                    }
                    
                    if($('.select-product-'+id).val() != 'default'){
                        $.ajax({
                            type: "GET",
                            url: "{{ route('user/exchange-to-product') }}?id=" + id,
                            dataType: 'json',
                            
                            success: function(response) {
                                if(response.products != ''){
                                    html += `<select class="form-select nice-select select-product select-product-`+id+`" onchange="changeProduct(`+id+`)">
                                                <option value="default" selected>Đổi sang</option>`;
                                    for(var item of response.products){
                                        html += `<option value="`+item.id+`">`+item.name+`</option>`;
                                    }
                                    html += `</select>`;
                                } else {
                                    html += '<small class="text-danger">Hết hàng</small>'
                                }
                                
                                $('#block-product-'+id).html(html);
                            },
                        });
                    }              
                } else {
                    if(amount - amount_product > 0){
                        $('.amount').val(amount - amount_product);
                        $('.note').html(`<small class="text-primary">Note: Bạn cần trả thêm `+new Intl.NumberFormat().format(amount - amount_product)+ `<span class="currency">đ</span></small>`);
                    } else {
                        $('.amount').val(Number(amount));
                    }
                    
                    $('#block-pay-'+id).addClass('d-none');
                    $('.select-product-'+id).addClass('d-none');
                    $('.select-color-'+id).addClass('d-none');
                    $('.select-size-'+id).addClass('d-none');
                    $('.error-'+id).text('');
                    $('.size-'+id).val('');
                    $('.product-'+id).val('');
                    $('.color-'+id).val('');
                }
            } else {
                $('.note').html('');
                $('.amount').val(0);
                $('#block-pay-'+id).addClass('d-none');
                $('.select-product-'+id).addClass('d-none');
                $('.select-color-'+id).addClass('d-none');
                $('.select-size-'+id).addClass('d-none');
                $('.error-'+id).text('');
            }
            
            $('.popup-refund').text('Hoàn thành lựa chọn của bạn');
            $('.popup-refund').attr('disabled','disabled');
        });

        function changeProduct(id) {
            var price = $('.price-'+id).val();
            var amount = Number($('.amount').val());
            var select = $('.select-product-'+id).val();
            var quantity = $('.quantity-'+id).val();
            var html = ''
            $('.product-'+id).val(select);
            $.ajax({
                type: "GET",
                url: "{{ route('user/exchange-to-color') }}?id=" + select ,
                success: function(response) {
                    if(response.item != null){
                        $('.style-'+id).val(response.item.style);
                        html += `<select class="form-select nice-select select-color select-color-`+id+`" onchange="changeColor(`+id+`,`+select+`, `+response.item.style+`)">
                                    <option value="default" selected>Đổi sang</option>`;
                        var arrColor = response.item.color.split(',');
                        for(var colorSlb of response.colorSlb){
                            for(var color in arrColor){
                                if(arrColor[color] == colorSlb.id){
                                    html += `<option value="`+colorSlb.name+`">`+colorSlb.name+`</option>`;
                                }
                            }
                        }
                        html += `</select>`;
                    } else {
                        html += '<small class="text-danger error-'+id+'">Chọn sản phẩm cần đổi</small>';
                    }
                    
                    $('#block-color-'+id).html(html);

                    
                    var price_selected = response.item.price * (100 - response.item.discount) / 100;
                    if(price_selected > price){
                        var html_pay = `<small class="text-primary">Bạn cần trả thêm `+new Intl.NumberFormat().format((price_selected - price) * quantity)+`<span class="currency">đ</span></small>`;
                        $('#block-pay-'+id).html(html_pay);
                        amount = Number(amount + (price_selected - price - $('.amount-'+id).val()) * quantity);

                        
                        $('.amount').val(amount);
                        $('.amount-'+id).val(Number((price_selected - price) * quantity));
                        $('.single-'+id).val(Number((price_selected - price)));
                        $('.note').html('<small class="text-primary">Note: Bạn cần trả thêm '+new Intl.NumberFormat().format(amount)+'<span class="currency">đ</span></small>');
                    }
                        
                    $('.popup-refund').text('Hoàn thành lựa chọn của bạn');
                    $('.popup-refund').attr('disabled','disabled');
                },
            });
        }

        function changeColor(id, select, style) {
            var color = $('.select-color-'+id).val();
            var html = ''
            $('.color-'+id).val(color);
            $.ajax({
                type: "GET",
                url: "{{ route('user/history-sku') }}?product_id=" + select + '&style=' + style + '&color=' + color,
                
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
        }

        function changeQuantity(id){
            var data = $('.quantity-'+id).val();
            var amount_product = Number($('.amount-'+id).val());
            var single = $('.single-'+id).val();
            var quantity = $('.hidden-quantity-'+id).val();

            if(data < quantity){
                var amount_display = amount_product - single * Math.abs(data - quantity);
                var amount = Number($('.amount').val() - single * Math.abs(data - quantity));
            } else {
                var amount_display = amount_product + single * Math.abs(data - quantity);
                var amount = Number(Number($('.amount').val()) + single * Math.abs(data - quantity));
            }

            $('.amount-'+id).val(Number(amount_display));
            $('#block-pay-'+id).html(`<small class="text-primary">Bạn cần trả thêm `+new Intl.NumberFormat().format(amount_display)+`<span class="currency">đ</span></small>`);
            
            $('.amount').val(amount);
            $('.note').html('<small class="text-primary">Note: Bạn cần trả thêm '+new Intl.NumberFormat().format(amount)+'<span class="currency">đ</span></small>');
            $('.hidden-quantity-'+id).val(data);
        }
        
        
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
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
            $('#reason-7').click(function(){
                $('#reason-other').removeClass('d-none');
                $('#other').attr("required", true);
            });

            $('.not-other').click(function(){
                $('#reason-other').addClass('d-none');
                $('#other').removeAttr("required");
                document.getElementById("error-reason").textContent = '';
            });

            $('#other').keyup(function(){
                document.getElementById("error-reason").textContent = '';
                if($(this).val() == ''){
                    document.getElementById("error-reason").textContent = 'Vui lòng nhập lý do';
                }
            });
        });
    </script>

@endsection
