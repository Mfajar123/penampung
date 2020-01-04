@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trash Dosen
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dosen</li>
        <li class="active"> Trash Dosen</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.dosen') }}" class="text-primary"> Data Dosen </a>| Trash
              </h3>
      			</div>

      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped dosen">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>NIP</th>
                          <th>Nama</th>
                          <th>Prodi</th>
                          <th>Status Dosen</th>
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
        $(".dosen").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.dosen.trash.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'nip'},
                {'data': 'nama'},
                {'data': 'nama_prodi'},
                {'data': 'status_dosen'},
                {'data': 'aksi'},
            ]
        });
      });
    </script>
@stop
