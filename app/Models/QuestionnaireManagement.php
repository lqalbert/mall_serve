<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionnaireManagement extends Model
{
    use SoftDeletes;

    protected $table = 'questionnaire_managements';

    protected $dates = [
        'deleted_at'
    ];
    protected $hidden = ['updated_at','deleted_at'];
    protected $fillable = [
        'title',
        'start_time',
        'end_time',
        'user_id',
        'user_name',
    ];
}
