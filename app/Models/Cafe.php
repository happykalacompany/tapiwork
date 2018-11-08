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
}
