@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Trash Pengumuman

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li>Pengumuman</li>

        <li class="active">Trash Pengumuman</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title"><a href="{{ route('admin.pengumuman') }}" class="text-primary">Data Pengumuman </a>| Trash

              </h3>

      			</div>



      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped Pengumuman">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>Id Pengumuman</th>

                          <th>Judul Pengumuman</th>

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

            ajax: "{{ route('admin.pengumuman.trash.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'id_pengumuman'},

                {'data': 'judul_pengumuman'},

                {'data': 'waktu_pengumuman'},

                {'data': 'sumber_pengumuman'},

                {'data': 'aksi'},


            ]

        });

      });

    </script>

@stop

