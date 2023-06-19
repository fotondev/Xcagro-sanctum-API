<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;

class ListUsers extends Controller
{
   public function __invoke(Request $request)
   {
      $users = User::query()
         ->orderBy($request->sortBy ?? 'name', $request->sortOrder ?? 'asc')
         ->paginate();

      return (UserResource::collection($users))
         ->response()
         ->setStatusCode(200);
   }
}
