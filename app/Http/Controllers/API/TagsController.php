<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * url:/api/v1/tags
     * method:get
     * description:get tags data
     */
    public function getTags(Request $request){
        //获取
        $search = Request::get('search');
        if($search == '' || $search == null){
            $tags = Tag::all();
        }else{
            $tags = Tag::where('name','like',$search."%")->get();
        }
        return response()->json($tags,201);
    }
}
