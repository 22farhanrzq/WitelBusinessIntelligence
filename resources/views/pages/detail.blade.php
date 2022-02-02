@extends('layouts.master')
@extends('layouts.components.navbar')
@extends('layouts.components.sidebar')
@foreach ($customer as $item)
@section('title', "$item->track_id")
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $item->track_id }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Customer</a></li>
                <li class="breadcrumb-item"><a href="/customer/{{ $item->distribution->kode }}">{{ $item->distribution->kode }}</a></li>
                <li class="breadcrumb-item"><a href="#">Detail</a></li>
                <li class="breadcrumb-item active">{{ $item->track_id }}</li>
                </ol>
            </div>
        </div>
    </div>
  <!-- /.container-fluid -->
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered">
                            <tr>
                                <td>Nama Customer</td>
                                <td>{{ $item->nama_customer }}</td>
                            </tr>
                            <tr>
                                <td>Telepon</td>
                                <td>{{ $item->telepon }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $item->email }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{ $item->alamat }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Internet</td>
                                <td>{{ $item->nomor_internet }}</td>
                            </tr>
                            <tr>
                                <td>Channel</td>
                                <td>{{ $item->channel->nama }}</td>
                            </tr>
                            <tr>
                                <td>Mitra</td>
                                <td>
                                    @if ($item->mitra_id == '')
                                    -
                                    @else
                                        {{ $item->mitra->nama }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Team</td>
                                <td>
                                    @if ($item->team_id == '')
                                    -
                                    @else
                                        {{ $item->team->nama }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>ODP Bookingan</td>
                                <td>{{ $item->odp_bookingan }}</td>
                            </tr>
                            <tr>
                                <td>ODP Alternatif</td>
                                <td>
                                    @if ($item->odp_alternatif == '')
                                    -
                                    @else
                                        {{ $item->odp_alternatif }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Koordinat</td>
                                <td>{{ $item->koordinat }}</td>
                            </tr>
                            <tr>
                                <td>QR Code</td>
                                <td>
                                    @if ($item->qrcode == '')
                                    -
                                    @else
                                        {{ $item->qrcode }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>
                                    @if ($item->status_id == '')
                                    BELUM WO
                                    @else
                                        {{ $item->status->kategori }}
                                    </td>
                                    @endif
                            </tr>
                            <tr>
                                <td>Deskripsi</td>
                                <td>
                                    @if ($item->deskripsi == '')
                                    -
                                    @else
                                        {{ $item->deskripsi }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Dibuat pada</td>
                                <td>{{ $item->created_at }}</td>
                            </tr>
                            <tr>
                                <td>Terakhir diubah</td>
                                <td>{{ $item->updated_at }} by [{{ $item->user->username }}]</td>
                            </tr>
                        </table>
                        @guest
          
                        @else
                        <div class="row mt-3">
                            <div class="col-12 col-sm-8">
                                <div class="form-group"></div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <form action="/customer/delete/{{ $item->track_id }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-danger col-12" onclick="return confirm('Hapus {{ $item->track_id }}?')">Hapus</button>
                                </form>
                            </div>
                            <div class="col-12 col-sm-2">
                                <a href="/customer/detail/{{ $item->track_id }}/edit"><button type="submit" class="btn btn-primary col-12">Edit</button></a>
                            </div>
                        </div>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->


@endsection
@endforeach