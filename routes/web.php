<?php



Route::get("/login", 'LoginController@index');
Route::post("/login", 'LoginController@login');

Route::group(['prefix' => 'wx'], function () {
    Route::get("/", function(){
    	return view('wx');
    });

    include("wx.php");

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

