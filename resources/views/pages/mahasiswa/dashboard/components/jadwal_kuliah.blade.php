<div class="box box-warning">
    <div class="box-header with-border">
        <h5 class="box-title">Jadwal Kuliah Hari Ini</h5>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Jam</th>
                <th>Mata Kuliah</th>
                <th>Ruang</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list_jadwal as $jadwal)
                <tr>
                    <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                    <td>{{ $jadwal->kode_matkul }} - {{ $jadwal->nama_matkul }}</td>
                    <td>{{ $jadwal->kode_ruang }} - {{ $jadwal->nama_ruang }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>