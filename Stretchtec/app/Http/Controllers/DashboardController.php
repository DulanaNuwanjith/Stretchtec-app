<?php

namespace App\Http\Controllers;

use App\Models\SampleInquiry;
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

        $inProductionSamples = SampleInquiry::where('productionStatus', 'In Production')->count();
        $inProductionSamplesWithin30Days = SampleInquiry::where('productionStatus', 'In Production')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $productionCompleteSamples = SampleInquiry::where('productionStatus', 'Production Complete')->count();
        $productionCompleteSamplesWithin30Days = SampleInquiry::where('productionStatus', 'Production Complete')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $yarnOrderedButNotReceived = SamplePreparationRnD::whereNotNull('yarnOrderedDate')
            ->whereNull('yarnReceiveDate')
            ->get();
        $yarnOrderedButNotReceivedWithin30Days = SamplePreparationRnD::whereNotNull('yarnOrderedDate')
            ->whereNull('yarnReceiveDate')
            ->where('created_at', '>=', now()->subDays(30))
            ->get();


        // Get distinct customer coordinators
        $coordinatorNames = User::where('role', 'customer_coordinator')
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
            'inProductionSamples',
            'inProductionSamplesWithin30Days',
            'productionCompleteSamples',
            'productionCompleteSamplesWithin30Days',
            'yarnOrderedButNotReceived',
            'yarnOrderedButNotReceivedWithin30Days',
            'coordinatorNames',
            'acceptedSamplesCount',
            'rejectedSamplesCount',
            'customerNames',
            'acceptedSamplesCount2',
            'rejectedSamplesCount2'
        ));
    }
}
