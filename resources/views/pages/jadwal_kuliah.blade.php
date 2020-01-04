@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Jadwal Kuliah
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Jadwal Kuliah</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
      		<div class="box box-default">
	      			<div class="box-header with-border">
	      				<h3 class="box-title">Jadwal Kuliah
	              </h3>
	                <a href="" class="btn btn-primary btn-sm pull-right">Download</a>
	      			</div>
	            
	      			<div class="box-body">
	      				<div class="row">
		                <div class="col-xs-12">
		                	<select class="col-md-offset-5 col-xs-offset-5" name="semester" id="semester">
				                <option value="0">-- Pilih Semester --</option>
				                @foreach($semester as $listSemester)
				                	<option value="{{ $listSemester->id_semester }}">{{ $listSemester->tipe }} ( <?php echo date('Y', strtotime($listSemester->tgl_mulai)).' - '.date('Y', strtotime($listSemester->tgl_selesai)) ?> )</option>
				                @endforeach
				            </select>
			                    <table class="table table-bordered table-responsive">
			                    	<thead>
			                    		<tr>
			                    			<th>
			                    				Kode Matakuliah
			                    			</th>
			                    			<th>
			                    				Matakuliah
			                    			</th>
			                    			<th>
			                    				Hari
			                    			</th>
			                    			<th>
			                    				Jam Mulai
			                    			</th>
			                    			<th>
			                    				Jam Selesai
			                    			</th>
			                    			<th>
			                    				SKS
			                    			</th>
			                    		</tr>
			                    	</thead>

			                    	<tbody id="Matkul">
			                    		
			                    	</tbody>
			                    </table>
		                </div>
		              </div>
	      			</div>
	      		</div>
      	</div>
      </div>
    </section>

    <script type="text/javascript">
    	$('#semester').change(function() {
          var id = $(this).val();
          var urlname = "{{ url('mahasiswa/getJadwal') }}/" + id;

          $.ajax({
              type: 'GET',
              url: urlname,
              success: function(data) {
                  $('#Matkul').html(data);
              }
          })
      })
    </script>
@endsection