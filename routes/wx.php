<?php
//测试专用
Route::any('/test', 'Wx\IndexController@test');

Route::post('/train', 'Wx\TrainController@sign');
Route::post('/sign', 'Wx\WxSignUpController@sign');

Route::post('/search', 'Wx\WxSignUpController@search');

Route::post('/reset', 'Wx\WxSignUpController@reset');


Route::group(['prefix' => 'algorithm'], function () {
	Route::post('/selectNewPractice', 'Wx\algorithm\wxAlgorithmController@get_new_algorithm');
	Route::post('/selectAllPractice', 'Wx\algorithm\wxAlgorithmController@get_all_algorithms');
	Route::post('/selectDetailedContent', 'Wx\algorithm\wxAlgorithmController@get_detailed_algorithms');
});
