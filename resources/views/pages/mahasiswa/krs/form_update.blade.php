@if (Auth::guard('mahasiswa')->user()->is_updated_information == 'F')
	<div class="modal fade modal-update" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				{!! Form::model(Auth::guard('mahasiswa')->user(), ['method' => 'POST', 'route' => 'mahasiswa.krs.update_profile']) !!}
					<div class="modal-header">
						<h4 class="modal-title">Update Informasi</h4>
					</div>
					<div class="modal-body">
						<h4>Update Data Profil</h4>
						<hr>
						<div class="form-group">
							{!! Form::label('no_telp', 'No. Telepon', ['class' => 'control-label']) !!}
							{!! Form::text('no_telp', null, ['class' => 'form-control']) !!}
						</div>
						
						<h4>Update Data Alamat</h4>
						<hr>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									{!! Form::label('jalan', 'Jalan/Dusun *', ['class' => 'control-label']) !!}
									{!! Form::text('jalan', null, ['required', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									{!! Form::label('rt', 'RT', ['class' => 'control-label']) !!}
									{!! Form::text('rt', null, ['class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									{!! Form::label('rw', 'RW', ['class' => 'control-label']) !!}
									{!! Form::text('rw', null, ['class' => 'form-control']) !!}
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									{!! Form::label('kelurahan', 'Desa/Kelurahan *', ['class' => 'control-label']) !!}
									{!! Form::text('kelurahan', null, ['required', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('kode_pos', 'Kode Pos', ['class' => 'control-label']) !!}
									{!! Form::text('kode_pos', null, ['class' => 'form-control']) !!}
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('kecamatan', 'Kecamatan *', ['class' => 'control-label']) !!}
									{!! Form::text('kecamatan', null, ['required', 'class' => 'form-control']) !!}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('kota', 'Kota/Kabupaten *', ['class' => 'control-label']) !!}
									{!! Form::text('kota', null, ['required', 'class' => 'form-control']) !!}
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									{!! Form::label('provinsi', 'Provinsi *', ['class' => 'control-label']) !!}
									{!! Form::text('provinsi', null, ['required', 'class' => 'form-control']) !!}
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				{!! Form::close() !!}
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
@endif