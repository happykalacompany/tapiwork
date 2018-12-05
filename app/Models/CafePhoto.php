<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafePhoto extends Model
{
    protected $table = 'cafes_photos';

    /**
     * @abstract 定义的咖啡店和上传图片的关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cafe(){
        return $this->belongsTo(Cafe::class,'cafe_id','id');
    }

    /**
     * @abstract 定义用户和上传图片之间的关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'uploaded_by','id');
    }
}
