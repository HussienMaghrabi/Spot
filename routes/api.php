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
    Route::get('friend-list', 'User\FriendController@index');
    Route::get('following-list', 'User\FollowController@following');
    Route::get('followers-list', 'User\FollowController@followers');
    Route::get('block-list', 'User\BlockController@block');
    Route::delete('remove-items', 'Items\ItemController@remove_exp_items');
    Route::resource('store', 'Items\ItemController');
    Route::resource('user-items', 'Items\PurchaseController');
});
