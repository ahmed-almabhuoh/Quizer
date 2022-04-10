<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
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
    Route::resource('/questions', QuestionController::class);

    // To get quiz with its questions
    Route::get('/quiz/{id}/questions', [QuizController::class, 'getToQuizQuestions'])->name('quiz.questions');

    // Add questions to quiz
    Route::get('/quiz/{id}/add-questions', [QuizController::class, 'addQuestionToQuiz'])->name('add.questions');

    // Add student to room
    Route::get('/add-student-to-room/{id}/room', [RoomController::class, 'showAddStudentToClass'])->name('add.student.to.room');
    Route::post('/add-student-to-room/{room}/room', [RoomController::class, 'addStudentToClass']);

    // Change password
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change.password');
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
