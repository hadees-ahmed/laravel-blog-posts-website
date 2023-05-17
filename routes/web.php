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
Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])
    ->middleware('isAdmin','auth')
    ->name('users.index');

// display all posts
Route::get('/posts',[PostController::class,'index'])
    ->middleware('auth')
    ->name('posts');

// categories
// displays all posts ->  no category_Id check
// or filters by category -> category_Id check
// to display user posts
Route::get('/users/{user?}/posts', [PostController::class, 'index'])
    ->middleware('auth')
    ->name('users.posts.index');

//new user registration page
Route::get('/register',[\App\Http\Controllers\RegistrationController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// store new user in database
Route::post('/register',[\App\Http\Controllers\RegistrationController::class, 'store'])
    ->middleware('guest')
    ->name('register');

//logout the user
Route::post('/logout',[\App\Http\Controllers\SessionsController::class,'logout'])
    ->middleware('auth')
    ->name('logout');

//login page view
Route::get('/login',[\App\Http\Controllers\SessionsController::class, 'create'])
    ->middleware('guest')
    ->name('login');

//login
Route::post('/login',[\App\Http\Controllers\SessionsController::class, 'login'])
    ->middleware('guest')
    ->name('login');

// to edit other users from admin login
Route::get('{user?}/update',[\App\Http\Controllers\UserController::class,'edit'])
    ->middleware('isAdmin','auth')
    ->name('admin.users.update');

// edit profile route
Route::get('/update',[\App\Http\Controllers\UserController::class,'edit'])
    ->middleware('auth')
    ->name('users.update');

// save updated profile details
Route::post('/update',[\App\Http\Controllers\UserController::class,'update'])
    ->middleware('auth')
    ->name('users.update');

// to delete the user from blog (admins only)
Route::get('{user}/delete',[\App\Http\Controllers\UserController::class,'destroy'])
    ->middleware('auth','isAdmin')
    ->name('users.delete');

//show comments
Route::get('/posts/{post}/comments',[\App\Http\Controllers\CommentsController::class,'index'])
    ->middleware('auth')
    ->name('posts.comments.index');//done

// store comment
Route::post('/users/{user}/{post}/comments',[\App\Http\Controllers\CommentsController::class , 'create'])
    ->middleware('auth')
    ->name('users.comments');












