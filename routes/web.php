<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UsersController;








Route::get('/',[StaticPagesController::class,'home'])->name('home');
Route::get('help',[StaticPagesController::class,'help'])->name('help');
Route::get('about',[StaticPagesController::class,'about'])->name('about');

//sign
Route::get('/signup',[UsersController::class,'create'])->name('signup');
//user
Route::resource('users', 'UsersController');
