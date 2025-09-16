<?php
use Illuminate\Support\Number;

$name = '';
$id = $item1 = $item2 = $item3 = $item4 = $item5 = $item6 = '';


if ($item != null) {
    $id          = $item['id'];
    $item1       = $item['item1'];
    $item2       = $item['item2'];
    $item3       = $item['item3'];
    $item4       = $item['item4'];
    $item5       = $item['item5'];
    $item6       = $item['item6'];
}
$picture1   = $picture2 = $picture3 = $picture4 = $picture5 = $picture6 = '';
$name1      = $name2    = $name3    = $name4    = $name5    = $name6    = '';
if($picture != null){
    foreach($picture as $key => $value){
        foreach($value as $keyPicture => $valuePicture){
            if($valuePicture['id'] == $item1){
                $picture1 = asset('public/images/product/' . $valuePicture['name'] . '/' . $valuePicture['picture1']);
                $name1  = $valuePicture['name'];
            }
               
            if($valuePicture['id'] == $item2){
                $picture2 = asset('public/images/product/' . $valuePicture['name'] . '/' . $valuePicture['picture1']);
                $name2  = $valuePicture['name'];
            }
                
            if($valuePicture['id'] == $item3){
                $picture3 = asset('public/images/product/' . $valuePicture['name'] . '/' . $valuePicture['picture1']);
                $name3  = $valuePicture['name'];
            }
                
            if($valuePicture['id'] == $item4){
                $picture4 = asset('public/images/product/' . $valuePicture['name'] . '/' . $valuePicture['picture1']);
                $name4  = $valuePicture['name'];
            }
                
            if($valuePicture['id'] == $item5){
                $picture5 = asset('public/images/product/' . $valuePicture['name'] . '/' . $valuePicture['picture1']);
                $name5  = $valuePicture['name'];
            }
                
            if($valuePicture['id'] == $item6){
                $picture6 = asset('public/images/product/' . $valuePicture['name'] . '/' . $valuePicture['picture1']);
                $name6  = $valuePicture['name'];
            }
                
        }
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
                            <h4 class="card-title"> Create New Outfit</h4>
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
                            <div class="row justify-content-center">
                                <div class="col-md-2 row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item1">Item 1</label>
                                            <input list="data1" id="item1" name="name1" class="form-control" placeholder="Search Item 1" value="{{ $name1 }}">
                                            <datalist id="data1">
                                                @foreach($nameDataList as $key => $value)
                                                    <option value="{{ $value['name'] }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="result1">
                                        <img src="{!! $picture1 !!}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-2 row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item2">Item 2</label>
                                            <input list="data2" id="item2" name="name2" class="form-control" placeholder="Search Item 2" value="{{ $name2 }}">
                                            <datalist id="data2">
                                                @foreach($nameDataList as $key => $value)
                                                    <option value="{{ $value['name'] }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="result2">
                                        <img src="{!! $picture2 !!}" alt="">
                                    </div>
                                </div>
                               
                                <div class="col-md-2 row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item3">Item 3</label>
                                            <input list="data3" id="item3" name="name3" class="form-control" placeholder="Search Item 3" value="{{ $name3 }}">
                                            <datalist id="data3">
                                                @foreach($nameDataList as $key => $value)
                                                    <option value="{{ $value['name'] }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="result3">
                                        <img src="{!! $picture3 !!}" alt="">
                                    </div>
                                </div>
                                
                                <div class="col-md-2 row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item4">Item 4</label>
                                            <input list="data4" id="item4" name="name4" class="form-control" placeholder="Search Item 4" value="{{ $name4 }}">
                                            <datalist id="data4">
                                                @foreach($nameDataList as $key => $value)
                                                    <option value="{{ $value['name'] }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="result4">
                                        <img src="{!! $picture4 !!}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-2 row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item5">Item 5</label>
                                            <input list="data5" id="item5" name="name5" class="form-control" placeholder="Search Item 5" value="{{ $name5 }}">
                                            <datalist id="data5">
                                                @foreach($nameDataList as $key => $value)
                                                    <option value="{{ $value['name'] }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="result5">
                                        <img src="{!! $picture5 !!}" alt="">
                                    </div>
                                </div>
                                
                                <div class="col-md-2 row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="item6">Item 6</label>
                                            <input list="data6" id="item6" name="name6" class="form-control" placeholder="Search Item 6" value="{{ $name6 }}">
                                            <datalist id="data6">
                                                @foreach($nameDataList as $key => $value)
                                                    <option value="{{ $value['name'] }}">
                                                @endforeach
                                            </datalist>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="result6">
                                        <img src="{!! $picture6 !!}" alt="">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $('#item1').change(function(){
                var text = $(this).val();
                var url = "{{asset('public/images/product')}}"
                
                $.ajax({
                    type: "GET",
                    url: "{{route('outfit/ajax')}}?key=" + text,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){
                            _html += '<img src="'+url+'/'+pro.name+'/'+pro.picture1+'" alt="">';
                            _html += '<input type="hidden" name="item1" value="'+pro.id+'">';
                            
                        }
                        $('#result1').html(_html);
                        
                    }
                });

                
            });
        })
        $(document).ready(function(){
            $('#item2').change(function(){
                var text = $(this).val();
                var url = "{{asset('public/images/product')}}"
                
                $.ajax({
                    type: "GET",
                    url: "{{route('outfit/ajax')}}?key=" + text,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){
                            _html += '<img src="'+url+'/'+pro.name+'/'+pro.picture1+'" alt="">';
                            _html += '<input type="hidden" name="item2" value="'+pro.id+'">';
                            
                        }
                        $('#result2').html(_html);
                        
                    }
                });

                
            });
        })
        $(document).ready(function(){
            $('#item3').change(function(){
                var text = $(this).val();
                var url = "{{asset('public/images/product')}}"
                
                $.ajax({
                    type: "GET",
                    url: "{{route('outfit/ajax')}}?key=" + text,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){
                            _html += '<img src="'+url+'/'+pro.name+'/'+pro.picture1+'" alt="">';
                            _html += '<input type="hidden" name="item3" value="'+pro.id+'">';
                            
                        }
                        $('#result3').html(_html);
                        
                    }
                });

                
            });
        })
        $(document).ready(function(){
            $('#item4').change(function(){
                var text = $(this).val();
                var url = "{{asset('public/images/product')}}"
                
                $.ajax({
                    type: "GET",
                    url: "{{route('outfit/ajax')}}?key=" + text,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){
                            _html += '<img src="'+url+'/'+pro.name+'/'+pro.picture1+'" alt="">';
                            _html += '<input type="hidden" name="item4" value="'+pro.id+'">';
                            
                        }
                        $('#result4').html(_html);
                        
                    }
                });

                
            });
        })
        $(document).ready(function(){
            $('#item5').change(function(){
                var text = $(this).val();
                var url = "{{asset('public/images/product')}}"
                
                $.ajax({
                    type: "GET",
                    url: "{{route('outfit/ajax')}}?key=" + text,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){
                            _html += '<img src="'+url+'/'+pro.name+'/'+pro.picture1+'" alt="">';
                            _html += '<input type="hidden" name="item5" value="'+pro.id+'">';
                            
                        }
                        $('#result5').html(_html);
                        
                    }
                });

                
            });
        })
        $(document).ready(function(){
            $('#item6').change(function(){
                var text = $(this).val();
                var url = "{{asset('public/images/product')}}"
                
                $.ajax({
                    type: "GET",
                    url: "{{route('outfit/ajax')}}?key=" + text,
                    success: function(response){
                        var _html = '';
                        for(var pro of response){
                            _html += '<img src="'+url+'/'+pro.name+'/'+pro.picture1+'" alt="">';
                            _html += '<input type="hidden" name="item6" value="'+pro.id+'">';
                            
                        }
                        $('#result6').html(_html);
                        
                    }
                });

                
            });
        })
    </script>
@endsection
