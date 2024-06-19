<?php
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
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
});

Route::get('/tracuu', function () {
    return view('search');
});

Route::get('/event/{id}', function () {
    return view('detail');
});

Route::get('/calendar-event', [ScheduleController::class, 'index']);

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
