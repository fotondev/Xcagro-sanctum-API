<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class EditUser extends Controller
{
    public function __invoke(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
    }
}
