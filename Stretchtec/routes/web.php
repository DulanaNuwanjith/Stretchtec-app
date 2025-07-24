<?php

use App\Http\Controllers\SampleInquiryController;
use App\Http\Controllers\SamplePreparationRnDController;
use App\Http\Controllers\SamplePreparationProductionController;
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

    Route::patch('/sample-preparation-production/update-operator/{id}', [SamplePreparationProductionController::class, 'updateOperator'])
        ->name('sample-preparation-production.update-operator');

    Route::patch('/sample-preparation-production/update-supervisor/{id}', [SamplePreparationProductionController::class, 'updateSupervisor'])
        ->name('sample-preparation-production.update-supervisor');

    Route::patch('/sample-inquery-details/{id}/update-notes', [SampleInquiryController::class, 'updateNotes'])->name('sample-inquery-details.update-notes');

    //Sample inquiry routes
    Route::resource('sampleInquiry', 'App\Http\Controllers\SampleInquiryController')->names([
        'index' => 'sample-inquery-details.index',
        'store' => 'sampleInquiry.store',
        'destroy' => 'sampleInquiry.destroy',
    ]);
    // Route::post('/sampleInquiry/update-developed-status', [SampleInquiryController::class, 'updateDevelopedStatus'])->name('inquiry.updateDevelopedStatus');
    Route::post('/sampleInquiry/mark-sent-to-sample-dev', [SampleInquiryController::class, 'markSentToSampleDevelopment'])
        ->name('inquiry.markSentToSampleDev');
    Route::post('/sampleInquiry/mark-customer-delivered', [SampleInquiryController::class, 'markCustomerDelivered'])
        ->name('inquiry.markCustomerDelivered');
    Route::patch('/sample-inquery-details/{id}/update-decision', [SampleInquiryController::class, 'updateDecision'])
        ->name('sample-inquery-details.update-decision');

    //Operators and Supervisors routes
    Route::resource('operatorsandSupervisors', 'App\Http\Controllers\OperatorsandSupervisorsController')->names([
        'index' => 'operatorsandSupervisors.index',
        'store' => 'operatorsandSupervisors.store',
        'update' => 'operatorsandSupervisors.update',
        'destroy' => 'operatorsandSupervisors.destroy',
    ]);
    Route::get('/userDetails', [\App\Http\Controllers\UserMananagementController::class, 'index'])->name('userDetails.index');
    Route::delete('/userDetails/{id}', [\App\Http\Controllers\UserMananagementController::class, 'destroy'])->name('userDetails.destroy');

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

Route::get('leftoverYarnManagement', function () {
    return view('sample-development.leftover-yarn-details');
})->name('leftoverYarnManagement.index');

// Route::get('sample-preparation-details', function () {
//     return view('sample-development.pages.sample-preparation-details');
// })->name('sample-preparation-details.index');

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

Route::get('sample-preparation-details', [SamplePreparationRnDController::class, 'viewRnD'])->name('sample-preparation-details.index');

Route::post('/rnd/mark-colour-match-sent', [SamplePreparationRnDController::class, 'markColourMatchSent'])->name('rnd.markColourMatchSent');

Route::post('/rnd/mark-colour-match-receive', [SamplePreparationRnDController::class, 'markColourMatchReceive'])->name('rnd.markColourMatchReceive');

Route::post('/rnd/mark-yarn-ordered', [SamplePreparationRnDController::class, 'markYarnOrdered'])->name('rnd.markYarnOrdered');

Route::post('/rnd/mark-yarn-received', [SamplePreparationRnDController::class, 'markYarnReceived'])->name('rnd.markYarnReceived');

Route::post('/rnd/mark-send-to-production', [SamplePreparationRnDController::class, 'markSendToProduction'])->name('rnd.markSendToProduction');

Route::post('/rnd/set-develop-plan-date', [SamplePreparationRnDController::class, 'setDevelopPlanDate'])->name('rnd.setDevelopPlanDate');
Route::post('/rnd/lockPoField', [SamplePreparationRnDController::class, 'lockPoField'])->name('rnd.lockPoField');
Route::post('/rnd/lockShadeField', [SamplePreparationRnDController::class, 'lockShadeField'])->name('rnd.lockShadeField');
Route::post('/rnd/lockQtyField', [SamplePreparationRnDController::class, 'lockQtyField'])->name('rnd.lockQtyField');
Route::post('/rnd/lockTktField', [SamplePreparationRnDController::class, 'lockTktField'])->name('rnd.lockTktField');
Route::post('/rnd/lockSupplierField', [SamplePreparationRnDController::class, 'lockSupplierField'])->name('rnd.lockSupplierField');
Route::post('/rnd/lockDeadlineField', [SamplePreparationRnDController::class, 'lockDeadlineField'])->name('rnd.lockDeadlineField');
Route::post('/rnd/lockReferenceField', [SamplePreparationRnDController::class, 'lockReferenceField'])->name('rnd.lockReferenceField');
Route::post('/sample-preparation/update-developed', [SamplePreparationRnDController::class, 'updateDevelopedStatus'])->name('rnd.updateDevelopedStatus');
Route::post('/rnd/update-yarn-weights', [SamplePreparationRnDController::class, 'updateYarnWeights'])->name('rnd.updateYarnWeights');


Route::prefix('sample-production')->group(function () {
    Route::get('/', [SamplePreparationProductionController::class, 'index'])->name('production.index');
    Route::post('/update', [SamplePreparationProductionController::class, 'update'])->name('production.update');
    Route::post('/mark-start', [SamplePreparationProductionController::class, 'markOrderStart'])->name('production.markStart');
    Route::post('/mark-complete', [SamplePreparationProductionController::class, 'markOrderComplete'])->name('production.markComplete');
    Route::post('/dispatch-to-rnd', [SamplePreparationProductionController::class, 'dispatchToRnd'])->name('production.dispatchToRnd');
    Route::post('/update-output', [SamplePreparationProductionController::class, 'updateOutput'])->name('production.updateOutput');
    Route::post('/update-damagedOutput', [SamplePreparationProductionController::class, 'updateDamagedOutput'])->name('production.updateDamagedOutput');
});

Route::get('/sample-preparation-production', [SamplePreparationProductionController::class, 'index'])
    ->name('sample-preparation-production.index');
