<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GachaController extends Controller
{
    public function dashboard(): View
    {
        return view('gacha.dashboard');
    }

    public function pull(): View|RedirectResponse
    {
        $character = Character::query()->inRandomOrder()->first();

        if (! $character) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Aucun personnage n\'est disponible dans la base de donnees.');
        }

        return view('gacha.result', [
            'character' => $character,
        ]);
    }
}
