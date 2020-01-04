@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Registrasi Mahasiswa Pindahan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Registrasi Mahasiswa Pindahan</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content container-fluid">

      <div class="row">

      	<div class="col-md-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">List Pendaftaran Mahasiswa Pindahan

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

                          <th>ID Daftar</th>
                          
                          <th> NIM </th>

                          <th>Nama Pendaftar</th>

                          <th>Prodi</th>
                          
                          <th>Waktu Kuliah</th>

                          <th>Status Pembayaran</th>
                          
                          <th>Sisa</th>

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

            ajax: "{{ route('admin.pindahan.registrasi.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'id_daftar'},
                
                {'data': 'nim'},

                {'data': 'nama'},

                {'data': 'prodi'},
                
                {'data': 'wakul'},

                {'data': 'status'},
                
                {'data': 'sisa'},

                {'data': 'aksi'},

            ]

        });

      });

    </script>

@stop