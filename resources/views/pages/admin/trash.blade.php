@extends('template')

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Trash Kategori Pembayaran
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Trash Kategori Pembayaran</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  	<div class="col-xs-12">
      @include('_partials.flash_message')
  		<div class="box box-default">
  			<div class="box-header with-border">
  				<h3 class="box-title"><a href="{{ route('admin.pembayaran') }}" class="text-primary">Data Kategori Pembayaran</a> | Trash
          </h3>
  			</div>
        
  			<div class="box-body">
  				<div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped DataTable trash">
                  <thead>
                    <tr>
                      <th width="10">No</th>
                      <th>Kode</th>
                      <th>Tahun Akademik</th>
                      <th>Nama Kategori</th>
                      <th>Prodi</th>
                      <th>Waktu Kuliah</th>
                      <th>Biaya</th>
                      <th>Potongan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                   
                  </tbody>
                </table>
            </div>
          </div>
  			</div>
  		</div>
  	</div>
  </div>
</section>
<!-- /.content -->

<script type="text/javascript">
  $(document).ready(function(){
    $(".trash").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.pembayaran.trash.datatable') }}",
        columns: [
            {'data': 'no'},
            {'data': 'kode'},
            {'data': 'akademik'},
            {'data': 'kategori'},
            {'data': 'prodi'},
            {'data': 'waktu_kuliah'},
            {'data': 'biaya'},
            {'data': 'potongan'},
            {'data': 'aksi'},
        ]
    });
  });
</script>
@stop
