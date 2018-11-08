<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BrewMethod;
//use 
class BrewMethodsController extends Controller
{
    /**
     * 获取所有的冲调方式及对应方式下所属的咖啡店的数量
     *
     * url: /api/v1/brew_methods
     * method: get
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBrewMethods(){
        $brewMethods = BrewMethod::withCount('cafes')->get();
        return response()->json($brewMethods);
    }
}
