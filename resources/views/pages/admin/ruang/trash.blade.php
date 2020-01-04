@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trash Ruang
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li>Ruang</li>
        <li class="active">Trash Ruang</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.ruang') }}" class="text-primary">Data Ruang </a>| Trash
              </h3>
      			</div>

      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped ruang">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Ruang </th>
                          <th>Nama Ruang</th>
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
        $(".ruang").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.ruang.trash.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'kode_ruang'},
                {'data': 'nama_ruang'},
                {'data': 'aksi'},
            ]
        });
      });
    </script>
@stop
