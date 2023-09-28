<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;


    public function availablePositions()
    {
        return $this->hasMany(AvailablePosition::class);
    }

    public function jobApplySociety()
    {
        return $this->hasMany(JobApplySociety::class);
    }

    public function jobApplyPosition()
    {
        return $this->hasMany(JobApplyPosition::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id', 'id');
    }
}
