<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireSurveyResults extends Model
{

    use SoftDeletes;

    protected $table = 'questionnaire_survey_results';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'cus_id',
        'questionnaire_options_id',
        'answer',
    ];



}
