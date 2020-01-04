@extends('template')

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Detail Pembayaran Kelulusan
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('admin.daftar') }}"><i class="fa fa-file-text-o"></i> Pendaftaran</a></li>
    <li class="active">Detail Pembayaran  Kelulusan Calon Mahasiswa</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-default">
  			<div class="box-header with-border">
  				<h3 class="box-title">Detail Pembayaran Kelulusan Calon Mahasiswa
          </h3>
  			</div>
        
  			<div class="box-body">
          <div class="col-md-12 col-xs-12">
            <div class="row">
              <div class="table-responsive">
                <table class="kolom" width="100%" cellspacing="0">
                  <tr>
                    <th>No.Pendaftaran</th>
                    <td>: {{$daftar->id_daftar}}</td>
                    <th>Waktu Kuliah</th>
                    <td>: {{$daftar->nama_waktu_kuliah}}</td>
                  </tr>
                  <tr>
                    <th>Nama Pendaftar</th>
                    <td>: {{$daftar->nama}}</td>
                    <th>Alamat</th>
                    <td>: {{$daftar->alamat}}</td>
                  </tr>
                  <tr>
                    <th>Program Studi</th>
                    <td>: {{$daftar->Prodi->nama_prodi}}</td>
                    <th>Status</th>
                    <td>: {{$kategori}}</td>
                  </tr>
                </table>
              </div><br><br>
              <div class="table-responsive">
                <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                   <tr>
                    <th colspan="2" style="text-align: center;">Biaya Registrasi Mahasiswa Baru</th>
                  </tr>
                  <tr>
                    <th>Jenis Biaya</th>
                    <th>Besar Biaya</th>
                  </tr>
                  
                  <tr>
                    <td>Total</td>
                    <td>Rp. {{ number_format($daftar->biaya) }}</td>
                  </tr>
                  <tr>
                    <td>Potongan</td>
                    <td>Rp. {{ number_format($daftar->potongan) }}</td> 
                  </tr>
                  <tr>
                    <td>Promo</td>
                    <td>Rp. {{ number_format($diskon_promo) }}</td>  
                  </tr>
                  <tr>
                    <td>Biaya Harus Dibayar</td>
                    <td>Rp. {{ number_format($biaya) }}</td>
                  </tr>
                </table>

                <table id="tabel-data" class="table table-striped table-bordered" width="100%" cellspacing="0">
                  <tr>
                    <th colspan="4" style="text-align: center;">Pembayaran Kelulusan</th>
                  </tr>
                  <tr>
                    <th>Tanggal Pembayaran</th>
                    <th>Bayaran Kelulusan</th>
                    <th>Bayar Ke</th>
                    <th>Akis</th>
                  </tr>
                  @foreach($detail as $dtl)
                  
                  <tr>
                    <td>{{ date('d-m-Y', strtotime($dtl->tanggal_pembayaran))  }}</td>
                    <td>Rp. {{ number_format($dtl->bayar_kelulusan) }}</td>
                    <td>{{ $dtl->pembayaran_ke }}</td>
                    <td>
                        <a href="{{ route('admin.pembayaran_kelulusan.hapus', [ $dtl->id_daftar, $dtl->id_daftar_pembayaran, $dtl->id_daftar_detail_pembayaran,  ])}}" onclick="return confirm('Apa anda yakin ingin membatalkan pembayaran ini ? ')" class="btn btn-danger btn-sm" title="Batalkan Pembayaran" ><i class="fa fa-undo"></i></a> 
                    </td>
                  </tr>
                  @endforeach
                  <tr>
                    <th >Status</th>
                    <th>{{ $daftar->status_pembayaran }}</th>
                  </tr>
                </table>
              </div>
                 <a href="{{ route('admin.pembayaran_kelulusan') }}" class="btn btn-default">Kembali</a>
            </div>
          </div>
  			</div>
  		</div>
  	</div>
  </div>
</section>
<!-- /.content -->
@stop