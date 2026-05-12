<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'module_name', 'title', 'score', 'mood', 'stress', 'remarks', 'answers'];

    protected $casts = [
        'answers' => 'array',
    ];
}
