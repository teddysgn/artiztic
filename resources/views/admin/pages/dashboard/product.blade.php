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
                    <div class="card card-chart btn btn-warning">
                        <div class="card-header">
                            <h4 class="card-title"><i class="tim-icons icon-single-02 text-primary"></i> Users</h4>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-6">
                <a href="{{ route('dashboard/product') }}">
                    <div class="card card-chart btn btn-warning active">
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
                        <h5 class="card-category">Total Products</h5>
                        <h3 class="card-title"><i class="fa-solid fa-shirt text-primary"></i> {{ $countAllProduct }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Total Inventory</h5>
                        <h3 class="card-title"><i class="fa-solid fa-bars-progress text-primary"></i> {{ $sumInventoryProduct }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Total Sold</h5>
                        <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-primary "></i> {{ $sumSoldProduct }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="card card-chart">
                    <div class="card-header ">
                        <h5 class="card-category">Discount Products</h5>
                        <h3 class="card-title"><i class="fa-solid fa-arrow-trend-down text-primary"></i> {{ $countDiscountProduct }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Bar Chart - Inventory & Sold --}}
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h2 class="card-title"> Search</h2>
                        <form action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <input type="text" name="key" id="search_key" class="form-control" placeholder="Search Product">
                                    </div>
                                </div>
                                
                                <div class="col-lg-3 col-6">
                                    <div class="form-group">
                                        <input type="button" id="search_product" class="btn btn-sm btn-primary" value="Submit">
                                    </div>
                                </div>
                            </div>
                        </form>
                
                    </div>
                    <div class="card-body" id="search_ajax">
                        
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h2 class="card-title">Inventory & Sold</h2>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="inventory-sold"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Bar Chart - Ratings --}}
        <div class="row">
            {{-- Ratings --}}
            <div class="col-12">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h2 class="card-title header-chart">Ratings</h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                    <label class="btn btn-sm btn-primary btn-simple active" id="0"  onclick="changeChart('highest-rating', '{{ $params['view_by'] != 'default' ? $params['view_by'] : '10'  }} Highest Ratings')">
                                        <input type="radio" name="options" autocomplete="off" checked>
                                        Highest
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple " id="1" onclick="changeChart('lowest-rating', '{{ $params['view_by'] != 'default' ? $params['view_by'] : '10'  }} Lowest Ratings')">
                                        <input type="radio" name="options" autocomplete="off"> Lowest
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="highest-rating" class="change-chart"></canvas>
                            <canvas id="lowest-rating" class="d-none change-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Bar Chart - Distribution --}}
        <div class="row">
            <div class="col-12">
                <div class="card card-chart">
                    <div class="card-header ">
                        <div class="row">
                            <div class="col-sm-6 text-left">
                                <h2 class="card-title header-chart-distribution">Categories Distribution</h2>
                            </div>
                            <div class="col-sm-6">
                                <div class="btn-group btn-group-toggle float-right" data-toggle="buttons">
                                    <label class="btn btn-sm btn-primary btn-simple active" id="3"  onclick="changeChartDistribution('categories-distribution', 'Categories Distribution')">
                                        <input type="radio" name="options" autocomplete="off" checked>
                                        Categories
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple " id="4" onclick="changeChartDistribution('occasions-distribution', 'Occasions Distribution')">
                                        <input type="radio" name="options" autocomplete="off">
                                        Occasions
                                    </label>
                                    <label class="btn btn-sm btn-primary btn-simple " id="5" onclick="changeChartDistribution('collections-distribution', 'Collections Distribution')">
                                        <input type="radio" name="options" autocomplete="off">
                                        Collections
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="categories-distribution" class="change-chart-distribution"></canvas>
                            <canvas id="occasions-distribution" class="d-none change-chart-distribution"></canvas>
                            <canvas id="collections-distribution" class="d-none change-chart-distribution"></canvas>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        {{-- Line Chart & Table --}}
        <div class="row">
            {{-- Table --}}
            <div class="col-lg-6 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h2 class="card-title"> Most Favorite</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th class="text-center">Users</th>
                                </thead>
                                <tbody>
                                    @foreach($favoriteProduct as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img width="60" src="{{ asset('public/images/product/' . '/' . $value['product_name'] . '/' . $value['product_picture']) }}" alt=""></td>
                                            <td>{{ $value['product_name'] }}</td>
                                            <td class="text-center">{{ number_format($value['count'], 0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card ">
                    <div class="card-header">
                        <h2 class="card-title"> Most Access</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table tablesorter " id="">
                                <thead class=" text-primary">
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th class="text-center">Views</th>
                                </thead>
                                <tbody>
                                    @foreach($viewProduct as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img width="60" src="{{ asset('public/images/product/' . '/' . $value['name'] . '/' . $value['picture1']) }}" alt=""></td>
                                            <td>{{ $value['name'] }}</td>
                                            <td class="text-center">{{ number_format($value['view'], 0) }}</td>
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

        $('#search_product').click(function() {
            var key = $('#search_key').val();
            var src = '{{ asset('public/images/product/') }}';
            var html = `<div class="table-responsive" style="overflow: auto">
                            <table class="table tablesorter">
                                <thead class="text-primary">
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Style</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Inventory</th>
                                    <th>Sold</th>
                                </thead>
                                <tbody>`;
            $('#search_ajax').html('');
            $.ajax({
                url: "{{ route('dashboard/search') }}?key=" + key,
                type: "GET",
                success: function(response) {
                    if(response != ''){
                        var count = 0;
                        for(var value of response){
                            
                            html += `<tr>`;
                                if(count == 0){
                                    html += `<td rowspan="`+response.length+`"><img width="120" src="` + src + `/` + value.name + `/` + value.picture1 + `" alt=""></td>
                                        <td  rowspan="`+response.length+`">`+value.name+`</td>
                                        <td  rowspan="`+response.length+`">`+value.style+`</td>`;
                                }
                                    html += `<td>`+value.color+`</td>
                                        <td>`+value.size+`</td>
                                        <td>`+value.inventory+`</td>
                                        <td>`+value.sold+`</td>
                                    </tr>`;
                            count++;
                        }
                        
                    } else {
                        html += `<tr>
                                    <td colspan="7" class="text-center">
                                        Nothing to show
                                    </td>
                                </tr>`;
                    }
                    html += `</tbody>
                            </table>
                        </div>`;
                    $('#search_ajax').html(html);
                    
                    
                }
            });
        })
    </script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        // Bar Chart - Rating
        createBarChart('highest-rating', @php echo json_encode($ratingHighestProduct) @endphp, 'Rating', 'Highest Rating', 'rating');
        createBarChart('lowest-rating', @php echo json_encode($ratingLowestProduct) @endphp, 'Rating', 'Lowest Rating', 'rating');

        // Bar Chart - Inventory & Sold
        createBarChart('inventory-sold', @php echo json_encode($inventoryAndSoldProduct) @endphp, 'Rating', 'Inventory & Sold', 'incentory');

        // Bar Chart - Distribution
        createBarChart('categories-distribution', @php echo json_encode($categoriesDistribution) @endphp, 'Products', 'Categories Distribution', 'distribution');
        createBarChart('occasions-distribution', @php echo json_encode($occasionsDistribution) @endphp, 'Products', 'Occasions Distribution', 'distribution');
        createBarChart('collections-distribution', @php echo json_encode($collectionsDistribution) @endphp, 'Products', 'Collections Distribution', 'distribution');


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
                        backgroundColor: "#800020",
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
                        backgroundColor: "#800020",
                        data: data
                    }]
                };
            }

            if(options == 'incentory'){
                var inventory = [];
                var sold = [];
                for (var value in arrData) {
                    name.push(arrData[value].product_name);
                    sold.push(arrData[value].sold);
                    inventory.push(arrData[value].inventory);
                }

                var barChartData = {
                    labels: name,
                    datasets: [{
                        label: 'Inventory',
                        barThickness: 25,
                        backgroundColor: "#800020",
                        data: inventory
                    },{
                        label: 'Sold',
                        barThickness: 25,
                        backgroundColor: "#11A9A8",
                        data: sold
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
                                borderColor: '#800020)',
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
                    backgroundColor: "#800020",
                    borderColor: "#800020",
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
