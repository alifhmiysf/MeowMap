
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatSpottingController;
use App\Http\Controllers\Api\BreedController;
use App\Http\Controllers\Api\ListingController;

use App\Http\Controllers\Api\Admin\CatSpottingModerationController;
use App\Http\Controllers\Api\Admin\ListingModerationController;
use App\Http\Controllers\Api\Admin\AdminAnalyticsController;
use App\Http\Controllers\Api\Admin\AdminCatSpottingController;

// =====================================================
// AUTHENTICATION
// =====================================================

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// =====================================================
// PUBLIC CAT SPOTTINGS
// =====================================================

Route::get('/cat-spottings', [CatSpottingController::class, 'index']);
Route::get('/cat-spottings/{catSpotting}', [
    CatSpottingController::class,
    'show'
]);


// =====================================================
// BREEDS
// =====================================================

Route::get('/breeds', [BreedController::class, 'index']);
Route::get('/breeds/{breed}', [BreedController::class, 'show']);


// =====================================================
// PUBLIC MARKETPLACE
// =====================================================

Route::get('/listings', [ListingController::class, 'index']);
Route::get('/listings/{listing}', [ListingController::class, 'show']);


// =====================================================
// AUTHENTICATED USER
// =====================================================

Route::middleware('auth:sanctum')->group(function () {

    // Current authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);


    // -------------------------------------------------
    // CAT SPOTTING MANAGEMENT
    // -------------------------------------------------

    Route::post('/cat-spottings', [
        CatSpottingController::class,
        'store'
    ]);

    Route::patch('/cat-spottings/{catSpotting}', [
        CatSpottingController::class,
        'update'
    ]);

    Route::delete('/cat-spottings/{catSpotting}', [
        CatSpottingController::class,
        'destroy'
    ]);


    // -------------------------------------------------
    // MARKETPLACE MANAGEMENT
    // -------------------------------------------------

    Route::post('/listings', [
        ListingController::class,
        'store'
    ]);

    Route::patch('/listings/{listing}', [
        ListingController::class,
        'update'
    ]);

    Route::delete('/listings/{listing}', [
        ListingController::class,
        'destroy'
    ]);


    // =================================================
    // ADMIN API
    // Requires authentication and manage-meowmap ability
    // =================================================

    Route::prefix('admin')
        ->middleware('can:manage-meowmap')
        ->group(function () {

            // -----------------------------------------
            // CAT SPOTTING MODERATION
            // -----------------------------------------

            // Get reports for the admin dashboard
            Route::get('/cat-spottings', [
                CatSpottingModerationController::class,
                'index'
            ]);

            // Approve or reject a report
            Route::patch('/cat-spottings/{catSpotting}/status', [
                CatSpottingModerationController::class,
                'updateStatus'
            ]);

            // Soft delete a report
            Route::delete('/cat-spottings/{catSpotting}', [
                AdminCatSpottingController::class,
                'destroy'
            ]);


            // -----------------------------------------
            // LISTING MODERATION
            // -----------------------------------------

            Route::get('/listings', [
                ListingModerationController::class,
                'index'
            ]);

            Route::patch('/listings/{listing}/status', [
                ListingModerationController::class,
                'updateStatus'
            ]);


            // -----------------------------------------
            // ADMIN ANALYTICS
            // -----------------------------------------

            // Report statistics, trends, and district data
            Route::get('/analytics', [
                AdminAnalyticsController::class,
                'index'
            ]);
        });
});
