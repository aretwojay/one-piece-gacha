<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('gacha-pulls', function (Request $request) {
            $limiterKey = $request->user()?->getAuthIdentifier()
                ? 'gacha-pulls:user:'.$request->user()->getAuthIdentifier()
                : 'gacha-pulls:ip:'.$request->ip();

            return Limit::perHour(10)
                ->by($limiterKey)
                ->response(function (Request $request, array $headers) {
                    $retryAfterSeconds = max(1, (int) ($headers['Retry-After'] ?? 3600));
                    $retryAfterMinutes = (int) ceil($retryAfterSeconds / 60);
                    $message = "Tu as atteint la limite de 10 tirages par heure. Reessaie dans {$retryAfterMinutes} minute(s).";

                    if ($request->expectsJson()) {
                        return response()->json([
                            'message' => $message,
                            'retry_after' => $retryAfterSeconds,
                        ], 429, $headers);
                    }

                    return redirect()
                        ->route('dashboard')
                        ->with('error', $message);
                });
        });
    }
}
