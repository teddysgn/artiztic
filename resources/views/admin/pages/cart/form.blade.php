<?php
use Illuminate\Support\Number;
use App\Helpers\Template as Template;


$statusValue    = [
        'default'   => 'Select Status',
        'pending'   => 'Pending',
        'approved'  => 'Approved',
        'packaging' => 'Packaging',
        'shipping'  => 'Shipping',
        'delivered' => 'Delivered',
    ];
?>
@extends('admin.main')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ">
                        <div class="card-header">
                            <h4 class="card-title"> Cart Details</h4>
                            <a style="padding: 10px 18px" href="{{ route($controllerName) }}" class="btn btn-sm btn-simple">Back to List</a>
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
                                        <th>Picture</th>
                                        <th>Name</th>
                                        <th>Style</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                        <th>Quantity</th>
                                    </thead>
                                    <tbody>
                                        @if(count($items) > 0)
                                            @foreach($items as $key => $value)
                                                @php
                                                    $id             = $value['identify'];
                                                    $quantity       = $value['quantity'];
                                                    $name           = $value['product_name'];
                                                    $style          = $value['product_style'];
                                                    $color          = $value['color'];
                                                    $size           = $value['size'];
                                                    $picture        = Template::showItemThumb('product', $value['product_picture1'], $value['product_name'], 80);
                                                @endphp
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{!! $picture !!}</td>
                                                    <td>{!! $name !!}</td>
                                                    <td>{!! $style !!}</td>
                                                    <td>{!! $color !!} </td>
                                                    <td>{{ $size }}</td>
                                                    <td>{{ $quantity }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if($refundDetails != null)
                    <div class="col-lg-12">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title"> Exchange Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table tablesorter " id="">
                                        <thead class=" text-primary">
                                            <th class="text-center">#</th>
                                            <th class="text-center">Picture</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Style</th>
                                            <th class="text-center">Color</th>
                                            <th class="text-center">Size</th>
                                            <th class="text-center">Quantity</th>
                                        </thead>
                                        <tbody>
                                            
                                            @foreach($refundDetails as $key => $value)
                                                @php
                                                    $id             = $value['id'];
                                                    $quantity       = $value['quantity'];
                                                    $newName        = $value['product_name'];
                                                    $newStyle       = $value['product_style'];
                                                    $newColor       = $value['to_color'];
                                                    $newSize        = $value['to_size'];
                                                    $newPicture     = Template::showItemThumb('product', $value['product_picture1'], $value['product_name'], 80);
                                                @endphp
                                                @foreach($items as $keyCart => $valueCart)
                                                    @if($valueCart['product_id'] == $value['product_id'])
                                                        @php
                                                            $oldName = $valueCart['product_name'];
                                                            $oldStyle = $valueCart['product_style'];
                                                            $oldColor = $value['color'];
                                                            $oldSize = $value['size'];
                                                            $oldPicture = $valueCart['product_name'];
                                                            $oldPicture        = Template::showItemThumb('product', $valueCart['product_picture1'], $valueCart['product_name'], 80);
                                                        @endphp
                                                    @endif
                                                @endforeach
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td class="text-center">
                                                        {!! $oldPicture !!}
                                                        </br><i class="tim-icons icon-minimal-down"></i></br>
                                                        {!! $newPicture !!}
                                                    </td>
                                                    <td class="text-center">
                                                        {!! $oldName !!}
                                                        </br><i class="tim-icons icon-minimal-down"></i></br>
                                                        <span class="text-primary">{!! $newName !!}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        {!! $oldStyle !!}
                                                        </br><i class="tim-icons icon-minimal-down"></i></br>
                                                        <span class="text-primary">{!! $newStyle !!}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        {!! $oldColor !!}
                                                        </br><i class="tim-icons icon-minimal-down"></i></br>
                                                        <span class="text-primary">{!! $newColor !!}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        {!! $oldSize !!}
                                                        </br><i class="tim-icons icon-minimal-down"></i></br>
                                                        <span class="text-primary">{!! $newSize !!}</span>
                                                    </td>
                                                    <td class="text-center text-primary">{{ $quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Exchange Date</label>
                                            <p class="form-control">
                                                {{ date('H:i:s d/m/Y', strtotime($refund['created'])); }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Exchange By</label>
                                            <p class="form-control">
                                                {{ $refund['created_by'] }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Exchange Reason</label>
                                            <p class="form-control">
                                                {{ $refund['reason'] }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            {!! Template::showItemSelectExchangeCart($controllerName, $refund['cart_id'], $refund['status'], 'refund'); !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="row">
                <div class="col-lg-12 col-md-6"><div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Shipping Details</h4>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer Name</label>
                                    <p class="form-control">
                                        {{ $cart['user_name'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping Name</label>
                                    <p class="form-control">
                                        {{ $cart['fullname'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping Email</label>
                                    <p class="form-control">
                                        {{ $cart['email'] }}
                                    </p>
                                </div>
                            </div><div class="col-md-6">
                                <div class="form-group">
                                    <label>Shipping Phone</label>
                                    <p class="form-control">
                                        {{ $cart['phone'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Shipping Address</label>
                                    <p class="form-control">
                                        {{ $cart['address'] }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    {!! Template::showItemSelectStatusCart($controllerName, $cart['cart_id'], $cart['status'], $cart['cancel'], 'status') !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="cancel">Cancel</label>
                                    {!! Template::showItemSelectCancelCart($controllerName, $cart['cart_id'], $cart['cancel'], $cart['cancel_by'], $cart['status'], 'cancel') !!}
                                </div>
                            </div>
                            @if($cart['cancel'] != 'default')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cancel Date</label>
                                        <p class="form-control">
                                            {{ $cart['cancel_date'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Cancel By</label>
                                        <p class="form-control">
                                            {{ $cart['cancel_by'] }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Reason</label>
                                        <p class="form-control">
                                            {{ $cart['reason_cancel'] }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div></div>
                <div class="col-lg-12 col-md-6 row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Billing Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between my-3">
                                    <span>Subtotal</span>
                                    <span> {{ $cart['subtotal'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span>Discount</span>
                                    <span> -{{ $cart['discount'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span>Member</span>
                                    <span> -{{ $cart['member'] }}</span>
                                </div>
                                <div class="d-flex justify-content-between my-3">
                                    <span>Coupon</span>
                                    <span> -{{ $cart['coupon_value'] }}</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between my-3">
                                    <span>Total</span>
                                    <span> {{ $cart['total'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($cart['cancel'] == 'default')
                        <div class="col-lg-12">
                            <form id="main-form" method="POST" action="{{ route($controllerName) . '/save' }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                @csrf
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Cancel Order By Artiz</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="reason">Reason to Cancel</label>
                                                    <textarea type="number" id="reason" name="reason_cancel" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <input type="hidden" name="id" value="{{ $cart['cart_id'] }}">
                                        <button type="submit" class="btn btn-fill btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
