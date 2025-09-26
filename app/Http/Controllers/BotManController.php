<?php

namespace App\Http\Controllers;

use App\Conversations\OnboardingConversation;
use BotMan\BotMan\BotManFactory;
use App\Cache\BotManCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BotManController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('BotMan request data:', $request->all());

        // Load the Web driver
        DriverManager::loadDriver(WebDriver::class);

        // BotMan config
        $config = [
            'conversation_cache_time' => 600,
            'user_cache_time'         => 600,
        ];

        // Pass IlluminateCache() as the cache driver
        $botman = BotManFactory::create($config, new BotManCache(), $request);

        // Start conversation triggers (case-insensitive)
        $botman->hears('/^(start|hello|hi|begin)$/i', function ($botman) {
            $botman->startConversation(new OnboardingConversation());
        });

        // Fallback
        $botman->fallback(function ($botman) {
            $text = $botman->getMessage()->getText() ?: '[empty]';
            $botman->reply("Sorry, I didn't understand \"$text\".\nType “start” to begin the onboarding process.");
        });

        $botman->listen();
    }

    public function tinker()
    {
        return view('botman.tinker');
    }
}
