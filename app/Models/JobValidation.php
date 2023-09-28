<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobValidation extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;
    protected $table = 'validations';


    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function validator()
    {
        return $this->belongsTo(JobValidator::class, 'validator_id', 'id');
    }

    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id', 'id');
    }
}
