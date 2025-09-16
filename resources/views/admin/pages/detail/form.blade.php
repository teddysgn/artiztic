<?php
use Illuminate\Support\Number;

$id = $style = $color =  '';
$color = [];
$dataColor = $colorSlb;
$dataStyle = $styleSlb;
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
    $style = $item['style'];
    $color = $item['color'];
    $name  = $item['color_name'];
    $picture1 = $item['picture1'];
    $picture2 = $item['picture2'];
    $picture3 = $item['picture3'];
    $picture4 = $item['picture4'];
    $picture5 = $item['picture5'];
    $picture6 = $item['picture6'];

    if ($item['picture1'] != null) {
        $URLPicture1 = asset('public/images/detail/' . $style . '/' . $name . '/' . $item['picture1']);
    }
    if ($item['picture2'] != null) {
        $URLPicture2 = asset('public/images/detail/' . $style . '/' . $name . '/' . $item['picture2']);
    }
    if ($item['picture3'] != null) {
        $URLPicture3 = asset('public/images/detail/' . $style . '/' . $name . '/' . $item['picture3']);
    }
    if ($item['picture4'] != null) {
        $URLPicture4 = asset('public/images/detail/' . $style . '/' . $name . '/' . $item['picture4']);
    }
    if ($item['picture5'] != null) {
        $URLPicture5 = asset('public/images/detail/' . $style . '/' . $name . '/' . $item['picture5']);
    }
    if ($item['picture6'] != null) {
        $URLPicture6 = asset('public/images/detail/' . $style . '/' . $name . '/' . $item['picture6']);
    }

 
}
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <form id="main-form" name="main-form" id="main-form" method="POST" action="{{ route($controllerName) . '/save' }}"
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
                                        <label for="style">Style</label>
                                        <select class="form-control style" name="style" id="style">
                                            <option value="0">
                                                Select Style
                                            </option>
                                            @foreach ($dataStyle as $key => $value)
                                                @if ($style == $value)
                                                    <option value="{{ $value }}" selected>
                                                        {{ $value }}
                                                    </option>
                                                @else
                                                    <option value="{{ $value }}">
                                                        {{ $value }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <small class="text-danger" id="error-style">
                                            @if ($errors->has('style'))
                                                {!! $errors->first('style') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="color">Color</label>
                                        @if($id == '')
                                            <select class="form-control color" name="color" id="color" disabled>
                                        @else 
                                            <select class="form-control color" name="color" id="color">
                                        @endif
                                            <option value="0">
                                                Select Color
                                            </option>
                                            @foreach ($dataColor as $key => $value)
                                                @if ($color == $key)
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
                                        <small class="text-danger" id="error-color">
                                            @if ($errors->has('color'))
                                                {!! $errors->first('color') !!}
                                            @endif
                                        </small>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer row text-center">
                                <input type="hidden" name="id" value="{{ $id }}">
                                <input type="hidden" name="hidden_picture1" value="{{ $picture1 }}">
                                <input type="hidden" name="hidden_picture2" value="{{ $picture2 }}">
                                <input type="hidden" name="hidden_picture3" value="{{ $picture3 }}">
                                <input type="hidden" name="hidden_picture4" value="{{ $picture4 }}">
                                <input type="hidden" name="hidden_picture5" value="{{ $picture5 }}">
                                <input type="hidden" name="hidden_picture6" value="{{ $picture6 }}">
                                <div class="col-md-12">
                                    <input type="submit" name="save" class="btn btn-fill btn-primary" value="Save">
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="save_close" class="btn btn-fill btn-primary"
                                        value="Save And Close">
                                </div>
                                <div class="col-md-12">
                                    <input type="submit" name="save_new" class="btn btn-fill btn-primary"
                                        value="Save And New">
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
                                        <label for="picture1">Picture 1</label>
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
                    </div>
                </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function(){
            const form  = document.getElementById('main-form');
            var errorColor = document.getElementById("error-color");
            var errorStyle = document.getElementById("error-style");
            form.addEventListener('submit', function handler(e) {
                let messages = [];

                errorStyle.textContent = '';
                if($('.style').val() == 0){
                    messages.push('Error');
                    errorStyle.textContent = 'Style is required';
                }

                errorColor.textContent = '';
                if($('.color').val() == 0){
                    messages.push('Error');
                    errorColor.textContent = 'Color is required';
                }

                $('.color').change(function(){
                    errorColor.textContent = '';
                    let style = $('.style').val();
                    let color = $('.color').val();
                    $.ajax({
                        type: "GET",
                        url: "{{route('detail/ajax')}}?color=" + color + '&style=' + style,
                        success: function(response){
                            if(response.id == null){
                                messages.push('Error');
                                errorColor.textContent = 'This Color is not Exist in Product';
                            }
                            
                        }
                    });
                });

                $('.style').change(function(){
                    errorColor.textContent = '';
                    let style = $('.style').val();
                    let color = $('.color').val();
                    $.ajax({
                        type: "GET",
                        url: "{{route('detail/ajax')}}?color=" + color + '&style=' + style,
                        success: function(response){
                            if(response.id == null){
                                messages.push('Error');
                                errorColor.textContent = 'This Color is not Exist in Product';
                            }
                            
                        }
                    });
                });

                if (messages.length > 0) {
                    e.preventDefault();
                } else {
                    form.removeEventListener('submit', handler);
                }
            });
            
            $('.style').change(function(){
                if($('.style').val() == 0){
                    $('.color').attr('disabled', 'disabled');
                } else {
                    $('.color').removeAttr('disabled');
                }
                
                errorColor.textContent = '';
                    let style = $('.style').val();
                    let color = $('.color').val();
                    $.ajax({
                        type: "GET",
                        url: "{{route('detail/ajax')}}?color=" + color + '&style=' + style,
                        success: function(response){
                            if(response.id == null){
                                errorColor.textContent = 'This Color is not Exist in Product';
                            }
                            
                        }
                    });
            });
            
            $('.color').change(function(){
                errorColor.textContent = '';
                let style = $('.style').val();
                let color = $('.color').val();
                $.ajax({
                    type: "GET",
                    url: "{{route('detail/ajax')}}?color=" + color + '&style=' + style,
                    success: function(response){
                        if(response.id == null){
                            errorColor.textContent = 'This Color is not Exist in Product';
                        }
                        
                    }
                });
            });


        });
        @php
        for($i = 1; $i <= 6; $i++){
            echo  'const   picture'.$i.'     = document.querySelector("#picture'.$i.'");
                    var     upload_image'.$i.'    = "";

                    picture'.$i.'.addEventListener("change", function () {
                        const reader = new FileReader();
                        reader.addEventListener("load", () => {
                            upload_image'.$i.' = reader.result;
                            document.querySelector("#display_image'.$i.'").src = `${upload_image'.$i.'}`;
                        });
                        reader.readAsDataURL(this.files[0]);
                    });
                ';
        }
        @endphp
    </script>
@endsection
