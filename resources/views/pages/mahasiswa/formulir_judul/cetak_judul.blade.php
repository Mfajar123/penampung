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
        <div class="row" align="center">
        <div class="col-md-4 col-xs-2"></div>
        <div class="konten col-md-4 col-xs-8" style="padding:0px 0px; ">
            <span><img src="{{asset('images/logo/ppi.png')}}"  alt="Logo STIE PPI" class="img-responsive"  title="Logo STIE PPI" style="width: 10%; margin: 0px;"></span>
            <div class="bisa">
                <h4 style="color: black; text-align: center; margin-top: 5px; ">FORMULIR PENGAJUAN JUDUL</h4>
                <p style="text-align: center; color: black; padding-top: 5px;">SKRIPSI MAHASISWA<br></p>
            </div> 
        </div>
        <div class="col-md-4 col-xs-2"></div>
    </div><br>

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
            <td width=25px align="center">A.</td>
            <td><b>{{$d->judul1}}</b></td>
        </tr>
        <tr>
            <td width=25px align="center">B.</td>
            <td><b>{{$d->judul2}}<b></td>
        </tr>
            <tr>
            <td width=25px align="center">C.</td>
            <td><b>{{$d->judul3}}<b></td>
        </tr>
        </table>
        <br>
        <table>
                <tr>
                        <td width=180px>Topik/Judul Terpilih adalah</td>
                        <td> : </td>
                        <td align="top"><b>A / B / C </b></td>
                </tr>
        </table><br>
        <table>
                    <tr>
                        <td width=70px>Penulisan terhitung mulai tanggal </td>
                        <td>: _____________________________________________</td>
                </tr>
        </table><br>
        <table>
                    <tr>
                        <td width=70px>Skripsi diharapkan selesai tanggal</td>
                        <td>: _____________________________________________</td>
                    </tr>
        </table>
        <br><br>
        <table>
            <tr>
            <td width="250px"></td>
            <td width="250px"></td>
            <td><b>Tangerang,</b> ___________________</td>
            </tr>

            <tr>
            <td>Menyetujui,<br>Penasehat Akademik</td>
            <td></td>
            <td>Yang Mengajukan,</td>
            </tr>

        </table>
        <br><br><br><br>
        <table>
                <tr>
                <td width="200">________________________<br><b>NIP : </b></td>
                <td width="175"></td>
                <td>________________________<br><b>NIM : {{$d->nim}}</td>
                </tr>
        </table>

 @endforeach
</body>
</html>