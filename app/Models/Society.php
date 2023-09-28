<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Society extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;

    public function jobApplySociety()
    {
        return $this->hasMany(JobApplySociety::class);
    }

    public function jobApplyPositions()
    {
        return $this->hasMany(JobApplyPosition::class);
    }

    public function validations()
    {
        return $this->hasMany(JobValidation::class, 'society_id', 'id');
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class);
    }
}
