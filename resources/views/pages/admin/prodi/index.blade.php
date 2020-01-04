@extends('template')

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Fakultas
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      @include('_partials.flash_message')
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">Data Fakultas
          </h3>
            <a href="{{ route('admin.prodi.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>
        </div>
        
        <div class="box-body">
          <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-responsive DataTable">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>ID Prodi</th>
                      <th>Kode Prodi</th>
                      <th>Nama Prodi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php $no = 1; ?>
                    @foreach($prodi as $list)
                    <tr>
                      <td>{{ $no }}</td>
                      <td>{{ $list->id_prodi }}</td>
                      <td>{{ $list->kode_prodi }}</td>
                      <td>{{ $list->nama_prodi }}</td>
                      <td align="center"><a href="{{ route('admin.prodi.ubah', $list->id_prodi) }}" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a> <a href="{{ route('admin.prodi.hapus', $list->id_prodi) }}" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus prodi {{ $list->nama_prodi }} ?')" title="Hapus"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                    <?php $no++; ?>
                    @endforeach
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
@stop