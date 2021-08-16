<?php

Route::get('/admin', function () {
    return redirect('/ar/dashboard');
});

Route::get('/ar/admin', function () {
    return redirect('/ar/dashboard');
});

Route::get('/en/admin', function () {
    return redirect('/ar/dashboard');
});

Route::get('admin/signin', 'Dashboard\LoginController@index')->name('admin.index');
Route::post('admin/signin', 'Dashboard\LoginController@login')->name('admin.login');


Route::prefix('{lang}/dashboard')->namespace('Dashboard')->name('admin.')->middleware(['admin:admin', 'locale'])->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::post('logout', 'LoginController@logout')->name('logout');

    Route::delete('admins/multiDelete', 'AdminController@multiDelete')->name('admins.multiDelete');
    Route::any('admins/search', 'AdminController@search')->name('admins.search');
    Route::resource('admins', 'AdminController');

    Route::delete('users/multiDelete', 'UserController@multiDelete')->name('users.multiDelete');
    Route::any('users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');

    Route::delete('vip-users/multiDelete', 'VipUserController@multiDelete')->name('vip-users.multiDelete');
    Route::any('vip-users/search', 'VipUserController@search')->name('vip-users.search');
    Route::resource('vip-users', 'VipUserController');

    Route::delete('bans/multiDelete', 'BanController@multiDelete')->name('bans.multiDelete');
    Route::any('bans/search', 'BanController@search')->name('bans.search');
    Route::resource('bans', 'BanController');

    Route::delete('suspends/multiDelete', 'SuspendController@multiDelete')->name('suspends.multiDelete');
    Route::any('suspends/search', 'SuspendController@search')->name('suspends.search');
    Route::resource('suspends', 'SuspendController');

    Route::delete('rooms/multiDelete', 'RoomController@multiDelete')->name('rooms.multiDelete');
    Route::any('rooms/search', 'RoomController@search')->name('rooms.search');
    Route::resource('rooms', 'RoomController');

});

