<?php

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
})->name('admin.dashboard');


// Event routes
Route::get('/events/create', [EventController::class, 'create'])->name("events.create");
Route::post('/events/store', [EventController::class, 'store'])->name("events.store");
Route::get('/api/events', [EventController::class, 'getAllEvents'])->name("events.all");