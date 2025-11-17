<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\SpecialtyController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('specialties', SpecialtyController::class)->except(['show']);

    // already existing
    // Route::resource('cities', CityController::class);
    // Route::resource('doctors', DoctorController::class);
    // Route::resource('patients', PatientController::class);
    // Route::resource('users', UserController::class);
});

use PhpParser\Comment\Doc;

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

Route::prefix('admin')->name('admin.')->group(function () {

    // User
    Route::resource('users', UserController::class);

    // Patient
    Route::resource('patients', PatientController::class);

    // Doctor
    Route::resource('doctors', DoctorController::class);

    // City
    Route::resource('cities', CityController::class);

    // Specialty
    Route::resource('specialties', SpecialtyController::class);
});



