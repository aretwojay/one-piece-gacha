<?php

namespace Tests\Feature;

use App\Models\Character;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CharacterCatalogPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_character_catalog_page_is_reachable_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('characters.index'))
            ->assertSuccessful();
    }

    public function test_guest_is_redirected_from_the_character_catalog(): void
    {
        $this->get(route('characters.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_users_can_filter_and_sort_the_character_catalog(): void
    {
        $user = User::factory()->create();

        Character::create([
            'japanese_name' => 'モンキー・D・ルフィ',
            'english_name' => 'Monkey D. Luffy',
            'romaji_name' => 'Monkii Dii Rufi',
            'rarity' => 'Legendary',
            'bounty' => '1,500,000,000',
            'hp' => 1200,
            'attack' => 1300,
            'defense' => 900,
            'speed' => 1100,
            'status' => 'Alive',
            'origin' => 'East Blue',
        ]);

        Character::create([
            'japanese_name' => 'ゴール・D・ロジャー',
            'english_name' => 'Gol D. Roger',
            'romaji_name' => 'Gooru Dii Rojaa',
            'rarity' => 'Legendary',
            'bounty' => '5,564,800,000',
            'hp' => 1500,
            'attack' => 1500,
            'defense' => 1200,
            'speed' => 1400,
            'status' => 'Deceased',
            'origin' => 'Grand Line',
        ]);

        Character::create([
            'japanese_name' => 'ロロノア・ゾロ',
            'english_name' => 'Roronoa Zoro',
            'romaji_name' => 'Roronoa Zoro',
            'rarity' => 'Rare',
            'bounty' => '1,111,000,000',
            'hp' => 700,
            'attack' => 900,
            'defense' => 750,
            'speed' => 650,
            'status' => 'Alive',
            'origin' => 'East Blue',
        ]);

        $response = $this->actingAs($user)->get(route('characters.index', [
            'name' => 'Roger',
            'rarity' => 'Legendary',
            'stat' => 'hp',
            'stat_min' => 1400,
            'sort' => 'hp',
            'direction' => 'desc',
        ]));

        $response->assertSuccessful();
        $response->assertSee('Gol D. Roger');
        $response->assertDontSee('Monkey D. Luffy');
        $response->assertDontSee('Roronoa Zoro');
    }

    public function test_authenticated_users_can_order_characters_by_name(): void
    {
        $user = User::factory()->create();

        Character::create([
            'japanese_name' => 'カタログ・アルファ',
            'english_name' => 'Catalog Alpha',
            'romaji_name' => 'Katarogu Arufa',
            'rarity' => 'Rare',
            'bounty' => '300,000,000',
            'hp' => 700,
            'attack' => 900,
            'defense' => 750,
            'speed' => 650,
            'status' => 'Alive',
            'origin' => 'East Blue',
        ]);

        Character::create([
            'japanese_name' => 'カタログ・ベータ',
            'english_name' => 'Catalog Beta',
            'romaji_name' => 'Katarogu Beta',
            'rarity' => 'Epic',
            'bounty' => '500,000,000',
            'hp' => 900,
            'attack' => 1100,
            'defense' => 800,
            'speed' => 950,
            'status' => 'Deceased',
            'origin' => 'Grand Line',
        ]);

        $response = $this->actingAs($user)->get(route('characters.index', [
            'name' => 'Catalog',
            'sort' => 'name',
            'direction' => 'asc',
        ]));

        $response->assertSuccessful();
        $response->assertSeeInOrder(['Catalog Alpha', 'Catalog Beta']);
    }
}
