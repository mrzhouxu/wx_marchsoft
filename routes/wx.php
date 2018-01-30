<?php
//测试专用
Route::any('/test', 'Wx\IndexController@test');

Route::post('/sign', 'Wx\WxSignUpController@sign');

Route::post('/search', 'Wx\WxSignUpController@search');

Route::post('/reset', 'Wx\WxSignUpController@reset');