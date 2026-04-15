<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Character;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $Characters = [
            [
                'nom' => 'Monkey D. Luffy',
                'titre' => 'Chapeau de Paille',
                'origine' => 'Village de Fuchsia (East Blue)',
                'capacites' => ['fruit' => 'Hito Hito no Mi (Nika)', 'haki' => ['Rois', 'Armement', 'Observation']],
                'avancement' => 'Empereur (Yonko), actuellement sur Egghead.',
                'prime' => 3000000000,
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'Roronoa Zoro',
                'titre' => 'Chasseur de Pirates',
                'origine' => 'Shimotsuki (East Blue)',
                'capacites' => ['fruit' => 'Aucun', 'haki' => ['Rois', 'Armement', 'Observation']],
                'avancement' => 'Second de Luffy, a vaincu King à Onigashima.',
                'prime' => 1111000000
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'Shanks',
                'titre' => 'Le Roux',
                'origine' => 'West Blue',
                'capacites' => ['fruit' => 'Aucun', 'haki' => ['Rois (Maîtrise absolue)', 'Armement', 'Observation']],
                'avancement' => 'Empereur, protecteur d\'Elbaf.',
                'prime' => 4048900000
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'Marshall D. Teach',
                'titre' => 'Barbe Noire',
                'origine' => 'Inconnue',
                'capacites' => ['fruit' => ['Yami Yami no Mi', 'Gura Gura no Mi'], 'haki' => ['Armement', 'Observation']],
                'avancement' => 'Empereur, basé sur l\'île de la Ruche.',
                'prime' => 3996000000
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'Trafalgar D. Water Law',
                'titre' => 'La Chirurgien de la Mort',
                'origine' => 'Flevance (North Blue)',
                'capacites' => ['fruit' => 'Ope Ope no Mi (Éveil)', 'haki' => ['Armement', 'Observation']],
                'avancement' => 'Ancien Grand Corsaire, a vaincu Big Mom avec Kid.',
                'prime' => 3000000000
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'Monkey D. Dragon',
                'titre' => 'Le pire criminel au monde',
                'origine' => 'Royaume de Goa (East Blue)',
                'capacites' => ['fruit' => 'Inconnu (Lien avec le vent)', 'haki' => ['Rois', 'Armement', 'Observation']],
                'avancement' => 'Chef de l\'Armée Révolutionnaire.',
                'prime' => 0 // Inconnue mais colossale
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'Sakazuki',
                'titre' => 'Akainu',
                'origine' => 'North Blue',
                'capacites' => ['fruit' => 'Magu Magu no Mi', 'haki' => ['Armement', 'Observation']],
                'avancement' => 'Amiral en Chef de la Marine.',
                'prime' => 0
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ],
            [
                'nom' => 'BuggY',
                'titre' => 'Le Clown / Le Génie bouffon',
                'origine' => 'Grand Line',
                'capacites' => ['fruit' => 'Bara Bara no Mi', 'haki' => ['Aucun']],
                'avancement' => 'Empereur (Yonko) par accident, leader de Cross Guild.',
                'prime' => 3189000000
                'image_url' => https://i.redd.it/fcnh4ty49i791.png
            ]
        ];

        foreach ($characters as $character) {
                \App\Models\Character::create($character);
            }
    }
}