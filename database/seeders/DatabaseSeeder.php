<?php

namespace Database\Seeders;

use App\Models\User;
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
        Character::create([
            'nom' => 'Monkey D. Luffy',
            'titre' => 'Chapeau de Paille',
            'origine' => 'Village de Fuchsia (East Blue)',
            'capacites' => [
                'fruit' => 'Hito Hito no Mi (Nika)',
                'haki' => ['Rois', 'Armement', 'Observation']
            ],
            'avancement' => 'Empereur des Mers (Yonko)',
            'prime' => 3000000000
        ]);
}
}
