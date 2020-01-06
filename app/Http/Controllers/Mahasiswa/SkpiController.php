<?php

namespace App\Http\Controllers\Mahasiswa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OptionsController;



class SkpiController extends Controller
{
    public function index(){
    return view('pages/mahasiswa/skpi/index');
    }

    public function save(){
        return 'form terinput';
    }
}
?>