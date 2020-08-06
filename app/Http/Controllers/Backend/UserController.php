<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api', 'verified']);
        $this->middleware('role:Super Admin|Admin')->only(['index']);
        $this->middleware('role:Super Admin')->only(['getUser', 'addRoleToUsers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return UserResource::collection(User::all());
    }

    public function getUser(Request $request)
    {
        $user = User::whereId($request->id)->get();

        return UserResource::collection($user);
    }


    public function addRoleToUsers(Request $request)
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $role = null;

        if ((int)$request->role === 1) {
            $role = 'Super Admin';
        }

        if ((int)$request->role === 2) {
            $role = 'Admin';
        }

        if ((int)$request->role === 3) {
            $role = 'User';
        }


        $user = User::findOrFail((int)$request->id);
        $user->syncRoles($role);
        $user = User::whereId((int)$request->id)->get();
        return UserResource::collection($user);
    }
}
