<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PostsDraftsController;
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

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login page view
    Route::get('login', [SessionsController::class, 'create'])
    ->name('login');

    // Login
    Route::post('login', [SessionsController::class, 'login']);

    // update password
    Route::post('update',[PasswordController::class,'update'])
        ->name('update.password');

    // enter email
    Route::get('forgot-password',[PasswordController::class,'create'])
        ->name('forgot.password');

    // verify email and send verification code
    Route::post('verification-code', [PasswordController::class, 'sendVerificationCode'])
        ->name('verification.code');

    // enter verification code
    Route::get('verification-code', [PasswordController::class, 'enterVerificationCode'])
        ->name('verification.code.enter');

    // verify code
    Route::post('verify-code', [PasswordController::class, 'verifyCode'])
        ->name('verify.code');

    //enter new password
    Route::get('/new-password',[PasswordController::class, 'enterNewPassword'])
        ->name('enter.new.password');
});

// Registration routes
Route::middleware('guest')->group(function () {
    // New user registration page
    Route::get('register', [RegistrationController::class, 'create'])
    ->name('register');

    // Store new user in the database
    Route::post('register', [RegistrationController::class, 'store'])
    ->name('register');
    });


    // User Controller routes
    Route::middleware(['auth', 'isAdmin'])->group(function () {
    // Display all the users
    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');

    // Edit other users from admin login
    Route::get('{user?}/update', [UserController::class, 'edit'])
        ->name('admin.users.update');

    // Delete the user from blog (admins only)
    Route::get('{user}/delete', [UserController::class, 'destroy'])
        ->name('users.delete');

    //promote admin
    Route::get('users/{user}/promote',[UserController::class, 'promote'])
        ->name('users.promote');

    Route::get('users/{user}/demote',[UserController::class, 'demote'])
        ->name('users.demote');

});


Route::middleware('auth')->group(function () {
    // Delete comment
    Route::get('comments/{comment}/delete', [CommentsController::class, 'destroy'])
    ->can('delete', 'comment')
    ->name('comments.delete');

    // Logout the user
    Route::post('logout', [SessionsController::class, 'logout'])
    ->name('logout');

    // Display all posts
    Route::get('posts', [PostsController::class, 'index'])
    ->middleware('auth')
    ->name('posts');

    // Edit profile route
    Route::get('update', [UserController::class, 'edit'])
    ->name('users.update');

    // Save updated profile details
    Route::post('update', [UserController::class, 'update'])
    ->name('users.update');

    // Categories
    // Displays all posts -> no category_Id check
    // or filters by category -> category_Id check
    // To display user posts
    Route::get('users/{user?}/posts', [PostsController::class, 'index'])
        ->name('users.posts.index');

    // Show comments and add comment
    Route::get('posts/{post}/comments', [CommentsController::class, 'index'])
        ->name('posts.comments.index');

    // Store comment
    Route::post('users/{user}/{post}/comments', [CommentsController::class, 'store'])
        ->name('users.comments');


    // Create post
    Route::get('posts/create', [PostsController::class, 'create'])
        ->name('posts.create');

    // Edit post
    Route::get('posts/{post}/edit', [PostsController::class, 'edit'])
        ->can('update', 'post')
        ->name('posts.edit');

    // Store created post
    Route::post('posts', [PostsController::class, 'store'])
        ->name('posts.store');

    // Update edited post
    Route::post('posts/{post}', [PostsController::class, 'update'])
        ->name('posts.update')
        ->can('update', 'post');


    // Delete post
    Route::get('posts/{post}/delete', [PostsController::class, 'delete'])
        ->name('posts.delete')
        ->can('delete', 'post');

    // View drafts
    Route::get('users/drafts', [\App\Http\Controllers\PostsDraftsController::class, 'index'])
        ->name('users.drafts');

    // Restore comment
    Route::get('comments/{comment}/restore', [CommentsController::class, 'restore'])
        ->name('comments.restore')->can('undo', 'comment')
        ->withTrashed();
});


