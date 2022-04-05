<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('cms')->middleware('guest:teacher')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});

Route::prefix('/cms/admin')->middleware('auth:teacher')->group(function () {
    Route::view('/', 'cms.index')->name('dashboard');
    Route::resource('/rooms', RoomController::class);
    Route::resource('/students', StudentController::class);
    Route::resource('/quizzes', QuizController::class);

    // Change password
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
