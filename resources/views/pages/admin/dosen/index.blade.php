@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Dosen

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li class="active">Dosen</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Data Dosen | <a href="{{ route('admin.dosen.trash') }}" class="text-primary">Trash</a>

              </h3>

                <a href="{{ route('admin.dosen.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>

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

            ajax: "{{ route('admin.dosen.datatable') }}",

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

