<?php

use App\Helper;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::prefix(Helper::parseLocale())->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/courses', [PageController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}', [PageController::class, 'course'])->name('courses.show');
    Route::get('/employees', [PageController::class, 'employees'])->name('employees');
    Route::get('/employees/{employee}', [PageController::class, 'employee'])->name('employees.show');
    Route::get('/camp', [PageController::class, 'camp'])->name('camp');
    Route::get('/services', [PageController::class, 'services'])->name('services');
    Route::get('/galleries', [PageController::class, 'galleries'])->name('galleries');
    Route::get('/galleries/{gallery}', [PageController::class, 'gallery'])->name('galleries.show');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
});
