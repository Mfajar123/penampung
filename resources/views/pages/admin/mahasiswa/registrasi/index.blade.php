@extends('template')





@section('main')


<!-- Content Header (Page header) -->


    <section class="content-header">


      <h1>


        Registrasi Mahasiswa


      </h1>


      <ol class="breadcrumb">


        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>


        <li class="active">Registrasi Mahasiswa</li>


      </ol>


    </section>





    <!-- Main content -->


    <section class="content container-fluid">


      <div class="row">


      	<div class="col-md-12">


          @include('_partials.flash_message')


      		<div class="box box-default">


      			<div class="box-header with-border">


      				<h3 class="box-title">List Registrasi Mahasiswa


              </h3>


      			</div>

            <div class="box-header with-border">

                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                      Filter By
                </button>


                <!-- search by -->

                <div class="collapse" id="collapseExample">
                  <div class="well">
                    <div class="row">

                      <div class="form-group col col-md-6">
                          <div class="col col-sm-12">
                              {!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
                              {!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['class' => 'form-control']) !!}
                          </div>
                      </div>

                      <div class="form-group col col-md-6">
                          <div class="col col-sm-12">
                              {!! Form::label('id_prodi', 'Prodi', ['class' => 'control-label']) !!}  
                              {!! Form::select('id_prodi', $list_prodi, null, ['class' => 'form-control' ]) !!}
                          </div>
                      </div>

                      <div class="form-group col col-md-6">
                          <div class="col col-sm-12">
                              <button type="button" id="btnCari" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i>" class="btn btn-primary"><i class='fa fa-search'></i> Filter</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
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

                           <th>NIM</th> 

                          <th>Nama Pendaftar</th>

                          <th>Prodi</th>

			                    <th>Waktu Kuliah</th>

                          <th>Status</th>

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
    @stop
    <!-- /.content -->

@section('script')

    <script type="text/javascript">


      $(document).ready(function(){

        var table = $(".pendaftar").DataTable({


            processing: true,


            serverSide: true,


            ajax: "{{ route('admin.registrasi.datatable') }}",


            columns: [


                {'data': 'no'},

                {'data': 'id_daftar'},

                {'data': 'nim'},

                {'data': 'nama'},

                {'data': 'prodi'},

		            {'data': 'waktu_kuliah'},
		        
                {'data': 'status'},
                
                {'data': 'status_pembayaran'},

                {'data' : 'sisa'},

                {'data': 'aksi'},


            ]


        });


          $('#btnCari').click(function(){

            var tahun_akademik      = $('#tahun_akademik').val();
            var id_prodi            = $('#id_prodi').val();

            var url = "{{ route('admin.registrasi.datatable') }}?tahun_akademik=" + tahun_akademik + "&id_prodi=" + id_prodi;

            //alert(url);
            table.ajax.url(url).load();

          });

      });

    </script>

@stop