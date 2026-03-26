<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    // Liste tous les personnages
    public function index()
    {
        return response()->json(Character::all());
    }

    // Voir un personnage précis
    public function show($id)
    {
        $character = Character::find($id);
        return $character ? response()->json($character) : response()->json(['error' => 'Pirate introuvable'], 404);
    }

    // Recherche (ex: /api/characters/search?name=Luffy)
    public function search(Request $request)
    {
        $name = $request->query('name');
        return Character::where('nom', 'LIKE', "%$name%")->get();
    }
}