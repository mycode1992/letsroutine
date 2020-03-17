<?php

Route::group(['module' => 'Admin', 'middleware' => ['web'], 'namespace' => 'App\Modules\Admin\Controllers'], function() {

  //   login Controller
  Route::get('/lradmin', 'LoginController@get_login');
  Route::post('/lradmin/login', 'LoginController@login');
  Route::get('/lradmin/logout', 'LoginController@logout');
  Route::get('/lradmin/edit_profile', 'LoginController@edit_profile');
  Route::post('/lradmin/remove_profile' , 'LoginController@remove_profile');
  Route::post('/lradmin/update_profile', 'LoginController@update_profile');
  Route::post('/lradmin/edit-profile/change_password' , 'LoginController@change_password');
  Route::get('/iladmin/forgot-password', 'LoginController@forgot_password');
  Route::post('/lradmin/forgot-password', 'LoginController@forgotpassword');
  Route::get('/lradmin/changepassword/{id?}', 'LoginController@changepassword');
  Route::post('/lradmin/changepasswordinsert', 'LoginController@changepasswordinsert');



  //cms controller
  Route::get('/lradmin/cms/about-us', 'CmsController@about_us');
  Route::post('/lradmin/cms/update_aboutus', 'CmsController@update_aboutus');
  Route::get('/lradmin/cms/terms-condition', 'CmsController@terms_condition');
  Route::post('/lradmin/cms/update_terms', 'CmsController@update_terms');
  Route::get('/lradmin/cms/privacy-policy', 'CmsController@privacy_policy');
  Route::post('/lradmin/cms/update_policy', 'CmsController@update_policy');
  Route::get('/lradmin/cms/faq', 'CmsController@faq');
  Route::get('/lradmin/cms/governorate', 'CmsController@governorate');
  Route::get('/lradmin/cms/add-governorate', 'CmsController@add_governorate');
  Route::get('lradmin/cms/edit-governorate/{id}', 'CmsController@add_governorate');
  Route::post('/lradmin/cms/save_governorate', 'CmsController@save_governorate');
  Route::get('/lradmin/cms/view-area/{id}', 'CmsController@view_area');
  Route::get('/lradmin/cms/add-area/{governorateid}', 'CmsController@add_area');
  Route::post('/lradmin/cms/save_area', 'CmsController@save_area');
  Route::get('/lradmin/cms/edit-area/{governorateid}/{governorateareaid}', 'CmsController@add_area');
  Route::get('/lradmin/cms/add-faq/{id?}', 'CmsController@add_faq');
  Route::post('/lradmin/cms/submit_faq', 'CmsController@submit_faq');




  //  admin controller
  Route::get('/lradmin/dashboard', 'AdminController@dashboard');
  Route::get('lradmin/contact-query', 'AdminController@contact_query');
  Route::post('/lradmin/readmore', 'AdminController@readmore');
  Route::get('/export/exportcon_queries', 'AdminController@exportcon_queries');
  Route::post('/lradmin/changestatus', 'AdminController@changestatus');


  // vendor controller
  Route::get('lradmin/vendor/add-vendor', 'VendorController@add_vendor');
  Route::post('/lradmin/vendor/save_sender', 'VendorController@save_sender');
  Route::get('lradmin/vendor/manage-vendor/{id}', 'VendorController@manage_vendor');
  Route::get('/lradmin/export/exportvendor/{id}', 'VendorController@exportvendor');
  Route::get('lradmin/vendor/edit-vendor/{id}', 'VendorController@add_vendor');
  Route::get('lradmin/vendor/edit-vendor/{id}', 'VendorController@add_vendor');
  Route::get('/lradmin/vendor/menu-category', 'VendorController@menu_category');
  Route::get('/lradmin/vendor/add-menu-category', 'VendorController@add_menu_category');
  Route::get('lradmin/cms/edit-menu-category/{id}', 'VendorController@add_menu_category');
  Route::post('/lradmin/vendor/save_menu_category', 'VendorController@save_menu_category');
  Route::get('lradmin/vendor/notification-announcement', 'VendorController@notification_announcement');
  Route::get('/lradmin/vendor/add-notification-announcement', 'VendorController@add_notifi_ann');
  Route::get('/lradmin/vendor/edit-notification-announcement/{id}', 'VendorController@add_notifi_ann');
  Route::post('/lradmin/vendor/save_notification_announcement', 'VendorController@save_noti_ann');
  Route::get('lradmin/vendor/view-plan/{id}', 'VendorController@view_plan');
  Route::get('lradmin/vendor/view-packages/{id}', 'VendorController@view_packages');
  Route::get('lradmin/vendor/view-meal/{id}', 'VendorController@view_meal');
  Route::get('lradmin/vendor/view-menu/{id}', 'VendorController@view_menu');
  Route::get('lradmin/vendor/report-problem', 'VendorController@report_problem');

   // App controller
   Route::get('lradmin/app/user-list/{id?}', 'AppController@user_list');
   Route::get('/lradmin/export/exportuser/{id}', 'AppController@exportuser');
   Route::post(' /lradmin/app/get_user_address_detail', 'AppController@get_user_address_detail');
   Route::get('/lradmin/app/about-us', 'AppController@about_us');
   Route::post('/lradmin/app/update_aboutus', 'AppController@update_aboutus');
   Route::get('/lradmin/app/customer-service', 'AppController@customer_service');
   Route::post('/lradmin/app/update_customer_service', 'AppController@update_customer_service');
   Route::any('/lradmin/app/user_edit/{id?}', 'AppController@user_edit');
   Route::get('/lradmin/app/user/transactions/{id?}','AppController@user_transactions');
   Route::get('/lradmin/app/user_orders/{id?}','AppController@user_orders');
   Route::get('/lradmin/app/user_report_problem','AppController@user_report_problem');
    Route::get('/lradmin/app/export_report_problem', 'AppController@export_report_problem');
    Route::get('/lradmin/app/control-packages-social-icons', 'AppController@control_packages_social_icons');
    Route::get('/lradmin/app/plan-filter', 'AppController@plan_filter');
    Route::get('/lradmin/app/add-plan-filter/{id?}', 'AppController@add_plan_filter');
    Route::post('/lradmin/app/save_plan_filter', 'AppController@save_plan_filter');
    Route::get('/lradmin/app/allergy', 'AppController@allergy');
    Route::get('/lradmin/app/add-allergy/{id?}', 'AppController@add_allergy');
    Route::post('/lradmin/app/save_allergy', 'AppController@save_allergy');
    Route::get('/lradmin/app/dislike', 'AppController@dislike');
    Route::get('/lradmin/app/add-dislike/{id?}', 'AppController@add_dislike');
    Route::post('/lradmin/app/save_dislike', 'AppController@save_dislike');
    Route::get('/lradmin/app/promo-code', 'AppController@promo_code');
    Route::get('/lradmin/app/add-promo-code/{id?}', 'AppController@add_promo_code');
    Route::post('/lradmin/app/save_promo_code', 'AppController@save_promo_code');

    Route::get('/lradmin/app/advertisement', 'AppController@advertisement');
    Route::get('/lradmin/app/add-advertisement/{id?}', 'AppController@add_advertisement');
     Route::post('/lradmin/app/save_advertisement', 'AppController@save_advertisement');

     Route::get('/lradmin/app/packages', 'AppController@packages');
     Route::get('/lradmin/app/add-packages/{id?}', 'AppController@add_packages');
     Route::post('/lradmin/app/save_packages', 'AppController@save_packages');
     Route::get('/lradmin/app/edit-plan-filter/{id}', 'AppController@add_packages');
     Route::post('/lradmin/app/edit_package_priority', 'AppController@edit_package_priority');

     Route::post('/lradmin/app/package_planlisting', 'AppController@package_planlisting');

     Route::post('/lradmin/app/package_editplanlisting', 'AppController@package_editplanlisting');
     
});        
