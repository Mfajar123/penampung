@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Kategori Informasi

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li class="active">Kategori Informasi</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Data Kategori Informasi | <a href="{{ route('smp.admin.kategori_info.trash') }}" class="text-primary">Trash</a>

              </h3>

                <a href="{{ route('smp.admin.kategori_info.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>

      			</div>



      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped kategori_info">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>Id Kategori Informasi</th>

                          <th>Kategori Infromasi</th>

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

        $(".kategori_info").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('smp.admin.kategori_info.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'id_kategori_info'},

                {'data': 'kategori_info'},

                {'data': 'aksi'},


            ]

        });

      });

    </script>

@stop

