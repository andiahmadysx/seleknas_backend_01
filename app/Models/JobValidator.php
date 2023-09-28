<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobValidator extends Model
{
    use HasFactory;
    protected  $guarded = [];
    public $timestamps = false;
    protected $table = 'validators';

    public function validations()
    {
        return $this->hasMany(JobValidation::class, 'validator_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
