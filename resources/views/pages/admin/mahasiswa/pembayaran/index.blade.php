@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Pembayaran Kelulusan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Pendaftaran</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-md-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">List Pendaftaran Mahasiswa

              </h3>

      			</div>

            

      			<div class="box-body">

              <div class="col-md-12 col-xs-12">

                <div class="row">

                  <div class="table-responsive">

                    <table class="table table-striped pendaftar">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>No Pendaftaran</th>

                          <th>Nama Pendaftar</th>

                          <th>Nilai</th>

                          <th>Biaya</th>
                          
                          <th>Di Bayar</th>
                          
                          <th>Sisa</th>

                          <th>Status</th>

                          <th width="50">Aksi</th>

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

      </div>

    </section>

    <!-- /.content -->

    <script type="text/javascript">

      $(document).ready(function(){

        $(".pendaftar").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.pembayaran_kelulusan.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'id_daftar'},

                {'data': 'nama'},

                {'data': 'nilai'},

                {'data': 'biaya'},
                
                {'data': 'bayar'},
                
                {'data': 'sisa'},

                {'data': 'status'},

                {'data': 'aksi'},

            ]

        });

      });

    </script>

@stop