<div class="form-group">
		<label>Tahun Akademik</label>
		<select class="form-control select2 select_tahun_akademik" onchange="get_kelas()" name="tahun_akademik" required>
			@foreach($tahun_akademik as $tahun)
				<option value="{{$tahun->tahun_akademik}}" {{ (($tahun->tahun_akademik == @$jadwal->tahun_akademik) || ($tahun->tahun_akademik == Request::get('tahun_akademik'))) ? 'selected' : '' }}>{{$tahun->keterangan}}</option>
			@endforeach
		</select>
	</div>
	
	<div class="form-group">
		<label>Program Studi</label>
		<select class="form-control select2 select_prodi" onchange="get_kelas()"  name="id_prodi" required>
			@foreach($prodi as $p)
			<option value="{{$p->id_prodi}}" {{ (($p->id_prodi == @$jadwal->id_prodi) || ($p->id_prodi == Request::get('id_prodi'))) ? 'selected' : '' }}>{{$p->id_prodi}}-{{$p->nama_prodi}}</option>
			@endforeach
		</select>
	</div>
	
	<div class="form-group">
		{!! Form::label('id_waktu_kuliah', 'Waktu Kuliah', ['class' => 'control-label']) !!}
	
		<select class="form-control select2 select_waktu" onchange="get_kelas()" style="width: 100%" name="id_waktu_kuliah" required>
			@foreach($waktu as $w)
			<option value="{{$w->id_waktu_kuliah}}" {{(($w->id_waktu_kuliah == @$jadwal->id_waktu_kuliah) || ($w->id_waktu_kuliah == Request::get('id_waktu_kuliah'))) ? 'selected' : ''}}>{{$w->nama_waktu_kuliah}}</option>
			@endforeach
	
		</select>
	</div>
	
	<div class="form-group">
		<label>Semester</label>
		<select class="form-control select2 select_semester" name="id_semester" onchange="get_kelas()" required>
			@foreach($semester as $s)
			<option value="{{$s->id_semester}}" {{ (($s->id_semester == @$jadwal->id_semester) || ($s->id_semester == Request::get('id_semester'))) ? 'selected' : '' }}>{{$s->semester_ke}}</option>
			@endforeach
		</select>
	</div>
	
	<div class="form-group">
		{!! Form::label('id_kelas', 'Kelas', ['class' => 'control-label']) !!}
		<select class="form-control select2 select_kelas" name="id_kelas" required>
			<option value="">- Pilih Kelas -</option>
		</select>
	</div>
	
	<div class="form-group">
		{!! Form::label('hari', 'Hari', ['class' => 'control-label']) !!}
		{!! Form::select('hari', $hari, null, ['class' => 'form-control select2', 'autocomplete' => 'off']) !!}
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('jam_mulai', 'Jam Mulai', ['class' => 'control-label']) !!}
				{!! Form::time('jam_mulai', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('jam_selesai', 'Jam Selesai', ['class' => 'control-label']) !!}
				{!! Form::time('jam_selesai', null, ['class' => 'form-control', 'autocomplete' => 'off']) !!}
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<label>Mata Kuliah</label>
		<select class="form-control select2" name="id_matkul">
			@foreach($matkul as $m)
				<option value="{{$m->id_matkul}}" {{ ($m->id_matkul == @$jadwal->id_matkul) ? 'selected' : '' }}>{{$m->nama_matkul}}-{{$m->kode_matkul}}-{{$m->sks}}sks</option>
			@endforeach
		</select>
	</div>
	
	<div class="form-group">
		<label>Ruang</label>
		<select class="form-control select2" name="id_ruang">
			@foreach($ruang as $r)
			<option value="{{$r->id_ruang}}" {{ ($r->id_ruang == @$jadwal->id_ruang) ? 'selected' : '' }}>{{$r->kode_ruang}}-{{$r->nama_ruang}}</option>
			@endforeach
		</select>
	</div>
	
	<div class="form-group">
		<label>Dosen</label>
		<select class="form-control select2" name="id_dosen">
			@foreach($dosen as $d)
			<option value="{{$d->id_dosen}}" {{ ($d->id_dosen == @$jadwal->id_dosen) ? 'selected' : '' }}>{{$d->nama}}-{{$d->nip}}</option>
			@endforeach
		</select>
	</div>
	
	{!! Form::submit($btnSubmit, ['class' => 'btn btn-primary']) !!}
	<a href="{{ route('admin.jadwal') }}" class="btn btn-default">Batal</a>