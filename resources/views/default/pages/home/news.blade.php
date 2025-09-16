@extends('default.main')
@section('content')
<div class="artiz_product_area_new_in section-padding-50">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h1>Tin tức về Artiz</h1>
            </div>
        </div>
        <div class="row ">
            @foreach($items as $key => $value)
                <div class="col-12 col-lg-4">
                    <a href="{{ $value['link'] }}">
                        <div class="container">
                            <img class="mb-3 mt-5" src="{{ asset('public/images/news/' . $value['picture']) }}" alt="">
                            <h5>{{ $value['title'] }}</h5>
                            <strong>{{ $value['description'] }}</strong>
                            <hr style="height: 0.1px">
                            <small>{{ $value['source'] }} | {{ $value['date'] }}</small>
                        </div>
                    </a>
                   
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
