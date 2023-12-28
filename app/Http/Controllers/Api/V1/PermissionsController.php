<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_permissions');
    //     $this->middleware('permission:add_permissions');
    //     $this->middleware('permission:edit_permissions');
    //     $this->middleware('permission:delete_permissions');
    // }
    public function index()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return response()->json(['data' => $permissions]);
    }
}
