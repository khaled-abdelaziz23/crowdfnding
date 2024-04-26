<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminconttroller;
use App\Http\Controllers\projectcontroller;

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
Route::get('index', [adminconttroller::class , 'index'])->name('index.user');


Route::put('update/{id}', [adminconttroller::class , 'update'])->name('user.update');
Route::get('show/{id}', [adminconttroller::class , 'show'])->name('user.show');
Route::delete('delete/{id}', [adminconttroller::class , 'delete'])->name('user.delete');

Route::post('registeration', [adminconttroller::class , 'registiration'])->name('user.registiration');
Route::post('adduser', [adminconttroller::class , 'adduser'])->name('user.add');
Route::post('userphoto/{id}', [adminconttroller::class , 'userphoto'])->name('user.userphoto');


//#############################Projects_routes###############################/ 
Route::get('getproject/{id}', [projectcontroller::class , 'getproject'])->name('user.getproject');
Route::post('addproject/{user}', [projectcontroller::class , 'addproject'])->name('user.addproject');
Route::delete('deleteproject/{id}', [projectcontroller::class , 'deleteproject'])->name('user.deleteproject');
Route::get('decrease', [projectcontroller::class , 'decrease'])->name('date.decrease');
Route::get('allproject', [projectcontroller::class , 'allproject'])->name('project.allproject');
Route::get('collectedmoney', [projectcontroller::class , 'collectedmoney'])->name('project.collectedmoney');

//#############################Projects_routes###############################/ 

//#############################backer_routes###############################/ 
