<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DepositOperationLog extends Model
{
    use SoftDeletes;

    const ACTION_CANCEL = '取消订单';
    const ACTION_CHECK = '审核订单';

    protected $table ='deposit_operation_log';

    protected $fillable=[
    	'order_id',
        'operator_id',
        'operator',
        'action',
        'remark'
    ];

    // protected $hidden = ['created_at', 'updated_at','deleted_at'];

    protected $dates = [
        'deleted_at'
    ];

    protected $appends = ['action_text'];

    public function getActionTextAttribute(){
        switch ($this->attributes['action']) {
            case 'cancel':
                return self::ACTION_CANCEL;
                break;
            case 'check':
                return self::ACTION_CHECK;
                break;
            default:
                # code...
                break;
        }
    }
}
