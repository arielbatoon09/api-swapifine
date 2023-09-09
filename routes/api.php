<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\User\PostItemController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;


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
Route::post('/admin/invite', [AdminAuthController::class, 'invite']);
Route::post('/add/category', [CategoryController::class, 'addCategory']);
Route::get('/category/list', [CategoryController::class, 'CategoryList']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/admin/logout', [AdminAuthController::class, 'logout']);
});


// User API Endpoints
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);    

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [UserAuthController::class, 'user']);
    Route::get('/logout', [UserAuthController::class, 'logout']);
    // Route::get('/post/item', [PostItemController::class, 'postItem']);
});
Route::post('/post/item', [PostItemController::class, 'postItem']);

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