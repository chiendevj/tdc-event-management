<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\QrCodeGeneratorController;
use Illuminate\Support\Facades\Route;

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
    return view('home');
})->name('home');

Route::get('/tracuu', function () {
    return view('search');
})->name('search');

Route::get('/event/{id}', function () {
    return view('detail');
});

Route::get('/qr-codes', [QrCodeGeneratorController::class, 'generate']);

Route::get('/diemdanh/{code}', [AttendanceController::class, 'attend'])->name('attend');
Route::post('/diemdanh', [AttendanceController::class, 'submitAttendance'])->name('submit.attendance');


Route::get('/calendar-event', [ScheduleController::class, 'index'])->name('calendar-event');

// Routes chỉ cho super-admin
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin.index');
    })->name("dashboard");
    Route::get('admin/dashboard/events', [EventController::class, 'index'])->name("events.index");

});

Route::middleware(['auth', 'role_or_permission:super-admin'])->group(function () {
    // Event routes
    Route::get('admin/dashboard/events/create', [EventController::class, 'create'])->name("events.create");
    Route::post('admin/dashboard/events/store', [EventController::class, 'store'])->name("events.store");
    Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");
    Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
    Route::get('/api/events/search', [EventController::class, 'search'])->name("events.search");

    Route::get('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'create'])->name("qr-codes.create");
    Route::get('admin/dashboard/events/{id}/qr-codes/show', [QrCodeGeneratorController::class, 'show'])->name("qr-codes.show");
    Route::post('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'store'])->name("qr-codes.store");
});


// Routes chỉ cho admin có quyền edit
Route::middleware(['auth', 'role_or_permission:edit event'])->group(function () {
    Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");
    Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
});

// Public routes
Route::get('/api/events', [EventController::class, 'getAllEvents'])->name("events.all");

// Auth routes
Route::get('/auth/login', [AuthController::class, "showLogin"])->name("login");
Route::post('/auth/login', [AuthController::class, "login"])->name("handle_login");
Route::post('/auth/logout', [AuthController::class, "logout"])->name("handle_logout");
