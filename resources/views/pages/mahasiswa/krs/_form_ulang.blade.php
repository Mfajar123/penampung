          <div class="form-group">
          <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
            <input type="hidden" name="id_matkul" value="{{ $id_matkul }}">
            <label class="control-label col-sm-4">Maka Kuliah Diulang :</label>
            <div class="col-sm-7">
                <input type="text" class="form-control select-custom" disabled value="{{ $nama_matkul }}">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4">Pilih Waktu :</label>
            <div class="col-sm-7">
            {!! Form::select('jadwal', $jadwal, null, ['placeholder' => '- Pilih Jadwal -', 'class' => 'form-control select-custom', 'required']) !!}
            <!-- <input type="number" class="form-control" name="qty"/> -->
            </div>
          </div>
