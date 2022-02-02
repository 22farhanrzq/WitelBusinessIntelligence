@extends('layouts.master')
@extends('layouts.components.navbar')
@extends('layouts.components.sidebar')
@section('title','Dashboard')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            {{-- @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }} --}}
            <div class="col-sm-6">
                <h1 class="m-0">Performa Teknisi PSB Sulawesi Selatan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $today_order}}</h3>
        
                        <p>Order hari ini</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $today_ps }}</h3>
                        {{-- <sup style="font-size: 20px">%</sup> --}}
                        <p>PS hari ini</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-checkmark"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <!-- ./col -->
            
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $today_wo }}</h3>
        
                        <p>WO hari ini</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-arrow-circle-right"></i>
                    </div>
                    {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                </div>
            </div>
            <!-- ./col -->

            <div class="col-md-6">
                <div class="card card-blue">
                    <div class="card-header border-0">
                        <h3 class="card-title">Performa PSB Tiap STO hari ini</h3>
                        {{-- <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                            <i class="fas fa-bars"></i>
                            </a>
                        </div> --}}
                    </div>
                    <div class="card-body table-responsive p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                        <th>STO</th>
                        <th>PS</th>
                        <th>Kendala</th>
                        <th>(PS/WO)%</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($distribution_list as $index => $item)
                            <tr>
                            <td>
                                {{ $item->nama }}
                            </td>
                            {{-- <td>$13 USD</td> --}}
                            <td>{{ $ps_dashboard[$index] }}</td>
                            <td>
                                {{-- <small class="text-success mr-1">
                                <i class="fas fa-arrow-up"></i>
                                12%
                                </small>
                                12,000 Sold --}}
                                {{ $kendala_dashboard[$index] }}
                            </td>
                            <td>
                                {{-- <a href="#" class="text-muted">
                                    <i class="fas fa-search"></i>
                                </a> --}}
                                @if ($dist_pswo[$index] > 90)
                                    <span class="badge bg-success">{{ sprintf("%.0f", $dist_pswo[$index]) }}</span>
                                @elseif ($dist_pswo[$index] >= 80)
                                    <span class="badge bg-warning">{{ sprintf("%.0f", $dist_pswo[$index]) }}</span>
                                @else
                                    <span class="badge bg-danger">{{ sprintf("%.0f", $dist_pswo[$index]) }}</span>
                                @endif
                            </td>
                            </tr> 
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-6">
                <!-- BAR CHART -->
                <div class="card card-secondary">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Kendala</h3>
                    </div> --}}
                    <div class="card-body">
                        <div class="chart">
                            <div id="kendala-chart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></div>
                            {{-- <div class="kendala-chart"></div> --}}
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <div class="row">
                <div class="col-lg-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $total_kendala }}</h3>
                            
                            <p>Kendala hari ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-settings"></i>
                        </div>
                        {{-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> --}}
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ sprintf("%.0f", $pswo) }} <sup style="font-size: 20px">%</sup></h3>
            
                            <p>PS / WO hari ini</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                </div>

            </div>

        </div>

        {{-- <div class="row">
            
        </div> --}}
    </div>
</section>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('kendala-chart-beta', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Kendala Hari Ini'
        },
        accessibility: {
            announceNewData: {
                enabled: true
            }
        },
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'Total Kendala'
            }
        },
        legend: {
            enabled: 'false'
        },
        plotOptions: {
            series: {
                allowPointSelect: false,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                }
            }
        },
        // tooltip: {
        //     headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        //     pointFormat: '<span style="color:{point.color}">{point.name}</span>'
        // },
        series: [{
            name: "Kendala",
            colorByPoint: true,
            data: [
                {
                    name: "Kendala Teknis",
                    y: {{ $kendala_teknis }},
                },
                {
                    name: "Kendala Pelanggan",
                    y: {{ $kendala_pelanggan }},
                },
            ]
        }]
    });
</script>

<script>
    Highcharts.chart('kendala-chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Kendala Hari Ini'
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Kendala'
        }
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                // format: '{point.y:.1f}%'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },

    series: [
        {
            name: "Kendala",
            colorByPoint: true,
            data: [
                {
                    name: "Kendala Teknis",
                    y: {{ $kendala_teknis }},
                },
                {
                    name: "Kendala Pelanggan",
                    y: {{ $kendala_pelanggan }},
                },
            ]
        }
    ],
});
</script>

<script>
    $(function () {
      /* ChartJS
       * -------
       * Here we will create a few charts using ChartJS
       */
  
      //--------------
      //- AREA CHART -
      //--------------
  
      // Get context with jQuery - using jQuery's .get() method.
      var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
  
      var areaChartData = {
        labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
          {
            label               : 'Digital Goods',
            backgroundColor     : 'rgba(60,141,188,0.9)',
            borderColor         : 'rgba(60,141,188,0.8)',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : [28, 48, 40, 19, 86, 27, 90]
          },
          {
            label               : 'Electronics',
            backgroundColor     : 'rgba(210, 214, 222, 1)',
            borderColor         : 'rgba(210, 214, 222, 1)',
            pointRadius         : false,
            pointColor          : 'rgba(210, 214, 222, 1)',
            pointStrokeColor    : '#c1c7d1',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data                : [65, 59, 80, 81, 56, 55, 40]
          },
        ]
      }
  
      var areaChartOptions = {
        maintainAspectRatio : false,
        responsive : true,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            gridLines : {
              display : false,
            }
          }],
          yAxes: [{
            gridLines : {
              display : false,
            }
          }]
        }
      }
  
      // This will get the first returned node in the jQuery collection.
      new Chart(areaChartCanvas, {
        type: 'line',
        data: areaChartData,
        options: areaChartOptions
      })
  
      //-------------
      //- LINE CHART -
      //--------------
      var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
      var lineChartOptions = $.extend(true, {}, areaChartOptions)
      var lineChartData = $.extend(true, {}, areaChartData)
      lineChartData.datasets[0].fill = false;
      lineChartData.datasets[1].fill = false;
      lineChartOptions.datasetFill = false
  
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: lineChartData,
        options: lineChartOptions
      })
  
      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutData        = {
        labels: [
            'Chrome',
            'IE',
            'FireFox',
            'Safari',
            'Opera',
            'Navigator',
        ],
        datasets: [
          {
            data: [700,500,400,600,300,100],
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
          }
        ]
      }
      var donutOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })
  
      //-------------
      //- PIE CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
      var pieData        = donutData;
      var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
      })
  
      //-------------
      //- BAR CHART -
      //-------------
      var barChartCanvas = $('#barChart').get(0).getContext('2d')
      var barChartData = $.extend(true, {}, areaChartData)
      var temp0 = areaChartData.datasets[0]
      var temp1 = areaChartData.datasets[1]
      barChartData.datasets[0] = temp1
      barChartData.datasets[1] = temp0
  
      var barChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        datasetFill             : false
      }
  
      new Chart(barChartCanvas, {
        type: 'bar',
        data: barChartData,
        options: barChartOptions
      })
  
      //---------------------
      //- STACKED BAR CHART -
      //---------------------
      var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
      var stackedBarChartData = $.extend(true, {}, barChartData)
  
      var stackedBarChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }
  
      new Chart(stackedBarChartCanvas, {
        type: 'bar',
        data: stackedBarChartData,
        options: stackedBarChartOptions
      })
    })
</script>
@endsection