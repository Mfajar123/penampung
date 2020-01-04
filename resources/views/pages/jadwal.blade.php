@extends('template')

@section('main')
<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        KRS Online
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">KRS Online</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      	<div class="col-xs-12">
          @if (Session::has('flash_message'))
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              {{ Session::get('flash_message') }}
            </div>
          @endif
          		<div class="box box-default">
	      			<div class="box-header with-border">
	      				<h3 class="box-title">Pengisian KRS Online
	              </h3>
	              <p class="pull-right">Jurusan : <strong>{{ $getJurusan->jurusan->nama_jurusan }}</strong></p>
	                <!-- <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#tambahKelas">Tambah</a> -->
	      			</div>
	            
	      			<div class="box-body">
	      				<div class="row">
		                <div class="col-xs-12">
		                	{!! Form::open(['method' => 'post', 'route' => 'krs.tambah', 'files' => true]) !!}
			                    @if($jadwal > 0)
			                    	<h4>Semester : {{ $tipeSemester }}</h4>
			                    @else
			                    	<select class="col-md-offset-5 col-xs-offset-5" name="semester" id="semester">
				                    	<option value="0">-- Pilih Semester --</option>
				                    	@foreach($semester as $listSemester)
				                    		<option value="{{ $listSemester->id_semester }}">{{ $listSemester->tipe }} ( <?php echo date('Y', strtotime($listSemester->tgl_mulai)).' - '.date('Y', strtotime($listSemester->tgl_selesai)) ?> )</option>
				                    	@endforeach
				                    </select>
			                    @endif

			                    <table style="margin-top: 10px" class="table table-bordered table-responsive">
			                    	<thead>
			                    		<tr>
			                    			<th width="10">
			                    				<input type="checkbox" id="all">
			                    			</th>
			                    			<th>
			                    				Kode Matakuliah
			                    			</th>
			                    			<th>
			                    				Matakuliah
			                    			</th>
			                    			<th>
			                    				Dosen
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
			                    				Kelas
			                    			</th>
			                    			<th>
			                    				SKS
			                    			</th>
			                    		</tr>
			                    	</thead>

			                    	<tbody id="Matkul">
			                    		@if($jadwal > 0)
				                    		@foreach($Matkul as $listMatkul)
											       <tr>
											           <td>
											              <input type="checkbox" class="check" value="{{ $listMatkul->id_matkul }}" name="id_matkul[]">
											           </td>
											           <td>
											              {{ $listMatkul->kode_matkul }}
											           </td>
											           <td>
											              {{ $listMatkul->nama_matkul }}
											           </td>
											           <td>
											              {{ $listMatkul->nama_kelas }}
											           </td>
											           <td>
											              {{ $listMatkul->hari }}
											           </td>
											           <td>
											              {{ date('G:i A', strtotime($listMatkul->jam_mulai)) }}
											           </td>
											           <td>
											              {{ date('G:i A', strtotime($listMatkul->jam_selesai)) }}
											           </td>
											           <td>
											           		{{ $listMatkul->nama_kelas }}
											           </td>
											           <td>
											              {{ $listMatkul->sks }}
											           </td>
											           <input type="hidden" name="id_semester" value="{{ $idSemester }}">
											       </tr>
											@endforeach
										@else
												<tr>
													<td colspan="9" align="center"><i>Tidak ada data</i></td>
												</tr>
										@endif
			                    	</tbody>
			                    </table>
			                    @if($jadwal == 0)
			                    <button name="proses" class="btn btn-sm btn-primary">Proses</button>
			                    @else
			                    	@if(count($Matkul) == 0)
				                    	<i>Matakuliah sudah diisi semua</i>
				                    @else
				                    	<button name="proses" class="btn btn-sm btn-primary">Proses</button>
				                    @endif
			                    @endif
		                    {!! Form::close() !!}
		                </div>
		              </div>
	      			</div>
	      		</div>
	      		
      		<div class="box box-default">
	      			<div class="box-header with-border">
	      				<h3 class="box-title">KRS yang diambil
	              </h3>
	              <p class="pull-right">Jurusan : <strong>{{ $getJurusan->jurusan->nama_jurusan }}</strong></p>
	                <!-- <a href="" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#tambahKelas">Tambah</a> -->
	      			</div>
	            
	      			<div class="box-body">
	      				<div class="row">
			                <div class="col-xs-12">
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
				                    				Dosen
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
				                    				Kelas
				                    			</th>
				                    			<th>
				                    				SKS
				                    			</th>
				                    			<th>
				                    				Aksi
				                    			</th>
				                    		</tr>
				                    	</thead>

				                    	<tbody>
				                    		@if($jadwal > 0)
				                    			@foreach($krs as $viewKRS)
					                    			<tr>
											           <td>
											              {{ $viewKRS->kode_matkul }}
											           </td>
											           <td>
											              {{ $viewKRS->nama_matkul }}
											           </td>
											           <td>
											              {{ $viewKRS->nama }}
											           </td>
											           <td>
											              {{ $viewKRS->hari }}
											           </td>
											           <td>
											              {{ date('G:i A', strtotime($viewKRS->jam_mulai)) }}
											           </td>
											           <td>
											              {{ date('G:i A', strtotime($viewKRS->jam_selesai)) }}
											           </td>
											           <td>
											           	{{ $viewKRS->nama_kelas }}
											           </td>
											           <td>
											              {{ $viewKRS->sks }}
											           </td>
											           <td align="center">
											           	<button class="btn btn-danger btn-sm" data-toggle="modal" data-id="tooltip" data-placement="top" title="Hapus" data-target="#delete_{{ $viewKRS->id_krs }}"><i class="fa fa-trash-o"></i></button>
											           </td>
											       </tr>
											       	<!-- Modal -->
										            <div class="modal" id="delete_{{ $viewKRS->id_krs }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										              <div class="modal-dialog" role="document">
										                <div class="modal-content animated zoomIn">
										                  <div class="modal-header">
										                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										                    <h4 class="modal-title" id="myModalLabel">Tambah Data</h4>
										                  </div>
										                  <div class="modal-body">
										                      Anda Yakin Ingin Menghapus Matakuliah <strong>{{ $viewKRS->nama_matkul }}</strong> dari daftar KRS yang diambil ?
										                  </div>
										                  <div class="modal-footer">
										                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										                    <a href="{{ route('krs.delete', $viewKRS->id_krs) }}" class="btn btn-danger">Hapus</a>
										                  </div>
										                </div>
										              </div>
										            </div>
										       @endforeach
											       <tr>
													    <th colspan="7">
													       <span class="pull-right">Jumlah</span>
													    </th>
													    <th colspan="2">
													       {{ $Sks }}
													    </th>
													</tr>
				                    		@else
				                    			<tr>
				                    				<td colspan="8" align="center"><i>Tidak Ada Data</i></td>
				                    			</tr>
				                    		@endif
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
    	$('#all').click(function(){
    		if ($('#all').prop('checked') == true) {
    			$('.check').prop('checked', true);
    		}else if ($('#all').prop('checked') == false){
    			$('.check').prop('checked', false);
    		}
    	});

    	$('#semester').change(function() {
    		$('#all').prop('checked', false);
          var id = $(this).val();
          var urlname = "{{ url('mahasiswa/getMatkul') }}/" + id;
          $.ajax({
              type: 'GET',
              url: urlname,
              success: function(data) {
                  $('#Matkul').html(data);
              }
          })
      })
    	$('[data-id="tooltip"]').tooltip()
    </script>
@endsection