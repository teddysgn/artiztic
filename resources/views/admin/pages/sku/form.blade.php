<?php
use Illuminate\Support\Number;

$name = '';
$id = $style = $color = $size = $quantity = $style = '';

if ($item != null) {
    $id          = $item['id'];
    $sku         = $item['sku'];
    $color       = $item['color'];
    $size        = $item['size'];
    $quantity    = $item['quantity'];
    $style       = $item['style'];
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
                            <h4 class="card-title"> Create New SKU</h4>
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
                                {{-- Row 0 --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form-0-style">Style Product</label>
                                        <select class="form-control" name="form[0][style]" id="form-0-style" onchange="checkSKU(0)">
                                            <option value="default">Select Style</option>
                                            @foreach ($styleSlb as $key => $value)
                                                @if ($style == $key)
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
                                        <small class="text-danger" id="error-0"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form-0-color">Color</label>
                                        <select class="form-control" name="form[0][color]" id="form-0-color" onchange="checkSKU(0)">
                                            <option value="default">Select Color</option>
                                            @foreach ($colorSlb as $key => $value)
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
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form-0-size">Size</label>
                                        <select class="form-control" name="form[0][size]" id="form-0-size" onchange="checkSKU(0)">
                                            <option value="default">Select Size</option>
                                            @foreach ($sizeSlb as $key => $value)
                                                @if ($size == $key)
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
                                        <label for="form-0-quantity">Quantity</label>
                                        <input type="text" id="form-0-quantity" name="form[0][quantity]" class="form-control" placeholder="Quantity"
                                            value="{{ old('quantity', $quantity) }}">
                                    </div>
                                </div>
                                {{-- End Row 0 --}}

                                {{-- Row 1 --}}
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form-1-style">Style Product</label>
                                        <select class="form-control" name="form[1][style]" id="form-1-style" onchange="checkSKU(1)">
                                            <option value="default">Select Style</option>
                                            @foreach ($styleSlb as $key => $value)
                                                @if ($style == $key)
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
                                        <small class="text-danger" id="error-1"></small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form-1-color">Color</label>
                                        <select class="form-control" name="form[1][color]" id="form-1-color"  onchange="checkSKU(1)">
                                            <option value="default">Select Color</option>
                                            @foreach ($colorSlb as $key => $value)
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
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="form-1-size">Size</label>
                                        <select class="form-control" name="form[1][size]" id="form-1-size"  onchange="checkSKU(1)">
                                            <option value="default">Select Size</option>
                                            @foreach ($sizeSlb as $key => $value)
                                                @if ($size == $key)
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
                                        <label for="form-1-quantity">Quantity</label>
                                        <input type="text" name="form[1][quantity]" id="form-1-quantity" class="form-control" placeholder="Quantity"
                                            value="{{ old('quantity', $quantity) }}">
                                    </div>
                                </div>
                                {{-- End Row 1 --}}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function checkSKU(id){
            var style = $('#form-'+id+'-style').find(":selected").val();
            var color = $('#form-'+id+'-color').find(":selected").val();
            var size = $('#form-'+id+'-size').find(":selected").val();
            var error = document.getElementById("error-"+id);

            error.textContent = '';

            if(size != null && style != null && color != null){
                $.ajax({
                method: "GET",
                url: "{{ route('sku/check') }}?size=" + size + '&style=' + style + '&color=' + color,
                dataType: 'json',
                success: function(response) {
                    if(response.items == null){
                        error.textContent         = 'Color & Size are not match in this product';
                    }
                }
            });
            }

            
        }
    </script>
@endsection
