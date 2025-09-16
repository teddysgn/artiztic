<?php
    use App\Helpers\Template as Template;
    $filterButton       = Template::showButtonFilter($controllerName, $countByStatus, $params['filter']['status'], $params['search'], $params);
    $areaSearch         = Template::showAreaSearch($controllerName, $params['search']);

    $levelParams = [
        'admin' => 'Admin',
        'member' => 'Member'
];
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"> User List</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) . '/form' }}" class="btn btn-sm btn-simple">Create New User
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
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Full Name</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                    <th>Last Activity</th>
                                    <th>Online</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $username       = $value['username'];
                                                $email          = $value['email'];
                                                $fullname       = $value['fullname'];
                                                $level          = Template::showItemSelect($controllerName, $value['id'], $value['level'], 'level', $levelParams, 120);;
                                                $status         = Template::showItemStatus($controllerName, $value['id'], $value['status']);
                                               
                                                $buttonAction   = Template::showItemButton($controllerName, $value['id']);
                                                $online         = $value['last_activity'];
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $username }}</td>
                                                <td>{{ $email }}</td>
                                                <td>{{ $fullname }}</td>
                                                <td>{!! $level !!}</td>
                                                <td>{!! $status !!}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($online)->diffForHumans() }}
                                                </td>
                                                <td>
                                                    @if(Cache::has('user-is-online-'. $value['id']))
                                                        <span class="text-success">Online</span>
                                                    @else
                                                        <span class="text-danger">Offline</span>
                                                    @endif
                                                </td>
                                                <td>{!! $buttonAction !!}</td>
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
