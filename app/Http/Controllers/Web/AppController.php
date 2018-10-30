<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 2018/10/30
 * Time: 14:19
 */

namespace app\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class AppController extends Controller{

    /**
     * @abstract 应用进入控制器函数
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getApp(){
        return view('app');
    }

}