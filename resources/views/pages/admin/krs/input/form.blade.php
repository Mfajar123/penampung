<div class="form-group">
	{!! Form::label('nim', 'Mahasiswa', ['class' => 'control-label']) !!}
	{!! Form::select('nim', $list_mahasiswa, null, ['id' => 'select_nim', 'placeholder' => '- Pilih Mahasiswa -', 'class' => 'form-control select-custom', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
	{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['id' => 'select_tahun_akademik', 'placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
	{!! Form::select('id_waktu_kuliah', $list_waktu_kuliah, null, ['id' => 'select_waktu_kuliah', 'placeholder' => '- Pilih Waktu Kuliah -', 'class' => 'form-control select-custom', 'required']) !!}
</div>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th width="30">#</th>
				<th nowrap>Kode Matkul</th>
				<th nowrap>Nama Matkul</th>
				<th nowrap>SKS</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>

<div>
	{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('admin.krs.input.index') }}" class="btn btn-default">Batal</a>
</div>

@section('script')
	<script type="text/javascript">
		function get_matkul() {
			var nim = $("#select_nim").val();
			var tahun_akademik = $("#select_tahun_akademik").val();
			var id_waktu_kuliah = $("#select_waktu_kuliah").val();
			var table = $(".table").find("tbody");

			var formData = new FormData();

			formData.append('nim', nim);
			formData.append('tahun_akademik', tahun_akademik);
			formData.append('id_waktu_kuliah', id_waktu_kuliah);

			if (nim !== '' && tahun_akademik !== '' && id_waktu_kuliah !== '') {
				table.html("<tr><td colspan='4'>Loading...</td></tr>")

				$.ajax({
					url: "{{ route('admin.krs.input.get_matkul') }}",
					type: "POST",
					data: formData,
					dataType: "JSON",
					contentType: false,
					processData: false,
					cache: false,
					success: function (data) {
						table.html("");

						$.each(data, function (key, val) {
							$("<tr>\
								<td><input type='checkbox' name='id_matkul[]' value='"+val.id_matkul+"'></td>\
								<td>"+val.kode_matkul+"</td>\
								<td>"+val.nama_matkul+"</td>\
								<td>"+val.sks+"</td>\
							</tr>").appendTo(table);
						});
					},
					error: function (xhr, error) {
						console.log(error);
					}
				});
			}
		}

		$(document).ready(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$("#select_tahun_akademik").on("change", function (e) {
				get_matkul();

				e.preventDefault();
			});
			
			$("#select_waktu_kuliah").on("change", function (e) {
				get_matkul();

				e.preventDefault();
			});

			$("#select_nim").on("change", function (e) {
				get_matkul();

				e.preventDefault();
			});
		});
	</script>
@stop