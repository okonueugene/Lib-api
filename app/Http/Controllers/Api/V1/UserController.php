<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:add_user')->only(['store']);
        $this->middleware('permission:edit_user')->only(['update']);
        $this->middleware('permission:view_user')->only(['index', 'show']);
        $this->middleware('permission:delete_user')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {

        $user = new User($request->validated());
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole($request->role);

        return UserResource::make($user);

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $user->update($request->validated());

        return UserResource::make($user);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $user->delete();


        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function registerUnAuthenticatedUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'password_confirmed' => 'required|same:password',
        ]);

        try {
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            //assign user role
            $user->assignRole('user');

            return response()->json(['message' => 'User created successfully'], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
