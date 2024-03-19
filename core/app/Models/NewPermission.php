<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewPermission extends Model
{
    protected $table = 'new_permissions';

    protected $guarded = ['id'];

    use HasFactory;
}
