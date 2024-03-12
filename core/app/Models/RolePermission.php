<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model
{
    protected $table = 'new_roles_permission';

    protected $guarded = [];

    use HasFactory;

    public function permission(): BelongsTo 
    {

        return $this->belongsTo(NewPermission::class, 'permission_id');

    }

    public function role(): BelongsTo
    {

        return $this->belongsTo(NewRole::class, 'role_id');

    }
}
