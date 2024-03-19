<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_number',
        'sub_total',
        'discount',
        'shipping_cost',
        'tax',
        'platform_charge',
        'grand_total',
        'payment_method',
        'customer_comment',
        'error_msg'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::creating(function($model){
            $model->uuid =  Str::uuid()->toString();
        });
    }
}
