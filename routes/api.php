<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CertificateController;
use Illuminate\Http\Request;
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

//rotas públicas
Route::post('/register' , [AuthController::class, 'register'])->name('auth.register');
Route::post('/login' , [AuthController::class, 'login'])->name('auth.login');

//rotas privadas, necessitam estar autenticadas
Route::group(['middleware' => ['auth:api', 'cors']], function(){
    Route::apiResource('certificates', CertificateController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
