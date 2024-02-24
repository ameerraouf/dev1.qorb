<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultingReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'chlidren_id',
        'type',
        'problem',
        'solution',
    ];

    function children(){
        return $this->belongsTo(Children::class);
    }
}
