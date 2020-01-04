@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Dosen Penasihat Akademik</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Dosen Penasihat</li>
		</ol>
	</section>

	<section class="content">
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Data Dosen Penasihat Akademik</h4>
			</div>
	    <div class="box-header with-border">
	        <a href="{{ route('admin.dosen.pa.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah Dosen PA</a>
        
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
                        {!! Form::select('id_prodi', $prodi, null, ['class' => 'form-control' ]) !!}
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


				<div class="table-responsive">
					<table class="table table-striped dosen_pa">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>NIP</th>
								<th nowrap>Nama Dosen</th>
								<th nowrap>Prodi</th>
								<th nowrap>Jumlah</th>
								<th width="100">Aksi</th>
							</tr>
						</thead>
						<tbody>
							
						</tbody>
					</table>
				</div>
		</div>
	</section>

	 
@stop

@section('script')
    <script type="text/javascript">

      $(document).ready(function(){

        var modalFilter = $("#modal-filter");

        var table = $(".dosen_pa").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.dosen.pa.datatable') }}",

            columns: [

                {'data': 'no'},

                {'data': 'nip'},

                {'data': 'nama'},

                {'data': 'prodi'},

                {'data': 'jumlah'},

                {'data': 'aksi'},

            ]

        });


      $('#btnCari').click(function(){

        var id_prodi            = $('#id_prodi').val();

        var url = "{{ route('admin.dosen.pa.datatable') }}?id_prodi=" + id_prodi;

        //alert(url);
        table.ajax.url(url).load();

      });

      });

    </script>

@stop