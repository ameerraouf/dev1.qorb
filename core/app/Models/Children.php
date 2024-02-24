<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
        return $this->belongsTo(Teacher::class);
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
