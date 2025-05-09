<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;

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
//Route::get('/',[ApiController::class,'loginpage']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/addNewUser', [APIController::class, 'addNewUser'])->name('signup');
Route::get('/login', [ApiController::class, 'login'])->name('login');
Route::post('/addCustomer', [APIController::class, 'addCustomer'])->name('addcustF');
Route::post('/apiupdate', [APIController::class, 'apiupdate'])->name('apiupdate');
