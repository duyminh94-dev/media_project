<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\ResetPasswordController;
use App\Http\Auth\AuthController;
use App\Http\Users\PatientController;
use Illuminate\Support\Facades\Route;

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

        // Appointments Management (placeholder)
        Route::get('appointments', function () {
            return 'Appointments Management - Coming Soon';
        })->name('appointments.index');

        // Cities Management (placeholder)
        Route::get('cities', function () {
            return 'Cities Management - Coming Soon';
        })->name('cities.index');

        // Specialties Management (placeholder)
        Route::get('specialties', function () {
            return 'Specialties Management - Coming Soon';
        })->name('specialties.index');
    });
});
