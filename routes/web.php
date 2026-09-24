<?php

use App\Http\Controllers\API\TaskAPIController;
use App\Http\Controllers\API\UserAPIController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('AdminWelcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('AdminDashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/tasks', [TaskController::class, 'index'])->name('task.index');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('task.create');
    Route::post('/tasks/store', [TaskController::class, 'store'])->name('task.store');
    Route::get('/tasks/edit/{task}', [TaskController::class, 'edit'])->name('task.edit');
    Route::put('/tasks/update/{task}', [TaskController::class, 'update'])->name('task.update');
    

    // for API
    Route::prefix('api')->group(function () {
        Route::get('/tasks', [TaskAPIController::class, 'index'])->name('api.task.index');

        Route::delete('/tasks/delete/{task}', [TaskAPIController::class, 'destroy'])->name('api.task.destroy');
    });
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // User
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('admin.users.store');
    Route::get('/users/edit/{userId}', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/update/{userId}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/delete/{userId}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::prefix('api')->group(function () {
        Route::get('/users', [UserAPIController::class, 'index'])->name('api.users.index');

        Route::delete('/users/delete/{userId}', [UserAPIController::class, 'destroy'])->name('api.users.destroy');
    });
});



require __DIR__ . '/auth.php';
