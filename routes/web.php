<?php

Route::get('/', 'AppController@index');

Route::get('search','DaDataController@search');

Route::post('change','DaDataController@change');