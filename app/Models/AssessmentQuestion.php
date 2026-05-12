<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['module_name', 'module', 'question_text', 'options'];

    protected $casts = [
        'options' => 'array',
    ];
}
