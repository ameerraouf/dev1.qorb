<?php

namespace App\Models;

use App\Models\PurchaseTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Children extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $append = [
    //     'name','problem'
    // ];

    // public $appends=['name','problem'];

    // public function getNameAttribute(){
    //     return app()->getLocale() == 'ar'?$this->name_ar:$this->name_en;
    // }

    // public function getProblemAttribute(){
    //     return app()->getLocale() == 'ar'?$this->problem_ar:$this->problem_en;
    // }
    public function mother(): BelongsTo
    {
        return $this->belongsTo(Teacher::class ,'teacher_id');
    }

    public function specialist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function firstMedia(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediable')->orderBy('file_sort', 'asc');
    }
    public function media(): MorphMany
    {
        return $this->MorphMany(Media::class, 'mediable');
    }

    function reports(){
        return $this->hasMany(Report::class);
    }

    function consulting_reports(){
        return $this->hasMany(ConsultingReport::class);
    }

    function status_reports(){
        return $this->hasMany(StatusReport::class);
    }

    function vbmap_reports(){
        return $this->hasMany(VbmapReport::class);
    }

    function final_reports(){
        return $this->hasMany(FinalReport::class);
    }

    function treatment_plans(){
        return $this->hasMany(TreatmentPlan::class);
    }
}
