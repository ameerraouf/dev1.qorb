<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\NewPermission;
use App\Models\NewRole;
use App\Models\RolePermission;
use App\Models\WebmasterSection;
use Illuminate\Http\Request;

class NewRoleController extends Controller
{
    public function index() {

        $roles = NewRole::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view('dashboard.new-roles.list', compact('roles', 'GeneralWebmasterSections'));

    }

    public function create() {

        $permessions = NewPermission::all();
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view('dashboard.new-roles.create', compact('permessions', 'GeneralWebmasterSections'));

    }

    public function store(Request $request) {

        $request->validate([
            'role_ar' => 'required|string',
            'role_en' => 'required|string',
        ]);

        try {

            $role = NewRole::create([
                'name_ar' => $request->role_ar,
                'name_en' => $request->role_en
            ]);

            $permessions = $request->permissions;

            foreach($permessions as $item) {

                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $item
                ]);

            }
            return redirect()->action('Dashboard\NewRoleController@index')->with('doneMessage', __('backend.addDone'));
            
        }catch(\Exception $e) {

            return redirect()->action('Dashboard\NewRoleController@index')->with('errorMessage', __('backend.error'));
        }


    }


    public function edit(string $id) {

        
        $permessions = NewPermission::all();
        $role = NewRole::find($id);
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END
        return view('dashboard.new-roles.edit', compact('role', 'permessions','GeneralWebmasterSections'));

    }

    public function update(string $id, Request $request) {
        $role = NewRole::find($id);
        // General for all pages
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        // General END

        $request->validate([
            'role_ar' => 'required|string',
            'role_en' => 'required|string',
        ]);

        try {

            $role = NewRole::find($id)->update([
                'name_ar' => $request->role_ar,
                'name_en' => $request->role_en
            ]);

            $permessions = $request->permissions;

            RolePermission::where('role_id', $id)->delete();
            foreach($permessions as $item) {
                RolePermission::create([
                    'role_id' => $id,
                    'permission_id' => $item
                ]);

            }
            return redirect()->action('Dashboard\NewRoleController@index')->with('doneMessage', __('backend.saveDone'));
            
        }catch(\Exception $e) {

            return redirect()->action('Dashboard\NewRoleController@index')->with('errorMessage', __('backend.error'));
        }
    }

    public function destroy(string $id) {
        
        $role = NewRole::find($id);

        RolePermission::where('role_id', $id)->delete();

        $role->delete();

        return redirect()->action('Dashboard\NewRoleController@index')->with('doneMessage', __('backend.deleteDone'));


    }

}
