<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;



use File;

use Auth;

use Session;

use DB;

use DataTables;



use App\Admin;

use App\HakAkses;

use App\Jenjang;
use App\Role;

use App\StatusMahasiswa;



class KaryawanController extends Controller

{



    public function __construct()

    {

        $this->middleware('auth:admin');

    }



    public function datatable(Request $req)

    {

        $system = new SystemController();

        $data = array();

        $no = 1;



        if(!empty($req->segment(4)))

        {
            $admin = Admin::where('is_delete', 'Y')->whereNotIn('username', ['cahyanto'])->get();

        }

        else

        {
            $admin = Admin::where('is_delete', 'N')->whereNotIn('username', ['cahyanto'])->get();

        }

        $system = New SystemController();

        foreach ($admin as $list)

        {
            $toTrash = "'Anda Yakin Akan Menghapus Karyawan ".$list->nama."'";
            $hapus = "'Anda Yakin Akan Menghapus Permanen Karyawan ".$list->nama."'";
            $restore = "'Anda Yakin Akan Mengembalikan Data Karyawan ".$list->nama."'";
            
            if(empty($list->tgl_lahir))
            {
                $ttl = $list->tmp_lahir;
            }
            elseif(empty($list->tmp_lahir))
            {
                $ttl = date('d M Y', strtotime($list->tgl_lahir));
            }
            else
            {
                $ttl = $list->tmp_lahir.", ".date('d-m-Y', strtotime($list->tgl_lahir));
            }

            $pass = $system->decrypt($list->password, $list->username, $list->username);

            $row = array();
            $row['no'] = $no;
            $row['username'] = $list->username;
            $row['nama'] = $list->nama;
            $row['ttl'] = $ttl;
            $row['jenkel'] = $list->jenkel;
            $row['alamat'] = $list->alamat;

            if(!empty($req->segment(4)))
            {
                $row['aksi'] =
                '<a href="'.route('admin.karyawan.restore', $list->id_admin).'" class="btn btn-success btn-sm" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>
                <a href="'.route( 'admin.karyawan.hapus.permanen', $list->id_admin).'" class="btn btn-danger btn-sm" onclick="return confirm('.$hapus.')" title="Hapus Permanen" data-auth="'.$pass.'"><i class="fa fa-trash-o"></i></a>';
            }
            else
            {
                $row['aksi'] =
                '<a href="'.route('admin.karyawan.detail', $list->id_admin).'" class="btn btn-info btn-sm" title="detail"><i class="fa fa-search"></i></a>
                <a href="'.route('admin.karyawan.akses.ubah', $list->id_admin).'" class="btn btn-success btn-sm" title="Hak Akses"><i class="fa fa-eye"></i></a>
                <a href="'.route('admin.karyawan.ubah', $list->id_admin).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                <a href="'.route('admin.karyawan.hapus', $list->id_admin).'" class="btn btn-danger btn-sm" onclick="return confirm('.$toTrash.')" data-auth="'.$pass.'"><i class="fa fa-trash-o"></i></a>';
            }


            $data[] = $row;
            $no++;

        }

        return DataTables::of($data)->escapeColumns([])->make(true);

    }



    public function trash()

    {

        return view('pages.admin.karyawan.trash');

    }


    public function tambah()
    {

        $role = Role::pluck('role_name', 'id_role');

        return view('pages.admin.karyawan.tambah', compact('role'));

    }



    public function simpan(Request $request)

    {

        $system = new SystemController();



        $foto = $request->file('foto_profil');



        $input = $request->all();

        $input['created_by'] = Auth::guard('admin')->user()->nama;
        
        $input['tgl_lahir'] = date('Y-m-d', strtotime( $request->tgl_lahir ));

        $input['password'] = $system->encrypt('123', $request->username, $request->username);

        if (trim($request->username) != '' || trim($request->nama) != '') {
            # code...
            if(Admin::where('username', 'LIKE', '%'.$request->username.'%')->count() > 0)
            {
                Session::flash('fail', 'Username Sudah Digunakan !');


                return redirect()->back()->withInput($request->all());
            }
            else
            {
                if (empty($request->foto_profil)) {
                    # code...
                    Admin::create($input);


                    Session::flash('success', 'Karyawan Berhasil Ditambahkan');
                }else{
                    $ext = $foto->getClientOriginalExtension();


                    if ($foto->isValid())
                    {
                        $foto_name = date('dmYHis').'_admin.'.$ext;
                        $upload_path = 'images/admin/';
                        $request->file('foto_profil')->move($upload_path, $foto_name);
                        $input['foto_profil'] = $foto_name;
                        Admin::create($input);


                        Session::flash('success', 'Karyawan Berhasil Ditambahkan');
                    }
                }
                
                $admin = Admin::where('username', $request->username)->first();
                
                HakAkses::create(['id_admin' => $admin->id_admin]);
            }
                

        }else{
            Session::flash('fail', 'Nama Atau Username Wajib Diisi.');


            return redirect()->back()->withInput($request->all());

        }



         return redirect()->route('admin.karyawan');

    }



    public function ubah($id)

    {

        $role = Role::pluck('role_name', 'id_role');
        $karyawan = Admin::find($id);
        
        $tgl_lahir = date('d-M-Y', strtotime($karyawan->tgl_lahir));

        return view('pages.admin.karyawan.ubah', compact('karyawan','role', 'id', 'tgl_lahir'));

    }



    public function perbarui($id, Request $request)

    {

        $admin = Admin::find($id);



        $input = $request->all();

        $input['updated_by'] = Auth::guard('admin')->user()->nama;
        
        $input['tgl_lahir'] = date('Y-m-d', strtotime( $request->tgl_lahir ));

        $foto = $request->file('foto_profil');



        if(Admin::where('username', 'LIKE', '%'.$request->username.'%')->whereNotIn('username', [$admin->username])->count() > 0)

        {
            Session::flash('fail', 'Username Sudah Digunakan !');


            return redirect()->back()->withInput($request->all());

        }

        else

        {
            if(!empty($request->foto_profil))
            {
                $ext = $foto->getClientOriginalExtension();
                $foto_name = date('dmYHis').'_admin.'.$ext;
                $upload_path = 'images/admin/';


                File::delete($upload_path.$admin->foto_profil);
                $request->file('foto_profil')->move($upload_path, $foto_name);
                $input['foto_profil'] = $foto_name;


                $admin->update($input);
            }
            else
            {
                $admin->update($input);   
            }

        }



        Session::flash('success', 'Data Karyawan Berhasil Diperbarui.');



        return redirect()->route('admin.karyawan');

    }



    public function toTrash($id)

    {

        Admin::find($id)->update(['is_delete' => 'Y']);



        Session::flash('fail', 'Data Karyawan Berhasil Dihapus.');



        return redirect()->route('admin.karyawan');

    }



    public function status()

    {

        return view('pages.admin.mahasiswa.status');

    }



    public function ubahAkses($id)

    {

        $karyawan  = Admin::leftjoin('tbl_menu', 'tbl_menu.id_admin', 'm_admin.id_admin')->find($id);

        return view('pages.admin.karyawan.akses', compact('id', 'karyawan'));

    }



    public function perbaruiAkses(Request $req, $id)

    {

        $input = $req->except(['_token']);

        $input['id_admin'] = $id;

        $input['m_mahasiswa'] = (!empty($req->m_mahasiswa)) ? $req->m_mahasiswa : 'N';

        $input['m_dosen'] = (!empty($req->m_dosen)) ? $req->m_dosen : 'N';

        $input['m_karyawan'] = (!empty($req->m_karyawan)) ? $req->m_karyawan : 'N';

        $input['m_matkul'] = (!empty($req->m_matkul)) ? $req->m_matkul : 'N';



        HakAkses::where('id_admin', $id)->update($input);



        Session::flash('success', 'Hak Akses Berhasil Diperbarui');



        return redirect()->route('admin.karyawan');

    }



    public function detail($id)

    {

        $karyawan = Admin::find($id);

        $system = new SystemController();



        return view('pages.admin.karyawan.detail', compact('karyawan', 'system'));

    }



    public function restore($id)

    {

        Admin::find($id)->update(['is_delete' => 'N']);



        Session::flash('success', 'Data Karyawan Berhasil Dikembalikan.');



        return redirect()->route('admin.karyawan.trash');

    }



    public function hapus($id)

    {

        $admin = Admin::find($id);



        HakAkses::where('id_admin', $admin->id_admin)->delete();



        if(!empty($admin->foto_profil))

        {
            File::delete('images/admin/'.$admin->foto_profil);

        }



        $admin->delete();



        Session::flash('success', 'Data Karyawan Berhasil Dihapus');



        return redirect()->route('admin.karyawan.trash');

    }

}

