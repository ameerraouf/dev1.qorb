<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'children_id',
        'companion',
        'status_type',
        'strength_weakness',
        'reinforcers',
        'status_target',
    ];

    function children(){
        return $this->belongsTo(Children::class);
    }
}
