@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Trash Tahun Akademik
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li>Tahun Akademik</li>
        <li class="active">Trash Tahun Akademik</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title"><a href="{{ route('admin.tahun_akademik') }}" class="text-primary">Data Tahun Akademik</a> | Trash
              </h3>
      			</div>

      			<div class="box-body">
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped tahun_akademik">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Tahun Akademik</th>
                          <!--<th>Prodi</th>-->
                          <th>Semester</th>
                          <th>Keterangan</th>
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
        $(".tahun_akademik").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.tahun_akademik.trash.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'tahun_akademik'},
                // {'data': 'prodi'},
                {'data': 'semester'},
                {'data': 'keterangan'},
                {'data': 'status'},
                {'data': 'aksi'},
            ]
        });
      });
    </script>
@stop
