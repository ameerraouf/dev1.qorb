<?php

namespace App\Models;

use App\Models\SubService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainService extends Model
{
    use HasFactory;

    public function subServices()
    {
        return $this->hasMany(SubService::class);
    }
}
