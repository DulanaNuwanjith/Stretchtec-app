<?php

namespace App\Http\Controllers;

use App\Models\LeftoverYarn;
use App\Models\SampleInquiry;
use App\Models\SamplePreparationProduction;
use App\Models\SamplePreparationRnD;
use App\Models\User;
use Carbon\Carbon;

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

        $yetNotReceivedSamples = SampleInquiry::whereIn('customerDecision', ['Order Not Received', 'Pending'])->count();

        $yetNotReceivedSamplesWithin30Days = SampleInquiry::whereIn('customerDecision', ['Order Not Received', 'Pending'])
            ->where('created_at', '>=', now()->subDays(30))
            ->count();


        // Get distinct Yarn Suppliers from Sample Preparation RnD table
        $yarnSuppliers = SamplePreparationRnD::distinct()
            ->pluck('yarnSupplier')
            ->toArray();

        // Define only the suppliers you want
        $selectedSuppliers = ['Pan Asia', 'Ocean Lanka', 'A and E', 'Metro Lanka'];

        // Get yarn ordered but not yet received for each selected supplier
        $yarnOrderedNotReceived = [];
        foreach ($selectedSuppliers as $supplier) {
            $orderedCount = SamplePreparationRnD::where('yarnSupplier', $supplier)
                ->whereNotNull('yarnOrderedDate')
                ->whereNull('yarnReceiveDate')
                ->count();

            $yarnOrderedNotReceived[$supplier] = $orderedCount;
        }

        // Sum of available_stock from LeftoverYarn for last 60 days
        $totalLeftOverYarn = LeftoverYarn::where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('available_stock');
        $totalLeftOverYarn = number_format($totalLeftOverYarn, 0);

        // Sum of damaged_output from SamplePreparationProduction for last 60 days
        $totalDamagedOutput = SamplePreparationProduction::where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('damaged_output');
        $totalDamagedOutput = number_format($totalDamagedOutput, 0);

        // Sum of production_output and damaged_output for last 60 days
        $prodOutput = SamplePreparationProduction::where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('production_output');

        $damageOutput = SamplePreparationProduction::where('created_at', '>=', Carbon::now()->subDays(30))
            ->sum('damaged_output');

        $totalProductionOutput = $prodOutput - $damageOutput;
        $totalProductionOutput = number_format($totalProductionOutput, 0);

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
