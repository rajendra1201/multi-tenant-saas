<?php

namespace App\Conversations;

use App\Models\Tenant;
use App\Models\Domain;
use App\Services\BusinessTypeService;
use App\Services\TenantSetupService;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;

class OnboardingConversation extends Conversation
{
    protected $businessName;
    protected $ownerName;
    protected $ownerEmail;
    protected $businessType;
    protected $businessTypeService;
    protected $tenantSetupService;

    public function __construct()
    {
        $this->businessTypeService = new BusinessTypeService();
        $this->tenantSetupService = new TenantSetupService($this->businessTypeService);
    }

    public function run()
    {
        $this->say('Welcome! I\'ll help you set up your business in just a few steps. 🚀');
        $this->askBusinessName();
    }

    public function askBusinessName()
    {
        $this->ask('What\'s the name of your business?', function (Answer $answer) {
            $this->businessName = $answer->getText();
            $this->askOwnerName();
        });
    }

    public function askOwnerName()
    {
        $this->ask('Great! What\'s your name (business owner)?', function (Answer $answer) {
            $this->ownerName = $answer->getText();
            $this->askOwnerEmail();
        });
    }

    public function askOwnerEmail()
    {
        $this->ask('What\'s your email address?', function (Answer $answer) {
            $email = $answer->getText();

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->say('Please enter a valid email address.');
                $this->askOwnerEmail();
                return;
            }

            $this->ownerEmail = $email;
            $this->askBusinessType();
        });
    }

    public function askBusinessType()
    {
        $question = Question::create('What type of business do you have?');

        $businessTypes = $this->businessTypeService->getBusinessTypes();

        foreach ($businessTypes as $key => $type) {
            $question->addButton(Button::create($type['name'])->value($key));
        }

        $this->ask($question, function (Answer $answer) {
            $this->businessType = $answer->getValue();
            $this->confirmDetails();
        });
    }

    public function confirmDetails()
    {
        $businessTypeData = $this->businessTypeService->getBusinessType($this->businessType);

        $details = "Let me confirm your details:nn";
        $details .= "🏢 Business: {$this->businessName}n";
        $details .= "👤 Owner: {$this->ownerName}n";
        $details .= "📧 Email: {$this->ownerEmail}n";
        $details .= "🏪 Type: {$businessTypeData['name']}nn";
        $details .= "Is this correct?";

        $question = Question::create($details);
        $question->addButton(Button::create('Yes, Create My Business!')->value('yes'));
        $question->addButton(Button::create('No, Let me correct')->value('no'));

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                $this->createTenant();
            } else {
                $this->say('Let\'s start over!');
                $this->askBusinessName();
            }
        });
    }

    public function createTenant()
    {
        $this->say('Perfect! I\'m setting up your business now... ⚙️');

        try {
            // Create tenant
            $tenant = $this->tenantSetupService->createTenant([
                'business_name' => $this->businessName,
                'owner_name' => $this->ownerName,
                'owner_email' => $this->ownerEmail,
                'business_type' => $this->businessType,
            ]);

            $this->say('🎉 Congratulations! Your business has been created successfully!');
            $this->say("Your business URL: http://{$tenant->domains->first()->domain}.localhost:8000");
            $this->say('I\'m now generating your logo, banner, and setting up your products and services...');

            // Setup business assets asynchronously
            $this->tenantSetupService->setupBusinessAssets($tenant);

            $this->say('✅ Setup complete! You can now access your business dashboard and start customizing your store.');

        } catch (Exception $e) {
            $this->say('❌ Sorry, there was an error creating your business. Please try again or contact support.');
            logger()->error('Tenant creation failed: ' . $e->getMessage());
        }
    }
}
