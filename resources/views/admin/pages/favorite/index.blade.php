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
                        <h4 class="card-title"> Favorite List</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Picture</th>
                                    <th>Product</th>
                                    <th>User</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $name           = $value['product_name'];
                                                $user           = $value['user_name'];
                                                $picture        = Template::showItemThumb('product', $value['product_picture'], $value['product_name'], 180);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{!! $picture !!}</td>
                                                <td>{!! $name !!}</td>
                                                <td>{{ $user }}</td>
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
