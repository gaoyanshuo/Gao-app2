<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\FollowersController;





Route::get('/',[StaticPagesController::class,'home'])->name('home');
Route::get('help',[StaticPagesController::class,'help'])->name('help');
Route::get('about',[StaticPagesController::class,'about'])->name('about');

//sign
Route::get('/signup',[UsersController::class,'create'])->name('signup');
//user
Route::resource('users', 'UsersController');
//login,logout/
Route::get('login',[SessionsController::class,'create'])->name('login');
Route::post('login',[SessionsController::class,'store'])->name('login');
Route::delete('logout',[SessionsController::class,'logout'])->name('logout');
//user-edit
Route::get('users/{user}/edit',[UsersController::class,'edit'])->name('users.edit');
//token
Route::get('signup/confirm/{token}',[UsersController::class,'confirmEmail'])->name('confirm_email');
//password_reset
//email input
Route::get('password/reset',[PasswordController::class,'showLinkRequest'])->name('password.request');
//send email token
Route::post('password/email',[PasswordController::class,'sendResetLinkEmail'])->name('password.email');
// change password
Route::get('password/reset/{token}',[PasswordController::class,'showResetForm'])->name('password.reset');
// submit
Route::post('password/reset',[PasswordController::class,'reset'])->name('password.update');
//statuses
Route::resource('statuses','StatusesController',['only' => ['destroy','store']]);
//show_following/follower_list
Route::get('/user/{user}/following',[UsersController::class,'followings'])->name('users.followings');
Route::get('/user/{user}/followers',[UsersController::class,'followers'])->name('users.followers');
//follow,unfollow
Route::post('users/followers/{user}',[FollowersController::class,'store'])->name('followers.store');
Route::delete('users/followers/{user}',[FollowersController::class,'destroy'])->name('followers.destroy');
