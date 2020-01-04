@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

      Calon Mahasiswa Pindahan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Calon Mahasiswa Pindahan</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-md-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Data Pindahan | <a href="{{ route('admin.daftar.pindahan.trash') }}" class="text-primary">Trash</a>

              </h3>

                <a href="{{ route('admin.daftar.pindahan.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>

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

                    <table class="table table-striped daftar_pindahan">

                      <thead>

                        <tr>

                          <th>No</th>

                          <th>ID Daftar</th>

                          <th>Tahun Akademik</th>

                          <th>Nama Calon Mahasiswa</th>

                          <th>Prodi</th>

                          <th>Status</th>

                          <th>Status Pembayaran</th>

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

      </div>

    </section>

    <!-- /.content -->

    <script type="text/javascript">

      $(document).ready(function(){

       var table =  $(".daftar_pindahan").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.daftar.pindahan.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'id_daftar'},

                {'data': 'akademik'},

                {'data': 'nama'},

                {'data': 'prodi'},

                {'data': 'status'},

                {'data': 'status_pembayaran'},

                {'data': 'aksi'},

            ]

        });

        $('#btnCari').click(function(){

          var tahun_akademik      = $('#tahun_akademik').val();
          var id_prodi            = $('#id_prodi').val();

          var url = "{{ route('admin.daftar.pindahan.datatable') }}?tahun_akademik=" + tahun_akademik + "&id_prodi=" + id_prodi;

          //alert(url);
          table.ajax.url(url).load();

        });

      });

    </script>

@stop