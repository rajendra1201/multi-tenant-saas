<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TenancyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mapTenantRoutes();
    }

    protected function mapTenantRoutes(): void
    {
        $tenantRoutes = base_path('routes/tenant.php');

        if (file_exists($tenantRoutes)) {
            Route::middleware([
                'web',
                \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
                \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
            ])
            ->group($tenantRoutes);
        }
    }
}
