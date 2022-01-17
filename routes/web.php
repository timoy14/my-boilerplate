<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => true, 'reset' => false]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('home', 'HomeController@index')->name('home');

Route::get('language/{locale}', 'HomeController@language')->name('language');
Route::get('subscribers/check/expires', 'HomeController@checkExpires')->name('check.expires');

Route::group(['namespace' => 'Payments'], function () {
    Route::get('payment_redirect', 'PaymentController@redirectUrl')->name('payment.redirect');
    Route::get('payment/{payment_id}', 'PaymentController@store')->name('payment.charge');
});


Route::group(['namespace' => 'Auth'], function () {
    Route::get('administrator', 'AdminLoginController@index')->name('admin.login.index');
    Route::post('administrator', 'AdminLoginController@store')->name('admin.login.store');

    // Route::get('password-reset', 'PasswordResetController@index')->name('password.reset.index');
    // Route::post('password-reset', 'PasswordResetController@store')->name('password.reset.store');
});
Route::group(['namespace' => 'Dashboard', 'middleware' => ['auth:web', 'locale']], function () {

    Route::group(['namespace' => 'Admin', 'middleware' => ['auth.role'], 'role' => 'Admin'], function () {
        Route::namespace ('Users')->prefix('admin-users')->name('admin-users.')->group(function () {
            // Route::resource('owners', 'OwnerController');
            Route::resource('admins', 'AdminController');
            Route::resource('staffs', 'StaffController');
            Route::resource('drivers', 'DriverController');
            Route::put('drivers.update_registration_status/{driver_id}', 'DriverController@update_registration_status')->name('drivers.update_registration_status');

            

            Route::resource('customers', 'CustomerController');
            Route::get('customers/{user_id}/purchases', 'CustomerController@purchase_index')->name('customers.purchases-index');
            Route::get('customers/{user_id}/reviews', 'CustomerController@reviews_index')->name('customers.reviews-index');

        });


        Route::namespace ('Settings')->prefix('settings')->name('settings.')->group(function () {
            Route::resource('icons', 'BranchCategoryIconsController');
            Route::resource('terms-and-conditions', 'TermAndConditionController');
            Route::resource('cancellation-policy', 'CancellationPolicyController');
            Route::resource('general-setting', 'GeneralSettingsController');
            Route::resource('about-us', 'AboutUsController');
            Route::resource('contact-us', 'ContactUsController');
            Route::resource('introduction-screens', 'IntroductionScreenController');
            Route::resource('roles', 'RoleController');
            Route::resource('genders', 'GenderController');
            Route::resource('categories', 'CategoryController');
            Route::resource('subcategories', 'SubcategoryController');
            Route::resource('service-categories', 'ServiceCategoryController');

            Route::resource('cities', 'CityController');
            Route::resource('areas', 'AreaController');
            Route::resource('questions', 'QuestionController');
            Route::resource('advertisements', 'AdvertisementController');
            Route::resource('tickets', 'FeedbackController');
        });

        Route::namespace ('Notifications')->prefix('admin')->name('admin.')->group(function () {
            Route::resource('notifications', 'NotificationController');
        });



    });

});