<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PropertyController as AdminPropertyController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ViewingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/create', [PropertyController::class, 'create'])->middleware('auth')->name('properties.create');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [\App\Http\Controllers\Auth\PasswordController::class, 'update'])->name('password.update');

    Route::get('/my-properties', [PropertyController::class, 'myIndex'])->name('my-properties.index');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/properties/{property}/favorite', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('/properties/{property}/favorite', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
    Route::post('/properties/{property}/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');

    Route::get('/viewings', [ViewingController::class, 'index'])->name('viewings.index');
    Route::post('/properties/{property}/viewings', [ViewingController::class, 'store'])->name('viewings.store');
    Route::patch('/viewings/{viewing}/status', [ViewingController::class, 'updateStatus'])->name('viewings.update-status');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/properties', [AdminPropertyController::class, 'index'])->name('properties.index');
    Route::patch('/properties/{property}/approve', [AdminPropertyController::class, 'approve'])->name('properties.approve');
    Route::patch('/properties/{property}/reject', [AdminPropertyController::class, 'reject'])->name('properties.reject');

    Route::resource('property-types', PropertyTypeController::class)
        ->except(['show'])
        ->parameters(['property-types' => 'property_type']);
});
