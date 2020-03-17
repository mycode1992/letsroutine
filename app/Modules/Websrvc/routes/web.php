<?php

Route::group(['module' => 'Websrvc', 'middleware' => ['web'], 'namespace' => 'App\Modules\Websrvc\Controllers'], function() {

    Route::any('/websrvc/changepassword/{token}', 'WebsrvcController@changepassword'); 
    Route::post('/websrvc/changepasswordinsert', 'WebsrvcController@changepasswordinsert');
    Route::get('/websrvc/Aboutus', 'WebsrvcController@Aboutus'); 
	


});
