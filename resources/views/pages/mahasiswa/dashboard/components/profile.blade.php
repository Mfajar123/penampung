<div class="box box-primary">
        <div class="box-header with-border">
            <h5 class="box-title"><strong>Profile Ku</strong></h5>
        </div><p>
        <table class="table">
            <tbody>   
                <tr><div class="container">
                    <img src="{{ asset('images/mahasiswa/'.Auth::guard('mahasiswa')->user()->foto_profil) }}" class="user-image" style="max-height: 175px;" >
                </div></tr>

                <br>

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

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        
            
    </div>