<?php
    use App\Helpers\Template as Template;
    $filterButton       = Template::showButtonFilter($controllerName, $countByStatus, $params['filter']['status'], $params['search'], $params);
    $areaSearch         = Template::showAreaSearch($controllerName, $params['search']);
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"> Rating & Review</h4>
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
                                    <th>Picture</th>
                                    <th>Product</th>
                                    <th>User</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Modified</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $user           = $value['user_fullname'];
                                                $product        = $value['product_name'];
                                                $review         = $value['review'];
                                                $rating         = $value['rating'];
                                                $status         = Template::showItemStatus($controllerName, $value['id'], $value['status']);
                                                $picture        = Template::showItemThumb('product', $value['product_picture'], $value['product_name'], 180);
                                                $created        = date('H:i:s d/m/Y', strtotime($value['created']));
                                                $modified       = date('H:i:s d/m/Y', strtotime($value['modified']));
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{!! $picture !!}</td>
                                                <td>{!! $product !!}</td>
                                                <td>{!! $user !!}</td>
                                                <td>{!! $review !!}</td>
                                                <td>{!! $rating !!}</td>
                                                <td>{!! $status !!}</td>
                                                <td>{{ $created }}</td>
                                                <td>{{ $modified }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('admin.template.list_empty', ['colspan' => 8])
                                    @endif
                                </tbody>
                                <div class="row">
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
@endsection
