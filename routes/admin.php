<?php

use Illuminate\Support\Facades\Route;



Route::group(['middleware' => ['web', 'auth', 'admin','notBanned']], function() {
    Route::group(['namespace' => 'Auth'], function() {
        // Logout User
        Route::post('/logout', 'LoginController@logout')->name('logout');
    });
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        // Render perticular view file by foldername and filename and all passed in only one controller at a time
        // Route::get('/{folder}/{file}', 'LexaAdmin@index');
        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');



        // Projects
        Route::group(['prefix' => 'projects', 'as' => 'projects.'], function() {
            Route::get('/', 'ProjectController@index')->name('index');
            Route::post('/', 'ProjectController@store')->name('store');
            Route::get('/create', 'ProjectController@create')->name('create');
            Route::get('/edit/{project}', 'ProjectController@edit')->name('edit');
            Route::patch('/{project}', 'ProjectController@update')->name('update');
            Route::delete('/{project}', 'ProjectController@destroy')->name('destroy');
            Route::post('/remove_info', 'ProjectController@removeInfo')->name('remove_info');
        });
         // CLients
         Route::group(['prefix' => 'clients', 'as' => 'clients.'], function() {
            Route::get('/', 'ClientController@index')->name('index');
            Route::post('/', 'ClientController@store')->name('store');
            Route::get('/create', 'ClientController@create')->name('create');
            Route::get('/edit/{client}', 'ClientController@edit')->name('edit');
            Route::patch('/{client}', 'ClientController@update')->name('update');
            Route::delete('/{client}', 'ClientController@destroy')->name('destroy');
        });


        // Settings
        Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
            Route::get('/edit', 'SettingsController@edit')->name('edit');
            Route::patch('/update', 'SettingsController@update')->name('update');
        });

        // Orders
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
            Route::get('/', 'OrderController@index')->name('index');
            Route::post('/', 'OrderController@store')->name('store');
            Route::post('/status', 'OrderController@updateStatus')->name('status_update');
            Route::delete('/{order}', 'OrderController@destroy')->name('destroy');
        });

        // Investors
        Route::group(['prefix' => 'investors', 'as' => 'investors.'], function() {
            Route::get('/', 'MessagesController@index')->name('index');
            Route::post('/status', 'MessagesController@updateStatus')->name('status_update');
            Route::delete('/{message}', 'MessagesController@destroy')->name('destroy');
        });

        // Messages
        Route::group(['prefix' => 'messages', 'as' => 'messages.'], function() {
            Route::get('/', 'MessagesController@index')->name('index');
            Route::post('/status', 'MessagesController@updateStatus')->name('status_update');
            Route::delete('/{message}', 'MessagesController@destroy')->name('destroy');
        });


        // Statuses
        Route::group(['prefix' => 'statuses', 'as' => 'statuses.'], function() {
            Route::get('/', 'StatusController@index')->name('index');
            Route::get('/create', 'StatusController@create')->name('create');
            Route::post('/', 'StatusController@store')->name('store');
            Route::get('/{status}/edit', 'StatusController@edit')->name('edit');
            Route::patch('/{status}', 'StatusController@update')->name('update');
            Route::delete('/{status}', 'StatusController@destroy')->name('destroy');
        });

        // Users
        Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
            Route::get('/', 'UserController@index')->name('index');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('/create', 'UserController@create')->name('create');
            Route::get('/profile/{user}', 'UserController@profile')->name('profile');
            Route::post('/banned/{user}', 'UserController@banned')->name('banned');
            Route::get('/edit/{user}', 'UserController@edit')->name('edit');
            Route::patch('/{user}', 'UserController@update')->name('update');
            Route::delete('/{user}', 'UserController@destroy')->name('destroy');
        });

        // Roles
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function() {
            Route::get('/', 'RoleController@index')->name('index');
            Route::post('/', 'RoleController@store')->name('store');
            Route::get('/create', 'RoleController@create')->name('create');
            Route::get('/edit/{role}', 'RoleController@edit')->name('edit');
            Route::patch('/{role}', 'RoleController@update')->name('update');
            Route::delete('/{role}', 'RoleController@destroy')->name('destroy');
        });

    });
});

