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

    public function save(Request $request)
    {
        request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
 
        if ($files = $request->file('image')) {
 
            $image = $request->image->store('images/skpi');
             
            return Response()->json([
                "success" => true,
                "image" => $image
            ]);
 
        }
 
        return Response()->json([
                "success" => false,
                "image" => ''
            ]);
 
    }
}

?>