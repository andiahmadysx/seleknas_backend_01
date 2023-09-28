<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobCategory extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;
    public function validations()
    {
        return $this->hasMany(JobValidation::class, 'job_category_id', 'id');
    }

    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class, 'job_category_id', 'id');
    }
}
