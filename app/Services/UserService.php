<?php

namespace App\Services;

use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
    public static function get(Request $request)
    {
        return User::query()
            ->with('roles:id,name')
            ->select(['id', 'name', 'email', 'created_at'])
            ->filter($request->search, ['name', 'email'])
            ->latest('id')
            ->paginate(10);
    }

    public static function create(UserRequest $userRequest)
    {
        $user = User::create($userRequest->safe()->only('name', 'email', 'password'));
        return $user;
    }

    public static function update(UserRequest $userRequest, User $user)
    {

        if ($userRequest->filled('name')) {
            $user->fill($userRequest->safe()->only('name'));
        }
        if ($userRequest->filled('email')) {
            $user->fill($userRequest->safe()->only('email'));
        }
        if ($userRequest->filled('password')) {
            $user->fill($userRequest->safe()->only('password'));
        }

        $user->save();

        return $user;
    }
}
