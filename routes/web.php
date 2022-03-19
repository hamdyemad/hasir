<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function() {
    Route::post('/admin/login', 'Auth\LoginController@login')->name('login');
    Route::get('/admin/login', function() {
        return view('auth.login');
    })->name('admin_login');
});

Route::redirect('/admin', '/admin/login');

Route::group(['namespace' => 'FrontEnd', 'as' => 'frontend.'], function() {
    Route::get('/', 'HomeController@home_page')->name('home');
    Route::get('/services', 'HomeController@services_page')->name('services');
    Route::get('/projects', 'HomeController@projects_page')->name('projects');
    Route::get('/clients', 'HomeController@clients_page')->name('clients');
    Route::get('/contact_us', 'HomeController@contact_us_page')->name('contact_us');
    Route::get('/send-message', 'HomeController@send_message_page')->name('send_message_page');
    Route::post('/send-message', 'HomeController@send_message')->name('send_message');

    Route::get('/order/{project}/{info}', 'HomeController@order_page')->name('order');
    Route::post('/order/{info}', 'HomeController@order_store')->name('order.store');
    Route::get('project/{project}', 'HomeController@project_page')->name('project');
});
