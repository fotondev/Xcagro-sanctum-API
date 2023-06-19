<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ShowUser extends Controller
{
    public function __invoke(User $user)
    {
        return (new UserResource($user))
        ->response()
        ->setStatusCode(200);
    }
}
