@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Pengumuman

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li class="active">Pengumuman</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Data Pengumuman | <a href="{{ route('admin.pengumuman.trash') }}" class="text-primary">Trash</a>

              </h3>

                <a href="{{ route('admin.pengumuman.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>

      			</div>



      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped Pengumuman">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>Judul Pengumuman</th>

                          <th>Umumkan Kepada</th>

                          <th>Waktu Pengumuman</th>

                          <th>Sumber Pengumuman</th>

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

        $(".Pengumuman").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.pengumuman.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'judul_pengumuman'},

                {'data': 'umumkan_ke'},

                {'data': 'waktu_pengumuman'},

                {'data': 'sumber_pengumuman'},

                {'data': 'aksi'},


            ]

        });

      });

    </script>

@stop

