<?php

use App\Http\Controllers\ApiController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', function () {
        return "Halo";
});
Route::post('/login', [ApiController::class, 'login']);
Route::middleware(['auth'])->group(function () {
    Route::get('/todos', [ApiController::class, 'getalltodos']);
    Route::post('/todos', [ApiController::class, 'addtodos']);
    Route::put('/todos', [ApiController::class, 'updatetodos']);
    Route::delete('/todos/{id}', [ApiController::class, 'deletetodos']);
    Route::get('/logout', [ApiController::class, 'logout']);
});


