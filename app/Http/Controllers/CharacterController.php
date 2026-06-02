<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CharacterController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Character::all());
    }

    public function show(int $id): JsonResponse
    {
        $character = Character::find($id);

        if ($character === null) {
            return response()->json(['error' => 'Pirate introuvable'], 404);
        }

        return response()->json($character);
    }

    public function search(Request $request): JsonResponse
    {
        $name = $request->string('name')->trim()->toString();

        return response()->json(
            Character::query()
                ->when($name !== '', function (Builder $query) use ($name): void {
                    $query->where(function (Builder $query) use ($name): void {
                        $query->where('english_name', 'like', "%{$name}%")
                            ->orWhere('japanese_name', 'like', "%{$name}%")
                            ->orWhere('romaji_name', 'like', "%{$name}%");
                    });
                })
                ->orderBy('english_name')
                ->get()
        );
    }

    public function catalog(Request $request): View
    {
        $query = Character::query()->select([
            'id',
            'japanese_name',
            'english_name',
            'romaji_name',
            'image_url',
            'rarity',
            'bounty',
            'origin',
            'status',
            'hp',
            'attack',
            'defense',
            'speed',
            'created_at',
        ]);

        $name = $request->string('name')->trim()->toString();
        $rarity = $request->string('rarity')->trim()->toString();
        $stat = $request->string('stat')->trim()->toString();

        if ($name !== '') {
            $query->where(function (Builder $query) use ($name): void {
                $query->where('english_name', 'like', "%{$name}%")
                    ->orWhere('japanese_name', 'like', "%{$name}%")
                    ->orWhere('romaji_name', 'like', "%{$name}%");
            });
        }

        if (in_array($rarity, ['Legendary', 'Epic', 'Rare'], true)) {
            $query->where('rarity', $rarity);
        }

        if (in_array($stat, ['hp', 'attack', 'defense', 'speed'], true)) {
            if ($request->filled('stat_min')) {
                $query->where($stat, '>=', (int) $request->input('stat_min'));
            }

            if ($request->filled('stat_max')) {
                $query->where($stat, '<=', (int) $request->input('stat_max'));
            }
        }

        $sort = $request->string('sort')->trim()->toString();
        $direction = $request->string('direction')->trim()->lower()->toString() === 'asc' ? 'asc' : 'desc';

        if ($sort === 'name') {
            $query->orderBy('english_name', $direction)->orderBy('japanese_name', $direction);
        } elseif ($sort === 'rarity') {
            $query->orderByRaw("CASE rarity WHEN 'Legendary' THEN 3 WHEN 'Epic' THEN 2 WHEN 'Rare' THEN 1 ELSE 0 END {$direction}")
                ->orderBy('english_name');
        } elseif ($sort === 'power') {
            $query->orderByRaw('(COALESCE(hp, 0) + COALESCE(attack, 0) + COALESCE(defense, 0) + COALESCE(speed, 0)) '.$direction)
                ->orderBy('english_name');
        } elseif (in_array($sort, ['hp', 'attack', 'defense', 'speed'], true)) {
            $query->orderBy($sort, $direction)->orderBy('english_name');
        } else {
            $query->orderBy('created_at', $direction)->orderBy('id', $direction);
            $sort = 'recent';
        }

        return view('gacha.characters', [
            'characters' => $query->paginate(12)->withQueryString(),
            'filters' => [
                'name' => $name,
                'rarity' => $rarity,
                'stat' => $stat,
                'stat_min' => $request->input('stat_min'),
                'stat_max' => $request->input('stat_max'),
                'sort' => $sort,
                'direction' => $direction,
            ],
        ]);
    }

    public function details(Request $request, Character $character): View
    {
        $ownedCharacter = $request->user()?->characters()
            ->whereKey($character->getKey())
            ->first();

        return view('gacha.character', [
            'character' => $character,
            'isOwned' => $ownedCharacter !== null,
            'ownedAt' => $ownedCharacter?->pivot?->created_at,
            'ownedCount' => $character->users()->count(),
        ]);
    }
}
