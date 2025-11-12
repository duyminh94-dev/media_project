<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;

// === TRANG CHỦ ===
Route::get('/', function () {
    return view('welcome');
})->name('home');

// === AUTH ===
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// === DASHBOARD PHÂN QUYỀN THEO ROLE ===
Route::middleware(['auth'])->group(function() {

   Route::middleware(['role:patient'])->group(function () {
        //  Dashboard
        Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');

        //  Bác sĩ & Đặt lịch (Book/Create)
        Route::get('/patient/doctors', [PatientController::class, 'doctors'])->name('patient.doctors');

        // Tính năng đặt lịch tổng quát (lọc theo chuyên khoa)
        Route::get('/patient/book', [PatientController::class, 'showBookForm'])->name('patient.book');
        Route::post('/patient/book/store', [PatientController::class, 'storeBooking'])->name('patient.book.store'); // Dùng cho form lọc

        // Đặt lịch cụ thể với 1 bác sĩ
        Route::get('/patient/appointment/create/{doctor_id}', [PatientController::class, 'createAppointment'])->name('patient.appointment.create');
        Route::post('/patient/appointment/store', [PatientController::class, 'storeAppointment'])->name('patient.appointment.store');

        //  Lịch khám (Quản lý)
        Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
        Route::get('/patient/appointment/show/{id}', [PatientController::class, 'showAppointment'])->name('patient.appointment.show'); // Tính năng mới
        Route::post('/patient/appointment/cancel/{id}', [PatientController::class, 'cancelAppointment'])->name('patient.appointment.cancel'); // Tính năng mới

        //  Hồ sơ & Cài đặt
        Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile');
        Route::get('/patient/profile/edit', [PatientController::class, 'editProfile'])->name('patient.editProfile');
        Route::post('/patient/profile/update', [PatientController::class, 'updateProfile'])->name('patient.updateProfile');       
        Route::get('/patient/settings', [PatientController::class, 'settings'])->name('patient.settings');
        Route::post('/patient/settings/update-password', [PatientController::class, 'updatePassword'])->name('patient.updatePassword');
        Route::post('/patient/settings/update-notifications', [PatientController::class, 'updateNotifications'])->name('patient.updateNotifications');
       
    });
});
