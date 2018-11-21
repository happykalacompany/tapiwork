<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 2018/11/21
 * Time: 10:17
 */

namespace App\Utilities;
use App\Models\Tag;

class Tagger
{
    /**
     * @abstract 关联标签，用户和咖啡店的函数
     * @param $userid 用户id
     * @param $tags 标签数组
     * @param $cafe 咖啡店的对象
     */
    public static function tagsCafe($userid,$tags,$cafe){
        //循环传递进来的标签然后和cafe建立关联
        foreach ($tags as $key=>$value){
            $tagName = trim($value);
            $newTag = Tag::firstOrNew(['name' => $tagName]);
            $newTag->name = $tagName;
            $newTag->save();
            $cafe->Tags()->syncWithoutDetaching([$newTag->id => ['user_id' => $userid]]);
        }
    }
}