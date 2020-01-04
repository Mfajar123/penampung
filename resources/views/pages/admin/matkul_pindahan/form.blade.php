
<div class="form-group">
	{!! Form::label('nim', 'Nama Mahasiswa Pindahan', ['class' => 'control-label']) !!}
	{!! Form::select('nim', $list_nama, null, ['placeholder' => '- Pilih Nama  Mahasiswa Pindahan  -', 'class' => 'form-control select-custom', 'width' => '100%', 'required']) !!}
</div>
	<table class='table table-bordered table-striped'>
		<thead>
			<tr>
				<th>Nama Mata Kuliah</th>
				<th>SKS</th>
				<th>Nilai</th>
				<th>Aksi</th>
			</tr>
		</thead>
		<tbody id="tambah_row">
				<tr>
					<td>
						<Select name="id_matkul[]" id="matkul_1" onchange="getSKS(this)" class=" select-custom form-control" style="width:800px;"  >
							<option value="">- Pilih Matkul -</option>
							@foreach( $list_matkul as $matkul )
								<option value="{{ $matkul->sks }} - {{ $matkul->id_matkul }}" <?php if( @$mp->id_matkul == $matkul->id_matkul ) echo 'selected'; ?>   data="{{ $matkul->sks }}">{{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }}</option>
							@endforeach
						</Select>
					</td>
					<td>
						<input type="text" value="{{ @$mp->sks }}"  placeholder="SKS" name="sks[]" class="sks form-control" id="sks_1">
					</td>
						<td>
						<input type="text" value="{{ @$mp->nilai }}"  placeholder="Nilai" name="nilai[]" class="nilai form-control" id="nilai_1">
					</td>
					<td>
						<button type="button" class="btn btn-danger btn_remove_jadwal" disabled><i class="fa fa-remove" ></i></button>
					</td>
				</tr>
			
			
		</tbody>
			<tr>
				<td colspan='6'><button type='button' class='btn btn-default btn_tambah_field'>Tambah Matkul</button></td>
			</tr>
	</table>

	{!! Form::submit($btn_submit_text, ['id' => 'btn_submit_form', 'class' => 'btn btn-primary', 'data-loading-text' => 'Loading...']) !!}
	<a href="{{ route('admin.matkul_pindahan') }}" class="btn btn-default">Batal</a>
</form>

<div style="display:none;">
	
		<table>	
			<tr id="salin" > 
				<td>
					<Select name="id_matkul[]" id="field_matkul" onchange="getSKS(this)" class=" select-2 form-control" style="width:800px;"  >
						<option value="">- Pilih Matkul -</option>
						@foreach( $list_matkul as $matkul )
					<option value="{{ $matkul->sks }} - {{ $matkul->id_matkul }} "> {{ $matkul->kode_matkul }} - {{ $matkul->nama_matkul }}</option>
						@endforeach
					</Select>
				</td>
				<td>
					<input type="text" value="" placeholder="SKS" name="sks[]" class="sks form-control" id="field_sks">
				</td>
				<td>
					<input type="text" value="" placeholder="Nilai" name="nilai[]" class="nilai form-control" id="field_nilai">
				</td>
			</tr>
		</table>
	</div>
	
@section ('script')
	<script type="text/javascript">

		$(document).ready(function() {
			$('.select-2').select2();

			

			//SCRIPT TAMBAH Baris
			var max_fields 	= 50; //max field yg bisa ditambahkam
			var wrapper 	= $('#tambah_row #baris').length; // filed wrapper
			var add_button	= $('.btn_tambah_field'); // tombol add

			var x 			= 1;

			$(add_button).click(function() {

				$('.select-2').select2('destroy');
				
				var no	=  parseInt($('#nomor_doang').val());
				var data 		= $('#salin').html();

				var next_no = no + 1;


				$('#nomor_doang').val(next_no);

				data = data.replace(new RegExp('field_matkul', 'g'), 'matkul_' + next_no);
				data = data.replace(new RegExp('field_nilai', 'g'), 'nilai_' + next_no);
				data = data.replace(new RegExp('field_sks', 'g'), 'sks_' + next_no);

				if ( x < max_fields) {
					x++;
					$('#xxxxxxx').val('');
					$('#tambah_row').append('<tr id="baris' + next_no + '">' + data +'<td><a href="#" class="btn btn-danger" id="hapus_baris" data-field="' + next_no + '" onclick="hapus_baris(' + next_no + ')"><i class="fa fa-remove"></i></a></td></div>');
					$('.select-2').select2();
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