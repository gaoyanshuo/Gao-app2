<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SessionsController;







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
