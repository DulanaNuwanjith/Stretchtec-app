<?php

use App\Http\Controllers\SampleInquiryController;
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

    //Sample inquiry routes
    Route::resource('sampleInquiry', 'App\Http\Controllers\SampleInquiryController')->names([
        'index' => 'sample-inquery-details.index',
        'store' => 'sampleInquiry.store',
    ]);
    Route::post('/sampleInquiry/update-developed-status', [SampleInquiryController::class, 'updateDevelopedStatus'])->name('inquiry.updateDevelopedStatus');

});

Route::get('productCatalog', function () {
    return view('production-catalog.productCatalog');
})->name('productCatalog.index');

Route::get('storeManagement', function () {
    return view('store-management.storeManagement');
})->name('storeManagement.index');

Route::get('reports', function () {
    return view('reports');
})->name('reports.index');

Route::get('sampleStockManagement', function () {
    return view('sample-development.sample-stock-management');
})->name('sampleStockManagement.index');

//Route::get('sample-inquery-details', function () {
//    return view('sample-development.pages.sample-inquery-details');
//})->name('sample-inquery-details.index');

Route::get('sample-preparation-details', function () {
    return view('sample-development.pages.sample-preparation-details');
})->name('sample-preparation-details.index');

Route::get('sample-preparation-production', function () {
    return view('sample-development.pages.sample-preparation-production');
})->name('sample-preparation-production.index');

Route::get('codeCatalog', function () {
    return view('production-catalog.pages.codeCatalog');
})->name('codeCatalog.index');

Route::get('elasticCatalog', function () {
    return view('production-catalog.pages.elasticCatalog');
})->name('elasticCatalog.index');

Route::get('tapeCatalog', function () {
    return view('production-catalog.pages.tapeCatalog');
})->name('tapeCatalog.index');

Route::get('production-inquery-details', function () {
    return view('production.pages.production-inquery-details');
})->name('production-inquery-details.index');

Route::get('production-order-preparation', function () {
    return view('production.pages.production-order-preparation');
})->name('production-order-preparation.index');

Route::get('userDetails', function () {
    return view('user-management.pages.userDetails');
})->name('userDetails.index');

Route::get('addResponsiblePerson', function () {
    return view('user-management.pages.addResponsiblePerson');
})->name('addResponsiblePerson.index');

