<?php
use Illuminate\Support\Number;

$name = '';
$id = $name = $value = $status = $code = $expired = $maximum = '';

$picture_profile = '';
$URLPicturePprofile = asset('public/images/default.png');
$statusValue    = [
    'default' => 'Select Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

if ($item != null) {
    $id                 = $item['id'];
    $name               = $item['name'];
    $status             = $item['status'];
    $value              = $item['value'];
    $maximum            = $item['maximum'];
    $code               = $item['code'];
    $expired            = $item['expired'];
}
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <form id="main-form" method="POST" action="{{ route($controllerName) . '/save' }}" accept-charset="UTF-8"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            @if ($id == '')
                                <h4 class="card-title"> Create New Coupon</h4>
                            @else
                                <h4 class="card-title"> Edit Coupon</h4>
                            @endif
                            <a style="padding: 10px 18px" href="{{ route($controllerName) }}"
                                class="btn btn-sm btn-simple">Back to list
                            </a>
                            @if (session('artiz_notify'))
                                <div class="alert alert-success">
                                    <button type="button" aria-hidden="true" class="close" data-dismiss="alert"
                                        aria-label="Close">
                                        <i class="tim-icons icon-simple-remove"></i>
                                    </button>
                                    {{ session('artiz_notify') }}
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name (*)</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name" required
                                            value="{{ old('name', $name) }}">
                                        <small class="text-danger" id="error-name">
                                            @if ($errors->has('name'))
                                                {!! $errors->first('name') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code">Code (*)</label>
                                        <input type="text" id="code" name="code" class="form-control" placeholder="Code" required
                                            value="{{ old('code', $code) }}">
                                        <small class="text-danger" id="error-code">
                                            @if ($errors->has('code'))
                                                {!! $errors->first('code') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="value">Value (*)</label>
                                        <input type="number" id="value" name="value" class="form-control" placeholder="Value" required
                                            value="{{ old('value', $value) }}">
                                        <small class="text-danger" id="error-value">
                                            @if ($errors->has('value'))
                                                {!! $errors->first('value') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="maximum">Maximum</label>
                                        <input type="number" id="maximum" name="maximum" class="form-control" placeholder="Maximum" required
                                            value="{{ old('maximum', $maximum) }}">
                                        <small class="text-danger" id="error-maximum">
                                            @if ($errors->has('maximum'))
                                                {!! $errors->first('maximum') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status (*)</label>
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
                                        <small class="text-danger" id="error-status">
                                            @if ($errors->has('status'))
                                                {!! $errors->first('status') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expired">Expired (*)</label>
                                        <input type="text" id="expired" name="expired" class="form-control" placeholder="YYYY-MM-DD" required
                                            value="{{ old('expired', $expired) }}">
                                        <small class="text-danger" id="error-expired">
                                            @if ($errors->has('expired'))
                                                {!! $errors->first('expired') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="task" value="add">
                            <button type="submit" class="btn btn-fill btn-primary">Save</button>
                        </div>
                    </div>
                </div>
                
        </form>
                @if($id == '')
                    <div class="col-md-5">
                        <form id="main-form" method="POST" action="{{ route($controllerName) . '/generate' }}" accept-charset="UTF-8"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> Create Multiple</h4>
                                    <a style="padding: 10px 18px" href="{{ route($controllerName) }}"
                                        class="btn btn-sm btn-simple">Back to list
                                    </a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name_multiple">Name (*)</label>
                                                <input type="text" id="value" name="name_multiple" class="form-control" placeholder="Name" required
                                                    value="{{ old('name_multiple') }}">
                                                <small class="text-danger" id="error-value-multiple">
                                                    @if ($errors->has('name_multiple'))
                                                        {!! $errors->first('name_multiple') !!}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="quantity_multiple">Quantity (*)</label>
                                                <input type="number" id="quantity" name="quantity_multiple" class="form-control" placeholder="Quantity" required value="{{ old('quantity_multiple') }}">
                                                <small class="text-danger" id="error-quantity-multiple">
                                                    @if ($errors->has('quantity_multiple'))
                                                        {!! $errors->first('quantity_multiple') !!}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="value_multiple">Value (*)</label>
                                                <input type="number" id="value_multiple" name="value_multiple" class="form-control" placeholder="Value" required
                                                    value="{{ old('value_multiple') }}">
                                                <small class="text-danger" id="error-value-multiple">
                                                    @if ($errors->has('value_multiple'))
                                                        {!! $errors->first('value_multiple') !!}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="maximum_multiple">Maximum</label>
                                                <input type="number" id="maximum_multiple" name="maximum_multiple" class="form-control" placeholder="Maximum" required
                                                    value="{{ old('maximum_multiple') }}">
                                                <small class="text-danger" id="error-maximum-multiple">
                                                    @if ($errors->has('maximum_multiple'))
                                                        {!! $errors->first('maximum_multiple') !!}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status_multiple">Status (*)</label>
                                                <select class="form-control" name="status_multiple" id="status_multiple">
                                                    <option value="default">Select Status</option>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                </select>
                                                <small class="text-danger" id="error-status-multiple">
                                                    @if ($errors->has('status_multiple'))
                                                        {!! $errors->first('status_multiple') !!}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="expired_multiple">Expired (*)</label>
                                                <input type="text" id="expired_multiple" name="expired_multiple" class="form-control" placeholder="YYYY-MM-DD" required
                                                    value="{{ old('expired_multiple') }}">
                                                <small class="text-danger" id="error-expired-multiple">
                                                    @if ($errors->has('expired_multiple'))
                                                        {!! $errors->first('expired_multiple') !!}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" name="task" value="generate">
                                    <button type="submit" class="btn btn-fill btn-primary">Generate</button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        
    </div>
@endsection
