@extends('template')



@section('main')

<!-- Content Header (Page header) -->

    <section class="content-header">

      <h1>

        Trash Mata Kuliah

      </h1>

      <ol class="breadcrumb">

        <li>Home</li>

        <li>Mata Kuliah</li>

        <li class="active">Trash Mata Kuliah</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

      <div class="row">

      	<div class="col-xs-12">

          @include('_partials.flash_message')

      		<div class="box box-default">

      			<div class="box-header with-border">

      				<h3 class="box-title"><a href="{{ route('admin.matkul') }}" class="text-primary"> Data Mata Kuliah</a> | Trash

              </h3>

      			</div>



      			<div class="box-body">

      				<div class="row">

                <div class="col-xs-12 table-responsive">

                    <table class="table table-striped matkul">

                      <thead>

                        <tr>

                          <th>No</th>

                         <!-- <th>Prodi</th>

                          <th>Semester</th>

                          <th>Jenjang</th>

                          <th>Kompetensi</th>-->

                          <th>Kode Matkul</th>

                          <th>Nama Matkul</th>

                          <th>Aksi</th>

                        </tr>

                      </thead>



                      <tbody>



                      </tbody>

                    </table>

                </div>

              </div>

      			</div>

      		</div>

      	</div>

      </div>

    </section>

    <!-- /.content -->

    <script type="text/javascript">

      $(document).ready(function(){

        $(".matkul").DataTable({

            processing: true,

            serverSide: true,

            ajax: "{{ route('admin.matkul.trash.datatable') }}",

            columns: [

                {'data': 'no'},

               /* {'data': 'prodi'},

                {'data': 'semester'},

                {'data': 'jenjang'},

                {'data': 'kompetensi'},
*/
                {'data': 'kode_matkul'},

                {'data': 'nama_matkul'},

                {'data': 'aksi'},

            ]

        });

      });

    </script>

@stop

