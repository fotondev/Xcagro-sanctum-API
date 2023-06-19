<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteUser extends Controller
{
    public function __invoke(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
