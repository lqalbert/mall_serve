<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderOperationLog extends Model
{
    use SoftDeletes;

    const ACTION_ADD = '创建订单';
    const ACTION_EDIT = '编辑订单';
    const ACTION_DELETE = '删除订单';
    const ACTION_CANCEL = '取消订单';
    const ACTION_CHECK = '审核订单';
    const ACTION_AFTER_SALE = '订单售后';

    protected $table ='order_operation_log';

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
            case 'add':
                return self::ACTION_ADD;
                break;
            case 'edit':
                return self::ACTION_EDIT;
                break;
            case 'delete':
                return self::ACTION_DELETE;
                break;
            case 'cancel':
                return self::ACTION_CANCEL;
                break;
            case 'check':
                return self::ACTION_CHECK;
                break;
            case 'after-sale':
                return self::ACTION_AFTER_SALE;
                break;
            default:
                # code...
                break;
        }
    }

}
