<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\UsersAccessControlMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('login');
})->name('login')->middleware('guest');
Route::get('/registration', function () {
    return view('registration');
})->name('registration')->middleware('guest');
Route::middleware(['auth'])->group(function(){
    Route::get('/unauthorized', function () {
        return view('unauthorized');
    })->name('unauthorized');
});


Route::get('/custom-logout', [AuthController::class, 'userLogout'])->name('customLogout');

Route::POST('/registration-data', [AuthController::class, 'formValidation'])->name('registration-data');
Route::POST('/user-login', [AuthController::class, 'userLogin'])->name('userLogin');

Route::prefix('/admin')->middleware(['auth', 'userAccess:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin-dashboard');
    Route::get('/admin-list', function () {
        return view('admin.admin-list');
    })->name('admin-list');

});

Route::prefix('/teacher')->middleware(['auth', 'userAccess:teacher'])->group(function () {
    Route::get('/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher-dashboard');
});

Route::prefix('/student')->middleware(['auth', 'userAccess:student'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.dashboard');
    })->name('student-dashboard');
});

Route::prefix('/parent')->middleware(['auth', 'userAccess:parent'])->group(function () {
    Route::get('/dashboard', function () {
        return view('parent.dashboard');
    })->name('parent-dashboard');
});