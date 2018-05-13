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
Route::put('user/{username}', 'userController@updateUser');


// ======================ROOM========================//

