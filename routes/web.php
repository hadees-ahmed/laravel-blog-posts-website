<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// to display all the users
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->middleware('isAdmin','auth');

Route::get('/posts',[PostController::class,'index'])->middleware('auth');
// categories
// displays all posts ->  no category_Id check
// or filters by category -> category_Id check
// to display user posts

Route::get('/users/{user?}/posts', [PostController::class, 'index']);

//new user registration page
Route::get('/register',[\App\Http\Controllers\RegistrationController::class, 'create'])->middleware('guest');

// store new user in database
Route::post('/register',[\App\Http\Controllers\RegistrationController::class, 'store'])->middleware('guest');

//logout the user
Route::post('/logout',[\App\Http\Controllers\SessionsController::class,'logout'])->middleware('auth');

//login page view
Route::get('/login',[\App\Http\Controllers\SessionsController::class, 'create'])->middleware('guest')->name('login');

//login
Route::post('/login',[\App\Http\Controllers\SessionsController::class, 'login'])->middleware('guest');

// to edit other users from admin login
Route::get('{user?}/update',[\App\Http\Controllers\UserController::class,'edit'])->middleware('isAdmin','auth');

Route::get('/update',[\App\Http\Controllers\UserController::class,'edit'])->middleware('auth');

Route::post('/update',[\App\Http\Controllers\UserController::class,'update'])->middleware('auth');
Route::get('{user}/delete',[\App\Http\Controllers\UserController::class,'destroy'])->middleware('auth','isAdmin');
Route::get('/users/{user}/comment/{post}',[\App\Http\Controllers\CommentsController::class , 'create']);












