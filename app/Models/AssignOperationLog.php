<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssignOperationLog extends Model
{
    use SoftDeletes;

    const ACTION_CHECK = '审核';
    const ACTION_UPDATE_WAYBILL = '更新面单';
    const ACTION_REPEAT = '返单';
    const ACTION_STOP = '拦截';
    const ACTION_EDIT_ADDRESS = '修改地址';
    const ACTION_EXPRESS_PRINT = '快递单打印';
    const ACTION_ASSIGN_PRINT = '发货单打印';
    const ACTION_GOODS_INSPECT = '验货';
    const ACTION_GOODS_DELIVERY = '同步发货';
    const ACTION_EDIT_EXPRESS_FEE = '修改运费';

    protected $table ='invoice_operation_records';

    protected $fillable=[
    	'assign_id',
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
            case 'check':
                return self::ACTION_CHECK;
                break;
            case 'update-waybill':
                return self::ACTION_UPDATE_WAYBILL;
                break;
            case 'repeat':
                return self::ACTION_REPEAT;
                break;
            case 'stop':
                return self::ACTION_STOP;
                break;
            case 'edit-address':
                return self::ACTION_EDIT_ADDRESS;
                break;
            case 'express-print':
                return self::ACTION_EXPRESS_PRINT;
                break;
            case 'assign-print':
                return self::ACTION_ASSIGN_PRINT;
                break;
            case 'goods-inspect'://该做这个了
                return self::ACTION_GOODS_INSPECT;
                break;
            case 'goods-delivery':
                return self::ACTION_GOODS_DELIVERY;
                break;
            case 'edit-express-fee':
                return self::ACTION_EDIT_EXPRESS_FEE;
                break;
            default:
                # code...
                break;
        }
    }


}
