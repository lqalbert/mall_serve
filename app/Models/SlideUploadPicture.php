<?php
/**
 * Created by PhpStorm.
 * User: YRG
 * Date: 2018/7/30
 * Time: 15:22
 */

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlideUploadPicture extends Model
{
    use SoftDeletes;

    protected $table= 'slide_upload_picture';

    CONST TOP_IMG =1;
    CONST IMPORTANT_GOODS =2;
    CONST GOOD_GOODS = 3;
    CONST SHOW_MID = 4;
    CONST IMG_TEXT = 5;
    CONST SHOW_BOTTOM = 6;

    protected $dates=[
        'deleted_at'
    ];

    /**
     * 可以被批量赋值的属性
     */
    protected $fillable = [
        'user_id',
        'goods_id',
        'name',
        'picture_sort',
        'cover_url',
        'classify',
        'href_url',
        'description'
    ];

    protected  $hidden = ['updated_at', 'deleted_at','created_at'];

}