<?php

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
    return view('welcome');
});

Route::get('/admin/dashboard', function () {
    return view('dashboards.admin.index');
})->name("dashboard");

//Auth
Route::get('/auth/login', [AuthController::class, "showLogin"])->name("login");
Route::post('/auth/login', [AuthController::class, "login"])->name("handle_login");
Route::get('/auth/register', [AuthController::class, "showRegister"])->name("register");
Route::post('/auth/register', [AuthController::class, "register"])->name("handle_register");
Route::post('/auth/logout', [AuthController::class, "logout"])->name("handle_logout");
Route::post('/auth/update', [AuthController::class, "update"])->name("update_profile");

// Event routes
Route::get('admin/dashboard/events', [EventController::class, 'index'])->name("events.index");
Route::get('admin/dashboard/events/create', [EventController::class, 'create'])->name("events.create");
Route::post('admin/dashboard/events/store', [EventController::class, 'store'])->name("events.store");
Route::get('/api/events', [EventController::class, 'getAllEvents'])->name("events.all");
