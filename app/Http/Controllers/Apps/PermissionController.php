<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // get permission 
        $permissions = Permission::when($request->q, function ($permissions) use ($request) {
            $permissions = $permissions->where('name', 'like', "%$request->q%");
        })->latest()->paginate(5);

        // return inertia view
        return inertia('Apps/Permissions/Index', [
            'permissions' => $permissions
        ]);
    }
}
