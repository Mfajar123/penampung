<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;

use App\Role;
use App\RoleLink;
use App\Menu;


class RoleController extends Controller
{

    protected function datatables()
    {
        $no = 1;
        $data = [];

        $list_role = Role::get();

        foreach ($list_role as $list) {
            $list['no'] = $no++;
            $list['aksi'] = '
                <a href="'.route('role_link.set', $list->id_role).'" title="Set User Role"><i class="fa fa-cog"></i></a>&nbsp;
                <a href="#" class="btn-edit" title="Edit" data-id="'.$list->id_role.'"><i class="fa fa-edit"></i></a>&nbsp;
                <a href="#" class="btn-hapus" title="Hapus" data-id="'.$list->id_role.'"><i class="fa fa-trash"></i></a>
            ';

            $data[] = $list;
        }

        return DataTables::of($data)->escapeColumns([])->make(true);
    }

    protected function index()
    {
        return view('pages.admin.role.index');
    }

    protected function simpan(Request $request)
    {
        $input = $request->all();

        $role = Role::create($input);

        return response()->json(['status' => 'success', 'role' => $role], 200);
    }

    protected function edit($id)
    {
        $role = Role::findOrFail($id);

        return response()->json(['status' => 'success', 'role' => $role], 200);
    }

    protected function perbarui($id, Request $request)
    {
        $role = Role::findOrFail($id);
        
        $role->update($request->all());

        return response()->json(['status' => 'success'], 200);
    }

    protected function hapus($id)
    {
        $role = Role::findOrFail($id);
        
        $role->delete();

        return response()->json(['status' => 'success'], 200);
    }

    protected function restore($id)
    {
        $role = Role::findOrFail($id);
        
        $role->update(['is_delete' => 'N']);

        return response()->json(['status' => 'success'], 200);
    }

    protected function role_edit($id)
    {
        $role = Role::findOrFail($id);
        
        $menu = Menu::where(['parent_id_1' => null, 'is_delete' => 'N'])->orderBy('menu_position', 'ASC')->get();

        $i = 0;

        $role_before = array();

        $role_existing = RoleLink::where('id_role', $id)->get();
        foreach ($role_existing as $role_existing_data) {
            $role_before[$role_existing_data->id_menu]['can_access'] = $role_existing_data->can_access;
            $role_before[$role_existing_data->id_menu]['can_create'] = $role_existing_data->can_create;
            $role_before[$role_existing_data->id_menu]['can_modify'] = $role_existing_data->can_modify;
            $role_before[$role_existing_data->id_menu]['can_delete'] = $role_existing_data->can_delete;
            $role_before[$role_existing_data->id_menu]['see_restricted'] = $role_existing_data->see_restricted;

            $role_before[$role_existing_data->id_menu]['all'] = ($role_existing_data->can_access == '1' and $role_existing_data->can_create == '1' and $role_existing_data->can_modify == '1' and $role_existing_data->can_delete == '1' and $role_existing_data->see_restricted == '1') ? '1' : '0';

        }

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
                    $list_menu[$i]['child'][] = $row_parent_1;

                    $j = 0;

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
                            $list_menu[$i]['child'][$j]['child'][] = $row_parent_2;

                            $j++;

                        }
                    }

                }
            }

            $i++;
        }

        $list_menu = json_decode(json_encode($list_menu));

        return view('pages.admin.role.role_edit', compact('id', 'role', 'list_menu', 'role_before'));
    }

    protected function save_role($id, Request $request)
    {
        $role = Role::findOrFail($id);
        RoleLink::where('id_role', $id)->delete();

        $menu = Menu::where(['is_delete' => 'N'])->get();

        foreach($menu as $m){

            $data = array();
            
            $data['id_role'] = $id;
            $data['id_menu'] = $m->id_menu;

            if(!empty($_POST['can_access'][$m->id_menu])){
                $data['can_access'] = "1";
            }
            
            if(!empty($_POST['can_create'][$m->id_menu])){
                $data['can_create'] = "1";
            }
            
            if(!empty($_POST['can_modify'][$m->id_menu])){
                $data['can_modify'] = "1";
            }
            
            if(!empty($_POST['can_delete'][$m->id_menu])){
                $data['can_delete'] = "1";
            }
            
            if(!empty($_POST['see_restricted'][$m->id_menu])){
                $data['see_restricted'] = "1";
            }

            RoleLink::create($data);

        }

        return redirect()->route('role.index');
    }
}
