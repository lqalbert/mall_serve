<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireOptions extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_options';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'questionnaire_managements_id',
        'problem_type',
        'topic_name',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'option_e',
    ];
}
