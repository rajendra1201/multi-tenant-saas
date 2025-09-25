<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\Domain;
use App\Jobs\GenerateBusinessAssets;
use Illuminate\Support\Str;

class TenantSetupService
{
    protected $businessTypeService;

    public function __construct(BusinessTypeService $businessTypeService)
    {
        $this->businessTypeService = $businessTypeService;
    }

    public function createTenant(array $data): Tenant
    {
        // Generate unique subdomain
        $subdomain = $this->generateSubdomain($data['business_name']);

        // Create tenant
        $tenant = Tenant::create([
            'id' => Str::uuid(),
            'business_name' => $data['business_name'],
            'owner_name' => $data['owner_name'],
            'owner_email' => $data['owner_email'],
            'business_type' => $data['business_type'],
            'theme' => $this->businessTypeService->getTheme($data['business_type']),
            'setup_completed' => false,
        ]);

        // Create domain
        $tenant->domains()->create([
            'domain' => $subdomain,
        ]);

        // Initialize tenant database
        $tenant->run(function () use ($tenant) {
            $this->initializeTenantDatabase($tenant);
        });

        return $tenant;
    }

    public function setupBusinessAssets(Tenant $tenant): void
    {
        // Dispatch job to generate assets asynchronously
        GenerateBusinessAssets::dispatch($tenant);
    }

    protected function generateSubdomain(string $businessName): string
    {
        $base = Str::slug($businessName);
        $subdomain = $base;
        $counter = 1;

        while (Domain::where('domain', $subdomain)->exists()) {
            $subdomain = $base . '-' . $counter;
            $counter++;
        }

        return $subdomain;
    }

    protected function initializeTenantDatabase(Tenant $tenant): void
    {
        // Run tenant-specific migrations
        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--force' => true,
        ]);

        // Seed initial data based on business type
        $this->seedBusinessData($tenant);
    }

    protected function seedBusinessData(Tenant $tenant): void
    {
        $businessTypeData = $this->businessTypeService->getBusinessType($tenant->business_type);

        if (!$businessTypeData) {
            return;
        }

        // Create default categories based on business type
        foreach ($businessTypeData['default_sections'] as $section) {
            \App\Models\Category::create([
                'name' => ucwords(str_replace('-', ' ', $section)),
                'slug' => $section,
                'is_active' => true,
            ]);
        }

        // Create default services
        foreach ($businessTypeData['services'] as $service) {
            AppModelsService::create([
                'name' => $service,
                'description' => "Professional {$service} service",
                'is_active' => true,
            ]);
        }

        // Create default product categories
        foreach ($businessTypeData['products'] as $product) {
            \App\Models\Product::create([
                'name' => $product,
                'description' => "High-quality {$product}",
                'price' => 0,
                'is_active' => true,
            ]);
        }
    }
}
