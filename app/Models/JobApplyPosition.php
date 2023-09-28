<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyPosition extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;


    public function society()
    {
        return $this->belongsTo(Society::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }

    public function availablePosition()
    {
        return $this->belongsTo(AvailablePosition::class, 'position_id', 'id');
    }

    public function jobApplySociety()
    {
        return $this->belongsTo(JobApplySociety::class, 'job_apply_societies_id', 'id');
    }
}
