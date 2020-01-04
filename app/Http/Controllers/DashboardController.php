<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Admin;
use App\Mahasiswa;
use App\Prodi;

class DashboardController extends Controller
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

    function index()
    {
    	return view('pages.home');
    }

    function mahasiswa()
    {
    	return view('pages.admin.mahasiswa.index');
    }

    function dosen()
    {
    	return view('pages.admin.dosen.index');
    }

    function prodi()
    {
    	$prodi = Prodi::all();
    	return view('pages.admin.prodi.index', compact('prodi'));
    }
}
