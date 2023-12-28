<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view_roles');
    //     $this->middleware('permission:add_roles');
    //     $this->middleware('permission:edit_roles');
    //     $this->middleware('permission:delete_roles');
    // }
    public function index()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return response()->json(['data' => $roles]);

    }
}
