<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'],function(){

    /**
     * Url: /api/v1/user
     * Controller: API\UsersController@getUser
     * Method: get
     * Description: get current user
     */

    Route::get('/user','API\UsersController@getUser');

    /**
     * Url: /api/v1/cafes
     * Controller: API\CafesController@getCafes
     * Method: get
     * Description: get all cafes in the application
     */
    Route::get('/cafes','API\CafesController@getCafes');

    /**
     * Url: /api/v1/cafe/{id}
     * Controller: API\CafesController@getCafe
     * Method: get
     * Description: get a cafe detail
     */
    Route::get('/cafe/{id}','API\CafesController@getCafe');

    /**
     * Url: /api/v1/brew_methods
     * Controller: API\BrewMethodsController@getBrewMethods
     * Method: get
     * Description: get all BrewMethod with the count of cafe
     */
    Route::get('/brew_methods','API\BrewMethodsController@getBrewMethods');

    /**
     * Url:/api/v1/tags
     * Controller:API\CafesController@getTags
     * Method:delete
     * Description:delete cafe tag
     */
    Route::get('/tags','API\TagsController@getTags');
});

//需要登录的路由组
Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'],function(){
    /**
     * Url: /api/v1/cafes 
     * Controller: API\CafesController@postNewCafe 
     * Method: post
     * Description: add new cafe
     */
    Route::post('/cafes', 'API\CafesController@postNewCafe');

    /**
     * Url: /api/v1/cafes/{id}/like
     * Controller: API\CafesController@postLikeCafe
     * Method: post
     * Description: post cafe like data
     */
    Route::post('/cafes/{id}/like','API\CafesController@postLikeCafe');

    /**
     * Url: /api/v1/cafes/{id}/like
     * Controller: API\CafesController@deleteLikeCafe
     * Method: delete
     * Description: delete cafe like data
     */
    Route::delete('/cafes/{id}/like','API\CafesController@deleteLikeCafe');

    /**
     * Url:/api/v1/cafe/{id}/tags
     * Controller:API\CafesController@postAddTags
     * Method:Post
     * Desxription:add cafe tags
     */
    Route::post('/cafe/{id}/tags','API\CafesController@postAddTags');

    /**
     * Url:/api/v1/cafe/{id}/tags/{tagId}
     * Controller:API\CafesController@deleteCafeTags
     * Method:delete
     * Description:delete cafe tag
     */
    Route::delete('/cafe/{id}/tags/{tagId}','API\CafesController@deleteCafeTags');
});
