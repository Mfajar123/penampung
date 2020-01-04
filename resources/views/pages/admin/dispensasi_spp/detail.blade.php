@extends('template')

@section('main')
	<section class="content-header">
		<h1><a href="{{ route('admin.dispensasi_spp.index') }}" title="Kembali"><i class="fa fa-arrow-circle-o-left"></i></a> Detail Dispensasi SPP</h1>
	</section>

	<section class="content">
		<div class="box box-primary">
			<div class="box-header with-border">
				<h4 class="box-title">Detail</h4>
			</div>
			<div class="box-body">
				<table class="table table-striped">
					<tbody>
						<tr>
							<th width="200">NIM</th>
							<td width="10">:</td>
							<td>{{ $mahasiswa->nim }}</td>
						</tr>
						<tr>
							<th>Nama</th>
							<th>:</th>
							<td>{{ $mahasiswa->nama }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</section>
@stop