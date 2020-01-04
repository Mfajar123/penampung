

<div class="form-group">
	{!! Form::label('nip', 'Dosen PA', ['class' => 'control-label']) !!}
	{!! Form::select('nip', $list_dosen, null, ['placeholder' => '- Pilih Dosen PA -', 'class' => 'form-control select-custom', 'required']) !!}
</div>


<div class="form-group">
	{!! Form::label('tahun_masuk', 'Tahun Masuk', ['class' => 'control-label']) !!}
	{!! Form::select('tahun_masuk', $list_tahun_masuk, null, ['placeholder' => '- Pilih Tahun Masuk -', 'class' => 'form-control select-custom select-tahun-masuk', 'required']) !!}
</div>

<div class="form-group ">
		{!! Form::label('prodi', 'Prodi', ['class' => 'control-label']) !!}  
		{!! Form::select('prodi', $list_prodi, null, ['placeholder' => '- Pilih Prodi -', 'class' => 'form-control select-prodi', 'required' ]) !!}
</div>




<div class="table-responsive">
	<table class="table table-striped table-bordered table-mahasiswa">
		<thead>
			<tr>
				<th width="30"><input type="checkbox" class="checked_all"></th>
				<th nowrap>NIM</th>
				<th nowrap>Nama Mahasiswa</th>
				<th nowrap>Prodi</th>
				<th nowrap>Penasihat Akademik</th>
				<th nowrap>Tempat, Tanggal Lahir</th>
				<th nowrap>Jenis Kelamin</th>
			</tr>
		</thead>
		<tbody>
			
		</tbody>
	</table>
</div>

<div class="">
	{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('admin.dosen.pa.index') }}" class="btn btn-default">Batal</a>
</div>

@section ('script')
	<script type="text/javascript">

	function filter() {
		
		var tahun_masuk = $('.select-tahun-masuk').val();
					
		var prodi = $('.select-prodi').val();
		if (tahun_masuk !== '') {
			var table = $(".table-mahasiswa tbody");

			$(table).html("");

			$("<tr><td colspan='5'>Loading...</td></tr>").appendTo(table);

			$.ajax({
				url: "{{ route('admin.dosen.pa.index') }}/" + tahun_masuk + "/" + prodi + "/get_mahasiswa",
				type: "GET",
				success: function (data) {
					$(table).html("");

					$.each (data, function (key, val) {
						$("<tr>\
							<td><input type='checkbox' name='nim[]' value='"+val['nim']+"'></td>\
							<td>"+val['nim']+"</td>\
							<td>"+val['nama']+"</td>\
							<td>"+val['nama_prodi']+"</td>\
							<td>"+val['dosen']+"</td>\
							<td>"+val['tmp_lahir']+", "+val['tgl_lahir']+"</td>\
							<td>"+val['jenkel']+"</td>\
						</tr>").appendTo(table);
					});
				},
				// error: function (error) {
				// 	alert('Tidak dapat menampilkan data.');
				// 	console.log(error);
				// }
			});
		}
	}

		$(document).ready(function () {
			$(".checked_all").click(function () {
				$("input:checkbox").prop('checked', this.checked);
			});

			$(".select-tahun-masuk").change(function (e) {
				e.preventDefault();
				filter();
			});

			$(".select-prodi").change(function (e) {
				e.preventDefault();
				filter();
			});
		});
	</script>
@stop