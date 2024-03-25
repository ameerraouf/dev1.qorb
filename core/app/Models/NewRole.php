<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewRole extends Model
{
    protected $table = 'new_roles';

    protected $guarded = [];

    use HasFactory;

    public function permissions():HasMany 
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'id');
    }

    public function hasPermission($role_id, $permission_id) {

        $check = RolePermission::where('role_id', $role_id)->where('permission_id', $permission_id)->first();

        if ($check) {

            return true;

        }else {
            return false;
        }

    }
}
