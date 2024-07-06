<?php

use App\Http\Controllers\AcademicPeriodController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\QrCodeGeneratorController;

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialShareController;
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

Route::get('/', [EventController::class, 'getHomeEvents'])->name('home');
Route::get('/api/upcoming-events', [EventController::class, 'fetchUpcomingEvents']);
Route::get('/api/featured-events', [EventController::class, 'fetchFeaturedEvents']);

Route::get('/tracuu', function () {
    return view('search');
})->name('tra-cuu');

Route::get('/search', [StudentController::class, 'searchEventsByStudent'])->name('search_events_by_student');

Route::get('/sukien/{id}', [EventController::class, 'detail'])->name('events.detail');

Route::get('/qr-codes', [QrCodeGeneratorController::class, 'generate']);

Route::get('/diemdanh/{code}', [AttendanceController::class, 'attend'])->name('attend');
Route::post('/diemdanh', [AttendanceController::class, 'submitAttendance'])->name('submit.attendance');

Route::get('/sukien/{id}/dangky', [AttendanceController::class, 'register'])->name('regiter');
Route::post('/sukien/dangky', [AttendanceController::class, 'submitRegister'])->name('submit.register');

Route::get('/calendar-event', [ScheduleController::class, 'index'])->name('calendar-event');

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', function () {
        return view('dashboards.admin.index');
    })->name("dashboard");

    Route::get('admin/dashboard/statisticals', [StatisticalController::class, 'index'])->name("statisticals.index");
    Route::get('admin/dashboard/statisticals/{id}', [StatisticalController::class, 'eventDetails'])->name('events.details');
    Route::get('admin/dashboard/events', [EventController::class, 'index'])->name("events.index");
    Route::post('admin/dashboard/events/export', [EventController::class, 'exportEvents'])->name('events.export.excel.list');
    Route::get('admin/dashboard/statisticals/export/{eventId}', [EventController::class, 'exportEventToExcel'])->name('events.export.excel');
    Route::get('/api/events/{id}/participants', [EventController::class, 'getParticipants'])->name("events.participants");
    Route::get('/api/events', [EventController::class, 'getAllEvents'])->name("events.all");
    Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
    Route::get('/api/events/search', [EventController::class, 'search'])->name("events.search");
    Route::get('/api/events/participants/students', [StudentController::class, 'getStudentsByEventCount'])->name("events.participants.students");
    Route::get('admin/dashboard/students', [StudentController::class, "dashboard"])->name("students.index");
    Route::get('/api/students/{id}', [StudentController::class, "getStudentsById"])->name("students.get");
    Route::get('/api/academic-periods', [AcademicPeriodController::class, "getAcademicPeriods"])->name("academic_period.get");
    Route::get('admin/dashboard/students/course/{courseYear}', [StudentController::class, "filterStudentByCourse"])->name("students.course.get");
    Route::get('admin/dashboard/students/{studentId}/events/export/{academicPeriodId}', [StudentController::class, 'exportStudentEvents'])->name("students.events.export");
    Route::post('admin/dashboard/events/export', [EventController::class, 'exportEvents'])->name('events.export.excel.list');
    Route::get('admin/dashboard/student/{id}/events/participants/export', [EventController::class, 'exportParticipantsToExcel'])->name('events.export.excel.participants');
    Route::get('social-share/{id}', [SocialShareController::class, 'index'])->name('social-share');
    Route::get('admin/dashboard/events/trash/{id}', [EventController::class, 'moveEventToTrash'])->name('events.move.trash');
    Route::get('admin/dashboard/events/trash', [EventController::class, 'showTrash'])->name('events.trash');
    Route::get('api/events/trash', [EventController::class, 'trash'])->name('events.trash.more');
    Route::get('admin/dashboard/events/cancel/{id}', [EventController::class, 'cancelEvent'])->name('events.cancel');
    Route::get('admin/dashboard/events/restore/{id}', [EventController::class, 'restoreEventFromTrash'])->name('events.move.restore');
});

// Routes chỉ cho super-admin
Route::middleware(['auth', 'role_or_permission:super-admin'])->group(function () {
    Route::get('admin/dashboard/events/create', [EventController::class, 'create'])->name("events.create");
    Route::post('admin/dashboard/events/store', [EventController::class, 'store'])->name("events.store");
    Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");

    Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
    Route::get('/api/events/search', [EventController::class, 'search'])->name("events.search");

    Route::get('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'create'])->name("qr-codes.create");
    Route::get('admin/dashboard/events/{id}/qr-codes/show', [QrCodeGeneratorController::class, 'show'])->name("qr-codes.show");
    Route::post('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'store'])->name("qr-codes.store");

    Route::get('admin/dashboard/events/{id}/edit', [EventController::class, 'edit'])->name("events.edit");
    Route::post('admin/dashboard/events/{id}/edit', [EventController::class, 'update'])->name("events.update");
    Route::get('admin/dashboard/events/{id}/delete', [EventController::class, 'delete'])->name("events.delete");
});


// Routes chỉ cho admin có quyền edit
Route::middleware(['auth', 'role_or_permission:edit event'])->group(function () {
    Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");
    Route::get('admin/dashboard/events/{id}/edit', [EventController::class, 'edit'])->name("events.edit");
    Route::post('admin/dashboard/events/{id}/edit', [EventController::class, 'update'])->name("events.update");
});

// Auth routes
Route::get('/auth/login', [AuthController::class, "showLogin"])->name("login");
Route::post('/auth/login', [AuthController::class, "login"])->name("handle_login");
Route::post('/auth/logout', [AuthController::class, "logout"])->name("handle_logout");
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');