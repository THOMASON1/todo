<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'index'])->name('tasks');
    Route::post('/tasks/store', [App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{id}', [App\Http\Controllers\TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('/calendar/add', [App\Http\Controllers\TaskController::class, 'addToCalendar'])->name('calendar.add');

    Route::get('/tasks/data', [App\Http\Controllers\TaskController::class, 'getTasksData'])->name('tasks.data');
    Route::get('/generate-public-link/{userId}', [App\Http\Controllers\TaskController::class, 'generatePublicLink'])->name('tasks.token');
});

Route::get('/tasks/public/{token}', [App\Http\Controllers\TaskController::class, 'showPublicTasks'])->name('tasks.public');