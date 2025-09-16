<?php
use Illuminate\Support\Number;
use Illuminate\Support\Str;

?>
@extends('default.main')
@section('content')

    <div class="artiz_product_area section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                        <!-- Total Products -->
                        <div class="total-products">
                            <h2>Sales</h2>
                            <p class="text-capitalize">Explore the new items</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row filter-new-in justify-content-center mb-3">
                <ul class="d-flex justify-content-center flex-wrap">
                    <li class="active">
                        <a class="filter" data-filter="all">All</a>
                    </li>
                    @foreach ($sales as $key => $value)
                            @php
                                $arrFilter[] = $value['category_name'];  
                                $result = array_unique($arrFilter);
                            @endphp
                        @endforeach
                        @foreach ($result as $key => $value)
                            @php
                                $filter = strtolower($value);
                            @endphp
                            <li class="px-3 py-2"><a class="filter" data-filter="{{ $filter }}">{{ $value }}</a></li>
                        @endforeach
                </ul>
            </div>
            <div class="row">
                @foreach ($sales as $key => $value)
                    @php
                        $id         = $value['id'];
                        $name       = $value['name'];
                        $category   = strtolower($value['category_name']);
                        $price      = number_format($value['price']);
                        $discount   = number_format($value['price'] * (100 - $value['discount'])/100);
                        $picture1   = asset('public/images/product/' . $value['name'] . '/' . $value['picture1']);
                        $picture2   = asset('public/images/product/' . $value['name'] . '/' . $value['picture2']);
                    @endphp
                    <div class="single-products-catagory clearfix product {{ $category}}">
                        <div class="col-12 col-sm-12 col-md-12 col-xl-12" style="padding: 0 6px">
                            <div class="single-product-wrapper">
                                <a href="{{ route('shop/detail', ['id' => $value['id'], 'name' => Str::slug($value['name'])]) }}">
                                    <div class="product-img" data-toggle="tooltip" data-placement="right" title="{{ $name }}">
                                        <img src="{{ $picture1 }}" alt="">
                                        <img class="hover-img" src="{{ $picture2 }}" alt="">
                                    </div>
                                    <div class="flex w-100 row quick-view" onclick="event.preventDefault();" id="view-default"
                                        style="position: absolute; bottom: 10px; z-index: 100; margin: 0 auto">
                                        <div class="col-12">
                                            <button type="button" onclick="showPopup({{ $id }});" data-field="{{ $id }}" class="btn artiz-btn w-100 popup-element" style="min-width: 0; ">Xem nhanh</button>
                                        </div>
                                    </div>

                                    @if($value['discount'] > 0)
                                        <p data-placement="bottom"  class="btn btn-artiz" data-toggle="tooltip" title="Sale off" style="position: absolute; left: 5px; top: 5px; z-index:100; width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0">
                                            -{{ $value['discount'] }}%
                                        </p>
                                    @endif
                                </a>
                                @php
                                    $like = '';
                                    $type = 'add';
                                    $title = 'Add to Wishlist';
                                    $pictureURL = 'heart-default.png';
                                    foreach($favorites as $keyFavorite => $valueFavorite){
                                        if($value['id'] == $valueFavorite['product_id']){
                                            $like = 'liked';
                                            $type = 'remove';
                                            $title = 'Remove from Wishlist';
                                            $pictureURL = 'heart-active.png';
                                        } 
                                    }
                                @endphp
                                @if(Auth::check())
                                    <button type="button" aria-label="Favourite" class="button-like {{ $like }} element-{{ $id }}" onclick="actionLike({{ $id }})" data-field="{{ $type }}" data-placement="bottom" data-toggle="tooltip" data-placement="right" title="{{ $title }}" style="position: absolute; right: 5px; top: 5px; z-index:100">
                                        <img class="heart-active-{{ $id }}" fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/'.$pictureURL) }}" style="color: transparent; width: 25px; height: auto;">
                                    </button>
                                @else
                                    <a href="{{ route('auth/login') }}" aria-label="Favourite" class="button-like element-{{ $id }}"  data-placement="right" data-placement="bottom" data-toggle="tooltip" data-placement="right" title="Add to Wishlst" style="position: absolute; right: 5px; top: 5px; z-index:100">
                                        <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="color: transparent; width: 25px; height: auto;">
                                    </a>
                                @endif

                                <button type="button" class="button-view" id="view-mobile" onclick="showPopup({{ $id }})" data-placement="bottom" data-toggle="tooltip" data-placement="right" title="Xem nhanh" style="position: absolute; right: 5px; top: 45px; z-index:100">
                                    <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/quick-view.png') }}" style="color: transparent; width: 25px; height: auto;">
                                </button>
                            
                                <div class="product-description d-flex align-items-center justify-content-between">
                                    <div class="product-meta-data">
                                        <div class="line"></div>
                                        @if($value['discount'] > 0)
                                            <p class="product-price mb-1">
                                                <span class="currency">đ</span>{{ $discount }}
                                            </p>
                                            <p class="mb-1">
                                                <del><span class="currency">đ</span>{{ $price }}</del> <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-{{ $value['discount'] }}%</span>
                                            </p>
                                        @else
                                            <p class="product-price">
                                                <span class="currency">đ</span>{{ $price }}
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
            {!! $sales->appends(request()->input())->links('default.template.pagination') !!}
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.filter').click(function() {
                $(this).parent().addClass('active').siblings().removeClass('active');
                var filter = $(this).attr('data-filter');
                
                if(filter == 'all'){
                    $('.product').show(400);
                } else {
                    $('.product').not('.'+filter).hide(200);
                    $('.product').filter('.'+filter).show(400);
                }

            })
        });

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
                                                                            <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-`+response.item.discount+`%</span>`;
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
                                                                            <p class="p-0">Color</p>
                                                                            <div>
                                                                                <ul class="d-flex">`;
                                                                                    var arrColor = [response.item.color.split(',')];
                                                                                    for(var color of arrColor[0]){
                                                                                        for(var arr of response.colorSlb){
                                                                                            if(color == arr.id){
                                                                                                html += `
                                                                                                <li class="active-color">
                                                                                                    <a class="color-ajax-`+arr.id+`" aria-label="Color" onclick="changeColor('`+arr.id+`', '`+response.item.style+`')" data-bs-toggle="tooltip" data-bs-placement="right" title="` + arr.name + `">
                                                                                                        <img src="{{ asset('public/images/color/`+arr.name+`/`+arr.picture+`') }}" alt="">
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
                                                            <a href="shop/detail/` + name + `-` + response.item.id + `">See full Details</a>
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
    </script>

    <style>
        .filter-new-in li {
            padding: 8px 15px;
        }

        .filter-new-in li.active {
            background: #800020;
            color: #ffffff;
        }
    </style>
@endsection
