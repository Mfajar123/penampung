@extends('template')





@section('main')


<!-- Content Header (Page header) -->


    <section class="content-header">


      <h1>


        Nilai


      </h1>


      <ol class="breadcrumb">


        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="active">Nilai</li>


      </ol>


    </section>





    <!-- Main content -->


    <section class="content">


      <div class="row">


      	<div class="col-md-12">


          @include('_partials.flash_message')


      		<div class="box box-default">


      			<div class="box-header with-border">


      				<h3 class="box-title">List Nilai


              </h3>


      			</div>


            


      			<div class="box-body">


              <div class="col-md-12 col-xs-12">


                <div class="row">


                  <div class="table-responsive">


                    <table class="table table-striped nilai">


                      <thead>


                        <tr>


                          <th>No</th>


                          <th>ID Daftar</th>


                          <th>Tahun Akademik</th>


                          <th>Nama Calon Mahasiswa</th>


                          <th>Prodi</th>


                          <th>Nilai</th>


                          <th>Status Test</th>


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


        $(".nilai").DataTable({


            processing: true,


            serverSide: true,


            ajax: "{{ route('admin.nilai.datatable') }}",


            columns: [


                {'data': 'no'},


                {'data': 'id_daftar'},


                {'data': 'akademik'},


                {'data': 'nama'},


                {'data': 'prodi'},


                {'data': 'nilai'},


                {'data': 'status'},


                {'data': 'aksi'},


            ]


        });


      });


    </script>


@stop