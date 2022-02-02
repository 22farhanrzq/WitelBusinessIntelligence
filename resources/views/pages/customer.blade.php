@extends('layouts.master')
@extends('layouts.components.navbar')
@extends('layouts.components.sidebar')
@section('title','Customer')
@section('content')

@foreach($distribution_list as $item)
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>CUSTOMER {{ $item->nama }}</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Customer</a></li>
            <li class="breadcrumb-item active">{{ $item->nama }}</li>
          </ol>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
</div>
@endforeach

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h3 class="card-title">DataTable with default features</h3>
                    </div> --}}
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>FU Date</th>
                                    <th>Track ID</th>
                                    <th>Nama Customer</th>
                                    <th>Status</th>
                                    <th>Team</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_list as $index => $item)
                                <tr>
                                    <td>{{ $index +1 }}</td>
                                    <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                                    <td><a href="/customer/detail/{{ $item->track_id }}">{{ $item->track_id }}</a></td>
                                    <td>{{ $item->nama_customer }}</td>
                                    <td>
                                        @if ($item->status_id == '')
                                            <span class="badge bg-danger">Belum WO</span>
                                        @elseif ($item->status->kategori != 'PS')
                                            <span class="badge bg-danger">{{ $item->status->kategori }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $item->status->kategori }}</span>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if ($item->team_id == '')
                                            -
                                        @else
                                            {{ $item->team->nama }}
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>FU Date</th>
                                    <th>Track ID</th>
                                    <th>Nama Customer</th>
                                    <th>Status</th>
                                    <th>Team</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection