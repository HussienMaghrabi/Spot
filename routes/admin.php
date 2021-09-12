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
        Route::delete('userBadges/multiDelete', 'UserBadgesController@multiDelete')->name('userBadges.multiDelete');
        Route::resource('userBadges', 'UserBadgesController');
        Route::get('coins_history', 'ChargingController@coins_history')->name('users.coins_history');
        Route::get('diamond_history', 'ChargingController@diamond_history')->name('users.diamond_history');
    });

    Route::get('userItems/ajax', 'UserItemController@ajax')->name('userItems.ajax');

    Route::delete('vip-users/multiDelete', 'VipUserController@multiDelete')->name('vip-users.multiDelete');
    Route::any('vip-users/search', 'VipUserController@search')->name('vip-users.search');
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

    Route::delete('badges/multiDelete', 'BadgesController@multiDelete')->name('badges.multiDelete');
    Route::any('badges/search', 'BadgesController@search')->name('badges.search');
    Route::resource('badges', 'BadgesController');

    Route::delete('suspends/multiDelete', 'SuspendController@multiDelete')->name('suspends.multiDelete');
    Route::any('suspends/search', 'SuspendController@search')->name('suspends.search');
    Route::resource('suspends', 'SuspendController');

    Route::delete('items/multiDelete', 'ItemController@multiDelete')->name('items.multiDelete');
    Route::any('items/search', 'ItemController@search')->name('items.search');
    Route::resource('items', 'ItemController');

    Route::resource('recharge','ChargingController');
});

