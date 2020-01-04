@extends ('template')

@section ('main')

	<section class="content-header">
		<h1>Upload SKPI</h1>

		<ol class="breadcrumb">
			<li><a href="#">Home</a></li>
			<li class="active">Upload SKPI</li>
		</ol>
    </section>
    <p>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
          

    <section class="content">
        <body>
            <div class="row">
                <div class="container">
         
                    <h2 class="text-center my-5">Tutorial Laravel #30 : Membuat Upload File Dengan Laravel</h2>
                    
                    <div class="col-lg-8 mx-auto my-5">	
         
                        @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            {{ $error }} <br/>
                            @endforeach
                        </div>
                        @endif
         
                        <form action="/upload/proses" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
         
                            <div class="form-group">
                                <b>Sertifikat Ospek</b><br/>
                                <input type="file" name="file">
                            </div>

                            <div class="form-group">
                                <b>Sertifikat Seminar</b><br/>
                                <input type="file" name="file">
                            </div>

                            <div class="form-group">
                                <b>Sertifikat BNSP</b><br/>
                                <input type="file" name="file">
                            </div>
         
                            <input type="submit" value="Upload" class="btn btn-primary">
                        </form>
                        
                        <h4 class="my-5">Data</h4>
         
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="1%">File</th>
                                    <th>Keterangan</th>
                                    <th width="1%">OPSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($gambar as $g)
                                <tr>
                                    <td><img width="150px" src="{{ url('/data_file/'.$g->file) }}"></td>
                                    <td>{{$g->keterangan}}</td>
                                    <td><a class="btn btn-danger" href="#">HAPUS</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </body>
    </section>
    
    @stop