<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_role');
        $this->middleware('permission:add_role');
        $this->middleware('permission:edit_role');
        $this->middleware('permission:delete_role');
    }
    public function index()
    {
        $roles = \Spatie\Permission\Models\Role::all();
        return response()->json(['data' => $roles]);

    }
}
