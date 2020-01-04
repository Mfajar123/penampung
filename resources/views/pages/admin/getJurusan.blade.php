
    	@foreach($Jurusan as $listJurusan)
            <option value="{{ $listJurusan->id_jurusan }}">{{ $listJurusan->nama_jurusan }}</option>
        @endforeach