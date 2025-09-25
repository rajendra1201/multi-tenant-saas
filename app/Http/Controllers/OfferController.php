<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::latest()->paginate(10);
        return view('dashboard.offers.index', compact('offers'));
    }

    public function create()
    {
        return view('dashboard.offers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'code' => 'nullable|string|max:50|unique:offers,code',
            'min_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $validated['used_count'] = 0;
        $validated['is_active'] = true;

        Offer::create($validated);

        return redirect()->route('offers.index')->with('success', 'Offer created successfully!');
    }

    public function show(Offer $offer)
    {
        return view('dashboard.offers.show', compact('offer'));
    }

    public function edit(Offer $offer)
    {
        return view('dashboard.offers.edit', compact('offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'code' => 'nullable|string|max:50|unique:offers,code,' . $offer->id,
            'min_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'usage_limit' => 'nullable|integer|min:1',
        ]);

        $offer->update($validated);

        return redirect()->route('offers.index')->with('success', 'Offer updated successfully!');
    }

    public function destroy(Offer $offer)
    {
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Offer deleted successfully!');
    }
}
