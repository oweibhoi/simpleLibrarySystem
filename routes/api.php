<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BorrowerController;
use App\Http\Controllers\Api\BorrowListController;
use App\Http\Controllers\Api\ReturnListController;
use App\Http\Controllers\API\AuthController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('book', BookController::class);
    Route::resource('borrower', BorrowerController::class);
    Route::resource('borrow_list', BorrowListController::class);
    Route::get('return_list', 'App\Http\Controllers\Api\ReturnListController@index');
    Route::get('return_list/{id}', 'App\Http\Controllers\Api\ReturnListController@show');
    Route::put('return_list/return/{id}', 'App\Http\Controllers\Api\ReturnListController@return');
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
