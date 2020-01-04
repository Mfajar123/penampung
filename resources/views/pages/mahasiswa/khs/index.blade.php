@extends('template')

@section('style')
  <style>
    .table {
      margin-bottom: 0px;
      border: 1px solid #000;
    }

    .table thead tr th {
      text-align: center;
    }

    .table thead tr th,
    .table tbody tr td,
    .table tbody tr th {
      border: 1px solid #000;
    }
  </style>
@stop

@section('main')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Kartu Hasil Studi
  </h1>
  <ol class="breadcrumb">
    <li>Home</li>
    <li class="active">Kartu Hasil Studi</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
  	<div class="col-xs-12">
  		<div class="box box-default">
  			<div class="box-header with-border">
          <div class="form-inline">
            <select class="form-control select-custom semester">
              <option>- Pilih Semester -</option>
              @if (Auth::guard('mahasiswa')->check())
              @for($i = 1; $i <= Auth::guard('mahasiswa')->user()->id_semester; $i++)
                <option value="{{ $i }}">Semester {{ $i }}</option>
              @endfor
              @elseif (Auth::guard('wali')->check())
              @for($i = 1; $i <= Auth::guard('wali')->user()->id_semester; $i++)
                <option value="{{ $i }}">Semester {{ $i }}</option>
              @endfor
              @endif
            </select>
          </div>
  			</div>

  			<div class="box-body">
  				<div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="table-responsive" id="data">
                <table class="table table-striped table-bordered">
                  <thead>
                      <tr>
                        <th width="30" rowspan="2">No.</th>
                        <th rowspan="2">Kode</th>
                        <th rowspan="2">Mata Kuliah</th>
                        <th rowspan="2">SKS</th>
                        <th colspan="2">Nilai</th>
                        <th rowspan="2">Angka Mutu</th>
                        <th rowspan="2">Nilai Mutu</th>
                      </tr>
                    <tr>
                      <th>Angka</th>
                      <th>Huruf</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr>
                      <td colspan="9"><center>Tidak Ada Data</center></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
  			</div>

  		</div>
  	</div>
  </div>
</section>

<script type="text/javascript">
  /*$('.tahun').change(function(data){
    var id = $(this).val();
    var url = "{{ url('mahasiswa/hasil-studi/tahun') }}/"+id;

    if(id != '')
    {
      $.ajax({
        type: 'GET',
        url: url,
        success: function(id) {
            $('#data').html(id);
        }
      });
    }
    else
    {
      $('#data').html('<tr><td colspan="6"><center>Tidak Ada Data</center></td></tr>');
    }
  });*/

  $('.semester').change(function(data){
    var id = $(this).val();
    var url = "{{ url('mahasiswa/hasil-studi/semester') }}/"+id;

    if(id != '')
    {
      $("#data").html('Loading...');
      
      $.ajax({
        type: 'GET',
        url: url,
        success: function(id) {
            $('#data').html(id);
        }
      });
    }
    else
    {
      $('#data').html('<tr><td colspan="6"><center>Tidak Ada Data</center></td></tr>');
    }
  });
</script>
@stop
