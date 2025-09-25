<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('category')->latest()->paginate(10);
        return view('dashboard.services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('dashboard.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    public function show(Service $service)
    {
        return view('dashboard.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $categories = Category::where('is_active', true)->get();
        return view('dashboard.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully!');
    }
}
