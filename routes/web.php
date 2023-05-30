<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

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
Route::get('users', [UserController::class, 'index'])
    ->middleware('isAdmin','auth')
    ->name('users.index');

// display all posts
Route::get('posts',[PostsController::class,'index'])
    ->middleware('auth')
    ->name('posts');

// categories
// displays all posts ->  no category_Id check
// or filters by category -> category_Id check
// to display user posts
Route::get('users/{user?}/posts', [PostsController::class, 'index'])
    ->middleware('auth')
    ->name('users.posts.index');

//new user registration page
Route::get('register',[RegistrationController::class, 'create'])
    ->middleware('guest')
    ->name('register');

// store new user in database
Route::post('register',[RegistrationController::class, 'store'])
    ->middleware('guest')
    ->name('register');

//logout the user
Route::post('logout',[SessionsController::class,'logout'])
    ->middleware('auth')
    ->name('logout');

//login page view
Route::get('login',[SessionsController::class, 'create'])
    ->middleware('guest')
    ->name('login');

//login
Route::post('login',[SessionsController::class, 'login'])
    ->middleware('guest')
    ->name('login');

// to edit other users from admin login
Route::get('{user?}/update',[UserController::class,'edit'])
    ->middleware('isAdmin','auth')
    ->name('admin.users.update');

// edit profile route
Route::get('update',[UserController::class,'edit'])
    ->middleware('auth')
    ->name('users.update');

// save updated profile details
Route::post('update',[UserController::class,'update'])
    ->middleware('auth')
    ->name('users.update');

// to delete the user from blog (admins only)
Route::get('{user}/delete',[UserController::class,'destroy'])
    ->middleware('auth','isAdmin')
    ->name('users.delete');

//show comments and add comment
Route::get('posts/{post}/comments',[CommentsController::class,'index'])
    ->middleware('auth')
    ->name('posts.comments.index');

// store comment
Route::post('users/{user}/{post}/comments',[CommentsController::class , 'store'])
    ->middleware('auth')
    ->name('users.comments');

// delete comment
Route::get('comments/{comment}/delete',[CommentsController::class,'destroy'])
    ->middleware('auth')
    ->can('delete', 'comment')
    ->name('comments.delete');

//create post
Route::get('posts/create',[PostsController::class,'create'])
    ->middleware('auth')
    ->name('posts.create');

//edit post
Route::get('posts/{post}/edit',[PostsController::class,'edit'])
    ->middleware('auth')
    ->can('update', 'post')
    ->name('posts.edit');

//Store created post
Route::post('posts',[PostsController::class,'store'])
    ->middleware('auth')
    ->name('posts.store');

//update edited post
Route::post('posts/{post}',[PostsController::class, 'update'])
    ->middleware('auth')
    ->name('posts.update')
    ->can('update', 'post');

//delete post
Route::get('posts/{post}/delete',[PostsController::class,'delete'])
    ->middleware('auth')
    ->name('posts.delete')
    ->can('delete', 'post');

// view drafts
Route::get('users/drafts',[\App\Http\Controllers\PostsDraftsController::class, 'index'])
    ->middleware('auth')
    ->name('users.drafts');















