@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pembayaran Pendaftaran
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.daftar') }}"><i class="fa fa-file-text-o"></i> Pendaftaran</a></li>
        <li class="active">Pembayaran Pendaftaran</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-md-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Form Pembayaran
              </h3>
      			</div>
            
      			<div class="box-body">
              <div class="col-md-12 col-xs-12">
                <div class="row">
                  <div class="table-responsive">
                    {!! Form::model($daftar, ['method' => 'POST', 'route' => ['admin.daftar.pembayaran.perbarui', $id]]) !!}
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
                        <td>Status</td>
                        <td>:</td>
                        <td>{{ $daftar->status_bayar }}</td>
                      </tr>
                      
                      <tr>
                        <td>Promo</td>
                        <td>:</td>
                        {{-- <td>{{  $daftar->promo->nama_promo }} - {{number_format($daftar->promo->diskon) }}</td> --}}
                        <td>
                          <?php
                            if (! empty($daftar->id_promo)) {
                              foreach (explode(',', $daftar->id_promo) as $id_promo) {
                                $promo = App\Promo::findOrFail($id_promo);
                                echo $promo->nama_promo.' - '.number_format($promo->diskon).'<br>';
                              }
                            }
                          ?>
                        </td>
                      </tr>

                      <tr>
                        <td>Sudah Bayar</td>
                        <td>:</td>
                        <td>Rp. {{ number_format($daftar->bayar) }}</td>
                      </tr>

                      <tr>
                        <td>Tunggakan</td>
                        <td>:</td>
                        <td>Rp. {{ number_format($tunggakan) }} <input type="hidden" id="tunggakan" value="{{ $tunggakan }}"></td>
                      </tr>
                      
                      <tr>
                        <td style="vertical-align: middle">Bayar</td>
                        <td style="vertical-align: middle">:</td>
                        <td>{!! Form::text('biaya', null, ['class' => 'form-control money', 'placeholder' => 'Contoh : 250,000', 'required', 'autocomplete' => 'off', 'style' => 'width: 30%']) !!}</td>
                      </tr>

                    </table>
                    <div class="form-group">
                      <a href="{{ route('admin.daftar') }}" class="btn btn-default btn-sm"> Kembali</a>
                      {!! Form::submit('Bayar', ['class' => 'btn btn-primary btn-sm']) !!}
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
      $('.money').keyup(function(){
        if($(this).val() > parseInt($('#tunggakan').val()))
        {
          $(this).val(parseInt($('#tunggakan').val()));
        }
      });
    </script>
@stop