@extends('layouts.master')
@extends('layouts.components.navbar')
@extends('layouts.components.sidebar')
@section('title','Edit Tiket')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Edit Tiket: {{ $customer->track_id }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <li class="breadcrumb-item active">Edit Tiket</li>
          <li class="breadcrumb-item active">{{ $customer->track_id }}</li>
        </ol>
      </div>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
      <div class="card-body">
        <form method="post" action="/input/update/{{ $customer->track_id }}">
            @method('patch')
          @csrf

          <input name="user_id" value="{{ Auth::user()->id }}" required hidden>
          
          {{-- track id --}}
          <div class="form-group">
            {{-- <label for="track_id" class="form-label">Track ID</label> --}}
            <div class="input-group">
              {{-- <select id="track_type" name="track_type" class="custom-select rounded-0 col-md-1">
                  <option value="MYIR" selected>MYIR</option>
                  <option value="SC">SC</option>
              </select> --}}
              <input id="track_id" name="track_id" type="text" class="form-control col-sm-2 @error('track_id') is-invalid @enderror" aria-label="Track ID" placeholder="Track ID" value="{{ old('track_id', $customer->track_id) }}" hidden>
              @error('track_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="row">
            {{-- nama customer --}}
            <div class="col-12 col-sm-3">
              <div class="form-group">
                <label for="nama_customer">Nama Customer</label>
                <input name="nama_customer" type="text" class="form-control @error('nama_customer') is-invalid @enderror" id="nama_customer" placeholder="Nama Customer" value="{{ old('nama_customer', $customer->nama_customer) }}" readonly>
                @error('nama_customer')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            <div class="col-12 col-sm-3">
              <div class="form-group">
                <label for="telepon">Telepon</label>
                <input name="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" id="telepon" placeholder="Nama Customer" value="{{ old('telepon', $customer->telepon) }}" readonly>
                @error('telepon')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            <div class="col-12 col-sm-3">
              <div class="form-group">
                <label for="email">Email</label>
                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Nama Customer" value="{{ old('email', $customer->email) }}" readonly>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            {{-- alamat customer --}}
            <div class="col-12 col-sm-7">
              <div class="form-group">
                <label for="alamat">Alamat Customer</label>
                <input name="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" placeholder="Alamat Customer" value="{{ old('alamat', $customer->alamat) }}" readonly>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div>
            </div>

            {{-- nomor internet --}}
            <div class="col-12 col-sm-3">
              <div class="form-group">
                <label for="nomor_internet">Nomor Internet</label>
                <input name="nomor_internet" type="text" class="form-control @error('nomor_internet') is-invalid @enderror" id="nomor_internet" placeholder="Nomor Internet" value="{{ old('nomor_internet', $customer->nomor_internet) }}" readonly>
                @error('nomor_internet')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            {{-- channel --}}
            <div class="col-12 col-sm-2">
              <div class="form-group">
                <label>Channel</label>
                <input id="channel_id" name="channel_id" class="form-control" style="width: 100%;" value="{{ $customer->channel->nama }}" readonly>
              </div>
            </div>

            {{-- sto --}}
            <div class="col-12 col-sm-4">
              <div class="form-group">
                <label>STO</label>
                <select name="distribution_id" id="distribution" class="distribution form-control select2 select2-danger" data-dropdown-css-class="select2-danger" style="width: 100%;" required>
                    <option value="" selected disabled>Pilih Kembali: {{ $customer->distribution->nama }}</option>
                    <option value="{{ $customer->distribution->id }}">{{ $customer->distribution->nama }}</option>
                </select>
              </div>
            </div>

            {{-- mitra --}}
            <div class="col-12 col-sm-4">
              <div class="form-group">
                <label>Mitra</label>
                <select name="mitra_id" id="mitra" class="mitra form-control select2 select2-warning" data-dropdown-css-class="select2-warning" style="width: 100%;" required>
                    @if ($customer->mitra_id == '')
                        <option value="" disabled="true" selected="true">Pilih Mitra</option>
                    @else
                        <option value="{{ $customer->mitra_id }}" selected>{{ $customer->mitra->nama }}</option>
                    @endif
                </select>
              </div>
            </div>

            {{-- team --}}
            <div class="col-12 col-sm-4">
              <div class="form-group">
                <label>Team</label>
                <select name="team_id" class="team form-control select2 select2-blue" data-dropdown-css-class="select2-blue" style="width: 100%;" required>
                    @if ($customer->team_id == '')
                        <option value="" disabled="true" selected="true">Pilih Team</option>
                    @else
                        <option value="{{ $customer->team_id }}" selected>{{ $customer->team->nama }}</option>
                    @endif
                  </select>
              </div>
            </div>

            {{-- odp bookingan --}}
            <div class="col-4 col-sm-3">
              <div class="form-group">
                <label for="odp_bookingan">ODP Bookingan</label>
                <input name="odp_bookingan" type="text" class="form-control @error('odp_bookingan') is-invalid @enderror" id="odp_bookingan" placeholder="ODP Bookingan" value="{{ old('odp_bookingan', $customer->odp_bookingan) }}" readonly>
                @error('odp_bookingan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
              </div>
            </div>

            {{-- odp alternatif --}}
            <div class="col-4 col-sm-3">
              <div class="form-group">
                <label for="odp_alternatif">ODP Alternatif</label>
                <input name="odp_alternatif" type="text" class="form-control" id="odp_alternatif" placeholder="ODP Alternatif" value="{{ old('odp_alternatif', $customer->odp_alternatif) }}">
              </div>
            </div>

            {{-- titik koordinat --}}
            <div class="col-4 col-sm-3">
              <div class="form-group">
                <label for="koordinat">Koordinat Pelanggan</label>
                <input name="koordinat" type="text" class="form-control @error('koordinat') is-invalid @enderror" id="-5.159732,119.453886" placeholder="Koordinat Pelanggan" value="{{ old('koordinat', $customer->koordinat) }}" readonly>
                @error('koordinat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            {{-- qrcode --}}
            <div class="col-4 col-sm-3">
              <div class="form-group">
                <label for="qrcode">QR Code</label>
                <input name="qrcode" type="text" class="form-control @error('qrcode') is-invalid @enderror" id="qrcode" placeholder="T7T0JWTAMJ5N" value="{{ old('qrcode', $customer->qrcode) }}">
                @error('qrcode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
              </div>
            </div>

            {{-- status --}}
            <div class="col-12 col-sm-3">
              <div class="form-group">
                <label>Status</label>
                <select id="status_id" name="status_id" class="form-control select2 select2-purple" data-dropdown-css-class="select2-purple" style="width: 100%;">
                    @if ($customer->status_id == '')
                        <option value="" disabled="true" selected>Pilih Status</option>
                        @foreach ($status_list as $item)
                                <option value="{{ $item->id }}">{{ $item->kode . " - " . $item->nama }}</option>
                        @endforeach
                    @else
                        <option value="{{ $customer->status_id }}" selected="selected" disabled>{{ $customer->status->kode . " - " . $customer->status->nama }}</option>
                            @foreach ($status_list as $item)
                                <option value="{{ $item->id }}">{{ $item->kode . " - " . $item->nama }}</option>
                            @endforeach
                    @endif
                </select>
                {{-- @error('status_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror --}}
              </div>
            </div>

            {{-- deksripsi --}}
            <div class="col-12 col-sm-9">
              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <input name="deskripsi" type="text" class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" placeholder="deskripsi" value="{{ old('deskripsi', $customer->deskripsi) }}">
                @error('deskripsi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
              @enderror
              </div>
            </div>

          </div>
          <!-- /.row -->

          {{-- submit --}}
          {{-- @if (session('status')) --}}

          {{-- <div class="card-body p-0">
            <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
              <button type="submit" class="btn btn-primary col-3">Submit</button>
              <button type="submit" class="btn btn-primary col-9">Submit</button>
            </div>
          </div> --}}

            <div class="row mt-4">
                <div class="col-12 col-sm-3">
                    <a href="/customer/detail/{{ $customer->track_id }}"><button type="button" class="btn btn-danger col-12" onclick="return confirm('Batalkan perubahan pada Tiket {{ $customer->track_id }}?')">Batal</button></a>
                </div>
                <div class="col-12 col-sm-9">
                    <button type="submit" class="btn btn-primary col-12" onclick="return confirm('Simpan perubahan pada Tiket {{ $customer->track_id }}?')">Edit</button>
                </div>
            </div>
          {{-- @endif --}}

        </form>
      </div>
    </div>
      
  </div>
  <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $(document).on('change', '.distribution', function(){
        console.log("wih berubah!");

        var id=$(this).val();
        console.log(id);

        var div=$(this).parent().parent().parent().parent();

        var op=" ";

        $.ajax({
          type: 'get',
          url: '{!! URL::to('input/fetchMitra') !!}',
          data: {'id':id},
          success:function(data)
          {
            console.log('success');

            console.log(data);

            console.log(data.length);

            op+='<option value="0" selected disabled>Pilih Mitra</option>';
            for(var i=0;i<data.length;i++)
            {
              op+='<option value="'+data[i].id+'">'+data[i].nama+'</option>';
            }

            div.find('.mitra').html(" ");
            div.find('.mitra').append(op);
          },
          error:function(data)
          {
            console.log('error');
          }
        });

        // script mitra
        $(document).on('change', '.mitra', function(){
          console.log("kolom mitra b!");

          var id=$(this).val();
          console.log(id);

          var div=$(this).parent().parent().parent().parent();

          var op=" ";

          $.ajax({
            type: 'get',
            url: '{!! URL::to('input/fetchTeam') !!}',
            data: {'id':id},
            success:function(data)
            {
              console.log('success');

              console.log(data);

              console.log(data.length);

              op+='<option value="0" selected disabled>Pilih Team</option>';
              for(var i=0;i<data.length;i++)
              {
                op+='<option value="'+data[i].id+'">'+data[i].nama+'</option>';
              }

              div.find('.team').html(" ");
              div.find('.team').append(op);
            },
            error:function(data)
            {
                console.log('error');
            }
          });
        });
        // end script mitra
      });
    });
</script>

<script>
  $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
  })
</script>
