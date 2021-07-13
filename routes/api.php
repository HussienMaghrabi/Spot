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

    Route::resource('admins', 'Admin\AdminController');
    Route::post('admin-login',  'Admin\AdminController@login');
    Route::post('admin-logout', 'Admin\AdminController@logout');
    Route::post('admin-check',  'Admin\AdminController@check');
    Route::get('admin-profile', 'Admin\AdminController@profile');
    Route::post('change-password', 'Admin\AdminController@changePassword');
    Route::get('ban-user', 'accounts\banController@create');
    Route::get('un-ban-user', 'accounts\banController@remove');
    Route::get('banned-users', 'accounts\banController@index');
    Route::get('suspended-users', 'accounts\SuspendController@index');
    Route::get('suspend-user', 'accounts\SuspendController@create');
    Route::get('un-suspend-user', 'accounts\SuspendController@remove');
    Route::get('change-gender', 'Admin\UserOpController@changeGender');
    Route::get('change-name', 'Admin\UserOpController@changeName');
    Route::get('change-room-name', 'Admin\RoomOpController@changeNameRoom');
    Route::post('change-special_id', 'Admin\UserOpController@changeSpecialId');
    Route::post('remove-special_id', 'Admin\UserOpController@removeSpecialId');
    Route::post('add-coins-no level', 'Admin\UserOpController@rechargeNoLevel');
    Route::get('users-list', 'Admin\UserOpController@userList');
    Route::any('search-user', 'Admin\UserOpController@search');




    //Badge
    Route::post('addFriendBadge', 'Admin\BadgesController@addFriendBadge');
    Route::resource('badge', 'Admin\BadgesController');

    //user
    Route::post('social-login', 'User\AuthController@social');
    Route::get('profile', 'User\UpdateController@index');
    Route::post('change_password', 'User\UpdateController@changePassword');
    Route::any('profile-update', 'User\UpdateController@update');
    Route::get('user-badge' ,'User\UpdateController@userBadge');
    Route::get('show-profile' ,'User\UpdateController@showProfile');
    Route::get('diamond-list', 'levels\DiamondController@index');
    Route::post('diamond-transfer', 'levels\DiamondController@update');

    //Friends Relationship
    Route::get('friend-list', 'User\FriendController@index');
    Route::post('unfriend-user', 'User\FriendController@unFriend');
    Route::post('accept-friend', 'User\FriendController@acceptRequest');
    Route::post('decline-friend', 'User\FriendController@declineRequest');
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
    Route::post('store', 'Items\ItemController@index');
    Route::resource('user-items', 'Items\PurchaseController');
    Route::get('user-gifts', 'Items\GiftController@showGifts');
    Route::get('send-gifts', 'Items\GiftController@sendGift');
    Route::get('ban-user', 'accounts\banController@create');
    Route::get('user-items-byCat', 'Items\ItemController@showUserItemByCatId');
    Route::get('user-items-active-byCat', 'Items\ItemController@showUserActiveItemByCatId');
    Route::get('show-gifts', 'Items\GiftController@viewGifts');

    // chargingLevel
    Route::post('charge-coin','levels\chargeController@chargIng');

    //Report
    Route::resource('report-user', 'Report\ReportUserController');
    Route::resource('report-room', 'Report\ReportRoomController');

    // leaderboards
    Route::get('get-top', 'Leaders\topController@getTop');
    Route::get('get-topRechargeD', 'Leaders\topController@topRechargeD');
    Route::get('get-topRechargeW', 'Leaders\topController@topRechargeW');
    Route::get('get-topRechargeM', 'Leaders\topController@topRechargeM');
    Route::get('get-topSenderD', 'Leaders\topController@topSenderD');
    Route::get('get-topSenderW', 'Leaders\topController@topSenderW');
    Route::get('get-topSenderM', 'Leaders\topController@topSenderM');
    Route::get('get-topReceiverD', 'Leaders\topController@topReceiverD');
    Route::get('get-topReceiverW', 'Leaders\topController@topReceiverW');
    Route::get('get-topReceiverM', 'Leaders\topController@topReceiverM');
    Route::get('get-topRoomD', 'Leaders\topController@topRoomD');
    Route::get('get-topRoomW', 'Leaders\topController@topRoomW');
    Route::get('get-topRoomM', 'Leaders\topController@topRoomM');
    Route::get('room_password', 'Rooms\RoomController@create_room_password');
    Route::get('room_update_password', 'Rooms\RoomController@update_room_password');
    Route::post('test-json', 'Leaders\topController@getTop');

    //Room
    Route::resource('recent-room','Rooms\RecentRoomController');
    Route::post('follow-room', 'Rooms\MembersController@follow_room');
    Route::post('join-room', 'Rooms\MembersController@join_room');
    Route::post('un-follow-room', 'Rooms\MembersController@unFollow_room');
    Route::post('room-followers', 'Rooms\MembersController@room_followers');
    Route::post('room-active-users', 'Rooms\MembersController@room_joiners');
    Route::post('un-join-room', 'Rooms\MembersController@leave_room');
    Route::put('recent-room','Rooms\RecentRoomController@update');
    Route::post('enter-room','Rooms\ActiveRoomController@enterRoom');
    Route::post('leave-room','Rooms\ActiveRoomController@leave_room');
    Route::post('active-users','Rooms\ActiveRoomController@active_user');
    Route::get('active-rooms','Rooms\ActiveRoomController@active_room');
    Route::get('user-rooms-join','Rooms\MembersController@user_rooms_join');
    Route::get('user-rooms-follow','Rooms\MembersController@user_rooms_follow');
    Route::post('main-image-update','Rooms\HandleRoomController@main_image');
    Route::post('background-update','Rooms\HandleRoomController@background');
    Route::post('join-fees-update','Rooms\HandleRoomController@join_fees');
    Route::post('send-image-update','Rooms\HandleRoomController@send_image');
    Route::post('take-mic-update','Rooms\HandleRoomController@take_mic');
    Route::post('bc-message-update','Rooms\HandleRoomController@bc_message');
    Route::post('name-update','Rooms\HandleRoomController@name');
    Route::post('kick-user-from-room','Rooms\HandleRoomController@kickUser');
    Route::post('ban-user-from-room','Rooms\HandleRoomController@banEnter');
    Route::post('unban-user-from-room','Rooms\HandleRoomController@unBanEnter');
    Route::post('ban-user-from-chat','Rooms\HandleRoomController@banChat');
    Route::post('unban-user-from-chat','Rooms\HandleRoomController@unbanChat');
    Route::get('user-room','Rooms\RoomController@user_room');

    // chat
    Route::get('chat_Connection','chat\chatController@connection');
    Route::get('conversion','chat\chatController@conversion');
    Route::get('last_users_conversion','chat\chatController@getUserConversion');

    Route::resource('daily_gift','Admin\dailyGiftsController');

    // Room CRUD
    Route::post('rooms','Rooms\RoomController@getRooms');
    Route::post('store-room','Rooms\RoomController@createRoom');
    Route::post('update-room','Rooms\RoomController@updateRoom');
    Route::post('update-delete','Rooms\RoomController@deleteRoom');

    Route::get('countries','Rooms\FilterController@getCountries');
    Route::get('categories','Rooms\FilterController@getCategories');
    Route::post('pin-room','Admin\RoomOpController@pinRoom');
    Route::post('unpin-room','Admin\RoomOpController@unPinRoom');
    Route::get('pinned-rooms','Rooms\RoomController@pinnedRooms');
    Route::get('new-rooms','Rooms\RoomController@newRooms');
    Route::get('room-exist','Rooms\RoomController@checkRoom');


    // activities
    Route::get('activities','Rooms\activitiesController@getActivities');
    Route::get('activity-images','Rooms\activitiesController@getImage');
    Route::post('create-activities','Rooms\activitiesController@storeActivities');


    // vip controller APIs
    Route::get('purchase-vip','Vip\VipPurchaseController@purchaseVip');
    Route::get('renew-vip','Vip\VipPurchaseController@renewVip');

// vip_tiers
    Route::get('vip_tiers','Vip\vipTiersController@getTirs');
    Route::get('vip_tier','Vip\vipTiersController@getTir');

    //Events
    Route::resource('event','Events\EventsController');

//    Route::get('count/{id}', 'Items\GiftController@badgesForSendGift');




});
