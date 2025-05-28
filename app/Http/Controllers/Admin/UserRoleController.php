<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRoleUpdateRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class UserRoleController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(UserRoleUpdateRequest $request, User $user)
    {
        Gate::authorize('update', $user);
        $user = $request->updateUserRole();

        return response([
            'message' => __('users.role_update'),
            'user' => new UserResource($user),
        ]);
    }
}
