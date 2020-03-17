<?php

Route::group(['module' => 'Vendor', 'middleware' => ['api'], 'namespace' => 'App\Modules\Vendor\Controllers'], function() {

    Route::resource('vendor', 'VendorController');

});
