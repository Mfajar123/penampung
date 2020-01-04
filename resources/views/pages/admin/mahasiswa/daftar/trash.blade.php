@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trash Mahasiswa
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.mahasiswa') }}"><i class="fa fa-user"></i> Mahasiswa</a></li>
        <li class="active">Trash Mahasiswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.daftar') }}" class="text-primary">Data Mahasiswa</a> | Trash
              </h3>
      			</div>
            
      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped mahasiswa">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>ID Daftar</th>
                          <th>Tahun Akadmeik</th>
                          <th>Nama Pendaftar</th>
                          <th>Prodi</th>
                          <th>Status</th>
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
        $(".mahasiswa").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.daftar.trash.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'id_daftar'},
                {'data': 'akademik'},
                {'data': 'nama'},
                {'data': 'prodi'},
                {'data': 'status'},
                {'data': 'aksi'},
            ]
        });
      });
    </script>
@stop