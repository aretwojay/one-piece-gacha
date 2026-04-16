<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class GachaController extends Controller
{
    private const PULLS_RATE_LIMITER_NAME = 'gacha-pulls';

    private const PULLS_PER_HOUR_LIMIT = 10;

    public function dashboard(): View
    {
        return view('gacha.dashboard');
    }

    public function showPullAnimation(Request $request): View
    {
        return view('gacha.pull', $this->pullAvailability($request));
    }

    public function fetchCharacter(Request $request): JsonResponse
    {
        $character = Character::query()->inRandomOrder()->first();

        if (! $character) {
            return response()->json([
                'message' => 'Aucun personnage n\'est disponible dans la base de donnees.',
            ], 404);
        }

        $pullAvailability = $this->pullAvailability($request);

        return response()->json([
            'id' => $character->getKey(),
            'name' => $character->english_name ?: 'Personnage mystere',
            'rarity' => $character->rarity ?: 'Inconnue',
            'pulls_remaining' => $pullAvailability['pullsRemaining'],
            'pulls_limit' => $pullAvailability['pullsLimit'],
            'retry_after' => $pullAvailability['retryAfterSeconds'],
        ]);
    }

    public function pull(Request $request): View|RedirectResponse
    {
        $characterId = $request->integer('character');

        if ($characterId <= 0) {
            return redirect()
                ->route('gacha.pull-animation')
                ->with('error', 'Lance un tirage depuis la page d\'animation.');
        }

        $character = Character::query()->find($characterId);

        if (! $character) {
            return redirect()
                ->route('gacha.pull-animation')
                ->with('error', 'Le personnage tire est indisponible. Relance un tirage.');
        }

        $pullAvailability = $this->pullAvailability($request);

        return view('gacha.result', [
            'character' => $character,
            'pullsRemaining' => $pullAvailability['pullsRemaining'],
            'pullsLimit' => $pullAvailability['pullsLimit'],
            'retryAfterSeconds' => $pullAvailability['retryAfterSeconds'],
        ]);
    }

    /**
     * @return array{pullsRemaining:int,pullsLimit:int,retryAfterSeconds:int}
     */
    private function pullAvailability(Request $request): array
    {
        $limiterKey = $this->pullLimiterStorageKey($request);
        $pullsRemaining = max(0, RateLimiter::remaining($limiterKey, self::PULLS_PER_HOUR_LIMIT));
        $retryAfterSeconds = RateLimiter::tooManyAttempts($limiterKey, self::PULLS_PER_HOUR_LIMIT)
            ? RateLimiter::availableIn($limiterKey)
            : 0;

        return [
            'pullsRemaining' => $pullsRemaining,
            'pullsLimit' => self::PULLS_PER_HOUR_LIMIT,
            'retryAfterSeconds' => $retryAfterSeconds,
        ];
    }

    private function pullLimiterKey(Request $request): string
    {
        return $request->user()?->getAuthIdentifier()
            ? 'gacha-pulls:user:'.$request->user()->getAuthIdentifier()
            : 'gacha-pulls:ip:'.$request->ip();
    }

    private function pullLimiterStorageKey(Request $request): string
    {
        return md5(self::PULLS_RATE_LIMITER_NAME.$this->pullLimiterKey($request));
    }
}
