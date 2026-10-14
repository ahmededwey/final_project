<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyOwnerDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobCategoryController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('admin')
        ->name('dashboard');

    Route::get('/company-owner/dashboard', [CompanyOwnerDashboardController::class, 'index'])
        ->middleware('role:company-owner')
        ->name('company-owner.dashboard');

    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin,company-owner')->group(function () {
        Route::resource('/company', CompanyController::class);
        Route::post('/company/{id}/restore', [CompanyController::class, 'restore'])->name('company.restore');
        Route::delete('/company/{id}/force-delete', [CompanyController::class, 'forceDelete'])->name('company.force-delete');

        Route::resource('/jobApplication', JobApplicationController::class)
            ->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::post('/jobApplication/{id}/restore', [JobApplicationController::class, 'restore'])->name('jobApplication.restore');
        Route::delete('/jobApplication/{id}/force-delete', [JobApplicationController::class, 'forceDelete'])->name('jobApplication.force-delete');
    });

    Route::middleware('admin')->group(function () {
        Route::resource('/category', JobCategoryController::class)
            ->names('jobCategory')
            ->parameters(['category' => 'jobCategory']);
        Route::post('/category/{id}/restore', [JobCategoryController::class, 'restore'])->name('jobCategory.restore');
        Route::delete('/category/{id}/force-delete', [JobCategoryController::class, 'forceDelete'])->name('jobCategory.force-delete');

        Route::resource('/user', UserController::class)
            ->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::post('/user/{id}/restore', [UserController::class, 'restore'])->name('user.restore');
        Route::delete('/user/{id}/force-delete', [UserController::class, 'forceDelete'])->name('user.force-delete');
    });

    Route::resource('/resume', ResumeController::class)->only(['index']);

    Route::resource('/jobVacancy', JobVacancyController::class);
    Route::post('/jobVacancy/{id}/restore', [JobVacancyController::class, 'restore'])->name('jobVacancy.restore');
    Route::delete('/jobVacancy/{id}/force-delete', [JobVacancyController::class, 'forceDelete'])->name('jobVacancy.force-delete');
});

require __DIR__.'/auth.php';
