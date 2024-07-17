<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('register', [UserController::class, '_register'])->name('register');
Route::post('register', [UserController::class, 'register']);

Route::get('login', [LoginController::class, '_login'])->name('login');
Route::post('login', [LoginController::class, 'login']);

Route::get('/', [HomeController::class, 'home']);
Route::get('/user/retrive', [UserController::class, 'retrive']);

Route::get('user', [UserController::class, 'create'])->name('user.create');
Route::get('user/{user}', [UserController::class, 'show'])->name('user.show');
Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
Route::put('user/deactivate/{user}', [UserController::class, 'deactivate'])->name('user.deactivate');



//Route::get('home/index', [HomeController::class, 'index']);

//Route::get('/', [HomeController::class, 'home'])->middleware('auth:api');
//jwt.auth
/*
Route::group(['middleware' => 'auth:api'], function () {

Route::get('/home', [HomeController::class, 'home']);
Route::get('/home/index', [HomeController::class, 'index']);
});
*/
/*
Route::get('/home', function () {
    return view('home.index');
})->middleware('auth:api');
*/

/*
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('/', [HomeController::class, 'home']);
});*/


/*
Route::get('/', function () {
    return view('welcome');
});
*/
