<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\ResetPasswordController;
use App\Http\Auth\AuthController;
use App\Http\Users\PatientController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\DoctorAvailabilityController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');


// === AUTH ROUTES ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// === DASHBOARD PHÂN QUYỀN THEO ROLE ===
Route::middleware(['auth'])->group(function() {

    // === PATIENT ROUTES ===
    Route::middleware(['role:patient'])->group(function () {
        //  Dashboard
        Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');

        //  Bác sĩ & Đặt lịch (Book/Create)
        Route::get('/patient/doctors', [PatientController::class, 'doctors'])->name('patient.doctors');

        // Tính năng đặt lịch tổng quát (lọc theo chuyên khoa)
        Route::get('/patient/book', [PatientController::class, 'showBookForm'])->name('patient.book');
        Route::post('/patient/book/store', [PatientController::class, 'storeBooking'])->name('patient.book.store');

        // Đặt lịch cụ thể với 1 bác sĩ
        Route::get('/patient/appointment/create/{doctor_id}', [PatientController::class, 'createAppointment'])->name('patient.appointment.create');
        Route::post('/patient/appointment/store', [PatientController::class, 'storeAppointment'])->name('patient.appointment.store');

        //  Lịch khám (Quản lý)
        Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
        Route::get('/patient/appointment/show/{id}', [PatientController::class, 'showAppointment'])->name('patient.appointment.show');
        Route::post('/patient/appointment/cancel/{id}', [PatientController::class, 'cancelAppointment'])->name('patient.appointment.cancel');

        //  Hồ sơ & Cài đặt
        Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile');
        Route::get('/patient/profile/edit', [PatientController::class, 'editProfile'])->name('patient.editProfile');
        Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patient.updateProfile');
        Route::get('/patient/settings', [PatientController::class, 'settings'])->name('patient.settings');
        Route::post('/patient/settings/update-password', [PatientController::class, 'updatePassword'])->name('patient.updatePassword');
        Route::post('/patient/settings/update-notifications', [PatientController::class, 'updateNotifications'])->name('patient.updateNotifications');
    });

    // === DOCTOR ROUTES (placeholder - cần tạo DoctorController) ===
    Route::middleware(['role:doctor'])->group(function () {
        Route::get('/doctors/dashboard', function () {
            return view('user.doctors.dashboard');
        })->name('doctors.dashboard');
    });

    // === ADMIN ROUTES ===
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return 'Admin Dashboard';
        })->name('dashboard');

        // User Management
        Route::resource('users', UserController::class);
        Route::post('users/{id}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');
        Route::post('users/{id}/reactivate', [UserController::class, 'reactivate'])->name('users.reactivate');

        // Reset Password
        Route::get('reset-password', [ResetPasswordController::class, 'index'])->name('reset-password.index');
        Route::post('reset-password/{id}', [ResetPasswordController::class, 'reset'])->name('reset-password.reset');

        // Patient Management
        Route::resource('patients', AdminPatientController::class);

        // Doctor Management
        Route::resource('doctors', DoctorController::class);

        // Doctor Availability Management
        Route::resource('availabilities', DoctorAvailabilityController::class);

        // Custom availability routes
        Route::get('availabilities/doctor/{doctorId}', [DoctorAvailabilityController::class, 'byDoctor'])->name('availabilities.byDoctor');
        Route::get('availabilities/date', [DoctorAvailabilityController::class, 'byDate'])->name('availabilities.byDate');
        Route::post('availabilities/{id}/toggle', [DoctorAvailabilityController::class, 'toggleAvailable'])->name('availabilities.toggle');

        // Appointments Management
        Route::get('appointments', [App\Http\Controllers\Admin\AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{id}', [App\Http\Controllers\Admin\AppointmentController::class, 'show'])->name('appointments.show');
        Route::post('appointments/{id}/cancel', [App\Http\Controllers\Admin\AppointmentController::class, 'cancel'])->name('appointments.cancel');
        Route::post('appointments/{id}/update-status', [App\Http\Controllers\Admin\AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
        Route::post('appointments/{id}/doctor-notes', [App\Http\Controllers\Admin\AppointmentController::class, 'addDoctorNotes'])->name('appointments.addDoctorNotes');

        // Cities Management (placeholder)
        Route::resource('cities', CityController::class);

        // Specialties Management (placeholder)
        Route::resource('specialties', SpecialtyController::class);
    });
});
