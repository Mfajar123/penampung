@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Data Kelas

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Data Kelas</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Daftar Mahasiswa Kelas {{$p->kode_kelas}}</h3>

      			</div>

            

      			<div class="box-body">

              <table class="table table-bordered table-striped">

                <thead>

                  <tr>

                    <th>No</th>

                    <th>NIM</th>

                    <th>Nama</th>

                  </tr>

                </thead>

                <?php $no=1; ?>

                <tbody>

                  @foreach($kelas as $k)

                    <tr>

                      <td>{{$no++}}</td>

                      <td>{{$k->nim}}</td>

                      <td>{{$k->nama}}</td>

                    </tr>

                  @endforeach

                </tbody>

              </table>

      			</div>

      		</div>

      	</div>

      </div>

      <a href="{{route('admin.kelas')}}" class="btn btn-default">Kembali</a>

    </section>

    <!-- /.content -->

@stop

