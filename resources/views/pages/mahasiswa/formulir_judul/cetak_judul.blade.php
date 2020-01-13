<!DOCTYPE html>
<html>
<head>
	<title>cetak_judul</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
    </style>
         <div class="row"><b>Formulir Pengajuan Judul<b><br>
             <b>Skripsi Mahasiswa<b></tr></div>

        @foreach ($data as $d)

        <table>
            <tr>
                <td>Saya yang bertanda tangan dibawah ini :</td>
            </tr>
        </table><br>
        <table>
            <tr>
                <td width=70px>Nim</td>
                <td>:  <b>{{$d->nim}}<b></td>
            </tr>
            <tr>
                <td width=70px>Nama</td>
                <td>:  <b>{{$d->nama}}<b></td>
            </tr>
            <tr>
                <td width=70px>Prodi</td>
                <td>:  <b>{{$d->prodi}}<b></td>
            </tr>
        </table>
        <br><br>
        <table>
            <tr>
            <td>Dengan Ini Mengajukan Topik/Judul Penelitian sebagai berikut:</td>
            </tr>
        </table><br>
        <table>
        <tr>
            <td width=20px>A.</td>
            <td><b>{{$d->judul1}}</b></td>
        </tr>
        <tr>
            <td width=20px>B.</td>
            <td><b>{{$d->judul2}}<b></td>
        </tr>
            <tr>
            <td width=20px>C.</td>
            <td><b>{{$d->judul3}}<b></td>
        </tr>
        </table>
        <br>
        <table>
                <tr>
                        <td width=70px>Topik/Judul Terpilih adalah</td>
                        <td>: A / B / C</td>
                    </tr>
                    <tr>
                        <td width=70px>Penulisan terhirung mulai tanggal</td>
                        <td>: _____________________________________________</td>
                    </tr>
                    <tr>
                        <td width=70px>Skripsi diharapkan selesai tanggal</td>
                        <td>: _____________________________________________</td>
                    </tr>
        </table>
 @endforeach
</body>
</html>