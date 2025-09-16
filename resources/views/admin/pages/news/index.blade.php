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
                        <h4 class="card-title"> News List</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) . '/form' }}" class="btn btn-sm btn-simple">Create News
                        </a>
                        @if(session('artiz_notify'))
                            <div class="alert alert-success">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                                {{ session('artiz_notify') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Picture</th>
                                    <th>Title</th>
                                    <th>Source</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $title          = $value['title'];
                                                $link           = $value['link'];
                                                $source         = $value['source'];
                                                $date           = $value['date'];
                                                $status         = Template::showItemStatus($controllerName, $value['id'], $value['status']);
                                                $picture        = Template::showItemThumb($controllerName, $value['picture'], '', 180);
                                                $created        = date('H:i:s d/m/Y', strtotime($value['created']));
                                                $createdBy      = $value['created_by'];
                                                $modified       = date('H:i:s d/m/Y', strtotime($value['modified']));
                                                $modifiedBy     = $value['modified_by'];
                                                $buttonAction   = Template::showItemButton($controllerName, $value['id']);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{!! $picture !!}</td>
                                                <td><a href="{{ $link }}">{!! $title !!}</a></td>
                                                <td>{!! $source !!}</td>
                                                <td>{!! $status !!}</td>
                                                <td>{!! $date !!}</td>
                                                <td>{!! $buttonAction !!}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('admin.template.list_empty', ['colspan' => 7])
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
