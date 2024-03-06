<?php

namespace App\Models;

use App\Models\Children;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EarlyDetectionReport extends Model
{
    use HasFactory;

    function child(){
        return $this->belongsTo(Children::class);
    }
}
