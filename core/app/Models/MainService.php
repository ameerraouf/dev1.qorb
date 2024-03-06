<?php

namespace App\Models;

use App\Models\SubService;
use App\Models\PurchaseTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MainService extends Model
{
    use HasFactory;

    protected $fillable = ['name_ar' , 'name_en'];

    public function subServices()
    {
        return $this->hasMany(SubService::class);
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }
}
