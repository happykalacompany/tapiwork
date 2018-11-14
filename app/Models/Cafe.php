<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    /**
     * @abstract 定义咖啡店和冲调方法之间的关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function brewMethods(){
        return $this->belongsToMany(BrewMethod::class, 'cafes_brew_methods', 'cafe_id', 'brew_method_id');
    }

    //关于自身数据的关联

    /**
     * @abstract 获取分店数据
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(){
        return $this->hasMany(Cafe::class,'parent','id');
    }

    /**
     * @abstract 获取总店数据
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(){
        return $this->hasOne(Cafe::class,'id','parent');
    }
}
