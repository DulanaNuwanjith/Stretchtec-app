<?php

/**
 * --------------------------------------------------------------------------
 * Web Routes File (web.php)
 * --------------------------------------------------------------------------
 * This file defines all the HTTP routes for the application.
 * It maps URLs to specific controllers, methods, or views.
 *
 * Routes are grouped logically with middleware restrictions to ensure
 * proper access control based on authentication and user roles.
 *
 * --------------------------------------------------------------------------
 * TABLE OF CONTENTS
 * --------------------------------------------------------------------------
 *  1. Authentication & Entry Point
 *  2. Authenticated User Routes
 *      2.1 Dashboard
 *      2.2 Product Catalog
 *      2.3 Sample Preparation (RnD & Production)
 *      2.4 Sample Inquiries
 *      2.5 Leftover Yarn Management
 *      2.6 Sample Stock Management
 *      2.7 Store Management
 *      2.8 Production Inquiry & Order Preparation Views
 *
 *  3. Module-Specific Routes with Role Restrictions
 *      3.1 Sample Inquiries (Admin / Superadmin / Coordinator)
 *      3.2 Sample Preparation R&D (Admin / Superadmin / SampleDeveloper)
 *      3.3 Sample Preparation Production (Admin / Superadmin / ProductionOfficer)
 *      3.4 Operators & Supervisors (Superadmin Only)
 *      3.5 Reports (Admin / Superadmin / Customer Coordinator)
 *
 * --------------------------------------------------------------------------
 * Storyline:
 * - Start with login and general routes.
 * - Then explore core modules (catalog, inquiries, yarn, stocks, stores).
 * - Afterwards, dive into module-specific role-restricted areas.
 * - Finish with reporting functionality for admin-level users.
 * --------------------------------------------------------------------------
 */

use App\Http\Controllers\ColorMatchRejectController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeftoverYarnController;
use App\Http\Controllers\OperatorsandSupervisorsController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\ProductInquiryController;
use App\Http\Controllers\ProductOrderPreperationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SampleInquiryController;
use App\Http\Controllers\SamplePreparationProductionController;
use App\Http\Controllers\SamplePreparationRnDController;
use App\Http\Controllers\SampleStockController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StoresController;
use App\Http\Controllers\TechnicalCardController;
use App\Http\Controllers\UserMananagementController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* ==========================================================================
 |  AUTHENTICATION & ENTRY POINT
 |==========================================================================*/

/**
 * Default route: redirect user to login view when visiting root URL.
 */
Route::get('/', static function () {
    return view('auth.login');
});


/* ==========================================================================
 |  AUTHENTICATED USER ROUTES
 |==========================================================================*/

/**
 * All routes within this group require:
 * - Sanctum authentication
 * - Jetstream session
 * - Verified user email
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /* ----------------------------------------------------------------------
     | Dashboard
     |----------------------------------------------------------------------
     | Displays key metrics and overview for logged-in users.
     */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    /* ----------------------------------------------------------------------
     | Product Catalog Routes
     |----------------------------------------------------------------------
     | Manage product catalog including elastic, tape, and code variations.
     */
    Route::patch('/product-catalog/{catalog}/update-shade', [ProductCatalogController::class, 'updateShade'])
        ->name('productCatalog.updateShade');

    Route::get('productCatalog', static function () {
        return view('production-catalog.productCatalog');
    })->name('productCatalog.index');

    Route::get('elasticCatalog', [ProductCatalogController::class, 'elasticCatalog'])->name('elasticCatalog.index');
    Route::get('tapeCatalog', [ProductCatalogController::class, 'tapeCatalog'])->name('tapeCatalog.index');
    Route::get('codeCatalog', [ProductCatalogController::class, 'codeCatalog'])->name('codeCatalog.index');

    // Resourceful routes for full catalog CRUD
    Route::resource('product-catalog', ProductCatalogController::class);

    // Specific POST routes for creating catalog entries
    Route::post('/product-catalog', [ProductCatalogController::class, 'store'])->name('product-catalog.store');
    Route::post('elasticCatalog/store', [ProductCatalogController::class, 'storeElastic'])->name('elasticCatalog.store');
    Route::post('codeCatalog/store', [ProductCatalogController::class, 'storeCode'])->name('codeCatalog.store');
    Route::post('tapeCatalog/store', [ProductCatalogController::class, 'storeTape'])->name('tapeCatalog.store');

    // Upload product images and approvals
    Route::post('catalog/{catalog}/upload-image', [ProductCatalogController::class, 'uploadOrderImage'])->name('catalog.uploadImage');
    Route::patch('product-catalog/{productCatalog}/approval', [ProductCatalogController::class, 'updateApproval'])->name('product-catalog.updateApproval');


    /* ----------------------------------------------------------------------
     | Sample Preparation (RnD & Production) Routes
     |----------------------------------------------------------------------
     */
    Route::get('sample-preparation-details', [SamplePreparationRnDController::class, 'viewRnD'])
        ->name('sample-preparation-details.index');

    Route::patch('/sample-preparation-production/update-operator/{id}', [SamplePreparationProductionController::class, 'updateOperator'])
        ->name('sample-preparation-production.update-operator');
    Route::patch('/sample-preparation-production/update-supervisor/{id}', [SamplePreparationProductionController::class, 'updateSupervisor'])
        ->name('sample-preparation-production.update-supervisor');


    /* ----------------------------------------------------------------------
     | Sample Inquiry Routes
     |----------------------------------------------------------------------
     | Manage inquiries from customers regarding sample development.
     */
    Route::patch('/sample-inquery-details/{id}/update-notes', [SampleInquiryController::class, 'updateNotes'])->name('sample-inquery-details.update-notes');

    Route::resource('sampleInquiry', SampleInquiryController::class)->names([
        'index' => 'sample-inquery-details.index',
        'store' => 'sampleInquiry.store',
        'destroy' => 'sampleInquiry.destroy',
    ]);

    Route::post('/sampleInquiry/mark-customer-delivered', [SampleInquiryController::class, 'markCustomerDelivered'])
        ->name('inquiry.markCustomerDelivered');
    Route::post('/inquiry/mark-delivered', [SampleInquiryController::class, 'markCustomerDelivered'])->name('inquiry.markCustomerDelivered');


    /* ----------------------------------------------------------------------
     | Leftover Yarn Management Routes
     |----------------------------------------------------------------------
     */
    Route::resource('leftoverYarnManagement', LeftoverYarnController::class)->names([
        'index' => 'leftoverYarn.index',
        'store' => 'leftoverYarn.store',
        'update' => 'leftoverYarn.update',
        'destroy' => 'leftoverYarn.destroy',
    ]);
    Route::post('/leftover-yarn/borrow/{id}', [SamplePreparationRnDController::class, 'borrow'])->name('leftover-yarn.borrow');


    /* ----------------------------------------------------------------------
     | Sample Stock Management Routes
     |----------------------------------------------------------------------
     */
    Route::resource('sampleStockManagement', SampleStockController::class)->names([
        'index' => 'sampleStock.index',
        'store' => 'sampleStock.store',
        'update' => 'sampleStock.update',
        'destroy' => 'sampleStock.destroy',
    ]);
    Route::post('/sample-stock/{id}/borrow', [SampleStockController::class, 'borrow'])->name('sampleStock.borrow');

    Route::resource('stockManagement', StockController::class)->names([
        'index' => 'stockManagement.index',
        'store' => 'stockManagement.store',
        'destroy' => 'stockManagement.destroy'
    ]);

    Route::get('stockAvailabilityCheck', [StockController::class, 'storeManageIndex'])->name('stockAvailabilityCheck.index');

    /* ----------------------------------------------------------------------
     | Mail Booking Management Routes
     |----------------------------------------------------------------------
     */
    Route::get('mail-booking', static function () {
        return view('production.pages.mail-booking');
    })->name('mail-booking.index');

    Route::get('mail-booking-approval', static function () {
        return view('production.pages.mail-booking-approval');
    })->name('mail-booking-approval.index');

    /* ----------------------------------------------------------------------
     | Packing Management Routes
     |----------------------------------------------------------------------
     */
     Route::get('packing', static function () {
        return view('production.pages.packing');
    })->name('packing.index');

    /* ----------------------------------------------------------------------
     | Production Inquiry & Order Preparation Views
     |----------------------------------------------------------------------
     */
    Route::resource('production-inquery', ProductInquiryController::class)->names([
        'index' => 'production-inquery-details.index',
        'store' => 'production-inquery-details.store',
        'destroy' => 'production-inquery-details.destroy',
    ]);

    Route::resource('production-order-preparation', ProductOrderPreperationController::class)->names([
        'index' => 'production-order-preparation.index',
    ]);
    Route::get('/product-catalog/{id}/details', [ProductInquiryController::class, 'getSampleDetails'])
        ->name('product-catalog.details');

    Route::post('/production-orders/{id}/send-to-store', [ProductInquiryController::class, 'sendToStore'])->name('production.sendToStore');

    Route::patch('production-inquiry/{id}/send-to-production', [ProductInquiryController::class, 'sendToProduction'])->name('production-inquiry.sendToProduction');

    Route::post('/stores/{id}/assign', [StoresController::class, 'assign'])->name('stores.assign');

    Route::get('/stock/add/{id}', [StockController::class, 'addStock'])->name('stockManagement.addStock');

    Route::get('knitted', static function () {
        return view('production.pages.knitted');
    })->name('knitted.index');

    Route::get('loom', static function () {
        return view('production.pages.loom');
    })->name('loom.index');

    Route::get('braiding', static function () {
        return view('production.pages.braiding');
    })->name('braiding.index');

    //Technical Details Routes
    Route::get('/elasticTD', [TechnicalCardController::class, 'elasticIndex'])->name('elasticTD.index');
    Route::get('/tapeTD', [TechnicalCardController::class, 'tapeIndex'])->name('tapeTD.index');
    Route::get('/cordTD', [TechnicalCardController::class, 'cordIndex'])->name('cordTD.index');
    Route::post('/elasticTD/create', [TechnicalCardController::class, 'createElastic'])->name('elasticTD.create');
    Route::post('/cordTD/create', [TechnicalCardController::class, 'createCord'])->name('cordTD.create');
    Route::post('/tapeTD/create', [TechnicalCardController::class, 'createTape'])->name('tapeTD.create');
    Route::delete('/technical-card/{technicalCard}', [TechnicalCardController::class, 'destroy'])->name('technicalCards.delete');
    Route::post('/technical-card/{technicalCard}/store-image', [TechnicalCardController::class, 'storeImage'])
        ->name('technicalCards.storeImage');
});


/* ==========================================================================
 |  MODULE-SPECIFIC ROUTES WITH ROLE RESTRICTIONS
 |==========================================================================*/

/**
 * SAMPLE INQUIRY ROUTES - Restricted to ADMIN, SUPERADMIN, CUSTOMERCOORDINATOR
 */
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['ADMIN', 'SUPERADMIN', 'CUSTOMERCOORDINATOR'];
        if (!Auth::check() || !in_array(Auth::user()?->role ?? '', $allowedRoles, true)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], static function () {
        Route::post('/sampleInquiry/mark-sent-to-sample-dev', [SampleInquiryController::class, 'markSentToSampleDevelopment'])
            ->name('inquiry.markSentToSampleDev');
        Route::patch('/sample-inquery-details/{id}/update-decision', [SampleInquiryController::class, 'updateDecision'])
            ->name('sample-inquery-details.update-decision');
        Route::post('/sample-inquiry/{id}/upload-order-file', [SampleInquiryController::class, 'uploadOrderFile'])->name('sampleInquiry.uploadOrderFile');
        Route::post('/report/sample-inquiry', [ReportController::class, 'generateSampleInquiryReport'])->name('report.sampleInquiryReport');
    });
});


/**
 * SAMPLE PREPARATION R&D ROUTES - Restricted to ADMIN, SUPERADMIN, SAMPLEDEVELOPER
 */
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['ADMIN', 'SUPERADMIN', 'SAMPLEDEVELOPER'];
        if (!Auth::check() || !in_array(Auth::user()?->role ?? '', $allowedRoles, true)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], static function () {

        // Colour matching & yarn management
        Route::post('/rnd/mark-colour-match-sent', [SamplePreparationRnDController::class, 'markColourMatchSent'])
            ->name('rnd.markColourMatchSent');
        Route::post('/rnd/mark-colour-match-receive', [SamplePreparationRnDController::class, 'markColourMatchReceive'])
            ->name('rnd.markColourMatchReceive');
        Route::post('/rnd/mark-yarn-ordered', [SamplePreparationRnDController::class, 'markYarnOrdered'])
            ->name('rnd.markYarnOrdered');
        Route::post('/rnd/mark-yarn-received', [SamplePreparationRnDController::class, 'markYarnReceived'])
            ->name('rnd.markYarnReceived');

        // Workflow progression
        Route::post('/rnd/mark-send-to-production', [SamplePreparationRnDController::class, 'markSendToProduction'])
            ->name('rnd.markSendToProduction');
        Route::post('/rnd/set-develop-plan-date', [SamplePreparationRnDController::class, 'setDevelopPlanDate'])
            ->name('rnd.setDevelopPlanDate');

        // Field locking (ensure values can’t be modified further)
        Route::post('/rnd/lockPoField', [SamplePreparationRnDController::class, 'lockPoField'])->name('rnd.lockPoField');
        Route::post('/rnd/lockShadeField', [SamplePreparationRnDController::class, 'lockShadeField'])->name('rnd.lockShadeField');
        Route::post('/rnd/lockQtyField', [SamplePreparationRnDController::class, 'lockQtyField'])->name('rnd.lockQtyField');
        Route::post('/rnd/lockTktField', [SamplePreparationRnDController::class, 'lockTktField'])->name('rnd.lockTktField');
        Route::post('/rnd/lockSupplierField', [SamplePreparationRnDController::class, 'lockSupplierField'])->name('rnd.lockSupplierField');
        Route::post('/rnd/lockDeadlineField', [SamplePreparationRnDController::class, 'lockDeadlineField'])->name('rnd.lockDeadlineField');
        Route::post('/rnd/lockReferenceField', [SamplePreparationRnDController::class, 'lockReferenceField'])->name('rnd.lockReferenceField');

        // Development status & yarn weight updates
        Route::post('/sample-preparation/update-developed', [SamplePreparationRnDController::class, 'updateDevelopedStatus'])
            ->name('rnd.updateDevelopedStatus');
        Route::post('/rnd/update-yarn-weights', [SamplePreparationRnDController::class, 'updateYarnWeights'])
            ->name('rnd.updateYarnWeights');

        // Color match rejects
        Route::post('/color-match-rejects/store', [ColorMatchRejectController::class, 'store'])->name('colorMatchRejects.store');
        Route::get('/color-match-reject/{id}', [ColorMatchRejectController::class, 'getRejectDetails']);

        Route::post('/report/rnd', [ReportController::class, 'generateRndReport'])->name('report.rndReport');
    });
});


/**
 * SAMPLE PREPARATION PRODUCTION ROUTES - Restricted to PRODUCTIONOFFICER, ADMIN, SUPERADMIN
 */
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['PRODUCTIONOFFICER', 'ADMIN', 'SUPERADMIN'];
        if (!Auth::check() || !in_array(Auth::user()?->role ?? '', $allowedRoles, true)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], static function () {

        // Grouped under prefix 'sample-production'
        Route::prefix('sample-production')->group(function () {
            Route::get('/', [SamplePreparationProductionController::class, 'index'])->name('production.index');
            Route::post('/update', [SamplePreparationProductionController::class, 'update'])->name('production.update');
            Route::post('/mark-start', [SamplePreparationProductionController::class, 'markOrderStart'])->name('production.markStart');
            Route::post('/mark-complete', [SamplePreparationProductionController::class, 'markOrderComplete'])->name('production.markComplete');
            Route::post('/dispatch-to-rnd', [SamplePreparationProductionController::class, 'dispatchToRnd'])->name('production.dispatchToRnd');
        });

        // Alternative index route (outside prefix)
        Route::get('/sample-preparation-production', [SamplePreparationProductionController::class, 'index'])
            ->name('sample-preparation-production.index');
    });
});


/**
 * OPERATORS & SUPERVISORS ROUTES - Restricted to SUPERADMIN only
 */
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {

        /** @var User $user */
        $user = Auth::user();

        if (!$user || $user->role !== 'SUPERADMIN') {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }], static function () {

        // Operators and Supervisors Management
        Route::resource('operatorsandSupervisors', OperatorsandSupervisorsController::class)->names([
            'index' => 'operatorsandSupervisors.index',
            'store' => 'operatorsandSupervisors.store',
            'update' => 'operatorsandSupervisors.update',
            'destroy' => 'operatorsandSupervisors.destroy',
        ]);

        // User Management
        Route::get('/userDetails', [UserMananagementController::class, 'index'])->name('userDetails.index');
        Route::delete('/userDetails/{id}', [UserMananagementController::class, 'destroy'])->name('userDetails.destroy');
    });
});


/**
 * REPORTS ROUTES - Restricted to ADMIN and SUPERADMIN and CUSTOMERCOORDINATOR
 */
Route::middleware(['auth'])->group(function () {
    Route::group(['middleware' => function ($request, $next) {
        $allowedRoles = ['ADMIN', 'SUPERADMIN', 'CUSTOMERCOORDINATOR'];
        if (!Auth::check() || !in_array(Auth::user()?->role ?? '', $allowedRoles, true)) {
            abort(403, 'Unauthorized access.');
        }
        return $next($request);
    }], static function () {

        // General and specific reports
        Route::get('/reports/sample-reports', [ReportController::class, 'showReportPage'])->name('sample-reports.index');
        Route::get('/reports/customer-decision', [ReportController::class, 'inquiryCustomerDecisionReport'])->name('reports.customerDecision');
        Route::get('/report/order', [ReportController::class, 'generateOrderReport'])->name('report.order');
        Route::get('/report/inquiry-range', [ReportController::class, 'inquiryRangeReport'])->name('report.inquiryRange');

        // Views for production-related reports
        Route::get('/reports/production-reports', static function () {
            return view('reports.production-reports');
        })->name('production-reports.index');

        // Yarn supplier spending and coordinator reports
        Route::get('/reports/yarn-supplier-spending', [ReportController::class, 'yarnSupplierSpendingReport'])->name('reports.yarnSupplierSpending');
        Route::get('/reports/coordinator/pdf', [ReportController::class, 'coordinatorReportPdf'])->name('reports.coordinatorPdf');
        Route::get('/reports/reference-delivery', [ReportController::class, 'referenceDeliveryReport'])->name('reports.reference_delivery');

        Route::get('/reports/reject-report', [ReportController::class, 'generateRejectReportPdf'])
            ->name('reports.rejectReportPdf');
        Route::get('/reports/customer-reject-pdf', [ReportController::class, 'generateCustomerRejectReportPdf'])
            ->name('reports.customerRejectReportPdf');

    });
});

