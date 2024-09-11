<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ContactController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::apiResource('contacts', ContactController::class);
});
