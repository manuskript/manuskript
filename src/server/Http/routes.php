<?php

use Illuminate\Support\Facades\Route;
use Manuskript\Http\Controllers\ActionsController;
use Manuskript\Http\Controllers\Api\EntriesController as ApiEntriesController;
use Manuskript\Http\Controllers\EntriesController;
use Manuskript\Http\Controllers\FilesController;
use Manuskript\Http\Controllers\FileUploadController;
use Manuskript\Http\Controllers\HomeController;
use Manuskript\Http\Controllers\RelationsController;
use Manuskript\Http\Controllers\TrashedEntriesController;

Route::get('/', HomeController::class);

Route::get('files/{path?}', [FilesController::class, 'index'])->where('path', '.*')
    ->name('manuskript.filesystem');

Route::post('file-upload', FileUploadController::class)
    ->name('manuskript.file-upload');

Route::get('api/{resource}', [ApiEntriesController::class, 'index']);

Route::get('api/{resource}/{model}', [ApiEntriesController::class, 'show']);

Route::post('{resource}/actions/{action}', ActionsController::class);

Route::get('{resource}/relations/{method}', [RelationsController::class, 'index'])
    ->name('manuskript.relations.index');

Route::post('{resource}/relations/{method}', [RelationsController::class, 'store'])
    ->name('manuskript.relations.store');

Route::get('{resource}/relations/{method}/new', [RelationsController::class, 'create'])
    ->name('manuskript.relations.create');

Route::get('{resource}/relations/{method}/{id}', [RelationsController::class, 'show'])
    ->name('manuskript.relations.show');

Route::get('{resource}/trashed', [TrashedEntriesController::class, 'index'])
    ->name('manuskript.entries.trash.index');

Route::get('{resource}/trashed/{model}', [TrashedEntriesController::class, 'show'])
    ->name('manuskript.entries.trash.show');

Route::post('{resource}/trashed/restore', [TrashedEntriesController::class, 'restore']);

Route::post('{resource}/trashed/destroy', [TrashedEntriesController::class, 'destroy'])
    ->name('manuskript.entries.trash.destroy');

Route::get('{resource}', [EntriesController::class, 'index'])
    ->name('manuskript.entries.index');

Route::get('{resource}/new', [EntriesController::class, 'create'])
    ->name('manuskript.entries.create');

Route::post('{resource}/new', [EntriesController::class, 'store'])
    ->name('manuskript.entries.store');

Route::patch('{resource}/{model}', [EntriesController::class, 'update'])
    ->name('manuskript.entries.update');

Route::get('{resource}/{model}', [EntriesController::class, 'show'])
    ->name('manuskript.entries.show');

Route::get('{resource}/{model}/edit', [EntriesController::class, 'edit'])
    ->name('manuskript.entries.edit');

Route::delete('{resource}/{model}', [EntriesController::class, 'destroy'])
    ->name('manuskript.entries.destroy');
