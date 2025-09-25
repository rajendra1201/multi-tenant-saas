<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(10);
        return view('dashboard.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('dashboard.blog.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = 1; // Default author for demo

        if ($validated['is_published'] ?? false) {
            $validated['published_at'] = now();
        }

        Blog::create($validated);

        return redirect()->route('blog.index')->with('success', 'Blog post created successfully!');
    }

    public function show(Blog $blog)
    {
        return view('dashboard.blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = Category::where('is_active', true)->get();
        return view('dashboard.blog.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if (($validated['is_published'] ?? false) && !$blog->published_at) {
            $validated['published_at'] = now();
        }

        $blog->update($validated);

        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully!');
    }
}
