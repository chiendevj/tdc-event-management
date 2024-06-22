<?php
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StatisticalController;
use App\Http\Controllers\StudentController;
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
})->name('tra-cuu');

Route::get('/search', [StudentController::class, 'searchEventsByStudent'])->name('search_events_by_student');

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
    Route::get('admin/dashboard/statisticals', [StatisticalController::class, 'index'])->name("statisticals.index");
    Route::get('admin/dashboard/statisticals/{id}', [StatisticalController::class, 'eventDetails'])->name('events.details');
    Route::get('admin/dashboard/statisticals/export/{eventId}', [EventController::class, 'exportEventToExcel'])->name('events.export.excel');
    Route::post('admin/dashboard/events/export', [EventController::class, 'exportEvents'])->name('events.export.excel.list');

    Route::get('/events/{id}/share', [FacebookController::class, 'share'])->name('events.share');
});

Route::middleware(['auth', 'role_or_permission:super-admin'])->group(function () {
    // Event routes
    Route::get('admin/dashboard/events/create', [EventController::class, 'create'])->name("events.create");
    Route::post('admin/dashboard/events/store', [EventController::class, 'store'])->name("events.store");
    Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");
    Route::get('admin/dashboard/events/{id}/edit', [EventController::class, 'edit'])->name("events.edit");
    Route::post('admin/dashboard/events/{id}/edit', [EventController::class, 'update'])->name("events.update");
    Route::get('admin/dashboard/events/{id}/delete', [EventController::class, 'delete'])->name("events.delete");
    Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
    Route::get('/api/events/search', [EventController::class, 'search'])->name("events.search");
});


// Routes chỉ cho admin có quyền edit
Route::middleware(['auth', 'role_or_permission:edit event'])->group(function () {
    Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");
    Route::get('admin/dashboard/events/{id}/edit', [EventController::class, 'edit'])->name("events.edit");
    Route::post('admin/dashboard/events/{id}/edit', [EventController::class, 'update'])->name("events.update");
    Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
    Route::get('/api/events/search', [EventController::class, 'search'])->name("events.search");
});

// Public routes
Route::get('/api/events', [EventController::class, 'getAllEvents'])->name("events.all");

// Auth routes
Route::get('/auth/login', [AuthController::class, "showLogin"])->name("login");
Route::post('/auth/login', [AuthController::class, "login"])->name("handle_login");
Route::post('/auth/logout', [AuthController::class, "logout"])->name("handle_logout");
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');

