<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Services\AIAssetGenerator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateBusinessAssets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle(AIAssetGenerator $generator)
    {
        try {
            // Generate business description
            $description = $generator->generateBusinessDescription($this->tenant);

            // Generate logo
            $logoPath = $generator->generateLogo($this->tenant);

            // Generate banner
            $bannerPath = $generator->generateBanner($this->tenant);

            // Update tenant with generated assets
            $this->tenant->update([
                'business_description' => $description,
                'logo_path' => $logoPath,
                'banner_path' => $bannerPath,
                'setup_completed' => true,
            ]);

        } catch (Exception $e) {
            logger()->error('Asset generation failed for tenant ' . $this->tenant->id . ': ' . $e->getMessage());

            // Retry the job
            $this->release(60);
        }
    }
}
