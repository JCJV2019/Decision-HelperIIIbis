<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ItemController;

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

Route::view('/', 'welcome')->name('home');

Route::prefix('users')->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('users.logout');
    Route::get('/list', [UserController::class, 'index'])->middleware('auth')->name('users.list');
    //
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::get('/register', [UserController::class, 'register'])->name('users.create');
});

Route::controller(QuestionController::class)->middleware('auth')->group(function () {
    Route::get('members', 'index')->name('questionUser.list');
    Route::get('members-list/{question?}', 'show')->name('itemsQuestion.show');
});

Route::controller(ItemController::class)->middleware('auth')->group(function () {
    Route::get('tip/{question}', 'tip')->name('questionTip.tip');
});

Route::fallback(function () {
    return redirect()->route('home');
});
