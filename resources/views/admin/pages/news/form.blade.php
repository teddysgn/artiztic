<?php
use Illuminate\Support\Number;

$name = '';
$id = $title = $description = $status = $link = $source = $date = '';

$picture = '';
$URLPicture = asset('public/images/default.png');
$statusValue    = [
    'default' => 'Select Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

if ($item != null) {
    $id                 = $item['id'];
    $title              = $item['title'];
    $status             = $item['status'];
    $link               = $item['link'];
    $source             = $item['source'];
    $date               = $item['date'];
    $description        = $item['description'];
    $picture            = $item['picture'];
    $URLPicture         = asset('public/images/'.$controllerName.'/'. $item['picture']);
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
                            <h4 class="card-title"> Create News</h4>
                            <a style="padding: 10px 18px" href="{{ route($controllerName) }}"
                                class="btn btn-sm btn-simple">Back to list
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
                                        <label for="title">Title</label>
                                        <input type="text" id="title" name="title" class="form-control" placeholder="Title"
                                            value="{{ old('title', $title) }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description (*)</label>
                                        <textarea rows="8" style="max-height: 200px; height: fit-content" cols="120" id="description"
                                            name="description" class="form-control" placeholder="Description">{{ $description }}</textarea>
                                        <small class="text-danger" id="error-description">
                                            @if ($errors->has('description'))
                                                {!! $errors->first('description', $description) !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="url" id="link" name="link" class="form-control" placeholder="Link"
                                            value="{{ old('link', $link) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="source">Source</label>
                                        <input type="text" id="source" name="source" class="form-control" placeholder="Source"
                                            value="{{ old('source', $source) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">Date</label>
                                        <input type="text" id="date" name="date" class="form-control" placeholder="YYYY/MM/DD"
                                            value="{{ old('date', $date) }}">
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
                                        <label for="picture">Picture</label>
                                        <input type="file" id="picture" name="picture" class="form-control">
                                        <img id="display_picture" style="background-color: #FFC3C0"
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
        const   picture     = document.querySelector("#picture");
        var     upload_picture    = "";

        picture.addEventListener("change", function () {
            const reader = new FileReader();
            reader.addEventListener("load", () => {
                upload_picture = reader.result;
                document.querySelector("#display_picture").src = `${upload_picture}`;
            });
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
