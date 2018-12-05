<?php

namespace App\Models;
use App\User;
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
    /**
     * @abstract 定义用户对咖啡店的喜爱和关注关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes(){
        return $this->belongsToMany(Cafe::class,'users_cafes_likes','cafe_id','user_id');
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

    /**
     * @abstract 获取当前登录用户和当前咖啡店之间的关注关系
     * @return $this
     */
    public function userLike(){
        return $this->belongsToMany(User::class, 'users_cafes_likes', 'cafe_id', 'user_id')->where('user_id', auth()->id());
    }

    /**
     * @abstract 标定咖啡店个某一个标签之间的关系
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Tags(){
        return $this->belongsToMany(Tag::class,'cafes_users_tags','cafe_id','tag_id');
    }

    /**
     * @abstract 标定咖啡店和咖啡店图标之间的关系
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photo(){
        return $this->hasMany(CafePhoto::class,'id','cafe_id');
    }
}
