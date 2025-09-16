<?php
    use App\Helpers\Template as Template;
?>
@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"> Outfit List</h4>
                        <a style="padding: 10px 18px" href="{{ route($controllerName) . '/form' }}" class="btn btn-sm btn-simple">Create New Outfit
                        </a>
                        @if(session('artiz_notify'))
                            <div class="alert alert-success">
                                <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                  </button>
                                {{ session('artiz_notify') }}
                            </div>
                        @endsession
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Item 1</th>
                                    <th>Item 2</th>
                                    <th>Item 3</th>
                                    <th>Item 4</th>
                                    <th>Item 5</th>
                                    <th>Item 6</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                    
                                        @foreach($items as $key => $value)
                                            @php
                                                $picture1 = $picture2 = $picture3 = $picture4 = $picture5 = $picture6 = '';
                                                
                                                $buttonAction   = Template::showItemButton($controllerName, $value['id']);
                                            @endphp
                                            
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{!! $buttonAction !!}</td>
                                                @foreach($picture as $keyA => $valueA)
                                                    @if($keyA == $value['id'])
                                                        @foreach($valueA as $keyB => $valueB)
                                                            @foreach($valueB as $keyC => $valueC)
                                                            <td>
                                                                <img style="width: 180px" src="{{ asset('public/images/product/' . $valueC['name'] . '/' . $valueC['picture1']) }}" alt="">
                                                            </td>
                                                            @endforeach
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('admin.template.list_empty', ['colspan' => 8])
                                    @endif
                                </tbody>
                            </table>
                            {!! $items->appends(request()->input())->links('admin.template.pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
