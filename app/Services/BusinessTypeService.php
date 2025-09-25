<?php

namespace App\Services;

class BusinessTypeService
{
    protected $businessTypes = [
        'gym' => [
            'name' => 'Gym & Fitness Center',
            'theme' => 'fitness',
            'default_sections' => ['memberships', 'trainers', 'classes', 'equipment'],
            'banner_keywords' => ['fitness', 'gym', 'workout', 'strength training'],
            'services' => ['Personal Training', 'Group Classes', 'Nutrition Counseling'],
            'products' => ['Protein Supplements', 'Fitness Equipment', 'Gym Merchandise'],
        ],
        'kirana' => [
            'name' => 'Kirana Store',
            'theme' => 'grocery',
            'default_sections' => ['groceries', 'daily-essentials', 'household'],
            'banner_keywords' => ['grocery store', 'daily essentials', 'fresh vegetables'],
            'services' => ['Home Delivery', 'Bulk Orders', 'Fresh Produce'],
            'products' => ['Rice & Grains', 'Spices', 'Dairy Products', 'Snacks'],
        ],
        'clothing' => [
            'name' => 'Clothing Store',
            'theme' => 'fashion',
            'default_sections' => ['mens-wear', 'womens-wear', 'accessories'],
            'banner_keywords' => ['fashion', 'clothing', 'trendy outfits', 'style'],
            'services' => ['Custom Tailoring', 'Personal Styling', 'Alterations'],
            'products' => ['Shirts', 'Dresses', 'Accessories', 'Shoes'],
        ],
        'restaurant' => [
            'name' => 'Restaurant',
            'theme' => 'food',
            'default_sections' => ['menu', 'reservations', 'catering'],
            'banner_keywords' => ['restaurant', 'delicious food', 'dining experience'],
            'services' => ['Dine-in', 'Takeaway', 'Catering', 'Home Delivery'],
            'products' => ['Appetizers', 'Main Course', 'Desserts', 'Beverages'],
        ],
        'salon' => [
            'name' => 'Beauty Salon',
            'theme' => 'beauty',
            'default_sections' => ['services', 'staff', 'appointments'],
            'banner_keywords' => ['beauty salon', 'hair styling', 'beauty treatments'],
            'services' => ['Hair Cut & Styling', 'Facial Treatments', 'Manicure & Pedicure'],
            'products' => ['Hair Care Products', 'Skincare', 'Cosmetics'],
        ],
    ];

    public function getBusinessTypes(): array
    {
        return $this->businessTypes;
    }

    public function getBusinessType(string $type): ?array
    {
        return $this->businessTypes[$type] ?? null;
    }

    public function getTheme(string $businessType): string
    {
        return $this->businessTypes[$businessType]['theme'] ?? 'default';
    }

    public function getDefaultSections(string $businessType): array
    {
        return $this->businessTypes[$businessType]['default_sections'] ?? [];
    }

    public function getBannerKeywords(string $businessType): array
    {
        return $this->businessTypes[$businessType]['banner_keywords'] ?? [];
    }
}
