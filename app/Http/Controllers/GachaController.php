<?php

namespace App\Http\Controllers;

use App\Models\Character; // Très important : on importe le modèle
use Illuminate\Http\Request;

class GachaController extends Controller
{
    /**
     * Logique pour tirer un personnage aléatoire
     */
    public function pull()
    {
        for ($i = 1; $i <= 10; $i++) {
            $personnage = Character::inRandomOrder()->first();

            if (!$personnage) {
                return "Erreur : Aucun personnage n'est disponible dans la base de données.";
            }
        }

        // 3. On envoie le personnage à une "vue" (le fichier HTML)
        // On crée un dossier 'gacha' dans resources/views et un fichier 'result.blade.php'
        return view('gacha.result', [
            'character' => $personnage
        ]);
    }
}