<?php

use NickDeKruijk\LaravelVisitors\Visitors;

Route::middleware('web')->group(function () {
    Route::get(config('visitors.route_prefix'), [Visitors::class, 'xhr'])->name('laravel-visitors.post');
    Route::get(config('visitors.route_prefix') . '.png', [Visitors::class, 'pixel'])->name('laravel-visitors.pixel');
});
