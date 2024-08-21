<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\QrCodeGeneratorController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\StudentController;
use App\Http\Middleware\DynamicAdminUrl;
use App\Http\Controllers\AcademicPeriodController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocialShareController;
use App\Http\Controllers\StatisticalController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

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

/**
 * Route for user
 */
Route::get('/', [EventController::class, 'getHomeEvents'])->name('home');
Route::get('/api/upcoming-events', [EventController::class, 'fetchUpcomingEvents']);
Route::get('/api/featured-events', [EventController::class, 'fetchFeaturedEvents']);
Route::get('/api/all-events', [EventController::class, 'getAllEventUser']);
Route::get('/api/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
Route::get('/api/students/{id}', [StudentController::class, "getStudentsById"])->name("students.get");


Route::get('api/events/featured', [EventController::class, 'getFeaturedEvents'])->name('events.get.featured');
Route::get('/tim-kiem', [EventController::class, 'getEventBySearch'])->name('events.all.search');

Route::get('/tracuu', function () {
    return view('search');
})->name('tra-cuu');

Route::get('/search', [StudentController::class, 'searchEventsByStudent'])->name('search_events_by_student');
Route::get('/su-kien/{name}-{id}', [EventController::class, 'detail'])->where(['name' => '[\w-]+', 'id' => '[\d]+'])->name('events.detail');
Route::get('/qr-codes', [QrCodeGeneratorController::class, 'generate']);
Route::get('/diemdanh/{code}', [AttendanceController::class, 'attend'])->name('attend');
Route::post('/diemdanh', [AttendanceController::class, 'submitAttendance'])->name('submit.attendance');
Route::get('/su-kien/{name}-{id}/dangky', [AttendanceController::class, 'register'])->where(['name' => '[\w-]+', 'id' => '[\d]+'])->name('regiter');
Route::post('/su-kien/dangky', [AttendanceController::class, 'submitRegister'])->name('submit.register');
Route::get('/calendar-event', [ScheduleController::class, 'index'])->name('calendar-event');
Route::get('api/events/featured', [EventController::class, 'getFeaturedEvents'])->name('events.get.featured');

// Auth routes
Route::get('/auth/login', [AuthController::class, "showLogin"])->name("login");
Route::post('/auth/login', [AuthController::class, "login"])->name("handle_login");
Route::post('/auth/logout', [AuthController::class, "logout"])->name("handle_logout");
Route::post('/upload', [UploadController::class, 'upload'])->name('upload');
Route::post('/auth/change-password', [AccountController::class, 'changePassword'])->name('change_password');
Route::get('/forget/password/form', [MailController::class, "showResetPasswordForm"])->name("forget.password.form");
Route::post('/api/forget/password', [MailController::class, "resetPassword"])->name("forget.password");
Route::get('/forget/password/confirm', [MailController::class, "showConfirmTokenForm"])->name("forget.password.confirm");
Route::get('/forget/password/change/form', [MailController::class, "showChangePasswordForm"])->name("forget.password.change.form");
Route::post('/forget/password/change', [MailController::class, "changePassword"])->name("forget.password.change");
Route::post('/api/forget/password/confirm', [MailController::class, "confirmToken"])->name("forget.password.confirm.token");



// Lấy giá trị admin_url từ database
if (Schema::hasTable('settings')) {
    $adminUrl = DB::table('settings')->where('key', 'admin_url')->value('value');
    if ($adminUrl) {
        Route::prefix($adminUrl)->group(function () {
            /**
             * Route for admin
             */

            // Routes only use for super-admin
            Route::middleware(['auth', 'role_or_permission:super-admin'])->group(function () {
                // Route for create, edit, delete account admin
                Route::resource('accounts', AccountController::class);
                Route::resource('roles', RoleController::class);
                // Route for move event to trash
                Route::get('admin/dashboard/events/trash', [EventController::class, 'showTrash'])->name('events.trash');
                Route::get('api/events/trash', [EventController::class, 'trash'])->name('events.trash.more');
                // Route for delete event
                Route::get('admin/dashboard/events/{id}/delete', [EventController::class, 'delete'])->name("events.delete");
            });

            // Routes only use for admin have permission to edit event
            Route::middleware(['auth', 'role_or_permission:edit event'])->group(function () {
                // Route for edit event
                Route::get('admin/dashboard/events/{id}/edit', [EventController::class, 'edit'])->name("events.edit");
                Route::post('admin/dashboard/events/{id}/edit', [EventController::class, 'update'])->name("events.update");
            });

            // Routes only use for admin have permission to delete event => move to trash
            Route::middleware(['auth', 'role_or_permission:delete event'])->group(function () {
                // Route for move event to trash
                Route::get('admin/dashboard/events/trash/{id}', [EventController::class, 'moveEventToTrash'])->name('events.move.trash');
            });

            // Routes only use for admin have permission to add event
            Route::middleware(['auth', 'role_or_permission:create event'])->group(function () {
                // Route for create event
                Route::get('admin/dashboard/events/create', [EventController::class, 'create'])->name("events.create");
                Route::post('admin/dashboard/events/store', [EventController::class, 'store'])->name("events.store");
            });

            // Routes only use for admin have permission to restore event
            Route::middleware(['auth', 'role_or_permission:restore event'])->group(function () {
                // Route for restore event from trash
                Route::get('admin/dashboard/events/restore/{id}', [EventController::class, 'restoreEventFromTrash'])->name('events.move.restore');
            });

            // Routes only use for admin have permission to featured event
            Route::middleware(['auth', 'role_or_permission:featured event'])->group(function () {
                // Route for featured event
                Route::get('admin/dashboard/events/featured/{id}', [EventController::class, 'featuredEvent'])->name('events.featured');
                
            });

            // Routes only use for admin have permission to cancel event
            Route::middleware(['auth', 'role_or_permission:cancel event'])->group(function () {
                // Route for cancel event
                Route::get('admin/dashboard/events/cancel/{id}', [EventController::class, 'cancelEvent'])->name('events.cancel');
            });

            // Routes only use for admin
            Route::middleware(['auth'])->group(function () {

                /**
                 *  ============ Dashboard ============
                 */
                Route::get('/admin/dashboard', function () {
                    return view('dashboards.admin.index');
                })->name("dashboard");


                /**
                 *  ============ Statistical ============
                 */
                Route::get('admin/dashboard/statisticals', [StatisticalController::class, 'index'])->name("statisticals.index");
                Route::get('admin/dashboard/statisticals/{id}', [StatisticalController::class, 'eventDetails'])->name('events.details');
                Route::get('admin/dashboard/statisticals/export/{eventId}', [EventController::class, 'exportEventToExcel'])->name('events.export.excel');

                /**
                 *  ============ Events ============
                 */

                // Route for export events
                Route::post('admin/dashboard/events/export', [EventController::class, 'exportEvents'])->name('events.export.excel.list');
                Route::get('/api/events/{id}/participants', [EventController::class, 'getParticipants'])->name("events.participants");
                Route::post('admin/dashboard/events/export', [EventController::class, 'exportEvents'])->name('events.export.excel.list');
                
                // Route for generate qr code
                Route::get('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'create'])->name("qr-codes.create");
                Route::get('admin/dashboard/events/{id}/qr-codes/show', [QrCodeGeneratorController::class, 'show'])->name("qr-codes.show");
                Route::post('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'store'])->name("qr-codes.store");
                Route::delete('admin/dashboard/events/{id}/qr-codes', [QrCodeGeneratorController::class, 'deleteQRByDate'])->name("qr-codes.delete");
                Route::delete('admin/dashboard/events/{event_id}/qr-codes/delete', [QrCodeGeneratorController::class, 'deleteByEventId'])->name("qr-codes.deleteByEventId");

                //Route for generate form for event
                Route::get('admin/dashboard/events/{id}/form', [FormController::class, 'create'])->name("event.create.form");
                Route::post('admin/dashboard/events/form', [FormController::class, 'store'])->name("event.store.form");
                Route::get('admin/dashboard/events/{id}/form/delete', [FormController::class, 'destroy'])->name("event.delete.form");
                // Route question
                Route::get('admin/dashboard/events/show-question/{id}', [QuestionController::class, 'show'])->name("event.show.question");
                Route::post('admin/dashboard/events/save-question', [QuestionController::class, 'store'])->name("event.store.question");
                Route::put('admin/dashboard/events/edit-question/{id}', [QuestionController::class, 'update'])->name("event.update.question");
                Route::delete('admin/dashboard/events/delete-question/{id}', [QuestionController::class, 'destroy'])->name("event.delete.question");
                //Route statistic, export annd delete
                Route::get('admin/dashboard/events/{id}/form/statistic', [FormController::class, 'getStatistic'])->name("event.statistic.form");
                Route::get('admin/dashboard/events/{id}/form/export', [FormController::class, 'export'])->name("event.export.form");

                // Route for load more events, search events
                Route::get('/api/events/more', [EventController::class, 'loadmore'])->name("events.more");
                Route::get('/api/events/search', [EventController::class, 'search'])->name("events.search");
                Route::get('/api/events/trash/search', [EventController::class, 'searchEventsTrash'])->name("events.trash.search");
                // Route for show event
                Route::get('admin/dashboard/events/{id}', [EventController::class, 'show'])->name("events.show");
                Route::get('admin/dashboard/events', [EventController::class, 'index'])->name("events.index");
                Route::get('/api/events', [EventController::class, 'getAllEvents'])->name("events.all");
                // Route for get question of event
                Route::get('/api/events/{id}/questions', [EventController::class, 'getEventQuestion'])->name("events.questions");
                // Route for get students register event
                Route::get('/api/events/{id}/register/students', [EventController::class, 'getRegisteredStudents'])->name("events.register.students");
                // Route for export students register event
                Route::get('/api/events/{id}/register/students/export', [EventController::class, 'exportRegisterEventToExcel'])->name("events.register.students.export");

                /**
                 *  ============ Students ============
                 */
                // Route for get students order by event participated count
                Route::get('/api/events/participants/students', [StudentController::class, 'getStudentsByEventCount'])->name("events.participants.students");
                // Route for show students
                Route::get('admin/dashboard/students', [StudentController::class, "dashboard"])->name("students.index");
                // Route get academic periods
                Route::get('/api/academic-periods', [AcademicPeriodController::class, "getAcademicPeriods"])->name("academic_period.get");
                // Route for filter students by academic period
                Route::get('admin/dashboard/students/course/{courseYear}', [StudentController::class, "filterStudentByCourse"])->name("students.course.get");
                // Route for export students to excel
                Route::get('admin/dashboard/students/{studentId}/events/export/{academicPeriodId}', [StudentController::class, 'exportStudentEvents'])->name("students.events.export");
                Route::get('admin/dashboard/student/{id}/events/participants/export', [EventController::class, 'exportParticipantsToExcel'])->name('events.export.excel.participants');
                // Route for get total students participated in events
                Route::get('/api/events/students/total/participants', [StudentController::class, 'getTotalStudentsParticipatedInEvents'])->name("students.events.participants.total");
                // Route for import students from excel
                Route::post('/import/students', [ExcelController::class, 'import'])->name('excel.students.import');
                // Route for delete student
                Route::post('admin/dashboard/students/delete', [StudentController::class, 'destroy'])->name('students.delete');
                // Seawrch students
                Route::get('admin/dashboard/students/search/{searchValue}', [StudentController::class, 'searchStudents'])->name('students.search');


                /**
                 *  ============ Social share ============
                 */
                Route::get('social-share/{id}', [SocialShareController::class, 'index'])->name('social-share');
            });

            // Route for show config
            Route::get('admin/dashboard/configs', [ConfigController::class, 'showConfig'])->name('config.show');
            // Route for update config
            Route::post('admin/dashboard/configs/update', [ConfigController::class, 'updateConfig'])->name('config.update');
        });
    }
}
