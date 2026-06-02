<?php

namespace Tests\Feature;

use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterDetailsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_character_details_and_ownership_status(): void
    {
        $user = User::factory()->create();

        $character = Character::create([
            'japanese_name' => 'ルフィ',
            'english_name' => 'Monkey D. Luffy',
            'romaji_name' => 'Munkii Dii Rufi',
            'rarity' => 'Legendary',
            'bounty' => '1,500,000,000',
            'hp' => 1200,
            'attack' => 1300,
            'defense' => 900,
            'speed' => 1100,
            'status' => 'Alive',
            'origin' => 'East Blue',
        ]);

        $response = $this->actingAs($user)->get(route('characters.show', $character));

        $response->assertSuccessful();
        $response->assertSee('Monkey D. Luffy');
        $response->assertSee('Tu ne possedes pas encore ce personnage');

        $user->characters()->attach($character);

        $response = $this->actingAs($user)->get(route('characters.show', $character));

        $response->assertSuccessful();
        $response->assertSee('Tu possedes ce personnage');
    }
}
