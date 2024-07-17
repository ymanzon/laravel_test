<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth',
    ], function ($route){
        Route::post('login',[AuthController::class, 'login']);
        Route::post('register',[AuthController::class, 'register']);
        //Route::post('logout', 'AuthController@logout');
        //Route::post('refresh', 'AuthController@refresh');
        //Route::post('me', 'AuthController@me');
    }
);

Route::middleware('auth:api')->get('/', [HomeController::class, 'home']);
Route::middleware('auth:api')->get('/user/retrive', [UserController::class, 'retrive']);

Route::middleware('auth:api')->get('user/show', [UserController::class, 'show']);
Route::middleware('auth:api')->put('user/deactivate', [UserController::class, 'deactivate']);

/*
Route::middleware('auth:api')->get('/user/show', [UserController::class, 'show']);
Route::middleware('auth:api')->get('/user/update', [UserController::class, 'update']);
Route::middleware('auth:api')->get('/user/destroy', [UserController::class, 'destroy']);
Route::middleware('auth:api')->get('/user/deactivate', [UserController::class, 'deactivate']);
*/
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/


