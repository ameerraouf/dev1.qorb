<?php

namespace App\Models;
use App\Models\PurchaseTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

    protected $table = "teachers";
    protected $guard = 'teacher';
    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function childrens()
    {
        return $this->hasMany(Children::class);
    }

    public function purchase()
    {
        return $this->belongsTo(PurchaseTransaction::class);
    }
}
