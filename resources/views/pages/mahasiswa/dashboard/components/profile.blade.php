<div class="box box-primary">
        <div class="box-header with-border">
            <h5 class="box-title">Profile Ku</h5>
        </div>
        <table class="table">
            <tbody>   
                <tr>
                <td><div class="img">
                    <img src="{{ asset('images/mahasiswa/'.Auth::guard('mahasiswa')->user()->foto_profil) }}" class="user-image">
            </div></td>
                {{-- <td><img src="{{asset('../img/')}}"></td> --}}
                <td></td>    
                </tr> 
                <tr>
                    <td width="20"><b>Nim</b></td>
                    <td>:</td>
                    <td><b>{{ Auth::guard('mahasiswa')->user()->nim }}</b></td>
                </tr>

                <tr>
                    <td width="20"><b>Nama</b></td>
                    <td>:</td>
                    <td>{{ Auth::guard('mahasiswa')->user()->nama }}</td>
                </tr>

                <tr>
                    <td width="20"><b>JenKel</b></td>
                    <td>:</td>
                    <td>{{ Auth::guard('mahasiswa')->user()->jenkel }}</td>
                </tr>
                
                <tr>
                    <td width="20"><b>Agama</b></td>
                    <td>:</td>
                    <td>{{ Auth::guard('mahasiswa')->user()->agama }}</td>
                </tr>

                <tr>
                    <td width="20"><b>Alamat</b></td>
                    <td>:</td>
                    <td>{{ Auth::guard('mahasiswa')->user()->alamat }}</td>
                </tr>

                <tr>
                    <td width="20"><b>E-Mail</b></td>
                    <td>:</td>
                    <td>{{ Auth::guard('mahasiswa')->user()->email }}</td>
                </tr>

                <tr>
                    <td width="20"><b>TTL</b></td>
                    <td>:</td>
                    <td>{{ Auth::guard('mahasiswa')->user()->tmp_lahir}},{{ Auth::guard('mahasiswa')->user()->tgl_lahir}}</td>
                </tr>

                
                {{-- @foreach ($list_jadwal as $jadwal)
                    <tr>
                        <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                        <td>{{ $jadwal->kode_matkul }} - {{ $jadwal->nama_matkul }}</td>
                        <td>{{ $jadwal->kode_ruang }} - {{ $jadwal->nama_ruang }}</td>
                    </tr>
                @endforeach --}}
            </tbody>

            <tr>
                <td></td>
            </tr>
        </table>
    </div>