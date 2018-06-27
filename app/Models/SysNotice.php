<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SysNotice extends Model
{
    //
    use SoftDeletes;

    protected $table= 'sys_notices';

    protected $fillable = [
                'title',
                'user_id',
                'type_id',
                'start_time',
                'end_time',
                'content',
            ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $types = [
        1 =>'新功能上线',
        2 =>'系统维护',
        3 =>'系统公告',
        4 =>'内部通知',
        5 =>'其它公告'
    ];
    
    public function getTypeTextAttribute()
    {
        return isset($this->types[$this->type]) ? $this->types[$this->type]: '其它公告';
    }
    
    public function getShortContentAttribute()
    {
        return mb_substr(strip_tags($this->content),0,20);
    }
    
    
    public function user()
    {
        return $this->belongsTo('App\Models\User')->select(['id','realname']);
    }
}
