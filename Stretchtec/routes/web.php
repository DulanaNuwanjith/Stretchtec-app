<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('sampleDevelopment', function () {
    return view('sample-development.sampleDevelopment');
})->name('sampleDevelopment.index');

Route::get('productCatalog', function () {
    return view('production-catalog.productCatalog');
})->name('productCatalog.index');


