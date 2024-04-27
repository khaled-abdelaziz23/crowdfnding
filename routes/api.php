<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminconttroller;
use App\Http\Controllers\projectcontroller;
use App\Http\Controllers\commentcontroller;

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
Route::post('editproject/{id}', [projectcontroller::class , 'editproject'])->name('project.editproject');
Route::delete('deleteproject/{id}', [projectcontroller::class , 'deleteproject'])->name('user.deleteproject');
Route::get('decrease', [projectcontroller::class , 'decrease'])->name('date.decrease');
Route::get('allproject', [projectcontroller::class , 'allproject'])->name('project.allproject');
Route::get('collectedmoney', [projectcontroller::class , 'collectedmoney'])->name('project.collectedmoney');

//#############################Projects_routes###############################/ 

//#############################backer_routes###############################/ 
Route::get('backer/{id}', [projectcontroller::class , 'backer'])->name('project.backer');
Route::get('userbacker/{id}', [projectcontroller::class , 'userbacker'])->name('user.backer');
Route::post('backproject/{user}/{project}', [projectcontroller::class , 'backproject'])->name('backproject');
Route::get('allbacker', [projectcontroller::class , 'allbacker'])->name('allbacker.backer');

//#############################backer_routes###############################/ 

//#############################complaints_routes###############################/ 
Route::get('allcomplain', [projectcontroller::class , 'allcomplain'])->name('allcomplain.backer');
Route::post('addcomplain/{user}/{project}', [projectcontroller::class , 'addcomplain'])->name('addcomplain');
Route::get('addcomplaintuser/{id}', [projectcontroller::class , 'addcomplaintuser'])->name('addcomplaintuser');
Route::get('complaintproject/{id}', [projectcontroller::class , 'complaintproject'])->name('complaintproject');
Route::post('deletecomplaint/{id}', [projectcontroller::class , 'deletecomplaint'])->name('deletecomplaint');
//#############################comments_routes###############################/ 
Route::get('allcomments', [commentcontroller::class , 'usercomment'])->name('usercomment');
Route::get('usercomment/{id}', [commentcontroller::class , 'usercomment'])->name('usercomment');
Route::get('projectcomment/{id}', [commentcontroller::class , 'projectcomment'])->name('projectcomment');
Route::post('commenting/{user}/{project}', [commentcontroller::class , 'commenting'])->name('commenting');
Route::post('deletecomment/{id}', [commentcontroller::class , 'deletecomment'])->name('deletecomment');
