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
    Route::get('users/{id}/edit/{users}', 'UserController@edit')->name('users.edit');
    Route::PATCH('users/name/{id}', 'UserController@change_name')->name('users.name');
    Route::PATCH('users/image/{id}', 'UserController@change_image')->name('users.image');
    Route::PATCH('users/special_id/{id}', 'UserController@change_special_id')->name('users.special_id');
    Route::PATCH('users/coins/{id}', 'UserController@change_special_id')->name('users.coins');
    Route::PATCH('users/gender/{id}', 'UserController@change_gender')->name('users.gender');
    Route::PATCH('users/recharge_no_level/{id}', 'UserController@rechargeNoLevel')->name('users.recharge_no_level');
    Route::PATCH('users/recharge_with_level/{id}', 'UserController@rechargeWithLevel')->name('users.recharge_with_level');
    Route::PATCH('users/reduce_coins/{id}', 'UserController@reduceCoins')->name('users.reduce_coins');
    Route::PATCH('users/reduce_diamond/{id}', 'UserController@reduceDiamond')->name('users.reduce_diamond');
    Route::PATCH('users/freeze/{id}', 'UserController@freezeDiamond')->name('users.freeze');
    Route::PATCH('users/vip_role/{id}', 'UserController@vip')->name('users.vip_role');
    Route::resource('users', 'UserController');

    Route::prefix('{user}')->group(function ()
    {
        Route::delete('userItems/multiDelete', 'UserItemController@multiDelete')->name('userItems.multiDelete');
        Route::resource('userItems', 'UserItemController');
    });

    Route::get('userItems/ajax', 'UserItemController@ajax')->name('userItems.ajax');

    Route::delete('vip-users/multiDelete', 'VipUserController@multiDelete')->name('vip-users.multiDelete');
    Route::any('vip-users/search', 'VipUserController@search')->name('vip-users.search');
    Route::get('vip-users/{id}/edit/{users}', 'VipUserController@edit')->name('vip-users.edit');
    Route::PATCH('vip-users/name/{id}', 'VipUserController@change_name')->name('vip-users.name');
    Route::PATCH('vip-users/image/{id}', 'VipUserController@change_image')->name('vip-users.image');
    Route::PATCH('vip-users/special_id/{id}', 'VipUserController@change_special_id')->name('vip-users.special_id');
    Route::PATCH('vip-users/coins/{id}', 'VipUserController@change_special_id')->name('vip-users.coins');
    Route::PATCH('vip-users/gender/{id}', 'VipUserController@change_gender')->name('vip-users.gender');
    Route::PATCH('vip-users/recharge_no_level/{id}', 'VipUserController@rechargeNoLevel')->name('vip-users.recharge_no_level');
    Route::PATCH('vip-users/recharge_with_level/{id}', 'VipUserController@rechargeWithLevel')->name('vip-users.recharge_with_level');
    Route::PATCH('vip-users/reduce_coins/{id}', 'VipUserController@reduceCoins')->name('vip-users.reduce_coins');
    Route::PATCH('vip-users/reduce_diamond/{id}', 'VipUserController@reduceDiamond')->name('vip-users.reduce_diamond');
    Route::PATCH('vip-users/vip_role/{id}', 'VipUserController@vip')->name('vip-users.vip_role');
    Route::resource('vip-users', 'VipUserController');

    Route::delete('rooms/multiDelete', 'RoomController@multiDelete')->name('rooms.multiDelete');
    Route::any('rooms/search', 'RoomController@search')->name('rooms.search');
    Route::get('rooms/{id}/edit/{users}', 'RoomController@edit')->name('rooms.edit');
    Route::PATCH('rooms/name/{id}', 'RoomController@change_name')->name('rooms.name');
    Route::PATCH('rooms/image/{id}', 'RoomController@change_image')->name('rooms.image');
    Route::PATCH('rooms/pin/{id}', 'RoomController@pinRoom')->name('rooms.pin');
    Route::PATCH('rooms/trend/{id}', 'RoomController@trendRoom')->name('rooms.trend');
    Route::PATCH('rooms/official/{id}', 'RoomController@officialRoom')->name('rooms.official');
    Route::resource('rooms', 'RoomController');

    Route::delete('bans/multiDelete', 'BanController@multiDelete')->name('bans.multiDelete');
    Route::any('bans/search', 'BanController@search')->name('bans.search');
    Route::resource('bans', 'BanController');

    Route::delete('suspends/multiDelete', 'SuspendController@multiDelete')->name('suspends.multiDelete');
    Route::any('suspends/search', 'SuspendController@search')->name('suspends.search');
    Route::resource('suspends', 'SuspendController');

    Route::delete('items/multiDelete', 'ItemController@multiDelete')->name('items.multiDelete');
    Route::any('items/search', 'ItemController@search')->name('items.search');
    Route::resource('items', 'ItemController');
});

