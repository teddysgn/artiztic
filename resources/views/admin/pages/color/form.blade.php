<?php
use Illuminate\Support\Number;

$name = '';
$id = $ordering = $price = $quantity = $description = $status = $picture = '';
$URLPicture = asset('public/images/default.png');
$statusValue    = [
    'default' => 'Select Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

if ($item != null) {
    $id          = $item['id'];
    $name        = $item['name'];
    $status      = $item['status'];
    $ordering    = $item['ordering'];
    if ($item['picture'] != null) {
        $picture     = $item['picture'];
        $URLPicture = asset('public/images/color/' . $name . '/' . $item['picture']);
    }
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
                            <h4 class="card-title"> Create New Color</h4>
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Name"
                                            value="{{ old('name', $name) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="ordering">Ordering</label>
                                        <input type="number" id="ordering" name="ordering" class="form-control" placeholder="Ordering"
                                            value="{{ old('ordering', $ordering) }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="picture">Picture</label>
                                        <input type="file" id="picture" name="picture" class="form-control">
                                        <img id="display_image" style="background-color: #FFC3C0; width: 100%"
                                            src="{{ old('picture', $URLPicture) }}" alt="">

                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="card-footer">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="hidden_picture" value="{{ $picture }}">
                            <button type="submit" class="btn btn-fill btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        const picture = document.querySelector("#picture");
        var upload_image = "";

        picture.addEventListener("change", function() {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                upload_image = reader.result;
                document.querySelector("#display_image").src = `${upload_image}`;
            });
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
