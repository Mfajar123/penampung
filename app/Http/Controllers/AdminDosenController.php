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



use App\Dosen;

use App\DosenPendidikan;

use App\DosenJabatan;

use App\Prodi;



class AdminDosenController extends Controller

{

    public function __construct()

    {

        $this->middleware('auth:admin');

    }



    public function datatable(Request $req)

    {

        $data = array();

        $no = 1;



        if(!empty($req->segment(4)))

        {

            $dosen = Dosen::where('is_delete', 'Y')->get();

        }

        else

        {

            $dosen = Dosen::where('is_delete', 'N')->get();

        }

        foreach ($dosen as $list)

        {

            $toTrash = "'Anda Yakin Akan Menghapus dosen ".$list->nama."'";

            $hapus = "'Anda Yakin Akan Menghapus Permanen dosen ".$list->nama."'";

            $restore = "'Anda Yakin Akan Mengembalikan Data dosen ".$list->nama."'";



            $row = array();

            $row['no'] = $no;

            $row['nip'] = $list->nip;

            $row['nama'] = $list->gelar_depan. ' ' .$list->nama. ' ' .$list->gelar_belakang  ;

            $row['nama_prodi'] = $list->prodi->nama_prodi;

            if($list->status_dosen == 1)

            {

                $row['status_dosen'] = "Dosen Tetap";

            }else{

                $row['status_dosen'] = "Dosen Luar";

            }

            if(!empty($req->segment(4)))

            {

                $row['aksi'] =

                '<a href="'.route('admin.dosen.restore', $list->id_dosen).'" class="btn btn-success btn-sm" title="Restore" onclick="return confirm('.$restore.')" title="Restore"><i class="fa fa-mail-reply"></i></a>

                <a href="'.route( 'admin.dosen.hapus.permanent', $list->nip).'" class="btn btn-danger btn-sm"  title="Hapus Permanen"onclick="return confirm('.$hapus.')" title="Hapus Permanen"><i class="fa fa-trash-o"></i></a>';

            }

            else

            {

                $row['aksi'] =

                '

                <a href="'.route('admin.dosen.detail', $list->nip).'" class="btn btn-info btn-sm" title="Detail"><i class="fa fa-search"></i></a>

                <a href="'.route('admin.dosen.ubah', $list->id_dosen).'" class="btn btn-warning btn-sm" title="Ubah"><i class="fa fa-edit"></i></a>
                
                <a href="'.route('admin.dosen.reset_password', $list->id_dosen).'" class="btn btn-default btn-sm" title="Reset Password" onclick="return confirm(Anda yakin mereset password dosen tersebut?)"><i class="fa fa-refresh"></i></a>

                <a href="'.route('admin.dosen.hapus', $list->id_dosen).'" class="btn btn-danger btn-sm" title="Hapus" onclick="return confirm('.$toTrash.')"><i class="fa fa-trash-o"></i></a>';

            }



            $data[] = $row;

            $no++;

        }

        return DataTables::of($data)->escapeColumns([])->make(true);

    }



    public function trash()

    {

        return view('pages.admin.dosen.trash');

    }



    public function tambah()

    {

        $jabatan = DosenJabatan::pluck('nama', 'id_dosen_jabatan');

        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');

        return view('pages.admin.dosen.tambah', compact('jabatan', 'prodi'));

    }



    private function uploadFoto(Request $request){

        $foto = $request->file('foto_profil');

        $ext = $foto->getClientOriginalExtension();



        if($request->file('foto_profil')->isValid()){

            $namaFoto = date('YmdHis')."_dosen.".$ext;

            $upload_path = 'images/dosen';

            $request->file('foto_profil')->move($upload_path,$namaFoto);

            return $namaFoto;

        }

        return false;

      }



    public function simpan(Request $request)

    {

        $system = new SystemController();

        $input = $request->all();

        $status = $request->status_dosen;

        $tahun = date('y');

        $huruf_awal = "194".$status.$tahun;

    	$last_data = DB::select(DB::raw("SELECT * FROM m_dosen WHERE nip LIKE '$huruf_awal%' ORDER BY id_dosen DESC "));

    	if (empty($last_data)) {

    		$next_id = "1";

    		$nol = "00";

    	}else{

    		$last_data = $last_data[0]->nip;

    		$explode = explode($huruf_awal, $last_data);

    		$next_id = $explode[1]+1;

    		$nol = substr("000", 0, 3 - strlen($next_id));

    	}

    	$ref_baru = $huruf_awal.$nol.$next_id;

    	$input['nip'] = $ref_baru;



        if ($request->hasFile('foto_profil')) {

        	$input['foto_profil'] = $this->uploadFoto($request);

    	}

        $input['create_by'] = Auth::guard('admin')->user()->nama;

        $input['create_date'] = date('Y-m-d H:i:s');

        // $input['password'] = $system->crypt(date('dmY', strtotime($request->tgl_lahir)), 'e');

        $input['password'] = $system->encrypt('123', $ref_baru, $ref_baru);

        Dosen::create($input);

        DosenPendidikan::create($input);

        Session::flash('success', 'Dosen Berhasil Ditambahkan');



        return redirect()->route('admin.dosen');

    }



    public function detail($id)

    {

        $system = new SystemController();

        $dsn = Dosen::where('nip', $id)->get();

        $pendidikan = DosenPendidikan::where('nip', $id)->get();



        return view('pages.admin.dosen.detail', compact('dsn', 'pendidikan', 'system'));

    }



    public function toTrash($id)

    {

        Dosen::find($id)->update(['delete_by' => Auth::guard('admin')->user()->nama, 'delete_date' => date('Y-m-d H:i:s'),'is_delete' => 'Y']);



        Session::flash('fail', 'Data Dosen Berhasil Dihapus.');



        return redirect()->route('admin.dosen');

    }



    public function restore($id)

    {

        Dosen::find($id)->update(['is_delete' => 'N']);



        Session::flash('success', 'Data Dosen Berhasil Dikembalikan.');



        return redirect()->route('admin.dosen.trash');

    }



    public function hapus($id)

    {

        $dosen = Dosen::where('nip',$id)->delete();

        $pendidikan = DosenPendidikan::where('nip', $id)->delete();

        Session::flash('success', 'Data Dosen Berhasil Dihapus');



        return redirect()->route('admin.dosen.trash');

    }



    public function ubah($id)

    {

        $jabatan = DosenJabatan::pluck('nama', 'id_dosen_jabatan');

        $prodi = Prodi::pluck('nama_prodi', 'id_prodi');
        
        

        $dosen = Dosen::leftjoin('m_dosen_pendidikan', 'm_dosen_pendidikan.nip', 'm_dosen.nip')->find($id);
        
        $tgl_lahir = date('d-M-Y', strtotime( $dosen->tgl_lahir ));
        
        $tgl_skyys = date('d-M-Y', strtotime( $dosen->tgl_skyys ));
        
       
        return view('pages.admin.dosen.ubah', compact('dosen', 'id', 'jabatan', 'prodi', 'tgl_lahir', 'tgl_skyys'));

    }



    public function perbarui($id, Request $request)

    {

        $dosen = Dosen::leftjoin('m_dosen_pendidikan', 'm_dosen_pendidikan.nip', 'm_dosen.nip')->find($id);

        $system = new SystemController();

        $input = $request->all();

        if(!empty($request->foto_profil)){

            foreach (Dosen::where('id_dosen', $id)->get() as $foto) {

                $currentFoto = 'images/dosen/'.$foto->foto_profil;

            }

            if (@$currentFoto) {

                File::delete($currentFoto);

            }

        }

        if($request->status_dosen != $dosen->status_dosen)

        {

            $status = $request->status_dosen;

            $tahun = date('y');

            $huruf_awal = "194".$status.$tahun;

            $last_data = DB::select(DB::raw("SELECT * FROM m_dosen WHERE nip LIKE '$huruf_awal%' ORDER BY id_dosen DESC "));

            if (empty($last_data)) {

                $next_id = "1";

                $nol = "00";

            }else{

                $last_data = $last_data[0]->nip;

                $explode = explode($huruf_awal, $last_data);

                $next_id = $explode[1]+1;

                $nol = substr("000", 0, 3 - strlen($next_id));

            }

            $ref_baru = $huruf_awal.$nol.$next_id;

            $nip = $ref_baru;

        }

        else

        {
            $bnyk_dosen = Dosen::where('nip', $request->nip)->first();
            
                if(!empty($bnyk_dosen->nip) )
                {
                    $nip = $dosen->nip;
                    
                }
                else
                {
                    $nip = $request->nip;
                }
            
        }

        $input['nip'] = $nip;

        if ($request->hasFile('foto_profil')) {

            $input['foto_profil'] = $this->uploadFoto($request);

        }
        
        $input['tgl_lahir'] = date('d-M-Y', strtotime( $request->tgl_lahir ));
        
        $input['update_by'] = Auth::guard('admin')->user()->nama;

        $input['update_date'] = date('Y-m-d H:i:s');

        // $input['password'] = $system->crypt(date('dmY', strtotime($request->tgl_lahir)), 'e');
        
        $input['password'] = $system->encrypt('123', $nip, $nip);

        $dospen = DosenPendidikan::where('nip', $request->nip)->first();
        
            if( empty($dospen->nip)  )
            {
                DosenPendidikan::create(['nip' => $input['nip'], 'jenjang' => $request->jenjang, 'nama_sekolah' => $request->nama_sekolah, 'jurusan' => $request->jurusan, 'gelar' => $request->gelar, 'konsentrasi' => $request->konsentrasi]);
            }else{
                 DosenPendidikan::where('nip', $dosen->nip)->update(['nip' => $input['nip'], 'jenjang' => $request->jenjang, 'nama_sekolah' => $request->nama_sekolah, 'jurusan' => $request->jurusan, 'gelar' => $request->gelar, 'konsentrasi' => $request->konsentrasi]);
            }

       

        $dosen->update($input);
        
        $all_dosen = Dosen::all();
            
           
            // $bnyk_dosen = Dosen::where('nip', $request->nip)->first();
            
            //     if(!empty($bnyk_dosen->nip) )
            //     {
            //          Session::flash('fail', 'Data NIP sudah digunakan'.  $bnyk_dosen->nama);
            //     }
            //     else
            //     {
                    Session::flash('success', 'Data Dosen Berhasil Diperbarui.'  );
                
                // }



        return redirect()->route('admin.dosen');

    }
    
    public function reset_password($id_dosen){
        
        $system = new SystemController();

        $profil = Dosen::findOrFail($id_dosen);
        
        $password = $system->encrypt('123', $profil->nip, $profil->nip);
        $profil->update(['password' => $password]);
        
        Session::flash('success', 'Password dosen berhasil direset');

        return redirect()->route('admin.dosen');
    }

}

