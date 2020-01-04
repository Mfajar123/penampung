<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;



use Auth;

use Session;

use Redirect;

use File;



use App\Admin;



use App\Mahasiswa;

use App\MahasiswaSekolah;

use App\MahasiswaPekerjaan;

use App\MahasiswaOrtu;



use App\Dosen;

use App\DosenPendidikan;

use App\DosenJabatan;



use App\Prodi;

use App\Provinsi;



class ProfilController extends Controller

{

    function __construct(Request $req)

    {

    	if($req->segment(1) == 'admin')

    	{

    		$this->middleware('auth:admin');

    	}

    	elseif($req->segment(1) == 'mahasiswa')

    	{

    		$this->middleware('auth:mahasiswa');

    	}

    	elseif($req->segment(1) == 'dosen')

    	{

    		$this->middleware('auth:dosen');

    	}

    }



    function profil(Request $req)

    {

        $system = New SystemController();

        if($req->segment(1) == 'admin')

        {

            $profil = Admin::find(Auth::guard('admin')->user()->id_admin);

            $path = 'images/admin/';

            $id = $profil->id_admin;



            return view('pages.profil.index', compact('profil', 'path', 'id'));

        }

        elseif($req->segment(1) == 'mahasiswa')

        {

            $profil = Mahasiswa::find(Auth::guard('mahasiswa')->user()->id_mahasiswa);

            $path = 'images/mahasiswa/';

            $id = $profil->id_admin;



            $sekolah = MahasiswaSekolah::where('nim', $profil->nim)->first();

            $pekerjaan = MahasiswaPekerjaan::where('nim', $profil->nim)->first();

            $ortu = MahasiswaOrtu::where('nim', $profil->nim)->first();



            $rFoto = 'mahasiswa.profil.foto';

            $rHapus_foto = 'mahasiswa.profil.foto.hapus';



            return view('pages.profil.index', compact('profil', 'path', 'id', 'sekolah', 'pekerjaan', 'ortu', 'system', 'rFoto', 'rHapus_foto'));

        }

        elseif($req->segment(1) == 'dosen')

        {

            $profil = Dosen::find(Auth::guard('dosen')->user()->id_dosen);

            $path = 'images/dosen/';

            $id = $profil->id_dosen;



            $pendidikan = DosenPendidikan::where('nip', Auth::guard('dosen')->user()->nip)->first();



            $rFoto = 'dosen.profil.foto';

            $rHapus_foto = 'dosen.profil.foto.hapus';



            return view('pages.profil.index', compact('profil', 'path', 'id', 'pendidikan', 'jabatan', 'rFoto', 'rHapus_foto'));

        }

    	

    }



    function ubah(Request $req)

    {

        $provinsi = Provinsi::orderBy('nama_provinsi', 'ASC')->pluck('nama_provinsi', 'id_provinsi');

        if($req->segment(1) == 'admin')

        {

            $profil = Admin::find(Auth::guard('admin')->user()->id_admin);

        }

        elseif($req->segment(1) == 'mahasiswa')

        {

            $profil = Mahasiswa::leftjoin('m_mahasiswa_ortu', 'm_mahasiswa.nim', 'm_mahasiswa_ortu.nim')->leftjoin('m_mahasiswa_pekerjaan', 'm_mahasiswa.nim', 'm_mahasiswa_pekerjaan.nim')->leftjoin('m_mahasiswa_sekolah', 'm_mahasiswa.nim', 'm_mahasiswa_sekolah.nim')->find(Auth::guard('mahasiswa')->user()->id_mahasiswa);

            $route = 'mahasiswa.profil.perbarui';

        }

        elseif($req->segment(1) == 'dosen')

        {

            $profil = Dosen::leftjoin('m_dosen_pendidikan', 'm_dosen.nip', 'm_dosen_pendidikan.nip')->find(Auth::guard('dosen')->user()->id_dosen);

            $jabatan = DosenJabatan::orderBy('nama', 'ASC')->pluck('nama', 'id_dosen_jabatan');

            $prodi = Prodi::pluck('nama_prodi', 'id_prodi');

            $route = 'dosen.profil.perbarui';

        }



        return view('pages.profil.ubah', compact('profil', 'id', 'route', 'provinsi', 'jabatan', 'prodi'));

    }



    function perbarui(Request $req)

    {

        if($req->segment(1) == 'admin')

        {

            if(trim($req->nama) == '')

            {

                Session::flash('fail', 'Nama Wajib Diisi!');



                return redirect()->back()->withInput($req->all());

            }

            else

            {

                $input = $req->all();



                Admin::find($id)->update($input);

                Session::flash('success', 'Profil Berhasil Diubah');



                return redirect()->route('admin.profil');

            }

        }

        elseif($req->segment(1) == 'mahasiswa')

        {

            $input = $req->all();



            Mahasiswa::find(Auth::guard('mahasiswa')->user()->id_mahasiswa)->update($input);

            MahasiswaOrtu::where('nim', Auth::guard('mahasiswa')->user()->nim)->update(['nama_ibu' => $req->nama_ibu, 'nama_ayah' => $req->nama_ayah, 'alamat_ortu' => $req->alamat_ortu, 'no_telp_ortu' => $req->no_telp_ortu]);

            MahasiswaPekerjaan::where('nim', Auth::guard('mahasiswa')->user()->nim)->update(['perusahaan' => $req->perusahaan, 'posisi' => $req->posisi, 'alamat_perusahaan' => $req->alamat_perusahaan]);

            MahasiswaSekolah::where('nim', Auth::guard('mahasiswa')->user()->nim)->update(['asal_sekolah' => $req->asal_sekolah, 'no_ijazah' => $req->no_ijazah, 'jurusan' => $req->jurusan, 'alamat_sekolah' => $req->alamat_sekolah]);



            Session::flash('success', 'Profil Berhasil Diubah');



            return redirect()->route('mahasiswa.profil');

        }

        elseif($req->segment(1) == 'dosen')

        {

            $input = $req->all();



            Dosen::find(Auth::guard('dosen')->user()->id_dosen)->update($input);



            DosenPendidikan::where('nip', Auth::guard('dosen')->user()->nip)->update(['jenjang' => $req->jenjang, 'nama_sekolah' => $req->nama_sekolah, 'jurusan' => $req->jurusan, 'gelar' => $req->gelar, 'konsentrasi' => $req->konsentrasi]);



            Session::flash('success', 'Profil Berhasil Diubah');



            return redirect()->route('dosen.profil');

        }

    }



    function password(Request $req)

    {

        $system = New SystemController();



        if($req->segment(1) == 'admin')

        {

            $auth = Auth::guard('admin')->user();



            $admin = Admin::find($auth->id_admin);



            $password = $system->decrypt($admin->password, $admin->username, $admin->username);



            if($req->password_lama != $password)

            {

                Session::flash('fail', 'Password Lama Tidak Sesuai !');



                return redirect()->back();

            }

            else

            {

                if($req->konfirmasi_password != $req->password_baru)

                {

                    Session::flash('fail', 'Konfirmasi Password Tidak Sesuai !');



                    return redirect()->back();

                }

                else

                {

                    $admin->update(['password' => $system->encrypt($req->password_baru, $admin->username, $admin->username)]);



                    Session::flash('success', 'Password Berhasil Diperbarui !');



                    return redirect()->route('admin.password');

                }

            }

        }

        elseif($req->segment(1) == 'mahasiswa')

        {

            $auth = Auth::guard('mahasiswa')->user();



            $mahasiswa = Mahasiswa::find($auth->id_mahasiswa);



            $password = $system->decrypt($mahasiswa->password, $mahasiswa->nim, $mahasiswa->nim);



            if($req->password_lama != $password)

            {

                Session::flash('fail', 'Password Lama Tidak Sesuai !');



                return redirect()->back();

            }

            else

            {

                if($req->konfirmasi_password != $req->password_baru)

                {

                    Session::flash('fail', 'Konfirmasi Password Tidak Sesuai !');



                    return redirect()->back();

                }

                else

                {

                    $mahasiswa->update(['password' => $system->encrypt($req->password_baru, $mahasiswa->nim, $mahasiswa->nim)]);



                    Session::flash('success', 'Password Berhasil Diperbarui !');



                    return redirect()->route('mahasiswa.password');

                }

            }

        }

        elseif($req->segment(1) == 'dosen')

        {

            $auth = Auth::guard('dosen')->user();



            $dosen = Dosen::find($auth->id_dosen);



            $password = $system->decrypt($dosen->password, $dosen->nip, $dosen->nip);



            if($req->password_lama != $password)

            {

                Session::flash('fail', 'Password Lama Tidak Sesuai !');



                return redirect()->back();

            }

            else

            {

                if($req->konfirmasi_password != $req->password_baru)

                {

                    Session::flash('fail', 'Konfirmasi Password Tidak Sesuai !');



                    return redirect()->back();

                }

                else

                {

                    $dosen->update(['password' => $system->encrypt($req->password_baru, $dosen->nip, $dosen->nip)]);



                    Session::flash('success', 'Password Berhasil Diperbarui !');



                    return redirect()->route('dosen.password');

                }

            }

        }

    }



    function foto(Request $req)

    {

        $foto = $req->file('foto_profil');

        if($req->segment(1) == 'admin')

        {
            if(empty($req->foto_profil))

            {

                Session::flash('fail', 'Foto Profil Harus Diisi');



                return redirect()->back();

            }

            else

            {

                $admin = Admin::find(Auth::guard('admin')->user()->id_admin);

                $name = $admin->id_admin.'_admin'.'.'.$foto->getClientOriginalExtension();



                if(!empty($admin->foto_profil))

                {

                    File::delete('images/admin/'.$admin->foto_profil);

                }



                $req->file('foto_profil')->move('images/admin/', $name);



                $admin->update(['foto_profil' => $name]);



                Session::flash('success', 'Foto Berhasil Diubah');

                

                return redirect()->route('admin.profil');                

            }


        }

        elseif($req->segment(1) == 'mahasiswa')

        {

            if(empty($req->foto_profil))

            {

                Session::flash('fail', 'Foto Profil Harus Diisi');



                return redirect()->back();

            }

            else

            {

                $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->user()->id_mahasiswa);

                $name = $mahasiswa->nim.'_mahasiswa'.'.'.$foto->getClientOriginalExtension();



                if(!empty($mahasiswa->foto_profil))

                {

                    File::delete('images/mahasiswa/'.$mahasiswa->foto_profil);

                }



                $req->file('foto_profil')->move('images/mahasiswa/', $name);



                $mahasiswa->update(['foto_profil' => $name]);



                Session::flash('success', 'Foto Berhasil Diubah');

                

                return redirect()->route('mahasiswa.profil');                

            }

        }

        elseif($req->segment(1) == 'dosen')

        {

            if(empty($req->foto_profil))

            {

                Session::flash('fail', 'Foto Profil Harus Diisi');



                return redirect()->back();

            }

            else

            {

                $dosen = Dosen::find(Auth::guard('dosen')->user()->id_dosen);

                $name = $dosen->nip.'_dosen'.'.'.$foto->getClientOriginalExtension();



                if(!empty($dosen->foto_profil))

                {

                    File::delete('images/dosen/'.$dosen->foto_profil);

                }



                $req->file('foto_profil')->move('images/dosen/', $name);



                $dosen->update(['foto_profil' => $name]);



                Session::flash('success', 'Foto Berhasil Diubah');

                

                return redirect()->route('dosen.profil');                

            }

        }

    }



    function hapus_foto(Request $req)

    {

        if($req->segment(1) == 'admin')

        {

            $admin = Admin::find(Auth::guard('admin')->user()->id_admin);



            File::delete('images/admin/'.$admin->foto_profil);

            $admin->update(['foto_profil' => null]);



            Session::flash('success', 'Foto Profil Berhasil Dihapus');



            return redirect()->route('admin.profil');

        }

        elseif($req->segment(1) == 'mahasiswa')

        {

            $mahasiswa = Mahasiswa::find(Auth::guard('mahasiswa')->user()->id_mahasiswa);



            File::delete('images/mahasiswa/'.$mahasiswa->foto_profil);

            $mahasiswa->update(['foto_profil' => null]);



            Session::flash('success', 'Foto Profil Berhasil Dihapus');



            return redirect()->route('mahasiswa.profil');

        }

        elseif($req->segment(1) == 'dosen')

        {

            $dosen = Dosen::find(Auth::guard('dosen')->user()->id_dosen);



            File::delete('images/dosen/'.$dosen->foto_profil);

            $dosen->update(['foto_profil' => null]);



            Session::flash('success', 'Foto Profil Berhasil Dihapus');



            return redirect()->route('dosen.profil');

        }

    }

}

