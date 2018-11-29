<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EditUserRequest;
class UsersController extends Controller
{
    /**
     * url:/api/v1/user
     * method:get
     * description:get current user
     */
    public function getUser(){
        return Auth::guard('api')->user();
    }

    /**
     * url:/api/v1/user
     * method:put
     * description:update user info data
     */
    public function putUpdateUser(EditUserRequest $request){
        //获取当前的登录用户
        $user = Auth::user();
        //获取表单传值
        $favorite_coffee = $request->input('favorite_coffee');
        $flavor_note = $request->input('flavor_note');
        $profile_visibility = $request->input('profile_visibility');
        $city = $request->input('city');
        $state = $request->input('state');
        //腐殖质对应的类属性
        if($favorite_coffee){
            $user->favorite_coffee = $favorite_coffee;
        }
        if($flavor_note){
            $user->flavor_note = $flavor_note;
        }
        if($profile_visibility){
            $user->profile_visibility = $profile_visibility;
        }
        if($city){
            $user->city = $city;
        }
        if($state){
            $user->state = $state;
        }
        //存储
        $user->save();
        return response()->json(['user_updated' => true],201);
    }
}
