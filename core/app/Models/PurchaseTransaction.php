<?php

namespace App\Models;

use App\Models\Package;
use App\Models\Teacher;
use App\Models\Children;
use App\Models\SubService;
use App\Models\MainService;
use App\Models\TeacherSubscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['main_service_id','sub_service_id','children_ids','teacher_id','package_id','price' /* other fillable fields */];


    public function main_service()
    {
        return $this->belongsTo(MainService::class);
    }

    public function sub_service()
    {
        return $this->belongsTo(SubService::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

}
