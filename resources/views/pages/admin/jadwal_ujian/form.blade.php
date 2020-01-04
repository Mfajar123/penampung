<div class="form-group">
	{!! Form::label('id_tahun_akademik', 'Tahun Akademik', ['class' =>'control-label']) !!}
	{!! Form::select('id_tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom', 'width' => '100%', 'required']) !!}
</div>

<div class="form-group">
	{!! Form::label('jenis_ujian', 'Jenis Ujian', ['class' => 'control-label']) !!}
	{!! Form::select('jenis_ujian', ['uts' => 'Ujian Tengah Semester (UTS)', 'uas' => 'Ujian Akhir Semester (UAS)', 'remedial' => 'Remedial'], null, ['placeholder' => '- Pilih Jenis Ujian -', 'class' => 'form-control', 'required']) !!}
</div>

<div>

<ul class="nav nav-tabs" role="tablist">
	<!--<li role="presentation" class="active"><a href="#input" aria-controls="input" role="tab" data-toggle="tab">{{ isset($jadwal_ujian) ? 'Edit' : 'Input' }} Data</a></li>-->
	<li role="presentation" class="active"><a href="#upload" aria-controls="upload" role="tab" data-toggle="tab">Upload File</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active" id="upload">
		<p></p>
		<div class="form-group">
			{!! Form::label('file_excel', 'File Excel', ['class' => 'control-label']) !!}
			{!! Form::file('file_excel') !!}
		</div>
	</div>
</div>

{!! Form::submit($btn_submit_text, ['id' => 'btn_submit_form', 'class' => 'btn btn-primary', 'data-loading-text' => 'Loading...']) !!}
<a href="{{ route('admin.jadwal_ujian') }}" class="btn btn-default">Batal</a>

@section ('script')
	<script type="text/javascript">
		function getName(str) {
			var string = '';
			var count = 0;

			for (var i = 0; i < str.length; i++) {
				if (count === 2) {
					if (str[i] === ']') {
						break;
					}
					string += str[i];
				}
				if (str[i] === '[') {
					count++;
				}
			}

			return string;
		}
		
		function getNameCount(str) {
			var string = '';
			var count = 0;

			for (var i = 0; i < str.length; i++) {
				if (count === 3) {
					if (str[i] === ']') {
						break;
					}
					string += str[i];
				}

				if (str[i] === '[') {
					count++;
				}
			}

			return string;
		}

		$(document).ready(function () {
			var count_row = {{ !isset($jadwal_ujian) ? 0 : $jadwal_ujian->jadwal_ujian_detail()->get()->count() }};

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			
			$("#btn_tambah_tanggal").click(function (e) {
				$("<div class='box box-primary'>\
					<div class='box-header with-border'>\
						<div class='pull-right'>\
							<button type='button' class='btn btn-danger btn-xs btn_remove_box_tanggal'><i class='fa fa-remove'></i></button>\
						</div>\
						<div class='clearfix'></div>\
					</div>\
					<div class='box-body'>\
						<div class='form-group'>\
							<input type='date' class='form-control input_tanggal' required />\
						</div>\
						<table class='table table-bordered table-striped'>\
							<thead>\
								<tr>\
									<th>Jam Mulai</th>\
									<th>Jam Selesai</th>\
									<th>Ruang</th>\
									<th>Mata Kuliah</th>\
									<th>Kelas</th>\
									<th>Aksi</th>\
								</tr>\
							</thead>\
							<tbody>\
								<tr>\
									<td colspan='6'><button type='button' class='btn btn-default btn_tambah_jadwal'>Tambah Jadwal</button></td>\
								</tr>\
							</tbody>\
						</table>\
					</div>\
				</div>").appendTo(".box_tanggal");

				e.preventDefault();
			});

			$(".box_tanggal").on("click", ".btn_tambah_jadwal", function (e) {
				var table = $(this).parent().parent();
				var tanggal = $(this).parent().parent().parent().parent().parent().find(".form-group").find("input").val();

				$('<tr data-count-row="'+count_row+'">\
					<td><input type="time" name="tanggal[][jam_mulai][]" class="form-control" /></td>\
					<td><input type="time" name="tanggal[][jam_selesai][]" class="form-control" /></td>\
					<td>{!! Form::select("tanggal[][id_ruang][]", $list_ruang, null, ["class" => "form-control select-custom", "width" => "100%"]) !!}</td>\
					<td>{!! Form::select("tanggal[][id_matkul][]", $list_matkul, null, ["class" => "form-control select-custom", "width" => "100%"]) !!}</td>\
					<td><button type="button" class="btn btn-default btn_tambah_kelas">Tambah Kelas</button></td>\
					<td><button type="button" class="btn btn-danger btn_remove_jadwal"><i class="fa fa-remove"></i></button></td>\
				</tr>').insertBefore(table);

				$.each($(table).parent().find("tr td .form-control"), function (key, val) {
					if (!$(val).hasClass('form-control-kelas')) {
						val.setAttribute('name', 'tanggal['+tanggal+']['+getName(val.name)+'][]');
					} else {
						val.setAttribute('name', 'tanggal['+tanggal+']['+getName(val.name)+']['+getNameCount(val.name)+'][]');
					}
				});

				count_row++;

				$(".select-custom").select2();

				e.preventDefault();
			});

			$(".box_tanggal").on("click", ".btn_remove_box_tanggal", function (e) {
				$(this).parent().parent().parent().remove();
				
				e.preventDefault();
			});

			$(".box_tanggal").on("click", ".btn_remove_jadwal", function (e) {
				$(this).parent().parent().remove();

				e.preventDefault();
			});

			$(".box_tanggal").on("change", ".input_tanggal", function (e) {
				var table = $(this).parent().parent().find("table tbody tr td .form-control");
				var tanggal = $(this).val();

				$.each($(table), function (key, val) {
					if (!$(val).hasClass('form-control-kelas')) {
						val.setAttribute('name', 'tanggal['+tanggal+']['+getName(val.name)+'][]');
					} else {
						val.setAttribute('name', 'tanggal['+tanggal+']['+getName(val.name)+']['+getNameCount(val.name)+'][]');
					}
				});

				e.preventDefault();
			});

			$(".box_tanggal").on("click", ".btn_tambah_kelas", function (e) {
				var td = $(this).parent();
				var tanggal = $(this).parent().parent().parent().parent().parent().find("input.input_tanggal").val();
				var get_count_row = $(this).parent().parent()[0].getAttribute('data-count-row');

				$('<div class="form-group">\
					<div class="input-group">\
						<select class="form-control form-control-kelas select-custom" name="tanggal['+tanggal+'][kelas]['+get_count_row+'][]" style="width: 100%">\
							@foreach ($list_kelas as $key => $val)\
								<option value="{{ $key }}">{{ $val }}</option>\
							@endforeach\
						</select>\
						<div class="input-group-btn">\
							<button type="button" class="btn btn-danger btn_remove_kelas"><i class="fa fa-trash"></i></button>\
						</div>\
					</div>\
				</div>').insertBefore(td.find("button.btn_tambah_kelas"));

				$(".select-custom").select2();

				e.preventDefault();
			});

			$(".box_tanggal").on("click", ".btn_remove_kelas", function(e) {
				$(this).parent().parent().parent().remove();

				e.preventDefault();
			});

			$(document).on('submit', '#frm_buat', function (e) {
				var btn_submit_form = $("#btn_submit_form");

				btn_submit_form.button('loading');

				$.ajax({
					@if (!isset($jadwal_ujian))
						url: "{{ route('admin.jadwal_ujian.simpan') }}",
					@else
						url: "{{ route('admin.jadwal_ujian.update', $jadwal_ujian->id_jadwal_ujian) }}",
					@endif
					type: "POST",
					data: new FormData(this),
					dataType: "JSON",
					processData: false,
        			contentType: false,
					success: function (data) {
						console.log(data);

						if (data.status === 'success') {
							btn_submit_form.button('reset');
							document.location.href = "{{ route('admin.jadwal_ujian') }}";
						}
					}
				});
				
				e.preventDefault();
			});
		});
	</script>
@stop