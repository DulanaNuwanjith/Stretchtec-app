<?php

use App\Http\Controllers\LeftoverYarnController;
use App\Http\Controllers\OperatorsandSupervisorsController;
use App\Http\Controllers\SampleInquiryController;
use App\Http\Controllers\SamplePreparationRnDController;
use App\Http\Controllers\SamplePreparationProductionController;
use App\Http\Controllers\SampleStockController;
use App\Http\Controllers\UserMananagementController;
use Illuminate\Support\Facades\Auth;
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

    Route::resource('leftoverYarnManagement', 'App\Http\Controllers\LeftoverYarnController')->names([
        'index' => 'leftoverYarn.index',
        'store' => 'leftoverYarn.store',
        'update' => 'leftoverYarn.update',
        'destroy' => 'leftoverYarn.destroy',
    ]);
    Route::post('/leftover-yarn/borrow/{id}', [SamplePreparationRnDController::class, 'borrow'])->name('leftover-yarn.borrow');

    Route::resource('sampleStockManagement', 'App\Http\Controllers\SampleStockController')->names([
        'index' => 'sampleStock.index',
        'store' => 'sampleStock.store',
        'update' => 'sampleStock.update',
        'destroy' => 'sampleStock.destroy',
    ]);
    Route::post('/sample-stock/{id}/borrow', [SampleStockController::class, 'borrow'])->name('sampleStock.borrow');

    Route::get('productCatalog', function () {
        return view('production-catalog.productCatalog');
    })->name('productCatalog.index');

    Route::get('storeManagement', function () {
        return view('store-management.storeManagement');
    })->name('storeManagement.index');

    Route::get('reports', function () {
        return view('reports');
    })->name('reports.index');

    Route::get('codeCatalog', function () {
        return view('production-catalog.pages.codeCatalog');
    })->name('codeCatalog.index');

    Route::get('elasticCatalog', function () {
        return view('production-catalog.pages.elasticCatalog');
    })->name('elasticCatalog.index');

    Route::get('tapeCatalog', function () {
        return view('production-catalog.pages.tapeCatalog');
    })->name('tapeCatalog.index');
});


//SAMPLE INQUIRY ROUTES
Route::middleware(['auth'])->group(function () {
    // Allow only ADMIN, SUPERADMIN, CUSTOMERCOORDINATOR
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['ADMIN', 'SUPERADMIN', 'CUSTOMERCOORDINATOR'];
        if (!Auth::check() || !in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], function () {

        //Sample inquiry routes
        Route::resource('sampleInquiry', 'App\Http\Controllers\SampleInquiryController')->names([
            'index' => 'sample-inquery-details.index',
            'store' => 'sampleInquiry.store',
            'destroy' => 'sampleInquiry.destroy',
        ]);
        Route::post('/sampleInquiry/mark-sent-to-sample-dev', [SampleInquiryController::class, 'markSentToSampleDevelopment'])
            ->name('inquiry.markSentToSampleDev');
        Route::post('/sampleInquiry/mark-customer-delivered', [SampleInquiryController::class, 'markCustomerDelivered'])
            ->name('inquiry.markCustomerDelivered');
        Route::patch('/sample-inquery-details/{id}/update-decision', [SampleInquiryController::class, 'updateDecision'])
            ->name('sample-inquery-details.update-decision');
        Route::post('/inquiry/mark-delivered', [SampleInquiryController::class, 'markCustomerDelivered'])->name('inquiry.markCustomerDelivered');
    });
});

// SAMPLE PREPARATION R&D ROUTES
Route::middleware(['auth'])->group(function () {
    // Restrict access to admin, superadmin, and sampledeveloper
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['ADMIN', 'SUPERADMIN', 'SAMPLEDEVELOPER'];
        if (!Auth::check() || !in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], function () {

        Route::get('sample-preparation-details', [SamplePreparationRnDController::class, 'viewRnD'])
            ->name('sample-preparation-details.index');
        Route::post('/rnd/mark-colour-match-sent', [SamplePreparationRnDController::class, 'markColourMatchSent'])
            ->name('rnd.markColourMatchSent');
        Route::post('/rnd/mark-colour-match-receive', [SamplePreparationRnDController::class, 'markColourMatchReceive'])
            ->name('rnd.markColourMatchReceive');
        Route::post('/rnd/mark-yarn-ordered', [SamplePreparationRnDController::class, 'markYarnOrdered'])
            ->name('rnd.markYarnOrdered');
        Route::post('/rnd/mark-yarn-received', [SamplePreparationRnDController::class, 'markYarnReceived'])
            ->name('rnd.markYarnReceived');
        Route::post('/rnd/mark-send-to-production', [SamplePreparationRnDController::class, 'markSendToProduction'])
            ->name('rnd.markSendToProduction');
        Route::post('/rnd/set-develop-plan-date', [SamplePreparationRnDController::class, 'setDevelopPlanDate'])
            ->name('rnd.setDevelopPlanDate');
        Route::post('/rnd/lockPoField', [SamplePreparationRnDController::class, 'lockPoField'])
            ->name('rnd.lockPoField');
        Route::post('/rnd/lockShadeField', [SamplePreparationRnDController::class, 'lockShadeField'])
            ->name('rnd.lockShadeField');
        Route::post('/rnd/lockQtyField', [SamplePreparationRnDController::class, 'lockQtyField'])
            ->name('rnd.lockQtyField');
        Route::post('/rnd/lockTktField', [SamplePreparationRnDController::class, 'lockTktField'])
            ->name('rnd.lockTktField');
        Route::post('/rnd/lockSupplierField', [SamplePreparationRnDController::class, 'lockSupplierField'])
            ->name('rnd.lockSupplierField');
        Route::post('/rnd/lockDeadlineField', [SamplePreparationRnDController::class, 'lockDeadlineField'])
            ->name('rnd.lockDeadlineField');
        Route::post('/rnd/lockReferenceField', [SamplePreparationRnDController::class, 'lockReferenceField'])
            ->name('rnd.lockReferenceField');
        Route::post('/sample-preparation/update-developed', [SamplePreparationRnDController::class, 'updateDevelopedStatus'])
            ->name('rnd.updateDevelopedStatus');
        Route::post('/rnd/update-yarn-weights', [SamplePreparationRnDController::class, 'updateYarnWeights'])
            ->name('rnd.updateYarnWeights');
    });
});

// SAMPLE PREPARATION PRODUCTION ROUTES
Route::middleware(['auth'])->group(function () {
    // Restrict to production_officer, admin, superadmin
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['PRODUCTIONOFFICER', 'ADMIN', 'SUPERADMIN'];
        if (!Auth::check() || !in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], function () {

        Route::prefix('sample-production')->group(function () {
            Route::get('/', [SamplePreparationProductionController::class, 'index'])
                ->name('production.index');
            Route::post('/update', [SamplePreparationProductionController::class, 'update'])
                ->name('production.update');
            Route::post('/mark-start', [SamplePreparationProductionController::class, 'markOrderStart'])
                ->name('production.markStart');
            Route::post('/mark-complete', [SamplePreparationProductionController::class, 'markOrderComplete'])
                ->name('production.markComplete');
            Route::post('/dispatch-to-rnd', [SamplePreparationProductionController::class, 'dispatchToRnd'])
                ->name('production.dispatchToRnd');
            Route::post('/update-output', [SamplePreparationProductionController::class, 'updateOutput'])
                ->name('production.updateOutput');
            Route::post('/update-damagedOutput', [SamplePreparationProductionController::class, 'updateDamagedOutput'])
                ->name('production.updateDamagedOutput');
        });

        Route::get('/sample-preparation-production', [SamplePreparationProductionController::class, 'index'])
            ->name('sample-preparation-production.index');
    });
});

//OPERATORS AND SUPERVISORS ROUTES
Route::middleware(['auth'])->group(function () {
    // Restrict only to superadmin
    Route::group(['middleware' => function ($request, $next) {
        if (!Auth::check() || Auth::user()->role !== 'SUPERADMIN') {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], function () {

        // Operators and Supervisors routes
        Route::resource('operatorsandSupervisors', OperatorsandSupervisorsController::class)->names([
            'index' => 'operatorsandSupervisors.index',
            'store' => 'operatorsandSupervisors.store',
            'update' => 'operatorsandSupervisors.update',
            'destroy' => 'operatorsandSupervisors.destroy',
        ]);

        // User management routes
        Route::get('/userDetails', [UserMananagementController::class, 'index'])->name('userDetails.index');
        Route::delete('/userDetails/{id}', [UserMananagementController::class, 'destroy'])->name('userDetails.destroy');
    });
});
