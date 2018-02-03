<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/login", 'LoginController@index');
Route::post("/login", 'LoginController@login');
//Route::get('/', function () {
//    return view('welcome');
//});
Route::group(['prefix' => 'wx'], function () {
    Route::get("/", function(){
    	return view('wx');
    });
//    Route::get("/tee", function(){
//        return view('News');
//    });

//    require("wx.php");
});

Route::group(['prefix'=>'News'],function(){

    Route::get('/getNew','wx\getNewController@getNews_show');
    Route::get('/new','wx\getNewController@getNew_show');
    Route::get('/getNewTime','wx\getNewController@getNewsTime_show');
});

Route::group(['middleware' => ['login.check']], function () {
    Route::get('/', 'IndexController@index');
    include('admin.php');
});

Route::group(['prefix'=>'student'],function (){
    Route::get('/getStudents','userInfoController@getStudents');
    Route::get('/getStudent','userInfoController@getStudent');
});