@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trash Jabatan Dosen
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li>Jabatan Dosen</li>
        <li class="active">Trash Jabatan Dosen</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.dosen_jabatan') }}" class="text-primary">Data Jabatan Dosen </a>| Trash
              </h3>
      			</div>

      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped dosen_jabatan">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Jabatan</th>
                          <th>Nama </th>
                          <th>Tunjangan Jabatan</th>
                          <th>Tunjangan SKS</th>
                          <th>Jumlah Komulatif Maksimal</th>
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
        $(".dosen_jabatan").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.dosen_jabatan.trash.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'id_dosen_jabatan'},
                {'data': 'nama'},
                {'data': 'tunjangan_jabatan'},
                {'data': 'tunjangan_sks'},
                {'data': 'jumlah_komulatif_maksimal'},
                {'data': 'aksi'},
            ]
        });
      });
    </script>
@stop
