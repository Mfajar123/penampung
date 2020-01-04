@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Dispensasi

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li class="active">Dispensasi</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Data Dispensasi | <a href="{{ route('admin.dispensasi.trash') }}" class="text-primary">Trash</a>

              </h3>

               {{--  <a href="{{ route('admin.dispensasi.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a> --}}

               <a href="{{ route('admin.dispensasi.print_all') }}" target="_blank" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-print "></i></a>

      			</div>



      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped Dispensasi">

                      <thead>

                        <tr>

                          <th>No</th>
                          
                          <th>NIM/ID Daftar</th>

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

        $(".Dispensasi").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.dispensasi.datatable') }}",

            columns: [

                {'data': 'no'},
                
                {'data': 'id_daftar'},

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

