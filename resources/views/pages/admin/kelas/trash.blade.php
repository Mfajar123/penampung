@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Trash Kelas
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Trash Kelas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.kelas') }}" class="text-primary">Data Kelas</a> | Trash
              </h3>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped DataTable">
                      <thead>
                        <tr>
                          <th width="15">No</th>
                          <th>Kode Kelas</th>
                          <th>Nama Kelas</th>
                          <th>Waktu Kuliah</th>
                          <th>Kapasitas</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>

                      <tbody>
                        @foreach($kelas as $list)
                        <tr>
                          <td>{{ $no++ }}</td>
                          <td>{{ $list->kode_kelas }}</td>
                          <td>{{ $list->nama_kelas }}</td>
                          <td>{{ $list->waktu_kuliah->nama_waktu_kuliah }}</td>
                          <td>{{ $list->kapasitas }}</td>
                          <td align="center"><a href="{{ route('admin.kelas.restore', $list->id_kelas) }}" class="btn btn-success btn-sm" title="Pulihkan" onclick="return confirm('Anda Yakin Akan Memulihkan {{ $list->nama_kelas }}')"><i class="fa fa-mail-reply"></i></a> <a href="{{ route('admin.kelas.hapus.permanen', $list->id_kelas) }}" class="btn btn-danger btn-sm" title="Hapus Permanen" onclick="return confirm('Anda yakin akan menghapus kelas {{ $list->nama_kelas }}')"><i class="fa fa-trash-o"></i></a>
                          </td>
                        </tr>
                        <!-- Modal -->
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
