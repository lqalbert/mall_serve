<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressInfo extends Model
{
    use SoftDeletes;

		protected $table = 'express_info';

    private static $expressStatus = array(
        '未发货',
		'运输中',
		'待签收',
		'已签收'
    );
     
    public static function getExpressStatus($index = null)
    {
        if ($index === null) {
            return self::$expressStatus;
        } else if (is_numeric($index) && in_array(intval($index), array_keys(self::$expressStatus))) {
            return self::$expressStatus[$index];
        }
        return self::$expressStatus[0];
    }

    







}
