<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInfoRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        \Gate::authorize('view', 'users');
        $users = User::paginate(15);
        return UserResource::collection($users);
    }

    public function show($id){
        \Gate::authorize('view', 'users');

        $user = User::find($id);
        return new UserResource($user);
    }

    public function store(UserCreateRequest $request){
        \Gate::authorize('edit', 'users');
        $user = User::create($request->only('first_name', 'last_name', 'email', 'role_id') +['password' => Hash::make(1234)]);
        return response(new UserResource($user), 201);
    }

    public function update(UserUpdateRequest $request, $id){
        \Gate::authorize('edit', 'users');
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email', 'role_id'));
        return response(new UserResource($user), 202);
    }

    public function destroy($id){
        \Gate::authorize('edit', 'users');
        User::destroy($id);
        return response( null, 204);
    }

    public function user()
    {
        $user = \Auth::user();

        return (new UserResource($user))->additional([
            'data' => [
                'permissions' => $user->permissions()
            ]
        ]);
    }

    public function updateInfo(UpdateInfoRequest $request)
    {
        $user = \Auth::user();
        $user->update($request->only('first_name', 'last_name', 'email'));
        return response(new UserResource($user), 202);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = \Auth::user();
        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);
        return response(new UserResource($user), 202);
    }
}
