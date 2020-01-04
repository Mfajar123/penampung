<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;

use App\Menu;

class MenuController extends Controller
{
    public function index()
    {
        
        $list_menu = array();
        $func = 'index';

        $menu = Menu::where(['parent_id_1' => null, 'is_delete' => 'N'])->orderBy('menu_position', 'ASC')->get();

        $i = 0;

        foreach ($menu as $m)
        {
            $row = array();
            $row['id_menu'] = $m->id_menu;
            $row['parent_id_1'] = null;
            $row['parent_id_2'] = null;
            $row['parent_id_3'] = null;
            $row['nama_menu'] = $m->nama_menu;
            $row['link_menu'] = $m->link_menu;
            $row['icon_menu'] = $m->icon_menu;

            $list_menu[$i] = $row;

            $parent_id_1 = Menu::where(['parent_id_1' => $m->id_menu, 'is_delete' => 'N'])->orderBy('menu_position', 'ASC')->get();

            if (count($parent_id_1) > 0)
            {

                $j = 0;
                foreach ($parent_id_1 as $parent_1)
                {

                    $row_parent_1 = array();
                    $row_parent_1['id_menu'] = $parent_1->id_menu;
                    $row_parent_1['parent_id_1'] = $parent_1->parent_id_1;
                    $row_parent_1['parent_id_2'] = null;
                    $row_parent_1['parent_id_3'] = null;
                    $row_parent_1['nama_menu'] = $parent_1->nama_menu;
                    $row_parent_1['link_menu'] = $parent_1->link_menu;
                    $row_parent_1['icon_menu'] = $parent_1->icon_menu;
                    $list_menu[$i]['child'][$j] = $row_parent_1;

                    $parent_id_2 = Menu::where(['parent_id_1' => $parent_1->id_menu, 'is_delete' => 'N'])->orderBy('menu_position', 'ASC')->get();

                    if (count($parent_id_2) > 0)
                    {

                        foreach ($parent_id_2 as $parent_2)
                        {

                            $row_parent_2 = array();
                            $row_parent_2['id_menu'] = $parent_2->id_menu;
                            $row_parent_2['parent_id_1'] = $parent_2->parent_id_1;
                            $row_parent_2['parent_id_2'] = $parent_2->parent_id_2;
                            $row_parent_2['parent_id_3'] = null;
                            $row_parent_2['nama_menu'] = $parent_2->nama_menu;
                            $row_parent_2['link_menu'] = $parent_2->link_menu;
                            $row_parent_2['icon_menu'] = $parent_2->icon_menu;
                            $list_menu[$i]['child'][$j]['child'][] = $parent_2;

                        }
                    }
                    
                    $j++;

                }
            }

            $i++;
        }

        $list_menu = json_decode(json_encode($list_menu));

        // var_dump($list_menu);

        $list_menu2 = array();
        // $menu = Menu::all();

        $menu2 = Menu::where(['parent_id_1' => null, 'parent_id_2' => null, 'parent_id_3' => null, 'is_delete' => 'N'])->get();
        
        $list_menu2[''] = '- no parent -';

        foreach ($menu2 as $m)
        {
            $list_menu2[$m->id_menu] = $m->nama_menu;

            $parent_id_1 = Menu::where(['parent_id_1' => $m->id_menu, 'parent_id_2' => null, 'parent_id_3' => null, 'is_delete' => 'N'])->get();

            if (count($parent_id_1) > 0)
            {
                foreach ($parent_id_1 as $parent_1)
                {
                    $list_menu2[$parent_1->id_menu] = '- - '.$parent_1->nama_menu;
                }
            }
        }

        return view('pages.admin.menu.index', compact('list_menu', 'list_menu2'));
    }


    public function save_position(Request $request)
    {

        $i = 0;
        foreach ($request->position as $pos) {
            
            // echo $pos.$request->id_menu[$i].'<br>';

            $menu = Menu::findOrFail($request->id_menu[$i]);

            $input = array();
            $input['menu_position'] = $i;

            $update = $menu->update($input);

            $i++;
        }

        return redirect()->route('menu.index');

    }

    public function trash()
    {

        $list_menu = array();
        $func = 'trash';

        $menu = Menu::where(['is_delete' => 'Y'])->get();

        foreach ($menu as $m)
        {
            $row = array();
            $row['id_menu'] = $m->id_menu;
            $row['parent_id_1'] = null;
            $row['parent_id_2'] = null;
            $row['parent_id_3'] = null;
            $row['nama_menu'] = $m->nama_menu;
            $row['link_menu'] = $m->link_menu;
            $row['icon_menu'] = $m->icon_menu;

            $list_menu[] = $row;
        }
        $list_menu = json_decode(json_encode($list_menu));
        return view('pages.admin.menu.index', compact('list_menu', 'func'));
    }


    protected function simpan(Request $request)
    {
        $input = $request->all();
        $input['parent_id_1'] = $request->menu_sub;

        if($input['id_menu'] != ''){

            $menu = Menu::findOrFail($input['id_menu']);
            $menu->update($input);

        }else{
            $menu = Menu::create($input);
        }

        return redirect()->route('menu.index');
        // return response()->json(['status' => 'success', 'menu' => $menu], 200);
    }

    protected function edit($id)
    {
        $menu = Menu::findOrFail($id);

        return response()->json(['status' => 'success', 'menu' => $menu], 200);
    }

    protected function perbarui($id, Request $request)
    {
        $menu = Menu::findOrFail($id);
        
        $input = $request->all();
        $input['parent_id_1'] = $request->menu_sub;

        $menu->update($input);

        return response()->json(['status' => 'success'], 200);
    }

    protected function hapus($id)
    {
        $menu = Menu::findOrFail($id);
        
        $menu->update(['is_delete' => 'Y']);

        return response()->json(['status' => 'success'], 200);
    }

    protected function restore($id)
    {
        $menu = Menu::findOrFail($id);
        
        $menu->update(['is_delete' => 'N']);

        return response()->json(['status' => 'success'], 200);
    }

}
