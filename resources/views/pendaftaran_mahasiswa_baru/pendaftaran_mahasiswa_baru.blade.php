<html>
<head>
    <title>Pendaftaran Mahasiswa Baru</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" href="http://yayasanppi.net/event_ppi/img/ppi.png" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <!-- Dropzone.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.2.0/dropzone.css">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
            folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="http://www.himauntika.org/third_party_perpustakaan/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/androidmaker155/tgl_indonesia/master/assets/css/bootstrap-datetimepicker.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <style>
        body {
            padding-top: 120px;
        }
        .batas {
            padding: 5;
        }
        .navbar-default {
            background-color: #fff;
        }
        .navbar-brand {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        .navbar-brand img {
            height: 50px;
        }
        .card {
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .card form {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <a href="#" class="navbar navbar-brand">
                <img class="img-responsive" src="http://yayasanppi.net/images/logo/yayasanppi.png">
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="col-md-12">
            @include('_partials.flash_message')        
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="card">
                {!! Form::open(['method' => 'POST']) !!}
                    <div class="form-group">
                        <label><i class="fa fa-user"></i> Nama</label>
                        <input type="text" placeholder="Nama" name="nama" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-envelope"></i> Email</label>
                                <input type="email" placeholder="Email" name="email" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-phone"></i> No Telp</label>
                                <input type="text" placeholder="No Telpon / Handphone" name="no_telp" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-map-marker-alt"></i> Alamat</label>
                                <input type="text" placeholder="Alamat" name="alamat" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-map-marker"></i> Provinsi</label>
                                {!! Form::select('id_provinsi', $list_provinsi, null, ['required', 'placeholder' => '- Pilih Provinsi -', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i class="fa fa-transgender"></i> Jenis Kelamin</label>
                        <select name="jenkel" class="form-control">
                            <option value="L">Laki - Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-map-marker"></i> Tempat Lahir</label>
                                <input type="text" placeholder="Tempat Lahir" name="tempat_lahir" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Tanggal Lahir</label>
                                <input type="date" placeholder="Tanggal Lahir" name="tgl_lahir" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-briefcase"></i> Program Studi</label>
                                {!! Form::select('id_prodi', $list_prodi, null, ['required', 'placeholder' => '- Pilih Prodi -', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-clock"></i> Waktu Kuliah</label>
                                {!! Form::select('id_waktu_kuliah', $list_waktu_kuliah, null, ['required', 'placeholder' => '- Pilih Waktu Kuliah -', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-university"></i> Jenjang</label>
                                {!! Form::select('id_jenjang', $list_jenjang, null, ['required', 'placeholder' => '- Pilih Jenjang -', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="fa fa-school"></i> Asal Sekolah</label>
                                <input type="text" placeholder="Asal Sekolah" name="asal_sekolah" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-info btn-block"><i class="fa fa-user-plus "></i> Daftar</button>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="col-md-5">
            <img src="{{ asset('images/kampus_3.png') }}" class="img-responsive">
        </div>
    </div>
</body>
</html>