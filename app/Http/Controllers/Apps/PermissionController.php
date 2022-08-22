<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        //get permissions
        $model = Permission::when(request()->q, function ($permissions) {
            $permissions = $permissions->where('name', 'like', '%' . request()->q . '%');
        });

        // jika ada request sort dan validasi di dalam array
        if ($request->has(['dir', 'sort'])) {
            $dir = $request->dir == 'desc' ? 'desc' : 'asc';
            $name = $request->sort;
            $model->orderBy($name, $dir);
        }

        $permissions = $model->paginate(5)
            ->appends(request()->query());

        //return inertia view
        return inertia('Apps/Permissions/Index', [
            'permissions' => $permissions
        ]);
    }
}
