@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Data Matkul Pindahan

      </h1>

      <ol class="breadcrumb">

        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>

        <li class="active">Data Matkul Pindahan</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title">Daftar Matkul Pindahan Calon Mahasiswa Pindahan</h3>

      			</div>

            

      		<div class="box-body">
                <div class="container" style="margin: 20px 0px;">
                    <table class="kolom" width="100%" cellspacing="0" style="font-weight:bold;">
                        <tr>
                            <td>Nama  </td>
                            <td> : {{ $dm->nama }}</td>
                            <td>Prodi </td>
                            <td> : {{ $dm->nama_prodi }}</td>
                        </tr>
                        <tr>
                            <td>Status  </td>
                            <td> : {{ $dm->nama_status }}</td>
                            <td>Waktu Kuliah </td>
                            <td> : {{ $dm->nama_waktu_kuliah }}</td>
                        </tr>
                    </table>
                </div>
              <table class="table table-bordered table-striped">

                <thead>

                  <tr>

                    <th>No</th>

                    <th>Nama Matkul</th>

                    <th style="text-align: center;">SKS</th>

                    <th style="text-align: center;">Nilai</th>

                  </tr>

                </thead>

                <?php $no=1; ?>

                <tbody>
                  <?php
                    $total_sks = 0;
                    $total_nilai = 0;
                  ?>
                  @foreach($mp as $m)
                  <?php
                    $total_sks += $m->sks;
                    $total_nilai += $m->nilai;
                  ?>
                    <tr>

                      <td>{{$no++}}</td>

                      <td>{{$m->nama_matkul}}</td>

                      <td align="center">{{$m->sks}}</td>

                      <td align="center">{{$m->nilai}}</td>

                    </tr>

                  @endforeach
                  <tr>
                    <th style="text-align: right;" colspan="2">Total</th>
                    <th style="text-align: center;">{{ $total_sks }}</th>
                    <th style="text-align: center;">{{ $total_nilai }}</th>
                  </tr>
                  <tr>
                    <th style="text-align: right;" colspan="2">Indeks Prestasi Semester</th>
                  </tr>
                </tbody>

              </table>

      			</div>

      		</div>

      	</div>

      </div>

      <a href="{{route('mahasiswa.home')}}" class="btn btn-default">Kembali</a>

    </section>

    <!-- /.content -->

@stop

