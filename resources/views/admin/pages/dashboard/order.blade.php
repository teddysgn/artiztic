@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/order') }}">
                    <div class="card card-chart btn btn-warning active">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-bag-16 text-primary"></i> Orders</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/user') }}">
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-single-02 text-primary"></i> Users</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/product') }}">
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-scissors text-primary"></i> Products</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Select Date --}}
        <form action="#" method="post">
            @csrf
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="form-group">
                        <input type="text" id="datepicker1" name="from-date" class="form-control" placeholder="From Date" value="{{ @$params['from-date'] }}">
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="form-group">
                        <input type="text" id="datepicker2" name="to-date" class="form-control" placeholder="To Date" value="{{ @$params['to-date'] }}">
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="form-group">
                        <select name="view_by" class="form-control w-100">
                            <option value="default" {{ isset($params['view_by']) ? '' : 'selected'  }}>Show All</option>
                            <option value="1" {{ $params['view_by'] == 1 ? 'selected' : ''  }}>1</option>
                            <option value="5" {{ $params['view_by'] == 5 ? 'selected' : ''  }}>5</option>
                            <option value="10" {{ $params['view_by'] == 10 ? 'selected' : ''  }}>10</option>
                            <option value="15" {{ $params['view_by'] == 15 ? 'selected' : ''  }}>15</option>
                            <option value="20" {{ $params['view_by'] == 20 ? 'selected' : ''  }}>20</option>
                            <option value="25" {{ $params['view_by'] == 25 ? 'selected' : ''  }}>25</option>
                            <option value="30" {{ $params['view_by'] == 30 ? 'selected' : ''  }}>30</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="form-group">
                        <input type="submit" class="btn btn-sm btn-primary" value="Submit">
                    </div>
                </div>
            </div>
        </form>

        {{-- Summary --}}
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Total Orders</h5>
                        <h3 class="card-title"><i class="tim-icons icon-bag-16 text-primary"></i> 
                            {{ $countAllOrder }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Delivered Orders</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-primary "></i>
                            {{ $countDeliveredOrder }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Cancelled Orders</h5>
                        <h3 class="card-title"><i class="tim-icons icon-simple-remove text-primary "></i>
                            {{ $countCancelledOrder }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Refunded Orders</h5>
                        <h3 class="card-title"><i class="tim-icons icon-refresh-02 text-primary "></i> 
                            {{ $countRefundedOrder }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart" data-toggle="tooltip" data-placement="bottom" title="{{ number_format($averageOrderValue, 1) }}">
                    <div class="card-header ">
                        <h5 class="card-category">Average Order Value</h5>
                        <h3 class="card-title">
                            <i class="tim-icons icon-chart-bar-32 text-primary "></i> 
                            {{ number_format($averageOrderValue / 1000000, 2) }}M
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart" data-toggle="tooltip" data-placement="bottom" title="{{ number_format($sumTotalRevenue, 1) }}">
                    <div class="card-header ">
                        <h5 class="card-category">Total Revenue</h5>
                        <h3 class="card-title"><i class="tim-icons icon-coins text-primary "></i> {{ number_format($sumTotalRevenue / 1000000, 1) }}M</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart" data-toggle="tooltip" data-placement="bottom" title="{{ number_format($sumTotalRevenueCashOnDelivery, 1) }}">
                    <div class="card-header ">
                        <h5 class="card-category">Cash on Delivery</h5>
                        <h3 class="card-title"><i class="tim-icons icon-coins text-primary "></i> {{ number_format($sumTotalRevenueCashOnDelivery / 1000000, 1) }}M</h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart" data-toggle="tooltip" data-placement="bottom" title="{{ number_format($sumTotalRevenueMobileBanking, 1) }}">
                    <div class="card-header ">
                        <h5 class="card-category">Mobile Banking</h5>
                        <h3 class="card-title"><i class="tim-icons icon-coins text-primary "></i> {{ number_format($sumTotalRevenueMobileBanking / 1000000, 1) }}M</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bar Chart --}}
        <div class="row">
            <div class="col-12">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h2 class="card-title header-chart">Total Orders</h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                    <label class="btn btn-sm btn-primary btn-simple active" id="0"  onclick="changeChart('total-chart', 'Total Orders')">
                                        <input type="radio" name="options" autocomplete="off" checked>
                                        All
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple " id="1" onclick="changeChart('delivered-chart', 'Delivered Orders')">
                                        <input type="radio" name="options" autocomplete="off"> Delivered
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple " id="2" onclick="changeChart('cancelled-chart', 'Cancelled Orders')">
                                        <input type="radio" name="options" autocomplete="off"> Cancelled
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple " id="3" onclick="changeChart('refunded-chart', 'Refunded Orders')">
                                        <input type="radio" name="options" autocomplete="off"> Refunded
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="total-chart" class="change-chart"></canvas>
                            <canvas id="delivered-chart" class="d-none change-chart"></canvas>
                            <canvas id="cancelled-chart" class="d-none change-chart"></canvas>
                            <canvas id="refunded-chart" class="d-none change-chart"></canvas>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h2 class="card-title">Products Sold</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="sold-chart"></canvas>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h2 class="card-title">Customer</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="customer-chart"></canvas>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        {{-- Line Chart & Table --}}
        <div class="row">
            {{-- Line Chart --}}
            <div class="col-lg-6 col-md-12">
                <div class="card card-tasks">
                    <div class="card-header ">
                        <h2 class="title d-inline">Revenue by Week</h2></br>
                        <p class="card-category d-inline">
                            This Week: 
                            <strong>{{ number_format($sumTotalRevenueByThisWeek / 1000000, 1) }}M</strong> 
                            @php
                                $displayTargetThisWeek = $sumTotalRevenueByThisWeek / $kpiWeek * 100;
                                $classTargetThisWeek = $displayTargetThisWeek > 100 ? 'text-success' : 'text-danger';
                            @endphp
                            <strong data-toggle="tooltip" data-placement="bottom" title="KPI: {{ number_format($kpiWeek, 0) }}" class="{{ $classTargetThisWeek }}">({{ number_format($displayTargetThisWeek, 1)  }}% KPI)</strong>
                        </p>
                        </br>
                        <p class="card-category d-inline">
                            Last Week: 
                            <strong>{{ number_format($sumTotalRevenueByPreviousWeek / 1000000, 1) }}M</strong>
                            @php
                                $displayTargetPreviousWeek = $sumTotalRevenueByPreviousWeek / $kpiWeek * 100;
                                $classTargetPreviousWeek = $displayTargetPreviousWeek > 100 ? 'text-success' : 'text-danger';
                            @endphp
                            <strong data-toggle="tooltip" data-placement="bottom" title="KPI: {{ number_format($kpiWeek, 0) }}" class="{{ $classTargetPreviousWeek }}">({{ number_format($displayTargetPreviousWeek, 1)  }}% KPI)</strong>
                        </p>
                        </br>
                    </div>
                    <div class="card-body ">
                        <div class="chart-area">
                            <canvas id="revenue-week"  style="height: 350px !important"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="col-lg-6 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h2 class="card-title"> Revenue by the last 7 days</h2>
                        <p class="card-category d-inline">
                            <strong>ABS:</strong> 
                            Average Basket Size
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>ABS</th>
                                    <th class="text-center">Revenue</th>
                                </thead>
                                <tbody>
                                    @foreach($tableListOrderByDate as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td data-toggle="tooltip" data-placement="bottom" title="{{ date('l', strtotime($value['date'])) }}">{{ $value['date'] }}</td>
                                            <td>{{ number_format($value['quantity'], 1) }}</td>
                                            <td class="text-center">{{ number_format($value['sum'] / 1000000, 1) }}M</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-tasks">
                    <div class="card-header ">
                        <h2 class="title d-inline">Revenue by Month</h2></br>
                        <p class="card-category d-inline">
                            This Month: 
                            <strong>{{ number_format($sumTotalRevenueByThisMonth / 1000000, 1) }}M</strong> 
                            @php
                                $displayTargetThisMonth = $sumTotalRevenueByThisMonth / $kpiMonth * 100;
                                $classTargetThisMonth = $displayTargetThisMonth > 100 ? 'text-success' : 'text-danger';
                            @endphp
                            <strong data-toggle="tooltip" data-placement="bottom" title="KPI: {{ number_format($kpiMonth, 0) }}" class="{{ $classTargetThisMonth }}">({{ number_format($displayTargetThisMonth, 1)  }}% KPI)</strong>
                        </p>
                        </br>
                        <p class="card-category d-inline">
                            Last Month: 
                            <strong>{{ number_format($sumTotalRevenueByPreviousMonth / 1000000, 1) }}M</strong>
                            @php
                                $displayTargetPreviousMonth = $sumTotalRevenueByPreviousMonth / $kpiMonth * 100;
                                $classTargetPreviousMonth = $displayTargetPreviousMonth > 100 ? 'text-success' : 'text-danger';
                            @endphp
                            <strong data-toggle="tooltip" data-placement="bottom" title="KPI: {{ number_format($kpiMonth, 0) }}" class="{{ $classTargetPreviousMonth }}">({{ number_format($displayTargetPreviousMonth, 1)  }}% KPI)</strong>
                        </p>
                        </br>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="revenue-month" style="height: 350px !important"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $('#datepicker1').datepicker({
            dateFormat: 'dd-mm-yy',
        });
        $('#datepicker2').datepicker({
            dateFormat: 'dd-mm-yy',
        });

        function changeChart(id, title) {
            $('.change-chart').addClass('d-none');
            $('#'+id).removeClass('d-none');
            $('.header-chart').text(title);
        }
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // Bar Chart - Cart
        createBarChart('delivered-chart', @php echo json_encode($chartDeliveredOrder) @endphp, 'Orders', 'Delivered Orders', 'cart');
        createBarChart('cancelled-chart', @php echo json_encode($chartCancelledOrder) @endphp, 'Orders', 'Cancelled Orders', 'cart');
        createBarChart('refunded-chart', @php echo json_encode($chartRefundedOrder) @endphp, 'Orders', 'Refunded Orders', 'cart');
        createBarChart('total-chart', @php echo json_encode($chartAllOrder) @endphp, 'Orders', 'All Orders', 'cart');

        // Bar Chart - Sold
        createBarChart('sold-chart', @php echo json_encode($chartProductSold) @endphp, 'Sold', 'All Orders', 'sold');

        // Bar Chart - Customer
        createBarChart('customer-chart', @php echo json_encode($chartCustomer) @endphp, 'Customer', 'Revenue', 'customer');

        // Bar Chart - Revenue Month
        createBarChartMulti('revenue-month', @php echo json_encode($chartByThisMonth) @endphp, @php echo json_encode($chartByPreviousMonth) @endphp, 'This Month', 'Last Month', 'Revenue');

        // Line Chart - Revenue Week
        createLineChart('revenue-week', @php echo json_encode($chartByThisWeek) @endphp, @php echo json_encode($chartByPreviousWeek) @endphp, 'This Week', 'Last Week', 'Revenue');

        function createBarChart(id, arrData, label, text, options) {
            if(options == 'cart'){
                var labels = [];
                var data = [];

                for (var value in arrData) {
                    labels.push(arrData[value].date);
                    data.push(arrData[value].count);
                }

                var barChartData = {
                    labels: labels,
                    datasets: [{
                        label: label,
                        barThickness: 25,
                        backgroundColor: "#968B7E",
                        data: data
                    }]
                };
            }

            if(options == 'sold'){
                var labels = [];
                var data = [];
                for (var value in arrData) {
                    labels.push(arrData[value].product_name);
                    data.push(arrData[value].sum);
                }

                var barChartData = {
                    labels: labels,
                    datasets: [{
                        label: label,
                        barThickness: 25,
                        backgroundColor: "#968B7E",
                        data: data
                    }]
                };
            }

            if(options == 'customer'){
                var labels = [];
                var data = [];
                var count = [];
                for (var value in arrData) {
                    labels.push(arrData[value].user_fullname);
                    data.push(arrData[value].sum / 1000000);
                    count.push(arrData[value].count);
                }

                var barChartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Customer',
                        barThickness: 25,
                        backgroundColor: "#968B7E",
                        data: data,
                        order: 1,
                    }, 
                    {
                        label: 'Orders',
                        barThickness: 25,
                        borderColor: "#11A9A8",
                        backgroundColor: "#11A9A8",
                        data: count,
                        order: 0,
                    }]
                };
            }
            
            var ctx = document.getElementById(id).getContext("2d");
                let barChart = new Chart(ctx, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        maintainAspectRatio: false,
                        elements: {
                            rectangle: {
                                borderWidth: 1,
                                borderColor: '#968B7E)',
                                borderSkipped: 'bottom'
                            }
                        },
                        responsive: true,
                        title: {
                            display: true,
                            text: text,
                        },
                        scales: {
                            y: {
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true,
                                position: 'right'
                            },
                            
                            revenue: {
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true,
                                    position: 'right'
                                },
                            },
                            order: {
                                ticks: {
                                    stepSize: 1,
                                    beginAtZero: true,
                                    position: 'left'
                                },
                            }
                        },
                        }
                        
                    }
                });
        }

        function createBarChartMulti(id, arrData1, arrData2, label1, label2, text) {
            var dateThisMonth = [];
            var dataThisMonth = [];
            var datePreviousMonth = [];
            var dataPreviousMonth = [];
            var date = [];

            for(let i = 1; i <= 31; i++){
                dataThisMonth[i - 1] = 0;
                dataPreviousMonth[i - 1] = 0;
                date.push(i);
            }

            for (var value in arrData1) {
                arrData1[value].sum != 0 ? dataThisMonth[arrData1[value].date - 1] = arrData1[value].sum / 1000000 : 0;
                dateThisMonth.push(arrData1[value].date);
            }

            for (var value in arrData2) {
                arrData2[value].sum != 0 ? dataPreviousMonth[arrData2[value].date - 1] = arrData2[value].sum / 1000000 : 0;
                datePreviousMonth.push(arrData2[value].date);
            }

            var barChartData = {
                labels: date,
                datasets: [{
                    label: label1,
                    barThickness: 15,
                    backgroundColor: "#968B7E",
                    borderColor: "#968B7E",
                    data: dataThisMonth
                },{
                    label: label2,
                    barThickness: 15,
                    backgroundColor: "#11A9A8",
                    borderColor: "#11A9A8",
                    data: dataPreviousMonth
                }]
            };
        
            
            var ctx = document.getElementById(id).getContext("2d");
                let barChart = new Chart(ctx, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        maintainAspectRatio: false,
                        elements: {
                            rectangle: {
                                borderWidth: 1,
                                borderColor: '#968B7E)',
                                borderSkipped: 'bottom'
                            }
                        },
                        responsive: true,
                        title: {
                            display: true,
                            text: text
                        },
                        y: {
                            ticks: {
                                stepSize: 1,
                                beginAtZero: true
                            }
                        }
                    }
                });
        }

        function createLineChart(id, arrData1, arrData2, label1, label2, text) {
            var data1 = [];
            var data2 = [];

            var date = [
                "Mon", 
                "Tue", 
                "Wed", 
                "Thu", 
                "Fri", 
                "Sat", 
                "Sun"
            ];

            for(let i = 1; i <= 31; i++){
                data1[i] = 0;
                data2[i] = 0;
            }

            for(var value of arrData1){
                value.date == 'Monday' ? data1[0] = value.sum / 1000000 : 0;
                value.date == 'Tuesday' ? data1[1] = value.sum / 1000000 : 0;
                value.date == 'Wednesday' ? data1[2] = value.sum / 1000000 : 0;
                value.date == 'Thursday' ? data1[3] = value.sum / 1000000 : 0;
                value.date == 'Friday' ? data1[4] = value.sum / 1000000 : 0;
                value.date == 'Saturday' ? data1[5] = value.sum / 1000000 : 0;
                value.date == 'Sunday' ? data1[6] = value.sum / 1000000 : 0;
            }

            for(var value of arrData2){
                value.date == 'Monday' ? data2[0] = value.sum / 1000000 : 0;
                value.date == 'Tuesday' ? data2[1] = value.sum / 1000000 : 0;
                value.date == 'Wednesday' ? data2[2] = value.sum / 1000000 : 0;
                value.date == 'Thursday' ? data2[3] = value.sum / 1000000 : 0;
                value.date == 'Friday' ? data2[4] = value.sum / 1000000 : 0;
                value.date == 'Saturday' ? data2[5] = value.sum / 1000000 : 0;
                value.date == 'Sunday' ? data2[6] = value.sum / 1000000 : 0;
            }



            var lineChartData = {
                labels: date,
                datasets: [{
                    label: label1,
                    backgroundColor: "#968B7E",
                    borderColor: "#968B7E",
                    fill: false,
                    data: data1
                },{
                    label: label2,
                    backgroundColor: "#11A9A8",
                    borderColor: "#11A9A8",
                    fill: false,
                    data: data2
                }]
            };

            window.onload = function() {
                var ctx = document.getElementById(id).getContext("2d");
                let lineChart = new Chart(ctx, {
                    type: 'line',
                    data: lineChartData,
                    options: {
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Revenue by Week'
                            },
                            responsive: true,
                        },
                    }
                });
            };
        }
    </script>
    
    <style>
        canvas#revenue-week {
            height: 350px !important;
        }
    </style>
@endsection
