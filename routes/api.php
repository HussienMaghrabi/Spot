<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('apiLocale')->namespace('Api')->group(function () {
    //Admin
    Route::resource('admins', 'Admin\IndexController');
    Route::post('admin-login',  'Admin\IndexController@login');
    Route::post('admin-logout', 'Admin\IndexController@logout');
    Route::post('admin-check',  'Admin\IndexController@check');
    Route::get('admin-profile', 'Admin\IndexController@profile');
    Route::post('change-password', 'Admin\IndexController@changePassword');
    Route::get('ban-user', 'accounts\banController@create');
    Route::get('un-ban-user', 'accounts\banController@remove');
    Route::get('banned-users', 'accounts\banController@index');
    Route::get('suspended-users', 'accounts\SuspendController@index');
    Route::get('suspend-user', 'accounts\SuspendController@create');
    Route::get('un-suspend-user', 'accounts\SuspendController@remove');

    //user
    Route::post('social-login', 'User\AuthController@social');
    Route::get('profile', 'User\UpdateController@index');
    Route::post('change_password', 'User\UpdateController@changePassword');
    Route::any('profile-update', 'User\UpdateController@update');

    //Friends Relationship
    Route::get('friend-list', 'User\FriendController@index');
    Route::get('unfriend-user', 'User\FriendController@unFriend');
    Route::get('accept-friend', 'User\FriendController@acceptRequest');
    Route::get('decline-friend', 'User\FriendController@declineRequest');
    Route::get('friend-requests', 'User\FriendController@showRequests');
    Route::get('friend-count', 'User\FriendController@friendCount');
    Route::get('friend-request', 'User\FriendController@create');
    Route::get('friend-count', 'User\FriendController@friendCount');
    Route::get('friend-request', 'User\FriendController@create');

    //Follow Relationship

    Route::get('following-list', 'User\FollowController@following');
    Route::get('followers-list', 'User\FollowController@followers');
    Route::get('followers-count', 'User\FollowController@followersCount');
    Route::get('following-count', 'User\FollowController@followingCount');
    Route::get('follow-user', 'User\FollowController@follow');
    Route::get('unfollow-user', 'User\FollowController@unfollow');
    Route::get('friend-count', 'User\FriendController@friendCount');
    Route::get('friend-request', 'User\FriendController@create');
    Route::delete('remove-items', 'Items\ItemController@remove_exp_items'); // will be removed


    //Block Relationship
    Route::get('block-list', 'User\BlockController@blockList');
    Route::get('block-count', 'User\BlockController@blockCount');
    Route::get('block-user', 'User\BlockController@create');
    Route::get('unblock-user', 'User\BlockController@destroy');
    //Route::get('block-list', 'User\BlockController@block');

    //Items
    Route::delete('remove-items', 'Items\ItemController@remove_exp_items');
    Route::post('items-update', 'Items\ItemController@activate');
    Route::post('item-deactivate', 'Items\ItemController@deactivate');
    Route::resource('store', 'Items\ItemController');
    Route::resource('user-items', 'Items\PurchaseController');
    Route::get('user-gifts', 'Items\GiftController@showGifts');
    Route::get('send-gifts', 'Items\GiftController@sendGift');
    Route::get('ban-user', 'accounts\banController@create');

});
