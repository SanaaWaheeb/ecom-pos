<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\DataTables\RoleDataTable;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
    }

    public function index(RoleDataTable $dataTable)
    {
        if(auth()->user() && auth()->user()->isAbleTo('Manage Role'))
        {
            //$roles = Role::where('name', '!=', 'super admin')->where('created_by', '=', auth()->user()->creatorId())->get();
            
            return $dataTable->render('roles.index');
           // return view('roles.index',compact('roles'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        $permissions = Permission::all()->pluck('name', 'id')->toArray();
        $modules = array_merge(['General'], getModuleList());
        return view('roles.create', ['permissions' => $permissions, 'modules' => $modules]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user() && auth()->user()->isAbleTo('Create Role'))
        {
            $existRole =  Role::where('name', $request->name)->where('store_id', getCurrentStore())->first();
            if ($existRole && $existRole->created_by != auth()->user()->id) {
                return redirect()->back()->with('error', __('The role is already being used in another account.'));
            }

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        Rule::unique('roles')->where(function ($query) {
                        return $query->where('created_by', \Auth::user()->id);
                        })
                    ],
                    'permissions' => 'required',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $name             = $request['name'];
            $role             = new Role();
            $role->name       = $name;
            // $role->store_id   = getCurrentStore();
            $role->guard_name  = 'web';
            $role->created_by = Auth::user()->creatorId();
            $role->store_id   = getCurrentStore();
            $permissions      = $request['permissions'];
            $role->save();

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermission($p);
            }

            return redirect()->back()->with('success', __('Role successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // $permissions = Permission::all()->pluck('name', 'id')->toArray();
        $user = \Auth::user();

        $modules = array_merge(['General'],getshowModuleList());
        $permissions = Permission::pluck('name', 'id')->toArray();
        $rolePermissions = new Collection();
        foreach($user->roles as $role1)
        {
            $rolePermissions = $rolePermissions->merge($role1->permissions);
        }
        $rolePermissions = $rolePermissions->pluck('name', 'id')->toArray();
        return view('roles.edit', compact('role', 'modules', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        
        if(auth()->user() && auth()->user()->isAbleTo('Edit Role'))
        {
            $existRole =  Role::where('name', $request->name)->where('store_id', getCurrentStore())->where('id', '!=', $role->id)->first();
            if ($existRole && $existRole->created_by != auth()->user()->id) {
                return redirect()->back()->with('error', __('The role is already being used in another account.'));
            }
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id,created_by,' . \Auth::user()->creatorId().',store_id,' . getCurrentStore(),
                    'permissions' => 'required',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $input['name'] = $request['name'];
            
            $userIds = DB::table('role_user')->where('role_id', $role->id)->pluck('user_id')->toArray();
            User::whereIn('id', $userIds)->update(['type' => $input['name']]);
            $permissions = $request['permissions'];
            $input['store_id']   = getCurrentStore();
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)
            {
                $role->removePermission($p);
            }

            $role->syncPermissions($permissions);
            // foreach($permissions as $permission)
            // {
            //     $p = Permission::where('id', '=', $permission)->firstOrFail();
            //     $role->givePermission($p);
            // }

            return redirect()->back()->with('success', __('Role successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        
        if(auth()->user() && auth()->user()->isAbleTo('Delete Role'))
        {
            $role->delete();

            return redirect()->route('roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
