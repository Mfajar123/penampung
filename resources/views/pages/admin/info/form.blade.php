<div class="form-group">
   <!--  {!! Form::label('id_info', 'Id Info', ['class' => 'control-label']) !!} <span>*</span> -->
    {!! Form::hidden('id_info', null, ['class' => 'form-control', 'placeholder' => 'Id Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('judul_info', 'Judul Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::text('judul_info', null, ['class' => 'form-control', 'placeholder' => 'Judul Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="row" id="tambah_row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('foto_info', 'Foto Utama', ['class' => 'control-label']) !!}
            <input type="file" name="foto_utama" id="foto_1">
        </div>
    </div>
</div>

<div class="form-group">
    <td colspan='6'><button type='button' class='btn btn-info btn_tambah_field'>Tambah Upload Foto</button></td>
</div>


<div class="form-group">
    {!! Form::label('ringkasan_info', 'Ringkasan Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::textarea('ringkasan_info', null, ['class' => 'form-control', 'placeholder' => 'Ringkasan Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('isi_info', 'Isi Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::textarea('isi_info', null, ['class' => 'form-control', 'placeholder' => 'Isi Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="form-group">
    {!! Form::label('sumber_info', 'Sumber Info', ['class' => 'control-label']) !!} <!-- <span>*</span> -->
    {!! Form::text('sumber_info', null, ['class' => 'form-control', 'placeholder' => 'Sumber Info', 'autocomplete' => 'off', 'required']) !!}
</div>

<div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::label('id_kategori_info', 'Kategori Info', ['class' => 'control-label']) !!}
                    @if(count($kategori) > 0)
                        {!! Form::select('id_kategori_info', $kategori, null, ['class'=>'form-control selectpicker','id'=>'id_kategori_info', 'placeholder'=>'Pilih Kategori Info', 'data-show-subtext' => 'true', 'data-live-search' => 'true', 'required']) !!}
                    @else
                        <p>Tidak Ada kategori</p>
                    @endif
                </div>
            </div>
<div class="form-group">
    <a href="{{ route('admin.info') }}" class="btn btn-default btn-sm"> Kembali</a>
    {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
</div>

<div style="display:none;">
    <div class="row" id="salin">
        <div class="form-group">
            {!! Form::label('foto_info', 'Foto / File Pendukung', ['class' => 'control-label']) !!}
            <input type="file" name="foto_info[]"  id="field_foto">
        </div>
    </div>
</div>


@section ('script')
	<script type="text/javascript">

		$(document).ready(function() {

			//SCRIPT TAMBAH Baris
			var max_fields 	= 50; //max field yg bisa ditambahkam
			var wrapper 	= $('#tambah_row #baris').length; // filed wrapper
			var add_button	= $('.btn_tambah_field'); // tombol add

			var x 			= 1;

			$(add_button).click(function() {
				
				var no	=  parseInt($('#nomor_doang').val());
				var data 		= $('#salin').html();

				var next_no = no + 1;


				$('#nomor_doang').val(next_no);

				data = data.replace(new RegExp('field_foto', 'g'), 'foto_' + next_no);

				if ( x < max_fields) {
					x++;
					$('#xxxxxxx').val('');
					$('#tambah_row').append('<div class="col-md-6" id="baris' + next_no + '">' + data +'<span><a href="#" class="btn btn-danger" id="hapus_baris" data-field="' + next_no + '" onclick="hapus_baris(' + next_no + ')"><i class="fa fa-remove"></i></a></span></div>');
				}


			});
		});

		function hapus_baris(no){

			$('#baris' + no).remove();

		}

		function getSKS(obj) {
			var id = $(obj).val();

			var $sks = id.substr(0, 1);

			$(obj).parent().parent().find('.sks').val($sks);

		}
	</script>
	<input type="hidden" id="nomor_doang" value="1">
@stop
