<?php
use Illuminate\Support\Number;
use Illuminate\Support\Str;

?>
@extends('default.main')
@section('content')
    <div class="artiz_product_area_new_in section-padding-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                    <h1>Collections</h1>
                </div>
                <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                    <p>At ARTIZ, we are committed to leading meaningful positive change, investing in our diverse global community and responding to environmental challenges through innovation and collaboration.</p>
                </div>
            </div>
            <div class="row">
                @foreach ($collections as $key => $value)
                    @php
                        $name =  $value['name'];
                        $description =  $value['description'];
                        $picture = asset(
                            'public/images/collection/' . $name . '/' . $value['picture_profile'],
                        );
                    @endphp
                    <div class="col-md-6 col-sm-12" style="padding-top: 50px">
                        <img src="{{ $picture }}" alt="">
                        <h3 class="mt-3 mb-1">{{ $name }}</h3>
                        <p class="m-0">{{ $description }}</p>
                        <a href="{{ route('shop', ['collection_id' => $value['id']]) }}">Shop the edit</a>
                    </div>
                @endforeach
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
