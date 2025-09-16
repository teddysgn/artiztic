<?php
    use App\Helpers\Template as Template;
    $areaSearch         = Template::showAreaSearch($controllerName, $params['search']);
    $filterStatus       = Template::showStatusCart($controllerName, $countByStatus, $params['filter']['status'], $params['search'], $params);
    $filterMethod       = Template::showMethodCart($controllerName, $countByMethod, $params['filter']['method'], $params['search'], $params);
    $filterCancel       = Template::showCancelCart($controllerName, $countByCancel, $params['filter']['cancel'], $params['search'], $params);
    $filterOrder        = Template::showOrderCart($controllerName, $params, 'date');
    $filterSort         = Template::showSortCart($controllerName, $params, 'date');
    $statusValue    = [
        'default'   => 'Select Status',
        'pending'   => 'Pending',
        'approved'  => 'Approved',
        'packaging' => 'Packaging',
        'shipping'  => 'Shipping',
        'delivered' => 'Delivered',
    ];

    $cancelValue    = [
        'default'   => 'Not Yet',
        'pending'   => 'Pending',
        'approved'  => 'Approve',
        'deny'      => 'Deny',
    ];
?>
@extends('admin.main')
@section('content')
 <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <div class="content">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h4 class="card-title"> Cart List</h4>
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
                            <form>
                                <div class="row">
                                    {!! $filterOrder !!}
                                    {!! $filterSort !!}
                                </div>
                            </form>
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>ID</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Cancel</th>
                                    <th>Exchange</th>
                                    <th>Method</th>
                                    <th>Invoice</th>
                                    <th>Coupon</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                </thead>
                                <tbody>
                                    @if(count($items) > 0)
                                        @foreach($items as $key => $value)
                                            @php
                                                $exchange = '';
                                                foreach($refund as $keyRefund => $valueRefund){
                                                    if($value['identify'] == $valueRefund['cart_id']){
                                                        $exchange = Template::showItemSelectExchangeCart($controllerName, $valueRefund['cart_id'], $valueRefund['status'], 'refund', 120);
                                                    }
                                                }
                                                $id                 = $value['identify'];
                                                $total              = $value['total'];
                                                $coupon             = $value['coupon_value'] == 0 ? 0 : $value['coupon_value'];
                                                $status             = Template::showItemSelectStatusCart($controllerName, $value['identify'], $value['status'], $value['cancel'], 'status', 120);
                                                $cancel             = Template::showItemSelectCancelCart($controllerName, $value['identify'], $value['cancel'], $value['cancel_by'], $value['status'], 'cancel', 120);
                                                $method             = $value['payment_method'];
                                                $customer           = $value['customer'];
                                                $created            = date('H:i:s d/m/Y', strtotime($value['created']));
                                                $picture = '';
                                                if($value['invoice'] != null)
                                                    $picture            = '<img width="20" class="btn btn-sm btn-primary" data-fancybox="" src="'. asset('public/images/cart/' . $id . '/' . $value['invoice']) .'" alt="'.$id.'">';
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{ route($controllerName . '/form', ['id' => $id]) }}">{!! $id !!}</a></td>
                                                <td>{!! $total !!} VND</td>
                                                <td>{!! $status !!}</td>
                                                <td>{!! $cancel !!}</td>
                                                <td>{!! $exchange !!}</td>
                                                <td style="text-transform: capitalize">{!! $method !!}</td>
                                                <td>{!! $picture !!} </td>
                                                <td>{!! $coupon !!}% </td>
                                                <td>{{ $customer }}</td>
                                                <td>{{ $created }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @include('admin.template.list_empty', ['colspan' => 8])
                                    @endif
                                </tbody>
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 row">
                                        <div class="col-md-12"><button class="btn btn-sm" style="width: 100px">Status</button>{!! $filterStatus !!}</div>
                                        <div class="col-md-12"><button class="btn btn-sm" style="width: 100px">Method</button>{!! $filterMethod !!}</div>
                                        <div class="col-md-12"><button class="btn btn-sm" style="width: 100px">Cancel</button>{!! $filterCancel !!}</div>
                                    </div>
                                    <div class="col-sm-12 col-md-12">
                                        {!! $areaSearch !!}
                                    </div>
                                </div>
                            </table>
                            {!! $items->appends(request()->input())->links('admin.template.pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
         Fancybox.bind("[data-fancybox]", {
           
            Images: {
                zoom: false,
            },
        });
        
            
    </script>
@endsection
