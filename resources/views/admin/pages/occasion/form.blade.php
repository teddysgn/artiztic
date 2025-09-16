<?php
use Illuminate\Support\Number;

$name = '';
$id = $ordering = $status =  '';

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
    $ordering           = $item['ordering'];
    $picture_profile    = $item['picture_profile'];
    $URLPicturePprofile = asset('public/images/'.$controllerName.'/' . $name . '/' . $item['picture_profile']);
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
                            <h4 class="card-title"> Create New Occasion</h4>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                            value="{{ old('name', $name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ordering">Ordering</label>
                                        <input type="number" id="ordering" name="ordering" class="form-control" placeholder="Ordering"
                                            value="{{ old('ordering', $ordering) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                       
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="picture_profile">Picture Profile</label>
                                        <input type="file" id="picture_profile" name="picture_profile" class="form-control">
                                        <img id="display_picture_profile" style="background-color: #FFC3C0"
                                            src="{{ old('picture_profile', $URLPicturePprofile) }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="hidden_picture_profile" value="{{ $picture_profile }}">
                            <button type="submit" class="btn btn-fill btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        const   picture_profile     = document.querySelector("#picture_profile");
        var     upload_picture_profile    = "";

        picture_profile.addEventListener("change", function () {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                upload_picture_profile = reader.result;
                document.querySelector("#display_picture_profile").src = `${upload_picture_profile}`;
            });
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection

