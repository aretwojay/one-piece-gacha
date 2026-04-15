<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\AsUri;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['japanese_name', 'english_name', 'romaji_name', 'image_url', 'debut_appearance', 'affiliations', 'origin', 'occupations', 'status', 'birthday', 'devil_fruit', 'bounty', 'age', 'height', 'blood_type', 'hp', 'attack', 'defense', 'speed', 'rarity'])]
class Character extends Model
{
    protected $casts = [
        'image_url' => AsUri::class,
        'debut_appearance' => 'json',
        'affiliations' => 'json',
        'occupations' => 'json',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'japanese_name' => '',
        'english_name' => '',
        'romaji_name' => '',
        'image_url' => null,
        'debut_appearance' => '[]',
        'affiliations' => '[]',
        'occupations' => '[]',
        'status' => '',
        'birthday' => null,
        'devil_fruit' => null,
        'bounty' => null,
        'age' => null,
        'height' => null,
        'blood_type' => null,
        'origin' => null,
    ];

    protected static function booted(): void
    {
        static::creating(function (Character $character) {
            $bounty = intval(str_replace(',', '', $character->bounty)) ?? 0;

            if (is_null($character->hp)) {
                $character->hp = $bounty > 1000000000 ? fake()->numberBetween(10000, 50000) : ($bounty > 100000000 ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->attack)) {
                $character->attack = $bounty > 1000000000 ? fake()->numberBetween(10000, 50000) : ($bounty > 100000000 ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->defense)) {
                $character->defense = $bounty > 1000000000 ? fake()->numberBetween(10000, 50000) : ($bounty > 100000000 ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->speed)) {
                $character->speed = $bounty > 1000000000 ? fake()->numberBetween(10000, 50000) : ($bounty > 100000000 ? fake()->numberBetween(5000, 10000) : fake()->numberBetween(1000, 5000));
            }
            if (is_null($character->rarity)) {
                $character->rarity = $bounty > 1000000000 ? 'Legendary' : ($bounty > 100000000 ? 'Epic' : 'Rare');
            }
        });
    }
    
}