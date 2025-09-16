<div class="accordion" id="accordionExample">
    <div class="accordion-item">
        <p class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-toggle="collapse" data-target="#collapseOne"
                aria-expanded="false" aria-controls="collapseOne">
                Category
            </button>
        </p>
        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
            data-parent="#accordionExample">
            <div class="accordion-body widget">
                <div class="catagories-menu mt-25">
                    <ul>
                        <li class="active">
                            <a class="filter" id="category-all" data-filter="category-all">Tất cả</a>
                        </li>
                        @foreach ($categories as $key => $value)
                            <li><a class="filter" id="category-{{ $key }}" data-filter="category-{{ $key }}-{{ $value }}">{{ $value }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <p class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                Bộ sưu tập
            </button>
        </p>
        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
            data-parent="#accordionExample">
            <div class="accordion-body widget">
                <div class="catagories-menu mt-25">
                    <ul>
                        <li class="active">
                            <a class="filter" id="collection-all" data-filter="collection-all">Tất cả</a>
                        </li>
                        @foreach ($collections as $key => $value)
                        
                        <li><a class="filter" id="collection-{{ $key }}" data-filter="collection-{{ $key }}">{{ $value }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <p class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Dịp/Sự kiện
            </button>
        </p>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
            data-parent="#accordionExample">
            <div class="accordion-body widget">
                <div class="catagories-menu mt-25">
                    <ul>
                        <li class="active">
                            <a class="filter" id="occasion-all" data-filter="occasion-all">Tất cả</a>
                        </li>
                        @foreach ($occasions as $key => $value)
                            <li><a class="filter" id="occasion-{{ $key }}" data-filter="occasion-{{ $key }}">{{ $value }}</a></li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <p class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Màu sắc
            </button>
        </p>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
            data-parent="#accordionExample">
            <div class="accordion-body p-0">
                <div class="widget color mt-30">
                    <div class="widget-desc">
                        <ul class="d-flex">
                            @foreach ($colorSlb as $key => $value)                               
                                <li>
                                    @php
                                        $img = asset('public/images/color/' . $value['name'] . '/' . $value['picture']);
                                    @endphp
                                    <a class="filter"  data-filter="color-{{ $value['id'] }}" id="color-{{ $value['id'] }}" data-placement="bottom" data-toggle="tooltip" title="{{ $value['name'] }}">
                                        <img src="{{ $img }}" alt="">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <p class="accordion-header" id="headingSix">
            <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                Size
            </button>
        </p>
        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
            data-parent="#accordionExample">
            <div class="accordion-body widget">
                <div class="catagories-menu mt-25">
                    <ul>
                        <li class="active">
                            <a class="filter" id="size-all" data-filter="size-all">Tất cả</a>
                        </li>
                        @foreach ($sizeSlb as $key => $value)
                        <li><a class="filter" id="size-{{ $key }}" data-filter="size-{{ $key }}">{{ $value }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion-item">
        <p class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-toggle="collapse"
                data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                Giá
            </button>
        </p>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
            data-parent="#accordionExample">
            <div class="accordion-body widget">
                <div class="catagories-menu mt-25">
                    <ul>
                        <li class="active"><a class="filter" id="price-all" data-filter="price-all">Tất cả</a></li>
                        <li><a class="filter" id="price-1" data-filter="price-1">Dưới 1M</a></li>
                        <li><a class="filter" id="price-2" data-filter="price-2">1M - 3M</a></li>
                        <li><a class="filter" id="price-3" data-filter="price-3">3M - 6M</a></li>
                        <li><a class="filter" id="price-4" data-filter="price-4">6M - 10M</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>