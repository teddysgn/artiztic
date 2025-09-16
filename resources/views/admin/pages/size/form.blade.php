<?php
use Illuminate\Support\Number;

$name = '';
$id = $ordering = $price = $quantity = $description = $status = '';
$statusValue    = [
    'default' => 'Select Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

if ($item != null) {
    $id          = $item['id'];
    $name        = $item['name'];
    $status      = $item['status'];
}
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <form id="main-form" method="POST" action="{{ route($controllerName) . '/save' }}" accept-charset="UTF-8"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Create New Size</h4>
                            <a style="padding: 10px 18px" href="{{ route($controllerName) }}"
                                class="btn btn-sm btn-simple">Back to List
                            </a>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <p class="text-white">{{ $error }}</p>
                                        @endforeach
                                        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                            <i class="tim-icons icon-simple-remove"></i>
                                          </button>
                                </div>
                            @endif
                            @if (session('artiz_notify'))
                                <div class="alert alert-success">
                                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                    {{ session('artiz_notify') }}
                                </div>
                                @endsession
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                            value="{{ old('name', $name) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ordering">Ordering</label>
                                        <input type="number" id="ordering" name="ordering" class="form-control" placeholder="Ordering"
                                            value="{{ old('ordering', $ordering) }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status">
                                            @foreach ($statusValue as $key => $value)
                                                @if ($status == $key)
                                                    <option value="{{ $key }}" selected>
                                                        {{ $value }}
                                                    </option>
                                                @else
                                                    <option value="{{ $key }}">
                                                        {{ $value }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <button type="submit" class="btn btn-fill btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
