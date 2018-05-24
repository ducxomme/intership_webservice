<?php

use Illuminate\Http\Request;


// ======================USER========================//
// Login
Route::post('user/login','userController@login');
// Register
Route::post('user/register', 'userController@register');
// Get All User
Route::get('users', 'userController@getAllUser');
// Get A User
Route::get('user/{username}', 'userController@getUser');
// Update User
Route::post('user/{username}', 'userController@updateUser');


// ======================ROOM========================//
// Get All Room
Route::get('rooms', 'roomController@getAllRoom');
// getRoomDetail
Route::get('room/{room_id}', 'roomController@getRoomDetail');
// addRoom
Route::post('room/{username}', 'roomController@addRoom');
// updateRoomDetail
Route::put('room/{room_id}', 'roomController@updateRoomDetail');
// deleteRoom
Route::delete('room/{room_id}', 'roomController@deleteRoom');
// unPublicRoom
Route::post('room/{room_id}', 'roomController@unPublicRoom');
// searchRoomByPrice
Route::get('room/price/{from}/{to}');
// searchRoomByAddress
Route::get('room/address/{from}/{to}');
