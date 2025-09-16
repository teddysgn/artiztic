<?php
use Illuminate\Support\Number;

$name = '';
$id = $name = $min = $discount = $code = '';

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
    $min                = $item['min'];
    $discount           = $item['discount'];
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
                            <h4 class="card-title"> Create New Member</h4>
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
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name"
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
                                        <label for="min">Milestone *</label>
                                        <input type="text" id="min" name="min" class="form-control" placeholder="Milestone" onkeyup="inputChange()" 
                                            value="{{ old('min', number_format($min, 0, '.', ',')) }}">
                                        <small class="text-danger" id="error-min">
                                            @if ($errors->has('min'))
                                                {!! $errors->first('min') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="discount">Discount *</label>
                                        <input type="number" id="discount" name="discount" class="form-control" placeholder="Discount"
                                            value="{{ old('discount', $discount) }}">
                                        <small class="text-danger" id="error-discount">
                                            @if ($errors->has('discount'))
                                                {!! $errors->first('discount') !!}
                                            @endif
                                        </small>
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
        </form>
    </div>
    <script>
        function inputChange(){
            const value = $( "#min" ).val();
            $( "input#min" ).val( Intl.NumberFormat().format(Number(value.replaceAll(',', ''))) )
        }
    </script>
@endsection
