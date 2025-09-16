<?php
    use App\Helpers\Template as Template;
    $areaSearch         = Template::showAreaSearch($controllerName, $params['search']);
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"> SKU List</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) . '/form' }}" class="btn btn-sm btn-simple">Create New SKU
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
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>SKU</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Style</th>
                                    <th>Quantity</th>
                                    <th>Stock</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $sku            = $value['barcode'];
                                                $color          = $value['color'];
                                                $size           = $value['size'];
                                                $style          = $value['style'];
                                                $quantity       = $value['quantity'];
                                                $stock          = $value['stock'];
                                                $created        = date('H:i:s d/m/Y', strtotime($value['created']));
                                                $createdBy      = $value['created_by'];
                                                $buttonAction   = Template::showItemButton($controllerName, $value['id']);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{!! $sku !!}</td>
                                                <td>{!! $color !!}</td>
                                                <td>{!! $size !!}</td>
                                                <td>{!! $style !!}</td>
                                                <td>{!! $quantity !!}</td>
                                                <td>{!! $stock !!}</td>
                                                <td>{{ $created }}</td>
                                                <td>{{ $createdBy }}</td>
                                                <td>{!! $buttonAction !!}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('admin.template.list_empty', ['colspan' => 8])
                                    @endif
                                </tbody>
                                <div class="row">
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
@endsection
