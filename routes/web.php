<?php

use Illuminate\Support\Facades\Route;
use Manuskript\Http\Controllers\AssetsController;
use Manuskript\Http\Controllers\DashboardController;
use Manuskript\Http\Controllers\ResourcesController;

Route::name('manuskript.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('assets/{folder?}', [AssetsController::class, 'index'])->where('folder', '.*')->name('assets.index');

    Route::get('resources/{resource}', [ResourcesController::class, 'index'])->name('resources.index');
    Route::post('resources/{resource}', [ResourcesController::class, 'store'])->name('resources.store');
    Route::get('resources/{resource}/new', [ResourcesController::class, 'create'])->name('resources.create');
    Route::get('resources/{resource}/{model}', [ResourcesController::class, 'show'])->name('resources.show');
    Route::get('resources/{resource}/{model}/edit', [ResourcesController::class, 'edit'])->name('resources.edit');
    Route::patch('resources/{resource}/{model}', [ResourcesController::class, 'update'])->name('resources.update');
});
