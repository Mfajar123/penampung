<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Form Tambah</h3>
    </div>
    <div class="box-body">

        @foreach($mahasiswa as $siswa)
            <table class="table">
                <tr>
                    <th width="15%">Nim</th>
                    <td width="2%">:</td>
                    <td width="33%">{{$siswa->nim}} <input type="hidden" name="nim" value="{{$siswa->nim}}"></td>
                    <th width="15%">Jenjang</th>
                    <td width="2%">:</td>
                    <td width="33%">{{$siswa->jenjang->nama_jenjang}}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>:</td>
                    <td>{{$siswa->nama}}</td>
                    <th>Program Studi</th>
                    <td>:</td>
                    <td>{{$siswa->prodi->nama_prodi}}</td>
                </tr>
                <tr>
                    <th>Tempat, Tanggal Lahir</th>
                    <td>:</td>
                    <td>{{$siswa->tmp_lahir}}, {{date("d-m-Y", strtotime($siswa->tgl_lahir))}}</td>
                    <th>Tahun Akademik</th>
                    <td>:</td>
                    <td>{{$thn}} <input type="hidden" name="tahun_akademik" value="{{$tahun}}"></td>
                </tr>
                <tr>
                    <th></th>
                    <td></td>
                    <td></td>
                    <th>Semester</th>
                    <td>:</td>
                    <td>{{@$siswa->semester->semester_ke}}<input type="hidden" name="id_semester" value="{{$siswa->id_semester}}"></td>
                </tr>
        @endforeach
            </table>
        <hr>
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {!! Form::select('id_waktu_kuliah', $waktu_kuliah, null,['class' => 'form-control select_waktu', 'placeholder'=>'- Pilih Waktu Kuliah -', 'required']) !!}
            </div>
        </div>
        <hr>
        <table class="table table-striped table-bordered table-hover table-condensed">
            <thead>
                <tr>
                    <th width="30"><center><input type="checkbox" value="" id="all"></center></th>
                    <th><center>Kode Matkul</center></th>
                    <th><center>Nama Matkul</center></th>
                    <th><center>SKS</center></th>
                </tr>
            </thead>
            <tbody class="receiver">
                <!-- @foreach($matkul as $m)
                <tr>
                    <td><center><input type="checkbox" value="{{$m->matkul->sks}}" name="id_matkul[{{$m->id_matkul}}]" class="bancet" id="id_matkul_{{$m->id_matkul}}"></center></td>
                    <td><center>{{$m->matkul->kode_matkul}}</center></td>
                    <td><center>{{$m->matkul->nama_matkul}}</center></td>
                    <td><center>{{$m->matkul->sks}}</center></td>
                </tr>
                @endforeach -->
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Jumlah SKS Yang Diambil<input type="hidden" name="total_sks" id="total_sks" size="2" readonly></th>
                    <!--<th><center><input type="text" name="total_sks" id="total_sks" size="2" readonly></center></th>-->
                    <th><center id="trigger"></center></th>
                </tr>
            </tfoot>
        </table>

        <br>

        <div class="form-group">
            <a href="{{ route('mahasiswa.krs') }}" class="btn btn-default btn-sm"> Kembali</a>
            {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary btn-sm']) !!}
        </div>

    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){

        $('.select_waktu').change(function(){
            $.ajax({
                url : '{{ route('mahasiswa.krs.get_avail_matkul').'?id_waktu_kuliah=' }}' + $(this).val(),
                cache : false,
                success : function(data){
                    $('.receiver').html(data);
                }
            });
        });

        $('.select2').select2();

        $('#all').click(function(){
            if($('.bancet').is(':checked'))
            {
                $('.bancet').prop('checked', false);
                $(this).prop('checked', false);
            }
            else
            {
                $('.bancet').prop('checked', true);
                $(this).prop('checked', true);
            }
            hitung_sks();
        });

        $('.bancet').click(function(){
            hitung_sks();
        })

        function hitung_sks()
        {
            var total_sks = 0;
            $.each($(".bancet"), function (key, val) {
                //console.log(this.id);
                if ($("#"+val.id).is(":checked")) {
                    total_sks += parseInt(val.value);
                }
            });
            $("#trigger").html(total_sks);
            $("#total_sks").val(total_sks);
        }

        $(".bancet").click(function (e) {
            hitung_sks();
        });

    });
</script>