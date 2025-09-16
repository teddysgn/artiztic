<?php
    $typeParams = [
        'normal' => 'Normal',
        'featured' => 'Featured'
];

    use App\Helpers\Template as Template;
    $filterButton       = Template::showButtonFilter($controllerName, $countByStatus, $params['filter']['status'], $params['search'], $params);
    $filterOccasion     = Template::showSelectFilter($controllerName, $params, $occasionParams, 'occasion');
    $filterCategory     = Template::showSelectFilter($controllerName, $params, $categoryParams, 'category');
    $filterCollection   = Template::showSelectFilter($controllerName, $params, $collectionParams, 'collection');
    $filterType         = Template::showSelectFilter($controllerName, $params, $typeParams, 'type');
    $areaSearch         = Template::showAreaSearch($controllerName, $params['search']);
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"> Products List</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) . '/form' }}" class="btn btn-sm btn-simple">Create New Product
                        </a>
                        @if(session('artiz_notify'))
                            <div class="alert alert-success">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                                {{ session('artiz_notify') }}
                            </div>
                        @endsession
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class="text-primary">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Picture</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Occasion</th>
                                    <th>Category</th>
                                    <th>Collection</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="result-ajax">
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $name           = $value['name'];
                                                $picture        = Template::showItemThumb($controllerName, $value['picture1'], $value['name'], 180);
                                                $price          = number_format($value['price']);
                                                $status         = Template::showItemStatus($controllerName, $value['id'], $value['status']);
                                                $category       = Template::showItemSelect($controllerName, $value['id'], $value['category_id'], 'category', $categoryParams, 120);
                                                $occasion       = Template::showItemSelect($controllerName, $value['id'], $value['occasion_id'], 'occasion', $occasionParams, 120);
                                                $collection     = Template::showItemSelect($controllerName, $value['id'], $value['collection_id'], 'collection', $collectionParams, 120);
                                                $type           = Template::showItemSelect($controllerName, $value['id'], $value['type'], 'type', $typeParams, 120);
                                                $buttonAction   = Template::showItemButton($controllerName, $value['id']);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{ route('product/form', ['id' => $value['id']]) }}">{!! $name !!}</a></td>
                                                <td>{!! $picture !!}</td>
                                                <td>{{ $price }}</td>
                                                <td>{!! $status !!}</td>
                                                <td>{!! $occasion !!}</td>
                                                <td>{!! $category !!}</td>
                                                <td>{!! $collection !!}</td>
                                                <td>{!! $type !!}</td>
                                                <td>{!! $buttonAction !!}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('admin.template.list_empty', ['colspan' => 11])
                                    @endif
                                </tbody>
                                <div class="row">
                                    <div class="col-sm-12 col-lg-3">
                                        {!! $filterOccasion !!}
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        {!! $filterCategory !!}
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        {!! $filterCollection !!}
                                    </div>
                                    <div class="col-sm-12 col-lg-3">
                                        {!! $filterType !!}
                                    </div>
                                    <div class="col-sm-12 col-md-5">
                                        {!! $filterButton !!}
                                    </div>
                                    <div class="col-sm-12 col-md-7">
                                        {!! $areaSearch !!}
                                    </div>
                                </div>
                            </table>
                            {!! $items->appends(request()->input())->links('admin.template.pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<style>
    .search-ajax-result {
        position: absolute;
        align-items: center;
        width: 90%;
        background: #FFF;
        z-index: 5;
        border-radius: 5px;
    }

    .search-ajax-result a:hover {
        text-decoration: none
    }

    .search-ajax-result a:hover .media {
        background: linear-gradient(to bottom left, #C3B499, #927C66, #C3B499);
        color: #ffffff
    }
</style>
<script>
    $(document).ready(function(){
        $('#search_input').keyup(function(){
            var text = $(this).val();
            var html = '';
            var src = '{{ asset('public/images/product/') }}';

            $.ajax({
                type: "GET",
                url: "{{route('product/ajax')}}?key=" + text,
                success: function(response){
                    var _html = '';
                    for(var pro of response){
                        html += '<a href="product/form/'+pro.product_id+'">'
                        html += '<div class="media mb-2 align-items-center">';
                        html += '    <div class="pull-left m-2">';
                        html += '        <img class="media-objext" width="65" src="'+src+'/'+pro.name+'/'+pro.picture1+'">';
                        html += '    </div>';
                        html += '    <div class="media-body">';
                        html += '        <h4 class="media-heading m-0">'+pro.name+'</h4>';
                        html += '        <p>'+pro.category_name+'</p>';
                        html += '    </div>';
                        html += '</div>';
                        html += '</a>'
                    }
                    $('.search-ajax-result').html(html);
                    
                }
            });
        });
    })
</script>
@endsection
