<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Offer;
use App\Services\ThemeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    protected $themeService;

    public function __construct(ThemeService $themeService)
    {
        $this->themeService = $themeService;
    }

    public function index()
    {
        $tenant = tenant();

        if (!$tenant) {
            return redirect('/');
        }

        $this->themeService->applyTheme($tenant);

        $stats = [
            'products' => Product::count(),
            'services' => Service::count(),
            'blog_posts' => Blog::count(),
            'offers' => Offer::count(),
        ];

        return view('dashboard.index', compact('tenant', 'stats'));
    }
}
