<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'web'], function(){
    Route::get('/', function () {
        return view('web.beranda');
    });
    	Route::get('/', 'WebController@index')->name('web.beranda');
	Route::any('/m', 'APIController@index')->name('api');

	/* Jadwal Ujian Detail */
	Route::group(['prefix' => 'jadwal_ujian'], function () {
		Route::get('/{tahun_akademik}/{jenis_ujian}/{waktu}/detail', 'Admin\JadwalUjianController@detail')->name('jadwal_ujian.detail');
	});
	
	Route::group(['prefix' => 'profil'], function(){
		Route::get('/sejarah', 'WebController@sejarah')->name('web.sejarah');
		Route::get('/tentang_kami', 'WebController@tentang_kami')->name('web.tentang_kami');
		Route::get('/visimisi', 'WebController@visimisi')->name('web.visimisi');
	});
	Route::group(['prefix' => 'gallery'],function(){
		Route::get('/semua','WebController@semua_gallery')->name('web.gallery.semua');
	});
	
	Route::group(['prefix' => 'reset'],function(){
	//	Route::get('{id}/reset_password', 'ResetPasswordController@reset_password')->name('admin.reset.reset_password');
		Route::get('/test', 'ResetPasswordController@reset_password')->name('admin.reset.test');
	});
	
	Route::get('/struktur', 'WebController@struktur')->name('web.struktur');
	
	Route::group(['prefix' => 'pendaftaran_mahasiswa'], function () {
		Route::get('/','Pendaftaran_Mahasiswa\pendaftaran_mahasiswaController@pendaftaran');
		Route::post('/','Pendaftaran_Mahasiswa\pendaftaran_mahasiswaController@input_pendaftar');
	});

	Route::group(['prefix' => 'fasilitas'], function(){
		Route::get('/perpustakaan', 'WebController@perpustakaan')->name('web.perpustakaan');
		Route::get('/lab_komputer', 'WebController@lab_komputer')->name('web.lab_komputer');
		Route::get('/masjid', 'WebController@masjid')->name('web.masjid');
		Route::get('/studio_musik', 'WebController@studio_musik')->name('web.studio_musik');
		Route::get('/free_wifi', 'WebController@free_wifi')->name('web.free_wifi');
		Route::get('/atm_center', 'WebController@atm_center')->name('web.atm_center');
		Route::get('/radio_ppi', 'WebController@radio_ppi')->name('web.radio_ppi');
		Route::get('/kantin', 'WebController@kantin')->name('web.kantin');
		Route::get('/ruang_kelas_ac', 'WebController@ruang_kelas_ac')->name('web.ruang_kelas_ac');
	});
	
	Route::get('/kontak', 'WebController@kontak')->name('web.kontak');
	Route::post('/kontak/simpan', 'WebController@simpan')->name('web.simpan');
	Route::group(['prefix' => 'berita'], function(){
		Route::get('/semua', 'WebController@semua_berita')->name('web.berita.semua');
		Route::get('/{id}', 'WebController@berita')->name('web.berita');
	});
	
	Route::group(['prefix' => 'admin'], function(){

		Route::get('login', 'Auth\LoginController@form')->name('admin.login');
		Route::post('login', 'Auth\LoginController@login')->name('admin.login.auth');

		Route::group(['middleware' => 'auth:admin'], function () {
			Route::get('/', 'Admin\DashboardController@index')->name('admin.home');
			Route::get('logout', 'Auth\LoginController@logout')->name('admin.logout');

			Route::group(['prefix' => 'data_pendaftaran_mahasiswa'], function () {
				Route::get('/','Pendaftaran_Mahasiswa\pendaftaran_mahasiswaController@data_pendaftar')->name('pendaftar.data');
				Route::get('/{kd_daftar}/transfer','Pendaftaran_Mahasiswa\pendaftaran_mahasiswaController@transfer')->name('pendaftar.transfer');
			});

			Route::get('ubah-password', 'AdminController@password')->name('admin.password');
			Route::post('ubah-password', 'ProfilController@password')->name('admin.password.ubah');

			Route::group(['prefix' => 'profil'], function(){
				Route::get('/', 'ProfilController@profil')->name('admin.profil');

				Route::get('{id}/ubah', 'ProfilController@ubah')->name('admin.profil.ubah');
				Route::post('{id}/ubah', 'ProfilController@perbarui')->name('admin.profil.perbarui');

				Route::post('ubah-foto', 'ProfilController@foto')->name('admin.profil.foto');
				Route::get('hapus-foto', 'ProfilController@hapus_foto')->name('admin.profil.foto.hapus');
			});

			Route::group(['prefix' => 'pembayaran_spp'], function () {
				Route::get('/datatable', 'Admin\PembayaranSPPController@datatable')->name('admin.pembayaran_spp.datatable');
				Route::get('/', 'Admin\PembayaranSPPController@index')->name('admin.pembayaran_spp');
				Route::get('/transaksi', 'Admin\PembayaranSPPController@transaksi')->name('admin.pembayaran_spp.transaksi');
				Route::get('/{nim}/get_tahun_akademik', 'Admin\PembayaranSPPController@get_tahun_akademik')->name('admin.pembayaran_spp.get_tahun_akademik');
				Route::get('/{id}/hapus_pembayaran_spp', 'Admin\PembayaranSPPController@hapus_pembayaran_spp')->name('admin.pembayaran_spp.hapus');
				Route::get('/{nim}/{id_tahun_akademik}/get_pembayaran_spp', 'Admin\PembayaranSPPController@get_pembayaran_spp')->name('admin.pembayaran_spp.get_pembayaran_spp');
				Route::post('/transaksi', 'Admin\PembayaranSPPController@simpan')->name('admin.pembayaran_spp.simpan');
				Route::post('/add_list_mahasiswa', 'Admin\PembayaranSPPController@add_list_mahasiswa')->name('admin.pembayaran_spp.add_list_mahasiswa');
				Route::post('/get_tahun_akademik_index_page', 'Admin\PembayaranSPPController@get_tahun_akademik_index_page')->name('admin.pembayaran_spp.get_tahun_akademik_index_page');
				Route::post('/get_pembayaran_spp_index_page', 'Admin\PembayaranSPPController@get_pembayaran_spp_index_page')->name('admin.pembayaran_spp.get_pembayaran_spp_index_page');
				Route::post('/simpan_index_page', 'Admin\PembayaranSPPController@simpan_index_page')->name('admin.pembayaran_spp.simpan_index_page');
				Route::get('laporan_pembayaran_spp', 'Admin\PembayaranSPPController@lpspp')->name('admin.pembayaran_spp.lpspp');
				Route::post('laporan_pembayaran_spp', 'Admin\PembayaranSPPController@lpspp')->name('admin.pembayaran_spp.lpspp.submit');
			});

			Route::group(['prefix' => 'mahasiswa'], function(){
				Route::get('/', 'MahasiswaAdminController@index')->name('admin.mahasiswa');
				Route::post('/', 'MahasiswaAdminController@index')->name('admin.mahasiswa.submit');
				Route::get('trash', 'MahasiswaAdminController@trash')->name('admin.mahasiswa.trash');

				Route::get('trash/datatable', 'MahasiswaAdminController@datatable')->name('admin.mahasiswa.trash.datatable');
				Route::get('datatable', 'MahasiswaAdminController@datatable')->name('admin.mahasiswa.datatable');

				Route::get('{id}/disable_spp', 'MahasiswaAdminController@disable_spp')->name('admin.mahasiswa.disable_spp');
				Route::get('{id}/detail', 'MahasiswaAdminController@detail')->name('admin.mahasiswa.detail');
				Route::get('/{type?}', 'MahasiswaAdminController@index')->name('admin.mahasiswa');
			});
			
			Route::group(['prefix' => 'karyawan'], function(){
				Route::get('/', 'AdminController@karyawan')->name('admin.karyawan');
				Route::get('trash', 'KaryawanController@trash')->name('admin.karyawan.trash');

				Route::get('datatable', 'KaryawanController@datatable')->name('admin.karyawan.datatable');
				Route::get('trash/datatable', 'KaryawanController@datatable')->name('admin.karyawan.trash.datatable');

				Route::get('tambah', 'KaryawanController@tambah')->name('admin.karyawan.tambah');
				Route::post('tambah', 'KaryawanController@simpan')->name('admin.karyawan.simpan');
				
				Route::get('{id}/ubah', 'KaryawanController@ubah')->name('admin.karyawan.ubah');
				Route::post('{id}/ubah', 'KaryawanController@perbarui')->name('admin.karyawan.perbarui');

				Route::get('{id}/hak-akses', 'KaryawanController@ubahAkses')->name('admin.karyawan.akses.ubah');
				Route::post('{id}/hak-akses', 'KaryawanController@perbaruiAkses')->name('admin.karyawan.akses.perbarui');

				Route::get('{id}/restore', 'KaryawanController@restore')->name('admin.karyawan.restore');

				Route::get('{id}/hapus', 'KaryawanController@toTrash')->name('admin.karyawan.hapus');
				Route::get('{id}/hapus-permanen', 'KaryawanController@hapus')->name('admin.karyawan.hapus.permanen');

				Route::get('{id}/detail', 'KaryawanController@detail')->name('admin.karyawan.detail');
			});

			Route::group(['prefix' => 'prodi'], function(){
				Route::get('/', 'AdminController@prodi')->name('admin.prodi');

				Route::get('tambah', 'ProdiController@tambah')->name('admin.prodi.tambah');
				Route::post('tambah', 'ProdiController@simpan')->name('admin.prodi.simpan');

				Route::get('{id}/ubah', 'ProdiController@ubah')->name('admin.prodi.ubah');
				Route::post('{id}/ubah', 'ProdiController@perbarui')->name('admin.prodi.perbarui');

				Route::get('{id}/hapus', 'ProdiController@hapus')->name('admin.prodi.hapus');
			});

			Route::group(['prefix' => 'matkul'], function(){
				Route::get('/', 'MatkulController@index')->name('admin.matkul');
				Route::get('trash', 'MatkulController@trash')->name('admin.matkul.trash');

				Route::get('datatable', 'MatkulController@datatable')->name('admin.matkul.datatable');
				Route::get('trash/datatable', 'MatkulController@datatable')->name('admin.matkul.trash.datatable');

				Route::get('tambah', 'MatkulController@tambah')->name('admin.matkul.tambah');
				Route::post('tambah', 'MatkulController@simpan')->name('admin.matkul.simpan');

				Route::get('{id}/ubah', 'MatkulController@ubah')->name('admin.matkul.ubah');
				Route::post('{id}/ubah', 'MatkulController@perbarui')->name('admin.matkul.perbarui');

				Route::get('{id}/restore', 'MatkulController@restore')->name('admin.matkul.restore');

				Route::get('{id}/hapus', 'MatkulController@toTrash')->name('admin.matkul.hapus');
				Route::get('{id}/hapus-permanent', 'MatkulController@hapus')->name('admin.matkul.hapus.permanent');

				Route::get('{id}/detail', 'MatkulController@detail')->name('admin.matkul.detail');
			});
			Route::group(['prefix' => 'grade_nilai'], function () {
				Route::get('/', 'Admin\GradeNilaiController@index')->name('admin.grade_nilai.index');
				Route::get('/tambah', 'Admin\GradeNilaiController@tambah')->name('admin.grade_nilai.tambah');
				Route::get('/{tahun_akademik}/ubah', 'Admin\GradeNilaiController@ubah')->name('admin.grade_nilai.ubah');
				Route::patch('/{tahun_akademik}/ubah', 'Admin\GradeNilaiController@perbarui')->name('admin.grade_nilai.perbarui');
				Route::delete('/{tahun_akademik}/hapus', 'Admin\GradeNilaiController@hapus')->name('admin.grade_nilai.hapus');
				Route::post('/', 'Admin\GradeNilaiController@index')->name('admin.grade_nilai.index.submit');
				Route::post('/tambah', 'Admin\GradeNilaiController@simpan')->name('admin.grade_nilai.simpan');
			});
			Route::group(['prefix' => 'rekap_nilai'], function () {
				Route::get('/', 'Admin\RekapNilaiController@index')->name('admin.rekap_nilai.index');
				Route::get('/print', 'Admin\RekapNilaiController@print')->name('admin.rekap_nilai.print');
			});
			Route::group(['prefix' => 'dosen'], function(){
				Route::get('/', 'AdminController@dosen')->name('admin.dosen');
				Route::get('trash', 'AdminDosenController@trash')->name('admin.dosen.trash');

				Route::get('datatable', 'AdminDosenController@datatable')->name('admin.dosen.datatable');
				Route::get('trash/datatable', 'AdminDosenController@datatable')->name('admin.dosen.trash.datatable');

				Route::get('tambah', 'AdminDosenController@tambah')->name('admin.dosen.tambah');
				Route::post('tambah', 'AdminDosenController@simpan')->name('admin.dosen.simpan');
				
				Route::get('{id}/ubah', 'AdminDosenController@ubah')->name('admin.dosen.ubah');
				Route::post('{id}/ubah', 'AdminDosenController@perbarui')->name('admin.dosen.perbarui');
				
				Route::get('{id}/reset_password', 'AdminDosenController@reset_password')->name('admin.dosen.reset_password');

				Route::get('{id}/hak-akses', 'AdminDosenController@ubahAkses')->name('admin.dosen.akses.ubah');
				Route::post('{id}/hak-akses', 'AdminDosenController@perbaruiAkses')->name('admin.dosen.akses.perbarui');

				Route::get('{id}/restore', 'AdminDosenController@restore')->name('admin.dosen.restore');

				Route::get('{id}/hapus', 'AdminDosenController@toTrash')->name('admin.dosen.hapus');
				Route::get('{id}/hapus-permanent', 'AdminDosenController@hapus')->name('admin.dosen.hapus.permanent');

				Route::get('{id}/detail', 'AdminDosenController@detail')->name('admin.dosen.detail');

			
				Route::group(['prefix' => 'penasihat_akademik'], function () {
					Route::get('/', 'Admin\DosenPAController@index')->name('admin.dosen.pa.index');
					Route::post('/', 'Admin\DosenPAController@index')->name('admin.dosen.pa.submit');
					Route::get('trash', 'Admin\DosenPAController@trash')->name('admin.dosen.pa.trash');

					Route::get('trash/datatable', 'Admin\DosePAController@datatable')->name('admin.dosen.pa.trash.datatable');
					Route::get('datatable', 'Admin\DosenPAController@datatable')->name('admin.dosen.pa.datatable');
					Route::get('/tambah', 'Admin\DosenPAController@tambah')->name('admin.dosen.pa.tambah');
					Route::get('/{nip}/detail', 'Admin\DosenPAController@detail')->name('admin.dosen.pa.detail');
					Route::get('{id}/hapus', 'Admin\DosenPAController@hapus_dosen')->name('admin.dosen.pa.hapus');
					Route::get('{id}/{nip}/hapus_siswa', 'Admin\DosenPAController@hapus_siswa')->name('admin.dosen.pa.hapus_siswa');
					
					
					
					Route::get('/{tahun_masuk}/{prodi}/get_mahasiswa', 'Admin\DosenPAController@get_mahasiswa')->name('admin.dosen.pa.get_mahasiswa');
					Route::post('/tambah', 'Admin\DosenPAController@simpan')->name('admin.dosen.pa.simpan');
					Route::post('/{nip}/detail', 'Admin\DosenPAController@detail')->name('admin.dosen.pa.filter');
				});
			
			});
			Route::group(['prefix' => 'dosen_jabatan'], function(){
				Route::get('/', 'AdminController@dosen_jabatan')->name('admin.dosen_jabatan');
				Route::get('trash', 'AdminDosenJabatanController@trash')->name('admin.dosen_jabatan.trash');

				Route::get('datatable', 'AdminDosenJabatanController@datatable')->name('admin.dosen_jabatan.datatable');
				Route::get('trash/datatable', 'AdminDosenJabatanController@datatable')->name('admin.dosen_jabatan.trash.datatable');

				Route::get('tambah', 'AdminDosenJabatanController@tambah')->name('admin.dosen_jabatan.tambah');
				Route::post('tambah', 'AdminDosenJabatanController@simpan')->name('admin.dosen_jabatan.simpan');
				
				Route::get('{id}/ubah', 'AdminDosenJabatanController@ubah')->name('admin.dosen_jabatan.ubah');
				Route::post('{id}/ubah', 'AdminDosenJabatanController@perbarui')->name('admin.dosen_jabatan.perbarui');

				Route::get('{id}/restore', 'AdminDosenJabatanController@restore')->name('admin.dosen_jabatan.restore');

				Route::get('{id}/hapus', 'AdminDosenJabatanController@toTrash')->name('admin.dosen_jabatan.hapus');
				Route::get('{id}/hapus-permanent', 'AdminDosenJabatanController@hapus')->name('admin.dosen_jabatan.hapus.permanent');
			});
			Route::group(['prefix' => 'ruang'], function(){
				Route::get('/', 'AdminController@ruang')->name('admin.ruang');
				Route::get('trash', 'RuangController@trash')->name('admin.ruang.trash');

				Route::get('datatable', 'RuangController@datatable')->name('admin.ruang.datatable');
				Route::get('trash/datatable', 'RuangController@datatable')->name('admin.ruang.trash.datatable');

				Route::get('tambah', 'RuangController@tambah')->name('admin.ruang.tambah');
				Route::post('tambah', 'RuangController@simpan')->name('admin.ruang.simpan');

				Route::get('{id}/ubah', 'RuangController@ubah')->name('admin.ruang.ubah');
				Route::post('{id}/ubah', 'RuangController@perbarui')->name('admin.ruang.perbarui');
				
				Route::get('{id}/restore', 'RuangController@restore')->name('admin.ruang.restore');

				Route::get('{id}/hapus', 'RuangController@toTrash')->name('admin.ruang.hapus');
				Route::get('{id}/hapus-permanent', 'RuangController@hapus')->name('admin.ruang.hapus.permanent');
			});
			
			
			Route::group(['prefix' => 'info'], function(){
				Route::get('/', 'AdminController@infoweb')->name('admin.info');
				Route::get('trash', 'InfoWebController@trash')->name('admin.info.trash');

				Route::get('datatable', 'InfoWebController@datatable')->name('admin.info.datatable');
				Route::get('trash/datatable', 'InfoWebController@datatable')->name('admin.info.trash.datatable');

				Route::get('tambah', 'InfoWebController@tambah')->name('admin.info.tambah');
				Route::post('tambah', 'InfoWebController@simpan')->name('admin.info.simpan');

				Route::get('{id}/ubah', 'InfoWebController@ubah')->name('admin.info.ubah');

				Route::post('{id}/ubah', 'InfoWebController@perbarui')->name('admin.info.perbarui');
				Route::get('{id}/detail', 'InfoWebController@detail')->name('admin.info.detail');
				Route::get('{id}/restore', 'InfoWebController@restore')->name('admin.info.restore');

				Route::get('{id}/hapus', 'InfoWebController@toTrash')->name('admin.info.hapus');
				Route::get('{id}/hapus-permanent', 'InfoWebController@hapus')->name('admin.info.hapus.permanent');
			});
			
			Route::group(['prefix' => 'pesan'], function(){
				Route::get('/', 'AdminController@pesan')->name('admin.pesan');
				Route::get('trash', 'PesanController@trash')->name('admin.pesan.trash');

				Route::get('datatable', 'PesanController@datatable')->name('admin.pesan.datatable');
				Route::get('trash/datatable', 'PesanController@datatable')->name('admin.pesan.trash.datatable');

				Route::get('{id}/detail', 'PesanController@detail')->name('admin.pesan.detail');
				Route::get('{id}/restore', 'PesanController@restore')->name('admin.pesan.restore');

				Route::get('{id}/hapus', 'PesanController@toTrash')->name('admin.pesan.hapus');
				Route::get('{id}/hapus-permanent', 'PesanController@hapus')->name('admin.pesan.hapus.permanent');
			});
			
			Route::group(['prefix' => 'dispensasi'], function(){
				Route::get('/', 'DispensasiController@index')->name('admin.dispensasi');
				Route::get('trash', 'DispensasiController@trash')->name('admin.dispensasi.trash');
				Route::get('print_all', 'DispensasiController@print_all')->name('admin.dispensasi.print_all');

				Route::get('datatable', 'DispensasiController@datatable')->name('admin.dispensasi.datatable');
				Route::get('trash/datatable', 'DispensasiController@datatable')->name('admin.dispensasi.trash.datatable');

				Route::get('tambah', 'DispensasiController@tambah')->name('admin.dispensasi.tambah');
				Route::post('tambah', 'DispensasiController@simpan')->name('admin.dispensasi.simpan');

				Route::get('{id}/detail', 'DispensasiController@detail')->name('admin.dispensasi.detail');
				Route::get('{id}/print', 'DispensasiController@print')->name('admin.dispensasi.print');
				Route::get('{id}/{dp}/ubah', 'DispensasiController@ubah')->name('admin.dispensasi.ubah');

				Route::post('{id}/{dp}/ubah', 'DispensasiController@perbarui')->name('admin.dispensasi.perbarui');
				Route::get('{id}/restore', 'DispensasiController@restore')->name('admin.dispensasi.restore');

				Route::get('{id}/hapus', 'DispensasiController@toTrash')->name('admin.dispensasi.hapus');
				Route::get('{id}/hapus-permanent', 'DispensasiController@hapus')->name('admin.dispensasi.hapus.permanent');
			});

			
			Route::group(['prefix' => 'pengumuman'], function(){
				Route::get('/', 'AdminController@Pengumuman')->name('admin.pengumuman');
				Route::get('trash', 'PengumumanController@trash')->name('admin.pengumuman.trash');

				Route::get('datatable', 'PengumumanController@datatable')->name('admin.pengumuman.datatable');
				Route::get('trash/datatable', 'PengumumanController@datatable')->name('admin.pengumuman.trash.datatable');

				Route::get('tambah', 'PengumumanController@tambah')->name('admin.pengumuman.tambah');
				Route::post('tambah', 'PengumumanController@simpan')->name('admin.pengumuman.simpan');

				Route::get('{id}/ubah', 'PengumumanController@ubah')->name('admin.pengumuman.ubah');

				Route::post('{id}/ubah', 'PengumumanController@perbarui')->name('admin.pengumuman.perbarui');
				Route::get('{id}/detail', 'PengumumanController@detail')->name('admin.pengumuman.detail');
				Route::get('{id}/restore', 'PengumumanController@restore')->name('admin.pengumuman.restore');

				Route::get('{id}/hapus', 'PengumumanController@toTrash')->name('admin.pengumuman.hapus');
				Route::get('{id}/hapus-permanent', 'PengumumanController@hapus')->name('admin.pengumuman.hapus.permanent');
			});

		
			Route::group(['prefix' => 'cetak_absen'], function(){
				Route::get('/', 'CetakAbsenController@index')->name('admin.cetak_absen');
				Route::post('/', 'CetakAbsenController@submit')->name('admin.cetak_absen.submit');
				Route::get('/{id}/{id_matkul}/{semester}/print', 'CetakAbsenController@print')->name('admin.cetak_absen.print');
				Route::get('/{id}/{id_matkul}/{semester}/detail', 'CetakAbsenController@detail')->name('admin.cetak_absen.kehadiran.detail');
				
				Route::group(['prefix' => 'kehadiran'], function () {
					Route::get('/', 'CetakAbsenController@kehadiran')->name('admin.cetak_absen.kehadiran');
					Route::post('/', 'CetakAbsenController@kehadiran')->name('admin.cetak_absen.kehadiran');
				});

				Route::group(['prefix' => 'alpha'], function () {
					Route::get('/', 'CetakAbsenController@alpha')->name('admin.cetak_absen.alpha');
				});
			});

			Route::group(['prefix' => 'form_peserta_ujian'], function(){
				Route::get('/', 'Admin\FormPesertaUjianController@index')->name('admin.form_peserta_ujian');
				Route::get('/ajax_sub', 'Admin\FormPesertaUjianController@ajax_sub')->name('admin.ajax_sub');
				Route::post('/submit', 'Admin\FormPesertaUjianController@submit')->name('admin.form_peserta_ujian.submit');
				Route::get('/{id}/{id_matkul}/{ju}/print', 'Admin\FormPesertaUjianController@print')->name('admin.form_peserta_ujian.print');
			});


			Route::group(['prefix' => 'kategori_info'], function(){
				Route::get('/', 'AdminController@kategoriinfo')->name('admin.kategori_info');
				Route::get('trash', 'KategoriInfoWebController@trash')->name('admin.kategori_info.trash');

				Route::get('datatable', 'KategoriInfoWebController@datatable')->name('admin.kategori_info.datatable');
				Route::get('trash/datatable', 'KategoriInfoWebController@datatable')->name('admin.kategori_info.trash.datatable');

				Route::get('tambah', 'KategoriInfoWebController@tambah')->name('admin.kategori_info.tambah');
				Route::post('tambah', 'KategoriInfoWebController@simpan')->name('admin.kategori_info.simpan');

				Route::get('{id}/ubah', 'KategoriInfoWebController@ubah')->name('admin.kategori_info.ubah');
				Route::post('{id}/ubah', 'KategoriInfoWebController@perbarui')->name('admin.kategori_info.perbarui');
				
				Route::get('{id}/restore', 'KategoriInfoWebController@restore')->name('admin.kategori_info.restore');

				Route::get('{id}/hapus', 'KategoriInfoWebController@toTrash')->name('admin.kategori_info.hapus');
				Route::get('{id}/hapus-permanent', 'KategoriInfoWebController@hapus')->name('admin.kategori_info.hapus.permanent');
			});

			
			
			
			Route::group(['prefix' => 'promo'], function(){
				Route::get('/', 'AdminController@promo')->name('admin.promo');
				Route::get('trash', 'PromoController@trash')->name('admin.promo.trash');

				Route::get('datatable', 'PromoController@datatable')->name('admin.promo.datatable');
				Route::get('trash/datatable', 'PromoController@datatable')->name('admin.promo.trash.datatable');

				Route::get('tambah', 'PromoController@tambah')->name('admin.promo.tambah');
				Route::post('tambah', 'PromoController@simpan')->name('admin.promo.simpan');

				Route::get('{id}/ubah', 'PromoController@ubah')->name('admin.promo.ubah');
				Route::post('{id}/ubah', 'PromoController@perbarui')->name('admin.promo.perbarui');

				Route::get('{id}/restore', 'PromoController@restore')->name('admin.promo.restore');

				Route::get('{id}/hapus', 'PromoController@toTrash')->name('admin.promo.hapus');
				Route::get('{id}/hapus-permanent', 'PromoController@hapus')->name('admin.promo.hapus.permanent');
			});
			Route::group(['prefix' => 'tahun_akademik'], function(){
				Route::get('/', 'AdminController@tahun_akademik')->name('admin.tahun_akademik');
				Route::get('trash', 'TahunAkademikController@trash')->name('admin.tahun_akademik.trash');

				Route::get('datatable', 'TahunAkademikController@datatable')->name('admin.tahun_akademik.datatable');
				Route::get('trash/datatable', 'TahunAkademikController@datatable')->name('admin.tahun_akademik.trash.datatable');

				Route::get('tambah', 'TahunAkademikController@tambah')->name('admin.tahun_akademik.tambah');
				Route::post('tambah', 'TahunAkademikController@simpan')->name('admin.tahun_akademik.simpan');

				Route::get('{id}/ubah', 'TahunAkademikController@ubah')->name('admin.tahun_akademik.ubah');
				Route::post('{id}/ubah', 'TahunAkademikController@perbarui')->name('admin.tahun_akademik.perbarui');

				Route::get('{id}/restore', 'TahunAkademikController@restore')->name('admin.tahun_akademik.restore');

				Route::get('{id}/hapus', 'TahunAkademikController@toTrash')->name('admin.tahun_akademik.hapus');
				Route::get('{id}/hapus-permanent', 'TahunAkademikController@hapus')->name('admin.tahun_akademik.hapus.permanent');
			});
			
			Route::group(['prefix' => 'kelas'], function(){
				Route::get('/', 'KelasController@index')->name('admin.kelas');
				Route::get('/datatable', 'KelasController@datatable')->name('admin.kelas.datatable');
				Route::get('tambah', 'KelasController@tambah')->name('admin.kelas.tambah');
				Route::get('{id}/ubah', 'KelasController@ubah')->name('admin.kelas.ubah');
				Route::get('{id}/detail', 'KelasController@detail')->name('admin.kelas.detail');
				Route::get('{id}/no_absen', 'KelasController@no_absen')->name('admin.kelas.no_absen');
				Route::delete('{id}/hapus', 'KelasController@hapus')->name('admin.kelas.hapus');
				Route::post('{id}/ubah', 'KelasController@perbarui')->name('admin.kelas.perbarui');
				Route::post('tambah', 'KelasController@simpan')->name('admin.kelas.simpan');
			});
			
			Route::group(['prefix' => 'jadwal'], function(){
				Route::get('/', 'JadwalController@index')->name('admin.jadwal');
				Route::get('/datatable', 'JadwalController@datatable')->name('admin.jadwal.datatable');
				Route::get('/tambah', 'JadwalController@tambah')->name('admin.jadwal.tambah');
				Route::get('/{id}/ubah', 'JadwalController@ubah')->name('admin.jadwal.ubah');
				Route::delete('/{id}/hapus', 'JadwalController@hapus')->name('admin.jadwal.hapus');
				Route::patch('/{id}/ubah', 'JadwalController@perbarui')->name('admin.jadwal.perbarui');
				Route::post('/tambah', 'JadwalController@simpan')->name('admin.jadwal.simpan');
				Route::post('/get_kelas', 'JadwalController@get_kelas')->name('admin.jadwal.get_kelas');
			});
			
			Route::group(['prefix' => 'kategori-pembayaran'], function(){
				Route::group(['prefix' => 'kelulusan'], function(){
					Route::get('/', 'AdminController@kategori_pembayaran_kelulusan')->name('admin.pembayaran');
					Route::get('trash', 'KategoriPembayaranController@trash')->name('admin.pembayaran.trash');

					Route::get('datatable', 'KategoriPembayaranController@datatable')->name('admin.pembayaran.datatable');
					Route::get('datatable/trash', 'KategoriPembayaranController@datatable')->name('admin.pembayaran.trash.datatable');

					Route::get('tambah', 'KategoriPembayaranController@tambah')->name('admin.pembayaran.tambah');
					Route::post('tambah', 'KategoriPembayaranController@simpan')->name('admin.pembayaran.simpan');

					Route::get('{id}/ubah', 'KategoriPembayaranController@ubah')->name('admin.pembayaran.ubah');
					Route::post('{id}/ubah', 'KategoriPembayaranController@perbarui')->name('admin.pembayaran.perbarui');

					Route::get('{id}/restore', 'KategoriPembayaranController@restore')->name('admin.pembayaran.restore');
					Route::get('{id}/hapus', 'KategoriPembayaranController@toTrash')->name('admin.pembayaran.hapus');
					Route::get('{id}/hapus-permanen', 'KategoriPembayaranController@hapus')->name('admin.pembayaran.hapus.permanen');
				});

				Route::group(['prefix' => 'pindahan'], function(){
					Route::get('/', 'AdminController@kategori_pembayaran_pindahan')->name('admin.pembayaran.pindahan');
					Route::get('trash', 'BiayaPindahanController@trash')->name('admin.pembayaran.pindahan.trash');

					Route::get('datatable', 'BiayaPindahanController@datatable')->name('admin.pembayaran.pindahan.datatable');
					Route::get('datatable/trash', 'BiayaPindahanController@datatable')->name('admin.pembayaran.pindahan.trash.datatable');
			
					Route::get('tambah', 'BiayaPindahanController@tambah')->name('admin.pembayaran.pindahan.tambah');
					Route::post('tambah', 'BiayaPindahanController@simpan')->name('admin.pembayaran.pindahan.simpan');

					Route::get('{id}/ubah', 'BiayaPindahanController@ubah')->name('admin.pembayaran.pindahan.ubah');
					Route::post('{id}/ubah', 'BiayaPindahanController@perbarui')->name('admin.pembayaran.pindahan.perbarui');

					Route::get('{id}/restore', 'BiayaPindahanController@restore')->name('admin.pembayaran.pindahan.restore');
					Route::get('{id}/hapus', 'BiayaPindahanController@toTrash')->name('admin.pembayaran.pindahan.hapus');
					Route::get('{id}/hapus-permanen', 'BiayaPindahanController@hapus')->name('admin.pembayaran.pindahan.hapus.permanen');
				});
			});
			
			Route::group(['prefix' => 'm_pindahan'], function(){
				Route::get('/', 'PendaftaranPindahanController@index')->name('admin.daftar.pindahan');
				Route::get('trash', 'PendaftaranPindahanController@trash')->name('admin.daftar.pindahan.trash');

				Route::get('trash/datatable', 'PendaftaranPindahanController@datatable')->name('admin.daftar.pindahan.trash.datatable');
				Route::get('datatable', 'PendaftaranPindahanController@datatable')->name('admin.daftar.pindahan.datatable');

				Route::get('tambah', 'PendaftaranPindahanController@tambah')->name('admin.daftar.pindahan.tambah');
				Route::post('tambah', 'PendaftaranPindahanController@simpan')->name('admin.daftar.pindahan.simpan');
				
				Route::get('{id}/print', 'PendaftaranPindahanController@print')->name('admin.daftar.pindahan.print');
				
				Route::get('{id}/ubah', 'PendaftaranPindahanController@ubah')->name('admin.daftar.pindahan.ubah');
				Route::post('{id}/ubah', 'PendaftaranPindahanController@perbarui')->name('admin.daftar.pindahan.perbarui');

				Route::get('{id}/restore', 'PendaftaranPindahanController@restore')->name('admin.daftar.pindahan.restore');

				Route::get('{id}/hapus', 'PendaftaranPindahanController@toTrash')->name('admin.daftar.pindahan.hapus');
				Route::get('{id}/hapus-permanen', 'PendaftaranPindahanController@hapus')->name('admin.daftar.pindahan.hapus.permanen');

				Route::get('{id}/pembayaran', 'PendaftaranPindahanController@pembayaran')->name('admin.daftar.pindahan.pembayaran');
				Route::post('{id}/pembayaran', 'PendaftaranPindahanController@ubah_pembayaran')->name('admin.daftar.pindahan.pembayaran.perbarui');
			});

			Route::group(['prefix' => 'pendaftaran'], function(){
				Route::get('/', 'PendaftaranController@index')->name('admin.daftar');
				Route::get('trash', 'PendaftaranController@trash')->name('admin.daftar.trash');

				Route::get('trash/datatable', 'PendaftaranController@datatable')->name('admin.daftar.trash.datatable');
				Route::get('datatable', 'PendaftaranController@datatable')->name('admin.daftar.datatable');
				
				Route::get('laporan_jumlah_pendaftar', 'PendaftaranController@ljp')->name('admin.daftar.ljp');
				Route::post('laporan_jumlah_pendaftar', 'PendaftaranController@ljp')->name('admin.daftar.ljp.submit');

				Route::get('{id}/laporan_biaya_pendaftaran', 'PendaftaranController@lbp')->name('admin.daftar.lbp');
				Route::post('{id}/laporan_biaya_pendaftaran', 'PendaftaranController@lbp')->name('admin.daftar.lbp.submit');

				Route::get('tambah', 'PendaftaranController@tambah')->name('admin.daftar.tambah');
				Route::post('tambah', 'PendaftaranController@simpan')->name('admin.daftar.simpan');
				
				Route::get('{id}/print', 'PendaftaranController@print')->name('admin.daftar.print');
				
				Route::get('{id}/ubah', 'PendaftaranController@ubah')->name('admin.daftar.ubah');
				Route::post('{id}/ubah', 'PendaftaranController@perbarui')->name('admin.daftar.perbarui');

				Route::get('{id}/restore', 'PendaftaranController@restore')->name('admin.daftar.restore');

				Route::get('{id}/hapus', 'PendaftaranController@toTrash')->name('admin.daftar.hapus');
				Route::get('{id}/hapus-permanen', 'PendaftaranController@hapus')->name('admin.daftar.hapus.permanen');

				Route::get('{id}/pembayaran', 'PendaftaranController@pembayaran')->name('admin.daftar.pembayaran');
				Route::post('{id}/pembayaran', 'PendaftaranController@ubah_pembayaran')->name('admin.daftar.pembayaran.perbarui');

				Route::group(['prefix' => 'baru'], function(){
					Route::group(['prefix' => 'nilai-mahasiswa'], function(){
						Route::get('/', 'AdminController@nilai')->name('admin.nilai');
						Route::get('datatable', 'NilaiTestController@datatable')->name('admin.nilai.datatable');

						Route::get('{id}/ubah', 'NilaiTestController@nilai')->name('admin.nilai.ubah');
						Route::post('{id}/ubah', 'NilaiTestController@perbarui')->name('admin.nilai.perbarui');
					});

				Route::group(['prefix' => 'pembayaran-kelulusan'], function(){
						Route::get('/', 'AdminController@pembayaran_kelulusan')->name('admin.pembayaran_kelulusan');
						Route::get('datatable', 'PendaftaranPembayaranController@datatable')->name('admin.pembayaran_kelulusan.datatable');

						Route::get('{id}/{dp}/{dpd}/detail', 'PendaftaranPembayaranController@detail')->name('admin.pembayaran_kelulusan.detail');
						Route::get('{id}/{dp}/bayar', 'PendaftaranPembayaranController@bayar')->name('admin.pembayaran_kelulusan.bayar');
						Route::get('{id}/{dp}/print', 'PendaftaranPembayaranController@print')->name('admin.pembayaran_kelulusan.print');
						Route::get('{id}/{dp}/{dpd}/hapus', 'PendaftaranPembayaranController@hapus')->name('admin.pembayaran_kelulusan.hapus');
						Route::get('{id}/{dp}/dispensasi', 'PendaftaranPembayaranController@dispensasi')->name('admin.pembayaran_kelulusan.dispensasi');
						Route::post('{id}/{dp}/dispensasi', 'PendaftaranPembayaranController@dispen')->name('admin.pembayaran_kelulusan.dispen');
						Route::get('{id}/{dp}/dispensasi/print', 'PendaftaranPembayaranController@dispensasi_print')->name('admin.pembayaran_kelulusan.dispensasi.print');
						
						Route::get('{id}/laporan_keuangan_kelulusan', 'PendaftaranPembayaranController@lkk')->name('admin.pembayaran.lkk');

						Route::post('{id}/{dp}/bayar', 'PendaftaranPembayaranController@perbarui')->name('admin.pembayaran_kelulusan.perbarui');
					});


					Route::group(['prefix' => 'registrasi-mahasiswa'], function(){
						Route::get('/', 'RegistrasiMahasiswaController@index')->name('admin.registrasi');
						/* cpenk add */
						Route::get('{id}/batal_regis', 'RegistrasiMahasiswaController@batal_regis')->name('admin.registrasi.batal_regis');
						/* end */
						Route::post('/', 'RegistrasiMahasiswaController@index')->name('admin.registrasi.submit');
						Route::get('datatable', 'RegistrasiMahasiswaController@datatable')->name('admin.registrasi.datatable');

						Route::get('{id}/registrasi', 'RegistrasiMahasiswaController@registrasi')->name('admin.registrasi.index');
						Route::post('{id}/registrasi', 'RegistrasiMahasiswaController@perbarui')->name('admin.registrasi.action');
						Route::get('/laporan_kelas', 'RegistrasiMahasiswaController@laporan_kelas')->name('admin.registrasi.laporan_kelas');
					});
					
					Route::group(['prefix' => 'matkul_pindahan'], function () {
						Route::get('/', 'MatkulPindahanController@index')->name('admin.matkul_pindahan');
						Route::get('/datatables', 'MatkulPindahanController@datatables')->name('admin.matkul_pindahan.datatables');
						Route::get('/buat', 'MatkulPindahanController@buat')->name('admin.matkul_pindahan.buat');
						Route::get('/{id}/{nim}/detail', 'MatkulPindahanController@detail')->name('admin.matkul_pindahan.detail');
						Route::get('/ubah/{imp}/{idmp}/{nim}', 'MatkulPindahanController@ubah')->name('admin.matkul_pindahan.ubah');
						Route::get('/{id}/destroy', 'MatkulPindahanController@destroy')->name('admin.matkul_pindahan.destroy');
						Route::get('/{id}/hapus', 'MatkulPindahanController@hapus')->name('admin.matkul_pindahan.hapus');
						Route::post('/perbarui/{imp}/{idmp}/{nim}', 'MatkulPindahanController@perbarui')->name('admin.matkul_pindahan.perbarui');
						Route::post('/buat', 'MatkulPindahanController@simpan')->name('admin.matkul_pindahan.simpan');
					});
				});

				Route::group(['prefix' => 'pindahan'], function(){
					Route::group(['prefix' => 'transkrip-nilai'], function(){
						Route::get('/', 'AdminController@transkrip_nilai_pindahan')->name('admin.pindahan.nilai');
						Route::get('datatable', 'TranskripNilaiPindahanController@datatable')->name('admin.pindahan.nilai.datatable');

						Route::get('{id}/ubah', 'TranskripNilaiPindahanController@nilai')->name('admin.pindahan.nilai.ubah');
						Route::post('{id}/ubah', 'TranskripNilaiPindahanController@perbarui')->name('admin.pindahan.nilai.perbarui');
						Route::get('{id}/ubah/{str}', 'TranskripNilaiPindahanController@autocomplete');
					});

					Route::group(['prefix' => 'pembayaran-masuk'], function(){
						Route::get('/', 'AdminController@pembayaran_masuk_pindahan')->name('admin.pindahan.pembayaran');
						Route::get('datatable', 'PendaftaranPembayaranPindahanController@datatable')->name('admin.pindahan.pembayaran.datatable');

						Route::get('{id}/update_nominal', 'PendaftaranPembayaranPindahanController@update_nominal')->name('admin.pindahan.pembayaran.update_nominal');
						Route::get('{id}/bayar', 'PendaftaranPembayaranPindahanController@detail')->name('admin.pindahan.pembayaran.detail');
						Route::get('{id}/print', 'PendaftaranPembayaranPindahanController@print')->name('admin.pindahan.pembayaran.kwitansi');
						Route::post('{id}/bayar', 'PendaftaranPembayaranPindahanController@perbarui')->name('admin.pindahan.pembayaran.perbarui');
						Route::post('{id}/update_nominal', 'PendaftaranPembayaranPindahanController@perbarui_nominal')->name('admin.pindahan.pembayaran.perbarui_nominal');
					});

					Route::group(['prefix' => 'registrasi-mahasiswa'], function(){
						Route::get('/', 'AdminController@regis_pindahan')->name('admin.pindahan.registrasi');
						Route::get('datatable', 'RegistrasiMahasiswaPindahanController@datatable')->name('admin.pindahan.registrasi.datatable');

						Route::get('{id}/registrasi', 'RegistrasiMahasiswaPindahanController@registrasi')->name('admin.pindahan.registrasi.index');
						Route::post('{id}/registrasi', 'RegistrasiMahasiswaPindahanController@perbarui')->name('admin.pindahan.registrasi.action');
					});
					
					Route::group(['prefix' => 'matkul_pindahan'], function () {
						Route::get('/', 'MatkulPindahanController@index')->name('admin.matkul_pindahan');
						Route::get('/datatables', 'MatkulPindahanController@datatables')->name('admin.matkul_pindahan.datatables');
						Route::get('/buat', 'MatkulPindahanController@buat')->name('admin.matkul_pindahan.buat');
						Route::get('/{id}/{kd}/detail', 'MatkulPindahanController@detail')->name('admin.matkul_pindahan.detail');
						Route::get('/{id}/edit', 'MatkulPindahanController@edit')->name('admin.matkul_pindahan.edit');
						Route::get('/{id}/destroy', 'MatkulPindahanController@destroy')->name('admin.matkul_pindahan.destroy');
						Route::post('/{id}/edit', 'MatkulPindahanController@update')->name('admin.matkul_pindahan.update');
						Route::post('/buat', 'MatkulPindahanController@simpan')->name('admin.matkul_pindahan.simpan');
					});
				});
			});
			Route::group(['prefix' => 'jadwal_ujian'], function () {
				Route::get('/', 'Admin\JadwalUjianController@index')->name('admin.jadwal_ujian');
				Route::get('/datatables', 'Admin\JadwalUjianController@datatables')->name('admin.jadwal_ujian.datatables');
				Route::get('/buat', 'Admin\JadwalUjianController@buat')->name('admin.jadwal_ujian.buat');
				Route::get('/{id}/edit', 'Admin\JadwalUjianController@edit')->name('admin.jadwal_ujian.edit');
				Route::get('/{id}/destroy', 'Admin\JadwalUjianController@destroy')->name('admin.jadwal_ujian.destroy');
				Route::post('/{id}/edit', 'Admin\JadwalUjianController@update')->name('admin.jadwal_ujian.update');
				Route::post('/buat', 'Admin\JadwalUjianController@simpan')->name('admin.jadwal_ujian.simpan');
			});
			Route::group(['prefix' => 'setting'], function () {
				Route::group(['prefix' => 'semester'], function () {
					Route::get('/', 'Admin\SemesterController@index')->name('admin.setting.semester.index');
					Route::post('/', 'Admin\SemesterController@submit')->name('admin.setting.semester.submit');
				});

				Route::group(['prefix' => 'pembukaan_krs'], function () {
					Route::get('/', 'Admin\PembukaanKrsController@index')->name('admin.setting.pembukaan_krs.index');
					Route::get('/tambah', 'Admin\PembukaanKrsController@tambah')->name('admin.setting.pembukaan_krs.tambah');
					Route::get('/{id}/edit', 'Admin\PembukaanKrsController@edit')->name('admin.setting.pembukaan_krs.edit');
					Route::patch('/{id}/edit', 'Admin\PembukaanKrsController@perbarui')->name('admin.setting.pembukaan_krs.perbarui');
					Route::delete('/{id}/hapus', 'Admin\PembukaanKrsController@hapus')->name('admin.setting.pembukaan_krs.hapus');
					Route::post('/tambah', 'Admin\PembukaanKrsController@simpan')->name('admin.setting.pembukaan_krs.simpan');
				});

	            Route::group(['prefix' => 'menu'], function () {
	                Route::get('/', 'Admin\MenuController@index')->name('menu.index');
	                Route::post('/simpan', 'Admin\MenuController@simpan')->name('menu.simpan');
	                Route::patch('/{id}/perbarui', 'Admin\MenuController@perbarui')->name('menu.perbarui');
	                Route::get('/{id}/edit', 'Admin\MenuController@edit')->name('menu.edit');
	                Route::get('/{id}/restore', 'Admin\MenuController@restore')->name('menu.restore');
	                Route::get('/{id}/hapus', 'Admin\MenuController@hapus')->name('menu.hapus');
	                Route::post('/save_position', 'Admin\MenuController@save_position')->name('menu.save_position');
	            });
	            
	            Route::group(['prefix' => 'role'], function () {
	                Route::get('/datatables', 'Admin\RoleController@datatables')->name('role.datatables');
	                Route::get('/', 'Admin\RoleController@index')->name('role.index');
	                Route::get('/{id}/edit', 'Admin\RoleController@edit')->name('role.edit');
	                Route::patch('/{id}/edit', 'Admin\RoleController@perbarui')->name('role.perbarui');
	                Route::delete('{id}/hapus', 'Admin\RoleController@hapus')->name('role.hapus');
	                Route::post('/simpan', 'Admin\RoleController@simpan')->name('role.simpan');
	                Route::get('/role_edit/{id}', 'Admin\RoleController@role_edit')->name('role_link.set');
	                Route::post('/role_edit/{id}', 'Admin\RoleController@save_role')->name('role_link.save_role');
	            });

				Route::group(['prefix' => 'pembukaan_input_nilai'], function () {
					Route::get('/', 'Admin\PembukaanInputNilaiController@index')->name('admin.setting.pembukaan_input_nilai.index');
					Route::post('/', 'Admin\PembukaanInputNilaiController@store')->name('admin.setting.pembukaan_input_nilai.store');
				});

				Route::group(['prefix' => 'pembukaan_pembayaran_ujian'], function () {
					Route::get('/', 'Admin\PembukaanPembayaranUjian@index')->name('admin.setting.pembukaan_pembayaran_ujian.index');
					Route::get('/tambah', 'Admin\PembukaanPembayaranUjian@tambah')->name('admin.setting.pembukaan_pembayaran_ujian.tambah');
					Route::get('/{id}/edit', 'Admin\PembukaanPembayaranUjian@edit')->name('admin.setting.pembukaan_pembayaran_ujian.edit');
					Route::patch('/{id}/edit', 'Admin\PembukaanPembayaranUjian@perbarui')->name('admin.setting.pembukaan_pembayaran_ujian.perbarui');
					Route::delete('/{id}/hapus', 'Admin\PembukaanPembayaranUjian@hapus')->name('admin.setting.pembukaan_pembayaran_ujian.hapus');
					Route::post('/tambah', 'Admin\PembukaanPembayaranUjian@simpan')->name('admin.setting.pembukaan_pembayaran_ujian.simpan');
				});
			});

			Route::group(['prefix' => 'krs'], function () {
				Route::group(['prefix' => 'approve'], function () {
					Route::get('/datatable', 'Admin\KRSApproveController@datatable')->name('admin.krs.approve.datatable');
					Route::get('/datatable_ulang_matkul', 'Admin\KRSApproveController@datatable_ulang_matkul')->name('admin.krs.approve.datatable_ulang_matkul');
					Route::get('/', 'Admin\KRSApproveController@index')->name('admin.krs.approve.index');
					Route::get('/ulang_matkul', 'Admin\KRSApproveController@ulang_matkul')->name('admin.krs.approve.ulang_matkul');
					Route::get('/{id}/approve', 'Admin\KRSApproveController@approve')->name('admin.krs.approve.approve');
					Route::get('/{id}/approve_ulang_matkul', 'Admin\KRSApproveController@approve_ulang_matkul')->name('admin.krs.approve.approve_ulang_matkul');
					Route::post('/get_detail_krs', 'Admin\KRSApproveController@get_detail_krs')->name('admin.krs.approve.get_detail_krs');
					Route::post('/get_detail_krs_ulang_matkul', 'Admin\KRSApproveController@get_detail_krs_ulang_matkul')->name('admin.krs.approve.get_detail_krs_ulang_matkul');
					Route::post('/krs_ditolak', 'Admin\KRSApproveController@krs_ditolak')->name('admin.krs.approve.ditolak');
				});

				Route::group(['prefix' => 'input'], function () {
					Route::get('/datatable', 'Admin\KRSInputController@datatable')->name('admin.krs.input.datatable');
					Route::get('/', 'Admin\KRSInputController@index')->name('admin.krs.input.index');
					Route::get('/{id_krs}/print', 'Admin\KRSInputController@print')->name('admin.krs.input.print');
					Route::get('/tambah', 'Admin\KRSInputController@tambah')->name('admin.krs.input.tambah');
					Route::post('/tambah', 'Admin\KRSInputController@simpan')->name('admin.krs.input.simpan');
					Route::post('/get_matkul', 'Admin\KRSInputController@get_matkul')->name('admin.krs.input.get_matkul');
				});
				
				Route::group(['prefix' => 'rollback'], function () {
					Route::get('/datatable', 'Admin\KRSRollbackController@datatable')->name('admin.krs.rollback.datatable');
					Route::get('/', 'Admin\KRSRollbackController@index')->name('admin.krs.rollback.index');
					Route::post('/get_watku_kuliah', 'Admin\KRSRollbackController@get_watku_kuliah')->name('admin.krs.rollback.get_waktu_kuliah');
					Route::post('/rollback', 'Admin\KRSRollbackController@rollback')->name('admin.krs.rollback.rollback');
				});
			});

			Route::group(['prefix' => 'absensi'], function () {
				Route::get('/', 'Admin\AbsensiController@index')->name('admin.absensi');
				Route::get('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/detail', 'Admin\AbsensiController@detail')->name('admin.absensi.detail');
				Route::get('/{id}/{id_matkul}/{id_dosen}/kehadiran', 'Admin\AbsensiController@kehadiran')->name('admin.absensi.kehadiran');
				Route::get('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/absensi', 'Admin\AbsensiController@form_absensi')->name('admin.absensi.form_absensi');
				Route::get('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/{tanggal}/{pertemuan_ke}/edit', 'Admin\AbsensiController@form_edit')->name('admin.absensi.form_edit');
				Route::get('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/{tanggal}/{pertemuan_ke}/hapus', 'Admin\AbsensiController@hapus_absensi')->name('admin.absensi.hapus_absensi');
				Route::get('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/{nim}/edit', 'Admin\AbsensiController@edit_mahasiswa')->name('admin.absensi.edit_mahasiswa');
				Route::patch('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/{nim}/edit', 'Admin\AbsensiController@perbarui_mahasiswa')->name('admin.absensi.perbarui_mahasiswa');
				Route::patch('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/detail', 'Admin\AbsensiController@absensi')->name('admin.absensi.absensi');
				Route::patch('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/{tanggal}/{pertemuan_ke}/absensi_edit', 'Admin\AbsensiController@absensi_edit')->name('admin.absensi.absensi_edit');
				Route::patch('/{id}/{id_matkul}/{id_dosen}/{id_jadwal}/edit_absensi', 'Admin\AbsensiController@edit_absensi')->name('admin.absensi.edit_absensi');
				Route::patch('/{id}/{id_matkul}/{id_dosen}/kehadiran', 'Admin\AbsensiController@kehadiran')->name('admin.absensi.kehadiran.submit');			
				Route::post('/', 'Admin\AbsensiController@index')->name('admin.absensi.submit');;
			});

			Route::group(['prefix' => 'rekap_absen'], function(){
				Route::get('/{id}/{id_matkul}/{semester}/{id_dosen}/print', 'CetakAbsenController@rekap_absen')->name('admin.rekap_absen.print');
			});
			
			Route::group(['prefix' => 'batas_pembayaran'], function () {
				Route::group(['prefix' => 'krs'], function () {
					Route::get('/', 'Admin\BatasPembayaranKRSController@index')->name('admin.batas_pembayaran.krs');
					Route::get('/tambah', 'Admin\BatasPembayaranKRSController@tambah')->name('admin.batas_pembayaran.krs.tambah');
					Route::get('/{id}/edit', 'Admin\BatasPembayaranKRSController@edit')->name('admin.batas_pembayaran.krs.edit');
					Route::patch('/{id}/edit', 'Admin\BatasPembayaranKRSController@perbarui')->name('admin.batas_pembayaran.krs.perbarui');
					Route::get('/{id}/hapus', 'Admin\BatasPembayaranKRSController@hapus')->name('admin.batas_pembayaran.krs.hapus');
					Route::post('/tambah', 'Admin\BatasPembayaranKRSController@simpan')->name('admin.batas_pembayaran.krs.simpan');
				});

				Route::group(['prefix' => 'ujian'], function () {
					Route::get('/', 'Admin\BatasPembayaranUjianController@index')->name('admin.batas_pembayaran.ujian');
					Route::get('/tambah', 'Admin\BatasPembayaranUjianController@tambah')->name('admin.batas_pembayaran.ujian.tambah');
					Route::get('/{id}/edit', 'Admin\BatasPembayaranUjianController@edit')->name('admin.batas_pembayaran.ujian.edit');
					Route::patch('/{id}/edit', 'Admin\BatasPembayaranUjianController@perbarui')->name('admin.batas_pembayaran.ujian.perbarui');
					Route::get('/{id}/hapus', 'Admin\BatasPembayaranUjianController@hapus')->name('admin.batas_pembayaran.ujian.hapus');
					Route::post('/tambah', 'Admin\BatasPembayaranUjianController@simpan')->name('admin.batas_pembayaran.ujian.simpan');
				});
			});
			
			Route::group(['prefix' => 'dispensasi_spp'], function () {
				Route::get('/datatable', 'Admin\DispensasiSPPController@datatable')->name('admin.dispensasi_spp.datatable');
				Route::get('/', 'Admin\DispensasiSPPController@index')->name('admin.dispensasi_spp.index');
				Route::get('/', 'Admin\DispensasiSPPController@index')->name('admin.dispensasi_spp.index');
				Route::get('/tambah', 'Admin\DispensasiSPPController@tambah')->name('admin.dispensasi_spp.tambah');
				Route::get('/{id}/edit', 'Admin\DispensasiSPPController@edit')->name('admin.dispensasi_spp.edit');
				Route::get('/{id}/hapus', 'Admin\DispensasiSPPController@hapus')->name('admin.dispensasi_spp.hapus');
				Route::get('/{id}/detail', 'Admin\DispensasiSPPController@detail')->name('admin.dispensasi_spp.detail');
				Route::get('/{id}/sudah_dibayar', 'Admin\DispensasiSPPController@sudah_dibayar')->name('admin.dispensasi_spp.sudah_dibayar');
				Route::patch('/{id}/perbarui', 'Admin\DispensasiSPPController@perbarui')->name('admin.dispensasi_spp.perbarui');
				Route::post('/simpan', 'Admin\DispensasiSPPController@simpan')->name('admin.dispensasi_spp.simpan');
			});

			Route::group(['prefix' => 'kehadiran_dosen'], function () {
				Route::get('/', 'Admin\KehadiranDosenController@index')->name('admin.kehadiran_dosen.index');
			});
			
			Route::group(['prefix' => 'kuesioner'], function () {
				Route::group(['prefix' => 'form'], function () {
					Route::get('/', 'Admin\KuesionerFormController@index')->name('admin.kuesioner.form.index');
					Route::get('/{id}/hapus_kategori', 'Admin\KuesionerFormController@hapus_kategori')->name('admin.kuesioner.form.hapus_kategori');
					Route::get('/{id}/hapus_pertanyaan', 'Admin\KuesionerFormController@hapus_pertanyaan')->name('admin.kuesioner.form.hapus_pertanyaan');
					Route::post('/kategori_submit', 'Admin\KuesionerFormController@kategori_submit')->name('admin.kuesioner.form.kategori_submit');
					Route::post('/pertanyaan_submit', 'Admin\KuesionerFormController@pertanyaan_submit')->name('admin.kuesioner.form.pertanyaan_submit');
				});
			});

			Route::group(['prefix' => 'evaluasi'], function () {
				Route::group(['prefix' => 'hasil_angket_dosen'], function () {
					Route::get('/', 'Admin\AngketDosenController@index')->name('admin.evaluasi.hasil_angket_dosen.index');
					Route::get('/{id_dosen}/{id_matkul}/{tahun_akademik}/{id_semester}/detail', 'Admin\AngketDosenController@detail')->name('admin.evaluasi.hasil_angket_dosen.detail');
					Route::get('/{id_dosen}/{id_matkul}/{tahun_akademik}/{id_semester}/print', 'Admin\AngketDosenController@print')->name('admin.evaluasi.hasil_angket_dosen.print');
				});

				Route::group(['prefix' => 'rekap_angket_dosen'], function () {
					Route::get('/', 'Admin\RekapAngketDosenController@index')->name('admin.evaluasi.rekap_angket_dosen.index');
				});

				Route::group(['prefix' => 'saran_kritik'], function () {
					Route::group(['prefix' => 'sarana_prasarana'], function () {
						Route::get('/', 'Admin\SaranKritikController@sarana_prasarana')->name('admin.evaluasi.saran_kritik.sarana_prasarana');
						Route::post('/', 'Admin\SaranKritikController@sarana_prasarana')->name('admin.evaluasi.saran_kritik.sarana_prasarana');
					});

					Route::group(['prefix' => 'materi_proses_pembelajaran'], function () {
						Route::get('/', 'Admin\SaranKritikController@materi_proses_pembelajaran')->name('admin.evaluasi.saran_kritik.materi_proses_pembelajaran');
						Route::post('/', 'Admin\SaranKritikController@materi_proses_pembelajaran')->name('admin.evaluasi.saran_kritik.materi_proses_pembelajaran');
					});

					Route::group(['prefix' => 'metode_evaluasi_sistem_penilaian'], function () {
						Route::get('/', 'Admin\SaranKritikController@metode_evaluasi_sistem_penilaian')->name('admin.evaluasi.saran_kritik.metode_evaluasi_sistem_penilaian');
						Route::post('/', 'Admin\SaranKritikController@metode_evaluasi_sistem_penilaian')->name('admin.evaluasi.saran_kritik.metode_evaluasi_sistem_penilaian');
					});

					Route::group(['prefix' => 'pengembangan_soft_skill_mahasiswa'], function () {
						Route::get('/', 'Admin\SaranKritikController@pengembangan_soft_skill_mahasiswa')->name('admin.evaluasi.saran_kritik.pengembangan_soft_skill_mahasiswa');
						Route::post('/', 'Admin\SaranKritikController@pengembangan_soft_skill_mahasiswa')->name('admin.evaluasi.saran_kritik.pengembangan_soft_skill_mahasiswa');
					});
				});
			});

			Route::group(['prefix' => 'agenda'], function () {
				Route::get('/', 'Admin\AgendaController@index')->name('admin.agenda.index');
				Route::get('/datatable', 'Admin\AgendaController@datatable')->name('admin.agenda.datatable');
				Route::get('/create', 'Admin\AgendaController@create')->name('admin.agenda.create');
				Route::get('/{id}/edit', 'Admin\AgendaController@edit')->name('admin.agenda.edit');
				Route::get('/{id}/destroy', 'Admin\AgendaController@destroy')->name('admin.agenda.destroy');
				Route::patch('/{id}', 'Admin\AgendaController@update')->name('admin.agenda.update');
				Route::post('/', 'Admin\AgendaController@store')->name('admin.agenda.store');
			});
		});
	});

	Route::group(['prefix' => 'mahasiswa'], function(){
		Route::get('login', 'Auth\LoginController@form')->name('mahasiswa.login');
		Route::post('login', 'Auth\LoginController@login')->name('mahasiswa.login.auth');

		Route::group(['middleware' => 'auth:mahasiswa'], function () {
			Route::get('/', 'Mahasiswa\DashboardController@index')->name('mahasiswa.home');
			Route::get('logout', 'Auth\LoginController@logout')->name('mahasiswa.logout');

			Route::get('ubah-password', 'MahasiswaController@password')->name('mahasiswa.password');

			Route::get('generate-password', 'MahasiswaController@genpass')->name('mahasiswa.generate_password');
			
			Route::post('ubah-password', 'ProfilController@password')->name('mahasiswa.password.ubah');
			
			Route::group(['prefix' => 'pengumuman'], function(){
				Route::get('/', 'PengumumanController@mahasiswa')->name('mahasiswa.pengumuman');
			});

			Route::group(['prefix' => 'matkul_disetujui'], function(){
				Route::get('/', 'MatkulPindahanController@mahasiswa')->name('mahasiswa.matkul.disetujui');
			});
			
			
			Route::group(['prefix' => 'ujian'], function(){
				Route::get('/cetak', 'Admin\JadwalUjianController@cetak')->name('mahasiswa.cetak');
				Route::post('/cetak', 'Admin\JadwalUjianController@cetak')->name('mahasiswa.cetak');
				Route::get('/tengah_semester_front/{id}/{id_ta}', 'Admin\JadwalUjianController@cetak_uts_front')->name('mahasiswa.cetak.uts.front');
				Route::get('/tengah_semester_back/{id}/{id_ta}', 'Admin\JadwalUjianController@cetak_uts_back')->name('mahasiswa.cetak.uts.back');
				Route::get('/akhir_semester_front/{id}/{id_ta}', 'Admin\JadwalUjianController@cetak_uas_front')->name('mahasiswa.cetak.uas.front');
				Route::get('/akhir_semester_back/{id}/{id_ta}', 'Admin\JadwalUjianController@cetak_uas_back')->name('mahasiswa.cetak.uas.back');
			});
			
			

			Route::group(['prefix' => 'profil'], function(){
				Route::get('/', 'ProfilController@profil')->name('mahasiswa.profil');

				Route::get('ubah', 'ProfilController@ubah')->name('mahasiswa.profil.ubah');
				Route::post('ubah', 'ProfilController@perbarui')->name('mahasiswa.profil.perbarui');

				Route::post('ubah-foto', 'ProfilController@foto')->name('mahasiswa.profil.foto');
				Route::get('hapus-foto', 'ProfilController@hapus_foto')->name('mahasiswa.profil.foto.hapus');
			});
			
			Route::group(['prefix' => 'krs'], function(){
				Route::get('/', 'KRSController@index')->name('mahasiswa.krs');
				Route::get('/ulang', 'KRSController@ulang')->name('mahasiswa.krs.ulang');
				Route::get('/{id}/ulang_mk', 'KRSController@ulang_mk')->name('mahasiswa.krs.ulang_mk');
				Route::get('/{id_ulang}/batal_ulang', 'KRSController@batal_ulang')->name('mahasiswa.krs.batal_ulang');
				Route::get('/{id_krs}/ajukan', 'KRSController@ajukan')->name('mahasiswa.krs.ajukan');
				Route::get('/tambah', 'KRSController@tambah')->name('mahasiswa.krs.tambah');
				Route::get('/{id}/edit', 'KRSController@edit')->name('mahasiswa.krs.edit');
				Route::get('/{id_krs}/print', 'KRSController@print')->name('mahasiswa.krs.print');
				Route::put('/{id}/edit', 'KRSController@perbarui')->name('mahasiswa.krs.perbarui');
				Route::post('/tambah', 'KRSController@simpan')->name('mahasiswa.krs.simpan');
				Route::post('/add_ulang_mk', 'KRSController@add_ulang_mk')->name('mahasiswa.krs.add_ulang_mk');
				Route::post('/get_krs', 'KRSController@get_krs')->name('mahasiswa.krs.get_krs');
				Route::post('/get_matkul', 'KRSController@get_matkul')->name('mahasiswa.krs.get_matkul');
				Route::post('/get_matkul_pindahan', 'KRSController@get_matkul_pindahan')->name('mahasiswa.krs.get_matkul_pindahan');
				Route::post('/get_jadwal', 'KRSController@get_jadwal')->name('mahasiswa.krs.get_jadwal');
				Route::post('/update_profile', 'KRSController@update_profile')->name('mahasiswa.krs.update_profile');
			});

			Route::group(['prefix' => 'jadwal'], function(){
				Route::get('/', 'MahasiswaController@jadwal')->name('mahasiswa.jadwal');
				Route::get('{id}/print', 'MahasiswaController@print')->name('mahasiswa.jadwal.print');
			});
			
			Route::group(['prefix' => 'hasil-studi'], function(){
				Route::get('/', 'MahasiswaController@khs')->name('mahasiswa.khs');
				Route::get('/{semester}/print', 'MahasiswaController@print_khs')->name('mahasiswa.khs.print');
				Route::get('semester/{semester}', 'KHSController@semester')->name('mahasiswa.khs.semester');
			});

			Route::group(['prefix' => 'kehadiran'], function () {
				Route::get('/', 'Mahasiswa\AbsensiController@index')->name('mahasiswa.absensi');
				Route::post('/', 'Mahasiswa\AbsensiController@index')->name('mahasiswa.absensi.tampilkan');
			});

			Route::group(['prefix' => 'file_materi'], function () {
				Route::get('/', 'Mahasiswa\SharedMaterialController@index')->name('mahasiswa.shared_material');
			});

			Route::group(['prefix' => 'pembayaran_spp'], function () {
				Route::get('/', 'Mahasiswa\PembayaranSPPController@index')->name('mahasiswa.pembayaran_spp');
				Route::get('/{id_tahun_akademik}/get_pembayaran_spp', 'Mahasiswa\PembayaranSPPController@get_pembayaran_spp')->name('mahasiswa.pembayaran_spp.get_pembayaran_spp');
			});

			Route::group(['prefix' => 'remedial'], function () {
				Route::get('/', 'Mahasiswa\RemedialController@index')->name('mahasiswa.remedial');
				Route::post('/get_remedial', 'Mahasiswa\RemedialController@get_remedial')->name('mahasiswa.remedial.get_remedial');
				Route::post('/get_jadwal', 'Mahasiswa\RemedialController@get_jadwal')->name('mahasiswa.remedial.get_jadwal');
				Route::post('/ulang_matkul', 'Mahasiswa\RemedialController@ulang_matkul')->name('mahasiswa.remedial.ulang_matkul');
			});
			
			Route::group(['prefix' => 'jadwal_ujian'], function () {
				Route::get('/', 'Mahasiswa\CetakJadwalUjianController@index')->name('mahasiswa.cetak_jadwal_ujian');
			});
			
			Route::group(['prefix' => 'kuesioner'], function () {
				Route::get('/', 'Mahasiswa\KuesionerController@index')->name('mahasiswa.kuesioner.index');
				Route::post('/', 'Mahasiswa\KuesionerController@simpan')->name('mahasiswa.kuesioner.simpan');
			});

			Route::group(['prefix' => 'skpi'], function () {
				Route::get('/', 'Mahasiswa\SkpiController@index')->name('mahasiswa.skpi');
				Route::post('/save', 'Mahasiswa\SkpiController@save')->name('mahasiswa.skpi.simpan');
			});

			Route::group(['prefix' => 'judul'], function () {
				Route::get('/', 'Mahasiswa\JudulController@index')->name('mahasiswa.judul');
				Route::post('/save', 'Mahasiswa\JudulController@save')->name('mahasiswa.judul.save');
				Route::get('/cetak', 'Mahasiswa\JudulController@cetak')->name('mahasiswa.judul.cetak');
			});

		});
	});

	Route::group(['prefix' => 'dosen'], function(){
		Route::get('login', 'Auth\LoginController@form')->name('dosen.login');
		Route::post('login', 'Auth\LoginController@login')->name('dosen.login.auth');

		Route::group(['middleware' => 'auth:dosen'], function () {
			Route::get('/', 'Dosen\DashboardController@index')->name('dosen.home');
			Route::get('logout', 'Auth\LoginController@logout')->name('dosen.logout');

			Route::get('ubah-password', 'DosenController@password')->name('dosen.password');
			Route::post('ubah-password', 'ProfilController@password')->name('dosen.password.ubah');
			
			Route::group(['prefix' => 'pengumuman'], function(){
				Route::get('/', 'PengumumanController@dosen')->name('dosen.pengumuman');

			});
				

			Route::group(['prefix' => 'profil'], function(){
				Route::get('/', 'ProfilController@profil')->name('dosen.profil');

				Route::get('ubah', 'ProfilController@ubah')->name('dosen.profil.ubah');
				Route::post('ubah', 'ProfilController@perbarui')->name('dosen.profil.perbarui');

				Route::post('ubah-foto', 'ProfilController@foto')->name('dosen.profil.foto');
				Route::get('hapus-foto', 'ProfilController@hapus_foto')->name('dosen.profil.foto.hapus');
			});

			Route::group(['prefix' => 'krs'], function(){
				Route::get('/', 'DosenController@krs')->name('dosen.krs');
				Route::get('{id}/setuju', 'DosenController@krs_setuju')->name('dosen.krs.setuju');
				Route::get('{id}/tolak', 'DosenController@krs_tolak')->name('dosen.krs.tolak');
				Route::get('/detail', 'DosenController@krs_detail')->name('dosen.krs.detail');
				Route::get('/{id_krs}/print', 'DosenController@print')->name('dosen.krs.print');
			});

			Route::group(['prefix' => 'absensi'], function () {
				Route::get('/', 'Dosen\AbsensiController@index')->name('dosen.absensi');
				Route::get('/{id}/{id_matkul}/{id_jadwal}/detail', 'Dosen\AbsensiController@detail')->name('dosen.absensi.detail');
				Route::get('/{id}/{id_matkul}/kehadiran', 'Dosen\AbsensiController@kehadiran')->name('dosen.absensi.kehadiran');
				Route::get('/{id}/{id_matkul}/{id_jadwal}/absensi', 'Dosen\AbsensiController@form_absensi')->name('dosen.absensi.form_absensi');
				Route::get('/{id}/{id_matkul}/{id_jadwal}/{tanggal}/{pertemuan_ke}/edit', 'Dosen\AbsensiController@form_edit')->name('dosen.absensi.form_edit');
				Route::get('/{id}/{id_matkul}/{id_jadwal}/{tanggal}/{pertemuan_ke}/hapus', 'Dosen\AbsensiController@hapus_absensi')->name('dosen.absensi.hapus_absensi');
				Route::patch('/{id}/{id_matkul}/{id_jadwal}/detail', 'Dosen\AbsensiController@absensi')->name('dosen.absensi.absensi');
				Route::patch('/{id}/{id_matkul}/{id_jadwal}/{tanggal}/{pertemuan_ke}/absensi_edit', 'Dosen\AbsensiController@absensi_edit')->name('dosen.absensi.absensi_edit');
				Route::patch('/{id}/{id_matkul}/{id_jadwal}/edit_absensi', 'Dosen\AbsensiController@edit_absensi')->name('dosen.absensi.edit_absensi');
				Route::patch('/{id}/{id_matkul}/kehadiran', 'Dosen\AbsensiController@kehadiran')->name('dosen.absensi.kehadiran.submit');			
				Route::post('/', 'Dosen\AbsensiController@index')->name('dosen.absensi.submit');
				Route::get('{id}/{id_matkul}/print', 'Dosen\AbsensiController@print')->name('dosen.absensi.print');
			});

			Route::group(['prefix' => 'jadwal'], function () {
				Route::get('/', 'Dosen\JadwalController@index')->name('dosen.jadwal');
				Route::post('/', 'Dosen\JadwalController@index')->name('dosen.jadwal.submit');
				Route::get('{id}/print', 'Dosen\JadwalController@print')->name('dosen.jadwal.print');
			});

			Route::group(['prefix' => 'shared_material'], function () {
				Route::get('/datatable', 'Dosen\SharedMaterialController@datatable')->name('dosen.shared_material.datatable');
				Route::get('/', 'Dosen\SharedMaterialController@index')->name('dosen.shared_material');
				Route::get('/tambah', 'Dosen\SharedMaterialController@tambah')->name('dosen.shared_material.tambah');
				Route::post('/tambah', 'Dosen\SharedMaterialController@simpan')->name('dosen.shared_material.simpan');
				Route::get('/{id}/ubah', 'Dosen\SharedMaterialController@ubah')->name('dosen.shared_material.ubah');
				Route::get('/{id}/hapus', 'Dosen\SharedMaterialController@hapus')->name('dosen.shared_material.hapus');
				Route::patch('/{id}/ubah', 'Dosen\SharedMaterialController@perbarui')->name('dosen.shared_material.perbarui');
				
			});

			Route::group(['prefix' => 'nilai'], function () {
				Route::get('/', 'Dosen\NilaiController@index')->name('dosen.nilai.index');
				Route::get('/{id_tahun_akademik}/{id_kelas}/{id_matkul}/input', 'Dosen\NilaiController@input')->name('dosen.nilai.input');
				Route::post('/{id_tahun_akademik}/{id_kelas}/{id_matkul}/input', 'Dosen\NilaiController@input_simpan')->name('dosen.nilai.input.simpan');
				Route::post('/', 'Dosen\NilaiController@index')->name('dosen.nilai.index.submit');
				Route::get('/print', 'Admin\RekapNilaiController@print')->name('dosen.rekap_nilai.print');

				Route::group(['prefix' => 'persentase'], function () {
					Route::get('/atur', 'Dosen\PersentaseNilaiController@atur')->name('dosen.nilai.persentase.atur');
					Route::post('/atur', 'Dosen\PersentaseNilaiController@perbarui')->name('dosen.nilai.persentase.perbarui');
				});
			});

			Route::group(['prefix' => 'kuesioner'], function () {
				Route::group(['prefix' => 'nilai'], function () {
					Route::get('/', 'Dosen\NilaiKuesionerController@index')->name('dosen.kuesioner.nilai.index');
				});
			});

			Route::group(['prefix' => 'skpi'], function () {
				Route::get('/','Dosen\SkpiController@index')->name('dosen.skpi.index');
				Route::get('/cari','Dosen\SkpiController@cari')->name('dosen.skpi.cari');	
				Route::get('{id}/confirm','Dosen\skpiController@confirm')->name('dosen.skpi.confirm');
			});

			Route::group(['prefix' => 'saran_kritik'], function () {
				Route::group(['prefix' => 'materi_proses_pembelajaran'], function () {
					Route::get('/', 'Dosen\SaranKritikController@materi_proses_pembelajaran')->name('dosen.evaluasi.saran_kritik.materi_proses_pembelajaran');
					Route::post('/', 'Dosen\SaranKritikController@materi_proses_pembelajaran')->name('dosen.evaluasi.saran_kritik.materi_proses_pembelajaran');
				});

				Route::group(['prefix' => 'metode_evaluasi_sistem_penilaian'], function () {
					Route::get('/', 'Dosen\SaranKritikController@metode_evaluasi_sistem_penilaian')->name('dosen.evaluasi.saran_kritik.metode_evaluasi_sistem_penilaian');
					Route::post('/', 'Dosen\SaranKritikController@metode_evaluasi_sistem_penilaian')->name('dosen.evaluasi.saran_kritik.metode_evaluasi_sistem_penilaian');
				});
			});

			Route::group(['prefix' => 'rekap_absen'], function(){
				Route::get('/{id}/{id_matkul}/{semester}/print', 'CetakAbsenController@rekap_absen')->name('dosen.rekap_absen.print');
			});
		});
	});

	Route::group(['prefix' => 'wali'], function(){
		Route::get('/', 'Wali\DashboardController@index')->name('wali.home');

		Route::get('login', 'Auth\LoginController@form')->name('wali.login');
		Route::post('login', 'Auth\LoginController@login')->name('wali.login.auth');

		Route::get('logout', 'Auth\LoginController@logout')->name('wali.logout');

		Route::group(['prefix' => 'krs'], function(){
			Route::get('/', 'KRSController@index')->name('wali.krs');
			Route::get('tambah/', 'KRSController@tambah')->name('wali.krs.tambah');
			Route::post('tambah', 'KRSController@simpan')->name('wali.krs.simpan');
			Route::get('get_avail_matkul', 'KRSController@get_avail_matkul')->name('wali.krs.get_avail_matkul');
		});
		Route::group(['prefix' => 'jadwal'], function(){
			Route::get('/', 'MahasiswaController@jadwal')->name('wali.jadwal');
		});
		
		Route::group(['prefix' => 'hasil-studi'], function(){
			Route::get('/', 'MahasiswaController@khs')->name('wali.khs');

			Route::get('semester/{semester}', 'KHSController@semester')->name('wali.khs.semester');
		});
	});
	
	
	/*smk*/
	Route::group(['prefix' => 'smk'], function(){
		Route::get('/', 'SMK\SMKController@index')->name('smk.web.beranda');

		Route::group(['prefix' => 'profil'], function(){
			Route::get('/guru', 'SMK\SMKController@guru')->name('smk.web.guru');
			Route::get('/tentang_kami', 'SMK\SMKController@tentang_kami')->name('smk.web.tentang_kami');
			Route::get('/visimisi', 'SMK\SMKController@visimisi')->name('smk.web.visimisi');
		});

		Route::get('/struktur', 'SMK\SMKController@struktur')->name('smk.web.struktur');

		Route::group(['prefix' => 'fasilitas'], function(){
			Route::get('/perpustakaan', 'SMK\SMKController@sejarah')->name('smk.web.perpustakaan');
			Route::get('/lab_komputer', 'SMK\SMKController@sejarah')->name('smk.web.lab_komputer');
			Route::get('/masjid', 'SMK\SMKController@sejarah')->name('smk.web.masjid');
			Route::get('/studio_musik', 'SMK\SMKController@sejarah')->name('smk.web.studio_musik');
			Route::get('/free_wifi', 'SMK\SMKController@sejarah')->name('smk.web.free_wifi');
			Route::get('/atm_center', 'SMK\SMKController@sejarah')->name('smk.web.atm_center');
			Route::get('/radio_ppi', 'SMK\SMKController@sejarah')->name('smk.web.radio_ppi');
			Route::get('/kantin', 'SMK\SMKController@sejarah')->name('smk.web.kantin');
			Route::get('/ruang_kelas_ac', 'SMK\SMKController@sejarah')->name('smk.web.ruang_kelas_ac');
		});
	
		   	Route::get('/kontak', 'SMK\SMKController@kontak')->name('web.kontak');
			Route::post('/kontak/simpan', 'SMK\SMKController@simpan')->name('web.simpan');
			Route::get('{id}/berita', 'SMK\SMKController@berita')->name('web.berita');


		Route::group(['prefix' => 'fasilitas'], function(){
			Route::get('/perpustakaan', 'SMK\SMKController@perpustakaan')->name('smk.web.perpustakaan');
			Route::get('/lab_komputer', 'SMK\SMKController@lab_komputer')->name('smk.web.lab_komputer');
			Route::get('/masjid', 'SMK\SMKController@masjid')->name('smk.web.masjid');
			Route::get('/studio_musik', 'SMK\SMKController@studio_musik')->name('smk.web.studio_musik');
			Route::get('/free_wifi', 'SMK\SMKController@free_wifi')->name('smk.web.free_wifi');
			Route::get('/atm_center', 'SMK\SMKController@atm_center')->name('smk.web.atm_center');
			Route::get('/radio_ppi', 'SMK\SMKController@radio_ppi')->name('smk.web.radio_ppi');
			Route::get('/kantin', 'SMK\SMKController@kantin')->name('smk.web.kantin');
			Route::get('/ruang_kelas_ac', 'SMK\SMKController@ruang_kelas_ac')->name('smk.web.ruang_kelas_ac');
		});
		
		   	Route::get('/kontak', 'SMK\SMKController@kontak')->name('smk.web.kontak');
			Route::post('/kontak/simpan', 'SMK\SMKController@simpan')->name('smk.web.simpan');
			Route::get('{id}/berita', 'SMK\SMKController@berita')->name('smk.web.berita');
			
	});

	Route::group(['prefix' => 'admin_smk'], function(){
		Route::get('/', 'SMK\SMKAdminController@index')->name('admin_smk.home');

		Route::get('login', 'Auth\LoginController@form')->name('admin_smk.login');
		Route::post('login', 'Auth\LoginController@login')->name('admin_smk.login.auth');

		Route::get('logout', 'Auth\LoginController@logout')->name('admin_smk.logout');

		Route::get('ubah-password', 'SMK\SMKAdminController@password')->name('admin_smk.password');
		Route::post('ubah-password', 'ProfilController@password')->name('admin_smk.password.ubah');

		Route::group(['prefix' => 'profil'], function(){
			Route::get('/', 'ProfilController@profil')->name('admin_smk.profil');

			Route::get('{id}/ubah', 'ProfilController@ubah')->name('admin_smk.profil.ubah');
			Route::post('{id}/ubah', 'ProfilController@perbarui')->name('admin_smk.profil.perbarui');
		});

		

			Route::group(['prefix' => 'info'], function(){
				Route::get('/', 'SMK\SMKAdminController@SMKInfo')->name('smk.admin.info');
				Route::get('trash', 'SMK\SMKInfoController@trash')->name('smk.admin.info.trash');

				Route::get('datatable', 'SMK\SMKInfoController@datatable')->name('smk.admin.info.datatable');
				Route::get('trash/datatable', 'SMK\SMKInfoController@datatable')->name('smk.admin.info.trash.datatable');

				Route::get('tambah', 'SMK\SMKInfoController@tambah')->name('smk.admin.info.tambah');
				Route::post('tambah', 'SMK\SMKInfoController@simpan')->name('smk.admin.info.simpan');

				Route::get('{id}/ubah', 'SMK\SMKInfoController@ubah')->name('smk.admin.info.ubah');

				Route::post('{id}/ubah', 'SMK\SMKInfoController@perbarui')->name('smk.admin.info.perbarui');
				Route::get('{id}/detail', 'SMK\SMKInfoController@detail')->name('smk.admin.info.detail');
				Route::get('{id}/restore', 'SMK\SMKInfoController@restore')->name('smk.admin.info.restore');

				Route::get('{id}/hapus', 'SMK\SMKInfoController@toTrash')->name('smk.admin.info.hapus');
				Route::get('{id}/hapus-permanent', 'SMK\SMKInfoController@hapus')->name('smk.admin.info.hapus.permanent');
			});
			
			
			Route::group(['prefix' => 'guru'], function(){
				Route::get('/', 'SMK\SMKAdminController@SMKGuru')->name('smk.admin.guru');
				Route::get('trash', 'SMK\SMKGuruController@trash')->name('smk.admin.guru.trash');

				Route::get('datatable', 'SMK\SMKGuruController@datatable')->name('smk.admin.guru.datatable');
				Route::get('trash/datatable', 'SMK\SMKGuruController@datatable')->name('smk.admin.guru.trash.datatable');

				Route::get('tambah', 'SMK\SMKGuruController@tambah')->name('smk.admin.guru.tambah');
				Route::post('tambah', 'SMK\SMKGuruController@simpan')->name('smk.admin.guru.simpan');

				Route::get('{id}/ubah', 'SMK\SMKGuruController@ubah')->name('smk.admin.guru.ubah');

				Route::post('{id}/ubah', 'SMK\SMKGuruController@perbarui')->name('smk.admin.guru.perbarui');
				Route::get('{id}/detail', 'SMK\SMKGuruController@detail')->name('smk.admin.guru.detail');
				Route::get('{id}/restore', 'SMK\SMKGuruController@restore')->name('smk.admin.guru.restore');

				Route::get('{id}/hapus', 'SMK\SMKGuruController@toTrash')->name('smk.admin.guru.hapus');
				Route::get('{id}/hapus-permanent', 'SMK\SMKGuruController@hapus')->name('smk.admin.guru.hapus.permanent');
			});


		Route::group(['prefix' => 'kategori_info'], function(){
			Route::get('/', 'SMK\SMKAdminController@SMKKategoriInfo')->name('smk.admin.kategori_info');
			Route::get('trash', 'SMK\SMKKategoriInfoController@trash')->name('smk.admin.kategori_info.trash');

			Route::get('datatable', 'SMK\SMKKategoriInfoController@datatable')->name('smk.admin.kategori_info.datatable');
			Route::get('trash/datatable', 'SMK\SMKKategoriInfoController@datatable')->name('smk.admin.kategori_info.trash.datatable');

			Route::get('tambah', 'SMK\SMKKategoriInfoController@tambah')->name('smk.admin.kategori_info.tambah');
			Route::post('tambah', 'SMK\SMKKategoriInfoController@simpan')->name('smk.admin.kategori_info.simpan');

			Route::get('{id}/ubah', 'SMK\SMKKategoriInfoController@ubah')->name('smk.admin.kategori_info.ubah');
			Route::post('{id}/ubah', 'SMK\SMKKategoriInfoController@perbarui')->name('smk.admin.kategori_info.perbarui');
			
			Route::get('{id}/restore', 'SMK\SMKKategoriInfoController@restore')->name('smk.admin.kategori_info.restore');

			Route::get('{id}/hapus', 'SMK\SMKKategoriInfoController@toTrash')->name('smk.admin.kategori_info.hapus');
			Route::get('{id}/hapus-permanent', 'SMK\SMKKategoriInfoController@hapus')->name('smk.admin.kategori_info.hapus.permanent');
		});
			
// 			Route::group(['prefix' => 'pesan'], function(){
// 				Route::get('/', 'AdminController@pesan')->name('admin.pesan');
// 				Route::get('trash', 'PesanController@trash')->name('admin.pesan.trash');

// 				Route::get('datatable', 'PesanController@datatable')->name('admin.pesan.datatable');
// 				Route::get('trash/datatable', 'PesanController@datatable')->name('admin.pesan.trash.datatable');

// 				Route::get('{id}/detail', 'PesanController@detail')->name('admin.pesan.detail');
// 				Route::get('{id}/restore', 'PesanController@restore')->name('admin.pesan.restore');

// 				Route::get('{id}/hapus', 'PesanController@toTrash')->name('admin.pesan.hapus');
// 				Route::get('{id}/hapus-permanent', 'PesanController@hapus')->name('admin.pesan.hapus.permanent');
// 			});

			Route::group(['prefix' => 'karyawan'], function(){
			Route::get('/', 'SMK\SMKAdminController@SMKkaryawan')->name('smk.admin.karyawan');
			Route::get('trash', 'SMK\SMKKaryawanController@trash')->name('smk.admin.karyawan.trash');

			Route::get('datatable', 'SMK\SMKKaryawanController@datatable')->name('smk.admin.karyawan.datatable');
			Route::get('trash/datatable', 'SMK\SMKKaryawanController@datatable')->name('smk.admin.karyawan.trash.datatable');

			Route::get('tambah', 'SMK\SMKKaryawanController@tambah')->name('smk.admin.karyawan.tambah');
			Route::post('tambah', 'SMK\SMKKaryawanController@simpan')->name('smk.admin.karyawan.simpan');
			
			Route::get('{id}/ubah', 'SMK\SMKKaryawanController@ubah')->name('smk.admin.karyawan.ubah');
			Route::post('{id}/ubah', 'SMK\SMKKaryawanController@perbarui')->name('smk.admin.karyawan.perbarui');

			Route::get('{id}/hak-akses', 'SMK\SMKKaryawanController@ubahAkses')->name('smk.admin.karyawan.akses.ubah');
			Route::post('{id}/hak-akses', 'SMK\SMKKaryawanController@perbaruiAkses')->name('smk.admin.karyawan.akses.perbarui');

			Route::get('{id}/restore', 'SMK\SMKKaryawanController@restore')->name('smk.admin.karyawan.restore');

			Route::get('{id}/hapus', 'SMK\SMKKaryawanController@toTrash')->name('smk.admin.karyawan.hapus');
			Route::get('{id}/hapus-permanen', 'SMK\SMKKaryawanController@hapus')->name('smk.admin.karyawan.hapus.permanen');

			Route::get('{id}/detail', 'SMK\SMKKaryawanController@detail')->name('smk.admin.karyawan.detail');
		});
	});

	
	/*smp*/
	Route::group(['prefix' => 'smp'], function(){
		Route::get('/', 'SMP\SMPController@index')->name('smp.web.beranda');

		Route::group(['prefix' => 'profil'], function(){
			Route::get('/sejarah', 'SMP\SMPController@sejarah')->name('smp.web.sejarah');
			Route::get('/tentang_kami', 'SMP\SMPController@tentang_kami')->name('smp.web.tentang_kami');
			Route::get('/visimisi', 'SMP\SMPController@visimisi')->name('smp.web.visimisi');
		});

		Route::get('/struktur', 'SMP\SMPController@struktur')->name('smp.web.struktur');

		Route::group(['prefix' => 'fasilitas'], function(){
			Route::get('/perpustakaan', 'SMP\SMPController@sejarah')->name('smp.web.perpustakaan');
			Route::get('/lab_komputer', 'SMP\SMPController@sejarah')->name('smp.web.lab_komputer');
			Route::get('/masjid', 'SMP\SMPController@sejarah')->name('smp.web.masjid');
			Route::get('/studio_musik', 'SMP\SMPController@sejarah')->name('smp.web.studio_musik');
			Route::get('/free_wifi', 'SMP\SMPController@sejarah')->name('smp.web.free_wifi');
			Route::get('/atm_center', 'SMP\SMPController@sejarah')->name('smp.web.atm_center');
			Route::get('/radio_ppi', 'SMP\SMPController@sejarah')->name('smp.web.radio_ppi');
			Route::get('/kantin', 'SMP\SMPController@sejarah')->name('smp.web.kantin');
			Route::get('/ruang_kelas_ac', 'SMP\SMPController@sejarah')->name('smp.web.ruang_kelas_ac');
		});
	
		   	Route::get('/kontak', 'SMP\SMPController@kontak')->name('smp.web.kontak');
			Route::post('/kontak/simpan', 'SMP\SMPController@simpan')->name('smp.web.simpan');
			Route::get('{id}/berita', 'SMP\SMPController@berita')->name('smp.web.berita');


		Route::group(['prefix' => 'fasilitas'], function(){
			Route::get('/perpustakaan', 'SMP\SMPController@perpustakaan')->name('smp.web.perpustakaan');
			Route::get('/lab_komputer', 'SMP\SMPController@lab_komputer')->name('smp.web.lab_komputer');
			Route::get('/masjid', 'SMP\SMPController@masjid')->name('smp.web.masjid');
			Route::get('/studio_musik', 'SMP\SMPController@studio_musik')->name('smp.web.studio_musik');
			Route::get('/free_wifi', 'SMP\SMPController@free_wifi')->name('smp.web.free_wifi');
			Route::get('/atm_center', 'SMP\SMPController@atm_center')->name('smp.web.atm_center');
			Route::get('/radio_ppi', 'SMP\SMPController@radio_ppi')->name('smp.web.radio_ppi');
			Route::get('/kantin', 'SMP\SMPController@kantin')->name('smp.web.kantin');
			Route::get('/ruang_kelas_ac', 'SMP\SMPController@ruang_kelas_ac')->name('smp.web.ruang_kelas_ac');
		});
		
		   	Route::get('/kontak', 'SMP\SMPController@kontak')->name('smk.web.kontak');
			Route::post('/kontak/simpan', 'SMP\SMPController@simpan')->name('smk.web.simpan');
			Route::get('{id}/berita', 'SMP\SMPController@berita')->name('smk.web.berita');
			
	});


	Route::group(['prefix' => 'admin_smp'], function(){
		Route::get('/', 'SMP\SMPAdminController@index')->name('admin_smp.home');

		Route::get('login', 'Auth\LoginController@form')->name('admin_smp.login');
		Route::post('login', 'Auth\LoginController@login')->name('admin_smp.login.auth');

		Route::get('logout', 'Auth\LoginController@logout')->name('admin_smp.logout');

		Route::get('ubah-password', 'SMK\SMKAdminController@password')->name('admin_smp.password');
		Route::post('ubah-password', 'ProfilController@password')->name('admin_smp.password.ubah');

		Route::group(['prefix' => 'profil'], function(){
			Route::get('/', 'ProfilController@profil')->name('admin_smp.profil');

			Route::get('{id}/ubah', 'ProfilController@ubah')->name('admin_smp.profil.ubah');
			Route::post('{id}/ubah', 'ProfilController@perbarui')->name('admin_smk.profil.perbarui');
		});

		

			Route::group(['prefix' => 'info'], function(){
				Route::get('/', 'SMP\SMPAdminController@SMPInfo')->name('smp.admin.info');
				Route::get('trash', 'SMP\SMPInfoController@trash')->name('smp.admin.info.trash');

				Route::get('datatable', 'SMP\SMPInfoController@datatable')->name('smp.admin.info.datatable');
				Route::get('trash/datatable', 'SMP\SMPInfoController@datatable')->name('smp.admin.info.trash.datatable');

				Route::get('tambah', 'SMP\SMPInfoController@tambah')->name('smp.admin.info.tambah');
				Route::post('tambah', 'SMP\SMPInfoController@simpan')->name('smp.admin.info.simpan');

				Route::get('{id}/ubah', 'SMP\SMPInfoController@ubah')->name('smp.admin.info.ubah');

				Route::post('{id}/ubah', 'SMP\SMPInfoController@perbarui')->name('smp.admin.info.perbarui');
				Route::get('{id}/detail', 'SMP\SMPInfoController@detail')->name('smp.admin.info.detail');
				Route::get('{id}/restore', 'SMP\SMPInfoController@restore')->name('smp.admin.info.restore');

				Route::get('{id}/hapus', 'SMP\SMPInfoController@toTrash')->name('smp.admin.info.hapus');
				Route::get('{id}/hapus-permanent', 'SMP\SMPInfoController@hapus')->name('smp.admin.info.hapus.permanent');
			});

		Route::group(['prefix' => 'kategori_info'], function(){
			Route::get('/', 'SMP\SMPAdminController@SMPKategoriInfo')->name('smp.admin.kategori_info');
			Route::get('trash', 'SMP\SMPKategoriInfoController@trash')->name('smp.admin.kategori_info.trash');

			Route::get('datatable', 'SMP\SMPKategoriInfoController@datatable')->name('smp.admin.kategori_info.datatable');
			Route::get('trash/datatable', 'SMP\SMPKategoriInfoController@datatable')->name('smp.admin.kategori_info.trash.datatable');

			Route::get('tambah', 'SMP\SMPKategoriInfoController@tambah')->name('smp.admin.kategori_info.tambah');
			Route::post('tambah', 'SMP\SMPKategoriInfoController@simpan')->name('smp.admin.kategori_info.simpan');

			Route::get('{id}/ubah', 'SMP\SMPKategoriInfoController@ubah')->name('smp.admin.kategori_info.ubah');
			Route::post('{id}/ubah', 'SMP\SMPKategoriInfoController@perbarui')->name('smp.admin.kategori_info.perbarui');
			
			Route::get('{id}/restore', 'SMP\SMPKategoriInfoController@restore')->name('smp.admin.kategori_info.restore');

			Route::get('{id}/hapus', 'SMP\SMPKategoriInfoController@toTrash')->name('smp.admin.kategori_info.hapus');
			Route::get('{id}/hapus-permanent', 'SMP\SMPKategoriInfoController@hapus')->name('smp.admin.kategori_info.hapus.permanent');
		});
			
			Route::group(['prefix' => 'pesan'], function(){
				Route::get('/', 'AdminController@pesan')->name('admin.pesan');
				Route::get('trash', 'PesanController@trash')->name('admin.pesan.trash');

				Route::get('datatable', 'PesanController@datatable')->name('admin.pesan.datatable');
				Route::get('trash/datatable', 'PesanController@datatable')->name('admin.pesan.trash.datatable');

				Route::get('{id}/detail', 'PesanController@detail')->name('admin.pesan.detail');
				Route::get('{id}/restore', 'PesanController@restore')->name('admin.pesan.restore');

				Route::get('{id}/hapus', 'PesanController@toTrash')->name('admin.pesan.hapus');
				Route::get('{id}/hapus-permanent', 'PesanController@hapus')->name('admin.pesan.hapus.permanent');
			});

	    	Route::group(['prefix' => 'karyawan'], function(){
			Route::get('/', 'SMP\SMPAdminController@SMPkaryawan')->name('smp.admin.karyawan');
			Route::get('trash', 'SMP\SMPKaryawanController@trash')->name('smp.admin.karyawan.trash');

			Route::get('datatable', 'SMP\SMPKaryawanController@datatable')->name('smp.admin.karyawan.datatable');
			Route::get('trash/datatable', 'SMP\SMPKaryawanController@datatable')->name('smp.admin.karyawan.trash.datatable');

			Route::get('tambah', 'SMP\SMPKaryawanController@tambah')->name('smp.admin.karyawan.tambah');
			Route::post('tambah', 'SMP\SMPKaryawanController@simpan')->name('smp.admin.karyawan.simpan');
			
			Route::get('{id}/ubah', 'SMP\SMPKaryawanController@ubah')->name('smp.admin.karyawan.ubah');
			Route::post('{id}/ubah', 'SMP\SMPKaryawanController@perbarui')->name('smp.admin.karyawan.perbarui');

			Route::get('{id}/hak-akses', 'SMP\SMPKaryawanController@ubahAkses')->name('smp.admin.karyawan.akses.ubah');
			Route::post('{id}/hak-akses', 'SMP\SMPKaryawanController@perbaruiAkses')->name('smp.admin.karyawan.akses.perbarui');

			Route::get('{id}/restore', 'SMP\SMPKaryawanController@restore')->name('smp.admin.karyawan.restore');

			Route::get('{id}/hapus', 'SMP\SMPKaryawanController@toTrash')->name('smp.admin.karyawan.hapus');
			Route::get('{id}/hapus-permanen', 'SMP\SMPKaryawanController@hapus')->name('smp.admin.karyawan.hapus.permanen');

			Route::get('{id}/detail', 'SMP\SMPKaryawanController@detail')->name('smp.admin.karyawan.detail');
		});
	});
});