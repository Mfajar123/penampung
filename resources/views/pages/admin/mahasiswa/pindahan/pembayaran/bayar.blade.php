@extends('template')

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Nilai Calon Mahasiswa
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('admin.daftar') }}"><i class="fa fa-file-text-o"></i> Pendaftaran</a></li>
    <li class="active">Nilai Calon Mahasiswa</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  	<div class="col-md-12">
      @include('_partials.flash_message')
  		<div class="box box-default">
  			<div class="box-header with-border">
  				<h3 class="box-title">Form Nilai
          </h3>
  			</div>
        
  			<div class="box-body">
          <div class="col-md-12 col-xs-12">
            <div class="row">
              <div class="table-responsive">
                {!! Form::open(['method' => 'POST', 'route' => ['admin.pindahan.pembayaran.perbarui', $id]]) !!}
                <table class="table table-striped table-hover">
                  <tr>
                    <th width="200">Tahun Akademik</th>
                    <td width="10">:</td>
                    <td>{{ $daftar->keterangan }}</td>
                  </tr>

                  <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $daftar->nama }}</td>
                  </tr>

                  <tr>
                    <td>No. Telepon</td>
                    <td>:</td>
                    <td>{{ $daftar->no_telp }}</td>
                  </tr>

                  <tr>
                    <td>Provinsi</td>
                    <td>:</td>
                    <td>{{ $daftar->provinsi->nama_provinsi }}</td>
                  </tr>

                  <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ $daftar->alamat }}</td>
                  </tr>

                  <tr>
                    <td>Program Studi</td>
                    <td>:</td>
                    <td>{{ $daftar->prodi->nama_prodi }}</td>
                  </tr>
                  
                  <tr>
                    <td>Kategori Pembayaran</td>
                    <td>:</td>
                    <td>{{ $daftar->nama_biaya }}</td>
                  </tr>

                  <tr>
                    <td>Jenjang</td>
                    <td>:</td>
                    <td>{{ $daftar->jenjang->nama_jenjang }}</td>
                  </tr>

                  <tr>
                    <td>Waktu Kuliah</td>
                    <td>:</td>
                    <td>{{ $daftar->waktu_kuliah->nama_waktu_kuliah }}</td>
                  </tr>

                  <tr>
                    <td>Total Biaya</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($daftar->biaya) }}</td>
                  </tr>
                  
                  <tr>
                    <td>Minimal</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($daftar->minimal) }}</td>
                  </tr>
                  
                  <tr>
                    <td>Diskon</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($daftar->diskon) }}</td>
                  </tr>
                  
                  <tr>
                    <td>Kekurangan Harus Dibayar</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($daftar->biaya - $daftar->bayar_masuk - $daftar->diskon) }}</td>
                  </tr>

                  <tr>
                    <td>Sudah Bayar</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($daftar->bayar_masuk) }}</td>
                  </tr>

                  <tr>
                    <td style="vertical-align: middle">Bayar</td>
                    <td style="vertical-align: middle">:</td>
                    <td>{!! Form::text('bayar', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 20,000', 'required', 'autocomplete' => 'off', 'style' => 'width: 30%']) !!}</td>
                  </tr>

                  <tr>
                    <td>Bayar Ke</td>
                    <td>:</td>
                    <td>{{ $daftar->bayar_ke }}</td>
                  </tr>

                </table>
                <div class="form-group">
                  <a href="{{ route('admin.pindahan.pembayaran') }}" class="btn btn-default btn-sm"> Kembali</a>
                  {!! Form::submit('Simpan Data', ['class' => 'btn btn-primary btn-sm']) !!}
                </div>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
  			</div>
  		</div>
  	</div>
  </div>
</section>
<!-- /.content -->

<script type="text/javascript">
  $('[name="bayar"]').keyup(function(){
    var biaya = {{ $daftar->biaya - $daftar->bayar_masuk }}

    if($(this).val() > biaya)
    {
      $(this).val(biaya);
    }
  });
</script>
@stop