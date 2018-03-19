<?php

Route::group(['prefix' => 'admin'], function () {
    Route::get('/menu/get', 'Admin\MenuController@get_menu');
    Route::group(['prefix' => 'weixin'], function () {
        Route::post("/config/set", 'Admin\WeixinController@set_config');
        Route::post("/config/get", 'Admin\WeixinController@get_config');

        Route::post("/template/set", 'Admin\WeixinController@set_wx_template');
        Route::post("/template/get", 'Admin\WeixinController@get_wx_template');

        Route::post("/reply/get", 'Admin\WeixinController@get_reply');
        Route::post("/reply/set", 'Admin\WeixinController@set_reply');
        Route::post("/follow/set", 'Admin\WeixinController@set_follow');
        Route::post("/news/set", 'Admin\WeixinController@set_news');

        Route::post("/reply/create", 'Admin\WeixinController@create_reply');
        Route::post("/reply/delete/{id}", 'Admin\WeixinController@delete_reply');

        Route::post("/industry", 'Admin\WeixinController@set_industry');
        Route::post("/update", 'Admin\WeixinController@add_template');
        Route::post("/auto_update", 'Admin\WeixinController@get_private_templates');
        Route::post("/menu/get", 'Admin\WeixinController@get_menu');
        Route::post("/menu/set", 'Admin\WeixinController@set_menu');

        Route::get('/group/get', 'Admin\WeixinController@get_wx_group');
        Route::get('/group/set', 'Admin\WeixinController@set_wx_group');
        Route::get('/group/move', 'Admin\WeixinController@move_wx_group');
        Route::get('/group/del', 'Admin\WeixinController@del_wx_group');
        Route::get('/group/menu/a/set', 'Admin\WeixinController@set_wx_group_menu_a');
        Route::get('/group/menu/b/set', 'Admin\WeixinController@set_wx_group_menu_b');
        Route::get('/menu/get', 'Admin\WeixinController@get_wx_menu');
        Route::get('/user/menu/get', 'Admin\WeixinController@get_wx_user_mennu');
    });

});

Route::group(['prefix' => 'News'],function (){
    Route::get('/getNewItem','Admin\News\NewController@getNewItem');
    Route::post('/delete','Admin\News\NewController@deleteNews');
    Route::post('/add','Admin\News\NewController@insertNews');
    Route::get('/getOneNew','Admin\News\NewController@getOneNew');
    Route::post('/update','Admin\News\NewController@updateNew');
});

Route::group(['prefix'=> 'Contact'],function(){
    Route::get('/getContent','Admin\Contact\ContactController@getContent');
    Route::post('/updateContent','Admin\Contact\ContactController@updateContent');
});
Route::group(['prefix'=> 'Road'],function(){
    Route::get('/getRoad','Admin\Road\roadController@getRoad');
    Route::post('/updateRoad','Admin\Road\roadController@updateRoad');
});
