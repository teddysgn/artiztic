<?php
use Illuminate\Support\Number;

$id = $name = $type = $description = $status = '';
$category = $collection = $style = $occasion = $care = $composition = '';
$price = 0;
$color = $size = [];
$dataColor = $colorSlb;
$dataSize = $sizeSlb;
$fabric = $hip = $waist = $bust = '';
$picture1 = $picture2 = $picture3 = $picture4 = $picture5 = $picture6 = '';
$URLPicture1 = $URLPicture2 = $URLPicture3 = $URLPicture4 = $URLPicture5 = $URLPicture6 = asset('public/images/default.png');
$statusValue = [
    'default' => 'Select Status',
    'active' => 'Active',
    'inactive' => 'Inactive',
];

$typeValue = [
    'default' => 'Select Type',
    'featured' => 'Featured',
    'normal' => 'Normal',
];

if ($item != null) {
    $id = $item['id'];
    $name = $item['name'];
    $price = $item['price'];
    $type = $item['type'];
    $description = $item['description'];
    $status = $item['status'];
    $category = $item['category_id'];
    $collection = $item['collection_id'];
    $size = array_flip(explode(',', $item['size']));
    $color = array_flip(explode(',', $item['color']));
    $occasion = $item['occasion_id'];
    $occasion = $item['occasion_id'];
    $style = $item['style'];
    $care = $item['care'];
    $composition = $item['composition'];
    $hip = $item['hip'];
    $waist = $item['waist'];
    $bust = $item['bust'];
    $fabric = $item['fabric'];
    $picture1 = $item['picture1'];
    $picture2 = $item['picture2'];
    $picture3 = $item['picture3'];
    $picture4 = $item['picture4'];
    $picture5 = $item['picture5'];
    $picture6 = $item['picture6'];

    if ($item['picture1'] != null) {
        $URLPicture1 = asset('public/images/product/' . $name . '/' . $item['picture1']);
    }
    if ($item['picture2'] != null) {
        $URLPicture2 = asset('public/images/product/' . $name . '/' . $item['picture2']);
    }
    if ($item['picture3'] != null) {
        $URLPicture3 = asset('public/images/product/' . $name . '/' . $item['picture3']);
    }
    if ($item['picture4'] != null) {
        $URLPicture4 = asset('public/images/product/' . $name . '/' . $item['picture4']);
    }
    if ($item['picture5'] != null) {
        $URLPicture5 = asset('public/images/product/' . $name . '/' . $item['picture5']);
    }
    if ($item['picture6'] != null) {
        $URLPicture6 = asset('public/images/product/' . $name . '/' . $item['picture6']);
    }

    $dataColor = array_diff_key($colorSlb, $color);
    $dataSize = array_diff_key($sizeSlb, $size);
}
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <form id="main-form" name="main-form" method="POST" action="{{ route($controllerName) . '/save' }}"
            accept-charset="UTF-8" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            @if ($id == '')
                                <h4 class="card-title"> Create New Product</h4>
                            @else
                                <h4 class="card-title"> Edit Product</h4>
                            @endif
                            <a style="padding: 10px 18px" href="{{ route($controllerName) }}"
                                class="btn btn-sm btn-simple">Back to List
                            </a>

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
                                        <label for="name">Name (*)</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Name" value="{{ old('name', $name) }}">
                                        <small class="text-danger" id="error-name">
                                            @if ($errors->has('name'))
                                                {!! $errors->first('name') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="price">Price (*)</label>
                                        <input type="text" id="price" name="price" class="form-control" onkeyup="inputChange()"
                                            placeholder="Price" value="{{ old('price', number_format($price, 0, '.', ',')) }}">
                                        <small class="text-danger" id="error-price">
                                            @if ($errors->has('price'))
                                                {!! $errors->first('price') !!}
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
                                        <label for="type">Type (*)</label>
                                        <select class="form-control" name="type" id="type">
                                            @foreach ($typeValue as $key => $value)
                                                @if ($type == $key)
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
                                        <small class="text-danger" id="error-type">
                                            @if ($errors->has('type'))
                                                {!! $errors->first('type') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_id">Category (*)</label>
                                        <select class="form-control" name="category_id" id="category_id">
                                            <option value="0">
                                                Select Category
                                            </option>
                                            @foreach ($categorySlb as $key => $value)
                                                @if ($category == $key)
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
                                        <small class="text-danger" id="error-category">
                                            @if ($errors->has('category_id'))
                                                {!! $errors->first('category_id') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="collection_id">Collection (*)</label>
                                        <select class="form-control" name="collection_id" id="collection_id">
                                            <option value="0">
                                                Select Category
                                            </option>
                                            @foreach ($collectionSlb as $key => $value)
                                                @if ($collection == $key)
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
                                        <small class="text-danger" id="error-collection">
                                            @if ($errors->has('collection_id'))
                                                {!! $errors->first('collection_id') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="occasion_id">Occasion (*)</label>
                                        <select class="form-control" name="occasion_id" id="occasion_id">
                                            <option value="0">
                                                Select Occasion
                                            </option>
                                            @foreach ($occasionSlb as $key => $value)
                                                @if ($occasion == $key)
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
                                        <small class="text-danger" id="error-occasion">
                                            @if ($errors->has('occasion_id'))
                                                {!! $errors->first('occasion_id') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bust">Bust</label>
                                        <input type="text" id="bust" name="bust" class="form-control"
                                            placeholder="Bust" value="{{ old('bust', $bust) }}">
                                        <small class="text-danger" id="error-bust">
                                            @if ($errors->has('bust'))
                                                {!! $errors->first('bust') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="waist">Waist (*)</label>
                                        <input type="text" id="waist" name="waist" class="form-control"
                                            placeholder="Waist" value="{{ old('waist', $waist) }}">
                                        <small class="text-danger" id="error-waist">
                                            @if ($errors->has('waist'))
                                                {!! $errors->first('waist') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="hip">Hip</label>
                                        <input type="text" id="hip" name="hip" class="form-control"
                                            placeholder="Hip" value="{{ old('hip', $hip) }}">
                                        <small class="text-danger" id="error-hip">
                                            @if ($errors->has('hip'))
                                                {!! $errors->first('hip') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fabric">Fabric (*)</label>
                                        <input type="text" id="fabric" name="fabric" class="form-control"
                                            placeholder="Fabric" value="{{ old('fabric', $fabric) }}">
                                        <small class="text-danger" id="error-fabric">
                                            @if ($errors->has('fabric'))
                                                {!! $errors->first('fabric') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="composition">Composition (*)</label>
                                        <input type="text" id="composition" name="composition" class="form-control"
                                            placeholder="Composition" value="{{ old('composition', $composition) }}">
                                        <small class="text-danger" id="error-composition">
                                            @if ($errors->has('composition'))
                                                {!! $errors->first('composition') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="care">Care (*)</label>
                                        <input type="text" id="care" name="care" class="form-control"
                                            placeholder="Care" value="{{ old('care', $care) }}">
                                        <small class="text-danger" id="error-care">
                                            @if ($errors->has('care'))
                                                {!! $errors->first('care') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="style">Style (*)</label>
                                        <input type="text" id="style" name="style" class="form-control"
                                            placeholder="Style" value="{{ old('style', $style) }}">
                                        <small class="text-danger" id="error-style">
                                            @if ($errors->has('style'))
                                                {!! $errors->first('style') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                {{-- Color --}}
                                <div class="col-md-12">
                                    <div class="form-group m-0">
                                        <label>Color (*)</label>
                                        <small class="text-danger" id="error-color">
                                            @if ($errors->has('color'))
                                                {!! $errors->first('color') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                @foreach ($colorSlb as $keySlb => $valueSlb)
                                    @foreach ($color as $key => $value)
                                        @if ($key == $keySlb)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input color"
                                                                id="color[{{ $key }}]"
                                                                name="color[{{ $keySlb }}]" type="checkbox"
                                                                value="{{ $valueSlb }}" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check">{{ $valueSlb }}</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach

                                @foreach ($dataColor as $key => $value)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input color" id="color[{{ $key }}]"
                                                        name="color[{{ $key }}]" type="checkbox"
                                                        value="{{ $value }}">
                                                    <span class="form-check-sign">
                                                        <span class="check">{{ $value }}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- End Color --}}

                                {{-- Size --}}
                                <div class="col-md-12">
                                    <div class="form-group m-0">
                                        <label>Size (*)</label>
                                        <small class="text-danger" id="error-size">
                                            @if ($errors->has('size'))
                                                {!! $errors->first('size') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                @foreach ($sizeSlb as $keySlb => $valueSlb)
                                    @foreach ($size as $key => $value)
                                        @if ($key == $keySlb)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input size"
                                                                name="size[{{ $keySlb }}]" type="checkbox"
                                                                value="{{ $valueSlb }}" checked>
                                                            <span class="form-check-sign">
                                                                <span class="check">{{ $valueSlb }}</span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach

                                @foreach ($dataSize as $key => $value)
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input size" name="size[{{ $key }}]"
                                                        type="checkbox" value="{{ $value }}">
                                                    <span class="form-check-sign">
                                                        <span class="check">{{ $value }}</span>
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- End Color --}}

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description (*)</label>
                                        <textarea rows="8" style="max-height: 200px; height: fit-content" cols="120" id="description"
                                            name="description" class="form-control" placeholder="Description">{{ $description }}</textarea>
                                        <small class="text-danger" id="error-description">
                                            @if ($errors->has('description'))
                                                {!! $errors->first('description') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-user">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture1">Picture 1 (*)</label>
                                        <input type="file" id="picture1" name="picture1" class="form-control">
                                        <img id="display_image1" style="background-color: #FFC3C0"
                                            src="{{ old('picture1', $URLPicture1) }}" alt="">

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture2">Picture 2</label>
                                        <input type="file" id="picture2" name="picture2" class="form-control">
                                        <img id="display_image2" style="background-color: #FFC3C0"
                                            src="{{ old('picture2', $URLPicture2) }}" alt="">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture3">Picture 3</label>
                                        <input type="file" id="picture3" name="picture3" class="form-control">
                                        <img id="display_image3" style="background-color: #FFC3C0"
                                            src="{{ old('picture3', $URLPicture3) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture4">Picture 4</label>
                                        <input type="file" id="picture4" name="picture4" class="form-control">
                                        <img id="display_image4" style="background-color: #FFC3C0"
                                            src="{{ old('picture4', $URLPicture4) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture5">Picture 5</label>
                                        <input type="file" id="picture5" name="picture5" class="form-control">
                                        <img id="display_image5" style="background-color: #FFC3C0"
                                            src="{{ old('picture5', $URLPicture5) }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="picture6">Picture 6</label>
                                        <input type="file" id="picture6" name="picture6" class="form-control">
                                        <img id="display_image6" style="background-color: #FFC3C0"
                                            src="{{ old('picture6', $URLPicture6) }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer row text-center justify-content-center">
                            <input type="hidden" name="id" value="{{ $id }}">
                            <input type="hidden" name="hidden_picture1" value="{{ $picture1 }}">
                            <input type="hidden" name="hidden_picture2" value="{{ $picture2 }}">
                            <input type="hidden" name="hidden_picture3" value="{{ $picture3 }}">
                            <input type="hidden" name="hidden_picture4" value="{{ $picture4 }}">
                            <input type="hidden" name="hidden_picture5" value="{{ $picture5 }}">
                            <input type="hidden" name="hidden_picture6" value="{{ $picture6 }}">
                            <input type="submit" name="save" class="btn btn-fill btn-primary col-md-5" value="Save">
                            <input type="submit" name="save_close" class="btn btn-fill btn-primary col-md-5" value="Save And Close">
                            <input type="submit" name="save_new" class="btn btn-fill btn-primary col-md-5" value="Save And New">
                            <input type="submit" name="save_sku" class="btn btn-fill btn-primary col-md-5" value="Save And Add SKU">
                            <a href="{{ route('detail/form') }}" class="btn btn-fill btn-primary col-md-5">Add Colors</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        @php
            for ($i = 1; $i <= 6; $i++) {
                echo 'const   picture' .
                    $i .
                    '     = document.querySelector("#picture' .
                    $i .
                    '");
                    var     upload_image' .
                    $i .
                    '    = "";

                    picture' .
                    $i .
                    '.addEventListener("change", function () {
                        const reader = new FileReader();
                        reader.addEventListener("load", () => {
                            upload_image' .
                    $i .
                    ' = reader.result;
                            document.querySelector("#display_image' .
                    $i .
                    '").src = `${upload_image' .
                    $i .
                    '}`;
                        });
                        reader.readAsDataURL(this.files[0]);
                    });
                ';
            }
        @endphp

        $(document).ready(function() {
            const form = document.getElementById('main-form');
            let name = document.forms["main-form"]["name"];
            let price = document.forms["main-form"]["price"];
            let status = document.forms["main-form"]["status"];
            let type = document.forms["main-form"]["type"];
            let category = document.forms["main-form"]["category_id"];
            let collection = document.forms["main-form"]["collection_id"];
            let occasion = document.forms["main-form"]["occasion_id"];
            let bust = document.forms["main-form"]["bust"];
            let fabric = document.forms["main-form"]["fabric"];
            let composition = document.forms["main-form"]["composition"];
            let care = document.forms["main-form"]["care"];
            let style = document.forms["main-form"]["style"];
            let color = document.forms["main-form"]["color"];
            let size = document.forms["main-form"]["size"];
            let description = document.forms["main-form"]["description"];

            var errorName = document.getElementById("error-name");
            var errorPrice = document.getElementById("error-price");
            var errorStatus = document.getElementById("error-status");
            var errorType = document.getElementById("error-type");
            var errorCategory = document.getElementById("error-category");
            var errorCollection = document.getElementById("error-collection");
            var errorOccasion = document.getElementById("error-occasion");
            var errorBust = document.getElementById("error-bust");
            var errorFabric = document.getElementById("error-fabric");
            var errorComposition = document.getElementById("error-composition");
            var errorCare = document.getElementById("error-care");
            var errorStyle = document.getElementById("error-style");
            var errorColor = document.getElementById("error-color");
            var errorSize = document.getElementById("error-size");
            var errorDescription = document.getElementById("error-description");
            form.addEventListener('submit', function handler(e) {
                let messages = [];

                // Name
                errorName.textContent = '';
                if (validateNull(name, errorName, 'Name') == false) {
                    messages.push('Error');
                } else if (validateExistAjax(name, errorName, 'Name', 'name') == false) {
                    messages.push('Error');
                }

                // Price
                errorPrice.textContent = '';
                if (validateNull(price, errorPrice, 'Price') == false) {
                    messages.push('Error');
                }

                // Status
                errorStatus.textContent = '';
                if (status.selectedIndex == 0) {
                    errorStatus.textContent = 'Status is Required';
                }

                // Type
                errorType.textContent = '';
                if (type.selectedIndex == 0) {
                    errorType.textContent = 'Type is Required';
                }

                // Category
                errorCategory.textContent = '';
                if (category.selectedIndex == 0) {
                    errorCategory.textContent = 'Category is Required';
                }

                // Occasion
                errorOccasion.textContent = '';
                if (occasion.selectedIndex == 0) {
                    errorOccasion.textContent = 'Occasion is Required';
                }

                // Collection
                errorCollection.textContent = '';
                if (collection.selectedIndex == 0) {
                    errorCollection.textContent = 'Collection is Required';
                }

                // Fabric
                errorFabric.textContent = '';
                if (validateNull(fabric, errorFabric, 'Fabric') == false) {
                    messages.push('Error');
                }

                // Composition
                errorComposition.textContent = '';
                if (validateNull(composition, errorComposition, 'Composition') == false) {
                    messages.push('Error');
                }

                // Care
                errorCare.textContent = '';
                if (validateNull(care, errorCare, 'Care') == false) {
                    messages.push('Error');
                }

                // Style
                errorStyle.textContent = '';
                if (validateNull(style, errorStyle, 'Style') == false) {
                    messages.push('Error');
                } else if (validateExistAjax(style, errorStyle, 'Style', 'style') == false) {
                    messages.push('Error');
                }

                // Color
                errorColor.textContent = '';
                const checkboxesColor = document.querySelectorAll('.color');
                let checkedColor = false;
                checkboxesColor.forEach(checkboxColor => {
                    if (checkboxColor.checked) {
                        errorColor.textContent = '';
                        checkedColor = true;
                    }
                });

                if (!checkedColor) {
                    messages.push('Error');
                    errorColor.textContent = 'Color is required';

                }

                // Size
                errorSize.textContent = '';
                const checkboxesSize = document.querySelectorAll('.size');
                let checkedSize = false;
                checkboxesSize.forEach(checkboxSize => {
                    if (checkboxSize.checked) {
                        errorSize.textContent = '';
                        checkedSize = true;
                    }
                });

                if (!checkedSize) {
                    messages.push('Error');
                    errorSize.textContent = 'Size is required';

                }

                // Description
                errorDescription.textContent = '';
                if (validateNull(description, errorDescription, 'Description') == false) {
                    messages.push('Error');
                }

                if (messages.length > 0) {
                    e.preventDefault();
                } else {
                    form.removeEventListener('submit', handler);
                }
            });

            $('#name').keyup(function() {
                errorName.textContent = '';
                if (validateNull(name, errorName, 'Name') == true) {
                    validateExistAjax(name, errorName, 'Name', 'name')
                }
            });

            $('#price').keyup(function() {
                errorPrice.textContent = '';
                validateNull(price, errorPrice, 'Price')
            });


            $('#status').change(function() {
                errorStatus.textContent = '';
                if (status.selectedIndex == 0) {
                    errorStatus.textContent = 'Status is Required';
                }
            });

            $('#type').change(function() {
                errorType.textContent = '';
                if (type.selectedIndex == 0) {
                    errorType.textContent = 'Type is Required';
                }
            });

            $('#collection_id').change(function() {
                errorCollection.textContent = '';
                if (collection.selectedIndex == 0) {
                    errorCollection.textContent = 'Collection is Required';
                }
            });

            $('#category_id').change(function() {
                errorCategory.textContent = '';
                if (category.selectedIndex == 0) {
                    errorCategory.textContent = 'Category is Required';
                }
            });

            $('#collection_id').change(function() {
                errorCollection.textContent = '';
                if (collection.selectedIndex == 0) {
                    errorCollection.textContent = 'Collection is Required';
                }
            });

            $('#fabric').keyup(function() {
                errorFabric.textContent = '';
                validateNull(fabric, errorFabric, 'Fabric')
            });

            $('#compostion').keyup(function() {
                errorCompostion.textContent = '';
                validateNull(compostion, errorCompostion, 'Compostion')
            });

            $('#care').keyup(function() {
                errorCare.textContent = '';
                validateNull(care, errorCare, 'Care')
            });

            $('#style').keyup(function() {
                errorName.textContent = '';
                if (validateNull(style, errorStyle, 'Style') == true) {
                    validateExistAjax(style, errorStyle, 'Style', 'style')
                }
            });

            $('#description').keyup(function() {
                errorDescription.textContent = '';
                validateNull(description, errorDescription, 'Description')
            });

            function validateNull(field, error, name) {
                if (field.value == "") {
                    error.textContent = name + ' is required';
                    return false;
                } else return true;
            }

            function validateExistAjax(field, error, name, type) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('product/ajax-form') }}?" + type + "=" + field.value,
                    success: function(response) {
                        if (response.id != null) {
                            errorName.textContent = 'This ' + name + ' is Exist';
                            return false;
                        } else return true
                    }
                });
            }

            function validateCheckbox(field, error, name) {

            }
        });

        function inputChange(){
            const value = $( "#price" ).val();
            $( "input#price" ).val( Intl.NumberFormat().format(Number(value.replaceAll(',', ''))) )
        }
    </script>
@endsection
