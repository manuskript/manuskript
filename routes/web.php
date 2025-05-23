<?php

use Illuminate\Support\Facades\Route;
use Manuskript\Http\Controller\EntriesController;

Route::name('manuskript.')->group(function () {
    Route::resource('resources/{resource}', EntriesController::class);
});
