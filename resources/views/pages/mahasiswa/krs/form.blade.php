@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@6.6.2/dist/sweetalert2.min.css">
    <style>.table-mahasiswa{margin-bottom:0px;}</style>
@stop
<div class="box box-primary">
    <div class="box-header with-border">
        <div class="box-title">Form</div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-mahasiswa">
                <tbody>
                    <tr>
                        <th width="200">NIM</th>
                        <td width="5">:</td>
                        <td width="300">{{ $mahasiswa->nim }}</td>
                        <th width="200">Jenjang</th>
                        <td width="5">:</td>
                        <td>{{ $mahasiswa->id_jenjang }}</td>
                    </tr>
                    <tr>
                        <th>Nama</th>
                        <td>:</td>
                        <td>{{ $mahasiswa->nama }}</td>
                        <th>Program Studi</th>
                        <td>:</td>
                        <td>{{ $mahasiswa->prodi->nama_prodi }}</td>
                    </tr>
                    <tr>
                        <th>Tempat, Tanggal Lahir</th>
                        <td>:</td>
                        <td>{{ $mahasiswa->tmp_lahir }}, {{ $mahasiswa->tgl_lahir }}</td>
                        <th>Tahun Akademik</th>
                        <td>:</td>
                        <td>{!! Form::select('tahun_akademik', $list_tahun_akademik, null, ['placeholder' => '- Pilih Tahun Akademik -', 'class' => 'form-control select-custom', 'required']) !!}</td>
                    </tr>
                    <tr>
                        <th>Semester</th>
                        <td>:</td>
                        <td>{{ ! empty($mahasiswa->id_semester) ? $mahasiswa->semester->semester_ke : 'SEMESTER 1' }}</td>
                        <th>Waktu Kuliah</th>
                        <td>:</td>
                        <td>{!! Form::select('id_waktu_kuliah', $list_waktu_kuliah, @Auth::guard('mahasiswa')->user()->id_waktu_kuliah, ['placeholder' => '- Pilih Waktu Kuliah -', 'class' => 'form-control select-custom', 'required']) !!}</td>
                    </tr>
                    <tr id="upload_surat"></tr>
                </tbody>
            </table>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-krs">
                <thead>
                    <tr>
                        <th width="30"><input type="checkbox" id="select-all"></th>
                        <th>Kode Mata Kuliah</th>
                        <th>Nama Mata Kuliah</th>
                        <th>SKS</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th colspan="3">Jumlah SKS yang diambil</th>
                        <th><span id="total_sks">0</span></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        {!! Form::submit($btnSubmit, ['class' => 'btn btn-primary']) !!}
        <a href="{{ route('mahasiswa.krs') }}" class="btn btn-default">Batal</a>
    </div>
</div>

{!! Form::hidden('total_sks') !!}

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@6.6.2/dist/sweetalert2.min.js"></script>
    <script type="text/javascript">
        function hitung_sks() {
            var table = $(".table-krs").find("tbody").find("tr");
            var total_sks = 0;
            
            $.each(table, function (key, val) {
                var input = $(val).find("input[type='checkbox']")[0];
                
                if (input !== undefined && input.checked) {
                    total_sks += parseFloat(input.getAttribute('data-sks'));
                }
            });

            $("#total_sks").html(total_sks);
            $("input[name='total_sks']").val(total_sks);
        }

        function upload_surat() {
            var td_upload_surat = $(".table-mahasiswa").find("tbody").find("tr#upload_surat");
            var id_waktu_kuliah = $("select[name='id_waktu_kuliah']").val();

            $(td_upload_surat).html("");

            if (id_waktu_kuliah == 4) {
                $('\
                    <td colspan="3"></td>\
                    <th>Upload Surat Shift</th>\
                    <td>:</td>\
                    <td>{!! Form::file("file_surat", ["required"]) !!}<small>(JPG/PDF)</small></td>\
                ').appendTo(td_upload_surat);
            }
        }
        
        function get_matkul() {
            var tahun_akademik = $("select[name='tahun_akademik']").val();
            var id_waktu_kuliah = $("select[name='id_waktu_kuliah']").val();
            
            var table = $(".table-krs").find("tbody");

            if (tahun_akademik !== '' && id_waktu_kuliah !== '') {
                table.html("<tr><td colspan='4'>Loading...</td></tr>");
                hitung_sks();

                $.ajax({
                    type: "POST",
                    url: "{{ route('mahasiswa.krs.get_matkul') }}",
                    data: {
                        'tahun_akademik': tahun_akademik,
                        'id_waktu_kuliah': id_waktu_kuliah,
                        'from': '{{ empty($krs) ? 'tambah' : 'edit' }}'
                    },
                    success: function (data) {
                        table.html("");

                        if (data.status === 'success') {
                            if (data.id_status === undefined) {
                                $(".table-krs").html('<thead>\
                                    <tr>\
                                        <th width="30"><input type="checkbox" id="select-all"></th>\
                                        <th>Kode Mata Kuliah</th>\
                                        <th>Nama Mata Kuliah</th>\
                                        <th>SKS</th>\
                                    </tr>\
                                </thead>\
                                <tbody></tbody>\
                                <tfoot>\
                                    <tr>\
                                        <th colspan="3">Jumlah SKS yang diambil</th>\
                                        <th><span id="total_sks">0</span></th>\
                                    </tr>\
                                </tfoot>');

                                $.each(data.jadwal, function (key, val) {
                                    $("<tr>\
                                        <td><input type='checkbox' name='id_matkul[]' value='"+val.id_matkul+"' data-sks='"+val.sks+"'></td>\
                                        <td>"+val.kode_matkul+"</td>\
                                        <td>"+val.nama_matkul+"</td>\
                                        <td>"+val.sks+"</td>\
                                    </tr>").appendTo(".table-krs").find("tbody");
                                });

                                $("input[name='id_matkul[]']").on("change", function (e) {
                                    hitung_sks();

                                    e.preventDefault();
                                });

                                $(document).ready(function () {
                                    hitung_sks();
                                });
                            } else {
                                $(".table-krs").html('<thead>\
                                    <tr>\
                                        <th width="30%">Mata Kuliah</th>\
                                        <th width="30%">Hari</th>\
                                        <th width="30%">Jam</th>\
                                        <th width="100">Aksi</th>\
                                    </tr>\
                                </thead>\
                                <tbody>\
                                    <tr>\
                                        <td colspan="4"><button type="button" class="btn btn-default btn-tambah-matkul">Tambah Matkul</button></td>\
                                    </tr>\
                                </tbody>\
                                <tfoot>\
                                    <tr>\
                                        <th colspan="4">Jumlah SKS yang diambil: <span id="total_sks">0</span></th>\
                                    </tr>\
                                </tfoot>');
                            }
                        } else {
                            table.html("<tr><td colspan='4'>"+data.message+"</td></tr>");
                        }
                    }
                });
            }
        }

        $(document).ready(function () {
            upload_surat();
            get_matkul();

            $('.modal-update').modal({
                backdrop : "static",
                keyboard: false
            });

            $("select[name='tahun_akademik']").on("change", function (e) {
                get_matkul();

                e.preventDefault();
            });
            
            $("select[name='id_waktu_kuliah']").on("change", function (e) {
                e.preventDefault();
                
                get_matkul();
                upload_surat();
            });

            $("#select-all").change(function (e) {
                e.preventDefault();

                if (this.checked) {
                    $(":checkbox").each(function () {
                        this.checked  = true;
                    });
                } else {
                    $(":checkbox").each(function () {
                        this.checked = false;
                    });
                }

                hitung_sks();
            });

            $("form[name='frm_krs']").on("submit", function(e) {
                e.preventDefault();
                var form = $(this);
                
                swal({
                    title: 'Anda yakin ingin menyimpan KRS?',
                    text: "Silahkan cek daftar matkul dan waktu kuliah, apakah sesuai atau tidak",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    form.off("submit").submit();
                }).catch((result) => {
                    console.log(result);
                });
            });

            $(".table-krs").on("click", ".btn-tambah-matkul", function (e) {
                e.preventDefault();
                
                var tahun_akademik = $("select[name='tahun_akademik']").val();
                var id_waktu_kuliah = $("select[name='id_waktu_kuliah']").val();

                $.ajax({
                    url: "{{ route('mahasiswa.krs.get_matkul_pindahan') }}",
                    type: "POST",
                    data: {
                        tahun_akademik: tahun_akademik,
                        id_waktu_kuliah: id_waktu_kuliah
                    },
                    success: function (data) {
                        if (data.status === 'success') {
                            var select_matkul = '';

                            $.each(data.jadwal, function (key, val) {
                                select_matkul += '<option value="'+val.id_matkul+'">'+val.kode_nama+'</option>';
                            });

                            $('<tr>\
                                <td><select name="id_matkul[]" placeholder="- Pilih Mata Kuliah -" required class="form-control select-custom">'+select_matkul+'</select></td>\
                                <td>{!! Form::select("hari[]", [], null, ["required", "class" => "form-control select-custom"]) !!}</td>\
                                <td>{!! Form::select("jam[]", [], null, ["required", "class" => "form-control select-custom"]) !!}</td>\
                                <td><button type="button" class="btn btn-danger btn-hapus-matkul"><i class="fa fa-remove"></i></button></td>\
                            </tr>').insertBefore($(".table-krs").find("tbody tr:last-child"));

                            $(".select-custom").select2();
                        }
                    }
                });
            });

            $(".table-krs").on("click", ".btn-hapus-matkul", function (e) {
                e.preventDefault();

                $(this).parent().parent().remove();
            });

            $(".table-krs").on("change", "select[name='id_matkul[]']", function (e) {
                e.preventDefault();

                var id_matkul = $(this).val();
                var tahun_akademik = $("select[name='tahun_akademik']").val();
                var id_waktu_kuliah = $("select[name='id_waktu_kuliah']").val();
                var hari = $(this).parent().parent().find("select[name='hari[]']");
                var jam = $(this).parent().parent().find("select[name='jam[]']");

                $(hari).html("");
                $(jam).html("");

                if (id_matkul !== '') {
                    $("<option value=''>Loading...</option>").appendTo(hari);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('mahasiswa.krs.get_jadwal') }}",
                        data: {
                            id_matkul: id_matkul,
                            tahun_akademik: tahun_akademik,
                            id_waktu_kuliah: id_waktu_kuliah
                        },
                        success: function (data) {
                            if (data.status === 'success') {
                                $(hari).html("");

                                $("<option value=''>- Pilih Hari -</option>").appendTo(hari);

                                $.each (data.jadwal, function (key, val) {
                                    $("<option value='"+val.hari+"'>"+val.hari+"</option>").appendTo(hari);
                                });
                            }
                        }
                    });
                }
            });

            $(".table-krs").on("change", "select[name='hari[]']", function (e) {
                e.preventDefault();

                var id_matkul = $(this).parent().parent().find("select[name='id_matkul[]']").val();
                var tahun_akademik = $("select[name='tahun_akademik']").val();
                var id_waktu_kuliah = $("select[name='id_waktu_kuliah']").val();
                var hari = $(this).val();
                var jam = $(this).parent().parent().find("select[name='jam[]']");

                $(jam).html("");

                if (hari !== '') {
                    $("<option value=''>Loading...</option>").appendTo(jam);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('mahasiswa.krs.get_jadwal') }}",
                        data: {
                            id_matkul: id_matkul,
                            tahun_akademik: tahun_akademik,
                            id_waktu_kuliah: id_waktu_kuliah,
                            hari: hari
                        },
                        success: function (data) {
                            if (data.status === 'success') {
                                $(jam).html("");

                                $("<option value=''>- Pilih Jam -</option>").appendTo(jam);

                                $.each (data.jadwal, function (key, val) {
                                    $("<option value='"+val.jam_mulai+"-"+val.jam_selesai+"'>"+val.jam_mulai+" - "+val.jam_selesai+"</option>").appendTo(jam);
                                });
                            }
                        }
                    });
                } else {
                    console.log(123);
                }
            });
        });
    </script>
@stop