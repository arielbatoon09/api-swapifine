<?php

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/admin/logout', [AdminAuthController::class, 'logout']);
});

Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);    

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', [UserAuthController::class, 'user']);
    Route::get('/logout', [UserAuthController::class, 'logout']);
});

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