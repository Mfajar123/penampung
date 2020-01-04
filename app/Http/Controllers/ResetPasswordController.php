<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;



use File;

// use Auth;

// use Session;

use DB;

use DataTables;



// use App\Dosen;

// use App\DosenPendidikan;

// use App\DosenJabatan;

// use App\Prodi;



class ResetPasswordController extends Controller

{

/*
    public function __construct()

     {

    //     $this->middleware('auth:admin');

     }
*/


    
    public function test(){
        echo "test";        
    }

    public function reset_password($id_dosen){
        
        $system = new SystemController();

        $profil = Dosen::findOrFail($id_dosen);
        
        $password = $system->encrypt('123', $profil->nip, $profil->nip);
        $profil->update(['password' => $password]);
        
        echo "berhasil";
        
    //    Session::flash('success', 'Password dosen berhasil direset');

    //    return redirect()->route('admin.dosen');
    }

}

