<?php

use App\Http\Controllers\ScheduleController;
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


Route::get('/admin/dashboard', function () {
    return view('dashboards.admin.index');
});
