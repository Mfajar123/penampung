@extends('template')



@section('main')

    <section class="content-header">

        <h1>Tambah Jadwal</h1>

        <ol class="breadcrumb">

            <li>Home</li>

            <li>Jadwal</li>

            <li class="active">Tambah Jadwal</li>

          </ol>

    </section><!-- /.content-header -->



    <section class="content">

        @include('_partials.flash_message')

        <div class="box">

            <div class="box-header with-border">

                <h3 class="box-title">Form Tambah</h3>

            </div>

            <div class="box-body">

                {!! Form::open(['id' => 'frm_jadwal', 'method' => 'POST', 'files' => 'true']) !!}
                    @include('pages.admin.jadwal.form', ['btnSubmit' => 'Simpan'])
                {!! Form::close() !!}

            </div>

        </div>

    </section><!-- /.content -->
@stop


@section('script')
    <script src="https://cdn.rawgit.com/mgalante/jquery.redirect/master/jquery.redirect.js"></script>
    <script type="text/javascript">
        function get_kelas(id = null) {
            var tahun_akademik = $('.select_tahun_akademik').val();
            var id_prodi = $('.select_prodi').val();
            var id_waktu_kuliah = $('.select_waktu').val();
            var id_semester = $('.select_semester').val();
            var id_kelas = $(".select_kelas");

            var formData = new FormData();

            formData.append('tahun_akademik', tahun_akademik);
            formData.append('id_prodi', id_prodi);
            formData.append('id_waktu_kuliah', id_waktu_kuliah);
            formData.append('id_semester', id_semester);

            id_kelas.html('<option value="">- Pilih Kelas -</option>');

            $.ajax({
                type: "POST",
                url: "{{ route('admin.jadwal.get_kelas') }}",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    if (data.status === 'success') {
                        $.each(data.data, function (key, val) {
                            if (id !== null) {
                                if (val.id_kelas === id) {
                                    id_kelas.append('<option value="'+val.id_kelas+'" selected>'+val.kode_kelas+'</option>');
                                } else {
                                    id_kelas.append('<option value="'+val.id_kelas+'">'+val.kode_kelas+'</option>');
                                }
                            } else {
                                id_kelas.append('<option value="'+val.id_kelas+'">'+val.kode_kelas+'</option>');
                            }
                        });
                    }
                }
            });
        }
        
        $(document).ready(function(){
            $('.select2').select2();

            get_kelas({{ Request::get('id_kelas') }});
            
            $("#frm_jadwal").on("submit", function (e) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.jadwal.simpan') }}",
                    data: $("#frm_jadwal").serialize(),
                    success: function (data) {
                        if (data.status == 'success') {
                            $.redirect("{{ route('admin.jadwal.tambah') }}", {
                                tahun_akademik: data.input.tahun_akademik,
                                id_prodi: data.input.id_prodi,
                                id_waktu_kuliah: data.input.id_waktu_kuliah,
                                id_semester: data.input.id_semester,
                                id_kelas: data.input.id_kelas
                            }, "GET");
                        } else if (data.status == 'error') {
                            alert(data.message);
                        }
                    },
                    error: function (error) {
                        alert("Mohon maaf, terjadi kesalahan.");
                        console.log(error);
                    }
                });

                e.preventDefault();
            });
        });
    </script>
@stop