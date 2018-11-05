<?php
/**
 * Created by PhpStorm.
 * User: lf
 * Date: 2018/10/30
 * Time: 15:18
 */
namespace app\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Response;
use Socialite;
use Auth;

class AuthenticationController extends Controller{

    /**
     * @abstract 登录界面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin(){
        return view('login');
    }


    /**
     * @abstract 跳转到第三方OAuth获取验证码页面的路由
     * @param $account
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSocialRedirect($account){
        try{
            return Socialite::with($account)->redirect();
        }catch(\InvalidArgumentException $e){
            return redirect('/login');
        }
    }

    /**
     * @abstract 第三档登录的
     * @param $account
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function getSocialCallback($account){
        //首先通过第三方的OAuth获取用户的信息
        $socialUser = Socialite::with($account)->user();
        //查询数据库中的用户信息
        $user = User::where('provider_id','=',$socialUser->id)
            ->where('provider','=',$account)
            ->first();
        //查询用户为空的情况下保存为一个新的用户
        if($user == null){
            $newUser = new User();
            $newUser->name = $socialUser->getName();
            $newUser->email = $socialUser->getEmail() == ''?'':$socialUser->getEmail();
            $newUser->avatar = $socialUser->getAvatar();
            $newUser->password = '';
            $newUser->provider = $account;
            $newUser->provider_id = $socialUser->getId();
            $newUser->save();
            $user = $newUser;
        }
        //登录用户
        Auth::login($user);
        //跳转到主页
        return redirect('/#/home');
    }
}