<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogisticsInformation extends Model
{
    protected $table = 'company_code';
    protected $fillable = [
        'company_name',
        'code',
        'eng',
    ];
}
