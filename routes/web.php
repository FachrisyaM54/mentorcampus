<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/courses', [CourseController::class, 'index'])
    ->name('courses.index');

Route::get('/mentor-register', function () {
    return 'Mentor Register';
})->name('mentor.register');

Route::get('/mentor-schedule', function () {
    return 'Mentor Schedule';
})->name('mentor.schedule');

Route::get('/mentor-booking', function () {
    return 'Mentor Booking';
})->name('mentor.booking');

Route::get('/mentor-history', function () {
    return 'Mentor History';
})->name('mentor.history');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class,'index'])
        ->name('profile.index');

    //Route::get('/profile', [ProfileController::class, 'edit'])
     //   ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/booking/{schedule}', [BookingController::class, 'show'])
        ->name('booking.show');

    Route::post('/booking/{schedule}', [BookingController::class, 'store'])
        ->name('booking.store');

    Route::post('/booking/{id}/finish', [BookingController::class, 'finish'])
        ->name('booking.finish');

    Route::post('/booking/{id}/cancel', [BookingController::class, 'cancel'])
        ->name('booking.cancel');
});

require __DIR__.'/auth.php';