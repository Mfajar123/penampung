@extends('template')

@section('style')
	<style>
		.select-custom {
			width:300px
		}
		.table {
			margin-bottom: 0px;
		}
	</style>
@stop

@section('main')
<script>
              function load_form(link){
                      var url = "{{ url('mahasiswa/krs/') }}/"+link+"/ulang_mk";
                      $('#kedua_ini').load(url);
                  }

</script>

	<section class="content-header">
		<h1>KRS</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="nav-tabs-custom">
			<div class="nav nav-tabs">
				<li>
					<a href="{{ route('mahasiswa.krs') }}">KRS</a>
					<!-- <a href="#">KRS</a> -->
				</li>
				<li class="active">
					<a href="#">KRS Ulang Mata Kuliah</a>
				</li>
			</div>
			<div class="tab-content">
				<div class="tab-pane active">
					<div class="alert alert-success alert-dismissible alert-slide" role="alert">

				        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>

				        Catatan : <br>SKS yang sedang berjalan adalah {{ $total_sks_ }} ulang {{ $tot_sks_ulang }}<br>Maximal pengambilan SKS adalah 24

				    </div>				
				    <div class="box-body table-responsive no-padding">
					<table class="table table-striped table-bordered table-approve">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th >Kode Mata Kuliah</th>
								<th >Nama Mata Kuliah</th>
								<th align="center">Nilai Huruf</th>
								<th >SKS</th>
								<th >Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $no = 1; ?>
							@foreach($ulang_mk as $list)
							<tr>
								<td align="center">{{ $no }}</td>
								<td>{{ $list->kode_matkul }}</td>
								<td>{{ $list->nama_matkul }}</td>
								<td align="center">{{ $list->huruf }}</td>
								<td align="center">{{ $list->sks }}</td>
								<td align="center">
									<!-- <a href="{{ route('admin.prodi.ubah', $list->kode_matkul) }}" class="btn btn-primary btn-sm" title="Ulang Mata Kuliah"  @if (($list->sks + $total_sks_) > 24) disabled onclick="return false;" @endif><i class="fa fa-check"> Ulang</i></a> -->
									@if ($list->sks_ulang > 0)
										<a href="{{ route('mahasiswa.krs.batal_ulang', $list->id_ulang_mk) }}" onclick="return confirm('Apakah anda yakin?')"  class="btn btn-danger btn-sm" title="Ulang Mata Kuliah"><i class="fa fa-times"> Batal</i></a>
										<!-- Sudah Dipilih -->
									@else
									    @if (($list->sks + $total_sks_ + $tot_sks_ulang) > 24) 
									    	<a href="#" class="btn btn-primary btn-sm" title="Ulang Mata Kuliah" disabled><i class="fa fa-check"> Ulang</i></a>
									    @else
			    					    	<a href="#" onclick="load_form('{{$list->id_matkul}}')" data-toggle="modal" data-target="#kedua" class="btn btn-primary btn-sm" title="Ulang Mata Kuliah"><i class="fa fa-check"> Ulang</i></a>
									    @endif
									@endif
								</td>
							</tr>
							<?php $no++; ?>
							@endforeach
						</tbody>
					</table>
					</div>
				</div>
				<br>
					<a href="{{ route('mahasiswa.krs.ajukan', $max_thn) }}" onclick="return confirm('Apakah anda yakin untuk mengajukan?')" class="btn btn-primary btn-sm" title="Ajukan" @if ($ulang == 0) disabled onclick="return false;" @endif><i class="fa fa-save"> Simpan & Ajukan</i></a>
			</div>
		</div>
	</section>

<div class="modal" id="kedua" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ulang Mata Kuliah</h4>
        <div id="hasil_input"></div>
      </div>
  

    	<form action="{{ url('mahasiswa/krs/add_ulang_mk') }}" method="post" class="jsform form-horizontal" accept-charset="UTF-8" enctype="multipart/form-data">
    
	        <div class="modal-body" id="kedua_ini">



	        </div>
	        
	        <div class="modal-body">
	          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
	          <input type="submit" class="btn btn-success" value="Submit">
	        </div>
      
      	</form>
    </div>
  </div>
</div>

	<!--
	<section class="content">
		@if(empty($pembukaan_krs))
		<div class="alert alert-info alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4><i class="fa fa-info"></i> Info</h4>
			Maaf KRS sudah ditutup.
		</div>
		@endif
		<div class="box box-primary">
			<div class="box-header with-border">
				{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'select-custom']) !!}
				@if (! empty($pembukaan_krs))
					<a href="{{ route('mahasiswa.krs.tambah') }}" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Input KRS</a>
				@endif
			</div>
			<div class="box-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th width="30">No.</th>
								<th nowrap>Kode Mata Kuliah</th>
								<th nowrap>Nama Mata Kuliah</th>
								<th nowrap>SKS</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	-->
@stop

@section('script')
	<script type="text/javascript">
		function get_krs() {
			var tahun_akademik = $("select[name='tahun_akademik']").val();
			var table = $(".table").find("tbody");

			if (tahun_akademik !== '') {
				table.html("<tr><td colspan='4'>Loading...</td></tr>");

				$.ajax({
					type: "POST",
					url: "{{ route('mahasiswa.krs.get_krs') }}",
					data: {'tahun_akademik': tahun_akademik},
					success: function (data) {
						console.log(data);
						table.html("");

						if (data.status === 'success') {
							$.each(data.data.krs_item, function (key, val) {
								$("<tr>\
									<td>"+val.no+"</td>\
									<td>"+val.kode_matkul+"</td>\
									<td>"+val.nama_matkul+"</td>\
									<td>"+val.sks+"</td>\
								</tr>").appendTo(table);
							});

							var status = "";

							if (data.data.status === 'Y') {
								status = "<span class='text-success'>Sudah Disetujui</span> <a href='{{ route('mahasiswa.krs') }}/"+data.data.id_krs+"/print' class='btn btn-primary btn-sm' target='_blank'><i class='fa fa-print'></i> Print KRS</a>";
							} else if (data.data.status === 'N') {
								status = "<span class='text-warning'>KRS Anda ditolak</span><br>Keterangan: <span class='text-danger'>"+data.data.keterangan+"</span> <a href='{{ route('mahasiswa.krs') }}/"+data.data.id_krs+"/edit' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit KRS</a>";
							} else {
								status = "<span class='text-danger'>Menunggu Persetujuan</span><a href=''><i class='fa fa-print'></i> Print</a>";
							}

							$("<tr>\
								<th colspan='3'>Status</th>\
								<th>"+status+"</th>\
							</tr>").appendTo(table);
						} else {
							table.html("<tr><td colspan='4'>"+data.message+"</td></tr>");
						}
					}
				});
			}
		}

		$(document).ready(function () {
			$("select[name='tahun_akademik']").on("change", function (e) {
				get_krs();

				e.preventDefault();
			});
		});
	</script>
@stop