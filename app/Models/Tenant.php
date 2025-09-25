<?php

namespace App\Models;

use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;

    protected $fillable = [
        'id',
        'business_type',
        'business_name',
        'owner_name',
        'owner_email',
        'theme',
        'setup_completed',
        'logo_path',
        'banner_path',
        'business_description',
    ];

    protected $casts = [
        'setup_completed' => 'boolean',
    ];

    public static function getDefaultConnectionName(): string
    {
        return 'tenant';
    }
}
