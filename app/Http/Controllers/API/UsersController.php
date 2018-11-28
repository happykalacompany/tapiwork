<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
}
