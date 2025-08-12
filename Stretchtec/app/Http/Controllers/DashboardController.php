<?php

namespace App\Http\Controllers;

use App\Models\SampleInquiry;
use App\Models\SamplePreparationRnD;
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
            'yarnOrderedButNotReceivedWithin30Days'
        ));
    }
}
