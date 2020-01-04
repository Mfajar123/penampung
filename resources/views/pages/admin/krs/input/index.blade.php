@extends('template')

@section('main')
	<section class="content-header">
		<h1>Input KRS</h1>
	</section>

	<section class="content">
		@include('_partials.flash_message')
		<div class="box box-default">
			<div class="box-header with-border">
				<a href="{{ route('admin.krs.input.tambah') }}" class="btn btn-primary"><i class="fa fa-pencil"></i> Input KRS</a>
			</div>
			<div class="box-body">
				<p>
					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Filter By</button>
				</p>
				<div class="collapse" id="collapseExample">
					<div class="well">
						{!! Form::open(['id' => 'formFilter', 'method' => 'POST']) !!}
							<div class="form-group">
								{!! Form::label('tahun_akademik', 'Tahun Akademik', ['class' => 'control-label']) !!}
								{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Semua -', 'class' => 'form-control']) !!}
							</div>
							{!! Form::submit('Filter', ['class' => 'btn btn-primary']) !!}
						{!! Form::close() !!}
					</div>
				</div>
				<br>
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th width="30">No.</th>
							<th nowrap>Mahasiswa</th>
							<th nowrap>Dosen PA</th>
							<th nowrap>Tahun Akademik</th>
							<th width="150">Aksi</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</section>
@stop

@section('script')
	<script type="text/javascript">
		$(document).ready(function () {
			var tahun_akademik = $('select[name="tahun_akademik"]').val();
			
			var table = $(".table").DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('admin.krs.input.datatable') }}?tahun_akademik="+tahun_akademik,
				columns: [
					{'data': 'no'},
					{'data': 'nim_nama'},
					{'data': 'nip_nama'},
					{'data': 'tahun_akademik'},
					{'data': 'aksi'},
				]
			});

			$('#formFilter').on('submit', function (e) {
				e.preventDefault();
				var tahun_akademik = $('select[name="tahun_akademik"]').val();

				table.ajax.url("{{ route('admin.krs.input.datatable') }}?tahun_akademik="+tahun_akademik).load();
			});
		});
	</script>
@stop