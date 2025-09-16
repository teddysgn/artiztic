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
                        <h4 class="card-title"> Member List</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) . '/form' }}" class="btn btn-sm btn-simple">Create New Member
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
                                    <th>Name</th>
                                    <th>Discount</th>
                                    <th>Milestone</th>
                                    <th>Created At</th>
                                    <th>Created By</th>
                                    <th>Modified At</th>
                                    <th>Modified By</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $name           = $value['name'];
                                                $min            = number_format($value['min'], 0, ',', '.');
                                                $discount       = $value['discount'];
                                                $created        = date('H:i:s d/m/Y', strtotime($value['created']));
                                                $createdBy      = $value['created_by'];
                                                $modified       = date('H:i:s d/m/Y', strtotime($value['modified']));
                                                $modifiedBy     = $value['modified_by'];
                                                $buttonAction   = Template::showItemButton($controllerName, $value['id']);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{!! $name !!}</td>
                                                <td>{!! $discount !!}% </td>
                                                <td>{{ $min }}</td>
                                                <td>{{ $created }}</td>
                                                <td>{{ $createdBy }}</td>
                                                <td>{{ $modified }}</td>
                                                <td>{{ $modifiedBy }}</td>
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
