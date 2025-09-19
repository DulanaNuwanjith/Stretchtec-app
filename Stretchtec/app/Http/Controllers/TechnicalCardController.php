<?php

namespace App\Http\Controllers;

use App\Models\TechnicalCard;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class TechnicalCardController extends Controller
{
    public function elasticIndex(): Factory|View
    {
        $technicalCardElastics = TechnicalCard::where('type', 'Elastic')->get();
        return view('technical-details.pages.elasticTD', compact('technicalCardElastics'));
    }

    public function tapeIndex(): Factory|View
    {
        $technicalCardTapes = TechnicalCard::where('type', 'Tape')->get();
        return view('technical-details.pages.tapeTD', compact('technicalCardTapes'));
    }

    public function cordIndex(): Factory|View
    {
        $technicalCardCords = TechnicalCard::where('type', 'Cord')->get();
        return view('technical-details.pages.cordTD', compact('technicalCardCords'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createElastic(Request $request): ?RedirectResponse
    {
        $validated = $request->validate([
            'reference_number' => 'required|string|max:255|unique:technical_cards,reference_number',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'yarn_count' => 'nullable|string|max:100',
            'rubber_type' => 'nullable|string|max:100',
            'spindles' => 'nullable|string|min:0',
            'machine' => 'nullable|string|max:100',
            'wheel_up' => 'nullable|string|max:100',
            'wheel_down' => 'nullable|string|max:100',
            'needles' => 'nullable|string|min:0',
            'stretchability' => 'nullable|string|max:100',
            'weight_per_yard' => 'nullable|numeric|min:0',
            'url' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048', // 🔹 2MB max
            'special_remarks' => 'nullable|string|max:500',
        ]);

        try {
            // 🔹 Handle file upload
            if ($request->hasFile('url')) {
                $file = $request->file('url');
                $path = $file->store('technical_cards', 'public'); // saves to storage/app/public/technicalCards
                $validated['url'] = Storage::url($path); // /storage/technicalCards/filename.ext
            }

            $validated['type'] = 'Elastic';
            TechnicalCard::create($validated);

            return redirect()->back()->with('success', 'Technical card added successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to save technical card. Please try again.');
        }
    }

    public function createCord(Request $request): ?RedirectResponse
    {
        $validated = $request->validate([
            'reference_number' => 'required|string|max:255|unique:technical_cards,reference_number',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'yarn_count' => 'nullable|string|max:100',
            'rubber_type' => 'nullable|string|max:100',
            'spindles' => 'nullable|string|min:0',
            'weft_yarn' => 'nullable|string|max:100',
            'warp_yarn' => 'nullable|string|max:100',
            'reed' => 'nullable|string|max:100',
            'machine' => 'nullable|string|max:100',
            'wheel_up' => 'nullable|string|max:100',
            'wheel_down' => 'nullable|string|max:100',
            'needles' => 'nullable|integer|min:0',
            'stretchability' => 'nullable|string|max:100',
            'weight_per_yard' => 'nullable|numeric|min:0',
            'url' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048', // 🔹 2MB max
            'special_remarks' => 'nullable|string|max:500',
        ]);

        try {
            // 🔹 Handle file upload
            if ($request->hasFile('url')) {
                $file = $request->file('url');
                $path = $file->store('technical_cards', 'public'); // saves to storage/app/public/technicalCards
                $validated['url'] = Storage::url($path); // /storage/technicalCards/filename.ext
            }

            $validated['type'] = 'Cord';
            TechnicalCard::create($validated);

            // 🔹 Redirect with success
            return redirect()->back()->with('success', 'Technical card added successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()
                ->withInput() // keep old form values
                ->with('error', 'Failed to save technical card. Please try again.');
        }
    }

    public function createTape(Request $request): ?RedirectResponse
    {
        $validated = $request->validate([
            'reference_number' => 'required|string|max:255|unique:technical_cards,reference_number',
            'size' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:100',
            'yarn_count' => 'nullable|string|max:100',
            'rubber_type' => 'nullable|string|max:100',
            'spindles' => 'nullable|integer|min:0',
            'weft_yarn' => 'nullable|string|max:100',
            'warp_yarn' => 'nullable|string|max:100',
            'reed' => 'nullable|string|max:100',
            'machine' => 'nullable|string|max:100',
            'wheel_up' => 'nullable|string|max:100',
            'wheel_down' => 'nullable|string|max:100',
            'needles' => 'nullable|integer|min:0',
            'stretchability' => 'nullable|string|max:100',
            'weight_per_yard' => 'nullable|numeric|min:0',
            'url' => 'nullable|file|mimes:jpg,jpeg,pdf|max:2048', // 🔹 2MB max
            'special_remarks' => 'nullable|string|max:500',
        ]);

        try {
            // 🔹 Handle file upload
            if ($request->hasFile('url')) {
                $file = $request->file('url');
                $path = $file->store('technical_cards', 'public'); // saves to storage/app/public/technicalCards
                $validated['url'] = Storage::url($path); // /storage/technicalCards/filename.ext
            }

            $validated['type'] = 'Tape';
            TechnicalCard::create($validated);

            // 🔹 Redirect with success
            return redirect()->back()->with('success', 'Technical card added successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()
                ->withInput() // keep old form values
                ->with('error', 'Failed to save technical card. Please try again.');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(TechnicalCard $technicalCard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TechnicalCard $technicalCard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TechnicalCard $technicalCard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TechnicalCard $technicalCard): RedirectResponse
    {
        try {
            // 🔹 Delete associated file if exists
            if ($technicalCard->url) {
                $filePath = str_replace('/storage/', '', $technicalCard->url); // convert URL to storage path
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            // 🔹 Delete the database record
            $technicalCard->delete();

            return redirect()->back()->with('success', 'Technical card and associated file deleted successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());

            return redirect()->back()
                ->with('error', 'Failed to delete technical card: ' . $e->getMessage());
        }
    }

    public function storeImage(Request $request, TechnicalCard $technicalCard): RedirectResponse
    {
        $request->validate([
            'url' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // max 2MB
        ]);

        try {
            // 🔹 Delete previous file if exists
            if ($technicalCard->url) {
                $filePath = str_replace('/storage/', '', $technicalCard->url);
                if (Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
            }

            // 🔹 Store new file
            $file = $request->file('url');
            $path = $file->store('technical_cards', 'public');
            $technicalCard->url = Storage::url($path);

            $technicalCard->save();

            return redirect()->back()->with('success', 'Image uploaded successfully.');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to upload image: ' . $e->getMessage());
        }
    }
}
