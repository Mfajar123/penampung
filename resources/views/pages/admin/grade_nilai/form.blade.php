@include ('_partials.flash_message')

<div class="form-group">
	{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
	{!! Form::select('tahun_akademik', $list_tahun_akademik, empty($tahun_akademik) ? NULL : $tahun_akademik, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control', 'required']) !!}
</div>

<div class="table-responsive">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th nowrap>Huruf</th>
				<th nowrap>Nilai Min</th>
				<th nowrap>Nilai Max</th>
				<th nowrap>Bobot</th>
				<th width="50">Aksi</th>
			</tr>
		</thead>
		<tbody>
			@if (isset($list_grade_nilai))
				@foreach ($list_grade_nilai as $list)
					<tr>
						<td>{!! Form::text('huruf[]', $list->huruf, ['placeholder' => 'Contoh : A', 'class' => 'form-control', 'required']) !!}</td>
						<td>{!! Form::text('nilai_min[]', $list->nilai_min, ['placeholder' => 'Contoh : 90', 'class' => 'form-control', 'required']) !!}</td>
						<td>{!! Form::text('nilai_max[]', $list->nilai_max, ['placeholder' => 'Contoh : 100', 'class' => 'form-control', 'required']) !!}</td>
						<td>{!! Form::text('bobot[]', $list->bobot, ['placeholder' => 'Contoh : 4', 'class' => 'form-control', 'required']) !!}</td>
						<td><button type="button" class="btn btn-danger btn-sm btn-remove-grade"><i class="fa fa-remove"></i></button></td>
					</tr>
				@endforeach
			@endif
			<tr>
				<td colspan="5"><button class="btn btn-default btn-add-grade">Tambah Grade</button></td>
			</tr>
		</tbody>
	</table>
</div>

{!! Form::submit($btn_submit_text, ['class' => 'btn btn-primary']) !!}
<a href="{{ route('admin.grade_nilai.index') }}" class="btn btn-default">Batal</a>

@section ('script')
	<script type="text/javascript">
		$(document).ready(function () {
			$(".btn-add-grade").click(function (e) {

				$("<tr>\
					<td><input type='text' name='huruf[]' class='form-control' placeholder='Contoh : A' required /></td>\
					<td><input type='text' name='nilai_min[]' class='form-control' placeholder='Contoh : 90' required /></td>\
					<td><input type='text' name='nilai_max[]' class='form-control' placeholder='Contoh : 100' required /></td>\
					<td><input type='text' name='bobot[]' class='form-control' placeholder='Contoh : 4' required /></td>\
					<td><button type='button' class='btn btn-danger btn-sm btn-remove-grade'><i class='fa fa-remove'></i></button></td>\
				</tr>").insertBefore(".table tbody tr:last-child");

				e.preventDefault();
			});

			$(".table tbody").on("click", ".btn-remove-grade", function (e) {
				
				$(this).parent().parent().remove();

				e.preventDefault();
			});
		});
	</script>
@stop