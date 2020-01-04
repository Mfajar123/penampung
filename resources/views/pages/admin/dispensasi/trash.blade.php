@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Trash Dispensasi

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li>Informasi</li>

        <li class="active">Trash Dispensasi</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title"><a href="{{ route('admin.dispensasi') }}" class="text-primary">Data Dispensasi </a>| Trash

              </h3>

      			</div>



      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped informasi">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>Nama</th>

                          <th>Jenis Pembayaran</th>

                          <th>Tanggal Akan Bayar</th>

                          <th>Nominal Akan Bayar</th>
                          
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

        $(".informasi").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.dispensasi.trash.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'nama'},

                {'data': 'jenis_pembayaran'},

                {'data': 'tanggal_akan_bayar'},

                {'data': 'nominal_akan_bayar'},
                
                {'data': 'status'},

                {'data': 'aksi'},


            ]

        });

      });

    </script>

@stop

