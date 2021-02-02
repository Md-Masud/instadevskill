<?php
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use \App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// user auth
Route::post('register',[AuthController::class ,'register']);
Route::post('login',[AuthController::class,'login']);

// email verification
Route::get('/email/verify/{id}', [\App\Http\Controllers\VerificationController::class, 'verify'])
    ->name('verification.verify');
Route::post('/forgot-password', [\App\Http\Controllers\PasswordController::class, 'forgotPassword'])
    ->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', function ($token) {
    dd($token);
})->middleware('guest')->name('password.reset');

//route user
Route::middleware('auth:api')->group(function () {
    Route::get('/user',function (Request $request)
    {
        return $request->user();
    });
   Route::post('follow',[UserController::class,'follow']);
   Route::get('follows',[UserController::class,'follows']);
});

