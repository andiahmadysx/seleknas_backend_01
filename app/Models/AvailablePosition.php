<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailablePosition extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;

    public function jobApplyPositions()
    {
        return $this->hasMany(JobApplyPosition::class, 'position_id', 'id');
    }

    public function jobVacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id', 'id');
    }
}
