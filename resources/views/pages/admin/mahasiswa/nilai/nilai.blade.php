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
                {!! Form::open(['method' => 'POST', 'route' => ['admin.nilai.perbarui', $id]]) !!}
                <table class="table table-striped table-hover">
                  <tr>
                    <th width="150">Tahun Akademik</th>
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
                    <td>Total</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($daftar->bayar) }}</td>
                  </tr>

                  <tr>
                    <td>Status Bayar</td>
                    <td>:</td>
                    <td>{{ $daftar->status_bayar }}</td>
                  </tr>

                  <tr>
                    <td style="vertical-align: middle">Nilai</td>
                    <td style="vertical-align: middle">:</td>
                    <td>{!! Form::text('nilai', null, ['class' => 'form-control nilai', 'placeholder' => 'Contoh : 80.98', 'required', 'autocomplete' => 'off', 'style' => 'width: 15%', 'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57', 'maxlength' => '6']) !!}</td>
                  </tr>
                             

                </table>
                <div class="form-group">
                  <a href="{{ route('admin.nilai') }}" class="btn btn-default btn-sm"> Kembali</a>
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
  $('.nilai').keyup(function(){
    var current = $(this).val();
    if($(this).val().length == 3)
    {
        if(current.substr(2, 3) == '.')
        {
            $(this).val(current.replace('.', ''));
        }
        else
        {
            $(this).val(current.substr(0, 2)+'.'+current.substr(2, 6));
        }

    }
    else if($(this).val().length == 6)
    {
        $(this).val(current.replace('.', ''));
        var max = parseInt(100);
        if($(this).val() < max.toFixed(2))
        {
            $(this).val($(this).val().substr(0, 3)+'.'+$(this).val().substr(3, 6));
        }
        else
        {
            $(this).val(max.toFixed(2));
        }
    }
    else if($(this).val().length < 3)
    {
        $(this).val(current.replace('.', ''));
    }
  });
</script>
@stop