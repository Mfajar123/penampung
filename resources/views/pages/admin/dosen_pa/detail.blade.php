@extends ('template')

@section ('main')
	<section class="content-header">
		<h1>Detail Dosen Penasihat Akademik</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Detail Dosen Penasihat</li>
		</ol>
	</section>

	<section class="content">
		
		<div class="box box-default">
			<div class="box-header with-border">
				<h4 class="box-title">Detail</h4>
			</div>

			<div class="box-header with-border">
				<a href="{{ route('admin.dosen.pa.index') }}" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i> Kembali</a>
				<a class="btn btn-primary" data-toggle="modal" href='#modal-filter'><i class="fa fa-filter"></i> Filter</a>
			</div>
			<div class="box-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered datatable">
						<thead>
							<tr>
								<th nowrap>No</th>
								<th nowrap>NIM</th>
								<th nowrap>Nama Mahasiswa</th>
								<th nowrap>Tempat, Tanggal Lahir</th>
								<th nowrap>Tahun Masuk</th>
								<th nowrap>Jenis Kelamin</th>
								<th nowrap>Aksi</th>
							</tr>
						</thead>
						<tbody>
						<?PHP $no = 1; ?>
							@foreach ($list_mahasiswa as $list)
								<tr>
									<td>{{ $no++ }}</td>
									<td>{{ $list->nim }}</td>
									<td>{{ $list->nama }}</td>
									<td>{{ $list->tmp_lahir }}, {{ date('d-M-Y', strtotime($list->tgl_lahir)) }}</td>
									<td>{{ $list->tahun_masuk }}</td>
									<td>{{ $list->jenkel }}</td>
									<td> 
									<a href="{{ route('admin.dosen.pa.hapus_siswa', [ $list->id_detail_penasihat_akademik, $nip  ])  }}"  onclick="return confirm('Apakah anda yakin ingin menghapus mahasiswa dari penasihat ini?');"  class="btn btn-danger btn-sm" title="Hapus"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
	<div class="modal fade" id="modal-filter">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Filter</h4>
          </div>
          {!! Form::open(['id' => 'form_filter', 'method' => 'POST']) !!}
            <div class="modal-body">
              <div class="form-group">
                	{!! Form::label('tahun_masuk', 'Tahun Masuk', ['class' => 'control-label']) !!}
                	{!! Form::select('tahun_masuk', $tm, null, ['class' => 'form-control']) !!}  
                </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">OK</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
@stop