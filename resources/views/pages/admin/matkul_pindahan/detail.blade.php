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

                    <th>SKS</th>
                    
                    <th>Nilai</th>
                    
                    <th>Aksi</th>

                  </tr>

                </thead>

                <?php
                  $no=1;
                  $nilai_grade = [
                    'A' => 4,
                    'B' => 3,
                    'C' => 2,
                    'D' => 1,
                    'E' => 0
                  ];
                  $total_sks = 0;
                  $total_nilai = 0;
                  $ipk = 0;
                ?>

                <tbody>

                  @foreach($mp as $m)
                    <tr>

                      <td>{{$no++}}</td>

                      <td>{{ $m->kode_matkul . ' - ' . $m->nama_matkul}}</td>

                      <td style="text-align: center">{{ $m->sks }}</td>
                      
                      <td style="text-align: center"> {{ $m->nilai }}</td>
                      
                      <td>  
                        
                        <a href="{{route('admin.matkul_pindahan.ubah', [ $m->id_matkul_pindahan, $m->id_detail_matkul_pindahan, $m->nim ])}}"  class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="{{route('admin.matkul_pindahan.hapus', $m->id_detail_matkul_pindahan)}}"  class="btn btn-danger btn-sm" onclick="return confirm('Apa anda yakin ingin menhapus data ini?');"><i class="fa fa-eraser"></i> Hapus</a>
                      </td>

                    </tr>

                    <?php
                      $total_sks += $m->sks;
                      if (is_numeric($m->nilai)) {
                        $total_nilai += $m->nilai * $m->sks;
                      } else {
                        $total_nilai += @$nilai_grade[$m->nilai] * $m->sks;
                      }
                    ?>

                  @endforeach

                </tbody>

                <tfoot>
                  <tr>
                    <th style="text-align: right;" colspan="2">Total</th>
                    <th style="text-align: center;">{{ $total_sks }}</th>
                    <th colspan="2"></th>
                  </tr>
                  <tr>
                    <th style="text-align: right;" colspan="2">IPK</th>
                    <th style="text-align: center;" colspan="2">{{ ($total_nilai / $total_sks) }}</th>
                    <th></th>
                  </tr>
                </tfoot>

              </table>

      			</div>

      		</div>

      	</div>

      </div>

      <a href="{{route('admin.matkul_pindahan')}}" class="btn btn-default">Kembali</a>

    </section>

    <!-- /.content -->

@stop

