<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get roles
        $roles = Role::when(request()->q, function($roles) {
            $roles = $roles->where('name', 'like', '%'. request()->q . '%');
        })->with('permissions')->latest()->paginate(5);

        //render with inertia
        return inertia('Apps/Roles/Index', [
            'roles' => $roles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //get permission all
        $permissions = Permission::all();

        //render with inertia
        return inertia('Apps/Roles/Create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /**
         * Validate request
         */
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        //create role
        $role = Role::create(['name' => $request->name]);

        //assign permissions to role
        $role->givePermissionTo($request->permissions);

        //redirect
        return redirect()->route('apps.roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get role
        $role = Role::with('permissions')->findOrFail($id);

        //get permission all
        $permissions = Permission::all();

        //render with inertia
        return inertia('Apps/Roles/Edit', [
            'role'          => $role,
            'permissions'   => $permissions,
        ]);
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
        /**
         * validate request
         */
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        //update role
        $role->update(['name' => $request->name]);

        //sync permissions
        $role->syncPermissions($request->permissions);

        //redirect
        return redirect()->route('apps.roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find role by ID
        $role = Role::findOrFail($id);

        //delete role
        $role->delete();

        //redirect
        return redirect()->route('apps.roles.index');
    }
}