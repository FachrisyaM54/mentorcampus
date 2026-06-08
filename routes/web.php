<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MentorScheduleController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\FaqController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/auth/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/home', function () {
    return view('dashboard.index'); 
})->name('home');

// --- STRUKTUR ROUTE PROFILE STUDENT (SUDAH DIPERBAIKI AGAR TIDAK NOT FOUND) ---
// Mengubah URL index dari '/profile/update' menjadi '/profile' agar serasi dengan form action
Route::get('/profile', [ProfileController::class, 'index'])
    ->name('profile.index');

Route::post('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::patch('/profile', [ProfileController::class, 'update'])
    ->name('profile.update');

Route::delete('/profile', [ProfileController::class, 'destroy'])
    ->name('profile.destroy');

// 💡 ROUTE BARU: Menghubungkan tombol hapus riwayat cancelled ke ProfileController@destroyCancelled
Route::delete('/profile/cancelled/{id}', [ProfileController::class, 'destroyCancelled'])
    ->name('profile.cancelled.destroy');
// -------------------------------------

Route::get('/booking/{schedule}', [BookingController::class, 'show'])
    ->name('booking.show');

Route::post('/booking/{schedule}', [BookingController::class, 'store'])
    ->name('booking.store');

Route::post('/booking/{id}/finish', [BookingController::class, 'finish'])
    ->name('booking.finish');

Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])
    ->name('booking.cancel');

Route::get(
    '/rating/{id}',
    [RatingController::class,'create']
)->name('rating.create');

Route::post(
    '/rating/{id}',
    [RatingController::class,'store']
)->name('rating.store');

Route::get('/faq', [FaqController::class, 'index'])
    ->name('faq');
    
Route::view('/about', 'about.index')->name('about');


//MENTORR
Route::get('/mentor-register', [MentorController::class, 'create'])
    ->name('mentor.register');

Route::post('/mentor-register', [MentorController::class, 'store'])
    ->name('mentor.store');

Route::get('/mentor-status', [MentorController::class, 'status'])
    ->name('mentor.status');

// --- BAGIAN JADWAL MENTOR YANG DISESUAIKAN & DILENGKAPI ---
Route::get('/mentor-schedule', [MentorScheduleController::class, 'index'])
    ->name('mentor.schedule');

Route::get('/mentor-schedule-create', [MentorScheduleController::class, 'create'])
    ->name('mentor.schedule.create');

Route::post('/mentor-schedule-store', [MentorScheduleController::class, 'store'])
    ->name('mentor.schedule.store');

Route::delete('/mentor-schedule-delete/{id}', [MentorScheduleController::class, 'destroy'])
    ->name('mentor.schedule.delete');
// -----------------------------------------------------------

Route::get(
    '/mentor-bookings',
    [MentorController::class, 'bookings']
)->name('mentor.bookings');

Route::get(
    '/mentor-history',
    [MentorController::class, 'history']
)->name('mentor.history');

Route::get(
    '/mentor-dashboard',
    [MentorController::class, 'dashboard']
)->name('mentor.dashboard');

// 💡 ROUTE BARU: Menyambungkan form submit dari dashboard mentor ke MentorController fungsi updateProfile
Route::post(
    '/mentor-dashboard/profile-update',
    [MentorController::class, 'updateProfile']
)->name('mentor.profile.update');

Route::get(
    '/mentor/{id}',
    [MentorController::class, 'show']
)->name('mentor.show');


//ADMIN middleware
Route::middleware(['auth','admin'])->group(function () {

    Route::get('/admin-dashboard',
        [AdminController::class,'dashboard']
    )->name('admin.dashboard');

    Route::get('/admin-mentor-requests',
        [AdminController::class,'mentorRequests']
    )->name('admin.mentor.requests');

    Route::post('/admin-mentor-requests/{id}/approve',
        [AdminController::class,'approveMentor']
    )->name('admin.mentor.approve');

    Route::post('/admin-mentor-requests/{id}/reject',
        [AdminController::class,'rejectMentor']
    )->name('admin.mentor.reject');

    Route::get('/admin-users', [AdminController::class, 'users'])
        ->name('admin.users');
    
    Route::get(
        '/admin-mentors',
        [AdminController::class, 'mentors']
    )->name('admin.mentors');

    Route::get(
        '/admin-mentors/{id}',
        [AdminController::class, 'mentorDetail']
    )->name('admin.mentors.detail');

    Route::delete(
        '/admin-mentors/{id}',
        [AdminController::class, 'deleteMentor']
    )->name('admin.mentors.delete');

    Route::get(
        '/admin-report-pdf',
        [AdminController::class, 'exportPdf']
    )->name('admin.report.pdf');

    Route::post('/admin-kampus-store', [AdminController::class, 'storeKampus'])->name('admin.kampus.store');
    Route::delete('/admin-kampus-delete/{id}', [AdminController::class, 'deleteKampus'])->name('admin.kampus.delete');

});

require __DIR__.'/auth.php';