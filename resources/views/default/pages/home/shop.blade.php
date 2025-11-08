<?php
use Illuminate\Support\Number;
use Illuminate\Support\Str;
?>
@extends('default.main')
@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <div class="artiz_product_area section-padding-100">

        <div class="container-fluid">
            <input type="hidden" id="category-hidden"
                value="@php echo $params['category_id'] != 'all' ? $params['category_id'] : 'all' @endphp">
            <input type="hidden" id="occasion-hidden"
                value="@php echo $params['occasion_id'] != 'all' ? $params['occasion_id'] : 'all' @endphp">
            <input type="hidden" id="collection-hidden"
                value="@php echo $params['collection_id'] != 'all' ? $params['collection_id'] : 'all' @endphp">
            <input type="hidden" id="color-hidden" value="all">
            <input type="hidden" id="size-hidden" value="all">
            <input type="hidden" id="price-hidden" value="all">
            <input type="hidden" id="search-hidden" value="">
            <div class="row">
                <div class="col-12">
                    <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                        <!-- Total Products -->
                        <div class="total-products d-flex flex-wrap" id="result-ajax-button">
                            @if ($params['category_id'] != 'all')
                                <div class="view d-flex mr-4 mb-4" id="button-category" onclick="removeButton('category')">
                                    <a id="category-filter" class="px-3">{{ $nameCategory }}</a>
                                    <i style="color: #ffffff" 
                                        class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center"
                                        data-field="category"></i>
                                </div>
                            @endif

                            @if ($params['collection_id'] != 'all')
                                <div class="view d-flex mr-4 mb-4" id="button-collection" onclick="removeButton('collection')">
                                    <a id="collection-filter" class="px-3">{{ $nameCollection }}</a>
                                    <i style="color: #ffffff"
                                        class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center"
                                        data-field="collection"></i>
                                </div>
                            @endif

                            @if ($params['occasion_id'] != 'all')
                                <div class="view d-flex mr-4 mb-4" id="button-occasion" onclick="removeButton('occasion')">
                                    <a id="occasion-filter" class="px-3">{{ $nameOccasion }}</a>
                                    <i style="color: #ffffff" 
                                        class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center"
                                        data-field="occasion"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="product-topbar align-items-end justify-content-between mb-3 row">
                        <div class="sort-by-date align-items-center col-12 col-lg-6">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="key_word" id="search_input" placeholder="Tên sản phẩm...">
                                        <div class="search-ajax-result form-group" id="search-ajax-result">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="button" id="btn-search" class="btn artiz-btn w-100" style="min-width: 0">Tìm</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="product-topbar d-xl-flex align-items-end justify-content-between mb-3">
                                <!-- Sorting -->
                                <div class="product-sorting d-flex justify-content-end">
                                    <div id="filter-mobile">
                                        <div class="view-product d-flex align-items-center">
                                            <p>All Filter</p>
                                            <box-icon name='filter' style="margin-bottom: 5px"></box-icon>
                                        </div>
                                    </div>
                                    <div class="sort-by-date d-flex align-items-center">
                                        <p>Lọc</p>
                                        <form action="#" method="get">
                                            <select name="select" id="sortBydate" class="nice-select">
                                                <option value="price-up" class="value">Giá tăng dần</option>
                                                <option value="price-down" class="value">Giá giảm dần</option>
                                                <option value="newest" class="value">Mới nhất</option>
                                                <option value="popular" class="value">Phổ biến</option>
                                            </select>
        
                                        </form>
                                    </div>
                                    <div class="view-product d-flex align-items-center">
                                        <p>Xem</p>
                                        <form action="#" method="get">
                                            <select name="select" id="viewProduct" class="nice-select">
                                                <option value="12">12</option>
                                                <option value="24">24</option>
                                                <option value="48">48</option>
                                                <option value="96">96</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="row justify-content-center">
                <div class="loader mb-5" style="display: none">
                </div>
            </div>
            <div class="row" id="ajax-result">
                @foreach ($items as $key => $value)
                    @php
                        $colorFilter = '';
                        if ($value['color'] != null) {
                            $color = explode(',', $value['color']);
                            foreach ($colorSlb as $keyColorSlb => $valueColorSlb) {
                                foreach ($color as $keyColor => $valueColor) {
                                    if ($keyColor == $valueColorSlb['id']) {
                                        $colorFilter .= ' ' . strtolower($valueColorSlb['name']);
                                    }
                                }
                            }
                        }

                        $id         = $value['id'];
                        $name       = $value['name'];
                       
                        $price      = number_format($value['price']);
                        $discount   = number_format($value['price'] * (100 - $value['discount'])/100);
                        $picture1   = asset('public/images/product/' . $value['name'] . '/' . $value['picture1']);
                        $picture2   = asset('public/images/product/' . $value['name'] . '/' . $value['picture2']);

                        
                    @endphp
                    <div class="single-products-catagory clearfix product">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12" style="padding-right: 6px; padding-left: 6px">
                            <div class="single-product-wrapper">
                                <a href="{{ route('shop/detail', ['id' => $value['id'], 'name' => Str::slug($value['name'])]) }}">
                                    <div class="product-img" data-toggle="tooltip" data-placement="right" title="{{ $name }}">
                                        <img src="{{ $picture1 }}" alt="">
                                        @if($value['picture2'] != null)
                                            <img class="hover-img" src="{{ $picture2 }}" alt="">
                                        @else
                                            <img class="hover-img" src="{{ $picture1 }}" alt="">
                                        @endif
                                    </div>
                                    <div class="flex w-100 row quick-view" onclick="event.preventDefault();" id="view-default"
                                        style="position: absolute; bottom: 10px; z-index: 100; margin: 0 auto">
                                        <div class="col-12">
                                            <button type="button" onclick="showPopup({{ $id }});" data-field="{{ $id }}" class="btn artiz-btn w-100 popup-element" style="min-width: 0; ">Xem nhanh</button>
                                        </div>
                                    </div>
                                    @if($value['discount'] > 0)
                                        <p data-placement="bottom"  class="btn btn-artiz" data-toggle="tooltip" title="Sale off" style="position: absolute; left: 5px; top: 5px; z-index:100; width: 50px; background-color: #968B7E; color: white; border-radius: 5px; border-color: #968B7E; padding: 0">
                                            -{{ $value['discount'] }}%
                                        </p>
                                    @endif
                                </a>

                                @php
                                    $like = '';
                                    $type = 'add';
                                    $title = 'Thêm vào danh sách yêu thích';
                                    $pictureURL = 'heart-default.png';
                                    foreach($favorites as $keyFavorite => $valueFavorite){
                                        if($value['id'] == $valueFavorite['product_id']){
                                            $like = 'liked';
                                            $type = 'remove';
                                            $title = 'Xóa khỏi danh sách yêu thích';
                                            $pictureURL = 'heart-active.png';
                                        } 
                                    }
                                @endphp
                                @if(Auth::check())
                                    <button type="button" aria-label="Favourite" class="button-like {{ $like }} element-{{ $id }}" onclick="actionLike({{ $id }})" data-field="{{ $type }}" data-placement="bottom" data-toggle="tooltip" title="{{ $title }}" style="position: absolute; right: 5px; top: 5px; z-index:100">
                                        <img class="heart-active-{{ $id }}" fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/'.$pictureURL) }}" style="color: transparent; width: 25px; height: auto;">
                                    </button>
                                @else
                                    <a href="{{ route('auth/login') }}" aria-label="Favourite" class="button-like element-{{ $id }}"  data-placement="right" data-placement="bottom" data-toggle="tooltip" title="Bạn cần đăng nhập trước" style="position: absolute; right: 5px; top: 5px; z-index:100">
                                        <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="color: transparent; width: 25px; height: auto;">
                                    </a>
                                @endif

                                <button type="button" class="button-view" id="view-mobile" onclick="showPopup({{ $id }})" data-placement="bottom" data-toggle="tooltip" title="Xem nhanh" style="position: absolute; right: 5px; top: 45px; z-index:100">
                                    <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/quick-view.png') }}" style="color: transparent; width: 25px; height: auto;">
                                </button>

                                <div class="product-description d-flex align-items-center justify-content-between">
                                    <div class="product-meta-data">
                                        <div class="line"></div>
                                        @if($value['discount'] > 0)
                                            <p class="product-price mb-1">
                                                {{ $discount }}<span class="currency">đ</span>
                                            </p>
                                            <p class="mb-1">
                                                <del>{{ $price }}<span class="currency">đ</span></del> <span class="btn btn-artiz" style="width: 50px; background-color: #968B7E; color: white; border-radius: 5px; border-color: #968B7E; padding: 0; margin-bottom: 5px">-{{ $discount }}%</span>
                                            </p>
                                        @else
                                            <p class="product-price">
                                                {{ $price }}<span class="currency">đ</span>
                                            </p>
                                        @endif
                                        <p>{{ $name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            
            <div class="row" id="block-load-more" @if($button == false) style="display: none" @endif>
                <div class="col-12">
                    <!-- Load More -->
                    <button id="btn-load-more" class="btn btn-sm artiz-btn-black d-flex align-items-center">Load More 
                        <div
                            style="display: none" class="ml-3 loader-more">
                        </div>
                    </button>
                </div>
            </div>
            
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>

    <script type="text/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(document).ready(function() {
            let limit           = 12;
            let start           = 0;
            var flagCollection  = true;
            var flagCategory    = true;
            var flagOccasion    = true;
            var flagColor       = true;
            var flagSize        = true;
            var flagPrice       = true;
            var flagSearch      = true;

            $('.filter').click(function() {
                var nameButton  = '';
                var html        = '';
                var button      = '';
                var navigation  = '';

                $(this).parent().addClass('active').siblings().removeClass('active');
                var filter = $(this).attr('data-filter').split('-');

                var category_id         = filter[0] == 'category' ? filter[1] : '';
                var occasion_id         = filter[0] == 'occasion' ? filter[1] : '';
                var collection_id       = filter[0] == 'collection' ? filter[1] : '';
                var color_id            = filter[0] == 'color' ? filter[1] : '';
                var size_id             = filter[0] == 'size' ? filter[1] : '';
                var price_id            = filter[0] == 'price' ? filter[1] : '';
                var key                 = $('#search_input').val();
                var sort                = $('#sortBydate').val();
                var view                = $('#viewProduct').val();
                
                var categoryHidden = $('#category-hidden').val();
                if (category_id === '') category_id = categoryHidden;

                var occasionHidden = $('#occasion-hidden').val();
                if (occasion_id === '') occasion_id = occasionHidden;

                var collectionHidden = $('#collection-hidden').val();
                if (collection_id === '') collection_id = collectionHidden;

                var colorHidden = $('#color-hidden').val();
                if (color_id === '') color_id = colorHidden;

                var sizeHidden = $('#size-hidden').val();
                if (size_id === '') size_id = sizeHidden;
                
                var priceHidden = $('#price-hidden').val();
                if (price_id === '') price_id = priceHidden;

                

                $('#ajax-result').html('');
                $.ajax({
                    type: "GET",
                    url: "{{ route('shop/filter') }}?category_id=" + category_id + '&occasion_id=' + occasion_id + '&collection_id=' + collection_id + '&color_id=' + color_id + '&size_id=' + size_id + '&price_id=' + price_id + '&key=' + key + '&sort=' + sort + '&view=' + view,
                    beforeSend: () => {
                        $('.loader').show();
                        $('.loader-mobile').show();
                    },
                    complete: () => {
                        $('.loader').hide();
                        $('.loader-mobile').hide();
                    },
                    success: function(response) {
                        document.getElementById("category-hidden").value    = response.category;
                        document.getElementById("occasion-hidden").value    = response.occasion;
                        document.getElementById("collection-hidden").value  = response.collection;
                        document.getElementById("color-hidden").value       = response.color;
                        document.getElementById("size-hidden").value        = response.size;
                        document.getElementById("price-hidden").value       = response.price;

                        if (response.category != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-category" onclick="removeButton(\'category\', '+category_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCategory + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="category"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-category').length > 0) {
                            document.getElementById("button-category").remove();
                        }

                        if (response.occasion != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-occasion" onclick="removeButton(\'occasion\', '+occasion_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameOccasion + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="occasion"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-occasion').length > 0) {
                            document.getElementById("button-occasion").remove();
                        }

                        if (response.collection != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-collection" onclick="removeButton(\'collection\', '+collection_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCollection + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="collection"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-collection').length > 0) {
                            document.getElementById("button-collection").remove();
                        }

                        if (response.color != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-color" onclick="removeButton(\'color\', '+color_id+')">';
                            button += '    <a id="color-filter" class="px-3">' + response.nameColor + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="color"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-color').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.size != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-size" onclick="removeButton(\'size\', '+size_id+')">';
                            button += '    <a id="size-filter" class="px-3">' + response.nameSize + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="size"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-size').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.price != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-price" onclick="removeButton(\'price\', '+price_id+')">';
                            button += '    <a id="price-filter" class="px-3">' + response.namePrice + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="price"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-price').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if(response.button == false){
                            $('#block-load-more').hide();
                        } else {
                            $('#block-load-more').show();
                        }

                        var _html = '';
                        if (response.items != '') {
                            _html += showItems(response.items, response.favorites);
                        } else {
                            _html += `<div class="row justify-content-center w-100">
                                        <div class="login-table-area section-padding-100 ml-0">
                                                <div class="container-fluid">
                                                    <div class="row text-center">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="login-title">
                                                                <img src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="width: 25%" class="mb-5" alt="">
                                                                <p>Rất tiếc, hiện tại chưa có sản phẩm bạn mong muốn!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                        }

                        $('#ajax-result').html(_html);
                        $('#navigation').html('');
                    },
                });
            });

            $('#btn-search').click(function (){
                var button          = '';
                var key             = $('#search_input').val();
                var category_id     = $('#category-hidden').val();
                var occasion_id     = $('#occasion-hidden').val();
                var collection_id   = $('#collection-hidden').val();
                var color_id        = $('#color-hidden').val();
                var size_id         = $('#size-hidden').val();                
                var price_id        = $('#price-hidden').val();
                var sort            = $('#sortBydate').val();
                var view            = $('#viewProduct').val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('shop/filter') }}?category_id=" + category_id + '&occasion_id=' + occasion_id + '&collection_id=' + collection_id + '&color_id=' + color_id + '&size_id=' + size_id + '&price_id=' + price_id + '&key=' + key + '&sort=' + sort + '&view=' + view,
                    beforeSend: () => {
                        $('.loader').show();
                        $('.loader-mobile').show();
                    },
                    complete: () => {
                        $('.loader').hide();
                        $('.loader-mobile').hide();
                    },
                    success: function(response) {
                        document.getElementById("category-hidden").value    = response.category;
                        document.getElementById("occasion-hidden").value    = response.occasion;
                        document.getElementById("collection-hidden").value  = response.collection;
                        document.getElementById("color-hidden").value       = response.color;
                        document.getElementById("size-hidden").value        = response.size;
                        document.getElementById("price-hidden").value       = response.price;

                        if (response.category != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-category" onclick="removeButton(\'category\', '+category_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCategory + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="category"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-category').length > 0) {
                            document.getElementById("button-category").remove();
                        }

                        if (response.occasion != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-occasion" onclick="removeButton(\'occasion\', '+occasion_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameOccasion + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="occasion"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-occasion').length > 0) {
                            document.getElementById("button-occasion").remove();
                        }

                        if (response.collection != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-collection" onclick="removeButton(\'collection\', '+collection_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCollection + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="collection"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-collection').length > 0) {
                            document.getElementById("button-collection").remove();
                        }

                        if (response.color != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-color" onclick="removeButton(\'color\', '+color_id+')">';
                            button += '    <a id="color-filter" class="px-3">' + response.nameColor + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="color"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-color').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.size != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-size" onclick="removeButton(\'size\', '+size_id+')">';
                            button += '    <a id="size-filter" class="px-3">' + response.nameSize + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="size"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-size').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.price != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-price" onclick="removeButton(\'price\', '+price_id+')">';
                            button += '    <a id="price-filter" class="px-3">' + response.namePrice + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="price"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-price').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if(response.button == false){
                            $('#block-load-more').hide();
                        } else {
                            $('#block-load-more').show();
                        }

                        var _html = '';
                        if (response.items != '') {
                            _html += showItems(response.items, response.favorites);
                        } else {
                            _html += `<div class="row justify-content-center w-100">
                                        <div class="login-table-area section-padding-100 ml-0">
                                                <div class="container-fluid">
                                                    <div class="row text-center">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="login-title">
                                                                <img src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="width: 25%" class="mb-5" alt="">
                                                                <p>Sorry, we can't find any results</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                        }

                        $('#ajax-result').html(_html);
                        $('#navigation').html('');
                    },
                });
            });

            $('#sortBydate').change(function() {
                var button          = '';
                var key             = $('#search_input').val();
                var category_id     = $('#category-hidden').val();
                var occasion_id     = $('#occasion-hidden').val();
                var collection_id   = $('#collection-hidden').val();
                var color_id        = $('#color-hidden').val();
                var size_id         = $('#size-hidden').val();                
                var price_id        = $('#price-hidden').val();
                var view            = $('#viewProduct').val();
                var sort            = $(this).val();
                start = 0;

                $.ajax({
                    type: "GET",
                    url: "{{ route('shop/filter') }}?category_id=" + category_id + '&occasion_id=' + occasion_id + '&collection_id=' + collection_id + '&color_id=' + color_id + '&size_id=' + size_id + '&price_id=' + price_id + '&key=' + key + '&sort=' + sort + '&view=' + view,
                    beforeSend: () => {
                        $('.loader').show();
                        $('.loader-mobile').show();
                    },
                    complete: () => {
                        $('.loader').hide();
                        $('.loader-mobile').hide();
                    },
                    success: function(response) {
                        document.getElementById("category-hidden").value    = response.category;
                        document.getElementById("occasion-hidden").value    = response.occasion;
                        document.getElementById("collection-hidden").value  = response.collection;
                        document.getElementById("color-hidden").value       = response.color;
                        document.getElementById("size-hidden").value        = response.size;
                        document.getElementById("price-hidden").value       = response.price;

                        if (response.category != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-category" onclick="removeButton(\'category\', '+category_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCategory + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="category"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-category').length > 0) {
                            document.getElementById("button-category").remove();
                        }

                        if (response.occasion != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-occasion" onclick="removeButton(\'occasion\', '+occasion_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameOccasion + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="occasion"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-occasion').length > 0) {
                            document.getElementById("button-occasion").remove();
                        }

                        if (response.collection != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-collection" onclick="removeButton(\'collection\', '+collection_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCollection + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="collection"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-collection').length > 0) {
                            document.getElementById("button-collection").remove();
                        }

                        if (response.color != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-color" onclick="removeButton(\'color\', '+color_id+')">';
                            button += '    <a id="color-filter" class="px-3">' + response.nameColor + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="color"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-color').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.size != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-size" onclick="removeButton(\'size\', '+size_id+')">';
                            button += '    <a id="size-filter" class="px-3">' + response.nameSize + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="size"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-size').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.price != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-price" onclick="removeButton(\'price\', '+price_id+')">';
                            button += '    <a id="price-filter" class="px-3">' + response.namePrice + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="price"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-price').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if(response.button == false){
                            $('#block-load-more').hide();
                        } else {
                            $('#block-load-more').show();
                        }

                        var _html = '';
                        if (response.items != '') {
                            _html += showItems(response.items, response.favorites);
                        } else {
                            _html += `<div class="row justify-content-center w-100">
                                        <div class="login-table-area section-padding-100 ml-0">
                                                <div class="container-fluid">
                                                    <div class="row text-center">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="login-title">
                                                                <img src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="width: 25%" class="mb-5" alt="">
                                                                <p>Sorry, we can't find any results</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                        }

                        $('#ajax-result').html(_html);
                        $('#navigation').html('');
                    },
                });
            });

            $('#viewProduct').change(function() {
                var button          = '';
                var key             = $('#search_input').val();
                var category_id     = $('#category-hidden').val();
                var occasion_id     = $('#occasion-hidden').val();
                var collection_id   = $('#collection-hidden').val();
                var color_id        = $('#color-hidden').val();
                var size_id         = $('#size-hidden').val();                
                var price_id        = $('#price-hidden').val();
                var sort            = $('#sortBydate').val();
                var view            = $(this).val();
                start               = 0;
                limit               = Number(view);

                $.ajax({
                    type: "GET",
                    url: "{{ route('shop/filter') }}?category_id=" + category_id + '&occasion_id=' + occasion_id + '&collection_id=' + collection_id + '&color_id=' + color_id + '&size_id=' + size_id + '&price_id=' + price_id + '&key=' + key + '&sort=' + sort + '&view=' + view,
                    beforeSend: () => {
                        $('.loader').show();
                        $('.loader-mobile').show();
                    },
                    complete: () => {
                        $('.loader').hide();
                        $('.loader-mobile').hide();
                    },
                    success: function(response) {
                        document.getElementById("category-hidden").value    = response.category;
                        document.getElementById("occasion-hidden").value    = response.occasion;
                        document.getElementById("collection-hidden").value  = response.collection;
                        document.getElementById("color-hidden").value       = response.color;
                        document.getElementById("size-hidden").value        = response.size;
                        document.getElementById("price-hidden").value       = response.price;

                        if (response.category != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-category" onclick="removeButton(\'category\', '+category_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCategory + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="category"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-category').length > 0) {
                            document.getElementById("button-category").remove();
                        }

                        if (response.occasion != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-occasion" onclick="removeButton(\'occasion\', '+occasion_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameOccasion + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="occasion"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-occasion').length > 0) {
                            document.getElementById("button-occasion").remove();
                        }

                        if (response.collection != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-collection" onclick="removeButton(\'collection\', '+collection_id+')">';
                            button += '    <a id="category-filter" class="px-3">' + response.nameCollection + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="collection"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-collection').length > 0) {
                            document.getElementById("button-collection").remove();
                        }

                        if (response.color != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-color" onclick="removeButton(\'color\', '+color_id+')">';
                            button += '    <a id="color-filter" class="px-3">' + response.nameColor + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="color"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-color').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.size != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-size" onclick="removeButton(\'size\', '+size_id+')">';
                            button += '    <a id="size-filter" class="px-3">' + response.nameSize + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="size"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-size').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if (response.price != 'all') {
                            button += '<div class="view d-flex mr-4 mb-4" id="button-price" onclick="removeButton(\'price\', '+price_id+')">';
                            button += '    <a id="price-filter" class="px-3">' + response.namePrice + '</a>';
                            button += '    <i style="color: #ffffff" class="fa-solid fa-xmark close px-2 close-button-filter d-flex align-items-center" data-field="price"></i>';
                            button += '</div>';
                            $("#result-ajax-button").html(button);
                        } else if ($('#button-price').length > 0) {
                            document.getElementById("button-color").remove();
                        }

                        if(response.button == false){
                            $('#block-load-more').hide();
                        } else {
                            $('#block-load-more').show();
                        }

                        var _html = '';
                        if (response.items != '') {
                            _html += showItems(response.items, response.favorites);
                        } else {
                            _html += `<div class="row justify-content-center w-100">
                                        <div class="login-table-area section-padding-100 ml-0">
                                                <div class="container-fluid">
                                                    <div class="row text-center">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="login-title">
                                                                <img src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="width: 25%" class="mb-5" alt="">
                                                                <p>Sorry, we can't find any results</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>`;
                        }

                        $('#ajax-result').html(_html);
                        $('#navigation').html('');
                    },
                });
            });

            

            function load_data_ajax(limit, start) {
                let data_occasion       = $('#occasion-hidden').val();
                let data_category       = $('#category-hidden').val();
                let data_collection     = $('#collection-hidden').val();
                let data_color          = $('#color-hidden').val();
                let data_size           = $('#size-hidden').val();
                let data_price          = $('#price-hidden').val();
                var data_search         = $('#search_input').val();
                var sort                = $('#sortBydate').val();
                var view                = $('#viewProduct').val();
                
                var _html = '';
                $.ajax({
                    url: "{{ route('shop/load-more') }}",
                    type: "GET",
                    data: {
                        limit:          limit,
                        start:          start,
                        category_id:    data_category,
                        occasion_id:    data_occasion,
                        collection_id:  data_collection,
                        color_id:       data_color,
                        size_id:        data_size,
                        price_id:       data_price,
                        key:            data_search,
                        sort:           sort,
                        view:           view,
                    },
                    beforeSend: () => {
                        $('.loader-more').show();
                    },
                    complete: () => {
                        $('.loader-more').hide();
                    },
                    dataType: 'json',
                    success: function(response) {
                        _html += showItems(response.items, response.favorites);
                        $('#ajax-result').append(_html);

                        if(response.button == false){
                            $('#block-load-more').hide();
                        }
                    }
                });
            }

            $('#btn-load-more').click(function() {
                start = start + limit;
                let data_occasion       = $('#occasion-hidden').val();
                let data_category       = $('#category-hidden').val();
                let data_collection     = $('#collection-hidden').val();
                let data_color          = $('#color-hidden').val();
                let data_size           = $('#size-hidden').val();
                let data_price          = $('#price-hidden').val();
                var data_search         = $('#search_input').val();


                if (data_occasion != 'all' && start > 0 && flagOccasion == true) {
                    start = 0;
                    start = start + limit;
                    flagOccasion = false;
                }

                if (data_category != 'all' && start > 0 && flagCategory == true) {
                    start = 0;
                    start = start + limit;
                    flagCategory = false;
                }

                if (data_collection != 'all' && start > 0 && flagCollection == true) {
                    start = 0;
                    start = start + limit;
                    flagCollection = false;
                }

                if (data_color != 'all' && start > 0 && flagColor == true) {
                    start = 0;
                    start = start + limit;
                    flagColor = false;
                }

                if (data_price != 'all' && start > 0 && flagPrice == true) {
                    start = 0;
                    start = start + limit;
                    flagPrice = false;
                }

                if (data_size != 'all' && start > 0 && flagSize == true) {
                    start = 0;
                    start = start + limit;
                    flagSize = false;
                }

                if (data_search != '' && start > 0 && flagSearch == true) {
                    start = 0;
                    start = start + limit;
                    flagSearch = false;
                }


                load_data_ajax(limit, start);
            }); 

            $('#filter-mobile').click(function(){
                $('#top').toggleClass('bp-xs-on');
            });

            $('#search_input').click(function(){
                $(".search-ajax-result").removeClass("hide");
            });

            document.addEventListener('click', e => {
                if(e.target != document.getElementById('search_input')){
                    $(".search-ajax-result").addClass("hide");
                }
            });

            $('#search_input').keyup(function(){
                var key             = $(this).val();
                var category_id     = $('#category-hidden').val();
                var occasion_id     = $('#occasion-hidden').val();
                var collection_id   = $('#collection-hidden').val();
                var color_id        = $('#color-hidden').val();
                var size_id         = $('#size-hidden').val();                
                var price_id        = $('#price-hidden').val();

                var html = '';
                var src = '{{ asset('public/images/product/') }}';

                $.ajax({
                    type: "GET",
                    url: "{{route('shop/search-ajax')}}?category_id=" + category_id + '&occasion_id=' + occasion_id + '&collection_id=' + collection_id + '&color_id=' + color_id + '&size_id=' + size_id + '&price_id=' + price_id + '&key=' + key,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){                       
                            var name = pro.name.toLowerCase().replace(" ", "-");
                            var fill = name.split("");
                            var root = key.split("");

                             var displayName = '';
                            //     fill.forEach((elementFill) => {
                            //         if(elementFill == key){
                            //             displayName += `<span class="text-danger">`+elementFill+`</span>`;
                            //         }
                                        
                            //         else
                            //             displayName += `<span>`+elementFill+`</span>`;
                            //     });

                            var checkName = pro.name; // Blouse 1 - blouse 1 ~ blo

                            if(checkName.toLowerCase().includes(key.toLowerCase()) || checkName.includes(key)){
                                if(key == key.toLowerCase())
                                    displayName = checkName.toLowerCase().replaceAll(key.toLowerCase(), `<span class="text-danger">`+key.toLowerCase()+`</span>`);
                                else
                                    displayName = checkName.replaceAll(key, `<span class="text-danger">`+key+`</span>`);
                            } else {
                                displayName = checkName;
                            }
                                
                            
                            
                            html += '<a href="shop/detail/'+name+'-'+pro.product_id+'">'
                            html += '<div class="media mb-2 align-items-center">';
                            html += '    <div class="media-body">';
                            html += '        <p class="media-heading m-0 px-2" style="text-transform: capitalize">'+displayName+'</p>';
                            html += '    </div>';
                            html += '</div>';
                            html += '</a>'
                        }
                        $('.search-ajax-result').html(html);
                        
                    }
                });
            });
        });

        function actionLike(id){
            type = $('.element-'+id).attr('data-field');
            $.ajax({
                method: "GET",
                url: "{{ route('user/favorite') }}?type=" + type + "&product_id=" + id, 
                dataType: 'json',
                success: function(response) {
                    if (response.item == 'remove') {
                        $('.element-'+id).addClass("liked");
                        $('.element-'+id).attr('data-original-title', 'Remove from Wish List');
                        $('.element-'+id).attr('data-field', 'remove');
                        $(".heart-active-"+id).attr("src","{{ asset('public/default/img/core-img/heart-active.png') }}"); // active
                    } else {
                        $('.element-'+id).removeClass("liked");
                        $('.element-'+id).attr('data-original-title', 'Add to Wish List');
                        $('.element-'+id).attr('data-field', 'add');
                        $(".heart-active-"+id).attr("src","{{ asset('public/default/img/core-img/heart-default.png') }}"); // default
                    }
                    $('.element-'+id).attr('data-field', response.item);

                }
            });
        }

        function showPopup(id) {
            if($('.popup').hasClass("fade-out")){
                $('.popup').remove();
            }
            
            var html = '';
            var src = '{{ asset('public/images/product/') }}';
            const myPopup = new Popup({
                id: "my-popup",
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
                            if (response.favorite != null) {
                                liked = 'liked';
                                type = 'remove';
                                title = 'Remove from Wishlist!';
                            }
                            html += `<div class="single-product-area clearfix pt-0">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-12 col-lg-6">
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
                                                        <div class="short_overview my-1">
                                                            <p>` + response.item.description + `</p>
                                                        </div>

                                                        <form class="cart clearfix" method="post"  action="http://localhost/home/user/cart/add/2">
                                                            @csrf                            
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-8">
                                                                    <div class="widget color">
                                                                        <div class="widget-desc">
                                                                            <p class="p-0">Màu sắc</p>
                                                                            <div>
                                                                                <ul class="d-flex">`;
                                                                                    var arrColor = [response.item.color.split(',')];
                                                                                    for(var color of arrColor[0]){
                                                                                        for(var arr of response.colorSlb){
                                                                                            if(color == arr.id){
                                                                                                html += `
                                                                                                <li class="active-color">
                                                                                                    <a class="color-ajax-`+arr.id+`" aria-label="Color" onclick="changeColor('`+arr.id+`', '`+response.item.style+`')" data-bs-toggle="tooltip" data-bs-placement="right" title="` + arr.name + `">
                                                                                                        <img src="../public/images/color/`+arr.name+`/`+arr.picture+`" alt="">
                                                                                                    </a>
                                                                                                </li>`;
                                                                                            }
                                                                                        }
                                                                                    }
                                                                        html += `</ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="shop/detail/` + name + `-` + response.item.id + `">Xem chi tiết</a>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                            $('.popup-body').html(html);
                            setTimeout(() => {
                                $.ajax({
                                    method: "GET",
                                    url: "{{ route('shop/update-view') }}?id=" + id + '&view=' + response.item.view,
                                });
                            }, 7500);
                        }
                    });
                },
            });
            myPopup.show();
        }
        
        function removeButton(field, id) {
            document.getElementById(field+"-hidden").value = 'all';
            document.getElementById("button-"+field).remove();

            
            let data_occasion       = $('#occasion-hidden').val();
            let data_category       = $('#category-hidden').val();
            let data_collection     = $('#collection-hidden').val();
            let data_color          = $('#color-hidden').val();
            let data_size           = $('#size-hidden').val();
            let data_price          = $('#price-hidden').val();
            let data_search         = $('#search_input').val();

            var active = field + '-' + id;
            $('#' + active).parent().removeClass('active');
            $('#' + field + '-all').parent().addClass('active');

            $('#ajax-result').html('');
            $.ajax({
                type: "GET",
                url: "{{ route('shop/filter') }}?category_id=" + data_category + '&occasion_id=' + data_occasion + '&collection_id=' + data_collection + '&color_id=' + data_color + '&size_id=' + data_size + '&price_id=' + data_price + '&key=' + data_search,
                beforeSend: () => {
                    $('.loader').show();
                    $('.loader-mobile').show();
                },
                complete: () => {
                    $('.loader').hide();
                    $('.loader-mobile').hide();
                },
                success: function(response) {
                    document.getElementById("category-hidden").value    = response.category;
                    document.getElementById("occasion-hidden").value    = response.occasion;
                    document.getElementById("collection-hidden").value  = response.collection;
                    document.getElementById("color-hidden").value       = response.color;
                    document.getElementById("size-hidden").value        = response.size;
                    document.getElementById("price-hidden").value       = response.price;

                    var _html = '';
                    if (response.items !== null) {
                        _html += showItems(response.items, response.favorites);
                    }

                    if(response.button == false){
                        $('#block-load-more').hide();
                    } else {
                        $('#block-load-more').show();
                    }
                    
                    $('#ajax-result').html(_html);

                },
            });
        }

        function showItems(items, favorite = null) {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            var _html = '';
            var src = '{{ asset('public/images/product/') }}';

            
            for (var pro of items) {
                var name = pro.name.toLowerCase().replace(" ", "-");
                _html += '<div class="single-products-catagory clearfix product">';
                _html += '    <div class="col-12 col-sm-12 col-md-12 col-xl-12" style="padding: 0 6px">';
                _html += '        <div class="single-product-wrapper">';
               
                if (window.location.pathname == 'home/shop') {
                    _html += '       <a href="shop/detail/' + name + '-' + pro.id + '">';
                } else {
                    _html += '       <a href="shop/detail/' + name + '-' + pro.id + '">';
                }

                _html += '              <div class="product-img" data-toggle="tooltip" data-placement="right" title="'+pro.name+'">';
                _html += '                  <img src="' + src + '/' + pro.name + '/' + pro.picture1 + '" alt="">';
                        if(pro.picture2 != null)
                            _html += '                  <img class="hover-img" src="' + src + '/' + pro.name + '/' + pro.picture2 +'" alt="">';
                        else
                            _html += '                  <img class="hover-img" src="' + src + '/' + pro.name + '/' + pro.picture1 +'" alt="">';
                _html += '              </div>';
                _html += `              <div class="flex w-100 row quick-view" onclick="event.preventDefault();" style="position: absolute; bottom: 10px; z-index: 100; margin: 0 auto">
                                            <div class="col-12">
                                                <button type="button" data-field="` + pro.id + `" onclick="showPopup(` + pro.id + `);" class="btn artiz-btn w-100 popup-element" style="min-width: 0;">Xem nhanh</button>
                                            </div>
                                        </div>`;
                        if(pro.discount > 0)
                            _html += `  <p data-placement="bottom" class="btn btn-artiz" data-toggle="tooltip" title="Sale off" style="position: absolute; left: 5px; top: 5px; z-index:100; width: 50px; background-color: #968B7E; color: white; border-radius: 5px; border-color: #968B7E; padding: 0">
                                            -`+pro.discount+`%
                                        </p>`;
                _html += '            </a>';
                    var like = '';
                    var type = 'add';
                    var title = 'Thêm vào danh sách yêu thích';
                    var pictureURL = 'heart-default.png';
                for(var favoriteItem of favorite){
                    
                    if(pro.id == favoriteItem.product_id){
                        like = 'liked';
                        type = 'remove';
                        title = 'Xóa khỏi danh sách yêu thích';
                        pictureURL = 'heart-active.png';
                    }
                }

                _html += `          <button type="button" aria-label="Favourite" class="button-like `+like+` element-`+pro.id+`" onclick="actionLike(`+pro.id+`)" data-field="`+type+`" data-toggle="tooltip" data-placement="bottom" title="`+title+`" style="position: absolute; right: 5px; top: 5px; z-index:100">
                                        <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/`+pictureURL+`') }}" style="color: transparent; width: 25px; height: auto;">
                                    </button>
                                    <button type="button" class="button-view" id="view-mobile" onclick="showPopup(`+pro.id+`)" data-toggle="tooltip" data-placement="bottom" title="Xem nhanh" style="position: absolute; right: 5px; top: 45px; z-index:100">
                                        <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/quick-view.png') }}" style="color: transparent; width: 25px; height: auto;">
                                    </button>`;
                _html += '            <div class="product-description d-flex align-items-center justify-content-between">';
                _html += '                <div class="product-meta-data">';
                _html += '                    <div class="line"></div>';
                                                if(pro.discount > 0){
                                                    _html += `<p class="product-price mb-1">
                                                                `+new Intl.NumberFormat().format(pro.price * (100 - pro.discount) / 100)+`<span class="currency">đ</span>
                                                            </p>
                                                            <p class="mb-1">
                                                                <del>` + new Intl.NumberFormat().format(pro.price) + `<span class="currency">đ</span></del> <span class="btn btn-artiz" style="width: 50px; background-color: #968B7E; color: white; border-radius: 5px; border-color: #968B7E; padding: 0; margin-bottom: 5px">-`+pro.discount+`%</span>
                                                            </p>`;
                                                } else {
                                                    _html += '<p class="product-price">' + new Intl.NumberFormat().format(pro.price) + '<span class="currency">đ</span></p>';
                                                }
               
                _html += '                    <p>' + pro.name + '</p>';
                _html += '                </div>';
                _html += '            </div>';
                _html += '        </div>';
                _html += '    </div>';
                _html += '</div>';
            }
            return _html;
        }

        function changeColor(id, style) {
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
                        $('#thumnail-ajax').html(thumnail);
                    }
                });
        }
    </script>

    <style>

    .hide {
        display: none;
    }
    .search-ajax-result {
        position: absolute;
        align-items: center;
        width: 100%;
        background: #FCFAF6;
        z-index: 1000;
        border-radius: 5px;
        max-height: 450px;
        overflow-y: scroll;
    }

    .search-ajax-result a:hover {
        text-decoration: none
    }

    .search-ajax-result a:hover .media {
        background: whitesmoke;
        color: #ffffff
    }
    </style>
@endsection
