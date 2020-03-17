<?php

Route::group(['module' => 'Websrvc', 'middleware' => ['api'], 'namespace' => 'App\Modules\Websrvc\Controllers'], function() {

    // Route::resource('websrvc', 'WebsrvcController');
	Route::any('/websrvc/AreaList', 'WebsrvcController@AreaList');
	Route::any('/websrvc/UserLogin', 'WebsrvcController@UserLogin');
	Route::any('/websrvc/RegisterUser', 'WebsrvcController@RegisterUser');  
	Route::any('/websrvc/LoginUser', 'WebsrvcController@LoginUser'); 
	Route::any('/websrvc/ForgotPassword', 'WebsrvcController@ForgotPassword'); 
	Route::any('/websrvc/GetPageLinks', 'WebsrvcController@Aboutus'); 

});
