<?php
use Illuminate\Support\Number;
use Illuminate\Support\Str;
$picture1 = asset('public/images/product/' . $item['name'] . '/' . $item['picture1']);
$picture2 = asset('public/images/product/' . $item['name'] . '/' . $item['picture2']);
$picture3 = asset('public/images/product/' . $item['name'] . '/' . $item['picture3']);
$picture4 = asset('public/images/product/' . $item['name'] . '/' . $item['picture4']);
$picture5 = asset('public/images/product/' . $item['name'] . '/' . $item['picture5']);
$picture6 = asset('public/images/product/' . $item['name'] . '/' . $item['picture6']);

$id             = $item['id'];
$name           = $item['name'];
$category       = $item['category_name'];
$categoryID     = $item['category_id'];
$occasion       = $item['name'];
$description    = $item['description'];
$view           = $item['view'];
$quantity       = $item['quantity'];
$bust           = $item['bust'];
$waist          = $item['waist'];
$hip            = $item['hip'];
$fabric         = $item['fabric'];
$composition    = $item['composition'];
$care           = $item['care'];
$style          = $item['style'];
$price          = number_format($item['price']);
$discount       = $item['discount'];

$priceDiscount  = number_format($item['price'] * (100 - $item['discount'])/100);

$like           = $favorite != null ? 'liked' : '';
$type           = $favorite != null ? 'remove' : 'add';
$title          = $favorite != null ? 'Xóa khỏi danh sách yêu thích' : 'Thêm vào danh sách yêu thích';
$pictureURL     = $favorite != null ? 'heart-active.png' : 'heart-default.png';



?>
@extends('default.main')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <!-- Product Details Area Start -->
    <div class="single-product-area section-padding-100 clearfix pt-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">

                        <ol class="breadcrumb mt-50">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('shop') }}">Sản phẩm</a></li>
                            <li class="breadcrumb-item">{{ $category }}</li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="single_product_thumb">
                        <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                            <div class="row justify-content-center">
                                <div class="loader" style="display: none">
                                </div>
                            </div>
                            <ol class="carousel-indicators ajax-color-slider">
                                <li class="active" data-target="#product_details_slider" data-slide-to="0"
                                    style="background-image: url('{{ $picture1 }}')"></li>
                                @if ($item['picture2'] != null)
                                    <li data-target="#product_details_slider" data-slide-to="1"
                                        style="background-image: url('{{ $picture2 }}')"></li>
                                @endif
                                @if ($item['picture3'] != null)
                                    <li data-target="#product_details_slider" data-slide-to="2"
                                        style="background-image: url('{{ $picture3 }}')"></li>
                                @endif
                                @if ($item['picture4'] != null)
                                    <li data-target="#product_details_slider" data-slide-to="3"
                                        style="background-image: url('{{ $picture4 }}')"></li>
                                @endif
                                @if ($item['picture5'] != null)
                                    <li data-target="#product_details_slider" data-slide-to="4"
                                        style="background-image: url('{{ $picture5 }}')"></li>
                                @endif
                                @if ($item['picture6'] != null)
                                    <li data-target="#product_details_slider" data-slide-to="5"
                                        style="background-image: url('{{ $picture6 }}')"></li>
                                @endif
                            </ol>
                            <div class="carousel-inner product_gallery ajax-color-thumnail">
                                <div class="carousel-item active">
                                    <a href="{{ $picture1 }}">
                                        <img class="d-block w-100 my-img" data-fancybox="group" rel="gallery"
                                            src="{{ $picture1 }}" alt="First slide">
                                    </a>
                                </div>
                                @if ($item['picture2'] != null)
                                    <div class="carousel-item">
                                        <a href="{{ $picture2 }}">
                                            <img class="d-block w-100 my-img" data-fancybox="group" rel="gallery"
                                                src="{{ $picture2 }}" alt="First slide">
                                        </a>
                                    </div>
                                @endif
                                @if ($item['picture3'] != null)
                                    <div class="carousel-item">
                                        <a href="{{ $picture3 }}">
                                            <img class="d-block w-100 my-img" data-fancybox="group" rel="gallery"
                                                src="{{ $picture3 }}" alt="First slide">
                                        </a>
                                    </div>
                                @endif
                                @if ($item['picture4'] != null)
                                    <div class="carousel-item">
                                        <a href="{{ $picture4 }}">
                                            <img class="d-block w-100 my-img" data-fancybox="group" rel="gallery"
                                                src="{{ $picture4 }}" alt="First slide">
                                        </a>
                                    </div>
                                @endif
                                @if ($item['picture5'] != null)
                                    <div class="carousel-item">
                                        <a href="{{ $picture5 }}">
                                            <img class="d-block w-100 my-img" data-fancybox="group" rel="gallery"
                                                src="{{ $picture5 }}" alt="First slide">
                                        </a>
                                    </div>
                                @endif
                                @if ($item['picture6'] != null)
                                    <div class="carousel-item">
                                        <a href="{{ $picture6 }}">
                                            <img class="d-block w-100 my-img" data-fancybox="group" rel="gallery"
                                                src="{{ $picture6 }}" alt="First slide">
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="single_product_desc">
                        <!-- Product Meta Data -->
                        <div class="product-meta-data" style="position: relative">
                            <div class="line"></div>
                            @if(session('artiz_notify_error'))
                                <div class="alert alert-danger">
                                    <small>{{ session('artiz_notify_error') }}</small>
                                </div>
                            @endif
                            @if(session('artiz_notify_success'))
                            <div class="alert alert-success">
                                <small>{{ session('artiz_notify_success') }}</small>
                            </div>
                        @endif
                            <p class="product-price">
                                {{ $priceDiscount }}<span class="currency">đ</span>
                                @if($discount > 0)
                                    <del class="text-black-50">{{ $price }}<span class="currency">đ</span></del>
                                    
                                    <small>
                                        <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-{{ $discount }}%</span>
                                    </small>
                                @endif
                            </p>
                           
                            <h3>{{ $name }}</h3>
                            <!-- Ratings & Review -->
                            <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                <div class="ratings">
                                    @if($avgStarRating > 0)
                                        @php
                                            $star = 1;
                                            while($star <= $avgStarRating){
                                                echo '<span style="color: #800020">&#9733</span>';
                                                $star++;
                                            }
                                            if($countRating['count'] == 1)
                                                echo '<span style="color: #800020"> ('.$avgRating.'&#9733 - '.$countRating['count'].' Rating)</span>';
                                            else 
                                                echo '<span style="color: #800020"> ('.$avgRating.'&#9733 - '.$countRating['count'].' Ratings)</span>';
                                        @endphp
                                    @else   
                                        <span style="color: #800020">&#9733</span>
                                        <span style="color: #800020">&#9733</span>
                                        <span style="color: #800020">&#9733</span>
                                        <span style="color: #800020">&#9733</span>
                                        <span style="color: #800020">&#9733</span>
                                        <span style="color: #800020"><small>(0 Đánh giá)</small></span>
                                    @endif
                                </div>
                                <div class="review">
                                    <a href="#rating-review">Viết đánh giá</a>
                                </div>
                            </div>
                            <!-- Avaiable -->
                            <p class="avaibility"><i class="fa fa-circle"></i> Còn hàng</p>
                        </div>

                        <div class="short_overview my-1">
                            <p>{{ $description }}</p>
                        </div>

                        <!-- Thêm vào giỏ Form -->
                        <form class="cart clearfix" method="post" id="cart" action="{{ route('user/cart/add', ['id' => $id]) }}" id="main-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <div class="widget color">
                                        <div class="widget-desc">
                                            <strong class="p-0">Màu sắc <span class="color-text"></span></strong>
                                            <div>
                                                <ul class="d-flex">
                                                    @php
                                                        $xhtmlColor = '';
                                                        if ($item['color'] != null) {
                                                            $color = explode(',', $item['color']);
                                                            foreach ($colorSlb as $keyColorSlb => $valueColorSlb) {
                                                                foreach ($color as $keyColor => $valueColor) {
                                                                    $img = asset('public/images/color/' . $valueColorSlb['name'] . '/' . $valueColorSlb['picture']);
                                                                    if ($valueColor == $valueColorSlb['id']) {
                                                                        $xhtmlColor .=
                                                                            '<li>
                                                                                <a class="color-ajax" data-placement="bottom" data-toggle="tooltip" data-placement="right" title="'.$valueColorSlb['name'].'" data-field="' . $valueColorSlb['id'] . '">
                                                                                    <img src="'.$img.'" alt="">
                                                                                </a>
                                                                            </li>';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    @endphp
                                                    {!! $xhtmlColor !!}
                                                </ul>
                                                <input type="hidden" value="" name="color" id="color">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <div class="widget color">
                                        <div class="widget-desc">
                                            <div class="ratings-review mb-15 d-flex align-items-center justify-content-between">
                                                <div class="ratings">
                                                    <strong>Size <span class="size-text"></span></strong>
                                                </div>
                                                <div class="review">
                                                    <a style="cursor: pointer" onclick="showPopup()">Hướng dẫn chọn size</a>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <ul class="d-flex" id="ajax-size">
                                                    <li class="check-size size-S" onclick="activeSize('S')" data-field="S">S</li>
                                                
                                                    <li class="check-size size-M" onclick="activeSize('M')" data-field="M">M</li>
                                                
                                                    <li class="check-size size-L" onclick="activeSize('L')" data-field="L">L</li>
                                                </ul>
                                                
                                                <input type="hidden" value="" name="size" id="size">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12">
                                    <div class="cart-btn d-flex align-items-center">
                                        <strong class="p-0">Số lượng</strong>
                                        <div class="quantity">
                                            <input type="number" class="qty-text ml-3" id="qty" step="1" onchange="changeQuantity()"
                                                min="1" max="{{ $quantity }}" name="quantity" value="1">
                                                <small class="text-danger ml-5" id="error-quantity"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <strong>Thông số</strong>
                                @if ($bust != null)
                                    <p class="lh-sm">Ngực: {{ $bust }}</p>
                                @endif
                                @if ($waist != null)
                                    <p class="lh-sm">Eo: {{ $waist }}</p>
                                @endif
                                @if ($hip != null)
                                    <p class="lh-sm">Hông: {{ $hip }}</p>
                                @endif
                                @if ($fabric != null)
                                    <p class="lh-sm">Vải: {{ $fabric }}</p>
                                @endif
                                <br>
                                <strong>Chi tiết</strong>
                                @if ($composition != null)
                                    <p class="lh-sm">Chất liệu: {{ $composition }}</p>
                                @endif
                                @if ($care != null)
                                    <p class="lh-sm">Giặt ủi: {{ $care }}</p>
                                @endif
                                <p class="lh-sm">Mã sản phẩm: #{{ $style }}</p>
                                <br>
                            </div>
                            
                            <div class="row">
                                @if (Auth::check())
                                    <div class="col-md-9 col-9 d-flex justify-content-between">
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" name="addtocart" class="btn artiz-btn position-relative btn-add-to-cart" disabled>
                                            <span class="btn-state state-default">Thêm vào giỏ</span>
                                            <span class="btn-state state-adding">
                                                <span class="animation-ellipsis">
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                    <span class="dot"></span>
                                                </span>
                                                Đang thêm</span>
                                            <span class="btn-state state-added">
                                                <span class="checkmark-wrapper">
                                                    <span class="checkmark"></span>
                                                </span>
                                                Đã thêm!</span>
                                        </button>
                                    </div>
                                @else
                                    <div class="col-md-9 col-9 d-flex justify-content-between">
                                        <a href="{{ route('auth/login') }}" class="btn artiz-btn">Thêm vào giỏ</a>
                                    </div>
                                @endif
                                <div class="col-md-3 col-3 d-flex justify-content-between">
                                    @if (Auth::check())
                                        <button type="button" aria-label="Favourite" class="button-like {{ $like }} element-{{ $id }}" onclick="actionLike({{ $id }})" data-field="{{ $type }}"data-placement="bottom" data-toggle="tooltip" data-placement="right" title="{{ $title }}" style="width: 45px; height: 45px">
                                            <img class="heart-active-{{ $id }}" fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/'.$pictureURL) }}" style="color: transparent; width: 35px; height: auto;">
                                        </button>
                                    @else
                                        <a href="{{ route('auth/login') }}" aria-label="Favourite" class="button-like {{ $like }} element-{{ $id }}" onclick="actionLike({{ $id }})" data-field="{{ $type }}" data-placement="bottom" data-toggle="tooltip" data-placement="right" title="Bạn cần đăng nhập trước" style="width: 45px; height: 45px">
                                            <img fetchpriority="high" width="25px" height="auto" decoding="async" data-nimg="1" src="{{ asset('public/default/img/core-img/heart-default.png') }}" style="color: transparent; width: 35px; height: auto;">
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Product Details Area End -->

    <div class="single-product-area clearfix pt-0" id="rating-review">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mt-50">
                            <h2>Đánh giá</h2>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="products-catagories-area clearfix">
        <div class="container-fluid">
            <form action="{{ route('user/add-rating') }}" method="POST">
                @csrf
                <div class="row m-0">
                    <div class="col-md-12 col-lg-3">
                        <fieldset class="rating">
                            <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" data-toggle="tooltip" data-placement="bottom" title="Awesome - 5 stars"></label>
                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" data-toggle="tooltip" data-placement="bottom" title="Pretty good - 4 stars"></label>
                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" data-toggle="tooltip" data-placement="bottom" title="Meh - 3 stars"></label>
                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" data-toggle="tooltip" data-placement="bottom" title="Kinda bad - 2 stars"></label>
                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" data-toggle="tooltip" data-placement="bottom" title="Sucks big time - 1 star"></label>
                        </fieldset>
                    </div>
                    <div class="col-md-12 col-lg-9">
                        <div class="form-group">
                            <label for="review">Đánh giá của bạn</label>
                            
                            <textarea class="form-control" name="review" id="review" required cols="30" rows="10"></textarea>
                        </div>
                        <div>&nbsp;</div>
                        <div class="form-group">
                            <input type="hidden" name="product_id" id="hidden_id" value="{{ $id }}">
                            <input type="hidden" id="hidden_view" value="{{ $view }}">
                            <button type="submit" class="btn artiz-btn">Gửi</button>
                        </div>
                    </div>
                </div>
            </form>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <div class="row m-0">
                @if(count(($rating)) > 0)
                    @foreach($rating as $key => $value)
                        <div class="col-md-12 col-lg-3">
                            @php
                                $count = 1;
                                while($count <= $value['rating']){
                                    echo '<span class="rating-user" style="color: #800020">&#9733</span>';
                                    $count++;
                                }
                            @endphp
                        </div>
                        <div class="col-md-12 col-lg-9">
                            <div class="form-group">
                                <label>{{ $value['user_fullname'] }}</label>
                                
                                <p>{{ $value['review'] }}</p>
                                <small>&#8213; At {{ date('H:i:s d-m-Y', strtotime($value['created'])) }}</small>
                            </div>
                            <hr style="height: 0.1px; background: transparent">
                            <div>&nbsp;</div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    @if ($picture != null)
        <div class="single-product-area clearfix pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <h2>Hoàn thiện outfit</h2>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="products-catagories-area clearfix">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="col-md-12 col-lg-12 p-0">
                        <div class="f-carousel" id="productRelated">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track">
                                    @foreach ($picture as $key => $value)
                                        @foreach ($value as $keyA => $valueA)
                                            @foreach ($valueA as $keyB => $valueB)
                                                <div class="f-carousel__slide single-product-wrapper">
                                                    <a href="{{ route('shop/detail', ['id' => $valueB['id'], 'name' => Str::slug($valueB['name'])]) }}" data-placement="right" data-toggle="tooltip" title="{{ $valueB['name'] }}">
                                                        <img class="p-1" src="{{ asset('public/images/product/' . $valueB['name'] . '/' . $valueB['picture1']) }}" alt="">
                                                        <div class="product-description">
                                                            <div class="product-meta-data">
                                                                <div class="line ml-1"></div>
                                                                @if($valueB['discount'] > 0)
                                                                    <p class="product-price pl-1">
                                                                        {{ number_format($valueB['price'] * (100 - $valueB['discount']) / 100) }}<span class="currency">đ</span>
                                                                    </p>
                                                                    <p class="mb-1 pl-1">
                                                                        <del>{{ number_format($valueB['price']) }}<span class="currency">đ</span></del> <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-{{ $valueB['discount'] }}%</span>
                                                                    </p>
                                                                @else
                                                                    <p class="product-price pl-1">
                                                                        {{ number_format($valueB['price']) }}<span class="currency">đ</span>
                                                                    </p>
                                                                @endif
                                                                <p class="pl-1">{{ $valueB['name'] }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (count($itemsRelated) > 0)
        <div class="single-product-area clearfix pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <h2>Sản phẩm tương tự</h2>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="products-catagories-area clearfix">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="col-md-12 col-lg-12 p-0">
                        <div class="f-carousel" id="productRelated">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track">
                                    @foreach ($itemsRelated as $key => $value)
                                        @php
                                            $picture = asset(
                                                'public/images/product/' . $value['name'] . '/' . $value['picture1'],
                                            );
                                        @endphp
                                        <div class="f-carousel__slide single-product-wrapper">
                                            <a href="{{ route('shop/detail', ['id' => $value['id'], 'name' => Str::slug($value['name'])]) }}" data-placement="right" data-toggle="tooltip" title="{{ $value['name'] }}">
                                                <img class="p-1" src="{{ $picture }}" alt="">
                                                <div class="product-description">
                                                    <div class="product-meta-data">
                                                        <div class="line ml-1"></div>
                                                        @if($value['discount'] > 0)
                                                            <p class="product-price pl-1">
                                                                {{ number_format($value['price'] * (100 - $value['discount']) / 100) }}<span class="currency">đ</span>
                                                            </p>
                                                            <p class="mb-1 pl-1">
                                                                <del>{{ number_format($value['price']) }}<span class="currency">đ</span></del> <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-{{ $value['discount'] }}%</span>
                                                            </p>
                                                        @else
                                                            <p class="product-price pl-1">
                                                                {{ number_format($value['price']) }}<span class="currency">đ</span>
                                                            </p>
                                                        @endif
                                                        <p class="pl-1">{{ $value['name'] }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (count($recent) > 1)
        <div class="single-product-area clearfix pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <h2>Đã xem gần đây</h2>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="products-catagories-area clearfix">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="col-md-12 col-lg-12 p-0">
                        <div class="f-carousel" id="productRecently">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track">
                                    @php
                                        $recentID = 0;
                                    @endphp
                                    @foreach (array_reverse($recent) as $key => $value)
                                        
                                        @if($recentID != $value['id'] && $id != $value['id'])
                                            @php
                                                $picture = asset(
                                                    'public/images/product/' . $value['name'] . '/' . $value['picture1'],
                                                );
                                            @endphp
                                            <div class="f-carousel__slide single-product-wrapper">
                                                <a href="{{ route('shop/detail', ['id' => $value['id'], 'name' => Str::slug($value['name'])]) }}" data-placement="right" data-toggle="tooltip" title="{{ $value['name'] }}">
                                                    <img class="p-1" src="{{ $picture }}" alt="">
                                                    <div class="product-description">
                                                        <div class="product-meta-data">
                                                            <div class="line ml-1"></div>
                                                            @if($value['discount'] > 0)
                                                                <p class="product-price pl-1">
                                                                    {{ number_format($value['price'] * (100 - $value['discount']) / 100) }}<span class="currency">đ</span>
                                                                </p>
                                                                <p class="mb-1 pl-1">
                                                                    <del>{{ number_format($value['price']) }}<span class="currency">đ</span></del> <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-{{ $value['discount'] }}%</span>
                                                                </p>
                                                            @else
                                                                <p class="product-price pl-1">
                                                                    {{ number_format($value['price']) }}<span class="currency">đ</span>
                                                                </p>
                                                            @endif
                                                            <p class="pl-1">{{ $value['name'] }}</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                        @php
                                            $recentID = $value['id'];
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (count($itemsFeatured) > 0)
        <div class="single-product-area clearfix pt-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mt-50">
                                <h2>Artiz gợi ý cho bạn</h2>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="products-catagories-area clearfix">
            <div class="container-fluid">
                <div class="row m-0">
                    <div class="col-md-12 col-lg-12 p-0">
                        <div class="f-carousel" id="productFeatured">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track">
                                    @foreach ($itemsFeatured as $key => $value)
                                        @php
                                            $picture = asset(
                                                'public/images/product/' . $value['name'] . '/' . $value['picture1'],
                                            );
                                        @endphp
                                        <div class="f-carousel__slide single-product-wrapper">
                                            <a href="{{ route('shop/detail', ['id' => $value['id'], 'name' => Str::slug($value['name'])]) }}" data-placement="right" data-toggle="tooltip" title="{{ $value['name'] }}">
                                                <img class="p-1" src="{{ $picture }}" alt="">
                                                <div class="product-description">
                                                    <div class="product-meta-data">
                                                        <div class="line ml-1"></div>
                                                        @if($value['discount'] > 0)
                                                            <p class="product-price pl-1">
                                                                {{ number_format($value['price'] * (100 - $value['discount']) / 100) }}<span class="currency">đ</span>
                                                            </p>
                                                            <p class="mb-1 pl-1">
                                                                <del>{{ number_format($value['price']) }}<span class="currency">đ</span></del> <span class="btn btn-artiz" style="width: 50px; background-color: #800020; color: white; border-radius: 5px; border-color: #800020; padding: 0; margin-bottom: 5px">-{{ $value['discount'] }}%</span>
                                                            </p>
                                                        @else
                                                            <p class="product-price pl-1">
                                                                {{ number_format($value['price']) }}<span class="currency">đ</span>
                                                            </p>
                                                        @endif
                                                        <p class="pl-1">{{ $value['name'] }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        const containerRelated = document.getElementById("productRelated");
        const optionsRelated = {
            Dots: false,
            infinite: true,
        };
        new Carousel(containerRelated, optionsRelated);

        const containerFeatured = document.getElementById("productFeatured");
        const optionsFeatured = {
            Dots: false,
            infinite: true,
        };
        new Carousel(containerFeatured, optionsFeatured);

        const containerRecently = document.getElementById("productRecently");
        const optionsRecently = {
            Dots: false,
            infinite: true,
        };
        new Carousel(containerRecently, optionsRecently);
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/@simondmc/popup-js@1.4.3/popup.min.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        function showPopup() {
            if($('.popup').hasClass("fade-out")){
                $('.popup').remove();
            }
            
            var html = '';
            const myPopup = new Popup({
                id: "my-popup",
                title: "",
                content: ``,
                loadCallback: () => {
                    html += `
                            <p class="text-primary">Hướng dẫn chọn size</p>
                            <div class="filter-new-in mb-3">
                                <ul class="d-flex flex-wrap filter-ajax">
                                    <li style="cursor: pointer" class="px-3 py-2 active filter" data-filter="shirt"><a>Áo</a></li>
                                    <li style="cursor: pointer" class="px-3 py-2 filter" data-filter="pants"><a>Quấn</a></li>
                                    <li style="cursor: pointer" class="px-3 py-2 filter" data-filter="skirt"><a>Váy</a></li>
                                    <li style="cursor: pointer" class="px-3 py-2 filter" data-filter="dress"><a>Đầm</a></li>
                                </ul>
                            </div>
                            <table class="table shirt">
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>S</th>
                                        <th>M</th>
                                        <th>L</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dài</td>
                                        <td>88</td>
                                        <td>90</td>
                                        <td>92</td>
                                    </tr>
                                    <tr>
                                        <td>Bụng</td>
                                        <td>70</td>
                                        <td>74</td>
                                        <td>78</td>
                                    </tr>
                                    <tr>
                                        <td>Eo</td>
                                        <td>66</td>
                                        <td>70</td>
                                        <td>74</td>
                                    </tr>
                                    <tr>
                                        <td>Mông</td>
                                        <td>92</td>
                                        <td>96</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <td>Đùi</td>
                                        <td>52</td>
                                        <td>54</td>
                                        <td>56</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table pants" style="display: none">
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>S</th>
                                        <th>M</th>
                                        <th>L</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dài</td>
                                        <td>87 - 89</td>
                                        <td>89 - 91</td>
                                        <td>91 - 93</td>
                                    </tr>
                                    <tr>
                                        <td>Bụng</td>
                                        <td>68 - 72</td>
                                        <td>72 - 76</td>
                                        <td>76 - 80</td>
                                    </tr>
                                    <tr>
                                        <td>Eo</td>
                                        <td>64 - 68</td>
                                        <td>68 - 72</td>
                                        <td>72 - 76</td>
                                    </tr>
                                    <tr>
                                        <td>Mông</td>
                                        <td>90 - 94</td>
                                        <td>94 - 98</td>
                                        <td>98 - 102</td>
                                    </tr>
                                    <tr>
                                        <td>Đùi</td>
                                        <td>51 - 53</td>
                                        <td>53 - 55</td>
                                        <td>55 - 57</td>
                                    </tr>
                                    <tr>
                                        <td>Cân nặng</td>
                                        <td>45 - 55</td>
                                        <td>55 - 65</td>
                                        <td>65 - 75</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table skirt" style="display: none">
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>S</th>
                                        <th>M</th>
                                        <th>L</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dài</td>
                                        <td>88</td>
                                        <td>90</td>
                                        <td>92</td>
                                    </tr>
                                    <tr>
                                        <td>Bụng</td>
                                        <td>70</td>
                                        <td>74</td>
                                        <td>78</td>
                                    </tr>
                                    <tr>
                                        <td>Eo</td>
                                        <td>66</td>
                                        <td>70</td>
                                        <td>74</td>
                                    </tr>
                                    <tr>
                                        <td>Mông</td>
                                        <td>92</td>
                                        <td>96</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <td>Đùi</td>
                                        <td>52</td>
                                        <td>54</td>
                                        <td>56</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table dress" style="display: none">
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <colgroup></colgroup>
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>S</th>
                                        <th>M</th>
                                        <th>L</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Dài</td>
                                        <td>88</td>
                                        <td>90</td>
                                        <td>92</td>
                                    </tr>
                                    <tr>
                                        <td>Bụng</td>
                                        <td>70</td>
                                        <td>74</td>
                                        <td>78</td>
                                    </tr>
                                    <tr>
                                        <td>Eo</td>
                                        <td>66</td>
                                        <td>70</td>
                                        <td>74</td>
                                    </tr>
                                    <tr>
                                        <td>Mông</td>
                                        <td>92</td>
                                        <td>96</td>
                                        <td>100</td>
                                    </tr>
                                    <tr>
                                        <td>Đùi</td>
                                        <td>52</td>
                                        <td>54</td>
                                        <td>56</td>
                                    </tr>
                                </tbody>
                            </table>
                            <img src="{{ asset('public/default/img/core-img/measure.jpg') }}">
                            <p>Lưu ý: Bảng size trên là bảng size chung mang tính chất tham khảo, tùy thuộc vào số đo cơ thể, form sản phẩm và chất liệu vải khác nhau sẽ có sự chênh lệch nhất định từ 1-2cm hoặc hơn.</p>`;
                    $('.popup-body').html(html);
                    $('table').on('mouseenter mouseleave', 'td', function(e) {
                        (function(td, type) {
                        td.parent()[type]('hover');
                        td.closest('table').children('colgroup').eq(td.index())[type]('hover');
                        })(
                        $(this),
                        e.type === 'mouseenter' ? 'addClass' : 'removeClass'
                        );
                    });

                    $('.filter').click(function() {
                        $(this).addClass('active').siblings().removeClass('active');
                        var filter = $(this).attr('data-filter');

                        if (filter == 'all') {
                            $('.table').show(400);
                        } else {
                            $('.table').not('.' + filter).hide(200);
                            $('.table').filter('.' + filter).show(400);
                        }
                    });
                },
            });
            myPopup.show();
        }
        
        $(document).ready(function() {
            setTimeout(() => {
                var id = $('#hidden_id').val();
                var view = $('#hidden_view').val();
                $.ajax({
                    method: "GET",
                    url: "{{ route('shop/update-view') }}?id=" + id + '&view=' + view,
                });
            }, 15000);

            var inputSize       = $('#size').val();
            var inputColor      = $('#color').val();
            var inputQuantity   = $('#qty').val();
            if(inputSize == '' || inputColor == '' || inputQuantity == 0){
                $('.state-default').text('Chọn Màu & Size');
            }

            $('.color-ajax').click(function() {
                $(this).parent().addClass('active').siblings().removeClass('active');
                let color = $(this).data('field');
                let thumnail = '';
                let slider = '';
                var src = '{{ asset('public/images/detail/') }}';

                $('.ajax-color-thumnail').html('');
                $('.ajax-color-slider').html('');
                $.ajax({
                    method: "GET",
                    url: "{{ route('shop/detail-ajax') }}?color=" + color + '&style=' +
                        {{ $style }},
                    dataType: "json",
                    beforeSend: () => {
                        $('.loader').show();
                    },
                    complete: () => {
                        $('.loader').hide();
                    },
                    success: function(response) {
                        if (response.items.picture1 != null) {
                            let pic1 = src + '/' + {{ $style }} + '/' + '/' + response.items.color + '/' + response.items.picture1;
                            thumnail += '    <div class="carousel-item active">';
                            thumnail += '        <a data-fancybox="group" href="' + pic1 + '">';
                            thumnail += '            <img class="d-block w-100" src="' + pic1 +'" alt="First slide">';
                            thumnail += '        </a>';
                            thumnail += '    </div>';

                            slider += '<li class="active" data-target="#product_details_slider" data-slide-to="0" style="background-image: url(' + pic1 + ')"></li>';
                        }
                        if (response.items.picture2 != null) {
                            let pic2 = src + '/' + {{ $style }} + '/' + '/' + response.items.color + '/' + response.items.picture2;
                            thumnail += '    <div class="carousel-item">';
                            thumnail += '        <a data-fancybox="group" href="' + pic2 + '">';
                            thumnail += '            <img class="d-block w-100" src="' + pic2 +'" alt="First slide">';
                            thumnail += '        </a>';
                            thumnail += '    </div>';

                            slider += '<li data-target="#product_details_slider" data-slide-to="1" style="background-image: url(' + pic2 + ')"></li>';
                        }
                        if (response.items.picture3 != null) {
                            let pic3 = src + '/' + {{ $style }} + '/' + '/' + response.items.color + '/' + response.items.picture3;
                            thumnail += '    <div class="carousel-item">';
                            thumnail += '        <a data-fancybox="group" href="' + pic3 + '">';
                            thumnail += '            <img class="d-block w-100" src="' + pic3 +
                                '" alt="First slide">';
                            thumnail += '        </a>';
                            thumnail += '    </div>';

                            slider +=
                                '<li data-target="#product_details_slider" data-slide-to="2" style="background-image: url(' +
                                pic3 + ')"></li>';
                        }
                        if (response.items.picture4 != null) {
                            let pic4 = src + '/' + {{ $style }} + '/' + '/' + response.items.color + '/' + response.items.picture4;
                            thumnail += '    <div class="carousel-item">';
                            thumnail += '        <a data-fancybox="group" href="' + pic4 + '">';
                            thumnail += '            <img class="d-block w-100" src="' + pic4 +
                                '" alt="First slide">';
                            thumnail += '        </a>';
                            thumnail += '    </div>';

                            slider +=
                                '<li data-target="#product_details_slider" data-slide-to="3" style="background-image: url(' +
                                pic4 + ')"></li>';
                        }
                        if (response.items.picture5 != null) {
                            let pic5 = src + '/' + {{ $style }} + '/' + '/' + response.items.color + '/' + response.items.picture5;
                            thumnail += '    <div class="carousel-item">';
                            thumnail += '        <a data-fancybox="group" href="' + pic5 + '">';
                            thumnail += '            <img class="d-block w-100" src="' + pic5 +
                                '" alt="First slide">';
                            thumnail += '        </a>';
                            thumnail += '    </div>';

                            slider +=
                                '<li data-target="#product_details_slider" data-slide-to="4" style="background-image: url(' +
                                pic5 + ')"></li>';
                        }
                        if (response.items.picture6 != null) {
                            let pic6 = src + '/' + {{ $style }} + '/' + '/' + response.items.color + '/' + response.items.picture6;
                            thumnail += '    <div class="carousel-item">';
                            thumnail += '        <a data-fancybox="group" href="' + pic6 + '">';
                            thumnail += '            <img class="d-block w-100" src="' + pic6 +
                                '" alt="First slide">';
                            thumnail += '        </a>';
                            thumnail += '    </div>';

                            slider +=
                                '<li data-target="#product_details_slider" data-slide-to="5" style="background-image: url(' +
                                pic6 + ')"></li>';
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
                            htmlSize += `<li class="check-size size-S" onclick="activeSize('S', '`+{{ $id }}+`', '`+response.items.color+`', '`+{{ $style }}+`')"  data-field="S">S</li>`;
                        else 
                            htmlSize += `<li class="check-size-disabled" data-placement="bottom" data-toggle="tooltip" title="Hết hàng">S</li>`;

                        if(sizeM == true)
                            htmlSize += `<li class="check-size size-M" onclick="activeSize('M', '`+{{ $id }}+`', '`+response.items.color+`', '`+{{ $style }}+`')"  data-field="M">M</li>`;
                        else 
                            htmlSize += `<li class="check-size-disabled" data-placement="bottom" data-toggle="tooltip" title="Hết hàng">M</li>`;

                        if(sizeL == true)
                            htmlSize += `<li class="check-size size-L" onclick="activeSize('L', '`+{{ $id }}+`', '`+response.items.color+`', '`+{{ $style }}+`')"  data-field="L">L</li>`;
                        else 
                            htmlSize += `<li class="check-size-disabled" data-placement="bottom" data-toggle="tooltip" title="Hết hàng">L</li>`;

                        $('#size').val('');
                        $('.size-text').text('');
                        $('#ajax-size').html(htmlSize);

                        $('#color').val(response.items.color);
                        $('.color-text').text('- ' + response.items.color);

                        $('.ajax-color-thumnail').html(thumnail);
                        $('.ajax-color-slider').html(slider);

                        if($('#size').val() == ''){
                            $('.state-default').text('Chọn Size');
                            $('#error-quantity').text('');
                            $('#qty').removeClass('d-none');
                            $('.btn-add-to-cart').attr('disabled','disabled');
                        } else {
                            $('.state-default').text('Thêm vào giỏ');
                            $('#error-quantity').text('');
                            $('#qty').removeClass('d-none');
                            $('.btn-add-to-cart').removeAttr('disabled');
                        }
                        $('#qty').val(0);

                        $(function () {
                            $('[data-toggle="tooltip"]').tooltip()
                        });
                           
                    }
                });
            });

            $('.btn-add-to-cart').click(function() {
                event.preventDefault();
                if($('#size').val() != '' && $('#color').val() != '') {
                    const addToCartButton = document.querySelector('.btn-add-to-cart');
                    const CSS_ADDING = 'cart-adding';
                    const CSS_ADDED = 'cart-added';

                    var size = $('#size').val();
                    var color = $('#color').val();
                    var quantity = $('#qty').val();

                    $(this).addClass(CSS_ADDING);

                    $.ajax({
                        method: "GET",
                        url: "{{ route('user/cart/add', ['id' => $id]) }}?size=" + size + '&qty=' +
                            quantity + '&color=' + color,
                        dataType: 'json',
                        success: function(response) {
                            $('#total-cart').html('(' + response.total + ')');
                            $('#qty').attr({"max" : $("#qty").attr('max') - quantity});
                        }
                    });

                    setTimeout(() => {
                        $(this).addClass(CSS_ADDED);
                        $(this).removeClass(CSS_ADDING);
                    }, 2000);

                    setTimeout(() => {
                        $(this).removeClass(CSS_ADDED);
                    }, 4000);

                    
                    $('#qty').val(0);

                    $('.state-default').text('Nhập số lượng');
                    $('.btn-add-to-cart').attr('disabled','disabled');
                }
            });
        });

        function activeSize(size, id, color, style){
            $('.check-size').removeClass('check')
            $('.size-'+size).addClass('check');
            $('#size').val(size);
            $('.size-text').text('- '+ size);
            $.ajax({
                method: "GET",
                url: "{{ route('user/check-sku') }}?id=" + id + '&size=' + size + '&color=' + color + '&style=' + style,
                dataType: 'json',
                success: function(response) {
                    $('#qty').attr({"max" : response.stock - response.quantity});
                    $('#qty').val(0);
                    if(response.stock - response.quantity <= 0){
                        $('#error-quantity').text('Hết hàng');
                        $('#qty').addClass('d-none');
                        $('.btn-add-to-cart').attr('disabled','disabled');
                        $('.state-default').text('Hết hàng');
                    } else if($('#color').val() == ''){
                        $('#qty').removeClass('d-none');
                        $('#error-quantity').text('');
                        $('.state-default').text('Chọn màu');
                        $('.btn-add-to-cart').attr('disabled','disabled');
                    }
                    else if($('#qty').val() == 0) {
                        $('.state-default').text('Nhập số lượng');
                        $('.btn-add-to-cart').attr('disabled','disabled');
                    } else {
                        $('#qty').removeClass('d-none');
                        $('#error-quantity').text('');
                        $('.state-default').text('Thêm vào giỏ');
                        $('.btn-add-to-cart').removeAttr('disabled');
                    }
                }
            });
        }

        function changeQuantity(){
            var max = Number($('#qty').attr('max'));
            var value = Number($('#qty').val());
            if(value > max){
                $('#error-quantity').text('Chỉ còn ' + max + ' sản phẩm');
                $('.state-default').text('Nhập số lượng');
                $('.btn-add-to-cart').attr('disabled','disabled');
            } else {
                $('#error-quantity').text('');
                if($('#color').val() == '' || $('#size').val() == ''){
                    $('.state-default').text('Chọn Màu & Size');
                    $('.btn-add-to-cart').attr('disabled','disabled');
                } else {
                    $('.state-default').text('Thêm vào giỏ');
                    $('.btn-add-to-cart').removeAttr('disabled');
                }
            }
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
                        $('.element-'+id).attr('data-original-title', 'Xóa khỏi danh sách yêu thích');
                        $('.element-'+id).attr('data-field', 'remove');
                        $(".heart-active-"+id).attr("src","{{ asset('public/default/img/core-img/heart-active.png') }}"); // active
                    } else {
                        $('.element-'+id).removeClass("liked");
                        $('.element-'+id).attr('data-original-title', 'Thêm khỏi danh sách yêu thích');
                        $('.element-'+id).attr('data-field', 'add');
                        $(".heart-active-"+id).attr("src","{{ asset('public/default/img/core-img/heart-default.png') }}"); // default
                    }
                    $('.element-'+id).attr('data-field', response.item);

                }
            });
        }
    </script>

    <script>
        Fancybox.bind("[data-fancybox]", {
            Carousel: {
                transition: "slide",
            },
            // Disable image zoom animation on opening and closing
            Images: {
                zoom: false,
            },
        });
    </script>

    <style>
        .f-carousel {
            --f-carousel-slide-width: calc(100% / 4);
        }
        .popup-body {
            text-align: left;
        }
        table {
            border-collapse: collapse;
            background: #F8F8F8;
            width: 20em;
            text-align: center;
        }

        th, td {
            border: 1px solid #AAA;
            height: 1em;
        }

        th {
            background: #CCC;
        }

        .hover {
            background: #E8E8E8;
        }

        td:hover {
            background: #800020;
            color: white;
        }

        .popup-body li.active {
            background: #800020;
            color: white;
        }

        .popup-body li.active a {
            color: white !important;
        }
    </style>
@endsection
