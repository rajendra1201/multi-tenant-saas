<?php

namespace App\Cache;

use BotMan\BotMan\Interfaces\CacheInterface;
use Illuminate\Support\Facades\Cache;

class BotManCache implements CacheInterface
{
    public function put($key, $value, $seconds): void
    {
        Cache::put($key, $value, $seconds);
    }

    public function get($key, $default = null)
    {
        return Cache::get($key, $default);
    }

    public function destroy($key): void
    {
        Cache::forget($key);
    }

    public function increment($key, $value = 1): void
    {
        Cache::increment($key, $value);
    }

    public function decrement($key, $value = 1): void
    {
        Cache::decrement($key, $value);
    }

    public function has($key): bool
    {
        return Cache::has($key);
    }

    public function pull($key, $default = null)
    {
        return Cache::pull($key, $default);
    }
}
