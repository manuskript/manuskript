<?php

use Illuminate\Support\Facades\Route;
use Manuskript\Http\Controllers\DashboardController;
use Manuskript\Http\Controllers\ResourcesController;

Route::name('manuskript.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('{resource}', [ResourcesController::class, 'index'])->name('resources.index');
    Route::post('{resource}', [ResourcesController::class, 'store'])->name('resources.store');
    Route::get('{resource}/new', [ResourcesController::class, 'create'])->name('resources.create');
    Route::get('{resource}/{model}', [ResourcesController::class, 'show'])->name('resources.show');
    Route::get('{resource}/{model}/edit', [ResourcesController::class, 'edit'])->name('resources.edit');
    Route::patch('{resource}/{model}', [ResourcesController::class, 'update'])->name('resources.update');
});
