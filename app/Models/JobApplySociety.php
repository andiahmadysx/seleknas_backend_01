<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;

    public function jobApplyPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'job_apply_societies_id', 'id');
    }

    public function society ()
    {
        return $this->belongsTo(Society::class);
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
