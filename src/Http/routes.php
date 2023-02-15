<?php

use Illuminate\Support\Facades\Route;
use Manuskript\Http\Controllers\ActionsController;
use Manuskript\Http\Controllers\EntriesController;
use Manuskript\Http\Controllers\FileUploadController;
use Manuskript\Http\Controllers\HomeController;
use Manuskript\Http\Controllers\RelationsController;
use Manuskript\Http\Controllers\TrashedEntriesController;

Route::middleware('manuskript')->prefix('manuskript')->group(function () {

    Route::get('/', HomeController::class);

    Route::post('file-upload', FileUploadController::class)
        ->name('manuskript.file-upload');

    Route::post('{resource}/actions/{action}', ActionsController::class);

    Route::get('{resource}/relations/{method}', [RelationsController::class, 'index'])
        ->name('manuskript.relations.index');

    Route::get('{resource}/trashed', [TrashedEntriesController::class, 'index'])
        ->name('manuskript.entries.trash.index');

    Route::get('{resource}/trashed/{model}', [TrashedEntriesController::class, 'show'])
        ->name('manuskript.entries.trash.show');

    Route::post('{resource}/trashed/restore', [TrashedEntriesController::class, 'restore']);

    Route::post('{resource}/trashed/destroy', [TrashedEntriesController::class, 'destroy']);

    Route::get('{resource}', [EntriesController::class, 'index'])
        ->name('manuskript.entries.index');

    Route::get('{resource}/new', [EntriesController::class, 'create'])
        ->name('manuskript.entries.create');

    Route::post('{resource}/new', [EntriesController::class, 'store'])
        ->name('manuskript.entries.store');

    Route::patch('{resource}/{model}', [EntriesController::class, 'update'])
        ->name('manuskript.entries.update');

    Route::get('{resource}/{model}/relations/{method}', [RelationsController::class, 'create'])
        ->name('manuskript.relations.index');

    Route::get('{resource}/{model}', [EntriesController::class, 'edit'])
        ->name('manuskript.entries.edit');
});
