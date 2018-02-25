<?php
//测试专用
Route::any('/test', 'Wx\IndexController@test');

Route::post('/train', 'Wx\TrainController@sign');