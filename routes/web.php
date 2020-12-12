<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Admin\HomeController as AdminHome;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->middleware('isUser')->name('index');
Route::get('/home', [AdminHome::class, 'index'])->middleware('isAdmin')->name('home');
Route::get('/data-user', [AdminHome::class, 'dataUser'])->middleware('isAdmin')->name('data.user');
Route::get('/data-user/{id}', [AdminHome::class, 'userDetail'])->middleware('isAdmin')->name('user.detail');
Route::get('/data-user/{id}/history', [AdminHome::class, 'userHistory'])->middleware('isAdmin')->name('data.user.history');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'game','namespace' => 'Api'], function(){
    Route::get('/question',[QuestionController::class, 'getQuestion'])->name('game.question');
    Route::post('/verify',[QuestionController::class, 'verify'])->name('game.question.verify');
});
