@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Trash Pesan

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li>Pesan</li>

        <li class="active">Trash Pesan</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title"><a href="{{ route('admin.pesan') }}" class="text-primary">Data Pesan</a>| Trash

              </h3>

      			</div>



      			 <div class="box-body">

              <div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped pesan">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>Id Pesan</th>

                          <th>Nama Pengirim</th>

                          <th>Email Pengirim</th>

                          <th>No Telepon Pengirim</th>

                          <th>Subjek</th>

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

        $(".pesan").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.pesan.trash.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'id_pesan'},

                {'data': 'nama'},

                {'data': 'email'},

                {'data': 'no_telp'},

                {'data': 'subjek'},

                {'data': 'aksi'},


            ]

        });

      });

    </script>

@stop