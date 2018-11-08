<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrewMethod extends Model
{
    /**
     * @abstract 定义冲调方法和咖啡店之间的多对多关联
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cafes(){
        return $this->belongsToMany(Cafe::class, 'cafes_brew_methods', 'brew_method_id', 'cafe_id');
    }
}
