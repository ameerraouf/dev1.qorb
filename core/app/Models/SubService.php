<?php

namespace App\Models;

use App\Models\MainService;
use App\Models\PurchaseTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubService extends Model
{
    use HasFactory;

    public function main_service()
    {
        return $this->belongsTo(MainService::class);
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }
}
