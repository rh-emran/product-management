<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome'); // Ensure this view exists and is the entry point for your Vue app
})->where('any', '.*');
