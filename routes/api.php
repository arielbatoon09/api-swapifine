<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\CreditsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportedUserController;
use App\Http\Controllers\RatingsController;
use App\Http\Controllers\WithdrawalController;

use App\Events\MessageEvent;

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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
    Route::get('/admin/category/list', [CategoryController::class, 'GetAllCategory']);
    Route::post('/admin/category/post', [CategoryController::class, 'PostCategory']);
    Route::post('/admin/category/update', [CategoryController::class, 'UpdateCategory']);
    Route::post('/admin/category/delete/{id}', [CategoryController::class, 'DeleteCategory']);
});

// USER MANAGEMENT
// Route::group(['User Management'], function () {
//     Route::get('/user/list', [UserManagementController::class, 'userList']);
//     Route::post('/user/update', [UserManagementController::class, 'update']);
//     Route::post('/user/delete/{id}', [UserManagementController::class, 'delete']);
// });

// ADMIN MANAGEMENT
Route::group(['Admin Management'], function () {
    Route::post('/admin/invite', [AdminAuthController::class, 'invite']);
    Route::get('/admin/list', [AdminManagementController::class, 'AdminList']);
    Route::post('/admin/update', [AdminManagementController::class, 'update']);
    Route::post('/admin/delete/{id}', [AdminManagementController::class, 'delete']);
});

// Route::group(['Verification Request'], function(){
//     Route::post('/add/verification', [PersonalInfoController::class, 'addVerification']);
//     Route::get('/userVerification/list', [PersonalInfoController::class, 'verificationList']);
// });

// Route::group(['Super Admin'], function(){
//     Route::post('/SuperAdmin/EmailUpdate', [SuperAdminController::class, 'EmailUpdate']);
//     Route::post('/SuperAdmin/UpdatePassword', [SuperAdminController::class, 'PasswordUpdate']);
// });


// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/admin/logout', [AdminAuthController::class, 'logout']);
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/admin/logout', [AdminAuthController::class, 'logout']);
    Route::get('/checkout/all-list', [CreditsController::class, 'GetEveryCreditsHistory']);
    Route::post('/checkout/getCreditsByID', [CreditsController::class, 'GetCreditsByID']);
    Route::get('/transaction/all-list', [TransactionsController::class, 'GetEveryTransactionsHistory']);
    Route::post('/transaction/getTransactionsByID', [TransactionsController::class, 'GetTransactionsByID']);
    Route::get('/verification/all-list', [VerificationController::class, 'GetEveryVerificationList']);
    Route::post('/verification/getVerificationListByID', [VerificationController::class, 'GetVerificationListByID']);
    Route::post('/verification/updateVerificationStatus', [VerificationController::class, 'UpdateVerificationStatus']);
    Route::post('/admin/top-users', [UserController::class, 'TopUsersByPosts']);
    Route::post('/admin/totals', [UserController::class, 'TotalNumbers']);
    Route::get('/reported-user/all-list', [ReportedUserController::class, 'GetEveryReportedUser']);
    Route::post('/reported-user/getReportedUserByID', [ReportedUserController::class, 'GetReportedUserByID']);
    Route::get('/user/list', [UserController::class, 'GetAllUserList']);
    Route::post('/user/update', [UserController::class, 'UpdateUserByID']);
    Route::post('/user/delete/{id}', [UserController::class, 'DeleteUserByID']);
});


// Guest API Endpoints
Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);


// Protected API Endpoints
Route::middleware('auth:sanctum')->group(function () {
    // Common Endpoint
    Route::get('/user', [UserAuthController::class, 'user']);
    Route::get('/logout', [UserAuthController::class, 'logout']);

    // Post Endpoint
    Route::get('/browse', [PostController::class, 'GetAllPostItem']);
    Route::get('/browse/top-post', [PostController::class, 'GetTop3PostCategory']);
    Route::post('/post/item', [PostController::class, 'PostItem']);
    Route::post('/view/item', [PostController::class, 'GetPostDetails']);
    Route::post('/browse/recent-post', [PostController::class, 'GetRecentViewedPost']);
    Route::post('/wishlist/add', [PostController::class, 'AddWishList']);

    // Category Endpoint
    Route::get('/category/list', [CategoryController::class, 'GetAllCategory']);

    // Location Endpoint
    Route::get('/geocoding/{location}', [LocationController::class, 'GetSearchLocation']);
    Route::get('/location/list', [LocationController::class, 'GetUserLocation']);
    Route::post('/post/location', [LocationController::class, 'PostLocation']);

    // Inbox Endpoint
    Route::get('/inbox/list', [InboxController::class, 'GetAllContacts']);
    Route::post('/inbox/inquire', [InboxController::class, 'TapToInquire']);
    Route::post('/inbox/update/is-read', [InboxController::class, 'UpdateIsReadStatus']);
    Route::post('/inbox/messages', [InboxController::class, 'GetMessagesByID']);
    Route::post('/inbox/send-message', [InboxController::class, 'ComposeMessage']);

    // Buy Credits
    Route::get('/checkout/list', [CreditsController::class, 'GetAllCheckoutCredits']);
    Route::post('/checkout/completed', [CreditsController::class, 'CompletePayment']);
    Route::post('/checkout', [CreditsController::class, 'CheckoutCredits']);
    Route::post('/checkout/cancel', [CreditsController::class, 'CancelCheckout']);
    Route::post('/checkout/delete', [CreditsController::class, 'DeleteCheckout']);

    // User Transactions
    Route::get('/transaction/list', [TransactionsController::class, 'GetUserTransactions']);
    Route::post('/transaction/additional-info', [TransactionsController::class, 'GetAdditionalInformation']);
    Route::post('/transaction/create', [TransactionsController::class, 'OpenTransactions']);
    Route::post('/transaction/proceed', [TransactionsController::class, 'ProceedTransactions']);
    Route::post('/transaction/additional', [TransactionsController::class, 'AdditionalInformation']);
    Route::post('/transaction/rate', [TransactionsController::class, 'RateVendor']);

    // My Store
    Route::get('/mystore/user-post', [PostController::class, 'GetPostByUserID']);
    Route::post('/mystore/getPostImagesByID', [PostController::class, 'GetPostImagesByID']);
    Route::get('/mystore/user-wishlist', [PostController::class, 'GetWishlistImagesByUserID']);
    Route::post('/mystore/getWishlistImagesByID', [PostController::class, 'GetWishlistImagesByID']);
    Route::get('/mystore/user-ratings', [RatingsController::class, 'GetRatingsByUserID']);

    // Verification
    Route::post('/verification-request', [VerificationController::class, 'PostVerificationRequest']);

    // Withdrawal
    Route::get('/withdrawal/list', [WithdrawalController::class, 'GetEveryWithdrawalList']);
    Route::post('/withdrawal/getWithdrawalByID', [WithdrawalController::class, 'GetWithdrawalByID']);
    Route::post('/withdrawal/updateWithdrawalStatus', [WithdrawalController::class, 'UpdateWithdrawalStatus']);

    // Settings

    // Report User
    Route::post('/report-user', [ReportedUserController::class, 'PostReportUser']);
});


// Admin Unauthenticated Routes

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
