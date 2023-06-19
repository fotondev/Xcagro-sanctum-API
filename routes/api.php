<?php

use App\Http\Controllers\Api\v1\Admin\DeleteUser;
use App\Http\Controllers\Api\v1\Admin\EditUser;
use App\Http\Controllers\Api\v1\Admin\ListUsers;
use App\Http\Controllers\Api\v1\Admin\ShowUser;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CargoController;
use App\Http\Controllers\Api\v1\CustomerController;
use App\Http\Controllers\Api\v1\OrderController;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\TokenController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

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


//Api-Token
Route::post('/sanctum/token', TokenController::class);



//Auth
Route::group(['middleware' => config('fortify.middleware', ['auth:sanctum'])], function () {

    Route::get('/user', [AuthController::class, 'me']);

    //Customers and Orders
    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('customer.show');
        Route::post('/', [CustomerController::class, 'store'])->name('customer.store');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('customer.delete');

        Route::prefix('/{customer}/orders')->group(function () {
            Route::get('/', [OrderController::class, 'listByCustomer'])->name('customer-orders.index');
            Route::get('/{order}', [OrderController::class, 'show'])->name('customer-order.show');
            Route::post('/', [OrderController::class, 'store'])->name('customer-order.store');
            Route::put('/{order}', [OrderController::class, 'update'])->name('customer-order.update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('customer-order.delete');
        });
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('order.show');
        Route::post('/', [OrderController::class, 'store'])->name('order.store');
        Route::put('/{order}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('order.delete');

        //Cargos
        Route::prefix('/{order}/cargos')->group(function () {
            Route::get('/', [CargoController::class, 'index'])->name('cargo.index');
            Route::get('/{cargo?}', [CargoController::class, 'show'])->name('cargo.show');
            Route::post('/', [CargoController::class, 'store'])->name('cargo.store');
            Route::put('/{cargo}', [CargoController::class, 'update'])->name('cargo.update');
            Route::delete('/{cargo}', [CargoController::class, 'destroy'])->name('cargo.delete');
        });
    });


    //Users
    Route::prefix('/admin/users')->middleware('role:admin')->group(function () {
        Route::get('/', ListUsers::class);
        Route::get('/{user}', ShowUser::class);
        Route::post('/', [RegisteredUserController::class, 'store']);
        Route::put('/{user}', EditUser::class);
        Route::delete('/{user}', DeleteUser::class);
    });





    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');


    // Email Verification...
    $verificationLimiter = config('fortify.limiters.verification', '6,1');

    if (Features::enabled(Features::emailVerification())) {
        Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'signed', 'throttle:' . $verificationLimiter])
            ->name('verification.verify');

        Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
            ->name('verification.send');
    }

    // Profile Information...
    if (Features::enabled(Features::updateProfileInformation())) {
        Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-profile-information.update');
    }

    // Passwords...
    if (Features::enabled(Features::updatePasswords())) {
        Route::put('/user/password', [PasswordController::class, 'update'])
            ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
            ->name('user-password.update');
    }

    // Password Confirmation...
    Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('password.confirmation');

    Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
        ->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('password.confirm');
});

//Guest
Route::middleware(['guest:' . config('fortify.guard')])->group(function () {
    //Login
    $limiter = config('fortify.limiters.login');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware(
            $limiter ? 'throttle:' . $limiter : null,
        )->name('login');


    //Password
    if (Features::enabled(Features::resetPasswords())) {
        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
            ->name('password.email');
        Route::post('/reset-password', [NewPasswordController::class, 'store'])
            ->name('password.update');
    }
});
