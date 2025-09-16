@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/order') }}">
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-bag-16 text-primary"></i> Orders</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/user') }}">
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-single-02 text-primary"></i> Users</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/product') }}">
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-scissors text-primary"></i> Products</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
