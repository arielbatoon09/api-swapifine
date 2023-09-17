<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Welcome to Swapifine API Routes
| Please always add the routes in the specific category.
| Always follow clean code and structure.
| - Ariel Batoon
|
*/


// Admin API Endpoints
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// CATEGORY MANAGEMENT
Route::group(['Category Management'], function () {
    Route::post('/add/category', [CategoryController::class, 'addCategory']);
    Route::get('/category/list', [CategoryController::class, 'CategoryList']);
    Route::put('/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/delete/{id}', [CategoryController::class, 'delete']);
}); 

// USER MANAGEMENT
Route::group(['User Management'], function () {
    Route::get('/user/list', [UserManagementController::class, 'userList']);
    Route::put('/user/update/{id}', [UserManagementController::class, 'update']);
    Route::delete('/user/delete/{id}', [UserManagementController::class, 'delete']);
});

// ADMIN MANAGEMENT
Route::group(['Admin Management'], function () {
    Route::post('/admin/invite', [AdminAuthController::class, 'invite']);
    Route::get('/admin/list', [AdminManagementController::class, 'AdminList']);
    Route::put('/admin/update/{id}', [AdminManagementController::class, 'update']);
    Route::delete('/admin/delete/{id}', [AdminManagementController::class, 'delete']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/logout', [AdminAuthController::class, 'logout']);
});


// User API Endpoints
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserAuthController::class, 'user']);
    Route::get('/logout', [UserAuthController::class, 'logout']);

    Route::post('/post/item', [PostController::class, 'PostItem']);
    Route::get('/browse', [PostController::class, 'GetAllPostItem']);
    Route::get('/view/item', [PostController::class, 'GetPostDetails']);
});


// Email Verification Routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:sanctum')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return Redirect::to(env('SANCTUM_STATEFUL_DOMAINS'));
})->middleware(['auth:sanctum', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response([
        'status' => 'success',
        'message' => "Sent new verification link!"
    ]);
})->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');
