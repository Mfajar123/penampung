@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Detail KRS
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li class="active">Detail KRS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Detail KRS <b>{{$nama}}</b></h3>
              <a href="{{ route('dosen.krs.print', $id) }}" class='btn btn-primary btn-sm' target='_blank'><i class='fa fa-print'></i> Print KRS</a>
      			</div>

      			<div class="box-body">
      				<div class="row"> 
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped jadwal">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Matkul</th>
                          <th>Nama Matkul</th>
                          <th>SKS</th>
                        </tr>
                      </thead>
                      <?php $no=1;?>
                      @if(count($krs))
                      <tbody>
                        @foreach($krs as $item)
                        <tr>
                          <td>{{$no++}}</td>
                          <td>{{$item->matkul->kode_matkul}}</td>
                          <td>{{$item->matkul->nama_matkul}}</td>
                          <td>{{$item->matkul->sks}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      
                      @else
                      <tbody>
                        <tr>
                          <td colspan="4">Tidak Ada Data</td>
                        </tr>
                      </tbody>
                      @endif
                    </table>
                </div>
              </div>
            </div>
          </div>
          <a onclick="history.go(-1);" class="btn btn-default btn-sm"><i class="fa fa-arrow-left"></i> Kembali</a>
      	</div>
      </div>
    </section>
@stop
