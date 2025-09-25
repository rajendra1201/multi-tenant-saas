<?php

namespace App\Services;

use App\Models\Tenant;
use OpenAI;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AIAssetGenerator
{
    protected $openai;
    protected $businessTypeService;

    public function __construct(BusinessTypeService $businessTypeService)
    {
        $this->openai = OpenAI::client(config('services.openai.key'));
        $this->businessTypeService = $businessTypeService;
    }

    public function generateBusinessDescription(Tenant $tenant): string
    {
        $businessType = $this->businessTypeService->getBusinessType($tenant->business_type);

        $prompt = "Write a professional business description for '{$tenant->business_name}', a {$businessType['name']}. 
                  Make it engaging, highlight key services, and keep it under 200 words. 
                  Focus on what makes this business unique and appealing to customers.";

        try {
            $response = $this->openai->completions()->create([
                'model' => 'gpt-3.5-turbo-instruct',
                'prompt' => $prompt,
                'max_tokens' => 200,
                'temperature' => 0.7,
            ]);

            return trim($response['choices'][0]['text']);
        } catch (Exception $e) {
            return "Welcome to {$tenant->business_name}, your trusted {$businessType['name']}. We provide exceptional services and products to meet all your needs.";
        }
    }

    public function generateLogo(Tenant $tenant): string
    {
        try {
            // For demo purposes, create a text-based logo
            return $this->generateTextLogo($tenant);
        } catch (Exception $e) {
            return $this->generateTextLogo($tenant);
        }
    }

    public function generateBanner(Tenant $tenant): string
    {
        try {
            // For demo purposes, create a simple banner
            return $this->generateDefaultBanner($tenant);
        } catch (Exception $e) {
            return $this->generateDefaultBanner($tenant);
        }
    }

    protected function generateTextLogo(Tenant $tenant): string
    {
        // Create a simple text-based logo as fallback
        $filename = $tenant->id . '_logo_text_' . time() . '.txt';
        $path = 'tenants/' . $tenant->id . '/assets/' . $filename;

        Storage::put($path, $tenant->business_name);

        return $path;
    }

    protected function generateDefaultBanner(Tenant $tenant): string
    {
        // Create a simple banner as fallback
        $filename = $tenant->id . '_banner_default_' . time() . '.txt';
        $path = 'tenants/' . $tenant->id . '/assets/' . $filename;

        Storage::put($path, "Welcome to {$tenant->business_name}");

        return $path;
    }
}
