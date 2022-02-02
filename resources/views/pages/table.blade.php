@extends('layouts.master')
@extends('layouts.components.navbar')
@extends('layouts.components.sidebar')
@section('title','Performa Teknisi PSB')
@section('content')

@foreach ($distribution_list as $item)
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>PERFORMA TEKNISI PSB {{ $item->nama }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Tabel</a></li>
            <li class="breadcrumb-item active">{{ $item->nama }}</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
</div>
@endforeach

@php
    $current_year = date('Y');    
@endphp

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div id="chart2modded" style="margin-bottom: 20px" style="height: 200px"></div>
        {{-- <canvas id="myChart" width="400" height="400"></canvas> --}}
        {{-- <br> --}}

        <div class="card card-danger">
            <div class="card-header">
              <h3 class="card-title">Total Performa PSB tahun {{ $current_year }}</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered">
                <thead>
                <tr>
                    <th>Nama Mitra</th>
                    <th>Total Team</th>
                    <th>Total WO</th>
                    <th>PS</th>
                    <th>Kendala Teknis</th>
                    <th>Kendala Pelanggan</th>
                    <th>Kendala Total</th>
                    <th>(PS/WO)%</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($mitra_list as $index => $item)
                      @php
                          $total_team = DB::table('teams')
                          ->join('mitras', 'teams.mitra_id', '=', 'mitras.id')
                          ->where('mitra_id', $item->id)
                          // ->distinct()
                          ->count();

                          $ps = DB::table('customers')
                          ->join('statuses', 'customers.status_id', 'statuses.id')
                          ->join('teams', 'customers.team_id', 'teams.id')
                          ->where('kategori', '=', 'PS')
                          ->where('customers.mitra_id', $item->id)
                          ->where('created_at', 'like', $current_year.'%')
                          ->count();

                          $kendala_teknis = DB::table('customers')
                          ->join('statuses', 'customers.status_id', 'statuses.id')
                          ->join('teams', 'customers.team_id', 'teams.id')
                          ->where('kategori', '=', 'Kendala Teknis')
                          ->where('customers.mitra_id', $item->id)
                          ->where('created_at', 'like', $current_year.'%')
                          ->count();

                          $kendala_pelanggan = DB::table('customers')
                          ->join('statuses', 'customers.status_id', 'statuses.id')
                          ->join('teams', 'customers.team_id', 'teams.id')
                          ->where('kategori', '=', 'Kendala Pelanggan')
                          ->where('customers.mitra_id', $item->id)
                          ->where('created_at', 'like', $current_year.'%')
                          ->count();

                          $total_kendala = $kendala_teknis + $kendala_pelanggan;

                          $total_wo = $ps + $total_kendala;

                          if ($ps == 0) {
                              $pswo = 0;
                          }else {
                              $pswo = ($ps/$total_wo)*100;
                          }
                      @endphp
                    <tr>
                        <td>{{ $item->nama_mitra }}</td>
                        <td>{{ $total_team }}</td>
                        <td>{{ $total_wo }}</td>
                        <td>{{ $ps }}</td>
                        <td>{{ $kendala_teknis }}</td>
                        <td>{{ $kendala_pelanggan }}</td>
                        <td>{{ $total_kendala }}</td>
                        <td>
                            @if ($pswo > 90)
                                <span class="badge bg-success">{{ sprintf("%.0f", $pswo)."%" }}</span>
                            @elseif ($pswo >= 80)
                                <span class="badge bg-warning">{{ sprintf("%.0f", $pswo)."%" }}</span>
                            @else
                                <span class="badge bg-danger">{{ sprintf("%.0f", $pswo)."%" }}</span>
                            @endif
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
<!-- /.container-fluid -->
</div>
<!-- /.content -->

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
    Highcharts.chart('chart2modded', {

    title: {
        text: 'PERFORMA TEKNISI {{ $current_year }}'
    },

    subtitle: {
        text: ''
    },

    yAxis: {
        title: {
            text: '(PS/WO)%'
        }
    },

    xAxis: {
        // accessibility: {
        //     rangeDescription: 'Range: January to December'
        // }
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
    },

    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle'
    },

    plotOptions: {
        series: {
            label: {
                connectorAllowed: false
            },
            // pointStart: 2010
        }
    },

    series: [
        @foreach($mitra_list as $item)
            @php
            // januari
            $ps_januari = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-01-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_januari = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-01-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_januari = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-01-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_januari = $kendala_teknisi_januari + $kendala_pelanggan_januari;

            $total_wo_januari = $ps_januari + $total_kendala_januari;

            if ($ps_januari == 0) {
                $pswo_januari = 0;
            }else {
                $pswo_januari = ($ps_januari/$total_wo_januari)*100;
            }

            // februari
            $ps_februari = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-02-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_februari = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-02-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_februari = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-02-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_februari = $kendala_teknisi_februari + $kendala_pelanggan_februari;

            $total_wo_februari = $ps_februari + $total_kendala_februari;

            

            if ($ps_februari == 0) {
                $pswo_februari = 0;
            }else {
                $pswo_februari = ($ps_februari/$total_wo_februari)*100;
            }

            // maret
            $ps_maret = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-03-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_maret = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-03-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_maret = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-03-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_maret = $kendala_teknisi_maret + $kendala_pelanggan_maret;

            $total_wo_maret = $ps_maret + $total_kendala_maret;

            

            if ($ps_maret == 0) {
                $pswo_maret = 0;
            }else {
                $pswo_maret = ($ps_maret/$total_wo_maret)*100;
            }

            // april
            $ps_april = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-04-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_april = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-04-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_april = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-04-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_april = $kendala_teknisi_april + $kendala_pelanggan_april;

            $total_wo_april = $ps_april + $total_kendala_april;

            

            if ($ps_april == 0) {
                $pswo_april = 0;
            }else {
                $pswo_april = ($ps_april/$total_wo_april)*100;
            }

            // mei
            $ps_mei = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-05-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_mei = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-05-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_mei = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-05-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_mei = $kendala_teknisi_mei + $kendala_pelanggan_mei;

            $total_wo_mei = $ps_mei + $total_kendala_mei;

            

            if ($ps_mei == 0) {
                $pswo_mei = 0;
            }else {
                $pswo_mei = ($ps_mei/$total_wo_mei)*100;
            }

            // juni
            $ps_juni = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-06-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_juni = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-06-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_juni = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-06-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_juni = $kendala_teknisi_juni + $kendala_pelanggan_juni;

            $total_wo_juni = $ps_juni + $total_kendala_juni;

            

            if ($ps_juni == 0) {
                $pswo_juni = 0;
            }else {
                $pswo_juni = ($ps_juni/$total_wo_juni)*100;
            }

            // juli
            $ps_juli = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-07-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_juli = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-07-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_juli = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-07-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_juli = $kendala_teknisi_juli + $kendala_pelanggan_juli;

            $total_wo_juli = $ps_juli + $total_kendala_juli;

            

            if ($ps_juli == 0) {
                $pswo_juli = 0;
            }else {
                $pswo_juli = ($ps_juli/$total_wo_juli)*100;
            }

            // agustus
            $ps_agustus = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-08-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_agustus = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-08-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_agustus = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-08-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_agustus = $kendala_teknisi_agustus + $kendala_pelanggan_agustus;

            $total_wo_agustus = $ps_agustus + $total_kendala_agustus;

            

            if ($ps_agustus == 0) {
                $pswo_agustus = 0;
            }else {
                $pswo_agustus = ($ps_agustus/$total_wo_agustus)*100;
            }

            // september
            $ps_september = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-09-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_september = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-09-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_september = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-09-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_september = $kendala_teknisi_september + $kendala_pelanggan_september;

            $total_wo_september = $ps_september + $total_kendala_september;

            

            if ($ps_september == 0) {
                $pswo_september = 0;
            }else {
                $pswo_september = ($ps_september/$total_wo_september)*100;
            }

            // oktober
            $ps_oktober = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-10-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_oktober = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-10-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_oktober = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-10-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_oktober = $kendala_teknisi_oktober + $kendala_pelanggan_oktober;

            $total_wo_oktober = $ps_oktober + $total_kendala_oktober;

            

            if ($ps_oktober == 0) {
                $pswo_oktober = 0;
            }else {
                $pswo_oktober = ($ps_oktober/$total_wo_oktober)*100;
            }

            // november
            $ps_november = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-11-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_november = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-11-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_november = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-11-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_november = $kendala_teknisi_november + $kendala_pelanggan_november;

            $total_wo_november = $ps_november + $total_kendala_november;

            

            if ($ps_november == 0) {
                $pswo_november = 0;
            }else {
                $pswo_november = ($ps_november/$total_wo_november)*100;
            }

            // desember
            $ps_desember = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'PS')
            ->where('created_at', 'like', $current_year.'-12-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_teknisi_desember = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Teknis')
            ->where('created_at', 'like', $current_year.'-12-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $kendala_pelanggan_desember = DB::table('customers')
            ->join('statuses', 'customers.status_id', 'statuses.id')
            ->join('teams', 'customers.team_id', 'teams.id')
            ->where('kategori', '=', 'Kendala Pelanggan')
            ->where('created_at', 'like', $current_year.'-12-%')
            ->where('customers.mitra_id', $item->id)
            ->count();

            $total_kendala_desember = $kendala_teknisi_desember + $kendala_pelanggan_desember;

            $total_wo_desember = $ps_desember + $total_kendala_desember;

            

            if ($ps_desember == 0) {
                $pswo_desember = 0;
            }else {
                $pswo_desember = ($ps_desember/$total_wo_desember)*100;
            }
               
            @endphp
            {
                name: '{{ $item->nama_mitra }}',
                // 
                data: [{{ sprintf("%.0f", $pswo_januari) }}, {{ sprintf("%.0f", $pswo_februari) }}, {{ sprintf("%.0f", $pswo_maret) }}, {{ sprintf("%.0f", $pswo_april) }}, {{ sprintf("%.0f", $pswo_mei) }}, {{ sprintf("%.0f", $pswo_juni) }}, {{ sprintf("%.0f", $pswo_juli) }}, {{ sprintf("%.0f", $pswo_agustus) }}, {{ sprintf("%.0f", $pswo_september) }}, {{ sprintf("%.0f", $pswo_oktober) }}, {{ sprintf("%.0f", $pswo_november) }}, {{ sprintf("%.0f", $pswo_desember) }}]
                // data: data
            },
        @endforeach
    ],

    responsive: {
        rules: [{
            condition: {
                maxWidth: 500
            },
            chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
            }
        }]
    }

    });
</script>

{{-- <script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script> --}}
<script type="text/javascript">
    $(function() {
        $( "#datepicker" ).datepicker({dateFormat: 'yy'});
    });​
</script>


@endsection