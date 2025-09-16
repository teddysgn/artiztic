<?php
use Illuminate\Support\Number;
use Illuminate\Support\Str;

?>
@extends('default.main')
@section('content')
    <div class="artiz_product_area_new_in section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="product-topbar d-xl-flex align-items-end justify-content-between">
                        <!-- Total Products -->
                        <div class="total-products">
                            <h2>Shop by</h2>
                            <p class="text-capitalize">Explore our edits of ultra-stylish pieces for any and every occasion,
                                as chosen by our fashion experts</p>
                        </div>
                    </div>
                </div>
            </div>

            <div style="background: #f4f2f0">
                <br>
                <h4 class="text-center">All products</h4>
                <div class="row m-1">
                    <div class="col-md-12 col-lg-12 p-0 m-1">
                        <div class="f-carousel" id="myCarousel1">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track mb-4">
                                    @foreach ($categories as $key => $value)
                                        @php
                                            $picture = asset(
                                                'public/images/category/' . $value['name'] . '/' . $value['picture_profile'],
                                            );
                                        @endphp
                                        <div class="f-carousel__slide">
                                            <a
                                                href="{{ route('shop/category', ['category_id' => $value['id']]) }}">
                                                <img class="p-1" src="{{ $picture }}" alt="">
                                                <p class="p-1 mb-0 mt-2 text-center">{{ $value['name'] }}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                    <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2029324/2c83cbbe3b11981a136b07914c71e95e/image-desktop-data.jpg/w1500_q80.jpg" alt="">
                    <h3 class="mt-3 mb-1">Practically perfect</h3>
                    <p class="m-0">Elevate your everyday in new-season pieces designed for a great time</p>
                    <a href="">Shop spring/summer ’24</a>
                </div>
                <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                    <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2029322/c54cc968a0183239193a76d450ec52e3/image-desktop-data.jpg/w1500_q80.jpg" alt="">
                    <h3 class="mt-3 mb-1">The bestsellers</h3>
                    <p class="m-0">Discover the most desired items that everyone has their sights on</p>
                    <a href="">Shop bestsellers</a>
                </div>
            </div>

            <div style="background: #f4f2f0; margin-top: 50px">
                <br>
                <h4 class="text-center">The Collections</h4>
                <div class="row m-1">
                    <div class="col-md-12 col-lg-12 p-0 m-1">
                        <div class="f-carousel" id="myCarousel2">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track mb-4">
                                    @foreach ($collections as $key => $value)
                                        @php
                                            $picture = asset(
                                                'public/images/collection/' . $value['name'] . '/' . $value['picture_profile'],
                                            );
                                        @endphp
                                        <div class="f-carousel__slide">
                                            <a
                                                href="{{ route('shop/collection', ['collection_id' => $value['id']]) }}">
                                                <img class="p-1" src="{{ $picture }}" alt="">
                                                <p class="p-1 mb-0 mt-2 text-center">{{ $value['name'] }}</p>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                    <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2029438/e9133696a88c3f807cc0712e0592c297/image-desktop-data.jpg/w1500_q80.jpg" alt="">
                    <h3 class="mt-3 mb-1">The exclusives</h3>
                    <p class="m-0">Presenting the ultra-covetable pieces that are only available at NET‑A‑PORTER</p>
                    <a href="">Shop the edit</a>
                </div>
                <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                    <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2029436/2424dbb99a971f0941f3b2a5ced564f0/image-desktop-data.jpg/w1500_q80.jpg" alt="">
                    <h3 class="mt-3 mb-1">Runway stars</h3>
                    <p class="m-0">We shine a spotlight on the looks to know, straight from the shows</p>
                    <a href="">Shop the edit</a>
                </div>
            </div>

            <div style="background: #f4f2f0; margin-top: 50px">
                <br>
                <h4 class="text-center">Occasions</h4>
                <div class="row m-1">
                    <div class="col-md-12 col-lg-12 p-0 m-1">
                        <div class="f-carousel" id="myCarousel3">
                            <div class="f-carousel__viewport">
                                <div class="f-carousel__track mb-4">
                                    @foreach ($occasions as $key => $value)
                                        @php
                                            $picture = asset(
                                                'public/images/occasion/' . $value['name'] . '/' . $value['picture_profile'],
                                            );
                                        @endphp
                                        <div class="f-carousel__slide">
                                            <a
                                                href="{{ route('shop/occasion', ['occasion_id' => $value['id']]) }}">
                                                <img class="p-1" src="{{ $picture }}" alt="">
                                                <p class="p-1 mb-0 mt-2 text-center">{{ $value['name'] }}</p>
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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css" />
    <style>
        .f-carousel {
            --f-carousel-slide-width: calc(100% / 6) !important;
        }

        @media only screen and (max-width: 767px) {
            .f-carousel {
                --f-carousel-slide-width: calc(100% / 2) !important;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 991px) {
            .f-carousel {
                --f-carousel-slide-width: calc(100% / 3) !important;
            }
        }
    </style>
    <script>
        const container1 = document.getElementById("myCarousel1");
        const container2 = document.getElementById("myCarousel2");
        const container3 = document.getElementById("myCarousel3");
        const options = {
            Dots: false,
            infinite: true,
        };

        new Carousel(container1, options);
        new Carousel(container2, options);
        new Carousel(container3, options);
    </script>
@endsection
