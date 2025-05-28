<?php

namespace App\Models;

use Laratrust\Models\Role as RoleModel;

class Role extends RoleModel
{
    public $guarded = [];

    ## Other methods

    public function remove(): bool
    {
        $this->permissions()->detach();
        $this->delete();
        return true;
    }
}
