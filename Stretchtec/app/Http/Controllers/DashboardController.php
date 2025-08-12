<?php

namespace App\Http\Controllers;

use App\Models\LeftoverYarn;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationProduction;
use App\Models\SamplePreparationRnD;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $allSamplesReceived = SampleInquiry::all()->count();
        $allSamplesReceivedWithin30Days = SampleInquiry::where('created_at', '>=', now()->subDays(30))->count();

        $acceptedSamples = SampleInquiry::where('customerDecision', 'Order Received')->count();
        $acceptedSamplesWithin30Days = SampleInquiry::where('customerDecision', 'Order Received')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $rejectedSamples = SampleInquiry::where('customerDecision', 'Order Rejected')->count();
        $rejectedSamplesWithin30Days = SampleInquiry::where('customerDecision', 'Order Rejected')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $yetNotReceivedSamples = SampleInquiry::where('customerDecision', 'Order Not Received')->count();
        $yetNotReceivedSamplesWithin30Days = SampleInquiry::where('customerDecision', 'Order Not Received')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        // Get distinct Yarn Suppliers from Sample Preparation RnD table
        $yarnSuppliers = SamplePreparationRnD::distinct()
            ->pluck('yarnSupplier')
            ->toArray();

        // Get yarn ordered but not yet received for each supplier
        $yarnOrderedNotReceived = [];
        foreach ($yarnSuppliers as $supplier) {
            $orderedCount = SamplePreparationRnD::where('yarnSupplier', $supplier)
                ->whereNotNull('yarnOrderDate')
                ->whereNull('yarnReceiveDate')
                ->count();
            $yarnOrderedNotReceived[$supplier] = $orderedCount;
        }

        $totalLeftOverYarn = LeftoverYarn::sum('available_stock');
        $totalLeftOverYarn = number_format($totalLeftOverYarn, 0);

        $totalDamagedOutput = SamplePreparationProduction::sum('damaged_output');
        $totalDamagedOutput = number_format($totalDamagedOutput, 0);

        $prodOutput = SamplePreparationProduction::sum('production_output');
        $damageOutput = SamplePreparationProduction::sum('damaged_output');

        $totalProductionOutput = $prodOutput - $damageOutput;

        // Get distinct customer coordinators
        $coordinatorNames = User::where('role', 'CUSTOMERCOORDINATOR')
            ->distinct()
            ->pluck('name')
            ->toArray();

        // Initialize arrays to hold counts aligned with coordinatorNames
        $acceptedSamplesCount = [];
        $rejectedSamplesCount = [];

        foreach ($coordinatorNames as $coordinator) {
            $acceptedCount = SampleInquiry::where('coordinatorName', $coordinator)
                ->where('customerDecision', 'Order Received')
                ->count();
            $rejectedCount = SampleInquiry::where('coordinatorName', $coordinator)
                ->where('customerDecision', 'Order Rejected')
                ->count();

            $acceptedSamplesCount[] = $acceptedCount;
            $rejectedSamplesCount[] = $rejectedCount;
        }


        // Get distinct customer names from SampleInquiry table
        $customerNames = SampleInquiry::distinct()
            ->pluck('customerName')
            ->toArray();

        // Initialize arrays to hold counts aligned with customerNames
        $acceptedSamplesCount2 = [];
        $rejectedSamplesCount2 = [];

        foreach ($customerNames as $customer) {
            $acceptedCount2 = SampleInquiry::where('customerName', $customer)
                ->where('customerDecision', 'Order Received') // accepted condition
                ->count();

            $rejectedCount2 = SampleInquiry::where('customerName', $customer)
                ->where('customerDecision', 'Order Rejected') // rejected condition
                ->count();

            $acceptedSamplesCount2[] = $acceptedCount2;
            $rejectedSamplesCount2[] = $rejectedCount2;
        }


        return view('dashboard', compact(
            'allSamplesReceived',
            'allSamplesReceivedWithin30Days',
            'acceptedSamples',
            'acceptedSamplesWithin30Days',
            'rejectedSamples',
            'rejectedSamplesWithin30Days',
            'yetNotReceivedSamples',
            'yetNotReceivedSamplesWithin30Days',
            'totalLeftOverYarn',
            'totalDamagedOutput',
            'totalProductionOutput',
            'yarnSuppliers',
            'yarnOrderedNotReceived',
            'coordinatorNames',
            'acceptedSamplesCount',
            'rejectedSamplesCount',
            'customerNames',
            'acceptedSamplesCount2',
            'rejectedSamplesCount2'
        ));
    }
}
