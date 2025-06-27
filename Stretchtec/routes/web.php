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

Route::get('production', function () {
    return view('production.production');
})->name('production.index');

Route::get('storeManagement', function () {
    return view('store-management.storeManagement');
})->name('storeManagement.index');

Route::get('reports', function () {
    return view('reports');
})->name('reports.index');

Route::get('sampleStockManagement', function () {
    return view('sample-development.sample-stock-management');
})->name('sampleStockManagement.index');
