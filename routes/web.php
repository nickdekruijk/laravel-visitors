<?php

use NickDeKruijk\LaravelVisitors\Controllers\VisitorController;

Route::middleware('web')->group(function () {
    Route::post(config('visitors.route_prefix'), [VisitorController::class, 'xhr'])->name('laravel-visitors.post');
});
