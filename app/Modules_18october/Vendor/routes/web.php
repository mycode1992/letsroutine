<?php

Route::group(['module' => 'Vendor', 'middleware' => ['web'], 'namespace' => 'App\Modules\Vendor\Controllers'], function() {

  //  Route::get('vendor', 'VendorController');
    Route::get('/vendor/myprofile', 'VendorController@myprofil');
    Route::get('/vendor/current-order', 'VendorController@current_order');
    Route::get('/vendor/menu-details/{id}', 'VendorController@menu_details');
    Route::get('/vendor/menu-list', 'VendorController@menu_list');
    Route::get('/vendor/add-meal', 'VendorController@add_meal');
    Route::get('/vendor/edit-meal/{id}', 'VendorController@add_meal');
    
    Route::get('/vendor/meal-list', 'VendorController@meal_list');   
    Route::get('/vendor/package-info', 'VendorController@package_info');  
    Route::get('/vendor/add-package', 'VendorController@add_package');  
    Route::post('/vendor/save_package', 'VendorController@save_package'); 
    Route::get('/vendor/edit-package/{id}', 'VendorController@add_package'); 
    
    Route::get('/vendor/offer', 'VendorController@offer');   
    Route::get('/vendor/add-menu', 'VendorController@add_menu');  
     Route::get('/vendor/edit-menu/{id}', 'VendorController@edit_menu');  
    Route::get('/vendor/plan-listing', 'VendorController@plan_listing');   
    Route::get('/vendor/view-detail/plan/{id}', 'VendorController@plan_viewdetail'); 
    Route::get('/vendor/setting', 'VendorController@setting');   
    Route::get('/vendor/add-plan', 'VendorController@add_plan');   
    Route::get('/vendor/edit-plan/{id}', 'VendorController@add_plan');
    Route::post('/vendor/save_plan', 'VendorController@save_plan'); 
    Route::post('/vendor/changeplan_sub_cat', 'VendorController@changeplan_sub_cat'); 
    Route::get('/vendor/logout', 'VendorController@logout'); 
    Route::post('/vendor/update_profile', 'VendorController@update_profile'); 
    Route::post('/vendor/profilepic', 'VendorController@profilepic'); 
    Route::post('/vendor/change_password', 'VendorController@change_password'); 
    Route::get('/vendor/notification_and_announcement', 'VendorController@notification_and_announcement'); 
    Route::get('/vendor/report-problem', 'VendorController@report_problem'); 
    Route::get('/vendor/delivery-area-info', 'VendorController@delivery_area_info'); 
    Route::get('/vendor/delivery-centre-available', 'VendorController@delivery_centre_available'); 
    Route::post('/vendor/save_problem', 'VendorController@save_problem'); 
    Route::post('/vendor/readmore', 'VendorController@readmore'); 
    Route::post('/vendor/save_meal', 'VendorController@save_meal'); 
    Route::post('/vendor/save_meal_menu', 'VendorController@save_meal_menu'); 
    
    Route::post('/vendor/save_custom_menu', 'VendorController@save_custom_menu'); 
    
    Route::post('/vendor/change_area', 'VendorController@change_area'); 
    Route::post('/deleterowstatus', 'VendorController@deleterowstatus');
    Route::post('/deleterow', 'VendorController@deleterow');
    Route::post('/deleteallrow', 'VendorController@deleteallrow');
    Route::post('/vendor/showmeal_menu', 'VendorController@showmeal_menu');
    Route::post('/vendor/edit_showmeal_menu', 'VendorController@edit_showmeal_menu');
    Route::post('/vendor/save_menu', 'VendorController@save_menu');
    Route::post('/vendor/edit_save_menu', 'VendorController@edit_save_menu');
    Route::post('/vendor/save_governorate_area', 'VendorController@save_governorate_area');
    Route::post('/vendor/save_deliverytime', 'VendorController@save_deliverytime');
    Route::post('/vendor/save_vendor_availability_status', 'VendorController@save_vendor_availability_status');

    Route::post('/vendor/get_meal_data', 'VendorController@get_meal_data');
    Route::get('/vendor/plan/calender/{id}', 'VendorController@plan_calender'); 
    Route::post('/vendor/plan/changemenucategory', 'VendorController@plan_changemenucat'); 
    Route::post('/vendor/plan/changemeal', 'VendorController@plan_changemeal'); 
    Route::post('/vendor/plan/changemenucategory_snacks', 'VendorController@plan_changemenucat_snacks'); 
    Route::post('/vendor/plan/changemeal_snacks', 'VendorController@plan_changemeal_snacks'); 
    Route::post('/vendor/plan/save_plan_detail', 'VendorController@save_plan_detail'); 
    Route::post('/vendor/plan/update_plan_detail', 'VendorController@update_plan_detail'); 
    Route::post('/vendor/plan/edit-plan-detail', 'VendorController@edit_plan_detail'); 
    Route::post('/vendor/plan/get_meal_edit', 'VendorController@get_meal_edit'); 

    
    
});
