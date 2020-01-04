@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mata Kuliah
      </h1>
      <ol class="breadcrumb">
        <li>Home</li>
        <li class="active">Mata Kuliah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @include('_partials.flash_message')
      		<div class="box box-default">
      			<div class="box-header with-border">
      				<h3 class="box-title">Data Mata Kuliah | <a href="{{ route('admin.matkul.trash') }}" class="text-primary">Trash</a>
              </h3>
                <a href="{{ route('admin.matkul.tambah') }}" class="btn btn-primary btn-sm pull-right" title="Tambah"><i class="fa fa-plus"></i></a>
      			</div>
            
            <div class="box-header with-border">

                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                      Filter By
                </button>


                <!-- search by -->

                <div class="collapse" id="collapseExample">
                  <div class="well">
                    <div class="row">

                      <div class="form-group col col-md-12">
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
      				<div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped matkul">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Matkul</th>
                          <th>Prodi</th>
                          <!-- <th>Semester</th> -->
                          <!--<th>Jenjang</th>-->
                          <!--<th>Kompetensi</th>-->
                          <th>Nama Matkul</th>
                          <th>SKS</th>
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
       var table = $(".matkul").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.matkul.datatable') }}",
            columns: [
                {'data': 'no'},
                {'data': 'kode_matkul'},
                {'data': 'prodi'},
                // {'data': 'semester'},
                // {'data': 'jenjang'},
                // {'data': 'kompetensi'},
                {'data': 'nama_matkul'},
                {'data': 'sks'},
                {'data': 'aksi'},
            ]
        });
        
        $('#btnCari').click(function(){

        var id_prodi            = $('#id_prodi').val();

        var url = "{{ route('admin.matkul.datatable') }}?id_prodi=" + id_prodi;

        //alert(url);
        table.ajax.url(url).load();

        });


      });
    </script>
@stop
