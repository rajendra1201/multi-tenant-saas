<?php

return [
    'tenant_model' => \App\Models\Tenant::class,
    'id_generator' => \Stancl\Tenancy\UuidGenerator::class,

    'domain_model' => \App\Models\Domain::class,

    'central_domains' => [
        'localhost',
        '127.0.0.1',
    ],

    'bootstrappers' => [
        \Stancl\Tenancy\Bootstrappers\DatabaseTenancyBootstrapper::class,
        \Stancl\Tenancy\Bootstrappers\CacheTenancyBootstrapper::class,
        \Stancl\Tenancy\Bootstrappers\FilesystemTenancyBootstrapper::class,
    ],

    'database' => [
        'central_connection' => 'mysql',
        'template_tenant_connection' => 'tenant',
        'prefix' => 'tenant',
        'suffix' => '',
    ],

    'cache' => [
        'tag_base' => 'tenant',
    ],

    'filesystem' => [
        'suffix_base' => 'tenant',
        'disks' => [
            'local',
            'public',
        ],
    ],

    'redis' => [
        'prefix_base' => 'tenant',
    ],
];
