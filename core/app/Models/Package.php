<?php

namespace App\Models;

use App\Models\PurchaseTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $fillable = [
        'title_en',
        'title_ar',
        'advantages_ar',
        'advantages_en',
        'price',
    ];

    public function purchase()
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }

    // protected $casts = [
    //     'advantages' => 'array',
    // ];
}
