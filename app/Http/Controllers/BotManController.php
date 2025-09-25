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
            'conversation_cache_time' => 30,
            'user_cache_time'         => 30,
        ];

        // Pass IlluminateCache() as the cache driver
        $botman = BotManFactory::create($config, new BotManCache(), $request);

        // Start conversation triggers
        $botman->hears('start', fn($botman) => $botman->startConversation(new OnboardingConversation()));
        $botman->hears('hello', fn($botman) => $botman->startConversation(new OnboardingConversation()));
        $botman->hears('hi',    fn($botman) => $botman->startConversation(new OnboardingConversation()));
        $botman->hears('begin', fn($botman) => $botman->startConversation(new OnboardingConversation()));

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
