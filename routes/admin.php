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

});

