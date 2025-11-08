@extends('admin.main')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/order') }}">
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-bag-16 text-primary"></i> Orders</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/user') }}">
                    <div class="card card-chart btn btn-warning active">
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

        <form action="#" method="post">
            @csrf
            <div class="row">
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
                        <h5 class="card-category">Total Users</h5>
                        <h3 class="card-title"><i class="tim-icons icon-single-02 text-primary"></i> {{ $countAllUser }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Users Have Order</h5>
                        <h3 class="card-title"><i class="tim-icons icon-app text-primary"></i> {{ $countUserHaveOrder }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Recently Access</h5>
                        <h3 class="card-title"><i class="tim-icons icon-tap-02 text-primary "></i> {{ $countUserRecentlyAccess }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Discount Products</h5>
                        <h3 class="card-title"><i class="fa-solid fa-arrow-trend-down text-primary"></i> {{ $countUserHaveOrder }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{--Table --}}
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h2 class="card-title"> Activity Users</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Last Activity</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @foreach($tableListUser as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value['fullname'] }}</td>
                                            <td>{{ $value['email'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value['last_activity'])->diffForHumans() }}</td>
                                            <td>
                                                @if(Cache::has('user-is-online-'. $value['id']))
                                                    <span class="text-success">Online</span>
                                                @else
                                                    <span class="text-danger">Offline</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        function changeChart(id, title) {
            $('.change-chart').addClass('d-none');
            $('#'+id).removeClass('d-none');
            $('.header-chart').text(title);
        }

        function changeChartDistribution(id, title) {
            $('.change-chart-distribution').addClass('d-none');
            $('#'+id).removeClass('d-none');
            $('.header-chart-distribution').text(title);
        }
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Bar Chart - Rating
       

        function createBarChart(id, arrData, label, text, options) {
            var name = [];
            var data = [];


            if(options == 'rating'){
                for (var value in arrData) {
                    name.push(arrData[value].product_name);
                    data.push(arrData[value].rating);
                }

                var barChartData = {
                    labels: name,
                    datasets: [{
                        label: label,
                        barThickness: 25,
                        backgroundColor: "#968B7E",
                        data: data
                    }]
                };
            }

            if(options == 'distribution'){
                for (var value in arrData) {
                    name.push(arrData[value].distribution_name);
                    data.push(arrData[value].count);
                }

                var barChartData = {
                    labels: name,
                    datasets: [{
                        label: label,
                        barThickness: 25,
                        backgroundColor: "#968B7E",
                        data: data
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

            data1[0] = 0;
            data1[1] = 0;
            data1[2] = 0;
            data1[3] = 0;
            data1[4] = 0;
            data1[5] = 0;
            data1[6] = 0;

            data2[0] = 0;
            data2[1] = 0;
            data2[2] = 0;
            data2[3] = 0;
            data2[4] = 0;
            data2[5] = 0;
            data2[6] = 0;


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
                    responsive: true,
                    options: {
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Revenue by Week'
                            }
                        },
                    }
                });
            };
        }
        
        
    </script>
@endsection
