<?php

Route::group(['module' => 'Website', 'middleware' => ['web'], 'namespace' => 'App\Modules\Website\Controllers'], function() {

    Route::get('/', 'WebsiteController@index');      
    Route::get('/about', 'WebsiteController@about_us');  
    Route::get('/terms-condition', 'WebsiteController@terms_condition');
    Route::get('/privacy-policy', 'WebsiteController@privacy_policy');
    Route::get('/contact', 'WebsiteController@contact');
    Route::post('/storecontact', 'WebsiteController@storecontact');
    Route::get('/faq', 'WebsiteController@faq');     
    Route::get('/signup', 'WebsiteController@signup');

    ////////logincontrollet
    Route::get('/login', 'LoginController@login');
    Route::get('/forgot-password', 'LoginController@forgot_password');
    Route::post('/post_forgot_password', 'LoginController@post_forgot_password');  
    Route::post('/changepasswordinsert', 'LoginController@changepasswordinsert');  
    Route::get('/changepassword/{id}', 'LoginController@changepassword');
    Route::post('/login_check', 'LoginController@login_check');  
    Route::post('/register', 'WebsiteController@register');
    Route::get('/vendor/verify-email/{id?}', 'LoginController@verify_email');

   
    
    

});
