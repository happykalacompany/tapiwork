<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    /**
     * @abstract 标定标签和咖啡店之间的关系，这里还关联了用户
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function cafes(){
        return $this->belongsToMany(Cafe::class,'cafes_users_tags','tag_id','user_id');
    }
}
