<?php
use Illuminate\Support\Number;

?>
@extends('default.main')
@section('content')
    <div class="products-catagories-area clearfix">
        <div style="position: relative">
            <div class="d-flex">
                <div class="slide"></div>
                <div class="slide"></div>
                <div class="slide"></div>
                <div class="slide"></div>
            </div>
        </div>
        <div>
            <div style="position: absolute; top: 300px">
                <a href="cart.html" class="btn artiz-btn w-100 mb-4 px-5">Shop Collection</a>
            </div>
        </div>
        
        
        <div class="artiz-pro-catagory clearfix">
            <!-- Single Catagory -->
            @foreach ($items as $key => $value)
                @php
                    $name = $value['name'];
                    $price = number_format($value['price']);
                    $picture = asset('public/images/product/' . $value['name'] . '/' . $value['picture1']);
                @endphp
                <div class="single-products-catagory clearfix">
                    <a href="{{ route('shop/detail', [
                        'id' => $value['id'],
                        'name' => Str::slug($value['name'])]
                        ) }}">
                        <img src="{{ $picture }}" alt="">
                        <!-- Hover Content -->
                        
                    </a>
                </div>
            @endforeach
        </div>
        <div style="background: #f4f2f0; margin-top: 50px">
            <div class="row m-0">
                <div class="col-md-12 col-lg-4 d-flex align-items-center">
                    <div class="container">
                        <div class="cart-title mt-50">
                            <h2>New In</h2>
                            <p>New arrivals, now dropping five days a week – discover the latest launches onsite from Monday to Friday</p>
                            <a href="cart.html" class="btn artiz-btn w-100 mb-4">Shop New In</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 p-0">
                    <div class="f-carousel" id="myCarousel1">
                        <div class="f-carousel__viewport">
                            <div class="f-carousel__track">
                                @foreach ($items as $key => $value)
                                    @php
                                        $picture = asset('public/images/product/' . $value['name'] . '/' . $value['picture1']);
                                    @endphp
                                    <div class="f-carousel__slide"><a href="hello/{{ $value['id'] }}.php"><img src="{{ $picture }}" alt=""></a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-0 container-fluid">
            <div class="col-md-6 col-sm-12 px-0" style="padding-top: 50px">
                <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2029438/e9133696a88c3f807cc0712e0592c297/image-desktop-data.jpg/w1500_q80.jpg" alt="">
                <div>
                    <h3 class="mt-3 mb-1">The exclusives</h3>
                    <p class="m-0">Presenting the ultra-covetable pieces that are only available at NET‑A‑PORTER</p>
                    <a href="">Shop the edit</a>
                </div>
               
            </div>
            <div class="col-md-6 col-sm-12 px-0" style="padding-top: 50px">
                <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2029436/2424dbb99a971f0941f3b2a5ced564f0/image-desktop-data.jpg/w1500_q80.jpg" alt="">
                <div>
                    <h3 class="mt-3 mb-1">Runway stars</h3>
                    <p class="m-0">We shine a spotlight on the looks to know, straight from the shows</p>
                    <a href="">Shop the edit</a>
                </div>
            </div>
        </div>

        <div style="background: #f4f2f0; margin-top: 50px">
            <div class="row m-0">
                <div class="col-md-12 col-lg-4 d-flex align-items-center">
                    <div class="container">
                        <div class="cart-title mt-50">
                            <h2>Spotlight on Artiz</h2>
                            <p>Discover the latest array of stylish new-season pieces</p>
                            <a href="cart.html" class="btn artiz-btn w-100 mb-4">Shop The Collection</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8 p-0">
                    <div class="f-carousel" id="myCarousel2">
                        <div class="f-carousel__viewport">
                            <div class="f-carousel__track">
                                @foreach ($items as $key => $value)
                                    @php
                                        $picture = asset('public/images/product/' . $value['name'] . '/' . $value['picture1']);
                                    @endphp
                                    <div class="f-carousel__slide"><a href="hello/{{ $value['id'] }}.php"><img src="{{ $picture }}" alt=""></a></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-0 container-fluid">
            <div class="col-md-4 col-sm-12 px-0" style="padding-top: 50px">
                <img src="https://tpc.googlesyndication.com/simgad/1847585528953486940?" alt="">
                <div>
                    <h3 class="mt-3 mb-1">The exclusives</h3>
                    <p class="m-0">Presenting the ultra-covetable pieces that are only available at NET‑A‑PORTER</p>
                    <a href="">Shop the edit</a>
                </div>
               
            </div>
            <div class="col-md-4 col-sm-12 px-0" style="padding-top: 50px">
                <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2251236/769ff7c736d1a2e1eb15e7e83345adc1/image-data.jpg/w1500_q80.jpg" alt="">
                <div>
                    <h3 class="mt-3 mb-1">Runway stars</h3>
                    <p class="m-0">We shine a spotlight on the looks to know, straight from the shows</p>
                    <a href="">Shop the edit</a>
                </div>
            </div>
            <div class="col-md-4 col-sm-12 px-0" style="padding-top: 50px">
                <img src="https://www.net-a-porter.com/content/images/cms/ycm/resource/blob/2251272/cf106fec64755ee136acf522c0ae069e/image-data.jpg/w1500_q80.jpg" alt="">
                <div>
                    <h3 class="mt-3 mb-1">Runway stars</h3>
                    <p class="m-0">We shine a spotlight on the looks to know, straight from the shows</p>
                    <a href="">Shop the edit</a>
                </div>
            </div>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css" />
    <style>
        .f-carousel {
            --f-carousel-slide-width: calc(100% / 3);
        }
        .slide {
            height: 60vh;
            width: 50%;
            overflow: hidden;
            flex: 1;
            border-right: 1px solid white;
            filter: invert(30%);
            transition: 0.7s ease-in-out;
        }

        .slide:nth-child(1) {
            background: url({{ asset('public/default/img/slide/01.webp') }});
            background-position: center center;
            background-size: cover;
        }
        .slide:nth-child(2) {
            background: url({{ asset('public/default/img/slide/02.webp') }});
            background-position: center center;
            background-size: cover;
        }
        .slide:nth-child(3) {
            background: url({{ asset('public/default/img/slide/03.webp') }});
            background-position: center center;
            background-size: cover;
        }
        .slide:nth-child(4) {
            background: url({{ asset('public/default/img/slide/04.webp') }});
            background-position: center center;
            background-size: cover;
        }
        .slide:hover {
            flex-grow: 7;
            filter: invert(0);
            box-shadow: 0 0 20px 10px rgb(0, 0, 0, .5);
        }
    </style>
    <script>
        const container1 = document.getElementById("myCarousel1");
        const container2 = document.getElementById("myCarousel2");
        const options = {
            Dots: false,
            infinite: true,
        };

        new Carousel(container1, options);
        new Carousel(container2, options);
    </script>
@endsection
