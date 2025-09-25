<?php

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\View;

class ThemeService
{
    protected $themes = [
        'fitness' => [
            'name' => 'Fitness Theme',
            'primary_color' => '#FF6B35',
            'secondary_color' => '#004E89',
            'accent_color' => '#F7931E',
            'css_file' => 'themes/fitness.css',
            'layout' => 'fitness',
        ],
        'grocery' => [
            'name' => 'Grocery Theme',
            'primary_color' => '#2E8B57',
            'secondary_color' => '#FFD700',
            'accent_color' => '#228B22',
            'css_file' => 'themes/grocery.css',
            'layout' => 'grocery',
        ],
        'fashion' => [
            'name' => 'Fashion Theme',
            'primary_color' => '#FF1493',
            'secondary_color' => '#000000',
            'accent_color' => '#C0C0C0',
            'css_file' => 'themes/fashion.css',
            'layout' => 'fashion',
        ],
        'food' => [
            'name' => 'Restaurant Theme',
            'primary_color' => '#DC143C',
            'secondary_color' => '#FFD700',
            'accent_color' => '#8B4513',
            'css_file' => 'themes/food.css',
            'layout' => 'restaurant',
        ],
        'beauty' => [
            'name' => 'Beauty Theme',
            'primary_color' => '#FF69B4',
            'secondary_color' => '#DDA0DD',
            'accent_color' => '#FFB6C1',
            'css_file' => 'themes/beauty.css',
            'layout' => 'beauty',
        ],
    ];

    public function getTheme(string $themeKey): ?array
    {
        return $this->themes[$themeKey] ?? null;
    }

    public function getAllThemes(): array
    {
        return $this->themes;
    }

    public function applyTheme(Tenant $tenant): void
    {
        $theme = $this->getTheme($tenant->theme);

        if ($theme) {
            View::share('current_theme', $theme);
            View::share('tenant', $tenant);
        }
    }

    public function generateThemeCSS(Tenant $tenant): string
    {
        $theme = $this->getTheme($tenant->theme);

        if (!$theme) {
            return '';
        }

        return "
        :root {
            --primary-color: {$theme['primary_color']};
            --secondary-color: {$theme['secondary_color']};
            --accent-color: {$theme['accent_color']};
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .navbar {
            background-color: var(--primary-color);
        }

        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background-color: var(--primary-color) !important;
        }

        .border-primary {
            border-color: var(--primary-color) !important;
        }
        ";
    }
}
