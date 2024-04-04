<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminconttroller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [adminconttroller::class , 'loginn'])->name('login.login')->middleware('logintokin');
Route::post('logoutt', [adminconttroller::class , 'logoutt'])->name('logoutt.user')->middleware('logintokin');
Route::post('index', [adminconttroller::class , 'index'])->name('index.user');
